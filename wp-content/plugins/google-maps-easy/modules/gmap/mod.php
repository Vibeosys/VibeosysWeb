<?php
class  gmapGmp extends moduleGmp {
	private $_stylizations = array();
	private $_markersLists = array();
	
	public function init() {
		dispatcherGmp::addFilter('mainAdminTabs', array($this, 'addAdminTab'));
        add_action('wp_footer', array($this, 'addMapDataToJs'), 5);
		add_shortcode(GMP_SHORTCODE, array($this, 'drawMapFromShortcode'));
	}
	public function addAdminTab($tabs) {
		$tabs[ $this->getCode(). '_add_new' ] = array(
			'label' => __('Add Map', GMP_LANG_CODE), 'callback' => array($this, 'getAddNewTabContent'), 'fa_icon' => 'fa-plus-circle', 'sort_order' => 10, 'add_bread' => $this->getCode(),
		);
		$tabs[ $this->getCode(). '_edit' ] = array(
			'label' => __('Edit', GMP_LANG_CODE), 'callback' => array($this, 'getEditTabContent'), 'sort_order' => 20, 'child_of' => $this->getCode(), 'hidden' => 1, 'add_bread' => $this->getCode(),
		);
		$tabs[ $this->getCode() ] = array(
			'label' => __('All Maps', GMP_LANG_CODE), 'callback' => array($this, 'getTabContent'), 'fa_icon' => 'fa-list', 'sort_order' => 20, //'is_main' => true,
		);
		return $tabs;
	}
	public function getAddNewTabContent() {
		return $this->getView()->getEditMap();
	}
	public function getEditTabContent() {
		$id = (int) reqGmp::getVar('id', 'get');
		if(!$id)
			return __('No Map Found', GMP_LANG_CODE);
		return $this->getView()->getEditMap( $id );
	}
	public function getTabContent() {
		return $this->getView()->getTabContent();
	}
    public function drawMapFromShortcode($params = null) {
		frameGmp::_()->addScript('commonGmp', GMP_JS_PATH. 'common.js', array('jquery'));
		frameGmp::_()->addScript('coreGmp', GMP_JS_PATH. 'core.js', array('jquery'));
        if(!isset($params['id'])) {
            return __('Empty or Invalid Map ID', GMP_LANG_CODE);
        }
        return $this->getController()->getView()->drawMap($params);
    }
    public function addMapDataToJs(){
        $this->getView()->addMapDataToJs();
    }
	public function generateShortcode($map) {
		$shortcodeParams = array();
		$shortcodeParams['id'] = $map['id'];
		// For PRO version
		$shortcodeParamsArr = array();
		foreach($shortcodeParams as $k => $v) {
			$shortcodeParamsArr[] = $k. "='". $v. "'";
		}
		return '['. GMP_SHORTCODE. ' '. implode(' ', $shortcodeParamsArr). ']';
	}
	public function getControlsPositions() {
		return array(
			'TOP_CENTER' => __('Top Center', GMP_LANG_CODE),
			'TOP_LEFT' => __('Top Left', GMP_LANG_CODE),
			'TOP_RIGHT' => __('Top Right', GMP_LANG_CODE),
			'LEFT_TOP' => __('Left Top', GMP_LANG_CODE),
			'RIGHT_TOP' => __('Right Top', GMP_LANG_CODE),
			'LEFT_CENTER' => __('Left Center', GMP_LANG_CODE),
			'RIGHT_CENTER' => __('Right Center', GMP_LANG_CODE),
			'LEFT_BOTTOM' => __('Left Bottom', GMP_LANG_CODE),
			'RIGHT_BOTTOM' => __('Right Bottom', GMP_LANG_CODE),
			'BOTTOM_CENTER' => __('Bottom Center', GMP_LANG_CODE),
			'BOTTOM_LEFT' => __('Bottom Left', GMP_LANG_CODE),
			'BOTTOM_RIGHT' => __('Bottom Right', GMP_LANG_CODE),
		);
	}
	public function getEditMapLink($id) {
		return frameGmp::_()->getModule('options')->getTabUrl('gmap_edit'). '&id='. $id;
	}
	public function getStylizationsList() {
		if(empty($this->_stylizations)) {
			$this->_stylizations = dispatcherGmp::applyFilters('stylizationsList', require_once($this->getModDir(). 'stylezations.php'));
			foreach($this->_stylizations as$k => $v) {
				$this->_stylizations[ $k ] = utilsGmp::jsonDecode( $this->_stylizations[ $k ] );
			}
		}
		return $this->_stylizations;
	}
	public function getStylizationByName($name) {
		$this->getStylizationsList();
		return isset($this->_stylizations[ $name ]) ? $this->_stylizations[ $name ] : false;
	}
	public function getMarkerLists() {
		if(empty($this->_markersLists)) {
			// or == orientation (horizontal, vertical), d == display (title, image, description), eng == slider engine (jssor)
			$this->_markersLists = array(
				'slider_simple' => array('label' => __('Slider', GMP_LANG_CODE), 'or' => 'h', 'd' => array('title', 'img', 'desc'), 'eng' => 'jssor'),
				'slider_simple_title_img' => array('label' => __('Slider - Title and Img', GMP_LANG_CODE), 'or' => 'h', 'd' => array('title', 'img'), 'eng' => 'jssor'),
				'slider_simple_vertical_title_img' => array('label' => __('Slider Vertical - Title and Img', GMP_LANG_CODE), 'or' => 'v', 'd' => array('title', 'img'), 'eng' => 'jssor'),
				'slider_simple_vertical_title_desc' => array('label' => __('Slider Vertical - Title and Description', GMP_LANG_CODE), 'or' => 'v', 'd' => array('title', 'desc'), 'eng' => 'jssor'),
				'slider_simple_vertical_img_2cols' => array('label' => __('Slider Vertical - Title and Img', GMP_LANG_CODE), 'or' => 'v', 'd' => array('img'), 'eng' => 'jssor', 'two_cols' => true),
				'slider_simple_table' => array('label' => __('Slider Table', GMP_LANG_CODE), 'or' => 'h', 'd' => array('title', 'img', 'desc'), 'eng' => 'table'),
			);
			foreach($this->_markersLists as $i => $v) {
				$this->_markersLists[$i]['prev_img'] = isset($this->_markersLists[$i]['prev_img']) ? $this->_markersLists[$i]['prev_img'] : $i. '.jpg';
				$this->_markersLists[$i]['slide_height'] = 150;
				$this->_markersLists[$i]['slide_width'] = in_array('img', $this->_markersLists[$i]['d']) && in_array('desc', $this->_markersLists[$i]['d'])
					? 400 : 200;
				if(isset($this->_markersLists[$i]['two_cols']) && $this->_markersLists[$i]['two_cols']) {
					$this->_markersLists[$i]['slide_height'] = round($this->_markersLists[$i]['slide_height'] / 2);
				}
			}
		}
		return $this->_markersLists;
	}
	public function getMarkerListByKey($key) {
		$this->getMarkerLists();
		return isset($this->_markersLists[ $key ]) ? $this->_markersLists[ $key ] : false;
	}
}
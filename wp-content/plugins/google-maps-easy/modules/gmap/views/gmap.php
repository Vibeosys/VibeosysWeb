<?php
class gmapViewGmp extends viewGmp {
	//private $_gmapApiUrl = "https://maps.googleapis.com/maps/api/js?&sensor=false&=";
	private $_gmapApiUrl = '';
	private static $_mapsData;
	private $_displayColumns = array();
	// Used to compare rand IDs and original IDs on preview
	
	public function getApiUrl() {
		if(empty($this->_gmapApiUrl)) {
			$urlParams = dispatcherGmp::applyFilters('gApiUrlParams', array('sensor' => 'false'));
			$this->_gmapApiUrl = 'https://maps.googleapis.com/maps/api/js?'. http_build_query($urlParams);
		}
		return $this->_gmapApiUrl;
	}
	public function addMapData($params){
		if(empty(self::$_mapsData)) {
			self::$_mapsData = array();
		}
		if(!empty($params))
			self::$_mapsData[] = $params;
	}
	public function drawMap($params){
		$mapObj = frameGmp::_()->getModule('gmap')->getModel()->getMapById($params['id']);
		if(empty($mapObj))
			return;
		if(isset($params['map_center']) 
			&& is_string($params['map_center'])
		) {
			if(strpos($params['map_center'], ';')) {
				$centerXY = array_map('trim', explode(';', $params['map_center']));
				$params['map_center'] = array(
					'coord_x' => $centerXY[0],
					'coord_y' => $centerXY[1],
				);
			} elseif(is_numeric($params['map_center'])) {	// Map center - is coords of one of it's marker
				$params['map_center'] = (int) trim($params['map_center']);
				$found = false;
				if(!empty($mapObj['markers'])) {
					foreach($mapObj['markers'] as $marker) {
						if($marker['id'] == $params['map_center']) {
							$params['map_center'] = array(
								'coord_x' => $marker['coord_x'],
								'coord_y' => $marker['coord_y'],
							);
							$found = true;
							break;
						}
					}
				}
				// If no marker with such ID were found - just unset it to prevent map broke
				if(!$found) {
					unset($params['map_center']);
				}
			} else {
				// If it is set, but not valid - just unset it to not break user map
				unset($params['map_center']);
			}
		}
		$shortCodeHtmlParams = array('width', 'height', 'align');
		$paramsCanNotBeEmpty = array('width', 'height');
		foreach($shortCodeHtmlParams as $code) {
			if(isset($params[$code])){
				if(in_array($code, $paramsCanNotBeEmpty) && empty($params[$code])) continue;
				$mapObj['html_options'][$code] = $params[$code];
			}
		}
		$shortCodeMapParams = $this->getModel()->getParamsList();
		foreach($shortCodeMapParams as $code){
			if(isset($params[$code])) {
				if(in_array($code, $paramsCanNotBeEmpty) && empty($params[$code])) continue;
				$mapObj['params'][$code] = $params[$code];
			}
		}
		if(isset($params['display_as_img']) && $params['display_as_img']) {
			$mapObj['params']['map_display_mode'] = 'popup';
			$mapObj['params']['img_width'] = isset($params['img_width']) ? $params['img_width'] : 175;
			$mapObj['params']['img_height'] = isset($params['img_height']) ? $params['img_height'] : 175;
		}
		if(isset($params['display_as_img']) && $params['display_as_img']) {
			$mapObj['params']['map_display_mode'] = 'popup';
		}
		if($mapObj['params']['map_display_mode'] == 'popup') {
			frameGmp::_()->addScript('bpopup', GMP_JS_PATH. '/bpopup.js');
		}
		if(empty($mapObj['params']['map_display_mode'])){
			$mapObj['params']['map_display_mode'] = 'map';
		}
		$indoWindowSize = frameGmp::_()->getModule('options')->getModel('options')->get('infowindow_size');
		$this->assign('indoWindowSize', $indoWindowSize);
		
		$markersDisplayType = '';
		if(isset($params['markers_list_type'])) {
			$markersDisplayType = $params['markers_list_type'];
		} else if(isset($mapObj['params']['markers_list_type']) && !empty($mapObj['params']['markers_list_type'])) {
			$markersDisplayType = $mapObj['params']['markers_list_type'];
		}
		$mapObj['params']['markers_list_type'] = $markersDisplayType;
		$mapObj = dispatcherGmp::applyFilters('mapDataRender', $mapObj);
		$this->addMapData(dispatcherGmp::applyFilters('mapDataToJs', $mapObj));

		$this->assign('markersDisplayType', $markersDisplayType);
		$this->connectMapsAssets( $mapObj['params'] );
		frameGmp::_()->addScript('frontend.gmap', $this->getModule()->getModPath(). 'js/frontend.gmap.js', array('jquery'), false, true);
		$this->assign('currentMap', $mapObj);
		return parent::getInlineContent('gmapDrawMap');
	}
	public function addMapDataToJs(){
		frameGmp::_()->addJSVar('frontend.gmap', 'gmpAllMapsInfo', self::$_mapsData);
	}
	public function getDisplayColumns() {
		if(empty($this->_displayColumns)) {
			$this->_displayColumns = array(
				'id'				=> array('label' => __('ID'), 'db' => 'id'),
				'title'				=> array('label' => __('Title'), 'db' => 'title'),
				'list_html_options'	=> array('label' => __('Html options'), 'db' => 'html_options'),
				'list_markers'		=> array('label' => __('Markers'), 'db' => 'markers'),
				'operations'		=> array('label' => __('Operations'), 'db' => 'operations'),
			);
		}
		return $this->_displayColumns;
	}
	public function getListMarkers($map) {
		$this->assign('map', $map);
		return parent::getContent('gmapListMarkers');
	}
	public function getListOperations($map) {
		$this->assign('map', $map);
		$this->assign('editLink', $this->getModule()->getEditMapLink( $map['id'] ));
		return parent::getContent('gmapListOperations');
	}
	public function getTabContent() {
		frameGmp::_()->getModule('templates')->loadJqGrid();
		frameGmp::_()->addScript('admin.gmap', $this->getModule()->getModPath(). 'js/admin.gmap.js');
		frameGmp::_()->addScript('admin.gmap.list', $this->getModule()->getModPath(). 'js/admin.gmap.list.js');
		frameGmp::_()->addJSVar('admin.gmap.list', 'gmpTblDataUrl', uriGmp::mod('gmap', 'getListForTbl', array('reqType' => 'ajax')));
		frameGmp::_()->addStyle('admin.gmap', $this->getModule()->getModPath(). 'css/admin.gmap.css');
		
		$this->assign('addNewLink', frameGmp::_()->getModule('options')->getTabUrl('gmap_add_new'));
		return parent::getContent('gmapAdmin');
	}
	public function getEditMap($id = 0) {
		$gMapApiParams = array('language' => '');
		frameGmp::_()->addScript('jquery-ui-sortable');
		frameGmp::_()->addScript('wp.tabs', GMP_JS_PATH. 'wp.tabs.js');
		frameGmp::_()->addScript('admin.gmap', $this->getModule()->getModPath(). 'js/admin.gmap.js');
		frameGmp::_()->addScript('admin.gmap.edit', $this->getModule()->getModPath(). 'js/admin.gmap.edit.js');
		frameGmp::_()->addStyle('admin.gmap', $this->getModule()->getModPath(). 'css/admin.gmap.css');
		frameGmp::_()->addJSVar('admin.gmap.edit', 'gmpMapShortcode', GMP_SHORTCODE);
		$allStylizationsList = $this->getModule()->getStylizationsList();
		$allMarkerGroupsList = frameGmp::_()->getModule('marker_groups')->getModel()->getAllMarkerGroups();
		frameGmp::_()->addJSVar('admin.gmap.edit', 'gmpAllStylizationsList', $allStylizationsList);
		frameGmp::_()->addJSVar('admin.gmap.edit', 'gmpMapsListUrl', frameGmp::_()->getModule('options')->getTabUrl('gmap'));
		$stylizationsForSelect = array(
			'none' => __('None', GMP_LANG_CODE),
		);
		foreach($allStylizationsList as $styleName => $json) {
			$stylizationsForSelect[ $styleName ] = $styleName;	// JSON data will be attached on js side
		}
		$markerGroupsForSelect = array(
			'0' => __('None', GMP_LANG_CODE),
		);
		foreach($allMarkerGroupsList as $key => $value) {
			$markerGroupsForSelect[ $value['id'] ] = $value['title'];
		}
		$editMap = $id ? true : false;
		if($editMap) {
			$map = $this->getModel()->getMapById( $id );
			$this->assign('map', $map);
			$gMapApiParams = $map['params'];
			frameGmp::_()->addJSVar('admin.gmap.edit', 'gmpMainMap', $map);
		}
		$markerLists = $this->getModule()->getMarkerLists();
		$positionsList = $this->getModule()->getControlsPositions();
		$this->connectMapsAssets($gMapApiParams, true);
		$this->assign('editMap', $editMap);
		$this->assign('icons', frameGmp::_()->getModule('icons')->getModel()->getIcons(array('fields' => 'id, path, title')));
		$this->assign('stylizationsForSelect', $stylizationsForSelect);
		$this->assign('positionsList', $positionsList);
		$this->assign('isPro', frameGmp::_()->getModule('supsystic_promo')->isPro());
		$this->assign('mainLink', frameGmp::_()->getModule('supsystic_promo')->getMainLink());
		$this->assign('markerLists', $markerLists);
		$this->assign('markerGroupsForSelect', $markerGroupsForSelect);
		$this->assign('viewId', $editMap ? $map['view_id'] : 'preview_id_'. mt_rand(1, 9999));
		$this->assign('promoModPath', frameGmp::_()->getModule('supsystic_promo')->getModPath());
		return parent::getContent('gmapEditMap');
	}
	public function connectMapsAssets($params, $forAdminArea = false) {
		$params['language'] = isset($params['language']) && !empty($params['language']) ? $params['language'] : utilsGmp::getLangCode2Letter();
		frameGmp::_()->addScript('google_maps_api', $this->getApiUrl(). '&language='. $params['language']);
		frameGmp::_()->addScript('core.gmap', $this->getModule()->getModPath(). 'js/core.gmap.js');
		frameGmp::_()->addStyle('core.gmap', $this->getModule()->getModPath(). 'css/core.gmap.css');
		if((isset($params['marker_clasterer']) && $params['marker_clasterer'] != 'none') || $forAdminArea) {
			frameGmp::_()->addScript('core.markerclusterer', $this->getModule()->getModPath(). 'js/core.markerclusterer.min.js');
		}
		dispatcherGmp::doAction('afterConnectMapAssets', $params, $forAdminArea);
	}
}

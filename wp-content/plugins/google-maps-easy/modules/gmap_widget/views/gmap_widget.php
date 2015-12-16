<?php
class gmap_widgetViewGmp extends viewGmp {
    public function displayWidget($instance) {
		if(isset($instance['id']) && $instance['id']) {
			// List will be displayed in widget are not correct - just remove it for now
			$instance['display_type'] = 0;
			
			echo frameGmp::_()->getModule('gmap')->drawMapFromShortcode($instance);
		}
    }
    public function displayForm($data, $widget) {
		$maps = frameGmp::_()->getModule('gmap')->getModel()->getAllMaps();
		$mapsOpts = array();
		if(empty($maps)) {
			$mapsOpts[0] = __('You have no maps', GMP_LANG_CODE);
		} else {
			foreach($maps as $map) {
				$mapsOpts[ $map['id'] ] = $map['title'];
			}
		}
		$this->assign('mapsOpts', $mapsOpts);
        $this->displayWidgetForm($data, $widget);
    }
}
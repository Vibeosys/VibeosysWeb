<?php
class  iconsGmp extends moduleGmp {
    public function init(){
        parent::init();
		$this->getModel()->checkDefIcons();
		/*if(frameGmp::_()->isAdminPlugPage()){
			$gmpExistsIcons = $this->getModel()->getIcons();
			frameGmp::_()->addJSVar('iconOpts', 'gmpExistsIcons', $gmpExistsIcons);
			frameGmp::_()->addScript('iconOpts', $this->getModPath() .'js/iconOpts.js');			
		}*/
    }
}
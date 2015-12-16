<?php
	if(empty($this->currentMap)){
		_e('Map not found', GMP_LANG_CODE);
		return;
	}
    $width = trim($this->currentMap['html_options']['width']);
	if($width{strlen($width)-1} != '%' && $width{strlen($width)-1} != 'x' ){
		$width = (int)$width . (isset($this->currentMap['params']['width_units']) ? $this->currentMap['params']['width_units'] : 'px');
	}
    $height = $this->currentMap['html_options']['height'];
    $classname = @$this->currentMap['html_options']['classname'];
    $align = @$this->currentMap['html_options']['align'];
	$viewId = $this->currentMap['view_id'];
    $mapHtmlId = $this->currentMap['view_html_id'];
    
	$border = ((int)@$this->currentMap['html_options']['border_width']). 'px solid '. @$this->currentMap['html_options']['border_color'];
	$margin = @$this->currentMap['html_options']['margin'];
    $ln = $this->currentMap['params']['language'];
	$percentModeOn = false;
	$styleInPercent = '';
	
	if($this->currentMap['params']['map_display_mode'] == 'popup'){
        $class_name = 'display_as_popup';
		$popup = true;
		$mapWidth = '100%';
    } else {
        $class_name = '';
		$popup = false;
		$mapWidth = $width;
    }
	if($width{strlen($width)-1} == '%') {
		$percentMode = true;
		$controlsWidth = '100%';
	} else {
		$percentMode = false;
		$controlsWidth = $width;
	}
?>
    <style type="text/css">
        #<?php echo $mapHtmlId;?>{
            width:<?php echo $mapWidth;?>;
            height:<?php echo $height;?>px;
            float:<?php echo $align;  ?>;
            border:<?php echo $border;?>;
            margin:<?php echo ((int)$margin). 'px';?>;
        }
        #gmapControlsNum_<?php echo $viewId;?>{
           width:<?php echo $controlsWidth;?>
        }
		<?php
			if(isset($this->currentMap['params']['infowindow_width'])
				&& $this->currentMap['params']['infowindow_width'] != ""
			){
				$infoWindowWidth = $this->currentMap['params']['infowindow_width'];
			}else{
    			$infoWindowWidth = $this->indoWindowSize['width'];
			}
			if(isset( $this->currentMap['params']['infowindow_height'])
				&& $this->currentMap['params']['infowindow_height'] != ""
			){
    			$infoWindowHeight = $this->currentMap['params']['infowindow_height'];
			}else{
  				$infoWindowHeight = $this->indoWindowSize['height'];
			}
			if(!strpos($infoWindowWidth, 'px') && !strpos($infoWindowWidth, '%')) {
				$infoWindowWidth .= 'px';
			}
			if(!strpos($infoWindowHeight, 'px') && !strpos($infoWindowHeight, '%')) {
				$infoWindowHeight .= 'px';
			}
		?>
		 #<?php echo $mapHtmlId;?> .gmpMarkerInfoWindow{
			<!--width:<?php echo $infoWindowWidth;?>;
			height:<?php echo $infoWindowHeight;?>;-->
		}
		.gmpMapDetailsContainer#gmpMapDetailsContainer_<?php echo $viewId;?>{
			height:<?php echo (int)$height;?>px;
		}
		.gmp_MapPreview#<?php echo $mapHtmlId;?>{
			/*position:absolute;*/
			width:100%;
		}
		#mapConElem_<?php echo $viewId;?>{
			width:<?php echo $width;?>
		}
		<?php if(isset($this->currentMap['params']['infownd_title_color'])) { ?>
		#<?php echo $mapHtmlId;?> .gmpInfoWindowtitle {
			color: <?php echo $this->currentMap['params']['infownd_title_color']?> !important;
			font-size: <?php echo $this->currentMap['params']['infownd_title_size']?>px !important;
		}
		<?php }?>
	</style>
	<?php if($this->currentMap['params']['map_display_mode'] == 'popup'){ ?>
		<div class="map-preview-iumg-container">
			<img src="<?php echo GMP_IMG_PATH. 'gmap_preview.png' ?>" data_val="<?php echo $this->currentMap['id']; ?>" class="show_map_icon map_num_<?php echo $this->currentMap['id']; ?>" title = "Click to view map">
		</div>
	<?php } ?>
<div class="gmp_map_opts <?php echo $class_name;?>" 
	 id="mapConElem_<?php echo $viewId;?>" 
	 data-view-id="<?php echo $viewId;?>" 
	 data-id="<?php echo $this->currentMap['id']; ?>"
>
	<div class="gmpMapDetailsContainer" id="gmpMapDetailsContainer_<?php echo $viewId ;?>">
		<?php if($this->currentMap['params']['map_display_mode'] == 'popup') { ?>
			<a class="btn btn-info close_button" onclick="closePopup();">X</a>
		<?php } ?>
		<div class="gmp_MapPreview <?php echo $classname;?>" id="<?php echo $mapHtmlId ;?>"></div>
	</div>
	<div class="gmpMapProControlsCon" id="gmpMapProControlsCon_<?php echo $viewId;?>">
		<?php dispatcherGmp::doAction('addMapBottomControls', $this->currentMap); ?>
	</div>
</div>
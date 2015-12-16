<?php
	$addProElementAttrs = $this->isPro ? '' : ' title="'. esc_html(__('This option is available in <a target="_blank" href="%s">PRO version</a> only, you can get it <a target="_blank" href="%s">here.</a>', GMP_LANG_CODE)). '"';
	$addProElementClass = $this->isPro ? '' : 'supsystic-tooltip gmpProOpt';
	//$addProElementBottomHtml = $this->isPro ? '' : '<span class="gmpProOptMiniLabel"><a target="_blank" href="'. $this->mainLink. '">'. __('PRO option', GMP_LANG_CODE). '</a></span>';
	//$addProElementOptBottomHtml = $this->isPro ? '' : '<br /><span class="gmpProOptMiniLabel" style="padding-left: 0;"><a target="_blank" href="'. $this->mainLink. '">'. __('PRO option', GMP_LANG_CODE). '</a></span>';
?>
<section>
	<div class="supsystic-item supsystic-panel">
		<div id="containerWrapper">
			<div id="gmpMapMarkerTabs" class="supsistic-half-side-box">
				<h3 class="nav-tab-wrapper" style="margin-bottom: 0px; margin-top: 12px;">
					<a class="nav-tab nav-tab-active" href="#gmpMapTab">
						<p><?php _e('Map Properties', GMP_LANG_CODE)?></p>
					</a>
					<a class="nav-tab" href="#gmpMarkerTab">
						<p>
							<?php _e('Markers', GMP_LANG_CODE)?>
							<button class="button" id="gmpAddNewMarkerBtn">
								<i class="fa fa-map-marker"></i>
								<?php _e('Add New Marker', GMP_LANG_CODE)?>
							</button>
						</p>
					</a>
				</h3>
				<div id="gmpMapTab" class="gmpTabContent">
					<form id="gmpMapForm">
						<table class="form-table">
							<tr>
								<th scope="row">
									<label class="label-big" for="map_opts_title">
										<?php _e('Map Name', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Your map name', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<?php echo htmlGmp::text('map_opts[title]', array(
										'value' => $this->editMap ? $this->map['title'] : '',
										'attrs' => 'style="width: 100%;" id="map_opts_title"',
										'required' => true))?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="map_opts_width">
										<?php _e('Map Width', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Your map width', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<div class="sup-col sup-w-25">
										<?php echo htmlGmp::text('map_opts[width]', array(
											'value' => $this->editMap ? $this->map['html_options']['width'] : '100',
											'attrs' => 'style="width: 100%;" id="map_opts_width"'))?>
									</div>
									<div class="sup-col sup-w-75">
										<label class="supsystic-tooltip" title="<?php _e('Pixels', GMP_LANG_CODE)?>" style="margin-right: 15px; position: relative; top: 7px;"><?php echo htmlGmp::radiobutton('map_opts[width_units]', array(
											'value' => 'px',
											'checked' => $this->editMap ? htmlGmp::checkedOpt($this->map['params'], 'width_units', 'px') : false,
										))?>&nbsp;<?php _e('Px', GMP_LANG_CODE)?></label>
										<label style="margin-right: 15px; position: relative; top: 7px;"><?php echo htmlGmp::radiobutton('map_opts[width_units]', array(
											'value' => '%',
											'checked' => $this->editMap ? htmlGmp::checkedOpt($this->map['params'], 'width_units', '%') : true,
										))?>&nbsp;<?php _e('Percents', GMP_LANG_CODE)?></label>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="map_opts_height">
										<?php _e('Map Height', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Your map height', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<div class="sup-col sup-w-25">
										<?php echo htmlGmp::text('map_opts[height]', array(
											'value' => $this->editMap ? $this->map['html_options']['height'] : '250',
											'attrs' => 'style="width: 100%;" id="map_opts_height"'))?>
									</div>
									<div class="sup-col sup-w-75">
										<label class="supsystic-tooltip" title="<?php _e('Pixels', GMP_LANG_CODE)?>" style="margin-right: 15px; position: relative; top: 7px;"><?php echo htmlGmp::radiobutton('map_opts_height_units_is_constant', array(
											'value' => 'px',
											'checked' => true,
										))?>&nbsp;<?php _e('Px', GMP_LANG_CODE)?></label>
									</div>
								</td>
							</tr>
						</table>
						<?php /*?><div id="gmpExtendOptsBtnShell" class="row-pad">
							<a href="#" id="gmpExtendOptsBtn" class="button"><?php _e('Extended Options', GMP_LANG_CODE)?></a>
						</div><?php */?>
						<div id="gmpExtendOptsShell" class="row">
							<table class="form-table">
								<tr>
									<th scope="row">
										<label for="map_opts_type_control">
											<?php _e('Map type control', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Control view for map type - you can see it in right upper corner by default', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<div class="sup-col sup-w-50">
											<?php echo htmlGmp::selectbox('map_opts[type_control]', array(
												'options' => array('none' => __('None', GMP_LANG_CODE), 'DROPDOWN_MENU' => __('Dropdown Menu', GMP_LANG_CODE), 'HORIZONTAL_BAR' => __('Horizontal Bar', GMP_LANG_CODE)),
												'value' => $this->editMap && isset($this->map['params']['type_control']) ? $this->map['params']['type_control'] : 'HORIZONTAL_BAR',
												'attrs' => 'style="width: 100%;" id="map_opts_type_control"'))?>
										</div>
										<div class="sup-col sup-w-50">
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=type_control_position&utm_campaign=googlemaps'); ?>
											<i class="fa fa-arrows supsystic-tooltip" title="<?php _e('Change type control position on map', GMP_LANG_CODE)?>"></i>
											<?php echo htmlGmp::selectbox('map_opts[type_control_position]', array(
												'options' => $this->positionsList,
												'value' => $this->editMap && isset($this->map['params']['type_control_position']) ? $this->map['params']['type_control_position'] : 'TOP_RIGHT',
												'attrs' => 'data-for="mapTypeControlOptions" class="gmpMapPosChangeSelect '. $addProElementClass. '"'. (empty($addProElementAttrs) ? '' : sprintf($addProElementAttrs, $proLink, $proLink))
											))?>
											<?php if(!$this->isPro) { ?>
												<span class="gmpProOptMiniLabel" style="padding-left: 20px;"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
											<?php }?>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_zoom_control">
											<?php _e('Zoom control', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Zoom control type on your map. Note, to view Zoom control on the map the Custom Map Controls option must be disabled.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<div class="sup-col sup-w-50">
											<?php echo htmlGmp::selectbox('map_opts[zoom_control]', array(
												'options' => array('none' => __('None', GMP_LANG_CODE), 'DEFAULT' => __('Default', GMP_LANG_CODE)/*, 'LARGE' => __('Large', GMP_LANG_CODE), 'SMALL' => __('Small', GMP_LANG_CODE)*/),
												'value' => $this->editMap && isset($this->map['params']['zoom_control']) ? $this->map['params']['zoom_control'] : 'DEFAULT',
												'attrs' => 'style="width: 100%;" id="map_opts_zoom_control"'))?>
										</div>
										<div class="sup-col sup-w-50">
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=zoom_control_position&utm_campaign=googlemaps'); ?>
											<i class="fa fa-arrows supsystic-tooltip" title="<?php _e('Change zoom control position on map', GMP_LANG_CODE)?>"></i>
											<?php echo htmlGmp::selectbox('map_opts[zoom_control_position]', array(
												'options' => $this->positionsList,
												'value' => $this->editMap && isset($this->map['params']['zoom_control_position']) ? $this->map['params']['zoom_control_position'] : 'TOP_LEFT',
												'attrs' => 'data-for="zoomControlOptions" class="gmpMapPosChangeSelect '. $addProElementClass. '"'. (empty($addProElementAttrs) ? '' : sprintf($addProElementAttrs, $proLink, $proLink))
											))?>
											<?php if(!$this->isPro) { ?>
												<span class="gmpProOptMiniLabel" style="padding-left: 20px;"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
											<?php }?>
										</div>
										<div id="gmpDefaultZoomDisable" style="display: none;" title="<?php _e('Notice', GMP_LANG_CODE)?>">
											<p>
												<?php printf(__('Standard Zoom control will not displaying for this map, because the Custom Map Controls option enabled now.', GMP_LANG_CODE))?>
											</p>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_optsstreet_view_control_check">
											<?php _e('Street view control', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Street view control usually is located on left upper corner of your map', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<div class="sup-col sup-w-50">
											<?php echo htmlGmp::checkboxHiddenVal('map_opts[street_view_control]', array(
												'value' => $this->editMap && isset($this->map['params']['street_view_control']) ? $this->map['params']['street_view_control'] : true,
											))?>
										</div>
										<div class="sup-col sup-w-50">
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=street_view_control_position&utm_campaign=googlemaps'); ?>
											<i class="fa fa-arrows supsystic-tooltip" title="<?php _e('Change street view control position on map', GMP_LANG_CODE)?>"></i>
											<?php echo htmlGmp::selectbox('map_opts[street_view_control_position]', array(
												'options' => $this->positionsList,
												'value' => $this->editMap && isset($this->map['params']['street_view_control_position']) ? $this->map['params']['street_view_control_position'] : 'TOP_LEFT',
												'attrs' => 'data-for="streetViewControlOptions" class="gmpMapPosChangeSelect '. $addProElementClass. '"'. (empty($addProElementAttrs) ? '' : sprintf($addProElementAttrs, $proLink, $proLink))
											))?>
											<?php if(!$this->isPro) { ?>
												<span class="gmpProOptMiniLabel" style="padding-left: 20px;"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
											<?php }?>
										</div>
									</td>
								</tr>
								<?php /* ?>
 								<tr>
									<th scope="row">
										<label for="map_optspan_control_check">
											<?php _e('Pan control', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Pan control - allow you to pan over your map using mouse, usually is located on left upper corner of your map', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<div class="sup-col sup-w-50">
											<?php echo htmlGmp::checkboxHiddenVal('map_opts[pan_control]', array(
												'value' => $this->editMap && isset($this->map['params']['pan_control']) ? $this->map['params']['pan_control'] : false,
											))?>
										</div>
										<div class="sup-col sup-w-50">
											<?php $proLink =frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=pan_control_position&utm_campaign=googlemaps'); ?>
											<i class="fa fa-arrows supsystic-tooltip" title="<?php _e('Change pan control position on map', GMP_LANG_CODE)?>"></i>
											<?php echo htmlGmp::selectbox('map_opts[pan_control_position]', array(
												'options' => $this->positionsList,
												'value' => $this->editMap && isset($this->map['params']['pan_control_position']) ? $this->map['params']['pan_control_position'] : 'TOP_LEFT',
												'attrs' => 'data-for="panControlOptions" class="gmpMapPosChangeSelect '. $addProElementClass. '"'. (empty($addProElementAttrs) ? '' : sprintf($addProElementAttrs, $proLink, $proLink))
											))?>
											<?php if(!$this->isPro) { ?>
												<span class="gmpProOptMiniLabel" style="padding-left: 20px;"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
											<?php }?>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_overview_control">
											<?php _e('Overview control', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Overview control for your map, by default is disabled, and if enabled - is located on the right bottom corner', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<div class="sup-col" style="width: 100%;">
											<?php echo htmlGmp::selectbox('map_opts[overview_control]', array(
												'options' => array('none' => __('None', GMP_LANG_CODE), 'opened' => __('Opened', GMP_LANG_CODE), 'collapsed' => __('Collapsed', GMP_LANG_CODE)),
												'value' => $this->editMap && isset($this->map['params']['overview_control']) ? $this->map['params']['overview_control'] : 'none',
												'attrs' => 'style="width: 100%;" id="map_opts_overview_control"'))?>
										</div>
									</td>
								</tr>
								<?php */ ?>
								<tr>
									<th scope="row">
										<label for="map_optsdraggable_check">
											<?php _e('Draggable', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Enable or disable possibility to drag your map using mouse', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[draggable]', array(
											'value' => $this->editMap && isset($this->map['params']['draggable']) ? $this->map['params']['draggable'] : true,
										))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_optsdbl_click_zoom_check">
											<?php _e('Double click to zoom', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('By default double left click on map will zoom it in. But you can change this here.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[dbl_click_zoom]', array(
											'value' => $this->editMap && isset($this->map['params']['dbl_click_zoom']) ? $this->map['params']['dbl_click_zoom'] : true,
										))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_optsmouse_wheel_zoom_check">
											<?php _e('Mouse wheel to zoom', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Sometimes you need to disable possibility to zoom your map using mouse wheel. This can be required for example - if you need to use your wheel for some other action, for example scroll your site even if mouse is over your map.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[mouse_wheel_zoom]', array(
											'value' => $this->editMap && isset($this->map['params']['mouse_wheel_zoom']) ? $this->map['params']['mouse_wheel_zoom'] : true,
										))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_map_type">
											<?php _e('Google Map Theme', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('You can select your Google Map theme - Road Map, Hybrid, Satellite or Terrain - here. By default your map will have Road Map Google maps theme.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php echo htmlGmp::selectbox('map_opts[map_type]', array(
											'options' => array('ROADMAP' => __('Road Map', GMP_LANG_CODE), 'HYBRID' => __('Hybrid', GMP_LANG_CODE), 'SATELLITE' => __('Satellite', GMP_LANG_CODE), 'TERRAIN' => __('Terrain', GMP_LANG_CODE)),
											'value' => $this->editMap && isset($this->map['params']['map_type']) ? $this->map['params']['map_type'] : 'ROADMAP',
											'attrs' => 'style="width: 100%;" id="map_opts_map_type"'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_map_stylization">
											<?php _e('Map Stylization', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Make your map unique with our Map Themes, just try to change it here - and you will see results on your Map Preview.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php echo htmlGmp::selectbox('map_opts[map_stylization]', array(
											'options' => $this->stylizationsForSelect,
											'value' => $this->editMap && isset($this->map['params']['map_stylization']) ? $this->map['params']['map_stylization'] : 'none',
											'attrs' => 'style="width: '. ($this->isPro ? '100%' : 'calc(100% - 200px)'). ';" id="map_opts_map_stylization"'))?>
										<?php if(!$this->isPro) {?>
											<a target="_blank" href="<?php echo $this->mainLink;?>" class="sup-standard-link">
												<i class="fa fa-plus"></i>
												<?php _e('Get 300+ Themes with PRO', GMP_LANG_CODE)?>
											</a>
										<?php }?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_enable_trafic_layer">
											<?php _e('Traffic Layer', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Add real-time traffic information to your map.', GMP_LANG_CODE)?>"></i>
										<?php if(!$this->isPro) { ?>
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=trafic_layer&utm_campaign=googlemaps'); ?>
											<br /><span class="gmpProOptMiniLabel"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
										<?php }?>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[enable_trafic_layer]', array(
											'value' => $this->editMap && isset($this->map['params']['enable_trafic_layer']) ? $this->map['params']['enable_trafic_layer'] : false,
											'attrs' => 'class="gmpProOpt"'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_enable_transit_layer">
											<?php _e('Transit Layer', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Display the public transit network of a city on your map. When the Transit Layer is enabled, and the map is centered on a city that supports transit information, the map will display major transit lines as thick, colored lines.', GMP_LANG_CODE)?>"></i>
										<?php if(!$this->isPro) { ?>
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=transit_layer&utm_campaign=googlemaps'); ?>
											<br /><span class="gmpProOptMiniLabel"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
										<?php }?>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[enable_transit_layer]', array(
											'value' => $this->editMap && isset($this->map['params']['enable_transit_layer']) ? $this->map['params']['enable_transit_layer'] : false,
											'attrs' => 'class="gmpProOpt"'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_enable_bicycling_layer">
											<?php _e('Bicycling Layer', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Add a layer of bike paths, suggested bike routes and other overlays specific to bicycling usage on top of the given map.Dark green routes indicated dedicated bicycle routes. Light green routes indicate streets with dedicated "bike lanes." Dashed routes indicate streets or paths otherwise recommended for bicycle usage.', GMP_LANG_CODE)?>"></i>
										<?php if(!$this->isPro) { ?>
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=bicycling_layer&utm_campaign=googlemaps'); ?>
											<br /><span class="gmpProOptMiniLabel"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
										<?php }?>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[enable_bicycling_layer]', array(
											'value' => $this->editMap && isset($this->map['params']['enable_bicycling_layer']) ? $this->map['params']['enable_bicycling_layer'] : false,
											'attrs' => 'class="gmpProOpt"'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_marker_title_color">
											<?php _e('Marker Title color', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('You can set your markers title color here', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php echo htmlGmp::colorpicker('map_opts[marker_title_color]', array(
											'value' => $this->editMap && isset($this->map['params']['marker_title_color']) ? $this->map['params']['marker_title_color'] : '#A52A2A'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_markers_list_type">
											<?php _e('Markers List', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Display all map markers - as list bellow Your map. This will help your users get more info about your markers and find required marker more faster.', GMP_LANG_CODE)?>"></i>
										<?php if(!$this->isPro) { ?>
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=markers_list&utm_campaign=googlemaps'); ?>
											<br /><span class="gmpProOptMiniLabel"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
										<?php }?>
									</th>
									<td>
										<a id="gmpMapMarkersListBtn" href="#" class="button"><?php _e('Select Markers List type', GMP_LANG_CODE)?></a>
										<?php echo htmlGmp::hidden('map_opts[markers_list_type]', array(
											'value' => $this->editMap && isset($this->map['params']['markers_list_type']) ? $this->map['params']['markers_list_type'] : ''))?>
										<div id="gmpMapMarkersListSettings" style="display: none;">
											<div style="margin-top: 10px;">
												<label for="map_opts_markers_list_color">
													<?php _e('Markers List Color', GMP_LANG_CODE)?>
												</label></br>
												<?php echo htmlGmp::colorpicker('map_opts[markers_list_color]', array(
													'value' => $this->editMap && isset($this->map['params']['markers_list_color']) ? $this->map['params']['markers_list_color'] : '#55BA68'))?>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_marker_clasterer" class="sup-medium-label">
											<?php _e('Markers Clasterization', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('If you have many markers - you can have a problems with viewing them when zoom out for example: they will just cover each-other. Marker clasterization can solve this problem by grouping your markers in groups when they are too close to each-other.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php echo htmlGmp::selectbox('map_opts[marker_clasterer]', array(
											'options' => array('none' => __('None', GMP_LANG_CODE), 'MarkerClusterer' => __('Base Clasterization', GMP_LANG_CODE)),
											'value' => $this->editMap && isset($this->map['params']['marker_clasterer']) ? $this->map['params']['marker_clasterer'] : 'none',
											'attrs' => 'style="width: 100%;" id="map_opts_marker_clasterer"'))?>
										<div id="gmpMarkerClastererIcon" style="display: none; margin-top: 5px;">
											<label for="map_opts_marker_clasterer_icon">
												<?php _e('Claster Icon', GMP_LANG_CODE)?>
											</label>
											<div style="float: right;">
												<a id="gmpUploadClastererIconBtn" href="#" class="button" style="float: right; margin-bottom: 5px;"><?php _e('Upload Icon', GMP_LANG_CODE)?></a><br />
												<a id="gmpDefaultClastererIconBtn" href="#" class="button" style="float: right; margin-bottom: 5px;"><?php _e('Default', GMP_LANG_CODE)?></a>
												<div class="gmpClastererUplRes"></div>
											</div>
											<div style="margin-top: 10px;">
												<?php $curClusterIcon =
													$this->editMap
													&& isset($this->map['params']['marker_clasterer_icon'])
													&& $this->map['params']['marker_clasterer_icon']
														? $this->map['params']['marker_clasterer_icon']
														: 'https://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m1.png';
												$curClusterIconWidth =
													$this->editMap
													&& isset($this->map['params']['marker_clasterer_icon_width'])
													&& $this->map['params']['marker_clasterer_icon_width']
														? $this->map['params']['marker_clasterer_icon_width']
														: 53;
												$curClusterIconHeight =
													$this->editMap
													&& isset($this->map['params']['marker_clasterer_icon_width'])
													&& $this->map['params']['marker_clasterer_icon_width']
														? $this->map['params']['marker_clasterer_icon_width']
														: 52;
												?>
												<?php echo htmlGmp::hidden('map_opts[marker_clasterer_icon]', array(
													'value' => $curClusterIcon, ))?>
												<?php echo htmlGmp::hidden('map_opts[marker_clasterer_icon_width]', array(
													'value' => $curClusterIconWidth, ))?>
												<?php echo htmlGmp::hidden('map_opts[marker_clasterer_icon_height]', array(
													'value' => $curClusterIconHeight, ))?>
												<img id="gmpMarkerClastererIconPrevImg" src="<?php echo $curClusterIcon?>" style="max-width: 53px; height: auto;" />
											</div>
											<div style="clear: both;"></div>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<?php if(!$this->isPro) { ?>
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=enable_custom_map_controls&utm_campaign=googlemaps'); ?>
										<?php }?>
										<label for="map_opts_enable_custom_map_controls">
											<?php _e('Custom Map Controls', GMP_LANG_CODE)?>:
										</label>
										<i
											style="float: right;"
											class="fa fa-question supsystic-tooltip"
											title="<?php _e('Add custom map controls to the map.', GMP_LANG_CODE); 
												if(!$this->isPro){ 
													echo esc_html('<a href="'. $proLink. '" target="_blank"><img src="'. $this->promoModPath. 'img/custom_controls/custom_map_controls.png" /></a>'); 
												}?>"
										></i>
										<?php if(!$this->isPro) { ?>
											<br /><span class="gmpProOptMiniLabel"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
										<?php }?>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[enable_custom_map_controls]', array(
											'value' => $this->editMap && isset($this->map['params']['enable_custom_map_controls']) ? $this->map['params']['enable_custom_map_controls'] : false,
											'attrs' => 'class="gmpProOpt" onclick="gmpAddCustomControlsOptions()"'))?>
										<div id="custom_controls_options" style="display: none;">
											<div style="margin-top: 10px;">
											<label for="map_opts_custom_controls_type">
												<?php _e('Controls type', GMP_LANG_CODE)?>
											</label>
											<?php echo htmlGmp::selectbox('map_opts[custom_controls_type]', array(
												'options' => array('gmpSquareControls' => __('Square', GMP_LANG_CODE), 'gmpRoundedEdgesControls' => __('Rounded edges', GMP_LANG_CODE), 'gmpRoundControls' => __('Round', GMP_LANG_CODE)),
												'value' => $this->editMap && isset($this->map['params']['custom_controls_type']) ? $this->map['params']['custom_controls_type'] : 'round',
												'attrs' => 'class="gmpProOpt" style="width: 100%;" id="map_opts_custom_controls_type"'))?>
											</div>
											<div style="margin-top: 10px;">
												<label for="map_opts_custom_controls_bg_color">
													<?php _e('Background color', GMP_LANG_CODE)?>
												</label></br>
												<?php echo htmlGmp::colorpicker('map_opts[custom_controls_bg_color]', array(
													'attrs' => 'class="gmpProOpt"',
													'value' => $this->editMap && isset($this->map['params']['custom_controls_bg_color']) ? $this->map['params']['custom_controls_bg_color'] : '#55BA68'))?>
											</div>
											<div style="margin-top: 10px;">
											<label for="map_opts_custom_controls_txt_color">
												<?php _e('Text color', GMP_LANG_CODE)?>
											</label></br>
											<?php echo htmlGmp::colorpicker('map_opts[custom_controls_txt_color]', array(
												'attrs' => 'class="gmpProOpt"',
												'value' => $this->editMap && isset($this->map['params']['custom_controls_txt_color']) ? $this->map['params']['custom_controls_txt_color'] : '#000000'))?>
											</div>
											<div style="margin-top: 10px;">
												<label for="map_opts_custom_controls_position">
													<?php _e('Controls position', GMP_LANG_CODE)?>
												</label>
												<?php echo htmlGmp::selectbox('map_opts[custom_controls_position]', array(
													'options' => $this->positionsList,
													'value' => $this->editMap && isset($this->map['params']['custom_controls_position']) ? $this->map['params']['custom_controls_position'] : 'TOP_LEFT',
													'attrs' => 'class="gmpProOpt" style="width: 100%;" id="map_opts_custom_controls_position"'
												))?>
											</div>
											<div style="margin-top: 10px;">
												<label for="map_opts_custom_controls_slider_min">
													<?php _e('Min Search Radius', GMP_LANG_CODE)?>
												</label></br>
												<?php echo htmlGmp::text('map_opts[custom_controls_slider_min]', array(
													'value' => $this->editMap && isset($this->map['params']['custom_controls_slider_min']) ? $this->map['params']['custom_controls_slider_min'] : '0',
													'attrs' => 'class="gmpProOpt" style="width: 100%;" id="map_opts_custom_controls_slider_min"'))?>
											</div>
											<div style="margin-top: 10px;">
												<label for="map_opts_custom_controls_slider_max">
													<?php _e('Max Search Radius', GMP_LANG_CODE)?>
												</label></br>
												<?php echo htmlGmp::text('map_opts[custom_controls_slider_max]', array(
													'value' => $this->editMap && isset($this->map['params']['custom_controls_slider_max']) ? $this->map['params']['custom_controls_slider_max'] : '1000000',
													'attrs' => 'class="gmpProOpt" style="width: 100%;" id="map_opts_custom_controls_slider_max"'))?>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_enable_full_screen_btn">
											<?php _e('Full Screen Button', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Add a button on map to open it full screen.', GMP_LANG_CODE)?>"></i>
										<?php if(!$this->isPro) { ?>
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=enable_full_screen_btn&utm_campaign=googlemaps'); ?>
											<br /><span class="gmpProOptMiniLabel"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
										<?php }?>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[enable_full_screen_btn]', array(
											'value' => $this->editMap && isset($this->map['params']['enable_full_screen_btn']) ? $this->map['params']['enable_full_screen_btn'] : false,
											'attrs' => 'class="gmpProOpt"'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<?php if(!$this->isPro) { ?>
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=enable_directions_btn&utm_campaign=googlemaps'); ?>
										<?php }?>
										<label for="map_opts_enable_directions_btn">
											<?php _e('Directions Button', GMP_LANG_CODE)?>:
										</label>
										<i
											style="float: right;"
											class="fa fa-question supsystic-tooltip"
											title="<?php _e('Add a button at marker description to get direction from the entered address to the marker.', GMP_LANG_CODE); 
												if(!$this->isPro){
													echo esc_html('<a href="'. $proLink. '" target="_blank"><img src="'. $this->promoModPath. 'img/directions/get_directions.png" /></a>'); 
												}?>"
										></i>
										<?php if(!$this->isPro) { ?>
											<br /><span class="gmpProOptMiniLabel"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
										<?php }?>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[enable_directions_btn]', array(
											'value' => $this->editMap && isset($this->map['params']['enable_directions_btn']) ? $this->map['params']['enable_directions_btn'] : false,
											'attrs' => 'class="gmpProOpt"'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<?php if(!$this->isPro) { ?>
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=add_kml_layers&utm_campaign=googlemaps'); ?>
										<?php }?>
										<label for="map_opts_add_kml_layers">
											<?php _e('Add KML layers', GMP_LANG_CODE)?>:
										</label>
										<i
											style="float: right;"
											class="fa fa-question supsystic-tooltip"
											title="<?php _e('Add KML files to display custom layers on the map.', GMP_LANG_CODE);
											if(!$this->isPro){
												echo esc_html('<a href="'. $proLink. '" target="_blank"><img src="'. $this->promoModPath. 'img/kml/kml.png" /></a>');
											}?>"
										></i>
										<?php if(!$this->isPro) { ?>
											<br /><span class="gmpProOptMiniLabel"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
										<?php }?>
									</th>
									<td>
										<div id="gmpKmlFileRowExample" class="gmpKmlFileRow" style="display: none;">
											<div style="clear: both;"></div>
											<label for="map_opts_kml_file_url">
												<?php _e('Enter KML file URL', GMP_LANG_CODE)?>
											</label></br>
											<button
												class="btn btn-danger gmpProOpt"
												style="
													float: left;
													margin: 6px 5px 0px 0px;
													padding: 0px;
													width: 20px;
													height: 25px;"
												onclick="gmpKmlRemoveFileRowBtnClick(this); return false;"
											>
												<?php _e('X', GMP_LANG_CODE)?>
											</button>
											<?php echo htmlGmp::text('map_opts[kml_file_url][]', array(
												'value' => '',
												'attrs' => 'class="gmpProOpt" style="width: 90%;" disabled="disabled"'))?>
											<span
												class="gmpKmlUploadMsg"
												style="	float: right; width: 100%; text-align: right;"
											></span>
											<a
												href="#"
												class="gmpKmlUploadFileBtn button gmpProOpt"
												data-nonce="<?php echo wp_create_nonce('upload-kml-file')?>"
												data-url="<?php echo uriGmp::_(array(
													'baseUrl' => admin_url('admin-ajax.php'),
													'page' => 'kml',
													'action' => 'addFromFile',
													'reqType' => 'ajax',
													'pl' => GMP_CODE))?>"
												id="gmpKmlUploadFileBtn"
												style="margin: 5px 0px; float: right;"
											>
												<?php _e('or Upload KML file', GMP_LANG_CODE)?>
											</a><br />
										</div>
										<div id="gmpKmlFileRowsShell"></div>
										<a
										 	href="#"
											class="button gmpProOpt"
											id="gmpKmlAddFileRowBtn"
											style="margin: 5px 5px 5px 0px; float: left;"
										>
											<?php _e('Add more files', GMP_LANG_CODE)?>
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_hide_poi">
											<?php _e('Hide POI', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Hide the Points Of Interest - landmark or other object, the marked points on the map, for example: hotels, campsites, fuel stations etc.', GMP_LANG_CODE)?>"></i>
										<?php if(!$this->isPro) { ?>
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=hide_poi&utm_campaign=googlemaps'); ?>
											<br /><span class="gmpProOptMiniLabel"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
										<?php }?>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[hide_poi]', array(
											'value' => $this->editMap && isset($this->map['params']['hide_poi']) ? $this->map['params']['hide_poi'] : false,
											'attrs' => 'class="gmpProOpt"'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_center_on_cur_user_pos">
											<?php _e('Center on current user location', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('On frontend map will be centered on current user location.', GMP_LANG_CODE)?>"></i>
										<?php if(!$this->isPro) { ?>
											<?php $proLink = frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=center_on_cur_user_pos&utm_campaign=googlemaps'); ?>
											<br /><span class="gmpProOptMiniLabel"><a target="_blank" href="<?php echo $proLink?>"><?php _e('PRO option', GMP_LANG_CODE)?></a></span>
										<?php }?>
									</th>
									<td>
										<?php echo htmlGmp::checkboxHiddenVal('map_opts[center_on_cur_user_pos]', array(
											'value' => $this->editMap && isset($this->map['params']['center_on_cur_user_pos']) ? $this->map['params']['center_on_cur_user_pos'] : false,
											'attrs' => 'class="gmpProOpt"'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_marker_infownd_width">
											<?php _e('Markers Info Window Width', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Width of markers info windows.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
									<?php
										$markersInfoWndWidthUnits = isset($this->map['params']['marker_infownd_width_units']) && $this->map['params']['marker_infownd_width_units'];
										$markersInfoWndWidthInput = isset($this->map['params']['marker_infownd_width']) && $this->map['params']['marker_infownd_width'];
										$markersInfoWndWidthInputViewStyle = $this->editMap && $markersInfoWndWidthUnits && htmlGmp::checkedOpt($this->map['params'], 'marker_infownd_width_units', 'px') ? 'block' : 'none';
										$markersInfoWndWidthUnitsLabelStyle = $this->editMap && $markersInfoWndWidthUnits && htmlGmp::checkedOpt($this->map['params'], 'marker_infownd_width_units', 'px') ? '7px' : '0px';
									?>
										<div class="sup-col" style="padding-right: 0px;">
											<label
												for="map_opts_marker_infownd_width_units"
												style="margin-right: 15px; position: relative; top: <?php echo $markersInfoWndWidthUnitsLabelStyle?>;"
											>
												<?php echo htmlGmp::radiobutton('map_opts[marker_infownd_width_units]', array(
													'value' => 'auto',
													'checked' => $this->editMap && $markersInfoWndWidthUnits ? htmlGmp::checkedOpt($this->map['params'], 'marker_infownd_width_units', 'auto') : true,
												))?>&nbsp;<?php _e('Auto', GMP_LANG_CODE)?>
											</label>
											<label
												for="map_opts_marker_infownd_width_units"
												class="supsystic-tooltip"
												title="<?php _e('Pixels', GMP_LANG_CODE)?>"
												style="margin-right: 15px; position: relative; top: <?php echo $markersInfoWndWidthUnitsLabelStyle?>;"
											>
												<?php echo htmlGmp::radiobutton('map_opts[marker_infownd_width_units]', array(
													'value' => 'px',
													'checked' => $this->editMap && $markersInfoWndWidthUnits ? htmlGmp::checkedOpt($this->map['params'], 'marker_infownd_width_units', 'px') : false,
												))?>&nbsp;<?php _e('Px', GMP_LANG_CODE)?>
											</label>
										</div>
										<div class="sup-col sup-w-25">
											<?php echo htmlGmp::text('map_opts[marker_infownd_width]', array(
												'value' => $this->editMap && $markersInfoWndWidthInput ? $this->map['params']['marker_infownd_width'] : '200',
												'attrs' => 'style="width: 100%; display: '. $markersInfoWndWidthInputViewStyle .';"'))?>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_marker_infownd_height">
											<?php _e('Markers Info Window Height', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Height of markers info windows.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php
										$markersInfoWndHeightUnits = isset($this->map['params']['marker_infownd_height_units']) && $this->map['params']['marker_infownd_height_units'];
										$markersInfoWndHeightInput = isset($this->map['params']['marker_infownd_height']) && $this->map['params']['marker_infownd_height'];
										$markersInfoWndHeightInputViewStyle = $this->editMap && $markersInfoWndHeightUnits && htmlGmp::checkedOpt($this->map['params'], 'marker_infownd_height_units', 'px') ? 'block' : 'none';
										$markersInfoWndHeightUnitsLabelStyle = $this->editMap && $markersInfoWndHeightUnits && htmlGmp::checkedOpt($this->map['params'], 'marker_infownd_height_units', 'px') ? '7px' : '0px';
										?>
										<div class="sup-col" style="padding-right: 0px;">
											<label
												for="map_opts_marker_infownd_height_units"
												style="margin-right: 15px; position: relative; top: <?php echo $markersInfoWndHeightUnitsLabelStyle?>;"
												>
												<?php echo htmlGmp::radiobutton('map_opts[marker_infownd_height_units]', array(
													'value' => 'auto',
													'checked' => $this->editMap && $markersInfoWndHeightUnits ? htmlGmp::checkedOpt($this->map['params'], 'marker_infownd_height_units', 'auto') : true,
												))?>&nbsp;<?php _e('Auto', GMP_LANG_CODE)?>
											</label>
											<label
												for="map_opts_marker_infownd_height_units"
												class="supsystic-tooltip"
												title="<?php _e('Pixels', GMP_LANG_CODE)?>"
												style="margin-right: 15px; position: relative; top: <?php echo $markersInfoWndHeightUnitsLabelStyle?>;"
												>
												<?php echo htmlGmp::radiobutton('map_opts[marker_infownd_height_units]', array(
													'value' => 'px',
													'checked' => $this->editMap && $markersInfoWndHeightUnits ? htmlGmp::checkedOpt($this->map['params'], 'marker_infownd_height_units', 'px') : false,
												))?>&nbsp;<?php _e('Px', GMP_LANG_CODE)?>
											</label>
										</div>
										<div class="sup-col sup-w-25">
											<?php echo htmlGmp::text('map_opts[marker_infownd_height]', array(
												'value' => $this->editMap && $markersInfoWndHeightInput ? $this->map['params']['marker_infownd_height'] : '100',
												'attrs' => 'style="width: 100%; display: '. $markersInfoWndHeightInputViewStyle .';"'))?>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_marker_infownd_bg_color">
											<?php _e('Markers Info Window Background', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Background color of markers info windows.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php echo htmlGmp::colorpicker('map_opts[marker_infownd_bg_color]', array(
											'value' => $this->editMap && isset($this->map['params']['marker_infownd_bg_color']) ? $this->map['params']['marker_infownd_bg_color'] : '#FFFFFF'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_zoom_min" class="sup-medium-label">
											<?php _e('Min Zoom Level', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Sets min zoom level for map.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php echo htmlGmp::selectbox('map_opts[zoom_min]', array(
											'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21),
											'value' => $this->editMap && isset($this->map['params']['zoom_min']) ? $this->map['params']['zoom_min'] : 1,
											'attrs' => 'style="width: 100%;"'))?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="map_opts_zoom_max" class="sup-medium-label">
											<?php _e('Max Zoom Level', GMP_LANG_CODE)?>:
										</label>
										<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Sets max zoom level for map.', GMP_LANG_CODE)?>"></i>
									</th>
									<td>
										<?php echo htmlGmp::selectbox('map_opts[zoom_max]', array(
											'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21),
											'value' => $this->editMap && isset($this->map['params']['zoom_max']) ? $this->map['params']['zoom_max'] : 21,
											'attrs' => 'style="width: 100%;"'))?>
									</td>
								</tr>
							</table>
						</div>
						<?php echo htmlGmp::hidden('mod', array('value' => 'gmap'))?>
						<?php echo htmlGmp::hidden('action', array('value' => 'save'))?>
						<?php echo htmlGmp::hidden('map_opts[id]', array('value' => $this->editMap ? $this->map['id'] : ''))?>
						<?php echo htmlGmp::hidden('map_opts[map_center][coord_x]', array('value' => $this->editMap ? $this->map['params']['map_center']['coord_x'] : ''))?>
						<?php echo htmlGmp::hidden('map_opts[map_center][coord_y]', array('value' => $this->editMap ? $this->map['params']['map_center']['coord_y'] : ''))?>
						<?php echo htmlGmp::hidden('map_opts[zoom]', array('value' => $this->editMap ? $this->map['params']['zoom'] : ''))?>
					</form>
				</div>
				<div id="gmpMarkerTab" class="gmpTabContent">
					<form id="gmpMarkerForm">
						<table class="form-table">
							<tr>
								<th scope="row">
									<label class="label-big" for="marker_opts_title">
										<?php _e('Marker Name', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Your marker title', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<?php echo htmlGmp::text('marker_opts[title]', array(
										'value' => '',
										'attrs' => 'style="width: 100%;" id="marker_opts_title"'))?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="marker_opts_title">
										<?php _e('Marker Description', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Write here all text, that you want to appear in marker info-window PopUp', GMP_LANG_CODE)?>"></i>
								</th>
								<td></td>
							</tr>
							<tr>
								<th colspan="2">
									<?php wp_editor('', 'markerDescription', array(
										//'textarea_name' => 'marker_opts[description]',
										'textarea_rows' => 10
									));?>
									<?php echo htmlGmp::hidden('marker_opts[description]', array('value' => ''))?>
								</th>
							</tr>
							<tr>
								<th scope="row">
									<label class="label-big" for="gmpMarkerIconBtn">
										<?php _e('Icon', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Your marker Icon, that will appear on your map for this marker', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<?php echo htmlGmp::hidden('marker_opts[icon]', array(
										'value' => 1 /*Default Icon ID*/ ))?>
									<img id="gmpMarkerIconPrevImg" src="" style="float: left;" />
									<div style="float: right">
										<a id="gmpMarkerIconBtn" href="#" class="button"><?php _e('Choose Icon', GMP_LANG_CODE)?></a>
										<a id="gmpUploadIconBtn" href="#" class="button"><?php _e('Upload Icon', GMP_LANG_CODE)?></a>
										<div class="gmpUplRes"></div>
										<div class="gmpFileUpRes"></div>
									</div>
									<div style="clear: both;"></div>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="marker_opts_address">
										<?php _e('Address', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Search your location by address, just start typing here', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<?php echo htmlGmp::text('marker_opts[address]', array(
										'value' => '',
										'placeholder' => '603 Park Avenue, Brooklyn, NY 11206, USA',
										'attrs' => 'style="width: 100%;" id="marker_opts_address"'))?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="marker_opts_coord_x">
										<?php _e('Latitude', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Latitude for your marker', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<?php echo htmlGmp::text('marker_opts[coord_x]', array(
										'value' => '',
										'placeholder' => '40.69827799999999',
										'attrs' => 'style="width: 100%;" id="marker_opts_coord_x"'))?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="marker_opts_coord_y">
										<?php _e('Longitude', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Longitude for your marker', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<?php echo htmlGmp::text('marker_opts[coord_y]', array(
										'value' => '',
										'placeholder' => '-73.95141139999998',
										'attrs' => 'style="width: 100%;" id="marker_opts_coord_y"'))?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="marker_opts_show_description">
										<?php _e('Show description by default', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Open marker description when map load', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<?php echo htmlGmp::checkbox('marker_opts[params][show_description]', array(
										'checked' => ''))?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="marker_opts_marker_link">
										<?php _e('Marker Link', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Link for opening by click on the marker', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<?php echo htmlGmp::checkbox('marker_opts[params][marker_link]', array(
										'checked' => '',
										'attrs' => 'id="marker_link" onclick="gmpAddLinkOptions()"',
									))?>
									<div id="link_options" style="display: none;">
										<?php echo htmlGmp::text('marker_opts[params][marker_link_src]', array(
											'value' => '',
											'attrs' => 'style="width: 90%; margin: 0px 0px 10px 0px;"',
										))?>
										<?php echo htmlGmp::checkbox('marker_opts[params][marker_link_new_wnd]', array(
											'checked' => ''))?>
										<span>
											<?php _e('Open in new window', GMP_LANG_CODE)?>
										</span>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="marker_opts_description_mouse_hover">
										<?php _e('Show description by mouse hover', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Open marker description by mouse hover', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<?php echo htmlGmp::checkbox('marker_opts[params][description_mouse_hover]', array(
										'checked' => ''))?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="marker_opts_marker_group_id">
										<?php _e('Marker Category', GMP_LANG_CODE)?>:
									</label>
									<i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php _e('Choose marker category', GMP_LANG_CODE)?>"></i>
								</th>
								<td>
									<div class="sup-col" style="width: 100%;">
										<?php echo htmlGmp::selectbox('marker_opts[marker_group_id]', array(
											'options' => $this->markerGroupsForSelect,
											'value' => '',
											'attrs' => 'style="width: 100%;" id="marker_opts_marker_group_id"'))?>
									</div>
								</td>
							</tr>
						</table>
						<?php echo htmlGmp::hidden('mod', array('value' => 'marker'))?>
						<?php echo htmlGmp::hidden('action', array('value' => 'save'))?>
						<?php echo htmlGmp::hidden('marker_opts[id]', array('value' => ''))?>
						<?php echo htmlGmp::hidden('marker_opts[map_id]', array('value' => $this->editMap ? $this->map['id'] : ''))?>
						<?php echo htmlGmp::hidden('marker_opts[path]', array('value' => ''))?>
					</form>
				</div>
			</div>
			<div class="supsistic-half-side-box">
				<div id="gmpMapRightStickyBar" class="supsystic-sticky">
					<div id="gmpMapPreview" style="width: 100%; height: 300px;"></div>
					<div class="gmpMapProControlsCon" id="gmpMapProControlsCon_<?php echo $this->viewId;?>">
						<?php dispatcherGmp::doAction('addAdminMapBottomControls', $this->editMap ? $this->map : array()); ?>
					</div>
					<?php echo htmlGmp::hidden('rand_view_id', array('value' => $this->viewId, 'attrs' => 'id="gmpViewId"'))?>
					<div id="gmpShortCodeRowShell" class="row">
						<div class="shortcode-wrap">
							<p id="shortcodeCode" style="display: none;">
								<strong style="margin-top: 7px; font-size: 1.2em; float: left;"><?php _e('Map shortcode', GMP_LANG_CODE)?>:</strong>
								<?php echo htmlGmp::text('gmpCopyTextCode', array(
									'value' => '',	// Will be inserted from JS
									'attrs' => 'class="gmpCopyTextCode gmpMapShortCodeShell" style="float: right;"'));?>
								<br style="clear: both;" />
								<strong style="margin-top: 7px; font-size: 1.2em; float: left;"><?php _e('PHP code', GMP_LANG_CODE)?>:</strong>
								<?php echo htmlGmp::text('gmpCopyTextCode', array(
									'value' => '',	// Will be inserted from JS
									'attrs' => 'class="gmpCopyTextCode gmpMapPhpShortCodeShell" style="float: right;"'));?>
								<br style="clear: both;" />
							</p>
							<p id="shortcodeNotice" style="display: none;"><?php _e('Shortcode will appear after you save map.', GMP_LANG_CODE)?></p>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div id="gmpMapMainBtns" class="row">
						<div class="sup-col sup-w-50">
							<button id="gmpMapSaveBtn" class="button button-primary" style="width: 100%;">
								<i class="fa dashicons-before dashicons-admin-site"></i>
								<?php _e('Save Map', GMP_LANG_CODE)?>
							</button>
						</div>
						<div class="sup-col sup-w-50" style="padding-right: 0;">
							<button id="gmpMapDeleteBtn" class="button button-primary" style="width: 100%;">
								<i class="fa dashicons-before dashicons-trash"></i>
								<?php _e('Delete Map', GMP_LANG_CODE)?>
							</button>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div id="gmpMarkerMainBtns" class="row">
						<div class="sup-col sup-w-50">
							<button id="gmpSaveMarkerBtn" class="button button-primary" style="width: 100%;">
								<i class="fa fa-map-marker"></i>
								<?php _e('Save Marker', GMP_LANG_CODE)?>
							</button>
						</div>
						<div class="sup-col sup-w-50" style="padding-right: 0;">
							<button id="gmpMarkerDeleteBtn" class="button button-primary" style="width: 100%;">
								<i class="fa dashicons-before dashicons-trash"></i>
								<?php _e('Delete Marker', GMP_LANG_CODE)?>
							</button>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div class="row">
						<div id="markerList">
							<div style="display: none;" id="markerRowTemplate" class="row gmpMapMarkerRow">
								<div class="col-xs-12 egm-marker">
									<div class="row">
										<div class="col-xs-2 egm-marker-icon">
											<img alt="" src="">
										</div>
										<div class="col-xs-4 egm-marker-title">
										</div>
										<div class="col-xs-3 egm-marker-latlng">
										</div>
										<div class="col-xs-3 egm-marker-actions">
											<button title="<?php _e('Edit', GMP_LANG_CODE)?>" type="button" class="button button-small egm-marker-edit">
												<i class="fa fa-fw fa-pencil"></i>
											</button>
											<button title="<?php _e('Delete', GMP_LANG_CODE)?>" type="button" class="button button-small egm-marker-remove">
												<i class="fa fa-fw fa-trash-o"></i>
											</button>
										</div>
									</div>
								</div>
								<div style="clear: both;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</section>
<!--Icons Wnd-->
<div id="gmpIconsWnd" style="display: none;">
	<ul class="iconsList">
		<?php foreach($this->icons as $icon) { ?>
		<li class="previewIcon" data-id="<?php echo $icon['id']?>" title="<?php echo $icon['title']?>">
			<img src="<?php echo $icon['path']?>" >
		</li>
		<?php }?>
	</ul>
</div>
<!--Map Markers List Wnd-->
<div id="gmpMarkersListWnd" style="display: none;" title="<?php _e('Show markers list with your map on frontend', GMP_LANG_CODE)?>">
	<!--Mml == Map Markers List-->
	<ul id="gmpMml">
		<?php foreach($this->markerLists as $lKey => $lData) { ?>
		<li class="gmpMmlElement gmpMmlElement-<?php echo $lKey?>" data-key="<?php echo $lKey?>">
			<img src="<?php echo $this->promoModPath?>img/markers_list/<?php echo $lData['prev_img']?>" /><br />
			<div class="gmpMmlElementBtnShell">
				<a href="<?php echo frameGmp::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=marker_list_' . $lKey . '&utm_campaign=googlemaps');?>" target="_blank" class="button button-primary gmpMmlApplyBtn" data-apply-label="<?php _e('Apply', GMP_LANG_CODE)?>" data-active-label="<?php _e('Selected', GMP_LANG_CODE)?>">
					<?php $this->isPro ? _e('Apply', GMP_LANG_CODE) : _e('Available in PRO', GMP_LANG_CODE)?>
				</a>
			</div>
		</li>
		<?php }?>
	</ul>
</div>
var g_gmpMap = null
,	g_gmpMapMarkersIdsAdded = []	// Markers, added for map
,	g_gmpEditMap = false	// Adding or editing map
,	g_gmpCurrentEditMarker = null
,	g_gmpTinyMceEditorUpdateBinded = false
,	g_gmpMarkerFormChanged = false
,	g_gmpMapFormChanged = false
,	g_gmpMarkerTitleColorTimeoutSet = false
,	g_gmpMarkerTitleColorLast = ''
,	g_gmpMarkerBgColorTimeoutSet = false;
window.onbeforeunload = function(){
	// If there are at lease one unsaved form - show message for confirnation for page leave
	if(_gmpIsMapFormChanged()) {
		return 'You have unsaved changes in Map form. Are you sure want to leave this page?';
	}
	if(_gmpIsMarkerFormChanged()) {
		return 'You have unsaved changes in Marker form. Are you sure want to leave this page?';
	}
};
// Right sidebar height re-calc
jQuery(window).bind('resize', _gmpResizeRightSidebar);
jQuery(window).bind('orientationchange', _gmpResizeRightSidebar);

jQuery(document).ready(function(){
	jQuery('#gmpMapMarkerTabs').wpTabs({
		change: function(selector) {
			if(selector == '#gmpMapTab') {
				jQuery('#gmpMarkerMainBtns').hide();
				jQuery('#gmpMapMainBtns').show();
			} else {
				jQuery('#gmpMapMainBtns').hide();
				jQuery('#gmpMarkerMainBtns').show();
			}
		}
	});
	// Preview map definition
	gmpMainMap = typeof(gmpMainMap) === 'undefined' ? null : gmpMainMap;
	var previewMapParams = {};
	if(gmpMainMap) {
		previewMapParams = gmpMainMap.params;
		g_gmpEditMap = true;
	}
	previewMapParams.view_id = jQuery('#gmpViewId').val();
	if(previewMapParams.enable_custom_map_controls == 1) {
		gmpAddCustomControlsOptions();
	}
	g_gmpMap = new gmpGoogleMap('#gmpMapPreview', previewMapParams);
	if(gmpMainMap && gmpMainMap.markers) {
		gmpRefreshMapMarkers(g_gmpMap, gmpMainMap.markers);
	}
	// Map saving form
	jQuery('#gmpMapForm').submit(function(){
		var currentId = gmpGetCurrentId()
		,	firstTime = currentId ? false : true;

		jQuery(this).find('input[name="map_opts[map_center][coord_x]"]').val(g_gmpMap.getCenter().lat());
		jQuery(this).find('input[name="map_opts[map_center][coord_y]"]').val(g_gmpMap.getCenter().lng());
		jQuery(this).find('input[name="map_opts[zoom]"]').val(g_gmpMap.getZoom());
		
		jQuery(this).sendFormGmp({
			btn: '#gmpMapSaveBtn'
		,	appendData: {add_marker_ids: g_gmpMapMarkersIdsAdded}
		,	onSuccess: function(res) {
				if(!res.error) {
					if(res.data.map_id) {
						jQuery('#gmpMapForm input[name="map_opts[id]"]').val( res.data.map_id );
					}
					if(firstTime) {
						gmpCheckShortcode();
						if (res.data.edit_url) {
							setBrowserUrl( res.data.edit_url );
							jQuery('.supsystic-main-navigation-list li').removeClass('active');
							jQuery('.supsystic-main-navigation-list li[data-tab-key="gmap"]').addClass('active');
						}
						g_gmpMapMarkersIdsAdded = [];
						gmpMainMap = res.data.map;
					}
					if(_gmpIsMarkerFormChanged() && jQuery('#gmpMarkerForm input[name="marker_opts[title]"]').val() != '') {
						jQuery('#gmpMarkerForm').submit();
					}
					_gmpUnchangeMapForm();
				}
			}
		});
		return false;
	});
	jQuery('#gmpMapSaveBtn').click(function(){
		jQuery('#gmpMapForm').submit();
		return false;
	});
	jQuery('#gmpMapDeleteBtn').click(function(){
		var mapId = parseInt( jQuery('#gmpMapForm input[name="map_opts[id]"]').val() );
		if(mapId) {
			if(confirm(toeLangGmp('Are you sure want to delete current map?'))) {
				jQuery.sendFormGmp({
					btn: this
				,	data: {mod: 'gmap', action: 'remove', id: mapId}
				,	onSuccess: function(res) {
						if(!res.error) {
							toeRedirect(gmpMapsListUrl);
						}
					}
				});
			}
		}
		return false;
	});
	
	// Check - should we show shortcode block or not
	gmpCheckShortcode();
	// Markers form functionality
	jQuery('#gmpAddNewMarkerBtn').click(function(){
		var currentEditId = parseInt( jQuery('#gmpMarkerForm input[name="marker_opts[id]"]').val() );
		if(!currentEditId) {	// This was new marker
			var title = jQuery.trim( jQuery('#gmpMarkerForm input[name="marker_opts[title]"]').val() );
			if(title && title != '') {	// Save it if there was some required changes
				jQuery('#gmpMarkerForm').data('only-save', 1).submit();
			} else {
				var currentMarker = gmpGetCurrentMarker();
				if(currentMarker) {
					currentMarker.removeFromMap();
				}
			}
		}
		gmpOpenMarkerForm();
		// Add new marker - right after click on "Add new"
		_gmpCreateNewMapMarker();
		return false;
	});
	jQuery('#gmpSaveMarkerBtn').click(function(){
		jQuery('#gmpMarkerForm').submit();
		return false;
	});
	jQuery('#gmpMarkerDeleteBtn').click(function(){
		var markerTitle = jQuery('#gmpMarkerForm [name="marker_opts[title]"]').val();
		if(markerTitle && markerTitle != '') {
			markerTitle = '"'+ markerTitle+ '"';
		} else {
			markerTitle = 'current';
		}
		if(confirm('Remove '+ markerTitle+ ' marker?')) {
			var currentMarkerIdInForm = g_gmpCurrentEditMarker ? g_gmpCurrentEditMarker.getId() : 0;
			var removeFinalClb = function() {
				if(currentMarkerIdInForm) {
					g_gmpMap.removeMarker( currentMarkerIdInForm );
				}
				if(g_gmpCurrentEditMarker) {
					g_gmpCurrentEditMarker.removeFromMap();
				}
				gmpResetMarkerForm();
				gmpRefreshMapMarkersList( true );
			};
			if(currentMarkerIdInForm) {
				jQuery.sendFormGmp({
					btn: this
				,	data: {action: 'removeMarker', mod: 'marker', id: currentMarkerIdInForm}
				,	onSuccess: function(res) {
						if(!res.error) {
							removeFinalClb();
						}
					}
				});
			} else {
				removeFinalClb();
			}
		}
		return false;
	});
	// Marker saving
	jQuery('#gmpMarkerForm').submit(function(){
		var currentMapId = gmpGetCurrentId()
		,	currentMarkerMapId = parseInt( jQuery('#gmpMarkerForm input[name="marker_opts[map_id]"]').val() );
		if(currentMapId && !currentMarkerMapId) {
			jQuery('#gmpMarkerForm input[name="marker_opts[map_id]"]').val( currentMapId );
		}
		jQuery('#gmpMarkerForm input[name="marker_opts[description]"]').val( gmpGetTxtEditorVal('markerDescription') );
		
		var coordX = jQuery('#gmpMarkerForm input[name="marker_opts[coord_x]"]').val()
		,	coordY = jQuery('#gmpMarkerForm input[name="marker_opts[coord_y]"]').val();
		if(coordX == '' && coordY == '') {
			_gmpCreateNewMapMarker();
		}
		var onlySave = parseInt(jQuery(this).data('only-save'));
		if(onlySave) {
			jQuery(this).data('only-save', 0);
		}
		jQuery(this).sendFormGmp({
			btn: jQuery('#gmpSaveMarkerBtn')
		,	onSuccess: function(res) {
				if(!res.error) {
					if(!res.data.update) {
						if(!onlySave) {
							jQuery('#gmpMarkerForm input[name="marker_opts[id]"]').val( res.data.marker.id );
							var marker = gmpGetCurrentMarker();
							if(marker) {
								marker.setId( res.data.marker.id );
							}
						}
					}
					if(!currentMarkerMapId) {
						g_gmpMapMarkersIdsAdded.push( res.data.marker.id );
					}
					gmpRefreshMapMarkersList( true, (onlySave ? true : false) );
					_gmpUnchangeMarkerForm();
				}
			}
		});
		return false;
	});
	gmpInitIconsWnd();
	jQuery('#gmpMarkerForm [name="marker_opts[title]"]').keyup(function(){
		var marker = gmpGetCurrentMarker();
		if(!marker) {
			_gmpCreateNewMapMarker();
			marker = gmpGetCurrentMarker();
		}
		if(marker) {
			marker.setTitle( jQuery(this).val() );
			marker.showInfoWnd();
		}
	});
	// Build initial markers list
	gmpRefreshMapMarkersList(false, true);
	// Bind change marker description - with it's description in map preview
	setTimeout(function(){
		gmpBindTinyMceUpdate();
		if(!g_gmpTinyMceEditorUpdateBinded) {
			jQuery('.wp-switch-editor.switch-tmce').click(function(){
				setTimeout(gmpBindTinyMceUpdate, 500);
			});
		}
	}, 500);
	jQuery('#markerDescription').keyup(function(){
		var marker = gmpGetCurrentMarker();
		if(!marker) {
			_gmpCreateNewMapMarker();
			marker = gmpGetCurrentMarker();
		}
		if(marker) {
			marker.setDescription( gmpGetTxtEditorVal('markerDescription') );
			marker.showInfoWnd();
		}
	});
	jQuery('#gmpMarkerForm [name="marker_opts[address]"]').mapSearchAutocompleateGmp({
		msgEl: ''
	,	onSelect: function(item, event, ui) {
			if(item) {
				jQuery('#gmpMarkerForm [name="marker_opts[coord_x]"]').val(item.lat);
				jQuery('#gmpMarkerForm [name="marker_opts[coord_y]"]').val(item.lng).trigger('change');
			}
		}
	});
	jQuery('#gmpMarkerForm').find('input[name="marker_opts[coord_x]"],input[name="marker_opts[coord_y]"]').change(function(){
		var newX = jQuery('#gmpMarkerForm [name="marker_opts[coord_x]"]').val()
		,	newY = jQuery('#gmpMarkerForm [name="marker_opts[coord_y]"]').val();
		var marker = gmpGetCurrentMarker();
		if(marker) {
			marker.setPosition(newX, newY);
		} else {	// If there are no marker on map - set it and re-position it right into new position
			_gmpCreateNewMapMarker({coord_x: newX, coord_y: newY});
		}
	});
	// Extended options block
	jQuery('#gmpExtendOptsBtn').click(function(){
		jQuery('#gmpExtendOptsBtnShell').slideUp( g_gmpAnimationSpeed );
		jQuery('#gmpExtendOptsShell').slideDown( g_gmpAnimationSpeed );
		return false;
	});
	// Map type control style
	jQuery('#gmpMapForm select[name="map_opts[type_control]"]').change(function(){
		var newType = jQuery(this).val();
		if(typeof(google.maps.MapTypeControlStyle[ newType ]) !== 'undefined') {
			var mapTypeControlOptions = g_gmpMap.get('mapTypeControlOptions') || {};
			mapTypeControlOptions.style = google.maps.MapTypeControlStyle[ newType ];
			g_gmpMap.set('mapTypeControlOptions', mapTypeControlOptions).set('mapTypeControl', true);
		} else {
			g_gmpMap.set('mapTypeControl', false);
		}
	});
	// Map zoom control style
	jQuery('#gmpMapForm select[name="map_opts[zoom_control]"]').change(function(e){
		if(jQuery('#gmpMapForm input[name="map_opts[enable_custom_map_controls]"]').val() == 1) {
			e.stopPropagation();
			var $zoomDisableMsg = jQuery('#gmpDefaultZoomDisable').dialog({
				modal:    true
			,	autoOpen: false
			,	width:	540
			,	height: 150
			});
			$zoomDisableMsg.dialog('open');
			return false;
		}
		var newType = jQuery(this).val();
		if(typeof(google.maps.ZoomControlStyle[ newType ]) !== 'undefined') {
			var zoomControlOptions = g_gmpMap.get('zoomControlOptions') || {};
			zoomControlOptions.style = google.maps.ZoomControlStyle[ newType ];
			g_gmpMap.set('zoomControlOptions', zoomControlOptions).set('zoomControl', true);
		} else {
			g_gmpMap.set('zoomControl', false);
		}
	});
	// Map street view control
	jQuery('#gmpMapForm input[name="map_opts[street_view_control]"]').change(function(){
		// Remember - that this is not actually checkbox, we detect hidden field value here, @see htmlGmp::checkboxHiddenVal()
		if(parseInt(jQuery(this).val())) {
			g_gmpMap.set('streetViewControl', true);
		} else {
			g_gmpMap.set('streetViewControl', false);
		}
	});
	// Map pan view control
	jQuery('#gmpMapForm input[name="map_opts[pan_control]"]').change(function(){
		// Remember - that this is not actually checkbox, we detect hidden field value here, @see htmlGmp::checkboxHiddenVal()
		if(parseInt(jQuery(this).val())) {
			g_gmpMap.set('panControl', true);
		} else {
			g_gmpMap.set('panControl', false);
		}
	});
	// Map overview control style
	jQuery('#gmpMapForm select[name="map_opts[overview_control]"]').change(function(){
		var newType = jQuery(this).val();
		if(newType !== 'none') {
			g_gmpMap.set('overviewMapControlOptions', {
				opened: newType === 'opened' ? true : false
			}).set('overviewMapControl', true);
		} else {
			g_gmpMap.set('overviewMapControl', false);
		}
	});
	// Is map draggable
	jQuery('#gmpMapForm input[name="map_opts[draggable]"]').change(function(){
		// Remember - that this is not actually checkbox, we detect hidden field value here, @see htmlGmp::checkboxHiddenVal()
		if(parseInt(jQuery(this).val())) {
			g_gmpMap.set('draggable', true);
		} else {
			g_gmpMap.set('draggable', false);
		}
	});
	// Enable Double Click to zoom
	jQuery('#gmpMapForm input[name="map_opts[dbl_click_zoom]"]').change(function(){
		// Remember - that this is not actually checkbox, we detect hidden field value here, @see htmlGmp::checkboxHiddenVal()
		if(parseInt(jQuery(this).val())) {
			g_gmpMap.set('disableDoubleClickZoom', false);
		} else {
			g_gmpMap.set('disableDoubleClickZoom', true);
		}
	});
	// Mouse zoom enbling
	jQuery('#gmpMapForm input[name="map_opts[mouse_wheel_zoom]"]').change(function(){
		// Remember - that this is not actually checkbox, we detect hidden field value here, @see htmlGmp::checkboxHiddenVal()
		if(parseInt(jQuery(this).val())) {
			g_gmpMap.set('scrollwheel', true);
		} else {
			g_gmpMap.set('scrollwheel', false);
		}
	});
	// Map type
	jQuery('#gmpMapForm select[name="map_opts[map_type]"]').change(function(){
		var newType = jQuery(this).val();
		if(typeof(google.maps.MapTypeId[ newType ]) !== 'undefined') {
			g_gmpMap.set('mapTypeId', google.maps.MapTypeId[ newType ]);
		}
	});
	// Map stylization
	jQuery('#gmpMapForm select[name="map_opts[map_stylization]"]').change(function(){
		var newType = jQuery(this).val();
		if(newType !== 'none' && typeof(gmpAllStylizationsList[ newType ]) !== 'undefined') {
			g_gmpMap.set('styles', gmpAllStylizationsList[ newType ]);
		} else {
			g_gmpMap.set('styles', false);
		}
	});
	// Map Clasterization
	var markerClustererInput = jQuery('#gmpMapForm select[name="map_opts[marker_clasterer]"]');
	markerClustererInput.change(function(){
		var newType = jQuery(this).val();
		if(newType !== 'none' && newType) {
			g_gmpMap.enableClasterization( newType );
			gmpSwitchClustererIconView(newType);
		} else {
			g_gmpMap.disableClasterization();
			gmpSwitchClustererIconView('none');
		}
	});
	gmpSwitchClustererIconView(markerClustererInput.val());
	// Map KML layers
	jQuery('#gmpKmlAddFileRowBtn').click(function(e){
		if(GMP_DATA.isPro == '') {
			e.stopPropagation();
			var $proOptWnd = gmpGetMainPromoPopup();
			$proOptWnd.dialog('open');
			return false;
		}
	});
	// Map Marker Info Window width and height units
	jQuery('#gmpMapForm input[name="map_opts[marker_infownd_width_units]"]').change(function(){
		var infoWndWidthInput = jQuery('#gmpMapForm input[name="map_opts[marker_infownd_width]"]')
		,	infoWndWidthLabel = jQuery('#gmpMapForm').find('[for="map_opts_marker_infownd_width_units"]');

		if(jQuery(this).val() == 'px' && jQuery(this).val()) {
			infoWndWidthLabel.css('top', '7px');
			infoWndWidthInput.show();
		} else {
			infoWndWidthLabel.css('top', '0px');
			infoWndWidthInput.hide();
		}
	});
	jQuery('#gmpMapForm input[name="map_opts[marker_infownd_height_units]"]').change(function(){
		var infoWndHeightInput = jQuery('#gmpMapForm input[name="map_opts[marker_infownd_height]"]')
		,	infoWndHeightLabel = jQuery('#gmpMapForm').find('[for="map_opts_marker_infownd_height_units"]');

		if(jQuery(this).val() == 'px' && jQuery(this).val()) {
			infoWndHeightLabel.css('top', '7px');
			infoWndHeightInput.show();
		} else {
			infoWndHeightLabel.css('top', '0px');
			infoWndHeightInput.hide();
		}
	});
	jQuery('#gmpMapForm select[name="map_opts[zoom_min]"]').change(function(){
		var minZoom = jQuery(this).val()
		,	maxZoom = jQuery('#gmpMapForm select[name="map_opts[zoom_max]"]').val();
		g_gmpMap.setParam('zoom_min', minZoom);
		g_gmpMap.setParam('zoom_max', maxZoom);
		g_gmpMap._setMinZoomLevel();
		g_gmpMap._setMaxZoomLevel();
		g_gmpMap._fixZoomLevel();
	});
	jQuery('#gmpMapForm select[name="map_opts[zoom_max]"]').change(function(){
		var minZoom = jQuery('#gmpMapForm select[name="map_opts[zoom_min]"]').val()
		,	maxZoom = jQuery(this).val();
		g_gmpMap.setParam('zoom_min', minZoom);
		g_gmpMap.setParam('zoom_max', maxZoom);
		g_gmpMap._setMinZoomLevel();
		g_gmpMap._setMaxZoomLevel();
		g_gmpMap._fixZoomLevel();
	});
	// Set base icon img
	gmpSetIconImg();
	// Map Markers List selection
	gmpInitMapMarkersListWnd();
	// Ask before leave page without saving
	jQuery('#gmpMapForm').find('input,select,textarea').change(function(){
		_gmpChangeMapForm();
	});
	jQuery('#gmpMarkerForm').find('input,textarea,select').change(function(){
		_gmpChangeMarkerForm();
	});
	// Make markers table - sortable
	jQuery('#markerList').sortable({
		revert: true
	,	items: '.gmpMapMarkerRow'
	,	placeholder: 'ui-sortable-placeholder'
	,	update: function(event, ui) {
			var mapId = gmpGetCurrentId();
			var msgEl = jQuery('#gmpMarkersSortMsg').size() ? jQuery('#gmpMarkersSortMsg') : jQuery('<div id="gmpMarkersSortMsg" />')
			,	markersList = [];
			jQuery('#markerList').find('.gmpMapMarkerRow:not(#markerRowTemplate)').each(function(){
				markersList.push( jQuery(this).data('id') );
			});
			ui.item.find('.egm-marker-icon').append( msgEl );
			jQuery.sendFormGmp({
				msgElID: 'gmpMarkersSortMsg'
			,	data: {mod: 'gmap', action: 'resortMarkers', markers_list: markersList, map_id: mapId}
			,	onSuccess: function(res) {
					
				}
			});
		}
	});
});
jQuery(window).load(function(){
	jQuery('#gmpMapRightStickyBar').width( jQuery('#gmpMapRightStickyBar').width() );
});
function gmpBindTinyMceUpdate() {
	if(!g_gmpTinyMceEditorUpdateBinded && typeof(tinyMCE) !== 'undefined' && tinyMCE.editors && tinyMCE.editors.markerDescription) {
		tinyMCE.editors.markerDescription.onKeyUp.add(function(){
			var marker = gmpGetCurrentMarker();
			if(!marker) {
				_gmpCreateNewMapMarker();
				marker = gmpGetCurrentMarker();
			}
			if(marker) {
				marker.setDescription( gmpGetTxtEditorVal('markerDescription') );
				marker.showInfoWnd();
			}
		});
		g_gmpTinyMceEditorUpdateBinded = true;
	}
}
function gmpCheckShortcode() {
	var currentId = gmpGetCurrentId();
	if(currentId) {
		jQuery('#shortcodeCode .gmpMapShortCodeShell').val('['+ gmpMapShortcode+ ' id="'+ currentId+ '"]');
		jQuery('#shortcodeCode .gmpMapPhpShortCodeShell').val('<?php echo do_shortcode(\'['+ gmpMapShortcode+ ' id="'+ currentId+ '"]\')?>');
		gmpResetCopyTextCodeFields('#shortcodeCode');
		jQuery('#shortcodeCode').slideDown( g_gmpAnimationSpeed );
		jQuery('#shortcodeNotice').slideUp( g_gmpAnimationSpeed );
	} else {
		jQuery('#shortcodeCode').hide();
		jQuery('#shortcodeNotice').show();
	}
}
function gmpGetCurrentId() {
	return parseInt( jQuery('#gmpMapForm input[name="map_opts[id]"]').val() );
}
function drawNewIcon(icon){
    if(typeof(icon.data) == undefined){
        return;
    }
    jQuery('#gmpMarkerForm input[name="marker_opts[icon]"]').val(icon.id);
    var newIcon = '<li class="previewIcon" data-id="'+ icon.id+ '" title="'+ icon.title+ '"><img src="'+ icon.url+ '"></li>';
    jQuery('ul.iconsList').append(newIcon);
    gmpSetIconImg();
}
function gmpInitIconsWnd() {
	var $container = jQuery('#gmpIconsWnd').dialog({
		modal:    true
	,	autoOpen: false
	,	width: 540
	,	height: 600
	});

	jQuery('#gmpMarkerIconBtn').click(function(){
		$container.dialog('open');
		return false;
	});
	jQuery('.previewIcon').click(function(){
		var newId = jQuery(this).data('id');
		jQuery('#gmpMarkerForm input[name="marker_opts[icon]"]').val( newId );
		gmpSetIconImg();
		var marker = gmpGetCurrentMarker();
		if(!marker) {
			_gmpCreateNewMapMarker();
			marker = gmpGetCurrentMarker();
		}
		if(marker) {
			marker.setIcon( gmpGetIconPath() );
		}
		$container.dialog('close');
		return false;
	});
    /*
     * wp media upload
     *
     */
    jQuery('#gmpUploadIconBtn').click(function(e){
        var custom_uploader;
        e.preventDefault();
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image'
            ,	button: {
                text: 'Choose Image'
            }
            ,	multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        var currentForm = jQuery(this).parents('form');
        custom_uploader.on('select', function(){
            var attachment = custom_uploader.state().get('selection').first().toJSON()
                ,	respElem = jQuery('.gmpUplRes')
                ,	sendData={
                    page: 'icons'
                    ,	action: 'saveNewIcon'
                    ,	reqType: 'ajax'
                    ,	icon: {
                        url: attachment.url
                    }
                };
            if(attachment.title != undefined){
                sendData.icon.title = attachment.title;
            }
            if(attachment.description != undefined){
                sendData.icon.description = attachment.description;
            }
            jQuery.sendFormGmp({
                msgElID: respElem
                ,	data: sendData
                ,	onSuccess: function(res){
                    if(!res.error) {
                        var newItem = drawNewIcon(res.data);
                    } else {
                        respElem.html(data.error.join(','));
                    }
                }
            });
        });
        //Open the uploader dialog
        custom_uploader.open();
    });
}
jQuery('#gmpUploadClastererIconBtn').click(function(e){
	var custom_uploader;
	e.preventDefault();
	//If the uploader object has already been created, reopen the dialog
	if (custom_uploader) {
		custom_uploader.open();
		return;
	}
	//Extend the wp.media object
	custom_uploader = wp.media.frames.file_frame = wp.media({
		title: 'Choose Image'
	,	button: {
			text: 'Choose Image'
		}
	,	multiple: false
	});
	//When a file is selected, grab the URL and set it as the text field's value
	custom_uploader.on('select', function(){
		var attachment = custom_uploader.state().get('selection').first().toJSON()
	,	iconPrevImg = jQuery('#gmpMarkerClastererIconPrevImg')
	,	width  = 53
	,	height = 'auto';

		iconPrevImg.attr('src', attachment.url);
		width = document.getElementById('gmpMarkerClastererIconPrevImg').naturalWidth;
		height = document.getElementById('gmpMarkerClastererIconPrevImg').naturalHeight;
		gmpUpdateClusterIcon(attachment.url, width, height);
	});
	//Open the uploader dialog
	custom_uploader.open();
});
jQuery('#gmpDefaultClastererIconBtn').click(function(e) {
	e.preventDefault();
	var defIconUrl = 'https://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m1.png';
	jQuery('#gmpMarkerClastererIconPrevImg').attr('src', defIconUrl);
	gmpUpdateClusterIcon(defIconUrl, 53, 52);
});
function gmpUpdateClusterIcon(url, width, height) {
	jQuery('input[name="map_opts[marker_clasterer_icon]"]').val(url);
	jQuery('input[name="map_opts[marker_clasterer_icon_width]"]').val(width);
	jQuery('input[name="map_opts[marker_clasterer_icon_height]"]').val(height);
	g_gmpMap
		.setParam('marker_clasterer_icon', url)
		.setParam('marker_clasterer_icon_width', width)
		.setParam('marker_clasterer_icon_height', height)
		.enableClasterization(g_gmpMap.getParam('marker_clasterer'));
}
function gmpSetIconImg() {
	var id = parseInt( jQuery('#gmpMarkerForm input[name="marker_opts[icon]"]').val() );
	jQuery('#gmpMarkerIconPrevImg').attr('src', jQuery('.previewIcon[data-id="'+ id+ '"] img').attr('src'));
}
function gmpGetIconPath() {
	return jQuery('#gmpMarkerIconPrevImg').attr('src');
}
function gmpSetCurrentMarker(marker) {
	g_gmpCurrentEditMarker = marker;
}
function gmpGetCurrentMarker() {
	return g_gmpCurrentEditMarker;
}
function gmpRefreshMapMarkersList(fromServer, justTable) {
	var shell = jQuery('#markerList');
	var buildListClb = function(markersList) {
		if(gmpMainMap)
			gmpMainMap.markers = markersList;
		if(!justTable) {
			gmpRefreshMapMarkers(g_gmpMap, markersList);
			var currentFormMarker = parseInt( jQuery('#gmpMarkerForm input[name="marker_opts[id]"]').val() );
			if(currentFormMarker) {
				var editMapMarker = g_gmpMap.getMarkerById(currentFormMarker);
				if(editMapMarker) {
					gmpSetCurrentMarker( editMapMarker );
					editMapMarker.showInfoWnd();
				}
			}
		}
		//g_gmpMap.setMarkersParams( markersList );
		shell.find('.gmpMapMarkerRow:not(#markerRowTemplate)').remove();
		if(markersList && markersList.length) {
			for(var i = 0; i < markersList.length; i++) {
				var newRow = jQuery('#markerRowTemplate').clone();
				newRow.find('.egm-marker-icon img').attr('src', markersList[i].icon_data.path);
				newRow.find('.egm-marker-title').html(markersList[i].title);
				newRow.find('.egm-marker-latlng').html(parseFloat(markersList[i].coord_x).toFixed(2)+ '"N '+ parseFloat(markersList[i].coord_y).toFixed(2)+ '"E');
				newRow.data('id', markersList[i].id);
				newRow.find('.egm-marker-edit').click(function(){
					var markerRow = jQuery(this).parents('.gmpMapMarkerRow:first');
					gmpOpenMarkerEdit( markerRow.data('id') );
					return false;
				});
				newRow.find('.egm-marker-remove').click(function(){
					var markerRow = jQuery(this).parents('.gmpMapMarkerRow:first');
					gmpRemoveMarkerFromMapTblClick(markerRow.data('id'), {row: markerRow});
					return false;
				});
				newRow.removeAttr('id').show();
				shell.append( newRow );
			}
		}
		_gmpResizeRightSidebar();
	};
	if(fromServer) {
		shell.find('.egm-marker').css('opacity', '0.5');
		shell.addClass('supsystic-inline-loader');
		var currentMapId = gmpGetCurrentId();
		jQuery.sendFormGmp({
			data: {mod: 'marker', action: 'getMapMarkers', map_id: (currentMapId ? currentMapId : 0), 'added_marker_ids': g_gmpMapMarkersIdsAdded}
		,	onSuccess: function(res) {
				if(!res.error) {
					shell.find('.egm-marker').css('opacity', '1');
					shell.removeClass('supsystic-inline-loader');
					buildListClb( res.data.markers );
				}
			}
		});
	} else {
		if(gmpMainMap)
			buildListClb( gmpMainMap.markers );
	}
}
function gmpOpenMarkerEdit(id) {
	gmpOpenMarkerForm();
	var marker = g_gmpMap.getMarkerById( id );
	if(marker) {
		var markerParams = marker.getRawMarkerParams();
		jQuery('#gmpMarkerForm input[name="marker_opts[title]"]').val( markerParams.title );
		gmpSetTxtEditorVal('markerDescription', markerParams.description);
		jQuery('#gmpMarkerForm input[name="marker_opts[icon]"]').val( markerParams.icon_data.id );
		jQuery('#gmpMarkerForm input[name="marker_opts[address]"]').val( markerParams.address );
		jQuery('#gmpMarkerForm input[name="marker_opts[coord_x]"]').val( markerParams.coord_x );
		jQuery('#gmpMarkerForm input[name="marker_opts[coord_y]"]').val( markerParams.coord_y );
		jQuery('#gmpMarkerForm select[name="marker_opts[marker_group_id]"]').val(markerParams.marker_group_id);
		jQuery('#gmpMarkerForm input[name="marker_opts[id]"]').val( markerParams.id );
		if(markerParams.params.show_description == 1){
			jQuery('#gmpMarkerForm input[name="marker_opts[params][show_description]"]').prop('checked', true);
			gmpCheckUpdate( jQuery('#gmpMarkerForm input[name="marker_opts[params][show_description]"]') );
		}
		if(markerParams.params.marker_link == 1){
			jQuery('#gmpMarkerForm input[name="marker_opts[params][marker_link]"]').prop('checked', true);
			gmpCheckUpdate( jQuery('#gmpMarkerForm input[name="marker_opts[params][marker_link]"]') );
			jQuery('#gmpMarkerForm input[name="marker_opts[params][marker_link_src]"]').val( markerParams.params.marker_link_src );
			if(markerParams.params.marker_link_new_wnd == 1){
				jQuery('#gmpMarkerForm input[name="marker_opts[params][marker_link_new_wnd]"]').prop('checked', true);
				gmpCheckUpdate( jQuery('#gmpMarkerForm input[name="marker_opts[params][marker_link_new_wnd]"]') );
			}
		}
		if(markerParams.params.description_mouse_hover == 1) {
			jQuery('#gmpMarkerForm input[name="marker_opts[params][description_mouse_hover]"]').prop('checked', true);
			gmpCheckUpdate( jQuery('#gmpMarkerForm input[name="marker_opts[params][description_mouse_hover]"]') );
		}
		gmpAddLinkOptions();
		gmpSetIconImg();
		gmpSetCurrentMarker( marker );
		marker.showInfoWnd();
	}
}
function gmpRemoveMarkerFromMapTblClick(markerId, params) {
	params = params || {};
	var markerTitle = params.row ? params.row.find('.egm-marker-title').text() : ''
	,	btn = params.row ? params.row : params.btn;
	if(!confirm('Remove "'+ markerTitle+ '" marker?')) {
		return false;
	}
	if(markerId == ''){
		return false;
	}
	jQuery.sendFormGmp({
		btn: btn
	,	data: {action: 'removeMarker', mod: 'marker', id: markerId}
	,	onSuccess: function(res) {
			if(!res.error){
				if(params.row) {
					params.row.slideUp(g_gmpAnimationSpeed, function(){
						params.row.remove();
					});
				}
				g_gmpMap.removeMarker( markerId );
				gmpRefreshMapMarkersList( true );
				var currentEditMarkerId = parseInt( jQuery('#gmpMarkerForm input[name="marker_opts[id]"]').val() );
				if(currentEditMarkerId && currentEditMarkerId == markerId) {
					gmpResetMarkerForm();
					//gmpHideMarkerForm();
				}
			}
		}
	});
}
function gmpOpenMarkerForm() {
	gmpShowMarkerForm();
	gmpResetMarkerForm();
}
function gmpHideMarkerForm() {
	var markerFormIsVisible = jQuery('#gmpMarkerForm').is(':visible');
	if(markerFormIsVisible) {
		jQuery('#gmpSaveMarkerBtn').hide( g_gmpAnimationSpeed );
		jQuery('#gmpAddNewMarkerBtn').animate({
			width: '100%'
		}, g_gmpAnimationSpeed);
		jQuery('#gmpMarkerForm').slideUp( g_gmpAnimationSpeed );
	}
}
function gmpShowMarkerForm() {
	var markerFormIsVisible = jQuery('#gmpMarkerForm').is(':visible');
	if(!markerFormIsVisible) {
		jQuery('#gmpMapMarkerTabs').wpTabs('activate', '#gmpMarkerTab');
	}
}
function gmpResetMarkerForm() {
	jQuery('#gmpMarkerForm')[0].reset();
	jQuery('#gmpMarkerForm input[name="marker_opts[id]"]').val('');
	jQuery('#gmpMarkerForm input[name="marker_opts[icon]"]').val( 1 );
	jQuery('#gmpMarkerForm input[name="marker_opts[params][show_description]"]').prop('checked', false);
	gmpCheckUpdate( jQuery('#gmpMarkerForm input[name="marker_opts[params][show_description]"]') );
	jQuery('#gmpMarkerForm input[name="marker_opts[params][marker_link]"]').prop('checked', false);
	gmpCheckUpdate( jQuery('#gmpMarkerForm input[name="marker_opts[params][marker_link]"]') );
	jQuery('#gmpMarkerForm input[name="marker_opts[params][marker_link_new_wnd]"]').prop('checked', false);
	gmpCheckUpdate( jQuery('#gmpMarkerForm input[name="marker_opts[params][marker_link_new_wnd]"]') );
	jQuery('#gmpMarkerForm input[name="marker_opts[params][description_mouse_hover]"]').prop('checked', false);
	gmpCheckUpdate( jQuery('#gmpMarkerForm input[name="marker_opts[params][description_mouse_hover]"]') );
	gmpSetIconImg();
	gmpAddLinkOptions();
}
function _gmpMarkerDragEndClb() {
	var currentMarkerIdInForm = g_gmpCurrentEditMarker ? g_gmpCurrentEditMarker.getId() : 0
	,	draggedId =  this.getId();
	if((currentMarkerIdInForm && currentMarkerIdInForm == draggedId) || (!currentMarkerIdInForm && !draggedId)) {
		jQuery('#gmpMarkerForm input[name="marker_opts[coord_x]"]').val( this.lat() );
		jQuery('#gmpMarkerForm input[name="marker_opts[coord_y]"]').val( this.lng() );
	}
	if(draggedId) {	// Just save it in database
		jQuery.sendFormGmp({
			data: {mod: 'marker', action: 'updatePos', id: draggedId, lat: this.lat(), lng: this.lng()}
		,	onSuccess: function(res) {
				if(!res.error) {
					gmpRefreshMapMarkersList( true );
				}
			}
		});
	}
}
// Markers form check change actions
function _gmpIsMarkerFormChanged() {
	return g_gmpMarkerFormChanged;
}
function _gmpChangeMarkerForm() {
	g_gmpMarkerFormChanged = true;
}
function _gmpUnchangeMarkerForm() {
	g_gmpMarkerFormChanged = false;
}
// Map form check change actions
function _gmpIsMapFormChanged() {
	return g_gmpMapFormChanged;
}
function _gmpChangeMapForm() {
	g_gmpMapFormChanged = true;
}
function _gmpUnchangeMapForm() {
	g_gmpMapFormChanged = false;
}
function gmpInitMapMarkersListWnd() {
	var wndWidth = jQuery(window).width()
	,	wndHeight = jQuery(window).height()
	,	normWidth = 740
	,	normHeight = 540
	,	popupWidth = wndWidth > normWidth ? normWidth : wndWidth - 20
	,	popupHeight = wndHeight < normHeight ? normHeight : wndHeight - 70;
	jQuery('#gmpMarkersListWnd').find('.gmpMmlElement').css('max-width', popupWidth - 20);
	var $markersListWnd = jQuery('#gmpMarkersListWnd').dialog({
		modal:    true
	,	autoOpen: false
	,	width: popupWidth
	,	height: popupHeight
	,	open: function() {
			jQuery('.ui-widget-overlay').bind('click', function() {
				$markersListWnd.dialog('close');
			});
		}
	});
	jQuery('#gmpMapMarkersListBtn').click(function(){
		$markersListWnd.dialog('open');
		return false;
	});
	if(!GMP_DATA.isPro) {
		jQuery('.gmpMmlElement').click(function(){
			var url = jQuery(this).find('.gmpMmlApplyBtn').attr('href');
			window.open( url );
			return false;
		});
	}
}
function gmpRefreshMapMarkers(map, markers) {
	map.clearMarkers();
	markers = _gmpPrepareMarkersListAdmin( markers );
	for(var i in markers) {
		var newMarker = map.addMarker( markers[i] );
		newMarker.setTitle( markers[i].title, true );
		newMarker.setDescription( markers[i].description );
	}
	map.markersRefresh();
}
function _gmpPrepareMarkersListAdmin(markers) {
	return _gmpPrepareMarkersList(markers, {
		dragend: _gmpMarkerDragEndClb
	});
}
function _gmpResizeRightSidebar() {
	var wndHt = jQuery(window).height()
	,	rightBarHt = jQuery('#gmpMapRightStickyBar').outerHeight()
	,	rightBarTop = parseInt(jQuery('#gmpMapRightStickyBar').css('top'));
	if(!rightBarTop) {
		var rightBarPos = jQuery('#gmpMapRightStickyBar').offset();
		wndHt -= rightBarPos.top + 32;
	}
	if(rightBarHt > wndHt) {
		jQuery('#markerList').css('overflow', 'scroll');
		var minMapHt = 250
		,	minMarkersTblHt = 236
		,	d = rightBarHt - wndHt
		,	mListHt = jQuery('#markerList').outerHeight()
		,	mapPreviewHt = jQuery('#gmpMapPreview').outerHeight();
		if(mListHt - d >= minMarkersTblHt) {	// Try to minimazi it using just markers list
			jQuery('#markerList').height( mListHt - d );
			return;
		}
		var canDecreaseMList = mListHt - minMarkersTblHt;
		if(canDecreaseMList > 0) {
			jQuery('#markerList').css('height', mListHt - canDecreaseMList);
			d -= canDecreaseMList;
		}
		if(d <= 0) return;
		
		if(mapPreviewHt - d >= minMapHt) {
			jQuery('#gmpMapPreview').height( mapPreviewHt - d );
			return;
		}
		var canDecreaseMapPrev = mapPreviewHt - minMapHt;
		if(canDecreaseMapPrev > 0) {
			jQuery('#gmpMapPreview').height( mapPreviewHt - canDecreaseMapPrev );
			d -= canDecreaseMapPrev;
		}
		if(d <= 0) return;
	}
}
function _gmpCreateNewMapMarker(params) {
	params = params || {};
	var newMarkerData = {
		icon: gmpGetIconPath()
	,	draggable: true
	,	dragend: _gmpMarkerDragEndClb
	};
	var lat = 0
	,	lng = 0;
	if(params.coord_x && params.coord_y) {
		newMarkerData.coord_x = lat = parseFloat( params.coord_x );
		newMarkerData.coord_y = lng = parseFloat( params.coord_y );
	} else {
		var mapCenter = g_gmpMap.getCenter();
		newMarkerData.position = mapCenter;
		lat = mapCenter.lat();
		lng = mapCenter.lng();
	}
	gmpSetCurrentMarker( g_gmpMap.addMarker( newMarkerData ) );
	jQuery('#gmpMarkerForm [name="marker_opts[coord_x]"]').val( lat );
	jQuery('#gmpMarkerForm [name="marker_opts[coord_y]"]').val( lng );
}
function wpColorPicker_map_optsmarker_title_color_change(event, ui) {
	g_gmpMarkerTitleColorLast = ui.color.toString();
	if(!g_gmpMarkerTitleColorTimeoutSet) {
		setTimeout(function(){
			gmpWpColorpickerUpdatTitlesColor();
		}, 500);
		g_gmpMarkerTitleColorTimeoutSet = true;
	}
}
function gmpWpColorpickerUpdatTitlesColor(color) {
	g_gmpMarkerTitleColorTimeoutSet = false;
	var styleObj = jQuery('#gmpHardcodeMapTitleStl');
	if(!styleObj || !styleObj.size()) {
		styleObj = jQuery('<style type="text/css" id="gmpHardcodeMapTitleStl" />').appendTo('head');
	}
	styleObj.html('.gmpInfoWindowtitle { color: '+ g_gmpMarkerTitleColorLast+ ' !important; }');
}
function gmpAddLinkOptions() {
	var markerLink = jQuery('#marker_link').prop('checked');
	if (markerLink) {
		jQuery('#link_options').css('display', 'inline');
	} else {
		jQuery('#link_options').css('display', 'none');
	}
}
function gmpAddCustomControlsOptions() {
	var customMapControls = jQuery('#map_optsenable_custom_map_controls_check').prop('checked');
	if (customMapControls) {
		jQuery('#custom_controls_options').css('display', 'block');
	} else {
		jQuery('#custom_controls_options').css('display', 'none');
	};
}
function gmpSwitchClustererIconView(clusterType) {
	if (clusterType == 'none') {
		jQuery('#gmpMarkerClastererIcon').hide();
	} else {
		jQuery('#gmpMarkerClastererIcon').show();
	}
}
function wpColorPicker_map_optscustom_controls_bg_color_change(event, ui) {
	if(!GMP_DATA.isPro) {
		jQuery('#gmpMapForm [name="map_opts[custom_controls_bg_color]"]').trigger('change');
	}
}
function wpColorPicker_map_optscustom_controls_txt_color_change(event, ui) {
	if(!GMP_DATA.isPro) {
		jQuery('#gmpMapForm [name="map_opts[custom_controls_txt_color]"]').trigger('change');
	}
}
function wpColorPicker_map_optsmarker_infownd_bg_color_change(event, ui) {
	var color = ui.color.toString();
	if(!g_gmpMarkerBgColorTimeoutSet) {
		setTimeout(function(){
			//Set param anyway for info window preview, opened before new marker will be saved
			g_gmpMap.setParam('marker_infownd_bg_color', color);

			//Get all map markers
			var allMapMarkers = g_gmpMap.getAllMarkers();
			//If map has no markers - return
			if(!allMapMarkers) return;
			//If markers exist - call callback to change info window bg color (it does not depend from marker id)
			allMapMarkers[0]._changeMarkerInfoWndBgColor(g_gmpMap);
		}, 500);
		g_gmpMarkerBgColorTimeoutSet = true;
	}
}
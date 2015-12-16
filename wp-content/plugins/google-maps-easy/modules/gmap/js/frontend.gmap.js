var g_gmlAllMaps = [];
jQuery(document).ready(function(){
	if(typeof(gmpAllMapsInfo) !== 'undefined' && gmpAllMapsInfo && gmpAllMapsInfo.length) {
		for(var i = 0; i < gmpAllMapsInfo.length; i++) {
			if(jQuery('#'+ gmpAllMapsInfo[i].view_html_id).size()) {
				gmpInitMapOnPage( gmpAllMapsInfo[i] );
			}
		}
	}
});
function gmpInitMapOnPage(mapData) {
	var newMap = new gmpGoogleMap('#'+ mapData.view_html_id, mapData.params);
	if(mapData.markers && mapData.markers.length) {
		mapData.markers = _gmpPrepareMarkersList( mapData.markers );
		for(var j = 0; j < mapData.markers.length; j++) {
			var newMarker = newMap.addMarker( mapData.markers[j] );
			newMarker.setTitle( mapData.markers[j].title, true );
			newMarker.setDescription( mapData.markers[j].description );
		}
		newMap.markersRefresh();
	}
	g_gmlAllMaps.push( newMap );
}
function gmpGetMapInfoById(id) {
	if(typeof(gmpAllMapsInfo) !== 'undefined' && gmpAllMapsInfo && gmpAllMapsInfo.length) {
		id = parseInt(id);
		for(var i = 0; i < gmpAllMapsInfo.length; i++) {
			if(gmpAllMapsInfo[i].id == id) {
				return gmpAllMapsInfo[i];
			}
		}
	}
	return false;
}
function gmpGetMapInfoByViewId(viewId) {
	if(typeof(gmpAllMapsInfo) !== 'undefined' && gmpAllMapsInfo && gmpAllMapsInfo.length) {
		for(var i = 0; i < gmpAllMapsInfo.length; i++) {
			if(gmpAllMapsInfo[i].view_id == viewId) {
				return gmpAllMapsInfo[i];
			}
		}
	}
	return false;
}
function gmpGetAllMaps() {
	return g_gmlAllMaps;
}
function gmpGetMapById(id) {
	var allMaps = gmpGetAllMaps();
	for(var i = 0; i < allMaps.length; i++) {
		if(allMaps[i].getId() == id) {
			return allMaps[i];
		}
	}
	return false;
}
function gmpGetMapByViewId(viewId) {
	var allMaps = gmpGetAllMaps();
	for(var i = 0; i < allMaps.length; i++) {
		if(allMaps[i].getViewId() == viewId) {
			return allMaps[i];
		}
	}
	return false;
}
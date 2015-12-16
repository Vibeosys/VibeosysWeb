var g_gmpMarkerGroupFormChanged = false

window.onbeforeunload = function(){
	// If there are at lease one unsaved form - show message for confirnation for page leave
	if(_gmpIsMarkerGroupFormChanged()) {
		return 'You have unsaved changes in Marker Category form. Are you sure want to leave this page?';
	}
};
jQuery(document).ready(function() {
	function gmpGetCurrentId() {
		return parseInt( jQuery('#gmpMgrForm input[name="marker_group[id]"]').val() );
	}
	// Map saving form
	jQuery('#gmpMgrForm').submit(function () {
		var currentId = gmpGetCurrentId(), firstTime = currentId ? false : true;

		jQuery(this).sendFormGmp({
			btn: '#gmpMgrSaveBtn'
			, onSuccess: function (res) {
				if (!res.error) {
					if (res.data.marker_group_id) {
						jQuery('#gmpMgrForm input[name="marker_group[id]"]').val(res.data.marker_group_id);
					}
					if (firstTime) {
						 if (res.data.edit_url) {
						 setBrowserUrl( res.data.edit_url );
						 jQuery('.supsystic-main-navigation-list li').removeClass('active');
						 jQuery('.supsystic-main-navigation-list li[data-tab-key="marker_groups"]').addClass('active');
						 }
						gmpMarkerGroup = res.data.marker_group;
					}
					_gmpUnchangeMarkerGroupForm();
					jQuery('#addMarkerGroup').show();
				}
			}
		});
		return false;
	});
	jQuery('#gmpMgrSaveBtn').click(function () {
		jQuery('#gmpMgrForm').submit();
		return false;
	});
	jQuery('#gmpMgrForm').find('input').change(function(){
		_gmpChangeMarkerGroupForm();
	});
});
// Marker Group form check change actions
function _gmpIsMarkerGroupFormChanged() {
	return g_gmpMarkerGroupFormChanged;
}
function _gmpChangeMarkerGroupForm() {
	g_gmpMarkerGroupFormChanged = true;
}
function _gmpUnchangeMarkerGroupForm() {
	g_gmpMarkerGroupFormChanged = false;
}
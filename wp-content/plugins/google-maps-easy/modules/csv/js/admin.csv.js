var gmpCsvImportData = {};
jQuery(document).ready(function(){
	jQuery('#gmpCsvExportMapsBtn').click(function(){
		toeRedirect(createAjaxLinkGmp({
			page: 'csv'
		,	action: 'exportMaps'
		,	withMarkers: 1
		}));
		return false;
	});
	jQuery('#gmpCsvExportMarkersBtn').click(function(){
		toeRedirect(createAjaxLinkGmp({
			page: 'csv'
		,	action: 'exportMarkers'
		}));
		return false;
	});
	jQuery('#gmpCsvImportMarkersBtn').on('click', function () {
		jQuery('input[name="csv_import_file"]').click();
	});
});
function gmpCsvImportOnSubmit() {
    //jQuery('#gmpCsvImportMsg').showLoaderGmp();
    //jQuery('#gmpCsvImportMsg').removeClass('toeErrorMsg');
    //jQuery('#gmpCsvImportMsg').removeClass('toeSuccessMsg');
	//gmpCsvImportData['overwrite_same_names'] = jQuery('#gmpCsvOverwriteSameNames').attr('checked') ? 1 : 0;
}
function gmpCsvImportOnComplete(file, res) {
	toeProcessAjaxResponseGmp(res, 'gmpCsvImportMsg');
}
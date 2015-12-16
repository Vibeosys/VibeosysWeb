<section>
	<div class="supsystic-item supsystic-panel">
		<div id="containerWrapper">
			<table class="form-table">
				<tbody>
				<tr>
					<th scope="row">
						<label>
							<?php _e('Maps', GMP_LANG_CODE); ?>
						</label>
					</th>
					<td>
						<button id="gmpCsvExportMapsBtn" class="button">
							<?php _e('Export', GMP_LANG_CODE); ?>
						</button>
						<?php echo htmlGmp::ajaxfile('csv_import_file_maps', array(
							'url' => uriGmp::_(array('baseUrl' => admin_url('admin-ajax.php'), 'page' => 'csv', 'action' => 'import', 'type' => 'maps', 'reqType' => 'ajax')),
							'data' => 'gmpCsvImportData',
							'buttonName' => __('Import', GMP_LANG_CODE),
							'responseType' => 'json',
							'onSubmit' => 'gmpCsvImportOnSubmit',
							'onComplete' => 'gmpCsvImportOnComplete',
							'btn_class' => 'button',
						))?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="gmpCsvExportMarkersBtn">
							<?php _e('Markers', GMP_LANG_CODE); ?>
						</label>
					</th>
					<td>
						<button id="gmpCsvExportMarkersBtn" class="button">
							<?php _e('Export', GMP_LANG_CODE); ?>
						</button>
						<?php echo htmlGmp::ajaxfile('csv_import_file_markers', array(
							'url' => uriGmp::_(array('baseUrl' => admin_url('admin-ajax.php'), 'page' => 'csv', 'action' => 'import', 'type' => 'markers', 'reqType' => 'ajax')),
							'data' => 'gmpCsvImportData',
							'buttonName' => __('Import', GMP_LANG_CODE),
							'responseType' => 'json',
							'onSubmit' => 'gmpCsvImportOnSubmit',
							'onComplete' => 'gmpCsvImportOnComplete',
							'btn_class' => 'button',
						))?>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</section>
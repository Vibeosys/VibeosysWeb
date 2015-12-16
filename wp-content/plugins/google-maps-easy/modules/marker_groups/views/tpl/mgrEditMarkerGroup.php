<section>
	<div class="supsystic-item supsystic-panel">
		<div id="containerWrapper">
			<div id="gmpMgrTab" class="mgrTabContent">
				<a
					href="<?php echo $this->addNewLink?>"
					class="button button-table-action"
					id="addMarkerGroup"
					style="display: <?php echo $this->editMarkerGroup ? 'inline-block;' : 'none;'?>"
				>
					<?php _e('Add Category', GMP_LANG_CODE)?>
				</a>
				<form id="gmpMgrForm">
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="marker_group_title">
									<?php _e('Marker Category', GMP_LANG_CODE)?>:
								</label>
							</th>
							<td>
								<?php echo htmlGmp::text('marker_group[title]', array(
									'value' => $this->editMarkerGroup ? $this->marker_group['title'] : '',
									'attrs' => 'style="width: 60%;" id="marker_group_title"',
									'required' => true))?>
								<button class="button" id="gmpMgrSaveBtn">
									<i class="fa fa-save"></i>
									<?php _e('Save', GMP_LANG_CODE)?>
								</button>
							</td>
						</tr>
					</table>
					<?php echo htmlGmp::hidden('mod', array('value' => 'marker_groups'))?>
					<?php echo htmlGmp::hidden('action', array('value' => 'save'))?>
					<?php echo htmlGmp::hidden('marker_group[id]', array('value' => $this->editMarkerGroup ? $this->marker_group['id'] : ''))?>
				</form>
			</div>
		</div>
	</div>
</section>
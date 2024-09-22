<form method="post" action="<?php echo esc_attr(admin_url('/admin-ajax.php')); ?>">
	<input type="hidden" name="action" value="admin-gravity-forms">
    <?php wp_nonce_field( esc_attr(SPDSGVOGravityFormsAction::getActionName()). '-nonce' ); ?>

	<h1><?php _e('Gravity Forms','shapepress-dsgvo')?></h1>

	<p><?php _e('With these settings the saving behavior of Gravity Forms can be configured.','shapepress-dsgvo')?></p>

	<hr>

	<table class="lw-form-table">
		<tbody>
			<tr>
				<th scope="row"><?php _e('Do not save form data in the database','shapepress-dsgvo')?></th>
				<td><label for="gf_save_no_data"> <input name="gf_save_no_data"
						type="checkbox" id="gf_save_no_data" value="1"
						<?php echo esc_attr((SPDSGVOSettings::get('gf_save_no_data') === '1')? ' checked ' : '');  ?>>
				</label> <span class="info-text"><?php _e('If activated, no data will be stored, but only sent by e-mail. (Note: This option overrides form-specific settings).).','shapepress-dsgvo')?></span></td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Do not save IP address and user agent in database','shapepress-dsgvo')?></th>
				<td><label for="gf_no_ip_meta"> <input name="gf_no_ip_meta"
						type="checkbox" id="gf_no_ip_meta" value="1"
						<?php echo esc_attr((SPDSGVOSettings::get('gf_no_ip_meta') === '1')? ' checked ' : '');  ?>>
				</label> <span class="info-text"><?php _e('By default, if this checkbox is checked, this will be prevented from saving the IP address and user agent of the sender.','shapepress-dsgvo')?></span></td>
			</tr>

		</tbody>
	</table>

	<?php $gf_save_no_ = SPDSGVOSettings::get('gf_save_no_');?>

	<div>

		<h2><?php _e('Specific form settings','shapepress-dsgvo')?></h2>
		<h4><?php _e('For each Gravity Forms form, it can be subsequently defined for each field whether the data of the input field is stored in the database or not.','shapepress-dsgvo')?></h4>
		<table class="lw-form-table ">
			<tbody>
				<?php foreach( SPDSGVOGravityFormsTab::get_gf_forms() as $form ) :?>
				<tr>
					<th scope="row">Form: <?php echo esc_html($form['title']);?></th>
					<td>
							<?php foreach( $form['fields'] as $field ): ?>

								<input type="checkbox" id="" value="1"
						name="gf_save_no_[<?php echo esc_attr($form['id']);?>][<?php echo esc_attr($field->id);?>]"
						<?php echo esc_attr((isset( $gf_save_no_[$form['id']][$field->id] ) && $gf_save_no_[$form['id']][$field->id] === '1')? ' checked ' : '');  ?>> <?php echo esc_html($field->label); ?> <small><em>(<?php _e('Nicht in der Datenbank speichern.','shapepress-dsgvo'); ?>)</em></small>

						<?php endforeach; ?>
					</td>
				</tr>
				<?php endforeach; ?>

			</tbody>
		</table>
	</div>
	<hr>

    <?php submit_button(); ?>
</form>

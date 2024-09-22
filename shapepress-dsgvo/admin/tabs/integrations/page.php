<h1><?php _e('Integrations', 'shapepress-dsgvo'); ?></h1>
<hr>

<form method="post" action="<?php echo esc_attr(SPDSGVOIntegrationsAction::formURL()); ?>">
	<input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOIntegrationsAction::getActionName()) ?>">
    <?php wp_nonce_field( esc_attr(SPDSGVOIntegrationsAction::getActionName()). '-nonce' ); ?>

	<table class="lw-form-table">
		<tbody>

			<?php $integrations = SPDSGVOIntegration::getAllIntegrations(FALSE); ?>
			<?php if(count($integrations) === 0): ?>

				<tr>
					<th scope="row"><?php _e('No integrations installed','shapepress-dsgvo')?></th>
					<td></td>
				</tr>

			<?php else: ?>

				<?php foreach($integrations as $key => $integration): ?>

					<tr>
						<th scope="row"><?php echo esc_html($integration->title); ?></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text">
									<span><?php echo esc_html($integration->title); ?></span>
								</legend>

								<label for="<?php echo esc_attr($integration->slug); ?>">
									<input name="integrations[<?php echo esc_attr($integration->slug) ?>]" type="checkbox" id="<?php echo esc_attr($integration->slug); ?>" value="1" <?php echo esc_attr((SPDSGVOIntegration::isEnabled($integration->slug))? ' checked ' : '');  ?>>
								</label>
							</fieldset>
						</td>
					</tr>

				<?php endforeach; ?>
			<?php endif; ?>

		</tbody>
	</table>

	<?php submit_button(); ?>
</form>

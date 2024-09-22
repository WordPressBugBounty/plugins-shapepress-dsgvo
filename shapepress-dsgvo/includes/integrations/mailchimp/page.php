<h1 class="module-title"><?php _e('Mailchimp', 'shapepress-dsgvo') ?></h1>
<form method="post" action="<?php echo esc_url(SPDSGVOMailchimpIntegration::formURL()) ?> ">
	<input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOMailchimpIntegration::action()) ?>">

	<table class="lw-form-table wpk-main-design--one-table wpk-main-design--margin-top">
		<tbody>	
			<tr>
				<td scope="row" style="width: 150px"><label for="mailchimp_api_token"><?php _e('Mailchimp API Key','shapepress-dsgvo')?></label></td>
				<td>
					<input name="mailchimp_api_token" type="text" id="mailchimp_api_token" aria-describedby="admin-email-description" value="<?php echo esc_attr(get_option('mailchimp_api_token')); ?>" class="regular-text ltr">
					<p class="description" id="admin-email-description">
						<a href="https://kb.mailchimp.com/integrations/api-integrations/about-api-keys" target="_blank"><?php _e('Click here','shapepress-dsgvo')?> </a> 
						<?php _e('to get an API key','shapepress-dsgvo')?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>

	<?php submit_button(); ?>
</form>

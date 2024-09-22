<?php

function SPDSGVOUnsubscribeShortcode($atts){

    $firstName = '';
    $lastName  = '';
    $email     = '';

    if(is_user_logged_in()){
        $firstName = wp_get_current_user()->user_firstname;
        $lastName  = wp_get_current_user()->user_lastname;
        $email     = wp_get_current_user()->user_email;
    }      

    ob_start();
    ?>  
        <?php if(isset($_REQUEST['result']) && (sanitize_text_field($_REQUEST['result'])) === 'success'): ?>

            <p class="sp-dsgvo us-success-message"><?php _e('Request sent successfully. You will receive an email in a few minutes.','shapepress-dsgvo')?></p>

        <?php elseif(isset($_REQUEST['result']) && sanitize_text_field($_REQUEST['result']) === 'confirmed'): ?>

			<p class="sp-dsgvo us-success-message"><?php _e('Request successfully completed. Your data has been completely deleted.','shapepress-dsgvo')?></p>

        <?php else: ?>
        <div class="sp-dsgvo sp-unsubsribe-form">
            <form method="post" action="<?php echo esc_url(SPDSGVOSuperUnsubscribeFormAction::url()) ?>" >
                <?php wp_nonce_field( esc_attr(SPDSGVOSuperUnsubscribeFormAction::getActionName()). '-nonce' ); ?>
                <fieldset>
                    <div class="lwb-row">
                        <div class="lwb-col-3">
                            <label style="min-width:100px;" for="email-field"><?php _e('First name','shapepress-dsgvo')?></label>
                        </div>
                        <div class="lwb-col-6">
                            <input class="w-100" required type="text" id="first-name-field" name="first_name" value="<?php echo esc_attr($firstName) ?>" placeholder="<?php _e('First name','shapepress-dsgvo')?>" spellcheck="false" />
                        </div>


                    </div>
                    <div class="lwb-row">
                        <div class="lwb-col-3">
                            <label for="email-field"><?php _e('Last name','shapepress-dsgvo')?></label>
                        </div>
                        <div class="lwb-col-6">
                            <input class="w-100" required type="text" id="last-name-field" name="last_name" value="<?php echo esc_attr($lastName) ?>" placeholder="<?php _e('Last name','shapepress-dsgvo')?>" spellcheck="false" />
                        </div>
                    </div>

					<div class="lwb-row">
                        <div class="lwb-col-3">
                            <label for="email-field"><?php _e('Email','shapepress-dsgvo')?></label>
                        </div>
						<div class="lwb-col-6">
                   			 <input class="w-100" required type="email" id="email-field" name="email" value="<?php echo esc_attr($email) ?>" placeholder="<?php _e('Email','shapepress-dsgvo')?>" spellcheck="false" />
						</div>
                    </div>
                    <div class="lwb-row form-row-website-cap">
                        <div class="lwb-col-3">
                            <label for="email-field"><?php _e('Website','shapepress-dsgvo')?></label>
                        </div>
                        <div class="lwb-col-6">
                            <input class="w-100" type="text" id="website" name="website" value="" placeholder="" spellcheck="false" />
                        </div>
                    </div>
                    <div class="lwb-row">
						<div class="lwb-col">
                    		<label for="dsgvo-checkbox">
                   			 	<input required type="checkbox" id="dsgvo-checkbox" name="dsgvo_checkbox" value="1" />
                                <?php
                                $accept_text = convDeChars(SPDSGVOSettings::get('su_dsgvo_accepted_text'));
                                ?>
                   			 	<span style="font-weight:normal"><?php echo esc_html($accept_text);  ?></span>
                   			 </label>
						</div>
                    </div>
                    <br>
                    <input type="submit" value="<?php _e('Create delete request','shapepress-dsgvo')?>" />
                </fieldset>
            </form>
        </div>
        <?php endif; ?>
    <?php

    return ob_get_clean();
}

add_shortcode('unsubscribe_form', 'SPDSGVOUnsubscribeShortcode');
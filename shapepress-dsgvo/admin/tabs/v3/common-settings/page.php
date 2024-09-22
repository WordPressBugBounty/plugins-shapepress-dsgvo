<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

?>
<!--
<h1 class="module-title"><?php _e(SPDSGVOCommonSettingsTab::getTabTitle(), 'shapepress-dsgvo') ?></h1>
-->

<div class="card-columns">

    <!-- licensing -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Licensing', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <h6 class="card-subtitle mb-2"><?php _e('Activate Premium Version', 'shapepress-dsgvo') ?></h6>

            <form method="post" action="<?php echo esc_attr(admin_url('/admin-ajax.php')); ?>" style="display: inline">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOCommonSettingsActivateAction::getActionName()); ?>">
                <?php wp_nonce_field(esc_attr(SPDSGVOCommonSettingsActivateAction::getActionName()) . '-nonce'); ?>

                <div class="form-group">
                    <label for="exampleInputEmail1"><?php _e('License', 'shapepress-dsgvo') ?></label>
                    <input type="text" class="form-control" id="dsgvo_licence" name="dsgvo_licence" aria-describedby="licenseHelp"
                           placeholder="<?php _e('Enter License Number', 'shapepress-dsgvo'); ?>"
                           <?php echo esc_attr(SPDSGVOSettings::get('license_activated') === '1' ? 'readonly' : '');?>
                           value="<?php echo esc_attr(SPDSGVOSettings::get('dsgvo_licence')); ?>">
                    <small id="licenseHelp" class="form-text text-muted"><?php _e('An activated license unlocks all features.', 'shapepress-dsgvo'); ?></small>
                </div>
                <div class="form-group">
                    <?php if (SPDSGVOSettings::get('license_activated') === '1'): ?>
                        <input type="submit" class="btn btn-primary btn-block"
                               value="<?php _e('Deactivate license', 'shapepress-dsgvo') ?>"/>
                    <?php else: ?>
                        <input type="submit" class="btn btn-primary btn-block"
                               value="<?php _e('Activate license', 'shapepress-dsgvo') ?>"/>
                        <span class="info-text"><?php _e('Activating the license unlocks more features.', 'shapepress-dsgvo'); ?></span>
                    <?php endif; ?>
                </div>

            </form>
            <form method="post" action="<?php echo esc_attr(admin_url('/admin-ajax.php')); ?>" style="display: inline">
                <div class="form-group">
                    <input type="hidden" name="action"
                           value="<?php echo esc_attr(SPDSGVOCommonSettingsValidateLicenseAction::getActionName()); ?>">
                    <input type="submit" class="btn btn-secondary btn-block"
                           value="<?php esc_attr_e('Refresh license', 'shapepress-dsgvo') ?>"/>
                </div>
            </form>
            <div>
                <?php if (SPDSGVOSettings::get('license_activated') === '1'): ?>
                    <div style="font-weight:500">
                        <?php if (isPremiumEdition()): ?>
                            <?php echo wp_kses_post(isValidPremiumEdition() ? _e('Premium version has been activated', 'shapepress-dsgvo') : ('<span style ="color: red;">' . __('Invalid or expired license.', 'shapepress-dsgvo') . "</span>")); ?>
                        <?php endif; ?>
                        <?php if (isBlogEdition()): ?>
                            <?php echo wp_kses_post(isValidBlogEdition() ? _e('Blog version has been activated', 'shapepress-dsgvo') : _e('Invalid license.', 'shapepress-dsgvo')); ?>
                        <?php endif; ?>
                    </div>

                    <?php if (isPremiumEdition() && SPDSGVOSettings::get('licence_details_fetched') === '1'): ?>
                        <div>
                            <div style="font-weight:500; width: 150px; float:left;"><?php _e('Activated on:', 'shapepress-dsgvo'); ?></div> <?php echo esc_html(date("d.m.Y", strtotime(SPDSGVOSettings::get('licence_activated_on')))); ?>
                        </div>
                        <div>
                            <div style="font-weight:500; width: 150px; float:left;"><?php _e('Status:', 'shapepress-dsgvo'); ?></div> <?php echo esc_html(SPDSGVOSettings::get('licence_status')); ?>
                        </div>
                        <?php if (isUnlimitedLicense(SPDSGVOSettings::get('dsgvo_licence')) == false) : ?>
                            <div>
                                <div style="font-weight:500; width: 150px; float:left;"><?php _e('Valid to:', 'shapepress-dsgvo'); ?></div> <?php echo esc_html((new DateTime(SPDSGVOSettings::get('licence_valid_to')))->format("d.m.Y")) ; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (SPDSGVOSettings::get('licence_details_fetched_new') === '1'): ?>
                            <div>
                                <div style="font-weight:500; width: 150px; float:left;"><?php _e('Last validation:', 'shapepress-dsgvo'); ?></div> <?php echo esc_html(date_i18n("d.m.Y H:i", strtotime(SPDSGVOSettings::get('licence_details_fetched_on')))); ?>
                            </div>
                            <div>
                                <div style="font-weight:500; width: 150px; float:left;"><?php _e('Remaining activations:', 'shapepress-dsgvo'); ?></div> <?php echo esc_html(SPDSGVOSettings::get('licence_number_use_remaining')); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- common settings -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Common Settings', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">

            <form method="post" action="<?php echo esc_attr(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action" value="<?php echo SPDSGVOCommonSettingsAction::getActionName() ?>">
                <?php wp_nonce_field(esc_attr(SPDSGVOCommonSettingsAction::getActionName()) . '-nonce'); ?>
                <input type="hidden" value="<?php echo esc_attr(SPDSGVOSettings::get('dsgvo_licence')); ?>" id="dsgvo_licence_hidden"
                       name="dsgvo_licence_hidden"/>
                <input type="hidden" value="common-settings" id="subform"  name="subform"/>
                <?php
                spDsgvoWriteInput('text', '', 'admin_email', SPDSGVOSettings::get('admin_email'),
                    __('Admin email address', 'shapepress-dsgvo'),
                    __('A valid email address', 'shapepress-dsgvo'),
                    __('Used for sending emails for notifications.', 'shapepress-dsgvo'));

                /*
                spDsgvoWriteInput('toggle', '', 'dsgvo_auto_update', SPDSGVOSettings::get('dsgvo_auto_update'),
                    __('Plugin auto-update', 'shapepress-dsgvo'),
                    '',
                    __('The plugin will install updates automatically.', 'shapepress-dsgvo'));
                */
                ?>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </form>

        </div>
    </div>

    <!-- shortcodes settings -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Available shortcodes', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <small class="form-text text-muted mt-0 mb-3"><?php _e('Following you will find a list of all available shortcodes of this plugin.','shapepress-dsgvo') ?></small>

                <?php
                spDsgvoWriteInput('text', '', 'sc_pp', '[privacy_policy]',
                    __('Shortcode to generate the privacy policy', 'shapepress-dsgvo'),
                    '',
                    '', true, 'border-0', '', false);
                ?>

            <?php
            spDsgvoWriteInput('text', '', 'sc_imprint', '[imprint]',
                __('Shortcode to generate the imprint', 'shapepress-dsgvo'),
                '',
                '', true, 'border-0', '', false);
            ?>

            <?php
            spDsgvoWriteInput('text', '', 'sc_sar', '[sar_form]',
                __('Shortcode to render the form to do a data request', 'shapepress-dsgvo'),
                '',
                '', true, 'border-0', '', false);
            ?>

            <?php
            spDsgvoWriteInput('text', '', 'sc_unsubscribe', '[unsubscribe_form]',
                __('Shortcode to render the form to do a delete request', 'shapepress-dsgvo'),
                '',
                '', true, 'border-0', '', false);
            ?>

            <?php
            spDsgvoWriteInput('text', '', 'popup_link', '[cookie_popup_link text=&quot;Cookie Popup&quot; class=&quot;myClass&quot;]',
                __('Shortcode to render a link to open the cookie popup', 'shapepress-dsgvo'),
                '',
                __('With the attribute text you can set the link text, the attribut class defines additional a tag classes.', 'shapepress-dsgvo'), true, 'border-0', '', false);
            ?>

            <?php
            spDsgvoWriteInput('text', '', 'sc_pp_link', '[pp_link text=&quot;Privacy policy&quot; class=&quot;myClass&quot;]',
                __('Shortcode to render a link for navigating to your privacy policy', 'shapepress-dsgvo'),
                '',
                __('With the attribute text you can set the link text, the attribut class defines additional a tag classes.', 'shapepress-dsgvo'), true, 'border-0', '', false);
            ?>

            <?php
            spDsgvoWriteInput('text', '', 'sc_lw_content_block', '[lw_content_block type=&quot;id_here&quot; shortcode=&quot;other shortcode here&quot;] ... [/lw_content_block]',
                __('Shortcode to (manually) block content', 'shapepress-dsgvo'),
                '',
                __('If automatic detection does not work, you can use this shortcode to block until your vistor do an opt-in. You need to put the content which you want to block within this shortcode tags (instead of ...) After opt-in, the content will be displayed. For instance [lw_content_block type="gmaps"] &ltdiv&gtPlace some nice links or images of/to Google Maps&lt/div&gt [/lw_content_block]','shapepress-dsgvo'), true, 'border-0', '', false);
            ?>

        </div>
    </div>

    <!-- privacy policy -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Privacy Policy', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_attr(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOPrivacyPolicyAction::getActionName()); ?>">
                <?php wp_nonce_field(esc_attr(SPDSGVOPrivacyPolicyAction::getActionName()) . '-nonce'); ?>

                <div class="form-group">
                    <?php $privacyPolicyPage = SPDSGVOSettings::get('privacy_policy_page'); ?>
                    <label for="privacy_policy_page"><?php _e('Privacy policy page', 'shapepress-dsgvo') ?></label>
                    <select class="form-control" name="privacy_policy_page" id="privacy_policy_page">
                        <option value="0"><?php _e('Select', 'shapepress-dsgvo'); ?></option>
                        <?php foreach (get_pages(array('number' => 0)) as $key => $page): ?>
                            <option <?php echo esc_attr(selected($privacyPolicyPage == $page->ID)); ?> value="<?php echo esc_attr($page->ID); ?>">
                                <?php echo esc_html($page->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>



                </div>
                <div class="form-group">
                    <?php if ($privacyPolicyPage == '0'): ?>
                        <small><?php _e('Create a page that uses the shortcode <code>[privacy_policy]</code>.', 'shapepress-dsgvo') ?>
                            <a class="btn btn-secondary btn-block"
                               href="<?php echo esc_url(SPDSGVOCreatePageAction::url(array('privacy_policy_page' => '1'))); ?>"><?php _e('Create page', 'shapepress-dsgvo') ?></a>
                        </small>
                    <?php elseif (!pageContainsString($privacyPolicyPage, 'privacy_policy')): ?>
                        <small><?php _e('Attention: The shortcode <code>[privacy_policy]</code> was not found on the page you selected.', 'shapepress-dsgvo') ?>
                            <a class="btn btn-secondary btn-block" target="_blank"
                               href="<?php echo esc_url(get_edit_post_link($privacyPolicyPage)) ?>"><?php _e('Edit page', 'shapepress-dsgvo') ?></a>
                        </small>
                    <?php else: ?>
                        <small class="form-text text-muted"><?php _e('This option also sets the wordpress option for the privacy policy page, which can be accessed in the menu "Settings/Privacy".','shapepress-dsgvo') ?></small>
                        <small class="form-text text-muted"><?php _e('The page can also by edited and text could be extended by the editing the selected page with the Wordpress page editor like Gutenberg.','shapepress-dsgvo') ?></small>
                        <a class="btn btn-secondary btn-block" target="_blank"
                           href="<?php echo get_edit_post_link($privacyPolicyPage) ?>"><?php _e('Edit page', 'shapepress-dsgvo') ?></a>
                    <?php endif; ?>
                </div>

                <?php
                spDsgvoWriteInput('text', '', 'privacy_policy_custom_header', SPDSGVOSettings::get('privacy_policy_custom_header'),
                    __('Title', 'shapepress-dsgvo'),
                    '',
                    __('The title of the page for display the privacy texts. Usually it is caled privacy policy.', 'shapepress-dsgvo'));
                ?>

                <div class="position-relative">

                    <div class="form-group">
                        <?php $hTagTitle =  SPDSGVOSettings::get('privacy_policy_title_html_htag') ?>
                        <label for="privacy_policy_title_html_htag"><?php _e('Header stile of title', 'shapepress-dsgvo') ?></label>
                        <select class="form-control" name="privacy_policy_title_html_htag" id="privacy_policy_title_html_htag">
                            <option value="h1" <?php echo esc_attr(selected($hTagTitle == 'h1')) ?>>h1</option>
                            <option value="h2" <?php echo esc_attr(selected($hTagTitle == 'h2')) ?>>h2</option>
                            <option value="h3" <?php echo esc_attr(selected($hTagTitle == 'h3')) ?>>h3</option>
                            <option value="h4" <?php echo esc_attr(selected($hTagTitle == 'h4')) ?>>h4</option>
                            <option value="h5" <?php echo esc_attr(selected($hTagTitle == 'h5')) ?>>h5</option>
                            <option value="h6" <?php echo esc_attr(selected($hTagTitle == 'h6')) ?>>h6</option>
                        </select>
                        <small class="form-text text-muted"><?php _e('Specifies the html header tag of the header of the privacy policy.', 'shapepress-dsgvo') ?></small>
                    </div>
                    <div class="form-group">
                        <?php $hTagSubTitle =  SPDSGVOSettings::get('privacy_policy_subtitle_html_htag') ?>
                        <label for="privacy_policy_title_html_htag"><?php _e('Header stile of subtitles', 'shapepress-dsgvo') ?></label>
                        <select class="form-control" name="privacy_policy_subtitle_html_htag" id="privacy_policy_subtitle_html_htag">
                            <option value="h1" <?php echo esc_attr(selected($hTagSubTitle == 'h1')) ?>>h1</option>
                            <option value="h2" <?php echo esc_attr(selected($hTagSubTitle == 'h2')) ?>>h2</option>
                            <option value="h3" <?php echo esc_attr(selected($hTagSubTitle == 'h3')) ?>>h3</option>
                            <option value="h4" <?php echo esc_attr(selected($hTagSubTitle == 'h4')) ?>>h4</option>
                            <option value="h5" <?php echo esc_attr(selected($hTagSubTitle == 'h5')) ?>>h5</option>
                            <option value="h6" <?php echo esc_attr(selected($hTagSubTitle == 'h6')) ?>>h6</option>
                        </select>
                        <small class="form-text text-muted"><?php _e('Specifies the html header tag of the subtitles of the privacy policy.', 'shapepress-dsgvo') ?></small>
                    </div>
                    <div class="form-group">
                        <?php $hTagSubSubTitle =  SPDSGVOSettings::get('privacy_policy_subsubtitle_html_htag') ?>
                        <label for="privacy_policy_title_html_htag"><?php _e('Header stile of "subsubtitles"', 'shapepress-dsgvo') ?></label>
                        <select class="form-control" name="privacy_policy_subsubtitle_html_htag" id="privacy_policy_subsubtitle_html_htag">
                            <option value="h1" <?php echo esc_attr(selected($hTagSubSubTitle == 'h1')) ?>>h1</option>
                            <option value="h2" <?php echo esc_attr(selected($hTagSubSubTitle == 'h2')) ?>>h2</option>
                            <option value="h3" <?php echo esc_attr(selected($hTagSubSubTitle == 'h3')) ?>>h3</option>
                            <option value="h4" <?php echo esc_attr(selected($hTagSubSubTitle == 'h4')) ?>>h4</option>
                            <option value="h5" <?php echo esc_attr(selected($hTagSubSubTitle == 'h5')) ?>>h5</option>
                            <option value="h6" <?php echo esc_attr(selected($hTagSubSubTitle == 'h6')) ?>>h6</option>
                        </select>
                        <small class="form-text text-muted"><?php _e('Specifies the html header tag of the "subsubtitles" of the privacy policy.', 'shapepress-dsgvo') ?></small>
                    </div>
                </div>
                <?php
                spDsgvoWriteInput('toggle', '', 'pp_texts_notification_mail', SPDSGVOSettings::get('pp_texts_notification_mail'),
                    __('Email notification when new texts are downloadable', 'shapepress-dsgvo'),
                    '',
                    '');
                ?>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
                <div>
                    <label for="textsVersion"><?php _e('Privacy policy texts','shapepress-dsgvo');?></label>
                </div>

                <div class="form-row">

                    <div class="col">
                        <label for="textsVersion"><?php _e('Date of Version','shapepress-dsgvo');?></label>
                        <input type="text" readonly="" class="form-control-plaintext pb-0" id="textVersion" value="<?php echo esc_attr(date("d.m.y H:i", SPDSGVOSettings::get('legal_web_texts_version')))?>">
                        <?php if(SPDSGVOSettings::get('legal_web_texts_remote_version') != '0' && SPDSGVOSettings::get('legal_web_texts_version') == SPDSGVOSettings::get('legal_web_texts_remote_version')) : ?>
                            <label class="form-text text-success"><?php _e('Your texts are up to date.','shapepress-dsgvo');?></label>
                        <?php elseif (SPDSGVOSettings::get('legal_web_texts_remote_version') != '0' && SPDSGVOSettings::get('legal_web_texts_version') != SPDSGVOSettings::get('legal_web_texts_remote_version')) : ?>
                            <label class="form-text text-warning"><?php _e('A newer version of the texts are available.','shapepress-dsgvo');?></label>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <label for="textsVersion"><?php _e('Last update check','shapepress-dsgvo');?></label>
                        <input type="text" readonly="" class="form-control-plaintext" id="textVersion" value="<?php echo esc_attr(date("d.m.y H:i",SPDSGVOSettings::get('legal_web_texts_last_check')))?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="progress" id="progress-pp-texts-reload" style="display: none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>
                    <input id="btn-refresh-pp-texts" type="button" class="btn btn-outline-primary btn-block privacy-policy-texts-refresh-link" value="<?php _e('Reload Privacy Policy texts', 'shapepress-dsgvo');?>">
                </div>

            </form>
        </div>
    </div>


       <!-- forms -->

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Additional Texts', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOCommonSettingsAction::getActionName()); ?>">
                <?php wp_nonce_field(esc_attr(SPDSGVOCommonSettingsAction::getActionName()) . '-nonce'); ?>
                <input type="hidden" value="<?php echo esc_attr(SPDSGVOSettings::get('dsgvo_licence')); ?>" id="dsgvo_licence_hidden"
                       name="dsgvo_licence_hidden"/>
                <input type="hidden" value="forms" id="subform"  name="subform"/>

                <div class="form-group">
                    <small class="form-text text-muted"><?php _e('The registration form and comments feature do not require any additional phrases such as "I agree to the privacy policy" or "more privacy information". It is enough if there is a link to the privacy policy on the respective page in the footer.','shapepress-dsgvo'); ?></small>
                </div>
                <?php
/*
                spDsgvoWriteInput('toggle', '', 'sp_dsgvo_comments_checkbox', SPDSGVOSettings::get('sp_dsgvo_comments_checkbox'),
                    __('Notice text at comments', 'shapepress-dsgvo'),
                    '',
                    __('Displays at notice text when creating a comment. Important: Not compatible in combination with Jetpack comment form.', 'shapepress-dsgvo'));

                if (class_exists('WPCF7_ContactForm')) {
                    spDsgvoWriteInput('toggle', '', 'sp_dsgvo_cf7_acceptance_replace', SPDSGVOSettings::get('sp_dsgvo_cf7_acceptance_replace'),
                        __('Replace CF7 Acceptance text', 'shapepress-dsgvo'),
                        '',
                        __('Replaces the text of CF7 Acceptance Checkboxes with following text. (Add to your form: [acceptance dsgvo] Text[/acceptance])', 'shapepress-dsgvo'));
                }
*/
                ?>

                <div class="position-relative">

                    <?php //php spDsgvoWritePremiumOverlayIfInvalid($isBlog || $isPremium); ?>

                    <?php
/*
                        spDsgvoWriteInput('textarea', '', 'spdsgvo_comments_checkbox_text',
                            htmlentities(trim(SPDSGVOSettings::get('spdsgvo_comments_checkbox_text'))),
                            __('Text to display at comment forms', 'shapepress-dsgvo'),
                            __('A message text', 'shapepress-dsgvo'),
                            __('This text gets displayed at every comment form on your page, so that your user confirm to the privacy policy with committing the form.', 'shapepress-dsgvo'));
*/
                    ?>
                </div>

                <?php
/*
                spDsgvoWriteInput('toggle', '', 'wp_signup_show_privacy_checkbox', SPDSGVOSettings::get('wp_signup_show_privacy_checkbox'),
                    __('Notice text at sign-up form', 'shapepress-dsgvo'),
                    '',
                    __('Displays a text at user sign-up form to confirm to the privacy policy.', 'shapepress-dsgvo'));
*/
                ?>

                <div class="position-relative">
                    <?php spDsgvoWritePremiumOverlayIfInvalid($isBlog || $isPremium); ?>
                    <?php
/*
                        spDsgvoWriteInput('textarea', '', 'wp_signup_checkbox_text',
                            htmlentities(trim(SPDSGVOSettings::get('wp_signup_checkbox_text'))),
                            __('Text to display at sign-up form', 'shapepress-dsgvo'),
                            __('A message text', 'shapepress-dsgvo'),
                            __('This text gets displayed at the sign-up form on your page, so that your user confirm to the privacy policy with committing the form.', 'shapepress-dsgvo'));
*/
                    ?>
                </div>

                <?php
                spDsgvoWriteInput('toggle', '', 'woo_show_privacy_checkbox', SPDSGVOSettings::get('woo_show_privacy_checkbox'),
                    __('Checkout text at WooCommerce checkout', 'shapepress-dsgvo'),
                    '',
                    __('Possibility to display a custom text at the WooCommerce checkout form to ensure terms & conditions.', 'shapepress-dsgvo'));
                ?>

                <div class="position-relative">
                    <?php spDsgvoWritePremiumOverlayIfInvalid($isBlog || $isPremium); ?>
                    <?php
                        spDsgvoWriteInput('textarea', '', 'woo_privacy_text',
                            (trim(SPDSGVOSettings::get('woo_privacy_text'))),
                            __('Text to display at WooCommerce checkout form', 'shapepress-dsgvo'),
                            __('A message text', 'shapepress-dsgvo'),
                            '');
                    ?>
                </div>

                <div class="form-group">
                    <?php _e('<strong>Important Note:</strong> If you use WPML you can translate these inputs via WPML String Translations.', 'shapepress-dsgvo') ?>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </form>
        </div>
    </div>

</div>





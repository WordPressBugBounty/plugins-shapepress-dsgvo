<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

?>
<form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
    <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOPageBasicsAction::getActionName()) ?>">
    <?php wp_nonce_field(esc_attr(SPDSGVOPageBasicsAction::getActionName()) . '-nonce'); ?>

<div class="card-columns">
    <!-- hosting -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Hosting Provider', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="form">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOPageBasicsAction::getActionName()); ?>">
                <?php wp_nonce_field(esc_attr(SPDSGVOPageBasicsAction::getActionName()) . '-nonce'); ?>

                <div class="form-group">
                <?php
                    $selectedHostingProvider = SPDSGVOSettings::get('page_basics_hosting_provider');
                    if (empty($selectedHostingProvider)) $selectedHostingProvider = array();
                    foreach (SPDSGVOConstants::getHostingProvider() as $key => $value)
                    {
                        $checked = in_array($key, $selectedHostingProvider); // hack initial value
                        spDsgvoWriteInput('switch', 'page_basics_hosting_provider_'.$key, 'page_basics_hosting_provider[]',
                            $checked ? $key : $key.'1',
                            __($value, 'shapepress-dsgvo'),
                            '',
                            '', false,'', $key);
                    }
                ?>
                </div>

                <div class="form-group <?php echo checked(in_array('other', $selectedHostingProvider)) ? 'spdsgvo-d-block' : 'spdsgvo-d-none' ?>"
                     id="container-other-provider">
                    <label><?php _e('Other Hosting Provider', 'shapepress-dsgvo') ?></label>
                    <small class="form-text text-muted"><?php _e('Please complete those services that you have included in your website but are not listed in the list. The privacy policy of the respective service provider can be found on the website of the provider. In order to determine whether the US service provider Privacy Shield is certified, a query can be made in the list provided at this link: <a href="https://www.privacyshield.gov/list" target="_blank">https://www.privacyshield.gov/list</a>.', 'shapepress-dsgvo') ?></small>

                    <?php
                    $otherProviderText = SPDSGVOSettings::get('page_basics_other_provider_text');
                    if (empty($otherProviderText)) $otherProviderText = SPDSGVOPageBasicsAction::getDefaultOtherText();
                    ?>
                    <?php wp_editor($otherProviderText, 'otherProviderText', array('textarea_rows' => '10', 'drag_drop_upload' => 'false', 'teeny' => true, 'media_buttons' => false)); ?>

                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Server Basics', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="form" >

                <?php
                $useLogFiles = SPDSGVOSettings::get('page_basics_use_logfiles');

                spDsgvoWriteInput('switch', '', 'page_basics_use_logfiles', $useLogFiles,
                    __('Usage of log files', 'shapepress-dsgvo'),
                    '',
                    __('Enable, if your hoster/server stores log files.','shapepress-dsgvo'));

                ?>

                <div id="container-logfiles-life" class="<?php echo esc_attr($useLogFiles == 1 ? '' : 'spdsgvo-d-none');?>">
                    <?php

                    spDsgvoWriteInput('text', '', 'page_basics_logfiles_life', SPDSGVOSettings::get('page_basics_logfiles_life'),
                        __('Storage life (days)', 'shapepress-dsgvo'),
                        __('e.g. 7','shapepress-dsgvo'),
                        __('Specify after how much days the files will be deleted.','shapepress-dsgvo'));

                    ?>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </div>
        </div>
    </div>

    <!-- cdn -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('CDN Provider', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="form">

                <?php
                $useCdnProvider = SPDSGVOSettings::get('page_basics_use_cdn');

                spDsgvoWriteInput('switch', '', 'page_basics_use_cdn', $useCdnProvider,
                    __('Use of a CDN Server/Provider', 'shapepress-dsgvo'),
                    '',
                    __('Enable, if you use a CDN server for static content (CSS, Javascripts, Images,...).','shapepress-dsgvo'));

                ?>

                <div class="form-group <?php echo esc_attr($useCdnProvider == 1 ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>" id="container-basics-use-cdn">
                    <label><?php _e('CDN Provider', 'shapepress-dsgvo') ?></label>
                    <?php

                     $selectedCdnProvider = SPDSGVOSettings::get('page_basics_cdn_provider');
                    if (empty($selectedCdnProvider)) $selectedCdnProvider = array();
                    foreach (SPDSGVOConstants::getCDNServers() as $key => $value)
                    {
                    $checked = in_array($key, $selectedCdnProvider); // hack initial value
                    spDsgvoWriteInput('switch', 'page_basics_cdn_provider_'.$key, 'page_basics_cdn_provider[]',
                        $checked ? $key : $key.'1',
                        __($value, 'shapepress-dsgvo'),
                        '',
                        '', false,'', $key);
                    }
                    ?>

                    <div id="container-other-cdn" class="lw-form-table <?php echo checked(in_array('other', $selectedCdnProvider)) ? 'spdsgvo-d-block' : 'spdsgvo-d-none' ?>">

                        <label><?php _e('Other CDN Provider', 'shapepress-dsgvo') ?></label>
                        <small class="form-text text-muted"><?php _e('If you do not use any of the services proposed by us, you would need to complete the privacy policy for the service you use in this text box.', 'shapepress-dsgvo') ?></small>

                        <?php
                            $otherCdnProviderText = SPDSGVOSettings::get('page_basics_other_cdn_provider_text');
                            if (empty($otherCdnProviderText)) $otherCdnProviderText = SPDSGVOPageBasicsAction::getDefaultOtherText();
                        ?>
                        <?php wp_editor($otherCdnProviderText, 'otherCdnProviderText', array('textarea_rows' => '10', 'drag_drop_upload' => 'false', 'teeny' => true, 'media_buttons' => false)); ?>

                    </div>

                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </div>
        </div>
    </div>

    <!-- payment -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Webshop/Check Out Process', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="form">

                <div class="position-relative">
                    <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>
                    <?php
                    $usePaymentProvider = SPDSGVOSettings::get('page_basics_use_payment_provider', '0');

                    spDsgvoWriteInput('switch', '', 'page_basics_use_payment_provider', $usePaymentProvider,
                        __('Use of Payment Provider', 'shapepress-dsgvo'),
                        '',
                        __('Enable, if you use payment provider in your online shop.','shapepress-dsgvo'));

                    ?>

                    <div class="form-group <?php echo esc_attr($usePaymentProvider == 1 ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>" id="container-basics-use-payment-provider">
                        <label><?php _e('Payment Provider', 'shapepress-dsgvo') ?></label>
                        <?php

                        $selectedPaymentProvider = SPDSGVOSettings::get('page_basics_payment_provider');
                        if (empty($selectedPaymentProvider)) $selectedPaymentProvider = array();
                        foreach (SPDSGVOConstants::getPaymentProvider() as $key => $value)
                        {
                            $checked = in_array($key, $selectedPaymentProvider); // hack initial value
                            spDsgvoWriteInput('switch', 'page_basics_payment_provider_'.$key, 'page_basics_payment_provider[]',
                                $checked ? $key : $key.'1',
                                __($value, 'shapepress-dsgvo'),
                                '',
                                '', false,'', $key);
                        }
                        ?>


                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- fonts -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Fonts', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="form" method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">

                <div class="form-group">
                    <small class="form-text text-muted"><?php _e('Specify which types of font frameworks/services are used. This information is required for the generation of a valid privacy policy.', 'shapepress-dsgvo') ?></small>

                </div>
                <div class="form-group">
                    <small class="form-text text-muted"><?php _e('Due to the judgment of the ECJ on C311/18 of July 16, 2020, the use of external font services is not recommended. Although Legalweb.io generates a data protection declaration, this cannot offer the necessary protection. <a href="https://marketingrecht.eu/eugh-schrems-2/" target="_blank">Information from the lawyer</a>', 'shapepress-dsgvo') ?></small>
                </div>
                <div class="form-group">
                    <?php
                    $selectedFontProvider = SPDSGVOSettings::get('page_basics_font_provider');
                    if (empty($selectedFontProvider)) $selectedFontProvider = array();
                    foreach (SPDSGVOConstants::getFontServices() as $key => $value)
                    {
                        $checked = in_array($key, $selectedFontProvider); // hack initial value
                        spDsgvoWriteInput('switch', 'page_basics_font_provider_'.$key, 'page_basics_font_provider[]',
                            $checked ? $key : $key.'1',
                            $value,
                            '',
                            '', false,'', $key);
                    }
                    ?>
                </div>
                <!--
                <div id="container-block-google-fonts" class="<?php echo esc_attr(in_array('google-fonts', $selectedFontProvider) ? 'spdsgvo-d-block' : 'spdsgvo-d-none') ?>" style="display: none !important;">
                    <?php
                        spDsgvoWriteInput('switch', ''.$key, 'page_basics_block_google_fonts', SPDSGVOSettings::get('page_basics_use_google_fonts'),
                            __('Block Google Fonts', 'shapepress-dsgvo'),
                            '',
                            __('Block Google Fonts until the visitor opted-in.', 'shapepress-dsgvo'));
                    ?>
                </div>
                -->
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </div>
        </div>
    </div>


    <!-- forms -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Forms', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="form">

                <div class="form-group">
                    <small class="form-text text-muted"><?php _e('If your website use any kind of forms, check them to provide the texts in the privacy policy.', 'shapepress-dsgvo') ?></small>
                </div>

                <?php
                spDsgvoWriteInput('switch', '', 'page_basics_forms_contact', SPDSGVOSettings::get('page_basics_forms_contact'),
                    __('Contact form', 'shapepress-dsgvo'),
                    '',
                    __('Enable if your website provides a contact form.', 'shapepress-dsgvo'));
                ?>
                <?php
                spDsgvoWriteInput('switch', '', 'page_basics_forms_application', SPDSGVOSettings::get('page_basics_forms_application'),
                    __('Application form', 'shapepress-dsgvo'),
                    '',
                    __('Enable if your website provides a application form.', 'shapepress-dsgvo'));
                ?>

                <?php
                spDsgvoWriteInput('switch', '', 'page_basics_forms_contest', SPDSGVOSettings::get('page_basics_forms_contest'),
                    __('Promotional contest or game form', 'shapepress-dsgvo'),
                    '',
                    __('Enable if your website provides a contest form.', 'shapepress-dsgvo'));
                ?>

                <?php
                spDsgvoWriteInput('switch', '', 'page_basics_forms_registration', SPDSGVOSettings::get('page_basics_forms_registration'),
                    __('Registration/Sign up form', 'shapepress-dsgvo'),
                    '',
                    __('Enable if your website provides your visitors the possibility to sign up. Also during ordering process.', 'shapepress-dsgvo'));
                ?>
                <?php
                spDsgvoWriteInput('switch', '', 'page_basics_forms_comments', SPDSGVOSettings::get('page_basics_forms_comments'),
                    __('Comments form', 'shapepress-dsgvo'),
                    '',
                    __('Enable if your visitor can comment your posts.', 'shapepress-dsgvo'));
                ?>

                <div class="container-basics-forms_comments <?php echo esc_attr(checked('1', SPDSGVOSettings::get('page_basics_forms_comments')) ? 'spdsgvo-d-block' : 'spdsgvo-d-none'); ?>">

                    <div class="form-group">
                        <label><?php _e('Which personal data of the website visitor will be published in a commentary?', 'shapepress-dsgvo') ?></label>
                        <?php
                        spDsgvoWriteInput('radio', 'page_basics_forms_comments_name_comment', 'page_basics_forms_comments_publish_type',
                            SPDSGVOSettings::get('page_basics_forms_comments_publish_type'),
                            __('Name and comment', 'shapepress-dsgvo'),
                            '',
                            '', false, '', 'name_comment');
                        ?>
                        <?php
                        spDsgvoWriteInput('radio', 'page_basics_forms_comments_nick_comment', 'page_basics_forms_comments_publish_type',
                            SPDSGVOSettings::get('page_basics_forms_comments_publish_type'),
                            __('Nick and comment', 'shapepress-dsgvo'),
                            '',
                            '', false, '', 'nick_comment');
                        ?>

                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </div>
        </div>
    </div>

    <!-- security services -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Captcha Services', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="form">

                <div class="form-group">
                   <small class="form-text text-muted"> <?php _e('Do you use Captcha services? E.g. as part of forms for preventing entries by bots?', 'shapepress-dsgvo') ?></small>
                </div>
                <div class="form-group">
                    <small class="form-text text-muted"><?php _e('Due to the judgment of the ECJ on C311/18 of July 16, 2020, the use of external font services is not recommended. Although Legalweb.io generates a data protection declaration, this cannot offer the necessary protection. <a href="https://marketingrecht.eu/eugh-schrems-2/" target="_blank">Information from the lawyer</a>', 'shapepress-dsgvo') ?></small>
                </div>
                <div class="form-group">

                    <?php
                    $selectedSecurityProvider = SPDSGVOSettings::get('page_basics_security_provider');
                    if (empty($selectedSecurityProvider)) $selectedSecurityProvider = array();
                    foreach (SPDSGVOConstants::getSecurityServices() as $key => $value)
                    {
                        $checked = in_array($key, $selectedSecurityProvider); // hack initial value
                        spDsgvoWriteInput('switch', 'page_basics_security_provider_'.$key, 'page_basics_security_provider[]',
                            $checked ? $key : $key.'1',
                            $value,
                            '',
                            '', false,'', $key);
                    }
                    ?>

                </div>

                <div id="container-other-security" class="lw-form-table <?php echo checked(in_array('other', $selectedSecurityProvider)) ? 'spdsgvo-d-block' : 'spdsgvo-d-none' ?>">

                    <div class="form-group">
                        <small class="text-muted form-text"><?php _e('Please complete those services that you have included in your website but are not listed in the list. The privacy policy of the respective service provider can be found on the website of the provider. In order to determine whether the US service provider Privacy Shield is certified, a query can be made in the list provided at this link: <a href="https://www.privacyshield.gov/list" target="_blank">https://www.privacyshield.gov/list</a>.', 'shapepress-dsgvo') ?></small>
                    </div>
                    <div class="form-group">
                        <?php
                        $otherSecurityProviderText = SPDSGVOSettings::get('page_basics_other_security_provider_text');
                        if (empty($otherSecurityProviderText)) $otherSecurityProviderText = SPDSGVOPageBasicsAction::getDefaultOtherText();
                        ?>
                        <?php wp_editor($otherSecurityProviderText, 'otherSecurityProviderText', array('textarea_rows' => '10', 'drag_drop_upload' => 'false', 'teeny' => true, 'media_buttons' => false)); ?>
                    </div>

                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </div>
        </div>
    </div>

    <!-- newsletter service -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Newsletter Services', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="position-relative">
                <?php spDsgvoWritePremiumOverlayIfInvalid($isPremium); ?>
                <div class="form" method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">

                <?php
                $useNewsletterProvider = SPDSGVOSettings::get('page_basics_use_newsletter_provider', '0');

                spDsgvoWriteInput('switch', '', 'page_basics_use_newsletter_provider', $useNewsletterProvider,
                    __('Use of Newsletter Service', 'shapepress-dsgvo'),
                    '',
                    __('Enable, if you use newsletter provider/services. Important: Add a checkbox wherever you have your sign-up to the newsletter to request the users confirmation.','shapepress-dsgvo'));

                ?>

             <div id="container-basics-use-newsletter" <div class="<?php echo esc_attr($useNewsletterProvider == 1 ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">
                <div class="form-group">
                    <?php
                    $selectedNewsletter = SPDSGVOSettings::get('page_basics_newsletter_provider');
                    if (empty($selectedNewsletter)) $selectedNewsletter = array();
                    foreach (SPDSGVOConstants::getNewsletterIntegrations() as $key => $value)
                    {
                        $checked = in_array($key, $selectedNewsletter); // hack initial value
                        spDsgvoWriteInput('switch', 'page_basics_newsletter_'.$key, 'page_basics_newsletter_provider[]',
                            $checked ? $key : $key.'1',
                            $value,
                            '',
                            '', false,'', $key);
                    }
                    ?>
                </div>

                <div id="container-other-newsletter" class="lw-form-table <?php echo esc_attr(checked(in_array('other', $selectedNewsletter)) ? 'spdsgvo-d-block' : 'spdsgvo-d-none'); ?>">

                    <div class="form-group">
                        <small class="text-muted form-text"><?php _e('Please complete those services that you have included in your website but are not listed in the list. The privacy policy of the respective service provider can be found on the website of the provider. In order to determine whether the US service provider Privacy Shield is certified, a query can be made in the list provided at this link: <a href="https://www.privacyshield.gov/list" target="_blank">https://www.privacyshield.gov/list</a>.', 'shapepress-dsgvo') ?></small>
                    </div>
                    <div class="form-group">
                        <?php
                        $otherNewsletterText = SPDSGVOSettings::get('page_basics_other_newsletter_provider_text');
                        if (empty($otherNewsletterText)) $otherNewsletterText = SPDSGVOPageBasicsAction::getDefaultOtherText();
                        ?>
                        <?php wp_editor($otherNewsletterText, 'page_basics_other_newsletter_provider_text', array('textarea_rows' => '10', 'drag_drop_upload' => 'false', 'teeny' => true, 'media_buttons' => false)); ?>
                    </div>

                </div>
             </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </div>
            </div>
        </div>
    </div>

</div>
</form>
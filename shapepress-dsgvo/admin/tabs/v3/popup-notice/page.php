<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

?>

<div class="card-columns">
    <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
        <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOCookieNoticeAction::getActionName());?>">
        <?php wp_nonce_field(esc_attr(SPDSGVOCookieNoticeAction::getActionName()) . '-nonce'); ?>
    <!-- notice/popup general -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Common Settings Cookie Notice/Popup', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="form">

                <div class="form-group">
                    <label for="cookie_notice_display"><?php _e('Cookie Notice/Popup type', 'shapepress-dsgvo') ?></label>
                    <select class="form-control" id="cookie_notice_display" name="cookie_notice_display">
                        <option value="none" <?php if (SPDSGVOSettings::get('cookie_notice_display') == 'no_popup') {
                            echo 'selected';
                        } ?>><?php _e('No notice, no popup, no cookie selection.', 'shapepress-dsgvo') ?></option>
                        <option value="cookie_notice" <?php if (SPDSGVOSettings::get('cookie_notice_display') == 'cookie_notice') {
                            echo 'selected';
                        } ?>><?php _e('Cookie Notice', 'shapepress-dsgvo') ?></option>

                        <option value="policy_popup" <?php if (SPDSGVOSettings::get('cookie_notice_display') == 'policy_popup') {
                            echo 'selected';
                        } ?>><?php _e('Cookie Popup', 'shapepress-dsgvo') ?></option>
                    </select><!-- #cookie_notice_display -->
                    <small class="form-text text-muted"><?php _e('Defines what the user gets shown when he visits the page. None means this feature is deactivated an no cookie selection can be made. You can show the popup again by giving any html element the class "sp-dsgvo-show-privacy-popup". If your visitor clicks on it, the popup gets shown again and the visitor can change his settings.', 'shapepress-dsgvo') ?></small>
                </div>

                <?php
                    spDsgvoWriteInput('toggle', '', 'show_notice_on_close', SPDSGVOSettings::get('show_notice_on_close'),
                        __('Show cookie notice when popup gets closed or dismissed', 'shapepress-dsgvo'),
                        '',
                        __('Show the cookie notice if the user does not make a choice because he closes the popup or dismiss all.', 'shapepress-dsgvo'));

                ?>

                <?php
                spDsgvoWriteInput('toggle', '', 'force_cookie_info', SPDSGVOSettings::get('force_cookie_info'),
                    __('Show cookie notice/popup in any case (though not required)', 'shapepress-dsgvo'),
                    '',
                    __('Show the cookie notice/popup although it is not necessary because no integrations are used. Also show technically necessary integrations and integrations like matomo/piwik/WP Statistics,.. for which no opt-in by your user is required by GDPR. If you have not any integrations enabled, only the popup with an OK button will be shown.', 'shapepress-dsgvo'));

                ?>

                <?php
                spDsgvoWriteInput('toggle', '', 'mandatory_integrations_editable', SPDSGVOSettings::get('mandatory_integrations_editable'),
                    __('Let visitors be able to disable necessary integrations', 'shapepress-dsgvo'),
                    '',
                    __('Let visitors be able to disable  necessary integrations and integrations like matomo/piwik/WP Statistics,.. for which no opt-in by your user is required by GDPR. The default value for this setting is off, because you can enable these integrations by default', 'shapepress-dsgvo'));

                ?>

                <div class="form-group">
                    <?php $cnCookieValidity = SPDSGVOSettings::get('cn_cookie_validity'); ?>
                    <label for="cn_cookie_validity"><?php _e('Cookie lifetime if accepted', 'shapepress-dsgvo') ?></label>
                    <select class="form-control" name="cn_cookie_validity" id="cn_cookie_validity">
                            <option value="86400" <?php echo esc_attr(selected($cnCookieValidity == 86400)) ?>>1
                                <?php _e('Day', 'shapepress-dsgvo') ?></option>
                            <option value="604800" <?php echo esc_attr(selected($cnCookieValidity == 604800)) ?>>1
                                <?php _e('Week', 'shapepress-dsgvo') ?></option>
                            <option value="2592000"
                                <?php echo esc_attr(selected($cnCookieValidity == 2592000)) ?>>1 <?php _e('Month',
                                    'shapepress-dsgvo') ?></option>
                            <option value="7862400"
                                <?php echo esc_attr(selected($cnCookieValidity == 7862400)) ?>>2 <?php _e('Month',
                                    'shapepress-dsgvo') ?></option>
                            <option value="15811200"
                                <?php echo esc_attr(selected($cnCookieValidity == 15811200)) ?>>6 <?php _e('Month',
                                    'shapepress-dsgvo') ?></option>
                            <option value="31536000"
                                <?php echo esc_attr(selected($cnCookieValidity == 31536000)) ?>>1 <?php _e('Year',
                                    'shapepress-dsgvo') ?></option>
                     </select>
                    <small class="form-text text-muted"><?php _e('For this period, the cookie gets stored if the user accepts. After this period your visitors have to make the cookie choice again.', 'shapepress-dsgvo') ?></small>
                </div>
                <div class="form-group">
                    <?php $cnCookieValidity = SPDSGVOSettings::get('cn_cookie_validity_dismiss'); ?>
                    <label for="cn_cookie_validity"><?php _e('Cookie lifetime if dismissed', 'shapepress-dsgvo') ?></label>
                    <select class="form-control" name="cn_cookie_validity_dismiss" id="cn_cookie_validity_dismiss">
                        <option value="86400" <?php echo esc_attr(selected($cnCookieValidity == 86400)) ?>>1
                            <?php _e('Day', 'shapepress-dsgvo') ?></option>
                        <option value="604800" <?php echo esc_attr(selected($cnCookieValidity == 604800)) ?>>1
                            <?php _e('Week', 'shapepress-dsgvo') ?></option>
                        <option value="2592000"
                            <?php echo esc_attr(selected($cnCookieValidity == 2592000)) ?>>1 <?php _e('Month',
                                'shapepress-dsgvo') ?></option>
                        <option value="7862400"
                            <?php echo esc_attr(selected($cnCookieValidity == 7862400)) ?>>2 <?php _e('Month',
                                'shapepress-dsgvo') ?></option>
                        <option value="15811200"
                            <?php echo esc_attr(selected($cnCookieValidity == 15811200)) ?>>6 <?php _e('Month',
                                'shapepress-dsgvo') ?></option>
                        <option value="31536000"
                            <?php echo esc_attr(selected($cnCookieValidity == 31536000)) ?>>1 <?php _e('Year',
                                'shapepress-dsgvo') ?></option>
                    </select>
                    <small class="form-text text-muted"><?php _e('For this period, the cookie gets stored when a user clicks cancel or dismiss all. After this period your visitors have to make the cookie choice again.', 'shapepress-dsgvo') ?></small>
                </div>



                <?php
                spDsgvoWriteInput('text', '', 'cookie_version', SPDSGVOSettings::get('cookie_version'),
                    __('Cookie version', 'shapepress-dsgvo'),
                    '',
                    '', true, '', '1', false);

                ?>

                <div class="form-group">
                    <input id="btnIncreaseCookieVersion" type="button" class="btn btn-outline-primary btn-block" value="<?php _e('Refresh/Update Cookie Version', 'shapepress-dsgvo') ?>" />
                    <small class="form-text text-muted"><?php _e('If you have made changes at your cookie settings (style, integrations,..) you can force your visitors to make a choice again when you increase the version.', 'shapepress-dsgvo') ?></small>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </div>
        </div>
    </div>

    <! -- popup styling -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Cookie Popup customization', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="form">

                <?php
                spDsgvoWriteInput('toggle', '', 'popup_dark_mode', SPDSGVOSettings::get('popup_dark_mode'),
                    __('Enable Dark Mode of the popup', 'shapepress-dsgvo'),
                    '',
                    __('Shows the popup in dark colors.', 'shapepress-dsgvo'));

                spDsgvoWriteInput('toggle', '', 'deactivate_load_popup_fonts', SPDSGVOSettings::get('deactivate_load_popup_fonts'),
                    __('Disable fonts loading with CSS', 'shapepress-dsgvo'),
                    '',
                    __('Deactivates the loading of Roboto fonts if custom fonts are used by CSS.', 'shapepress-dsgvo'));
                ?>


                <?php
                $src = '';
                $img_id = '';
                if (SPDSGVOSettings::get('logo_image_id', '') != '') {
                    $img_id = SPDSGVOSettings::get('logo_image_id');
                    $src = wp_get_attachment_url(intval($img_id));
                }
                if (empty($src)) $src= sp_dsgvo_URL . 'public/images/legalwebio-icon.png';
                ?>
                <div class="form-group dsgvo-image-upload">
                    <label><?php _e('Popup header logo', 'shapepress-dsgvo') ?></label>
                    <small class="form-text text-muted"><?php _e('We recommend to use a square image.', 'shapepress-dsgvo') ?></small>
                    <div class="image-preview-wrapper d-flex justify-content-center pb-2" >
                        <img id='logo_image-preview' class="image-preview mb-3" src='<?php echo esc_url($src); ?>'
                             style="height: 50px">
                    </div>
                    <div class="position-relative w-100">

                        <input id="logo_upload_image_button" type="button"
                               class="btn btn-secondary btn-block"
                               value="<?php _e('Upload image', 'shapepress-dsgvo'); ?>"/>
                        <input type='hidden' class="image-id" name='logo_image_id' id='logo_image_id'
                               value='<?php echo esc_attr($img_id); ?>'>
                    </div>
                </div><!-- .dsgvo-image-upload -->
                <div class="form-group mt-5">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </div>
        </div>
    </div>

    <! -- notice styling -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Cookie Notice customization', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <div class="form">


                <div class="position-relative">

                    <div class="form-group">
                        <label for="cookie_style"><?php _e('Cookie notice style', 'shapepress-dsgvo') ?></label>

                        <?php // todo: set names for styles, add default style?>
                        <?php $cnCookieStyle = SPDSGVOSettings::get('cookie_style'); ?>
                        <select class="form-control" id="cookie_style" name="cookie_style"
                            <?php echo esc_attr($hasValidLicense == false ? 'disabled' : ''); ?>>
                            <option value="00" <?php echo esc_attr(selected($cnCookieStyle == '00')) ?>><?php _e('Default', 'shapepress-dsgvo') ?></option>
                            <option value="01" <?php echo esc_attr(selected($cnCookieStyle == '01')) ?>>1</option>
                            <option value="02" <?php echo esc_attr(selected($cnCookieStyle == '02')) ?>>2</option>
                            <option value="03" <?php echo esc_attr(selected($cnCookieStyle == '03')) ?>>3</option>
                            <option value="04" <?php echo esc_attr(selected($cnCookieStyle == '04')) ?>>4</option>
                            <option value="05" <?php echo esc_attr(selected($cnCookieStyle == '05')) ?>>5</option>
                            <option value="06" <?php echo esc_attr(selected($cnCookieStyle == '06')) ?>>6</option>
                            <option value="07" <?php echo esc_attr(selected($cnCookieStyle == '07')) ?>>7</option>
                            <option value="08" <?php echo esc_attr(selected($cnCookieStyle == '08')) ?>>8</option>
                            <option value="09" <?php echo esc_attr(selected($cnCookieStyle == '09')) ?>>9</option>
                            <option value="10" <?php echo esc_attr(selected($cnCookieStyle == '10')) ?>>10</option>
                            <option value="11" <?php echo esc_attr(selected($cnCookieStyle == '11')) ?>>11</option>
                            <option value="12" <?php echo esc_attr(selected($cnCookieStyle == '12')) ?>>12</option>
                        </select>
                        <small class="form-text text-muted"><?php _e('Choose one of our cookie notice style templates.', 'shapepress-dsgvo') ?></small>

                    </div>

                    <div class="form-group">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie1.png')) ?>"
                             class="cookie-style-admin-show--01">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie2.png')) ?>"
                             class="cookie-style-admin-show--02">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie3.png')) ?>"
                             class="cookie-style-admin-show--03">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie4.png')) ?>"
                             class="cookie-style-admin-show--04">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie5.png')) ?>"
                             class="cookie-style-admin-show--05">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie6.png')) ?>"
                             class="cookie-style-admin-show--06">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie7.png')) ?>"
                             class="cookie-style-admin-show--07">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie8.png')) ?>"
                             class="cookie-style-admin-show--08">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie9.png')) ?>"
                             class="cookie-style-admin-show--09">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie10.png')) ?>"
                             class="cookie-style-admin-show--10">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie11.png')) ?>"
                             class="cookie-style-admin-show--11">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie12.png')) ?>"
                             class="cookie-style-admin-show--12">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie13.png')) ?>"
                             class="cookie-style-admin-show--13">
                        <img src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/cookies/Cookie14.png')) ?>"
                             class="cookie-style-admin-show--14">
                    </div>
                </div>
                    <div class="form-group">
                        <?php
                        spDsgvoWriteInput('textarea', '', 'cookie_notice_text',
                            trim(SPDSGVOSettings::get('cookie_notice_text')),
                            __('Cookie Notice text', 'shapepress-dsgvo'),
                            __('A message text', 'shapepress-dsgvo'),
                            __('This text gets displayed within the cookie notice. If you use WPML you can translate these inputs via WPML String Translations.', 'shapepress-dsgvo'), false);
                        ?>
                        <small class="form-text text-warning"><?php _e('Warning: If you change this text by your own you risk not be confirm with the GDPR.', 'shapepress-dsgvo')?></small>
                    </div>

                    <div class="form-group">
                        <?php $cnNoticePosition = SPDSGVOSettings::get('cn_position'); ?>
                        <label for="cn_position"><?php _e('Position:', 'shapepress-dsgvo') ?></label>
                        <select class="form-control" name="cn_position" id="cn_position">
                                <option value="top" <?php echo esc_attr(selected($cnNoticePosition == 'top')) ?>><?php _e('On top',
                                        'shapepress-dsgvo') ?></option>
                                <option value="bottom"
                                    <?php echo esc_attr(selected($cnNoticePosition == 'bottom')) ?>><?php _e('Bottom',
                                        'shapepress-dsgvo') ?></option>
                            </select>
                         <small class="form-text text-muted"><?php _e('Specifies the location where the cookie notice should be displayed.', 'shapepress-dsgvo') ?></small>
                    </div>

                    <div class="form-group">
                        <?php $cnNoticeAnimation = SPDSGVOSettings::get('cn_animation'); ?>
                        <label for="cn_animation"><?php _e('Animation', 'shapepress-dsgvo') ?></label>
                        <select class="form-control" name="cn_animation" id="cn_animation">
                                <option value="none" <?php echo esc_attr(selected($cnNoticeAnimation == 'none')) ?>><?php _e('None',
                                        'shapepress-dsgvo') ?></option>
                                <option value="fade"
                                    <?php echo esc_attr(selected($cnNoticeAnimation == 'fade')) ?>><?php _e('fade',
                                        'shapepress-dsgvo') ?></option>
                                <option value="hide"
                                    <?php echo esc_attr(selected($cnNoticeAnimation == 'hide')) ?>><?php _e('hide',
                                        'shapepress-dsgvo') ?></option>
                            </select>
                         <small class="form-text text-muted"><?php _e('Animation when accepting the cookie message.', 'shapepress-dsgvo') ?></small>
                    </div>

                    <div class="form-group">
                        <label for="cn_size_text"><?php _e('Font size', 'shapepress-dsgvo') ?></label>

                        <?php $cnSizeText = SPDSGVOSettings::get('cn_size_text'); ?>
                        <select class="form-control" name="cn_size_text"
                                id="cn_size_text">
                            <option value="inherit" <?php echo esc_attr(selected($cnSizeText == 'inherit')) ?>><?php _e('Default',
                                    'shapepress-dsgvo') ?></option>
                            <option value="11px" <?php echo esc_attr(selected($cnSizeText == '11px')) ?>>11px</option>
                            <option value="12px" <?php echo esc_attr(selected($cnSizeText == '12px')) ?>>12px</option>
                            <option value="13px" <?php echo esc_attr(selected($cnSizeText == '13px')) ?>>13px</option>
                            <option value="14px" <?php echo esc_attr(selected($cnSizeText == '14px')) ?>>14px</option>
                            <option value="15px" <?php echo esc_attr(selected($cnSizeText == '15px')) ?>>15px</option>
                            <option value="16px" <?php echo esc_attr(selected($cnSizeText == '16px')) ?>>16px</option>
                            <option value="17px" <?php echo esc_attr(selected($cnSizeText == '17px')) ?>>17px</option>
                            <option value="18px" <?php echo esc_attr(selected($cnSizeText == '18px')) ?>>18px</option>
                            <option value="19px" <?php echo esc_attr(selected($cnSizeText == '19px')) ?>>19px</option>
                            <option value="20px" <?php echo esc_attr(selected($cnSizeText == '20px')) ?>>20px</option>
                        </select>
                    </div>
                <div class="position-relative">


                    <div class="cn-customize-standard-notice-container <?php echo esc_attr($cnCookieStyle == '00' ? 'spdsgvo-d-block': 'spdsgvo-d-none');?>">


                        <?php
                        spDsgvoWriteInput('color', '', 'cn_background_color', SPDSGVOSettings::get('cn_background_color'),
                            __('Background color', 'shapepress-dsgvo'),
                            '',
                            __('Specifies the background color of the cookie notice.', 'shapepress-dsgvo'));
                        ?>

                        <?php
                        spDsgvoWriteInput('color', '', 'cn_text_color', SPDSGVOSettings::get('cn_text_color'),
                            __('Text/Font color', 'shapepress-dsgvo'),
                            '',
                            __('Specifies the text/font color of the cookie notice text.', 'shapepress-dsgvo'));
                        ?>

                        <?php
                        spDsgvoWriteInput('color', '', 'cn_background_color_button', SPDSGVOSettings::get('cn_background_color_button'),
                            __('Button background color', 'shapepress-dsgvo'),
                            '',
                            __('Specifies the background color of the cookie notice button.', 'shapepress-dsgvo'));
                        ?>

                        <?php
                        spDsgvoWriteInput('color', '', 'cn_border_color_button', SPDSGVOSettings::get('cn_border_color_button'),
                            __('Button border color', 'shapepress-dsgvo'),
                            '',
                            __('Specifies the border color of the cookie notice button.', 'shapepress-dsgvo'));
                        ?>

                        <div class="form-group">
                            <label for="cn_height_container"><?php _e('Size of the button border', 'shapepress-dsgvo') ?></label>

                            <?php $cnButtonBorderSize = SPDSGVOSettings::get('cn_border_size_button'); ?>
                            <select class="form-control" name="cn_border_size_button"
                                    id="cn_border_size_button">
                                <option value="1px" <?php echo esc_attr(selected($cnButtonBorderSize == '1px')) ?>>1px</option>
                                <option value="2px" <?php echo esc_attr(selected($cnButtonBorderSize == '2px')) ?>>2px</option>
                                <option value="3px" <?php echo esc_attr(selected($cnButtonBorderSize == '3px')) ?>>3px</option>
                                <option value="4px" <?php echo esc_attr(selected($cnButtonBorderSize == '4px')) ?>>4px</option>
                                <option value="5px" <?php echo esc_attr(selected($cnButtonBorderSize == '5px')) ?>>5px</option>
                            </select>
                        </div>

                        <?php
                        spDsgvoWriteInput('color', '', 'cn_text_color_button', SPDSGVOSettings::get('cn_text_color_button'),
                            __('Button text/font color', 'shapepress-dsgvo'),
                            '',
                            __('Specifies the text/font color of the cookie notice button.', 'shapepress-dsgvo'));
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'cn_custom_css_container', SPDSGVOSettings::get('cn_custom_css_container'),
                            __('CSS class cookie notice', 'shapepress-dsgvo'),
                            __('.myClass1 .myClass2', 'shapepress-dsgvo'),
                            __('Specifies one or multiple additional classes for the cookie notice. Please specify them without leading "."', 'shapepress-dsgvo'));
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'cn_custom_css_text', SPDSGVOSettings::get('cn_custom_css_text'),
                            __('CSS class text', 'shapepress-dsgvo'),
                            __('.myClass1 .myClass2', 'shapepress-dsgvo'),
                            __('Specifies one or multiple additional classes for the text of cookie notice. Please specify them with leading "."', 'shapepress-dsgvo'));
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'cn_custom_css_buttons', SPDSGVOSettings::get('cn_custom_css_buttons'),
                            __('CSS class button', 'shapepress-dsgvo'),
                            __('.myClass1 .myClass2', 'shapepress-dsgvo'),
                            __('Specifies one or multiple additional classes for the button of cookie notice. Please specify them with leading "."', 'shapepress-dsgvo'));
                        ?>



                        <div class="form-group">
                            <label for="cn_height_container"><?php _e('Height of cookie notice', 'shapepress-dsgvo') ?></label>

                                <?php $cnHeightContainer = SPDSGVOSettings::get('cn_height_container'); ?>
                                <select class="form-control" name="cn_height_container"
                                        id="cn_height_container">
                                    <option value="auto" <?php echo esc_attr(selected($cnHeightContainer == 'auto')) ?>><?php _e('Default',
                                            'shapepress-dsgvo') ?></option>
                                    <option value="40px" <?php echo esc_attr(selected($cnHeightContainer == '40px')) ?>>40px</option>
                                    <option value="45px" <?php echo esc_attr(selected($cnHeightContainer == '45px')) ?>>45px</option>
                                    <option value="50px" <?php echo esc_attr(selected($cnHeightContainer == '50px')) ?>>50px</option>
                                    <option value="55px" <?php echo esc_attr(selected($cnHeightContainer == '55px')) ?>>55px</option>
                                    <option value="60px" <?php echo esc_attr(selected($cnHeightContainer == '60px')) ?>>60px</option>
                                    <option value="65px" <?php echo esc_attr(selected($cnHeightContainer == '65px')) ?>>65px</option>
                                    <option value="70px" <?php echo esc_attr(selected($cnHeightContainer == '70px')) ?>>70px</option>
                                    <option value="75px" <?php echo esc_attr(selected($cnHeightContainer == '75px')) ?>>75px</option>
                                    <option value="80px" <?php echo esc_attr(selected($cnHeightContainer == '80px')) ?>>80px</option>
                                </select>
                        </div>

                    </div>
                </div>


                <div class="form-group cn-customize-standard-notice-container <?php echo esc_attr($cnCookieStyle == '00' ? 'spdsgvo-d-block': 'spdsgvo-d-none');?>">
                    <?php
                    spDsgvoWriteInput('toggle', '', 'cn_show_dsgvo_icon', SPDSGVOSettings::get('cn_show_dsgvo_icon'),
                        __('Show WP DSGVO Tools (GDPR) icon', 'shapepress-dsgvo'),
                        '',
                        __('Displays the WP DSGVO Tools (GDPR) icon on the left side of the cookie notice.', 'shapepress-dsgvo'));
                    ?>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

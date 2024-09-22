<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package WP DSGVO Tools
 * @subpackage WP DSGVO Tools/public
 * @author Shapepress eU
 */
class SPDSGVOPublic
{
    private $validLicence;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $sp_dsgvo
     *            The name of the plugin.
     * @param string $version
     *            The version of this plugin.
     */
    public function __construct()
    {
        $this->validLicence = isValidBlogEdition() || isValidPremiumEdition();
    }

    private static $cookie = [
        'name'  => 'sp_dsgvo_cn_accepted',
        'value' => 'TRUE'
    ];

    private static $cookiePopup = [
        'name'  => 'sp_dsgvo_popup',
        'value' => '1'
    ];

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(sp_dsgvo_NAME.'_twbs4_grid', plugin_dir_url(__FILE__) . 'css/bootstrap-grid.min.css', array(), sp_dsgvo_VERSION, 'all');
        wp_enqueue_style(sp_dsgvo_NAME, plugin_dir_url(__FILE__) . 'css/sp-dsgvo-public.min.css', array(), sp_dsgvo_VERSION, 'all');
        wp_enqueue_style(sp_dsgvo_NAME.'_popup', plugin_dir_url(__FILE__) . 'css/sp-dsgvo-popup.min.css', array(), sp_dsgvo_VERSION, 'all');
        wp_enqueue_style('simplebar', plugin_dir_url(__FILE__) . 'css/simplebar.min.css');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(sp_dsgvo_NAME, plugin_dir_url(__FILE__) . 'js/sp-dsgvo-public.min.js', array(
            'jquery'
        ), sp_dsgvo_VERSION, false);

        $cf7AccText = SPDSGVOSettings::get('spdsgvo_comments_checkbox_text');
        if(function_exists('icl_translate')) {
            $cf7AccText = icl_translate('shapepress-dsgvo', 'spdsgvo_comments_checkbox_text', $cf7AccText);
        }

        /* i592995 */
        wp_enqueue_script('simplebar', plugin_dir_url(__FILE__) . 'js/simplebar.min.js', array(
            'jquery'
        ), null, true);
        /* i592995 */
    }

    /**
     * Print scripts for GA, FB Pixel,..
     * if enabled
     *
     * @return mixed
     */
    public function wp_print_footer_scripts()
    {

    }

    public function cookieNotice()
    {

        $settings = SPDSGVOSettings::getAll();

        /*
        if ($settings['cn_use_overlay'] === '1' && $settings['cookie_notice_display'] === 'cookie_notice') {
            echo '<div id="cookie-notice-blocker"></div>';
        }
        */

        $image_path = SPDSGVO::pluginURI('public');

        $noticeStyle = $settings['cookie_style'];
        if ($this->validLicence == false) $noticeStyle = '00';

        // styles have been moved to external php files to avoid spaghetti code
        if ($noticeStyle != '00') {
            require_once(SPDSGVO::pluginDir('public/inc/cookie-notice-styles.php'));
        }
        ?>
        <!--noptimize-->
        <div id="cookie-notice" role="banner"
            	class="sp-dsgvo lwb-d-flex cn-<?php echo esc_attr($settings['cn_position']) ?> cookie-style-<?php echo esc_attr($settings['cookie_style']);?> <?php echo esc_attr($settings['cn_custom_css_container'] !== '' ? ($settings['cn_custom_css_container']):''); ?> <?php echo esc_attr($noticeStyle != '00' ? 'cn-shadow-top' : '');?>"
            	style="background-color: <?php echo esc_attr($settings['cn_background_color']) ?>;
            	       color: <?php echo esc_attr($settings['cn_text_color']) ?>;
            	       height: <?php echo esc_attr($settings['cn_height_container']) ?>;">
	        <div class="cookie-notice-container container-fluid lwb-d-md-flex <?php echo esc_attr($noticeStyle == '00' ? 'justify-content-md-center align-items-md-center' : 'justify-content-around'); ?>">

                <?php

                    $imgSrc = 'public/images/cookie-icons/';
                    $imgClass = "cn_cookie_icon_".$noticeStyle;
                    switch ($noticeStyle) {
                        case '03': $imgSrc .= "gradient2.png"; break;
                        case '04': $imgSrc .= "cookie-4.png"; break;
                        case '05': $imgSrc .= "Cookie-one-navy2.png"; break;
                        case '07': $imgSrc .= "cookie-twin-white.png"; break;
                        case '08': $imgSrc .= "cookie-twin-white.png"; break;
                        case '09': $imgSrc .= "cookie-twin-white.png"; break;
                        case '11': $imgSrc .= "Cookie-one-white-1.png"; break;
                        default: $imgSrc = ""; $imgClass = "";
                    }

                ?>


                <?php if (empty($imgSrc) == false) : ?>
                <img src="<?php echo esc_url(SPDSGVO::pluginURI($imgSrc)); ?>" class="<?php echo esc_attr($imgClass); ?>" alt="<?php esc_attr_e('Cookie Image','shapepress-dsgvo');?>"/>
                <?php endif; ?>

                <?php $cookie_style_array = array('03', '04', '05', '07', '08', '09', '13', '14'); 
                 if(in_array($noticeStyle , $cookie_style_array)) : ?>
                <div class="cookie-style-03-text">
                <?php endif; ?>

                    <?php if($noticeStyle == '14') : ?>
                    <img src="<?php echo esc_url(SPDSGVO::pluginURI('public/images/cookie-icons/Cookie-one-white-1.png')); ?>" class="cn_cookie_icon_14" alt="<?php esc_attr_e('Cookie Image','shapepress-dsgvo');?>" />
                    <?php endif; ?>

                    <?php if ($settings['cn_show_dsgvo_icon'] === '1' && $settings['cookie_style'] == '00') : ?>
                        <span id="cn-notice-icon">
                            <a href="https://legalweb.io" target="_blank">
                                <img id="cn-notice-icon" src="<?php echo esc_url(plugin_dir_url(__FILE__)) . 'images/legalwebio-icon.png' ?>"
                                    alt="WP DSGVO Tools (GDPR) for Wordpress and WooCommerce" title="WP DSGVO Tools (GDPR) for Wordpress and WooCommerce" style="display:inline !important;" />
                            </a>
                        </span>
                    <?php endif;
            	
                    $cookieNoticeCustomText = wp_kses_post(SPDSGVOSettings::get('cookie_notice_text'));

                    //if(function_exists('icl_translate')) {
                    //    $cookieNoticeCustomText = icl_translate('shapepress-dsgvo', 'cookie_notice_text', $cookieNoticeCustomText);
                    //}
                    ?>

                    <span id="cn-notice-text" class="<?php echo esc_attr($settings['cn_custom_css_text'] !== '' ? ($settings['cn_custom_css_text']):''); ?>"
                        style="font-size:<?php echo esc_attr($settings['cn_size_text']) ?>"><?php echo convDeChars($cookieNoticeCustomText); ?>
                    </span>

                <?php if(in_array($noticeStyle , $cookie_style_array)) : ?>
                </div> <!-- class="cookie-style-03-text"-->
                <?php endif; ?>

                <?php if($noticeStyle != '00') : ?>
                <div id="cn-buttons-container">
                <?php endif; ?>

                    <a href="#" id="cn-btn-settings"
                        class="cn-set-cookie button button-default <?php echo esc_attr($settings['cn_custom_css_buttons'] !== '' ? ($settings['cn_custom_css_buttons']):''); ?>"
                        style="background-color: <?php echo esc_attr($settings['cn_background_color_button']) ?>;
                           color: <?php echo esc_attr($settings['cn_text_color_button']) ?>;
                           border-color: <?php echo esc_attr($settings['cn_border_color_button']) ?>;
                           border-width: <?php echo esc_attr($settings['cn_border_size_button']) ?>">

                        <?php _e('Settings', 'shapepress-dsgvo'); ?>
                    </a>

                <?php if($noticeStyle != '00') : ?>
                </div> <!-- id="cn-buttons-container"-->
                <?php endif; ?>

            </div> <!-- class="cookie-notice-container" -->
        </div> <!--id="cookie-notice" -->
        <!--/noptimize-->

<?php


    }

    public function writePopupStyles()
    {
        //require_once(SPDSGVO::pluginDir('public/inc/bootstrap-grid.min.php'));
        //require_once(SPDSGVO::pluginDir('public/inc/cookie-popup-styles.php'));

        if (SPDSGVOSettings::get('popup_dark_mode') == '1')
        {
            ?>
            <style>

                .sp-dsgvo-privacy-popup {
                    background-color: #202326;
                    color: #b2b4b6
                }

                #sp-dsgvo-popup-more-information-content,
                #sp-dsgvo-popup-more-information-content > p
                {
                    color: #b2b4b6;
                }
                .sp-dsgvo-popup-more-information-content strong
                {
                    color: #b2b4b6
                }

                .sp-dsgvo-category-container
                {
                    background-color: #313334;
                }
                .sp-dsgvo-category-item-description-url a {
                    color: #2ba2f4
                }

                .sp-dsgvo-popup-close svg,
                .sp-dsgvo-popup-close svg line,
                .sp-dsgvo-popup-more-information-close svg,
                .sp-dsgvo-popup-more-information-close svg line,
                .sp-dsgvo-privacy-popup .sp-dsgvo-lang-active svg,
                .sp-dsgvo-privacy-popup .sp-dsgvo-lang-active svg line,
                .sp-dsgvo-popup-more-information-close
                {
                    stroke: #b2b4b6;
                    fill: #b2b4b6;
                    color: #b2b4b6;
                }

                .sp-dsgvo-privacy-bottom  a.sp-dsgvo-popup-button
                {
                    color: #ffffff
                }

                .sp-dsgvo-privacy-bottom  a.sp-dsgvo-popup-button:hover
                {
                    color: #fafafa;
                }

            </style>
            <?php
        }


    }

    public function policyPopup()
    {
        // hide popup to bots
        $bot_identifiers = array(
            'bot',
            'slurp',
            'crawler',
            'spider',
            'curl',
            'facebook',
            'fetch',
        );
        $curUserAgent= strtolower($_SERVER['HTTP_USER_AGENT']);
        // See if one of the identifiers is in the UA string.
        foreach ($bot_identifiers as $identifier) {
            if (strpos($curUserAgent, $identifier) !== FALSE) {
                return;
            }
        }

        $settings = SPDSGVOSettings::getAll();


        if ($settings['cookie_notice_display'] == 'no_popup') {
            return ;
        }

        // write user defined styles from backend
        $this->writePopupStyles();

        $overlay_class = 'sp-dsgvo-popup-overlay sp-dsgvo-overlay-hidden';
        $overlay_class .= ' not-accepted'; //  todo check if needed

        $imprintUrl = get_permalink(SPDSGVOSettings::get('imprint_page'));//get_permalink($settings['imprint_page']);
        $privacyPolicyUrl = get_permalink(SPDSGVOSettings::get('privacy_policy_page')); //get_permalink($settings['privacy_policy_page']);

        $allCategories = SPDSGVOCookieCategoryApi::getCookieCategories();
        $integrationCountByCategory = array();
        $overallEnabledIntegrationCount = 0;
        foreach ($allCategories as $category)
        {
            $categoryData = SPDSGVOCookieCategoryApi::getCookieCategory($category['slug']);
            if ($categoryData == null)
            {
                $integrationCountByCategory[$category['slug']] = 0;
                continue;
            }

            // fetch all integrations with given category and check if they are enabled
            $integrations = SPDSGVOIntegrationApiBase::getAllIntegrationApis($category['slug'], FALSE);

            $enabledIntegrationCount = 0;
            foreach ($integrations as $integrationSlug => $integration)
            {
                if ($integration->getIsPremium() && $this->validLicence == false) continue;
                if ($integration->getShowInPopup() == false) continue;
                if ($integration->getIsEnabled()) $enabledIntegrationCount += 1;
            }
            $integrationCountByCategory[$category['slug']] = $enabledIntegrationCount;
            $overallEnabledIntegrationCount += $enabledIntegrationCount;
        }
        $onlyOkButton = $overallEnabledIntegrationCount == 0 || $integrationCountByCategory[SPDSGVOConstants::CATEGORY_SLUG_MANDATORY] == $overallEnabledIntegrationCount;


        // get introduction text depending on operator type
        $operatorType = $settings['page_operator_type'];
        $selectedCountry = $settings['spdsgvo_company_info_countrycode'];
        $selectedCountry = SPDSGVOConstants::getCountries()[$selectedCountry];
        $selectedCountry = __($selectedCountry, 'shapepress-dsgvo');
        $introductionText = "";
        $ownerText = "";
        switch ($operatorType) {
            case 'private':
                if ($onlyOkButton == false)
                {
                    $introductionText = __('I, {OWNER-TEXT}, would like to process personal data with external services. This is not necessary for using the website, but allows me to interact even more closely with them. If desired, please make a choice:', 'shapepress-dsgvo');
                } else
                {
                    $introductionText = __('I, {OWNER-TEXT}, process personal data to operate this website only to the extent technically necessary. All details in my privacy policy.','shapepress-dsgvo');
                }
                $ownerText = $settings['page_operator_operator_name'] . " (". __('Place of residence', 'shapepress-dsgvo') .": ". $selectedCountry .")";
                break;
            case 'one-man':
                if ($onlyOkButton == false)
                {
                    $introductionText = __('{OWNER-TEXT}, would like to process personal data with external services. This is not necessary for using the website, but allows me to interact even more closely with them. If desired, please make a choice:', 'shapepress-dsgvo');
                } else
                {
                    $introductionText = __('{OWNER-TEXT}, processes personal data only to the extent strictly necessary for the operation of this website. All details in the privacy policy.','shapepress-dsgvo');
                }
                $ownerText = $settings['page_operator_company_name'] . ", ". __('Owner', 'shapepress-dsgvo') .": ". $settings['page_operator_company_law_person']. " (". __('Registered business address', 'shapepress-dsgvo') .": ". $selectedCountry .")";
                break;
            case 'corporation':
                if ($onlyOkButton == false)
                {
                    $introductionText = __('We, the {OWNER-TEXT}, would like to process personal information with external services. This is not necessary for the use of the website, but allows us to interact even more closely with them. If desired, please make a choice:', 'shapepress-dsgvo');
                } else
                {
                    $introductionText = __('We, {OWNER-TEXT}, process personal data for the operation of this website only to the extent technically necessary. All details in our privacy policy.','shapepress-dsgvo');
                }
                $ownerText = $settings['page_operator_corporate_name'] . " (". __('Registered business address', 'shapepress-dsgvo') .": ". $selectedCountry .")";
                break;
            case 'society':
                if ($onlyOkButton == false)
                {
                    $introductionText = __('We, {OWNER-TEXT}, would like to process personal information with external services. This is not necessary for the use of the website, but allows us to interact even more closely with them. If desired, please make a choice:', 'shapepress-dsgvo');
                } else
                {
                    $introductionText = __('We, {OWNER-TEXT}, process personal data for the operation of this website only to the extent technically necessary. All details in our privacy policy.','shapepress-dsgvo');
                }
                $ownerText = $settings['page_operator_society_name'] . " (". __('Club seat', 'shapepress-dsgvo') .": ". $selectedCountry .")";
                break;
            case 'corp-public-law':
            case 'corp-private-law':
                if ($onlyOkButton == false)
                {
                    $introductionText = __('We, {OWNER-TEXT}, would like to process personal information with external services. This is not necessary for the use of the website, but allows us to interact even more closely with them. If desired, please make a choice:', 'shapepress-dsgvo');
                } else
                {
                    $introductionText = __('We, {OWNER-TEXT}, process personal data for the operation of this website only to the extent technically necessary. All details in our privacy policy.','shapepress-dsgvo');
                }
                $ownerText = $settings['page_operator_corp_public_law_name'] . " (". __('Registered business address', 'shapepress-dsgvo') .": ". $selectedCountry .")";
                break;
        }

        $introductionText = (str_replace('{OWNER-TEXT}', $ownerText, $introductionText));
        //$introductionText = convDeChars($introductionText); // let it uncommented until the first ticket about this gets opened
        ?>

        <!--noptimize-->
        <div class="sp-dsgvo <?php echo esc_attr( $overlay_class); ?>">
            <div class="sp-dsgvo-privacy-popup container-fluid no-gutters ">

                <div class="sp-dsgvo-popup-top">


                    <div class="sp-dsgvo-header-wrapper-xs d-block d-sm-none">
                        <div class="lwb-row" style="margin-bottom: 3px;">

                            <div class="lwb-col-10">
                                <div class="sp-dsgvo-logo-wrapper">
                                    <?php
                                    $src = sp_dsgvo_URL . 'public/images/legalwebio-icon.png';
                                    $img_id = $settings['logo_image_id'];
                                    if($img_id != '' && $img_id != '0') {
                                        $customLogo = wp_get_attachment_url(intval($img_id));
                                        if ($customLogo != false)
                                        {
                                            $src = $customLogo;
                                        }
                                    }
                                    ?>
                                    <img src="<?php echo esc_url($src); ?>" class="sp-dsgvo-popup-logo" alt="<?php esc_attr_e('Logo of the popup', 'shapepress-dsgvo');?>" title="<?php _e('WP DSGVO Tools (GDPR) for Wordpress and WooCommerce.','shapepress-dsgvo') ?>" />
                                </div><!-- .logo-wrapper -->

                                <div class="sp-dsgvo-privacy-popup-title">
                                    <div class="sp-dsgvo-privacy-popup-title-general"> <?php _e('Data protection', 'shapepress-dsgvo');?></div>
                                    <div class="sp-dsgvo-privacy-popup-title-details" style="display: none"> <?php _e('Details', 'shapepress-dsgvo');?></div>

                                </div>
                            </div>
                            <div class="lwb-col-2 " style="text-align: right">
                                <?php
                                $url = SPDSGVOSettings::get('close_button_url', '#');
                                $action = SPDSGVOSettings::get('close_button_action', '0');
                                $additional_class = '';
                                if($url == '' || $action == '' || $action == '0') {
                                    $url = '#';
                                    $additional_class = 'close';
                                }
                                if(function_exists('icl_translate')) {
                                    $url = icl_translate('shapepress-dsgvo', 'close_button_url', $url);
                                }
                                ?>
                                <a href="<?php echo esc_url($url); ?>" id="sp-dsgvo_popup_close-1" class="sp-dsgvo-popup-close <?php echo esc_attr($additional_class); ?>">
                                    <svg width="10" height="10">
                                        <line x1="0" y1="0" x2="10" y2="10" />
                                        <line x1="0" y1="10" x2="10" y2="0" />
                                    </svg><!-- #dsgvo_popup_close -->
                                </a>
                            </div>
                        </div><!-- line1 wrapper -->
                        <div class="lwb-row">
                            <div class="sp-dsgvo-link-wrapper lwb-col-8 pr-1">
                                <a href="<?php echo esc_url($imprintUrl); ?>" target="_blank" class="align-top"><?php _e('Imprint', 'shapepress-dsgvo');?></a>
                                <span class="align-top">|</span>
                                <a href="<?php echo esc_url($privacyPolicyUrl); ?>" target="_blank" class="align-top"><?php echo esc_html(SPDSGVOSettings::get('privacy_policy_custom_header'));?></a>
                            </div> <!-- .link-wrapper -->

                            <div class="sp-dsgvo-lang-wrapper lwb-col-4 pl-0" style="padding-left: 15px">
                                <?php if(function_exists('icl_get_languages')) : ?>
                                    <?php $langs = apply_filters( 'wpml_active_languages', NULL, 'orderby=native_name&order=desc&skip_missing=1' ); ?>
                                    <?php if(count($langs) > 0) : ?>
                                        <div class="sp-dsgvo-popup-language-switcher">

                                            <?php foreach($langs as $lang) : ?>
                                                <?php if($lang['active'] == 1) : ?>
                                                    <span class="sp-dsgvo-lang-active align-top">
                                                        <img src="<?php echo esc_url($lang['country_flag_url']); ?>" style="vertical-align: top;"  alt="<?php _e('Country Flag', 'shapepress-dsgvo');?>"/>
                                                        <span style="vertical-align: top;"><?php echo esc_html($lang['native_name']); ?> </span>
                                                        <svg width="10" height="6">
                                                             <line x1="0" y1="0" x2="5" y2="5" />
                                                             <line x1="5" y1="5" x2="10" y2="0" />
                                                        </svg>
                                                    </span>
                                                    <?php break; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                            <div class="sp-dsgvo-lang-dropdown">
                                                <?php foreach($langs as $lang) : ?>
                                                    <a href="<?php echo esc_url($lang['url']); ?>">
                                                        <img src="<?php echo esc_url($lang['country_flag_url']); ?>" alt="<?php _e('Country flag', 'shapepress-dsgvo');?>" />
                                                        <span><?php echo esc_html($lang['native_name']); ?></span>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div><!-- .dsgvo-lang-dropdown -->

                                        </div><!-- .popup-language-switcher -->
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php
                                /**
                                 * WPGlobus language switcher.
                                 */
                                if ( class_exists( 'WPGlobus' ) ): ?>
                                    <div class="sp-dsgvo-popup-language-switcher">

                                        <?php

                                        $currentLanguage = WPGlobus::Config()->language;
                                        $enabled_languages = apply_filters( 'wpglobus_extra_languages', WPGlobus::Config()->enabled_languages, WPGlobus::Config()->language );
                                        ?>

                                        <span class="sp-dsgvo-lang-active">
                                        <img src="<?php echo esc_url(WPGlobus::Config()->flags_url . WPGlobus::Config()->flag[ $currentLanguage ]); ?>"  alt="<?php _e('Country flag', 'shapepress-dsgvo');?>" style="vertical-align: middle;"/>
                                        <span><?php echo esc_html(WPGlobus::Config()->en_language_name[$currentLanguage]); ?></span>
                                        <svg width="10" height="6">
                                             <line x1="0" y1="0" x2="5" y2="5" />
                                             <line x1="5" y1="5" x2="10" y2="0" />
                                        </svg>
                                    </span>

                                        <div class="sp-dsgvo-lang-dropdown">

                                            <?php

                                            /**
                                             * Filter that prevent using language that has `draft` status.
                                             * That works with module `Publish` from WPGlobus Plus add-on.
                                             */

                                            foreach ( $enabled_languages as $language ):
                                                $url = null;

                                                if ( $language != WPGlobus::Config()->language ) {
                                                    $url = WPGlobus_Utils::localize_current_url( $language );
                                                }

                                                echo '<a href="'.esc_url( $url ).'">
                                                    <img src="'.esc_url(WPGlobus::Config()->flags_url . WPGlobus::Config()->flag[ $language ]).'"  alt="'. __('Country flag', 'shapepress-dsgvo').'" />
                                                    <span>'.esc_html(WPGlobus::Config()->en_language_name[$language]).'</span>
                                                </a>';

                                            endforeach; ?>

                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div><!-- .lang-wrapper -->
                        </div>

                        <div class="sp-dsgvo-header-description-text lwb-row lwb-col-12 m-0 p-0">
                            <?php echo esc_html($introductionText); ?>
                        </div>
                    </div> <!--header wrapper xs-->

                    <div class="sp-dsgvo-header-wrapper-sm d-none d-sm-block">

                        <div class="lwb-row" style="margin-bottom: 3px;">

                            <div class="lwb-col-md-4 pr-2">
                                <div class="sp-dsgvo-logo-wrapper">
                                    <?php
                                    $src = sp_dsgvo_URL . 'public/images/legalwebio-icon.png';
                                    $img_id = $settings['logo_image_id'];
                                    if($img_id != '' && $img_id != '0') {
                                        $customLogo = wp_get_attachment_url(intval($img_id));
                                        if ($customLogo != false)
                                        {
                                            $src = $customLogo;
                                        }
                                    }
                                    ?>
                                    <img src="<?php echo esc_url($src); ?>" class="sp-dsgvo-popup-logo" alt="<?php _e('Logo of the popup', 'shapepress-dsgvo');?>" title="<?php _e('WP DSGVO Tools (GDPR) for Wordpress and WooCommerce.','shapepress-dsgvo') ?>" />
                                </div><!-- .logo-wrapper -->

                                <div class="sp-dsgvo-privacy-popup-title">
                                    <div class="sp-dsgvo-privacy-popup-title-general"> <?php _e('Data protection', 'shapepress-dsgvo');?></div>
                                    <div class="sp-dsgvo-privacy-popup-title-details" style="display: none"> <?php _e('Details', 'shapepress-dsgvo');?></div>

                                </div>
                            </div>
                            <div class="sp-dsgvo-link-wrapper lwb-col-md-5 px-0">
                                <a href="<?php echo esc_url($imprintUrl); ?>" target="_blank"><?php _e('Imprint', 'shapepress-dsgvo');?></a>
                                <span>|</span>
                                <a href="<?php echo esc_url($privacyPolicyUrl); ?>" target="_blank"><?php echo esc_html(SPDSGVOSettings::get('privacy_policy_custom_header'));?></a>
                            </div> <!-- .link-wrapper -->

                            <div class="sp-dsgvo-lang-wrapper lwb-col-md-2 px-0">
                                <?php if(function_exists('icl_get_languages')) : ?>
                                    <?php $langs = apply_filters( 'wpml_active_languages', NULL, 'orderby=native_name&order=desc&skip_missing=1' ); ?>
                                    <?php if(count($langs) > 0) : ?>
                                        <div class="sp-dsgvo-popup-language-switcher">

                                            <?php foreach($langs as $lang) : ?>
                                                <?php if($lang['active'] == 1) : ?>
                                                    <span class="sp-dsgvo-lang-active">
                                                        <img src="<?php echo esc_url($lang['country_flag_url']); ?>"  alt="<?php _e('Country flag', 'shapepress-dsgvo');?>" style="vertical-align: middle;"/>
                                                        <span><?php echo esc_html($lang['native_name']); ?></span>
                                                        <svg width="10" height="6">
                                                             <line x1="0" y1="0" x2="5" y2="5" />
                                                             <line x1="5" y1="5" x2="10" y2="0" />
                                                        </svg>
                                                    </span>
                                                    <?php break; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                            <div class="sp-dsgvo-lang-dropdown">
                                                <?php foreach($langs as $lang) : ?>
                                                    <a href="<?php echo esc_url($lang['url']); ?>">
                                                        <img src="<?php echo esc_url($lang['country_flag_url']); ?>"  alt="<?php _e('Country flag', 'shapepress-dsgvo');?>" />
                                                        <span><?php echo esc_html($lang['native_name']); ?></span>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div><!-- .dsgvo-lang-dropdown -->

                                        </div><!-- .popup-language-switcher -->
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php
                                /**
                                * WPGlobus language switcher.
                                */
                                if ( class_exists( 'WPGlobus' ) ): ?>
                                <div class="sp-dsgvo-popup-language-switcher">

                                    <?php

                                        $currentLanguage = WPGlobus::Config()->language;
                                        $enabled_languages = apply_filters( 'wpglobus_extra_languages', WPGlobus::Config()->enabled_languages, WPGlobus::Config()->language );
                                    ?>

                                    <span class="sp-dsgvo-lang-active">
                                        <img src="<?php echo esc_url(WPGlobus::Config()->flags_url . WPGlobus::Config()->flag[ $currentLanguage ]); ?>"  alt="<?php _e('Country flag', 'shapepress-dsgvo');?>" style="vertical-align: middle;"/>
                                        <span><?php echo esc_html(WPGlobus::Config()->en_language_name[$currentLanguage]); ?></span>
                                        <svg width="10" height="6">
                                             <line x1="0" y1="0" x2="5" y2="5" />
                                             <line x1="5" y1="5" x2="10" y2="0" />
                                        </svg>
                                    </span>

                                    <div class="sp-dsgvo-lang-dropdown">

                                        <?php

                                        /**
                                         * Filter that prevent using language that has `draft` status.
                                         * That works with module `Publish` from WPGlobus Plus add-on.
                                         */

                                        foreach ( $enabled_languages as $language ):
                                            $url = null;

                                            if ( $language != WPGlobus::Config()->language ) {
                                                $url = WPGlobus_Utils::localize_current_url( $language );
                                            }

                                            echo '<a href="'.esc_url( $url ).'">
                                                    <img src="'.esc_url(WPGlobus::Config()->flags_url . WPGlobus::Config()->flag[ $language ]).'"  alt="'. __('Country flag', 'shapepress-dsgvo').'" />
                                                    <span>'.esc_html(WPGlobus::Config()->en_language_name[$language]).'</span>
                                                </a>';

                                        endforeach; ?>

                                    </div>
                                </div>
                                <?php endif; ?>

                            </div><!-- .lang-wrapper -->
                            <div class="lwb-col-md-1" style="text-align: right">
                                <?php
                                $url = SPDSGVOSettings::get('close_button_url', '#');
                                $action = SPDSGVOSettings::get('close_button_action', '0');
                                $additional_class = '';
                                if($url == '' || $action == '' || $action == '0') {
                                    $url = '#';
                                    $additional_class = 'close';
                                }
                                if(function_exists('icl_translate')) {
                                    $url = icl_translate('shapepress-dsgvo', 'close_button_url', $url);
                                }
                                ?>
                                <a href="<?php echo esc_url($url); ?>" id="sp-dsgvo_popup_close-2" class="sp-dsgvo-popup-close <?php echo esc_attr($additional_class); ?>">
                                    <svg width="10" height="10">
                                        <line x1="0" y1="0" x2="10" y2="10" />
                                        <line x1="0" y1="10" x2="10" y2="0" />
                                    </svg><!-- #dsgvo_popup_close -->
                                </a>
                            </div>
                        </div><!-- line1 wrapper -->
                        <div class="sp-dsgvo-header-description-text lwb-row lwb-col-12 m-0 p-0">
                            <?php echo esc_html($introductionText); ?>
                        </div>

                    </div> <!--header wrapper sm-->
                </div><!-- .popup-top -->

                <div class="sp-dsgvo-privacy-content" id="sp-dsgvo-privacy-content">
                    <div id="sp-dsgvo-privacy-content-category-content" class="sp-dsgvo-privacy-content-category-content">
                        <?php

                        $allCategories = SPDSGVOCookieCategoryApi::getCookieCategories();

                        foreach ($allCategories as $category)
                        {
                            if ($integrationCountByCategory[$category['slug']] == 0) continue;
                            $this->writePopupCategory($category['slug'], $integrationCountByCategory[$category['slug']]);
                        }
                        ?>
                    </div>


                    <div class="sp-dsgvo-popup-more-information" id="sp-dsgvo-popup-more-information" style="display: none">
                        <div class="sp-dsgvo-popup-more-information-top lwb-row">
                            <div class="lwb-col-8 sp-dsgvo-popup-more-information-title" id="sp-dsgvo-popup-more-information-title"></div>
                        <div class="lwb-col-4 px-1">
                            <div class="sp-dsgvo-category-item-toggle float-right">
                                <label class="switch switch-green  mt-0 mb-2" id="sp-dsgvo-more-information-switch">
                                    <input type="checkbox" class="switch-input" value="1" id="sp-dsgvo-more-information-switch-cb" data-slug="" />
                                    <span class="switch-label" data-on="<?php _e('Yes', 'shapepress-dsgvo');?>" data-off="<?php _e('No', 'shapepress-dsgvo');?>"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="sp-dsgvo-popup-more-information-content sp-dsgvo-category-container m-0" >
                        <div id="sp-dsgvo-popup-more-information-content">
                        </div>
                        <div id="sp-dsgvo-popup-more-information-progress">
                            <div class="progress" id="progress-more-information">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <?php _e('Loading details', 'shapepress-dsgvo');?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lwb-row float-right my-1">
                        <a href="#" class="sp-dsgvo-popup-more-information-close lwb-col">
                            <svg height="25" width="25" viewBox="0 0 32 32" style="margin-right: 3px;vertical-align: middle;" aria-hidden="true">
                                <path d="M26.025 14.496l-14.286-.001 6.366-6.366L15.979 6 5.975 16.003 15.971 26l2.129-2.129-6.367-6.366h14.29z"/>
                            </svg>
                            <?php _e('Back', 'shapepress-dsgvo');?>
                        </a>
                    </div>
                    <div style="clear:both"></div>
                </div>

                <div id="sp-dsgvo-privacy-footer">
                    <div class="sp-dsgvo-privacy-bottom d-none d-sm-flex">

                        <?php if ($onlyOkButton == false): ?>
                        <a href="#" class="sp-dsgvo-popup-button sp-dsgvo-privacy-btn-accept-selection grey p-2">
                            <?php _e('Accept selection', 'shapepress-dsgvo');?>
                        </a>
                        <a href="#" class="sp-dsgvo-popup-button sp-dsgvo-privacy-btn-accept-nothing blue p-2" style="margin-left: 10px;">
                            <?php _e('Accept nothing', 'shapepress-dsgvo');?>
                        </a>
                        <a href="#" class="sp-dsgvo-popup-button sp-dsgvo-privacy-btn-accept-all green p-2 ml-auto">
                            <?php _e('Accept all', 'shapepress-dsgvo');?>
                        </a>
                        <?php else : ?>
                        <a href="#" class="sp-dsgvo-popup-button sp-dsgvo-privacy-btn-accept-all green p-2 ml-auto" style="padding-right: 30px !important; padding-left: 30px !important;">
                            <?php _e('Ok', 'shapepress-dsgvo');?>
                        </a>
                        <?php endif; ?>

                    </div> <!--sp-dsvgo-privacy-bottom -->
                    <div class="sp-dsgvo-privacy-bottom d-block d-sm-none">
                        <div class="lwb-row px-1">
                            <?php if ($onlyOkButton == false): ?>
                            <div class="lwb-col-4 px-1">
                                <a href="#" class="lwb-col sp-dsgvo-popup-button sp-dsgvo-privacy-btn-accept-selection grey ">
                                    <?php _e('Accept <br />selection', 'shapepress-dsgvo');?>
                                </a>
                            </div>
                            <div class="lwb-col-4 px-1">
                                <a href="#" class="lwb-col sp-dsgvo-popup-button sp-dsgvo-privacy-btn-accept-nothing blue ">
                                    <?php _e('Accept <br />nothing', 'shapepress-dsgvo');?>
                                </a>
                            </div>
                            <div class="lwb-col-4 px-1">
                                <a href="#" class="lwb-col sp-dsgvo-popup-button sp-dsgvo-privacy-btn-accept-all green ">
                                    <?php _e('Accept <br />all', 'shapepress-dsgvo');?>
                                </a>
                            </div>
                            <?php else : ?>
                            <div class="lwb-col-4 px-1" style="margin: 0 auto;">
                                <a href="#" class="lwb-col sp-dsgvo-popup-button sp-dsgvo-privacy-btn-accept-all green ">
                                    <?php _e('Ok', 'shapepress-dsgvo');?>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!--/noptimize-->
        <?php

    }

    public function writePopupCategory($categorySlug, $enabledIntegrationCount)
    {
        $categoryData = SPDSGVOCookieCategoryApi::getCookieCategory($categorySlug);
        if ($categoryData == null) return ;


        // fetch all integrations with given category and check if they are enabled
        $integrations = SPDSGVOIntegrationApiBase::getAllIntegrationApis($categorySlug, FALSE);

        $mandatoryIntegrationsEditable = SPDSGVOSettings::get('mandatory_integrations_editable') == '1';
        $isReadonly = ($categorySlug == SPDSGVOConstants::CATEGORY_SLUG_MANDATORY) && $mandatoryIntegrationsEditable == false;

        ?>
        <div class="sp-dsgvo-category-container">
            <div>
                <div class="sp-dsgvo-category-name lwb-row no-gutters">
                    <div class="lwb-col-12">
                        <?php esc_html_e($categoryData['title'], 'shapepress-dsgvo');?> <small>(<?php echo esc_html(sprintf(_n('%s '.__('Service','shapepress-dsgvo'), '%s '.__('Services','shapepress-dsgvo'), $enabledIntegrationCount, 'shapepress-dsgvo'), $enabledIntegrationCount));?>)</small>
                    </div>
                </div>
                <div class="lwb-row no-gutters">
                    <div class="sp-dsgvo-category-description lwb-col-9"><?php esc_html_e($categoryData['description'], 'shapepress-dsgvo');?></div>
                    <div class="sp-dsgvo-category-toggle lwb-col-3">

                        <label class="switch switch-green float-right">
                            <input type="checkbox" class="switch-input" value="1" name="sp-dsgvo-switch-category" <?php echo esc_attr($isReadonly ? 'checked disabled' : ''); ?> data-slug="<?php echo esc_attr($categorySlug);?>" id="sp-dsgvo-switch-category-<?php echo esc_attr($categorySlug);?>">
                            <span class="switch-label" data-on="<?php _e('Yes', 'shapepress-dsgvo');?>" data-off="<?php _e('No', 'shapepress-dsgvo');?>"></span>
                            <span class="switch-handle"></span>
                        </label>

                    </div>
                </div>
            </div>

            <?php foreach ($integrations as $integrationSlug => $integration) :
                if ($integration->getIsEnabled() == false) continue;
                if ($integration->getIsPremium() && $this->validLicence == false) continue;
                if ($integration->getShowInPopup() == false) continue;
                $settings = $integration->getSettings();
                $withTagmanager = (array_key_exists('usedTagmanager', $settings) && $settings['usedTagmanager'] != '');
                $usedTagmanager = array_key_exists('usedTagmanager', $settings) && $settings['usedTagmanager'] != '' ? $settings['usedTagmanager'] : '';
                $isLocal = (array_key_exists('implementationMode', $settings) && $settings['implementationMode'] == 'on-premises');
                $isReadonly = ($isLocal || $categorySlug == SPDSGVOConstants::CATEGORY_SLUG_MANDATORY) && $mandatoryIntegrationsEditable == false;
                ?>
                <hr />
                <div class="sp-dsgvo-category-item lwb-row no-gutters pl-1">
                    <div class="lwb-col-9 lwb-col-md-6">
                        <div class="sp-dsgvo-category-item-name">
                            <?php echo esc_html($integration->getName());?>
                            <?php if($withTagmanager) :?>
                                <small><?php echo esc_html(__('via', 'shapepress-dsgvo').' '. SPDSGVOConstants::getTagManager()[$usedTagmanager]);?></small>
                            <?php endif; ?>
                        </div>
                        <?php if($isLocal) :?>
                            <div class="sp-dsgvo-category-item-company"><?php _e('Local installation', 'shapepress-dsgvo');?></div>
                        <?php else: ?>
                            <div class="sp-dsgvo-category-item-company"><?php echo esc_html($integration->getCompany());?>, <?php echo esc_html($integration->getCountry());?></div>
                        <?php endif; ?>

                        <div class="sp-dsgvo-category-item-description-url d-block d-sm-none">
                            <a href="#" class="sp-dsgvo-more-information-link" data-slug="<?php echo esc_attr($integrationSlug);?>" data-title="<?php echo esc_attr($integration->getName());?>">&#9432; <?php _e('All Details', 'shapepress-dsgvo');?></a>
                        </div>
                    </div>
                    <div class="lwb-col-3 lwb-col-md-6 lwb-row no-gutters">
                        <div class="sp-dsgvo-category-item-description-url d-none d-sm-block lwb-col px-0 mx-0">
                            <a href="#" class="sp-dsgvo-more-information-link" data-slug="<?php echo esc_attr($integrationSlug);?>" data-title="<?php echo esc_attr($integration->getName());?>">&#9432; <?php _e('All Details', 'shapepress-dsgvo');?></a>
                        </div>
                        <div class="sp-dsgvo-category-item-toggle lwb-col px-0 mx-0">
                            <label class="switch switch-green float-right">
                                <input type="checkbox" class="switch-input sp-dsgvo-switch-integration" <?php echo esc_attr($isReadonly == true ? 'checked disabled' : '') ?> value="1" name="sp-dsgvo-switch-integration" data-slug="<?php echo esc_attr($integrationSlug);?>" data-category="<?php echo esc_attr($categorySlug)?>" id="sp-dsgvo-switch-integration-<?php echo esc_attr($integrationSlug)?>">
                                <span class="switch-label" data-on="<?php _e('Yes', 'shapepress-dsgvo');?>" data-off="<?php _e('No', 'shapepress-dsgvo');?>"></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <?php

  }

    public function writeHeaderScripts()
    {
        apply_filters('sp_dsgvo_integrations_head', array());

        // write custom styles
        require_once(SPDSGVO::pluginDir('public/inc/embedding-placeholder-styles.php'));

        if(SPDSGVOSettings::get('deactivate_load_popup_fonts') == '0') {
             ob_start();
            // Beginn der Ausgabe
            ?>

            <style>
                /* latin */
                @font-face {
                    font-family: 'Roboto';
                    font-style: italic;
                    font-weight: 300;
                    src: local('Roboto Light Italic'),
                    local('Roboto-LightItalic'),
                    url(<?php echo esc_url(sp_dsgvo_URL); ?>public/css/fonts/roboto/Roboto-LightItalic-webfont.woff) format('woff');
                    font-display: swap;

                }

                /* latin */
                @font-face {
                    font-family: 'Roboto';
                    font-style: italic;
                    font-weight: 400;
                    src: local('Roboto Italic'),
                    local('Roboto-Italic'),
                    url(<?php echo  esc_url(sp_dsgvo_URL);; ?>public/css/fonts/roboto/Roboto-Italic-webfont.woff) format('woff');
                    font-display: swap;
                }

                /* latin */
                @font-face {
                    font-family: 'Roboto';
                    font-style: italic;
                    font-weight: 700;
                    src: local('Roboto Bold Italic'),
                    local('Roboto-BoldItalic'),
                    url(<?php echo  esc_url(sp_dsgvo_URL);; ?>public/css/fonts/roboto/Roboto-BoldItalic-webfont.woff) format('woff');
                    font-display: swap;
                }

                /* latin */
                @font-face {
                    font-family: 'Roboto';
                    font-style: italic;
                    font-weight: 900;
                    src: local('Roboto Black Italic'),
                    local('Roboto-BlackItalic'),
                    url(<?php echo  esc_url(sp_dsgvo_URL);; ?>public/css/fonts/roboto/Roboto-BlackItalic-webfont.woff) format('woff');
                    font-display: swap;
                }

                /* latin */
                @font-face {
                    font-family: 'Roboto';
                    font-style: normal;
                    font-weight: 300;
                    src: local('Roboto Light'),
                    local('Roboto-Light'),
                    url(<?php echo  esc_url(sp_dsgvo_URL);; ?>public/css/fonts/roboto/Roboto-Light-webfont.woff) format('woff');
                    font-display: swap;
                }

                /* latin */
                @font-face {
                    font-family: 'Roboto';
                    font-style: normal;
                    font-weight: 400;
                    src: local('Roboto Regular'),
                    local('Roboto-Regular'),
                    url(<?php echo  esc_url(sp_dsgvo_URL);; ?>public/css/fonts/roboto/Roboto-Regular-webfont.woff) format('woff');
                    font-display: swap;
                }

                /* latin */
                @font-face {
                    font-family: 'Roboto';
                    font-style: normal;
                    font-weight: 700;
                    src: local('Roboto Bold'),
                    local('Roboto-Bold'),
                    url(<?php echo  esc_url(sp_dsgvo_URL);; ?>public/css/fonts/roboto/Roboto-Bold-webfont.woff) format('woff');
                    font-display: swap;
                }

                /* latin */
                @font-face {
                    font-family: 'Roboto';
                    font-style: normal;
                    font-weight: 900;
                    src: local('Roboto Black'),
                    local('Roboto-Black'),
                    url(<?php echo  esc_url(sp_dsgvo_URL);; ?>public/css/fonts/roboto/Roboto-Black-webfont.woff) format('woff');
                    font-display: swap;
                }
            </style>
            <?php
            // Ende der Ausgabe
            $html = ob_get_contents();
            ob_end_clean();
            echo wp_kses($html, array('style' => array()));
        }

    }

    public function writeBodyStartScripts()
    {
        apply_filters('sp_dsgvo_integrations_body', array());


    }

    // p912419
    public static function blockGoogleFonts()
    {
	    //add_filter( 'style_loader_tag', 'SPDSGVOPublic::removeGoogleLinkTags' , 999, 4 );
	    add_action( 'get_header',  'SPDSGVOPublic::startBuffer' );
	    add_action( 'wp_footer', 'SPDSGVOPublic::removeGoogleFonts' );
    }

	/**
	 * Remove all google fonts links in <head></head>
	 *
	 * @param $html
	 * @param $handle
	 * @param $href
	 * @param $media
	 *
	 * @return string
	 */
	public static function removeGoogleLinkTags( $html, $handle, $href, $media )
	{
		$markup = preg_replace( '/<!--(.*)-->/Uis', '', $html );
		preg_match_all( '#<link(?:\s+(?:(?!href\s*=\s*)[^>])+)?(?:\s+href\s*=\s*([\'"])((?:https?:)?\/\/fonts\.googleapis\.com\/css(?:(?!\1).)+)\1)(?:\s+[^>]*)?>#iU', $markup, $matches );

		if ( ! $matches[2] ) {
			return $html;
		}else{
			error_log('REMOVE FONT: ' . json_encode($matches[2]));
			return '';
		}
	}

	public static function startBuffer()
	{
		ob_start();
	}

	/**
	 * Remove all google fonts imports
	 */
	public static function removeGoogleFonts()
	{
		$patternImportUrl = '/(@import[\s]url\((?:"|\')((?:https?:)?\/\/fonts\.googleapis\.com\/css(?:(?!\1).)+)(?:"|\')\)\;)/';
		$patternLinkTag = '/<link(?:\s+(?:(?!href\s*=\s*)[^>])+)?(?:\s+href\s*=\s*([\'"])((?:https?:)?\/\/fonts\.googleapis\.com\/css(?:(?!\1).)+)\1)(?:\s+[^>]*)?>/';

		$content = ob_get_clean();

		// Find all fonts-googleapi imports
		preg_match_all($patternImportUrl, $content, $matchesImportUrl);
		preg_match_all($patternLinkTag, $content, $matchesLinkTag);
		$matches = array_merge($matchesImportUrl,$matchesLinkTag);

		foreach( $matches as $match ) {
			// Remove the imports
			$content = str_replace( $match, '', $content );
		}

		echo wp_kses_post($content);
	}

    public function writeFooterScripts()
    {
        apply_filters('sp_dsgvo_integrations_body_end', array());

        $this->cookieNotice();
        $this->policyPopup();

    }

    public function registerTextActionEndpoint()
    {
        register_rest_route( 'legalweb/v1', 'lwTextEndpoint',array(
            'methods'  => 'GET',
            'callback' => array($this, 'getLwText'),
            'permission_callback' => '__return_true',
            'args' => array(
                'locale',
                'slug',
                'textId',
                'includeTagManager'
            )
        ));
    }

    public function getLwText(WP_REST_Request $request){

        $locale = $request->get_param('locale');
        $slug = $request->get_param('slug');
        $textId = $request->get_param('textId');
        $includeTagManager = $request->get_param('includeTagManager','');
        //error_log('notice-action: '.$noticeKey);

        if ($locale == NULL || $locale == '')
        {
            return "invalid locale";
        }

        if ($slug == NULL || $slug == '')
        {
            return "invalid slug";
        }

        if ($slug == NULL || $slug == '')
        {
            return "invalid textId";
        }

        //special case for matomo, piwik and mautic. only in cloud mode they are in popup, so attach -cloud to get correct popup text
        $specialIntegrations = array('matomo', 'piwik', 'mautic');
        $webAgencyText = "";
        if (in_array($slug, $specialIntegrations)) {

            $settings = null;
            switch ($slug){
                case SPDSGVOMatomoApi::getInstance()->getSlug():
                    $settings = SPDSGVOMatomoApi::getInstance()->getSettings();
                    break;
                case SPDSGVOPiwikApi::getInstance()->getSlug():
                    $settings = SPDSGVOPiwikApi::getInstance()->getSettings();
                    break;
                case SPDSGVOMauticApi::getInstance()->getSlug():
                    $settings = SPDSGVOMauticApi::getInstance()->getSettings();
                    break;
            }

            $slug .=  '-';
            $slug .=  (array_key_exists('implementationMode',$settings)) ? $settings['implementationMode'] : 'on-premises';

            if (array_key_exists('agency', $settings['meta']) == true)
            {
                $webAgencyText = $settings['meta']['agency'];
            }
        }

        $result = SPDSGVOLanguageTools::getLwText($slug, $textId, $locale);

        if (strpos($slug, "by-agency") >= 0)
        {
            $result = str_replace("{web_agency}", $webAgencyText, $result);
        }

        if ($includeTagManager != '')
        {
            switch ($includeTagManager)
            {
                case 'google-tagmanager':
                    $tagTitle = SPDSGVOGoogleTagmanagerApi::getInstance()->getName();
                    $result .= "<br /><p><strong style='font-size:110%'>$tagTitle</strong><br />";
                    $result .= SPDSGVOLanguageTools::getLwText('google-tagmanager', $textId, $locale) . "</p>";
                    break;
                case 'matomo-tagmanager':

                    // nothing to do here for now because matomo only works as container
                    /*
                    $tagTitle = SPDSGVOMatomoTagmanagerApi::getInstance()->getName();
                    $result .= "<br /><p><strong style='font-size:110%'>$tagTitle</strong><br />";
                    $result .= SPDSGVOLanguageTools::getLwText('matomo-tagmanager', $textId, $locale) . "</p>";
                    */
                    break;
            }

        }

        return $result;
    }

    public function allowJSON($mime_types)
    {
        $mime_types['json'] = 'application/json';
        return $mime_types;
    }

    public function publicInit()
    {
        load_plugin_textdomain( 'shapepress-dsgvo', false, basename(dirname(__FILE__)) . '/languages/' );

        if (SPDSGVOSettings::get('auto_delete_erasure_requests') === '1') {
            if (SPDSGVOSettings::get('last_auto_delete_cron') !== date('z')) {
                foreach (SPDSGVOUnsubscriber::all() as $unsubscriber) {
                    if ($unsubscriber->delete_on < time()) {
                        $unsubscriber->unsubscribe();
                    }
                }
                SPDSGVOSettings::set('last_auto_delete_cron', date('z'));
            }
        }
    }

    public function adminInit()
    {
        load_plugin_textdomain( 'shapepress-dsgvo', false, basename(dirname(__FILE__)) . '/languages/' );
    }

    public function wooAddCustomFields( $checkout)
    {
		if (isValidPremiumEdition() == false) return;

        if (SPDSGVOSettings::get('woo_show_privacy_checkbox') === '1') {
            echo '<div id="cb-spdsgvo-privacy-policy"><h3>'.__('Terms: ','shapepress-dsgvo').'</h3>';


			 $cbLabel = SPDSGVOSettings::get('woo_privacy_text', '');
            echo wp_kses_post($cbLabel);

            echo '</div>';
        }
    }



}



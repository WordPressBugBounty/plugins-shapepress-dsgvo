<?php

class SPDSGVOLanguageTools
{
    public $defaultLanguage = 'en_EN';


    private static $instance;

    public function __construct()
    {
        $this->defaultLanguage = get_option('WPLANG', 'en_EN');
    }


    public static function init()
    {
        return new self;
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function checkIfLanguagePluginIsActive()
    {
        return $this->getTypeOfLanguagePlugin() != 'none';
    }

    public function getTypeOfLanguagePlugin()
    {
        if ((defined('ICL_LANGUAGE_CODE') || defined('POLYLANG_FILE') || class_exists( 'WPGlobus' )) == false) return 'none';
        else {
            if(function_exists('icl_get_languages')) return 'wpml';
            if(function_exists('pll_current_language')) return 'polylang';
            if(class_exists( 'WPGlobus' )) return 'wpglobus';
        }

        return "none";
    }

    public function getCurrentLanguageCode()
    {
        $currentLanguage = null;

        switch ($this->getTypeOfLanguagePlugin()) {
            case "wpml":
                $currentLanguage = apply_filters('wpml_current_language', null);
                break;
            case "polylang":
                $currentLanguage = pll_current_language();
                // get default language if we dont get a current one
                if (empty($currentLanguage)) {
                    $currentLanguage = pll_default_language();
                }
                break;
            case "wpglobus":
                $currentLanguage = WPGlobus::Config()->language;
                break;
            case "none":
                $currentLanguage = $this->defaultLanguage;
                break;
            default:
                $currentLanguage = $this->defaultLanguage;
        }

        if (empty($currentLanguage) || $currentLanguage === 'all') {
            $currentLanguage = $this->getDefaultLanguageCode();
        }

        return $this->normalizeLocaleCode($currentLanguage);
    }

    public function getDefaultLanguageCode()
    {
        $currentLanguage = null;

        switch ($this->getTypeOfLanguagePlugin())
        {
            case "wpml":
                $currentLanguage = apply_filters('wpml_default_language', null);
                break;
            case "polylang":
                $currentLanguage = pll_default_language();
                // get default language if we dont get a current one
                if (empty($currentLanguage)) {
                    $currentLanguage = pll_default_language();
                }
                break;
            case "wpglobus":
                $currentLanguage = WPGlobus::Config()->default_language;
                break;
            case "none":
                $currentLanguage = $this->defaultLanguage;
                break;
            default:
                $currentLanguage = $this->defaultLanguage;
        }

        if (empty($currentLanguage) || $currentLanguage === 'all') {
            $currentLanguage = $this->defaultLanguage;
        }

        return $this->normalizeLocaleCode($currentLanguage);

    }

    public function checkMinVersionOfTexts()
    {
        if (SPDSGVOSettings::get('legal_web_texts_version') < sp_dsgvo_LEGAL_TEXTS_MIN_VERSION)
        {
            self::updateLwTexts();
        }
    }

    static function normalizeLocaleCode($locale)
    {
        try {
            $locale = strtolower($locale);

            if (substr( $locale, 0, 2 ) === 'de') $locale = 'de_DE';
            if (substr( $locale, 0, 2 ) === 'en') $locale = 'en_EN';
            if (substr( $locale, 0, 2 ) === 'fr') $locale = 'fr_FR';
            if (substr( $locale, 0, 2 ) === 'it') $locale = 'it_IT';
            if ($locale === "") $locale = "en_EN";
            return $locale;
        } catch (Exception $e) {
            return 'en_EN';
        }
    }

    public static function updateLwTexts()
    {
        $lang =  SPDSGVOSettings::get('spdsgvo_company_info_countrycode', '');
        if ($lang == '') return;


        $version = SPDSGVOSettings::get('legal_web_texts_version', '0');

        $url = SPDSGVOConstants::LEGAL_WEB_TEXT_SERVICE_URL;
        $url .= '?lang=' . $lang;
        $url .= '&version=' . $version;
        $url .= '&apiVersion=' . SPDSGVOConstants::LEGAL_WEB_TEXT_SERVICE_VERSION;

        $request = wp_remote_get($url);

        if (is_wp_error($request)) {

            error_log(__('error while updating language texts: ', 'shapepress-dsgvo') . $request->get_error_message()); // Bail early
        } else {
            SPDSGVOSettings::set('legal_web_texts_last_check', time());

            $result = wp_remote_retrieve_body($request);
            if (strpos($result, "INFO") === 0)
            {
                // set current version as remote version because file is actual
                SPDSGVOSettings::set('legal_web_texts_remote_version', $version);
               // file actual, just return saved texts
               $existingTexts =  SPDSGVOSettings::get('legal_web_texts', '');
               return $existingTexts;
            } else if (strpos($result, "ERROR") !== 0) {

                $resultCleaned = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $result);

                // try to create json. if success then store
                $xmlTextsJson = json_decode($resultCleaned, true);

                if ($xmlTextsJson != null) {

                    $xmlTextsBase64 = $xmlTextsJson['Texts'];
                    if (strtoupper($lang) == 'CH') { // ch does not use an ß
                        $xmlTextsBase64 = str_replace("ß", "ss",$xmlTextsBase64);
                        $xmlTextsBase64 = str_replace("&szlig;", "ss",$xmlTextsBase64);
                    }
                    $xmlTextsBase64 = base64_encode($xmlTextsBase64);
                    $version = $xmlTextsJson['Version'];
                    $lang = $xmlTextsJson['Language'];
                    if ($version == null || $version == '') $version = time();

                    SPDSGVOSettings::set('legal_web_texts_remote_version', $version);
                    SPDSGVOSettings::set('legal_web_texts', $xmlTextsBase64);
                    SPDSGVOSettings::set('legal_web_texts_version', $version);
                    SPDSGVOSettings::set('legal_web_texts_lang', $lang);
                    SPDSGVOSettings::set('legal_web_texts_last_update', time());
                    SPDSGVOSettings::set('show_notice_privacy_policy_texts_outdated', '0');

                    return $xmlTextsBase64;
                } else {
                    $jsonError = json_last_error();
                    error_log('wrong texts received. json_error: '.$jsonError); // Bail early
                }

            } else
            {
                error_log('shapepress-dsgvo: updateLwTexts: '. $result);
            }
        }
    }


    static function getLwText($slug, $textId, $lang = '')
    {

        $enc = SPDSGVOSettings::get('legal_web_texts', '');
        if ($enc == null || strlen($enc) < 10)
        {
            $enc = self::updateLwTexts();
        }
        if ($enc == null || strlen($enc) < 10) return '';

        $dec = base64_decode($enc);
        $xmlTexts = json_decode($dec, true);
        if ($xmlTexts  == false) return '';

        if (array_key_exists($slug, $xmlTexts) == false) return '';

        if ($lang == '' )$lang = self::normalizeLocaleCode((new self)->getCurrentLanguageCode());
        if (array_key_exists($textId, $xmlTexts[$slug]) == false) return '';
        // check if needed lang exists. if not, take default lang
        if (array_key_exists($lang, $xmlTexts[$slug][$textId]) == false)
        {
            $defaultLang = self::normalizeLocaleCode(SPDSGVOLanguageTools::getInstance()->getDefaultLanguageCode());
            if (array_key_exists($defaultLang, $xmlTexts[$slug][$textId]) == false)
            {
                return trim($xmlTexts[$slug][$textId]['en_EN']);
            } else {
                return trim($xmlTexts[$slug][$textId][$defaultLang]);
            }

        }

        return trim($xmlTexts[$slug][$textId][$lang]);
    }

    static function getPrivacyPolicyText($slug, $lang='')
    {
        return self::getLwText($slug, 'privacy-policy', $lang);
    }
}
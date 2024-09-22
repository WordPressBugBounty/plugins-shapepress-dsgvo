<?php

class SPDSGVOJavascript
{
    final public static function getInstance()
    {
        static $instances = array();

        $calledClass = get_called_class();

        if (!isset($instances[$calledClass]))
        {
            $instances[$calledClass] = new $calledClass();
        }

        return $instances[$calledClass];
    }

    public function register()
    {
        $settings = SPDSGVOSettings::getAll();

        $integrationConfig = array();

        $allCategories = SPDSGVOCookieCategoryApi::getCookieCategories();

        $allIntegrationSlugs = [];
        $gtmNeeded = 0;
        $mtmNeeded = 0;
        foreach ($allCategories as $currentCategory)
        {
            $categorySlug = $currentCategory['slug'];
            $categoryData = $currentCategory;
            if ($categoryData == null) return;


            // fetch all integrations with given category and check if they are enabled
            $integrations = SPDSGVOIntegrationApiBase::getAllIntegrationApis($categorySlug, FALSE);

            foreach ($integrations as $integrationSlug => $integration)
            {
                if ($integration->getIsEnabled() == false) continue;
                //if ($integration->getIfOptInNeeded() == false) continue;

                $allIntegrationSlugs[] = $integrationSlug;

                $integrationSettings = $integration->getSettings();

                $integrationConfig[] = [
                    'slug' => $integrationSlug,
                    'category' => $integration->getCategory(),
                    //'enabled' => $integration->getIsEnabled(),
                    'cookieNames' =>  $integration->getCookieNames(),
                    'insertLocation' =>  $integration->getInsertLocation(),
                    'usedTagmanager' => (array_key_exists('usedTagmanager', $integrationSettings) && $integrationSettings['usedTagmanager'] != '') ? $integrationSettings['usedTagmanager'] : '',
                    'jsCode' => base64_encode(($integration->getJsCode($integrationSettings))),
                    'hosts' => $integration->getHosts(),
                    'placeholder' => empty($integration->getHosts()) == false ? SPDSGVOEmbeddingsManager::getDummyPlaceholderForMutationObserver($integration) : ''
                ];

                $gtmNeeded += (array_key_exists('usedTagmanager', $integrationSettings) && $integrationSettings['usedTagmanager'] == SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug()) ? 1 : 0;
                $mtmNeeded += (array_key_exists('usedTagmanager', $integrationSettings) && $integrationSettings['usedTagmanager'] == SPDSGVOMatomoTagmanagerApi::getInstance()->getSlug()) ? 1 : 0;

            }
        }

        if ($gtmNeeded > 0)
        {
            $allIntegrationSlugs[] = SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug();
            $integrationConfig[] = [
                'slug' => SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug(),
                'category' => SPDSGVOGoogleTagmanagerApi::getInstance()->getCategory(),
                //'enabled' => $integration->getIsEnabled(),
                'cookieNames' =>  SPDSGVOGoogleTagmanagerApi::getInstance()->getCookieNames(),
                'insertLocation' =>  SPDSGVOGoogleTagmanagerApi::getInstance()->getInsertLocation(),
                'usedTagmanager' => '',
                'jsCode' => base64_encode((SPDSGVOGoogleTagmanagerApi::getInstance()->getJsCode())),
                'hosts' => SPDSGVOGoogleTagmanagerApi::getInstance()->getHosts()
            ];
        }

        if ($mtmNeeded > 0)
        {
            $allIntegrationSlugs[] = SPDSGVOMatomoTagmanagerApi::getInstance()->getSlug();
            $integrationConfig[] = [
                'slug' => SPDSGVOMatomoTagmanagerApi::getInstance()->getSlug(),
                'category' => SPDSGVOMatomoTagmanagerApi::getInstance()->getCategory(),
                //'enabled' => $integration->getIsEnabled(),
                'cookieNames' =>  SPDSGVOMatomoTagmanagerApi::getInstance()->getCookieNames(),
                'insertLocation' =>  SPDSGVOMatomoTagmanagerApi::getInstance()->getInsertLocation(),
                'usedTagmanager' => '',
                'jsCode' => base64_encode((SPDSGVOMatomoTagmanagerApi::getInstance()->getJsCode())),
                'hosts' => SPDSGVOMatomoTagmanagerApi::getInstance()->getHosts()
            ];
        }

        $generalConfig = [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'wpJsonUrl' => rest_url('legalweb/v1/'),
            'cookieName' => SPDSGVOConstants::CCOKIE_NAME,
            'cookieVersion'  => $settings['cookie_version'],
            'cookieLifeTime' => $settings['cn_cookie_validity'],
            'cookieLifeTimeDismiss' => $settings['cn_cookie_validity_dismiss'],
            //'cookieDomain' => '',
            'locale' => SPDSGVOLanguageTools::getInstance()->getCurrentLanguageCode(),
            'privacyPolicyPageId' => $settings['privacy_policy_page'],
            'privacyPolicyPageUrl' => get_permalink($settings['privacy_policy_page']),
            'imprintPageId' => $settings['imprint_page'],
            'imprintPageUrl' => get_permalink($settings['imprint_page']),
            'showNoticeOnClose' => $settings['show_notice_on_close'],
            'initialDisplayType' => $settings['cookie_notice_display'],
            'allIntegrationSlugs' => $allIntegrationSlugs,
            'noticeHideEffect' =>$settings['cn_animation'],
            'noticeOnScroll' => false,
            'noticeOnScrollOffset' => 100,
            'currentPageId' => get_the_ID(),
            'forceCookieInfo' => $settings['force_cookie_info'],
            'clientSideBlocking' => $settings['embed_enable_js_blocking']
        ];

        wp_localize_script(sp_dsgvo_NAME, 'spDsgvoGeneralConfig', $generalConfig);


        wp_localize_script(sp_dsgvo_NAME, 'spDsgvoIntegrationConfig', $integrationConfig);

    }

}
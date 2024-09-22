<?php

Class SPDSGVOLegalWebTextAction extends SPDSGVOAjaxAction{

    protected $action = 'legal-web-text-action';

    protected function run(){
       
        $locale = $this->get('locale');
        $slug = $this->get('slug');
        $textId = $this->get('textId');
        $includeTagManager = $this->get('includeTagManager','');
        //error_log('notice-action: '.$noticeKey);
        
        if ($locale == NULL || $locale == '')
        {
            echo "invalid locale";
            die;
        }

        if ($slug == NULL || $slug == '')
        {
            echo "invalid slug";
            die;
        }

        if ($slug == NULL || $slug == '')
        {
            echo "invalid textId";
            die;
        }

        //special case for matomo, piwik, mautic. only in cloud mode they are in popup, so attach -cloud to get correct popup text
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

        echo wp_kses_post($result);
        
        die;
    }
}

SPDSGVOLegalWebTextAction::listen();
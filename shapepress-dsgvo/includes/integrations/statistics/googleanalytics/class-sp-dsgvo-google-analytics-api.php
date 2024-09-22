<?php

class SPDSGVOGoogleAnalyticsApi extends SPDSGVOIntegrationApiBase
{

    protected function __construct()
    {
        $this->name = "Google Analytics";
        $this->company = "Google LLC";
        $this->country = "USA";
        $this->slug = 'google-analytics';
        $this->storageId = 'ga';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_STATISTICS;
        $this->cookieNames = '_ga;_gat;_gid';
        $this->insertLocation = 'head';
        $this->isTagManagerCompatible = true;
        $this->supportedTagManager[] = SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug();
        $this->supportedTagManager[] = SPDSGVOMatomoTagmanagerApi::getInstance()->getSlug();
    }

    public function getDefaultJsCode($propertyId)
    {
        return "
        <!-- Google Analytics -->
        <script>      
                    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
                    ga('create', '$propertyId', 'auto');
                    ga('set', 'anonymizeIp', true);
                    ga('send', 'pageview');
                    </script>
        <script async src='https://www.google-analytics.com/analytics.js'></script>        
        <!-- End Google Analytics -->";
    }


}

SPDSGVOGoogleAnalyticsApi::getInstance()->register();

add_filter('sp_dsgvo_integrations_head', [SPDSGVOGoogleAnalyticsApi::getInstance(),'processHeadAction']);
add_filter('sp_dsgvo_integrations_body_end',[SPDSGVOGoogleAnalyticsApi::getInstance(), 'processBodyEndAction']);
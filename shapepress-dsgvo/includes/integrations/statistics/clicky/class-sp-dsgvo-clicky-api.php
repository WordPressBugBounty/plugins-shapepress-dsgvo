<?php

class SPDSGVOClickyApi extends SPDSGVOIntegrationApiBase
{

    protected function __construct()
    {
        $this->name = "Clicky";
        $this->company = "Roxr Software Ltd";
        $this->country = "USA";
        $this->slug = 'clicky';
        $this->storageId = 'clicky';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_STATISTICS;
        $this->cookieNames = '_first_pageview;_jsuid;cluid;heatmaps_*';
        $this->isPremium = true;
    }

    public function getDefaultJsCode($propertyId)
    {
        return "
        <!-- $this->name -->
<script>var clicky_site_ids = clicky_site_ids || []; clicky_site_ids.push($propertyId);</script>
<script async src='//static.getclicky.com/js'></script>
<noscript><p><img alt='Clicky' width='1' height='1' src='//in.getclicky.com/".$propertyId."ns.gif' /></p></noscript>
        <!-- End $this->name -->";
    }

}

SPDSGVOClickyApi::getInstance()->register();

//add_filter('sp_dsgvo_integrations_head', [SPDSGVOClickyApi::getInstance(),'processHeadAction']);
add_filter('sp_dsgvo_integrations_body_end',[SPDSGVOClickyApi::getInstance(), 'processBodyEndAction']);
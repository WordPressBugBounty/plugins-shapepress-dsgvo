<?php

class SPDSGVOEtrackerApi extends SPDSGVOIntegrationApiBase
{

    protected function __construct()
    {
        $this->name = "Etracker";
        $this->company = "etracker GmbH";
        $this->country = "Germany";
        $this->slug = 'etracker';
        $this->storageId = 'etracker';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_STATISTICS;
        $this->cookieNames = 'cntcookie;_et_coid;GS3_v;BT_sdc;BT_pdc;BT_ecl';
        $this->isPremium = true;
    }

    public function getDefaultJsCode($propertyId)
    {
        return "<!-- $this->name -->
<!-- Copyright (c) 2000-2018 etracker GmbH. All rights reserved. -->
<!-- This material may not be reproduced, displayed, modified or distributed -->
<!-- without the express prior written permission of the copyright holder. -->
<!-- etracker tracklet 4.1 -->
<script type='text/javascript'>
//var et_pagename = '';
//var et_areas = '';
//var et_tval = '';
//var et_tonr = '';
//var et_tsale = 0;
//var et_basket = '';
//var et_cust = '';
</script>
<script id='_etLoader' type='text/javascript' charset='UTF-8' data-secure-code='$propertyId' data-respect-dnt='true' src='//static.etracker.com/code/e.js'></script>
<!-- etracker tracklet 4.1 end -->
        <!-- End $this->name -->";
    }

}

SPDSGVOEtrackerApi::getInstance()->register();

//add_filter('sp_dsgvo_integrations_head', [SPDSGVOEtrackerApi::getInstance(),'processHeadAction']);
add_filter('sp_dsgvo_integrations_body_end',[SPDSGVOEtrackerApi::getInstance(), 'processBodyEndAction']);
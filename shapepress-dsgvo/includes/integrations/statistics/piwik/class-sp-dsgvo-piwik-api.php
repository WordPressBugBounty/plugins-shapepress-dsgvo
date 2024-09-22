<?php

class SPDSGVOPiwikApi extends SPDSGVOIntegrationApiBase
{

    protected function __construct()
    {
        $this->name = "Piwik";
        $this->company = "Piwik PRO GmbH";
        $this->country = "Germany";
        $this->slug = 'piwik';
        $this->storageId = 'piwik';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_STATISTICS;
        $this->cookieNames = '_pk_*.*';
        $this->isPremium = true;
        $this->insertLocation = 'head';
        $this->optionTechMandatory = true;
        $this->supportsMultipleImplementationModes = true;
        $this->implementationModes = ['on-premises', 'by-agency', 'cloud'];
    }

    public function getDefaultJsCode($propertyId)
    {
        return "<!-- $this->name -->
<script type='text/javascript'>
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u='https://your-instance-name.piwik.pro/';
    _paq.push(['setTrackerUrl', u+'ppms.php']);
    _paq.push(['setSiteId', 'XXX-XXX-XXX-XXX-XXX']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'ppms.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
        <!-- End $this->name -->";
    }


    public function getIfOptInNeeded()
    {
        $settings = $this->getSettings();
        if ($this->optionTechMandatory == true && $settings['showAsTechMandatory'] == 1) return false;

        return $settings['implementationMode'] != 'on-premises';
    }

    public function getShowInPopup()
    {
        $settings = $this->getSettings();

        if (SPDSGVOSettings::get('force_cookie_info') == '1') return true;
        return $settings['implementationMode'] != 'on-premises';
    }


    public function getDefaultSettings($ownCodeEnabledByDefault = false)
    {
        $defaults =  parent::getDefaultSettings($ownCodeEnabledByDefault);

        $defaults['implementationMode'] = 'on-premises';

        return $defaults;
    }

    public function getSettings()
    {
        $settings =  parent::getSettings();
        $settings['useOwnCode'] = '1';

        if (array_key_exists('agency', $settings['meta']) == false)
        {
            $settings['meta']['agency'] = '';
        }

        // fallback for cloud mode
        $hasImplementationModeKey = array_key_exists('implementationMode', $settings);
        if (array_key_exists('cloudMode', $settings)
            && $hasImplementationModeKey == false && !empty($settings['implementationMode']))
        {
            $settings['implementationMode'] =  $settings['cloudMode'] == '1' ? 'cloud' : 'on-premises';
        }

        return $settings;
    }

}

SPDSGVOPiwikApi::getInstance()->register();

add_filter('sp_dsgvo_integrations_head', [SPDSGVOPiwikApi::getInstance(),'processHeadAction']);
add_filter('sp_dsgvo_integrations_body_end',[SPDSGVOPiwikApi::getInstance(), 'processBodyEndAction']);
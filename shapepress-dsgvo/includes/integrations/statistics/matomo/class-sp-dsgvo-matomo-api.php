<?php

class SPDSGVOMatomoApi extends SPDSGVOIntegrationApiBase
{

    protected function __construct()
    {
        $this->name = "Matomo";
        $this->company = "InnoCraft Ltd";
        $this->country = "New Zealand";
        $this->slug = 'matomo';
        $this->storageId = 'matomo';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_STATISTICS;
        $this->cookieNames = '_pk_*.*';
        $this->insertLocation = 'head';
        $this->optionTechMandatory = true;
        $this->isTagManagerCompatible = true;
        $this->supportedTagManager[] = SPDSGVOMatomoTagmanagerApi::getInstance()->getSlug();
        $this->supportsMultipleImplementationModes = true;
        $this->implementationModes = ['on-premises', 'by-agency', 'cloud'];
    }

    public function getDefaultJsCode($propertyId)
    {

        return "<!-- $this->name -->
<script type='text/javascript'>
  var _paq = window._paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u='//{Matomo_URL}/';
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '{IDSITE}']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
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

SPDSGVOMatomoApi::getInstance()->register();

add_filter('sp_dsgvo_integrations_head', [SPDSGVOMatomoApi::getInstance(),'processHeadAction']);
add_filter('sp_dsgvo_integrations_body_end',[SPDSGVOMatomoApi::getInstance(), 'processBodyEndAction']);
<?php

class SPDSGVOMauticApi extends SPDSGVOIntegrationApiBase
{

    protected function __construct()
    {
        $this->name = "Mautic";
        $this->company = "Acquia Inc";
        $this->country = "USA";
        $this->slug = 'mautic';
        $this->storageId = 'mautic';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_STATISTICS;
        $this->cookieNames = 'mautic_*;mtc_*'; // mehrer cookie pattern spezifizeiren
        $this->insertLocation = 'body';
        $this->optionTechMandatory = true;
        $this->supportsMultipleImplementationModes = true;
        $this->implementationModes = ['on-premises', 'by-agency'];
    }

    public function getDefaultJsCode($propertyId)
    {

        return "<!-- $this->name -->
		<script type='text/javascript'>
		    (function(w,d,t,u,n,a,m){w['MauticTrackingObject']=n;
		        w[n]=w[n]||function(){(w[n].q=w[n].q||[]).push(arguments)},a=d.createElement(t),
		        m=d.getElementsByTagName(t)[0];a.async=1;a.src=u;m.parentNode.insertBefore(a,m)
		    })(window,document,'script','http(s)://yourmautic.com/mtc.js','mt');
		
		    mt('send', 'pageview');
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

SPDSGVOMauticApi::getInstance()->register();

add_filter('sp_dsgvo_integrations_head', [SPDSGVOMauticApi::getInstance(),'processHeadAction']);
add_filter('sp_dsgvo_integrations_body_end',[SPDSGVOMauticApi::getInstance(), 'processBodyEndAction']);
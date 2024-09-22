<?php

abstract class SPDSGVOEmbeddingApiBase
{
    static $instances = array();

    public $name = "";
    public $company = "";
    public $country = "";
    public $slug = '';
    public $storageId = '';
    public $cookieCategory ='';
    public $cookieNames = '';
    public $isPremium = true;
    public $optInNeeded = true;
    public $optionTechMandatory = false;
    public $showPlaceholder = true;
    public $hosts = '';
    public $overlayText='';
    public $additionalCss='';

    protected function __construct()
    {
        $this->overlayText = SPDSGVOLanguageTools::getLwText($this->slug, 'overlay', '');
    }

    final function __clone()
    {
    }

    final public static function getInstance()
    {
        $calledClass = get_called_class();

        if (!isset($instances[$calledClass]))
        {
            $instances[$calledClass] = new $calledClass();
        }

        return $instances[$calledClass];
    }

    public final function getName()
    {
        return $this->name;
    }

    public final function getCompany()
    {
        return $this->company;
    }

    public final function getCountry()
    {
        return __($this->country, 'shapepress-dsgvo');
    }

    public final function getStorageId()
    {
        return $this->storageId;
    }

    public final function getSlug()
    {
        return $this->slug;
    }

    public final function getCookieNames()
    {
        return $this->cookieNames;
    }

    public final function getHosts()
    {
        return $this->hosts;
    }

    public final function getHostsArray()
    {
        return explode(';', $this->hosts);
    }

    public final function getCategory($backendMode = false)
    {
        if ($backendMode == false && $this->getIsTechMandatoryOptionEnabled() == true)
        {
            $settings = $this->getSettings();
            if ($settings['showAsTechMandatory'] == '1') return SPDSGVOConstants::CATEGORY_SLUG_MANDATORY;
            else return $this->cookieCategory;
        } else {
            return $this->cookieCategory;
        }
    }

    public final function getIsPremium()
    {
        return $this->isPremium;
    }

    public function getIfOptInNeeded()
    {
        return $this->optInNeeded;

    }

    public function getShowInPopup()
    {
        return $this->optInNeeded;
    }


    public final function getInsertLocation()
    {
        return '';

    }

    public final function getJsCode()
    {
        return '';

    }

    public final function getOverlayText()
    {
        return $this->overlayText;
    }

    public function getIsTechMandatoryOptionEnabled()
    {
        return $this->optionTechMandatory;
    }

    public function getDefaultSettings($ownCodeEnabledByDefault = false)
    {
        $settings = array();
        $settings['isEnabled'] = '0';
        $settings['propertyId'] = '';
        $settings['cookieNames'] = $this->cookieNames;
        $settings['showAsTechMandatory'] = '0';
        $settings['showPlaceholder'] = '';
        $settings['css'] = '';

        return $settings;
    }


    public final function checkIfIntegrationIsAllowed($integrationSlug)
    {

        // first check if the visitor interacted with our notice/plugin
        $cookieDecisionMade = isset($_COOKIE[SPDSGVOConstants::CCOKIE_NAME]);
        if ($cookieDecisionMade == false) return false;

	    // the settings are stored in an array like  "integration-slug" => '0'
	    $integrationSettings = (json_decode(stripslashes($_COOKIE[SPDSGVOConstants::CCOKIE_NAME])));
	    // check if it is a class and has the property
	    if ($integrationSettings instanceof stdClass  == false || !property_exists($integrationSettings, 'integrations')) return false;

	    $integrationSettingsArray = (array)$integrationSettings;
	    $integrationSettingsArray = spDsgvo_recursive_sanitize_text_field($integrationSettingsArray);

	    $enabledIntegrations = $integrationSettingsArray['integrations'];//filter_var_array($integrationSettings->integrations,FILTER_SANITIZE_ENCODED);
	    $integrationSettings = null; // we only need here the array of enabled integrations, which we sanitze and filter in the above lines. the rest gets nulled
	    if ($enabledIntegrations == false || isset($enabledIntegrations) == false) return false;

	    return in_array($integrationSlug, $enabledIntegrations);


    }

    public function getIsEnabled()
    {
        $settings = $this->getSettings();

        return $settings['isEnabled'] == '1';
    }

    public function getSettings()
    {
        $storageId = 'integration_'.$this->storageId;
        $defaultSettings = $this->getDefaultSettings();
        $settings = SPDSGVOSettings::get($storageId);
        if (is_array($settings) == false) $settings = [];

        $settings = array_merge($defaultSettings, $settings);

        return $settings;
    }

    public final function setSettings($settings)
    {
        $storageId = 'integration_'.$this->storageId;

        SPDSGVOSettings::set($storageId, $settings);
        SPDSGVOCacheManager::clearCaches();
    }

    protected function checkIfIntegrationIsAllowedByCookie($settings)
    {
        $integrationAllowed = false;
        if ($this->getIfOptInNeeded() == false) return true;

        if (array_key_exists('cloudMode', $settings) && $settings['cloudMode'] == '0')
        {
            $integrationAllowed = true;
        } else
        {
            $integrationAllowed = $this->checkIfIntegrationIsAllowed($this->slug);
        }

        return $integrationAllowed;
    }

    public function getOptInContentReplacementHtml($content)
    {

        $output = '<div class="sp-dsgvo-blocked-embedding-placeholder sp-dsgvo-blocked-embedding-placeholder-'.$this->slug.'">';
        $output .='  <div class="sp-dsgvo-blocked-embedding-placeholder-header"><img class="sp-dsgvo-blocked-embedding-placeholder-header-icon" src="'. SPDSGVO::pluginURI('public/images/embeddings/icon-'.$this->slug .'.svg') .'"/>'.sprintf(__('We need your consent to load the content of %s.','shapepress-dsgvo'), $this->name).'</div>';
        $output .='  <div class="sp-dsgvo-blocked-embedding-placeholder-body">';
        $output .=      $this->overlayText;
        $output .='   <div class="sp-dsgvo-blocked-embedding-button-container"> <a href="#" class="sp-dsgvo-direct-enable-popup sp-dsgvo-blocked-embedding-button-enable" data-slug="'.$this->slug.'">'.__('Click here to enable this content.','shapepress-dsgvo').'</a></div>';
        $output .='  </div>';
        if (empty($this->additionalCss) == false) $output.= '<style>'.$this->additionalCss .'</style>';

        $output .='</div>';

        return $output;
    }

    public final function register(){
        $class = get_called_class();
        $self = new $class();

        add_filter('sp_dsgvo_integrationapis_'.$this->getCategory(), array($class::getInstance(), 'registerCallback'));

    }

    public function registerCallback($integrations)
    {

        $class = get_called_class();
        $slug = $class::getInstance()->getSlug();

        $integrations[$slug] = $class::getInstance();
        return $integrations;

    }

    public static function getAllIntegrationApis($type, $safe = TRUE)
    {
        return apply_filters('sp_dsgvo_integrationapis_'.$type, array());
    }

}
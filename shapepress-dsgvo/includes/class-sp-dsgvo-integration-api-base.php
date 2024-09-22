<?php

abstract class SPDSGVOIntegrationApiBase
{

    public $name = "";
    public $company = "";
    public $country = "";
    public $slug = '';
    public $storageId = '';
    public $cookieCategory ='';
    public $cookieNames = '';
    public $isPremium = false;
    public $insertLocation = 'body';
    public $isTagManagerCompatible = false;
    public $supportedTagManager = [];
    public $optInNeeded = true;
    public $optionTechMandatory = false;
    public $supportsMultipleImplementationModes = false;
    public $implementationModes = [];
    public $hosts = '';

    protected function __construct()
    {
    }

    final function __clone()
    {
    }

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

    public final function getInsertLocation()
    {
        return $this->insertLocation;

    }

    public final function getIsTagManagerCompatible()
    {
        return $this->isTagManagerCompatible;
    }

    public final function getCompatibleTagManager()
    {
        $allTagmanager = SPDSGVOConstants::getTagManager();

        $result = [];
        foreach ($allTagmanager as $slug => $name)
        {
            if (in_array($slug, $this->supportedTagManager)) $result[$slug] = $name;
        }

        return $result;
    }

    public final function getSupportsMultipleImplementationModes()
    {
        return $this->supportsMultipleImplementationModes;
    }

    public final function getImplementationModes()
    {
        $allModes = SPDSGVOConstants::getWayOfIntegrationModes();

        $result = [];
        foreach ($allModes as $slug => $name)
        {
            if (in_array($slug, $this->implementationModes)) $result[$slug] = $name;
        }

        return $result;
    }


    public function getIfOptInNeeded()
    {
        return $this->optInNeeded;

    }

    public function getShowInPopup()
    {
        return $this->optInNeeded;
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
        $settings['useOwnCode'] = $ownCodeEnabledByDefault ? '1' : '0';
        $settings['jsCode'] = $this->getDefaultJsCode('YourCodeHere');
        $settings['cookieNames'] = $this->cookieNames;
        $settings['showAsTechMandatory'] = '0';
        $settings['usedTagmanager'] = '';
        $settings['implementationMode'] = '';
        $settings['meta'] = [];

        return $settings;
    }

    public function getJsCode($settings = null)
    {
        if (isset($settings) == false)
        {
            $settings = $this->getSettings();
        }

        if (empty($settings['jsCode'])) {
            $settings['jsCode'] = $this->getDefaultJsCode($settings['propertyId']);
        }

        return $settings['jsCode'];
    }

	public function validateJsCode($code){

		return $code;
	}

	function getAllowedHtmlForScriptsForKses() {
		return  array_merge(
			wp_kses_allowed_html( 'post' ),
			array(
				'script' => array(
					'type' => array(),
					'src' => array(),
					'charset' => array(),
					'async' => array()
				),
				'noscript' => array(),
				'style' => array(
					'type' => array()
				),
				'iframe' => array(
					'src' => array(),
					'height' => array(),
					'width' => array(),
					'frameborder' => array(),
					'allowfullscreen' => array()
				)
			)
		);

	}

    public final function checkIfIntegrationIsAllowed($integrationSlug)
    {
        // first check if the visitor interacted with our notice/plugin
        $cookieDecisionMade = isset($_COOKIE[SPDSGVOConstants::CCOKIE_NAME]);
        if ($cookieDecisionMade == false) return false;

        // the settings are stored in an array like  "integration-slug" => '0'
	    $integrationSettings = sanitize_text_field(json_decode(stripslashes($_COOKIE[SPDSGVOConstants::CCOKIE_NAME])));
		// check if it is a class and has the property
		if ($integrationSettings instanceof stdClass  == false || !property_exists($integrationSettings, 'integrations')) return false;

	    $enabledIntegrations = filter_var_array($integrationSettings->integrations,FILTER_SANITIZE_ENCODED);
	    $integrationSettings = null; // we only need here the array of enabled integrations, which we sanitze and filter in the above lines. the rest gets nulled
	    if ($enabledIntegrations == false || isset($enabledIntegrations) == false) return false;

        return in_array($integrationSlug, $enabledIntegrations);


    }

    public final function getIsEnabled()
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

        $hadUsedTagManagerKey = array_key_exists('usedTagmanager', $settings);
        $settings = array_merge($defaultSettings, $settings);

        // fallback to set gtag manager in case of old property
        if (array_key_exists('withGtm', $settings) && $settings['withGtm'] == '1' && $hadUsedTagManagerKey == false && !empty($settings['usedTagmanager']))
        {
            $settings['usedTagmanager'] = SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug();
        }

        return $settings;
    }

    public final function setSettings($settings)
    {
        // remove unneeded setting keys which got replaced or used in another way
        if (array_key_exists('withGtm', $settings)) unset($settings['withGtm']);
        if (array_key_exists('cloudMode', $settings)) unset($settings['cloudMode']);

        $storageId = 'integration_'.$this->storageId;

        SPDSGVOSettings::set($storageId, $settings);
        SPDSGVOCacheManager::clearCaches();
    }

    protected function checkIfIntegrationIsAllowedByCookie($settings)
    {
        $integrationAllowed = false;
        if ($this->getIfOptInNeeded() == false) return true;

        if (array_key_exists('implementationMode', $settings) && $settings['implementationMode'] == 'on-premises')
        {
            $integrationAllowed = true;
        } else
        {
            $integrationAllowed = $this->checkIfIntegrationIsAllowed($this->slug);
        }

        return $integrationAllowed;
    }

    public function processHeadAction()
    {
        if ($this->insertLocation != 'head') return;

        $settings = $this->getSettings();

        if ($settings['isEnabled'] == '0') return;
        $propertyId = $settings['propertyId'];

        $integrationAllowed = $this->checkIfIntegrationIsAllowedByCookie($settings);

        $jsCode = $this->getJsCode($settings);

        $result = "";

        $result = "<!-- id='sp-dsgvo-script-container-$this->slug' class='sp-dsgvo-script-container'-->$jsCode<!-- end sp-dsgvo-script-container-$this->slug -->";

        if ($integrationAllowed) {
            echo wp_kses($result, $this->getAllowedHtmlForScriptsForKses());
        }
        return;
    }

    public function processBodyEndAction()
    {
        if ($this->insertLocation != 'body') return;

        $settings = $this->getSettings();

        if ($settings['isEnabled'] == '0') return;
        $propertyId = $settings['propertyId'];

        $integrationAllowed = $this->checkIfIntegrationIsAllowedByCookie($settings);
        $jsCode = $this->getJsCode($settings);

        $result = "";

        $result = "<div class='sp-dsgvo-script-container sp-dsgvo-script-container-$this->slug'>
                $jsCode<!-- hook body-->
             </div>";

        if ($integrationAllowed) {
	        echo wp_kses($result, $this->getAllowedHtmlForScriptsForKses());
        }
        return;
    }

    public function processBodyStartAction()
    {
        if ($this->insertLocation != 'body') return;

        $settings = $this->getSettings();

        if ($settings['isEnabled'] == '0') return;
        $propertyId = $settings['propertyId'];

        $integrationAllowed = $this->checkIfIntegrationIsAllowedByCookie($settings);
        $jsCode = $this->getJsCode($settings);

        $result = "";

        $result = "<div class='sp-dsgvo-script-container sp-dsgvo-script-container-$this->slug'>
                $jsCode<!-- hook body-->
             </div>";

        if ($integrationAllowed) {
	        echo wp_kses($result, $this->getAllowedHtmlForScriptsForKses());
        }
        return;
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
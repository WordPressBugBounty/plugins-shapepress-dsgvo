<?php

class SPDSGVOOpenstreetmapApi extends SPDSGVOEmbeddingApiBase
{
    protected function __construct()
    {
        $this->name = "OpenStreetMap";
        $this->company = "OpenStreetMap Foundation CLG";
        $this->country = "UK";
        $this->slug = 'osm';
        $this->storageId = 'osm';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS;
        $this->cookieNames = '';
        $this->hosts = 'openstreetmap.org';

        parent::__construct();
    }

    public function processContent($content)
    {
        // if its allowed by cookie nothing is to do here. otherwise replace iframes, show image, add optin handler
        if ($this->checkIfIntegrationIsAllowed($this->slug) == true) return;

        $replacedContent = $this->getOptInContentReplacementHtml($content);

        return $replacedContent;
    }

    public function getIsEnabled()
    {
        $settings = $this->getSettings();

        $legacySettings = SPDSGVOSettings::get('page_basics_embeddings');
        if ($settings['isEnabled'] == '0' && empty($legacySettings) == false &&  in_array('open-street-map', $legacySettings))
        {
            $settings['isEnabled'] = '1';
        }

        return $settings['isEnabled'] == '1';
    }

    public function getSettings()
    {
        $settings = parent::getSettings();

        $legacySettings = SPDSGVOSettings::get('page_basics_embeddings');
        if ($settings['isEnabled'] == '0' && empty($legacySettings) == false && in_array('open-street-map', $legacySettings))
        {
            $settings['isEnabled'] = '1';
        }

        return $settings;
    }
}

SPDSGVOOpenstreetmapApi::getInstance()->register();
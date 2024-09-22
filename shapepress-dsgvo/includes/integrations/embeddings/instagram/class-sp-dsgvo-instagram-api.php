<?php

class SPDSGVOInstagramApi extends SPDSGVOEmbeddingApiBase
{
    protected function __construct()
    {
        $this->name = "Instagram";
        $this->company = "Meta Platforms Ireland Ltd.";
        $this->country = "Ireland, USA";
        $this->slug = 'insta';
        $this->storageId = 'insta';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS;
        $this->cookieNames = '';
        $this->hosts = 'instagram.com';

        parent::__construct();
    }

    public function processContent($content)
    {
        // if its allowed by cookie nothing is to do here. otherwise replace iframes, show image, add optin handler
        if ($this->checkIfIntegrationIsAllowed($this->slug) == true) return;

        $replacedContent = $this->getOptInContentReplacementHtml($content);

        return $replacedContent;
    }
}

SPDSGVOInstagramApi::getInstance()->register();
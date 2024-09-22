<?php

class SPDSGVOTwitterApi extends SPDSGVOEmbeddingApiBase
{
    protected function __construct()
    {
        $this->name = "Twitter";
        $this->company = "Twitter";
        $this->country = "San Francisco";
        $this->slug = 'twitter';
        $this->storageId = 'twitter';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS;
        $this->cookieNames = '';
        $this->hosts = 'twitter.com;t.co';

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

SPDSGVOTwitterApi::getInstance()->register();
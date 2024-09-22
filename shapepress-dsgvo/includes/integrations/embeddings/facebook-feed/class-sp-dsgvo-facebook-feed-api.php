<?php

class SPDSGVOFacebookFeedApi extends SPDSGVOEmbeddingApiBase
{
    protected function __construct()
    {
        $this->name = "Facebook";
        $this->company = "Meta Platforms Ireland Ltd.";
        $this->country = "Ireland, USA";
        $this->slug = 'facebook-feed';
        $this->storageId = 'fbfeed';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS;
        $this->cookieNames = '';
        $this->hosts = 'www.facebook.com';

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

SPDSGVOFacebookFeedApi::getInstance()->register();
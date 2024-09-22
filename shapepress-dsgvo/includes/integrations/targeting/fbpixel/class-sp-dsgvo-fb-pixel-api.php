<?php

class SPDSGVOFbPixelApi extends SPDSGVOIntegrationApiBase
{


    protected function __construct()
    {
        $this->name = "Facebook Pixel";
        $this->company = "Meta Platforms Ireland Ltd.";
        $this->country = "Ireland, USA";
        $this->slug = 'facebook-pixel';
        $this->storageId = 'fbpixel';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_TARGETING;
        $this->cookieNames = 'fbp;act;c_user;datr;fr;m_pixel_ration;pl;presence;sb;spin;wd;xs';
        $this->isPremium = true;
        $this->isTagManagerCompatible = true;
        $this->supportedTagManager[] = SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug();
        $this->supportedTagManager[] = SPDSGVOMatomoTagmanagerApi::getInstance()->getSlug();
    }

    public static function getDefaultJsCode($propertyId)
    {
        return "<!-- Facebook Pixel Code -->
        <script>
                  !function(f,b,e,v,n,t,s)
                  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                  n.queue=[];t=b.createElement(e);t.async=!0;
                  t.src=v;s=b.getElementsByTagName(e)[0];
                  s.parentNode.insertBefore(t,s)}(window, document,'script',
                  'https://connect.facebook.net/en_US/fbevents.js');
                  fbq('init', '$propertyId');
                  fbq('track', 'PageView');
                </script>
          <noscript>
        	<img height='1' width='1' style='display: none'
        		src='https://www.facebook.com/tr?id=$propertyId&ev=PageView&noscript=1' />
        </noscript>
        <!-- End Facebook Pixel Code -->";

    }


}

SPDSGVOFbPixelApi::getInstance()->register();

//add_filter('sp_dsgvo_integrations_head', [SPDSGVOFbPixelApi::getInstance(),'processHeadAction']);
add_filter('sp_dsgvo_integrations_body_end', [SPDSGVOFbPixelApi::getInstance(), 'processBodyEndAction']);
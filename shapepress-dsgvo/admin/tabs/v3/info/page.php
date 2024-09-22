<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

?>

<div class="card col-12">
    <div class="card-header"><?php _e('IMPORTANT, OTHERWISE YOUR WEBSITE WILL NOT CONFORM TO PRIVACY','shapepress-dsgvo')?></div>
    <div class="card-body">
        <h6 class="card-subtitle"> <?php _e('You need to take 10 minutes to read this text and to reconfigure WP DSGVO Tools (GDPR).','shapepress-dsgvo')?></h6>

    </div>
</div>
<div class="card-columns">
    <div class="card">
        <div class="card-header"><?php _e('1. GDPR GUIDANCE','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('WP DSGVO Tools helps you to design your website correctly. Nevertheless, WP DSGVO does not replace any individual legal advice and no control over whether all aspects of your website have been taken into account.','shapepress-dsgvo'); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><?php _e('2. NEW LEGAL POSITION','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('New judgments of the European Court of Justice and requirements of data protection authorities have a massive impact on websites and web marketing.<br />WP DSGVO V3 has implemented these requirements to get the consent of the web user to various services. WP DSGVO was fundamentally changed. with the support of data protection lawyer Peter Harlander of (§) MARKETINGRECHT.EU. WP DSGVO was fundamentally changed.<br /><strong> You must go through WP DSGVO point by point and make sure everything is set correctly. </strong> <br />If you are interested, you can read additional details on the legal requirements in the PDF from (§) MARKETINGRECHT.EU or directly from the data protection authorities:<br /><a href="https://www.marketingrecht.eu/downloads/legalweb-mr.pdf" target="_blank"> • https://www.marketingrecht.eu/downloads/legalweb-mr.pdf</a><br /><a href="https://www.baden-wuerttemberg.datenschutz.de/zum-einsatz-von-cookies-und-cookie-bannern-was-gilt-es-bei-einwilligungen-zu-tun-eugh-urteil-planet49/" target="_blank">• https://www.baden-wuerttemberg.datenschutz.de/zum-einsatz-von-cookies-und-cookie-bannern-was-gilt-es-bei-einwilligungen-zu-tun-eugh-urteil-planet49/</a><br />','shapepress-dsgvo'); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><?php _e('3. NEW OPTIONS','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('Other providers sometimes offer options such as "resume consent", "pre-selected services" or "no disapprove button". These options are meanwhile illegal. The offerers who offer such options, want to meet the website operators who, contrary to the opinion of the courts and data protection authorities still want to have it.<br /><br />We have only included options that are currently considered to be privacy-compliant (according to most lawyers) because we believe that very few WP DSGVO Tools (GDPR) users will hire a privacy expert to design their website.<br /><br />WP DSGVO Tools (GDPR) does not replace individual legal advice, but we want to get you in the right direction as much as possible. This is only possible if we do not even offer unnecessary risk factors. Also you can find out more details in the PDF of (§) MARKETINGRECHT.EU.','shapepress-dsgvo'); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><?php _e('4. ALL IN ONE','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('<strong>You need to configure WP DSGVO correctly.</strong> WP DSGVO will then create a legally compliant cookie popup and the corresponding privacy policy.<br /><br />The Free version primary contains all the services that private websites need. The Premium version includes services primarily used by professional marketing companies and agencies. It is important that you choose the version that contains as many services as possible of your website.<br /><br />For not included services you have to make your own. Our plugin is designed for standard configured services. Special settings may require special configurations.<br /><strong>Other services are ongoing</strong>.<br /><br />Requests for additional (frequently used) services for the Premium version can be made at <a href="https://legalweb.freshdesk.com" target="_blank">https://legalweb.freshdesk.com/</a>.','shapepress-dsgvo'); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><?php _e('5. BUT NO COOKIE POPUP?','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('Many Web site operators were irritated because WP DSGVO Tools (GDPR) V3 does not produce a cookie popup (correct) in some configurations.<br /><br /><strong>In addition the short legal explanation:</strong> the Cookie Popup serves "only" to obtain the consent of the website users to the processing of their personal data. This consent is not necessary if the tool for operating the website is necessarily technically necessary. <br /><br />According to data protection authorities, an analysis tool is basically technically necessary. However, it is not necessary for the provider of the analysis tool to process the data for his own purposes. <br /><br />Therefore, a local Matomo or WP Statistics (the data remains with the website operator) do not need consent and thus no popup. <br /><br />A Google Analytics, however, according to the data protection authorities, a consent and thus the popup, because Google further processed the analysis data. (<a href="https://datenschutz-hamburg.de/pressemitteilungen/2019/11/2019-11-14-google-analytics" target="_blank">https://datenschutz-hamburg.de/pressemitteilungen/2019/11/2019-11-14-google-analytics</a>) <br /><br />If Matomo or WP Statistics are the only services, it will not pop up. If you really want to have it different (because he represents a different view of the law), there is now an option to include technically necessary services like Matomo or WP Statistics in the popup.','shapepress-dsgvo'); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><?php _e('6. FACEBOOK PIXEL','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('The update brings a little re-sharpening. Facebook Pixel is no longer included in the Free Version. Facebook Pixel is primarily a marketing tool for optimizing paid Facebook advertising. Therefore, it has migrated to the premium version, which is aimed at companies and agencies. <br /><br />In return, the Free Version receives two new additional features: <br />• Access to multilingual legal texts created by lawyers and accurately translated by sworn and court-certified interpreters. <br /><br />• Access to privacy tools for embeddings such as Youtube, Google Maps, Open Street Map, Facebook, Instagram, etc. soon. <br /><br />The paid Blogger version still has access to Facebook Pixel and of course gets the same new features as the free version.','shapepress-dsgvo'); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><?php _e('7. LICENSE MODEL','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('We simplified the license model. There are only Free and Premium (1, 25, 100). The Blogger version is no longer available. If you already have these, you can of course reuse them and even get new functions with the update.','shapepress-dsgvo'); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><?php _e('8. SUPPORT','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('The conversion was really profound. With more than 40,000 installations, one or two websites may experience problems. We\'ll be happy to help if you report the problem at <a href="https://wordpress.org/support/plugin/shapepress-dsgvo/" target="_blank">https://wordpress.org/support/plugin/shapepress-dsgvo/</a> (for Free versions) or <a href="https://legalweb.freshdesk.com/" target="_blank">https://legalweb.freshdesk.com/</a> (for Blog and Premium versions).','shapepress-dsgvo'); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><?php _e('9. RATING','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('Unfortunately, there were some users who did not ask a support question, but have immediately "avenged" conversion issues with a 1-star rating. As a result, we have fallen from 4.5 stars to 3.5 stars. Please do not do that and use the support, we really like to help!<br /> <br />1-star ratings for small bugs, which the support immediately does, are a real problem - for us and for all users of WP DSGVO. Because the long term can only handle the effort if at least some of the massive development costs come in again due to good valuations of premium versions. <br /> <br />Stuck in WP DSGVO<br />• Over 2,500 internal hours worked by developers and lawyers<br /> • External costs for developers for special requirements<br /> • High external costs for sworn and court-certified interpreters for 100 percent correct translation of legal texts<br /> <br />If this is worth more than 1 star, we would really appreciate it: <br /> <a href="https://wordpress.org/support/plugin/shapepress-dsgvo/reviews/#new-post" target="_blank">https://wordpress.org/support/plugin/shapepress-dsgvo/reviews/#new-post</a>','shapepress-dsgvo'); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><?php _e('10. COMMUNITY','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('We are happy to be able to give the Wordpress Community WP DSGVO a small thank you for Wordpress and thousands of great plugins.<br /> <br />We will always provide the Wordpress community with a free version for private blogs and websites. <br /> <br />This is currently used by about 40,000 website operators.','shapepress-dsgvo'); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><?php _e('11. SHAPEPRESS + MARKETINGRECHT.EU = LEGALWEB','shapepress-dsgvo')?></div>
        <div class="card-body">
            <?php _e('No, we were not bought. On the contrary. We met with (§) MARKETINGRECHT.EU brought a data protection lawyer on board. This ensures that WP DSGVO is always up-to-date.','shapepress-dsgvo'); ?>
        </div>
    </div>

</div>



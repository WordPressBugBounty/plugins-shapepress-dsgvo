<div class="wrap"></div>

<div class="legalweb-bs" style="padding-right: 15px">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-2 text-white">
        <a class="navbar-brand" href="#">
            <img src="<?php echo esc_attr(SPDSGVO::pluginURI('public/images/legalwebio-logo-icon-white.svg')); ?>" width="30" height="30" class="d-inline-block align-top" alt="">
            <a class="navbar-brand"><?php _e('WP DSGVO Tools (GDPR) by legalweb.io', 'shapepress-dsgvo'); ?></a>
        </a>
    </nav>

    <!--
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">Hello, world!</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>
        </div>
    </div>
    -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><?php _e('WP DSGVO Tools (GDPR)', 'shapepress-dsgvo'); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php isset($tab) &&isset($tabs[$tab]) ? esc_html_e($tabs[$tab]->getTabTitle(),'shapepress-dsgvo') : '';?></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-9 container-fluid sp-dsgvo-content-container">
            <?php

            if (isset($tabs[$tab])) {
                $tabs[$tab]->page();
                ?>
                <script>
                    var spDsgvoActiveAdminSubmenu = '<?php echo esc_attr($tabs[$tab]->slug); ?>';

                </script>
                <?php
            } else {
                $tabs['common-settings']->page();
            }

            ?>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-3 sp-dsgvo-side-container">


            <div class="card border-info bg-light" style="">
                <div class="card-header">
                    <h5 class="text-info font-weight-bold text-uppercase m-0 float-left"><?php _e("LegalWeb Cloud",'shapepress-dsgvo')?></h5>
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"	 viewBox="0 0 291.728 291.728" style="enable-background:new 0 0 291.728 291.728; width:25px;margin-left: 5px;" xml:space="preserve"><g>	<path style="fill:#28a745;" d="M291.728,145.86l-39.489,28.52l19.949,44.439l-48.469,4.896l-4.896,48.479l-44.439-19.959		l-28.52,39.489l-28.52-39.489l-44.439,19.959l-4.896-48.479l-48.469-4.896l19.949-44.439L0,145.86l39.489-28.511L19.53,72.909		l48.479-4.896l4.905-48.479l44.43,19.959l28.52-39.489l28.52,39.489l44.439-19.959l4.887,48.479l48.479,4.896l-19.949,44.43		C252.24,117.34,291.728,145.86,291.728,145.86z"/>	<path style="fill:#FFFFFF;" d="M108.035,127.615c-2.836,0-4.942,1.76-4.942,4.914v23.834h-0.137L82.05,129.694		c-0.857-1.14-2.899-2.088-4.158-2.088c-2.836,0-4.942,1.76-4.942,4.914v35.823c0,3.155,2.106,4.914,4.942,4.914		c2.845,0,4.951-1.76,4.951-4.914v-23.514h0.137l20.907,26.35c0.921,1.14,2.89,2.088,4.149,2.088c2.845,0,4.951-1.76,4.951-4.914		V132.53C112.986,129.384,110.88,127.615,108.035,127.615z M147.241,164.186h-12.209v-9.583h10.823c3.173,0,4.814-2.206,4.814-4.349		c0-2.216-1.586-4.358-4.814-4.358h-10.823v-9.209h11.607c3.1,0,4.686-2.206,4.686-4.349c0-2.206-1.514-4.367-4.686-4.367h-16.357		c-3.492,0-5.133,2.334-5.133,5.498v34.684c0,2.836,2.17,4.723,5.079,4.723h17.014c3.1,0,4.677-2.197,4.677-4.349		C151.918,166.329,150.405,164.186,147.241,164.186z M214,127.615c-3.164,0-4.686,1.76-5.27,4.541l-5.607,26.797h-0.137		l-8.571-27.617c-0.72-2.27-2.699-3.72-5.133-3.72s-4.422,1.45-5.142,3.72l-8.571,27.617h-0.128l-5.607-26.797		c-0.593-2.781-2.106-4.541-5.279-4.541c-2.89,0-4.677,2.143-4.677,4.167l0.255,2.134l8.379,34.428		c0.656,2.644,2.836,4.914,6.528,4.914c3.228,0,5.735-2.024,6.528-4.604l7.65-24.335h0.137l7.65,24.335		c0.793,2.58,3.301,4.604,6.528,4.604c3.693,0,5.881-2.27,6.537-4.914l8.37-34.428l0.264-2.134		C218.678,129.758,216.9,127.615,214,127.615z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                </div>
                <div class="card-body">
                    <p class="card-text"><?php _e('The comprehensive GDPR and legal solution. Cookie popup, imprint, privacy policy, tracker management, legal terms generation and much more is possbible with LegalWeb cloud. Just visit <a href="https://legalweb.io" target="_blank" >this link</a> to see a lot of more details.','shapepress-dsgvo'); ?> </p>
                    <ul style="list-style: disc; padding-left: 20px;">
                        <li><?php _e('Generation of cookie pop-up & cookie notice, consent & revocation management', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Control of services & embeddings (statistics & analysis, marketing & profiling, live chats)', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Custom services', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Generation of the individual data protection declaration', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Languages of the legal texts: AT, DE, EN, ES, IT, FR, HU', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Certified by a lawyer, translations for legal texts by sworn & certified court interpreters', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Barrier-free according to WCAG 2.1 AA, operated via keyboard', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Different designs: As a popup, as a sidebar, as a bar at the bottom of the page, ...', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Color-adjustable via customizer or user-defined CSS', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('JavaScript client side API', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Time of display can be selected: immediately, after x seconds, when scrolling for the first time, by event, manually', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Plugins for Wordpress and many other CMS systems. Can also be used for individual developments via REST API.', 'shapepress-dsgvo'); ?></li>
                        <li><?php _e('Always up to date according to legal requirements.', 'shapepress-dsgvo'); ?></li>
                    </ul>
                </div>
            </div>

            <div class="card border-info bg-light" style="">
                <div class="card-header"><h5 class="text-info font-weight-bold text-uppercase m-0"><?php _e("Need help?",'shapepress-dsgvo')?></h5></div>
                <div class="card-body">
                    <p class="card-text"><?php _e('Do you have problems our questions how to configure this plugin correctly? Just visit <a href="https://legalweb.freshdesk.com/support/solutions" target="_blank" >this link</a> to see a quick start tutorial and access our FAQa.','shapepress-dsgvo'); ?> </p>
                </div>
            </div>

            <div class="card border-info bg-light" style="">
                <div class="card-header"><h5 class="text-info font-weight-bold text-uppercase m-0"><?php _e("Free Webinars",'shapepress-dsgvo')?></h5></div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-1"><?php _e("Next dates",'shapepress-dsgvo')?></h6>

                    <?php


                    //delete_transient('mr-webinare');
                    // get them from cache
                    if ( false === ($products = get_transient( 'mr-webinare' ) ) ) {
                        // this code runs when there is no valid transient set
                        // they are not in cache, so refetch them
                        $response = wp_remote_get( add_query_arg( array(
                            'category' => 'webinare'
                        ), 'https://legalweb.io/wp-json/legalweb/v1/webAndSeminar?category=webinare&status=publish' ) );

                        $products = null;
                        if ( is_wp_error($response) == false ) {
                            $products = json_decode(json_decode(wp_remote_retrieve_body( $response )), true);
                            set_transient( 'mr-webinare', $products, 60*60*24 );
                        }

                    }


                    if (($products = get_transient( 'mr-webinare' ) ) && isset($products)) {
                        $count = 0;
                        $maxCount = 3;
                        $result = '';
                        $result .= '<div class="list-group list-group-flush col-12">';
                        foreach ($products as $product) {
                            if ($count == $maxCount) break;
                            $webinar = $product['post']['data'];
                            $meta = $product['meta'];

                            $result .= '<div class="list-group-item font-weight-bold py-1 px-1 bg-light">';
                            $result .= '<a href="' . esc_url($webinar['link']) . '" class="clear" target="_blank">';
                            $result .= '<span class="seminare-date">' . esc_html(date_format(date_create_from_format("Y-m-d H:i", $meta['event_beginn'][0]), "d.m.")) . ' </span>';
                            $result .= '<span class="seminare-text">';
                            $result .= esc_html($webinar['title']['rendered']) . ' <br />';
                            $result .= '</span>';
                            $result .= '</a>';
                            $result .= '</div>';

                            $count++;
                        }
                        $result .= '</div>';
                    }

                    if (isset($result) && isset($products) && count($products) > 0) {
                        echo wp_kses_post($result);
                    } else
                    {
                        _e('Currently no dates planed. You can watch the videos of past webinars on our  <a href="https://www.youtube.com/channel/UCxPJiWLFirO_KJpm-TeyQhg" target="_blank">YouTube channel</a>','shapepress-dsgvo');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

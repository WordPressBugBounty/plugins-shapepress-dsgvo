<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

?>

<div class="card col-12">
    <div class="row no-gutters">
        <div class="col-md-3">
            <img src="<?php echo esc_attr(SPDSGVO::pluginURI('admin\images\DSGVO-Seminar.jpg')); ?>" style="width: 250px" class="rounded float-left m-2" alt="Mag. Peter Harlander">
        </div>
        <div class="col-md-9">
            <div class="card-body pl-5">
                <h5 class="card-title font-weight-bold"><?php _e('Free webinars on websites, web shops &amp; law','shapepress-dsgvo')?></h5>
                <p class="card-text"><?php _e('We have a new, free support option for free, premium and cloud users!<br />Attorney Peter Harlander will explain regularly what is legally important for websites and web shops (the webinar will be held in German).','shapepress-dsgvo')?></p>
                <p class="card-text"><?php _e('Free registration at: <a href="https://legalweb.io/" title="Webinare zu Webistes, Webshops &amp; Recht" target="_blank">legalweb.io</a>','shapepress-dsgvo')?></p>
                <p class="card-text"><?php _e('You can watch the videos of past webinars on our  <a href="https://www.youtube.com/channel/UCxPJiWLFirO_KJpm-TeyQhg/" target="_blank">YouTube channel</a>','shapepress-dsgvo')?></p>
            </div>
        </div>
    </div>
</div>

<div class="card-columns">
    <div class="card">
        <div class="card-header"><?php _e('Free Webinars','shapepress-dsgvo')?></div>
        <div class="card-body">
            <p><?php _e('Peter Harlander is an Attorney-at-law for IT, internet and marketing law, managing director at <a href="https://www.marketingrecht.eu/" title="Rechtsanwalt Datenschutzrecht" target="_blank">MARKETINGRECHT.EU</a> and co-founder of <a href="https://www.legalweb.io/" title="Recht für Websites und Webshops" target="_blank">legalweb.io</a>.','shapepress-dsgvo')?></p>
            <p><?php _e('Regularly Peter Harlander and his team explain how website and web shop operators have to implement legal regulations such as data protection law, e-commerce law, e-marketing law, copyright law, trademark law and competition law.','shapepress-dsgvo')?></p>
            <p><?php _e('In the webinar you can expect examples from practice and understandable instructions for implementation.','shapepress-dsgvo')?></p>
            <p><?php _e('Motto: One step closer to the legally perfect website every week!','shapepress-dsgvo')?></p>
        </div>
    </div>

    <!--
    <div class="card">
        <div class="card-header"><?php _e('Content','shapepress-dsgvo')?></div>
        <div class="card-body">
            <h6 class="font-weight-bold"><?php _e('Processing operations','shapepress-dsgvo')?></h6>
            <ul style="list-style: disc; padding-inline-start: 40px;">
                <li><?php _e('Affiliates','shapepress-dsgvo')?></li>
                <li><?php _e('Completion of purchase','shapepress-dsgvo')?></li>
                <li><?php _e('Payment services','shapepress-dsgvo')?></li>
                <li><?php _e('Shipping services','shapepress-dsgvo')?></li>
                <li><?php _e('Warehouse services','shapepress-dsgvo')?></li>
                <li><?php _e('Customer data','shapepress-dsgvo')?></li>
                <li><?php _e('Accounting','shapepress-dsgvo')?></li>
                <li><?php _e('Tax advice','shapepress-dsgvo')?></li>
                <li><?php _e('Debt collection','shapepress-dsgvo')?></li>
                <li><?php _e('Warranty / product liability / compensation','shapepress-dsgvo')?></li>
            </ul>
            <h6 class="font-weight-bold"><?php _e('Consent & information','shapepress-dsgvo')?></h6>
            <ul style="list-style: disc; padding-inline-start: 40px;">
                <li><?php _e('Checkout','shapepress-dsgvo')?></li>
                <li><?php _e('Data protection','shapepress-dsgvo')?></li>
                <li><?php _e('Deletion','shapepress-dsgvo')?></li>
            </ul>

        </div>
    </div>
    -->
    <div class="card">
        <div class="card-header"><?php _e('Dates','shapepress-dsgvo')?></div>
        <div class="card-body row no-gutters">
            <?php

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
                $result = '';
                $result .= '<div class="list-group list-group-flush col-12">';
                foreach ($products as $product) {
                    $webinar = $product['post']['data'];
                    $meta = $product['meta'];

                    $result .= '<div class="list-group-item font-weight-bold py-1 px-1">';
                    $result .= '<a href="' . esc_url($webinar['link']) . '" class="clear" target="_blank">';
                    $result .= '<span class="seminare-date">' . esc_html(date_format(date_create_from_format("Y-m-d H:i", $meta['event_beginn'][0]), "d.m.")) . ' </span>';
                    $result .= '<span class="seminare-text">';
                    $result .= esc_html($webinar['title']['rendered']) . ' <br />';
                    $result .= '</span>';
                    $result .= '</a>';
                    $result .= '</div>';
                }
                $result .= '</div>';
            }

            if (isset($result) && isset($products) && count($products) > 0) {
                echo wp_kses_post($result);
            }else
            {
                _e('Currently no dates planed. You can watch the videos of past webinars on our  <a href="https://www.youtube.com/channel/UCxPJiWLFirO_KJpm-TeyQhg" target="_blank">YouTube channel</a>','shapepress-dsgvo');
            }
            ?>
        </div>
    </div>

</div>



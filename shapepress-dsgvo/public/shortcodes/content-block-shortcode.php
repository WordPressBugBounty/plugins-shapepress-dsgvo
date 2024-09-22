<?php

function SPDSGVOContentBlockShortcode($atts, $content){

    $params = shortcode_atts( array (
        'type' => '',
        'shortcode' => ''
    ), $atts );

    if (empty($params['type'])) return $content;
    $slug = $params['type'];

	global $OL3_LIBS_LOADED;
	//$OL3_LIBS_LOADED = 0;

    $shortcode = $params['shortcode'];
    if (empty($shortcode) == false) $content = do_shortcode("[" . $shortcode ."]");

    $embeddingApi = SPDSGVOEmbeddingsManager::getInstance()->getEmbeddingApiBySlug($slug);
    if ($embeddingApi == null) return $content;
    // if its allowed by cookie nothing is to do here. otherwise replace iframes, show image, add optin handler
    if ($embeddingApi->checkIfIntegrationIsAllowed($embeddingApi->slug) == true) return $content;

    $originalContentBase64Encoded = base64_encode(htmlentities($content));
    $processedContent =  $embeddingApi->processContent($content);

    $customCssClasses = SPDSGVOSettings::get('embed_placeholder_custom_css_classes');

	$processedContent = wp_kses($processedContent, array_merge(
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
	));

    $content = '<div class="sp-dsgvo sp-dsgvo-embedding-container sp-dsgvo-embedding-' . esc_attr($embeddingApi->slug) . ' '. esc_attr($customCssClasses) .'">' . $processedContent . '<div class="sp-dsgvo-hidden-embedding-content sp-dsgvo-hidden-embedding-content-' . esc_attr($embeddingApi->slug) . '" data-sp-dsgvo-embedding-slug="' . esc_attr($embeddingApi->slug) . '">' . ($originalContentBase64Encoded) . '</div></div>';


    return $content;
}

add_shortcode('lw_content_block', 'SPDSGVOContentBlockShortcode');

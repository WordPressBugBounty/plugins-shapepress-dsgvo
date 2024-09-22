<style>
    .sp-dsgvo-blocked-embedding-placeholder
    {
        color: <?php echo esc_html(SPDSGVOSettings::get('embed_placeholder_text_color')) ?>;
        <?php if(empty(SPDSGVOSettings::get('embed_placeholder_custom_style'))==false):?>
            <?php echo esc_html(SPDSGVOSettings::get('embed_placeholder_custom_style'));?>
        <?php endif; ?>
    }

    a.sp-dsgvo-blocked-embedding-button-enable,
    a.sp-dsgvo-blocked-embedding-button-enable:hover,
    a.sp-dsgvo-blocked-embedding-button-enable:active {
        color: <?php echo esc_html(SPDSGVOSettings::get('embed_placeholder_text_color')) ?>;
        border-color: <?php echo esc_html(SPDSGVOSettings::get('embed_placeholder_border_color_button')) ?>;
        border-width: <?php echo esc_html(SPDSGVOSettings::get('embed_placeholder_border_size_button')) ?>;
    }

    <?php if (SPDSGVOSettings::get('embed_disable_negative_margin') == '1') : ?>
        .wp-embed-aspect-16-9 .sp-dsgvo-blocked-embedding-placeholder,
        .vc_video-aspect-ratio-169 .sp-dsgvo-blocked-embedding-placeholder,
        .elementor-aspect-ratio-169 .sp-dsgvo-blocked-embedding-placeholder{
            margin-top: 0; /*16:9*/
        }

        .wp-embed-aspect-4-3 .sp-dsgvo-blocked-embedding-placeholder,
        .vc_video-aspect-ratio-43 .sp-dsgvo-blocked-embedding-placeholder,
        .elementor-aspect-ratio-43 .sp-dsgvo-blocked-embedding-placeholder{
            margin-top: 0;
        }

        .wp-embed-aspect-3-2 .sp-dsgvo-blocked-embedding-placeholder,
        .vc_video-aspect-ratio-32 .sp-dsgvo-blocked-embedding-placeholder,
        .elementor-aspect-ratio-32 .sp-dsgvo-blocked-embedding-placeholder{
            margin-top: 0;
        }
    <?php else : ?>
        .wp-embed-aspect-16-9 .sp-dsgvo-blocked-embedding-placeholder,
        .vc_video-aspect-ratio-169 .sp-dsgvo-blocked-embedding-placeholder,
        .elementor-aspect-ratio-169 .sp-dsgvo-blocked-embedding-placeholder{
            margin-top: -56.25%; /*16:9*/
        }

        .wp-embed-aspect-4-3 .sp-dsgvo-blocked-embedding-placeholder,
        .vc_video-aspect-ratio-43 .sp-dsgvo-blocked-embedding-placeholder,
        .elementor-aspect-ratio-43 .sp-dsgvo-blocked-embedding-placeholder{
            margin-top: -75%;
        }

        .wp-embed-aspect-3-2 .sp-dsgvo-blocked-embedding-placeholder,
        .vc_video-aspect-ratio-32 .sp-dsgvo-blocked-embedding-placeholder,
        .elementor-aspect-ratio-32 .sp-dsgvo-blocked-embedding-placeholder{
            margin-top: -66.66%;
        }
    <?php endif; ?>
</style>
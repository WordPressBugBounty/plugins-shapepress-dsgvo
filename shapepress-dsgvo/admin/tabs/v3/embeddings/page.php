<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition();

require_once(SPDSGVO::pluginDir('public/inc/embedding-placeholder-styles.php'));

?>

<div class="col-12 card">
    <h4 class="card-header"><?php _e('Style settings','shapepress-dsgvo')?></h4>
    <div class="card-body">
        <div class="position-relative">
             <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>
            <small class="form-text text-muted mt-0 mb-2"><?php _e('The following settings define the appearance of the content placeholder. These settings get applied to the placeholder of all enabled embeddings.','shapepress-dsgvo')?></small>
            <div class="row">
                <div class="col">

                    <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                        <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOEmbeddingsIntegrationAction::getActionName()); ?>">
                        <input type="hidden" name="saveAction" value="save">
                        <?php wp_nonce_field(esc_attr(SPDSGVOEmbeddingsIntegrationAction::getActionName()) . '-nonce'); ?>

                        <?php
                        spDsgvoWriteInput('color', '', 'embed_placeholder_text_color', SPDSGVOSettings::get('embed_placeholder_text_color'),
                            __('Text/Font color', 'shapepress-dsgvo'),
                            '',
                            __('Specifies the text/font color of the text within the placeholder.', 'shapepress-dsgvo'));
                        ?>

                        <?php
                        spDsgvoWriteInput('color', '', 'embed_placeholder_border_color_button', SPDSGVOSettings::get('embed_placeholder_border_color_button'),
                            __('Button border color', 'shapepress-dsgvo'),
                            '',
                            __('Specifies the border color of the placeholder opt-in button.', 'shapepress-dsgvo'));
                        ?>

                        <div class="form-group">
                            <label for="cn_height_container"><?php _e('Size of the button border', 'shapepress-dsgvo') ?></label>

                            <?php $cnButtonBorderSize = SPDSGVOSettings::get('embed_placeholder_border_size_button'); ?>
                            <select class="form-control" name="embed_placeholder_border_size_button"
                                    id="embed_placeholder_border_size_button">
                                <option value="1px" <?php echo esc_attr(selected($cnButtonBorderSize == '1px')) ?>>1px</option>
                                <option value="2px" <?php echo esc_attr(selected($cnButtonBorderSize == '2px')) ?>>2px</option>
                                <option value="3px" <?php echo esc_attr(selected($cnButtonBorderSize == '3px')) ?>>3px</option>
                                <option value="4px" <?php echo esc_attr(selected($cnButtonBorderSize == '4px')) ?>>4px</option>
                                <option value="5px" <?php echo esc_attr(selected($cnButtonBorderSize == '5px')) ?>>5px</option>
                            </select>
                        </div>

                        <?php
                        spDsgvoWriteInput('textarea', '', 'embed_placeholder_custom_style', SPDSGVOSettings::get('embed_placeholder_custom_style'),
                            __('Custom style attributes <small>(Applied after saving changes)</small>', 'shapepress-dsgvo'),
                            __('text-transform: uppercase; text-align: center;', 'shapepress-dsgvo'),
                            __('Specifies one or multiple additional style attributes for placeholder. Please specify each with ";" at the end.', 'shapepress-dsgvo'));
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'embed_placeholder_custom_css_classes', SPDSGVOSettings::get('embed_placeholder_custom_css_classes'),
                            __('Additional CSS classes <small>(Applied after saving changes)</small>\'', 'shapepress-dsgvo'),
                            __('myClass1 myClass2', 'shapepress-dsgvo'),
                            __('Specifies one or multiple additional classes for the button of cookie notice. Please specify them without leading ".".', 'shapepress-dsgvo'));
                        ?>

                        <?php
                        spDsgvoWriteInput('switch', '', 'embed_disable_negative_margin', SPDSGVOSettings::get('embed_disable_negative_margin'),
                            __('Theme compatibility: disable negative margin of ratio classes', 'shapepress-dsgvo'),
                            '',
                            __("Enabling this option removes the negative margin of the placeholder. Do this, if your placeholder overlaps with other elements like texts or images.",'shapepress-dsgvo'));
                        ?>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                        </div>
                    </form>
                </div>
                <div class="col">
                    <h5 class="font-weight-bold mb-0"><?php _e('Design preview','shapepress-dsgvo')?></h5>
                    <small class="form-text text-muted mt-0"><?php _e('The full preview is rendered after saving.','shapepress-dsgvo'); ?></small>
                    <div class="embedding-preview-container">
                        <div class="sp-dsgvo sp-dsgvo-embedding-dummy">
                            <div class="sp-dsgvo-blocked-embedding-placeholder sp-dsgvo-blocked-embedding-placeholder-dummy <?php echo esc_attr(SPDSGVOSettings::get('embed_placeholder_custom_css_classes'))?>">
                                <div class="sp-dsgvo-blocked-embedding-placeholder-header">
                                    <img class="sp-dsgvo-blocked-embedding-placeholder-header-icon" src="<?php echo esc_url(SPDSGVO::pluginURI('admin/images/legalwebio-logo-icon-black.svg')); ?>">
                                    <?php echo esc_html(sprintf(__('We need your consent to load the content of %s.','shapepress-dsgvo'), '...')); ?>
                                </div>
                                <div class="sp-dsgvo-blocked-embedding-placeholder-body">
                                    <span>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat.</span>
                                    <div class="sp-dsgvo-blocked-embedding-button-container">
                                        <a href="#" class="sp-dsgvo-show-privacy-popup sp-dsgvo-blocked-embedding-button-enable"><?php _e('Click here to enable this content.','shapepress-dsgvo')?></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" class="mt-3" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                        <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOEmbeddingsIntegrationAction::getActionName()); ?>">
                        <input type="hidden" name="saveAction" value="restore">
                        <?php wp_nonce_field(esc_attr(SPDSGVOEmbeddingsIntegrationAction::getActionName()) . '-nonce'); ?>
                        <div class="form-group">
                            <input type="submit" class="btn btn-secondary btn-block" value="<?php _e('Restore defaults', 'shapepress-dsgvo');?>">
                        </div>
                    </form>

                    <div class="embedding-help-container">
                        <small class="form-text font-weight-bold"><?php _e('Styling information for CSS customization', 'shapepress-dsgvo');?></small>
                        <small class="form-text"><?php _e('By default a linear gradient is set as <code>background: linear-gradient(90deg, #e3ffe7 0%, #d9e7ff 100%);</code>.<br />You can overwrite it by setting the style property "background" to your desired style. At <a href="https://cssgradient.io" target="_blank">https://cssgradient.io</a> you could create gradients easily.', 'shapepress-dsgvo');?></small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-columns">

    <div class="card">
        <div class="card-header"><?php _e('Common Settings','shapepress-dsgvo')?></div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOEmbeddingsIntegrationAction::getActionName()); ?>">
                <input type="hidden" name="saveAction" value="common">
                <?php wp_nonce_field(esc_attr(SPDSGVOEmbeddingsIntegrationAction::getActionName()) . '-nonce'); ?>
                <?php
                spDsgvoWriteInput('switch', '', 'embed_enable_js_blocking', SPDSGVOSettings::get('embed_enable_js_blocking'),
                    __('Enable blocking of dynamic loaded embeddings', 'shapepress-dsgvo'),
                    '',
                    __("Enabling client side blocking of dynamic loaded/generated iframes.",'shapepress-dsgvo'));
                ?>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </form>
        </div>
    </div>


    <?php
    $integrations = SPDSGVOIntegration::getAllIntegrations(SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS, FALSE);

    uasort($integrations, function($a, $b) {
        return $a->title < $b->title ? -1 : 1;
    });

    ?>
    <?php if(count($integrations) === 0): ?>

    <div class="card">
        <div class="card-header"><?php _e('Information','shapepress-dsgvo')?></div>
        <div class="card-body"><?php _e('No integrations installed','shapepress-dsgvo')?></div>
    </div>
</div>

<?php else: ?>

    <?php foreach($integrations as $key => $integration): ?>

        <?php $integration->view() ?>

    <?php endforeach; ?>
<?php endif; ?>

</div>


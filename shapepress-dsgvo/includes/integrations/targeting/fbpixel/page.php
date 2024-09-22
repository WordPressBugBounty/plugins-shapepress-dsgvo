
<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

$settings = SPDSGVOFbPixelApi::getInstance()->getSettings();
$apiInstance = SPDSGVOFbPixelApi::getInstance();
?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?php echo esc_html($apiInstance->getName()); ?></h4>
    </div>
    <div class="card-body">
        <div class="position-relative">
            <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>
        <form method="post" action="<?php echo esc_url(SPDSGVOFbPixelIntegration::formURL()) ?>">
            <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOFbPixelIntegration::action()) ?>">
            <?php wp_nonce_field(esc_attr(SPDSGVOFbPixelIntegration::action()) . '-nonce'); ?>



            <?php
            spDsgvoWriteInput('switch', '', 'fb_enable_pixel', $settings['isEnabled'],
                __('Use Facebook Pixel', 'shapepress-dsgvo'),
                '',
                __('Enabling inserts the js code of Facebook Pixel.','shapepress-dsgvo'));
            ?>

            <?php
            spDsgvoWriteInput('text', '', 'fb_pixel_number', $settings['propertyId'],
                __('Facebook Pixel Id', 'shapepress-dsgvo'),
                '123456789',
                '');
            ?>



                <?php
                if ($apiInstance->getIsTagManagerCompatible())
                {
                    spDsgvoWriteSelect($apiInstance->getCompatibleTagManager(), '', $apiInstance->getSlug() . '_usedTagmanager', $settings['usedTagmanager'],
                        sprintf(__('Use Tagmanager', 'shapepress-dsgvo'), $apiInstance->getName()),
                        __('No', 'shapepress-dsgvo'),
                        __('If enabled, enable own tracking code and insert the custom event code there. In this code you should fire a custom trigger event surrounded by script tags. The event will be fired after a vistor opts in. For more information visit the documatation of your used tag manager.', 'shapepress-dsgvo'));

                }
                ?>

                <?php
                spDsgvoWriteInput('switch', '', 'fb_own_code', $settings['useOwnCode'],
                    __('Use own tracking code', 'shapepress-dsgvo'),
                    '',
                    __('You can customize the tracking code by yourself. Wrong codes results in invalid or no functionality.','shapepress-dsgvo'), true,'own-code-toggle');
                ?>


                <?php

                $ga_code = $settings['jsCode'];
                if ($ga_code == '') {
                    $ga_code = SPDSGVOFbPixelApi::getInstance()->getDefaultJsCode($settings['propertyId']);
                }

                spDsgvoWriteInput('textarea', '', 'fbpixel_code',
                    $ga_code,
                    $apiInstance->getName() .' '.__('code', 'shapepress-dsgvo'),
                    '',
                    __('If left blank, the standard script will be used.', 'shapepress-dsgvo'), true,'own-code-text','1', $settings['useOwnCode'] == '1');
                ?>


            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
            </div>
        </form>
        </div>
    </div>
</div>

<?php
$isPremium = isValidPremiumEdition();
$hasValidLicense = $isPremium;
$apiInstance = SPDSGVOEtrackerApi::getInstance();
$settings = $apiInstance->getSettings();
?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?php echo esc_html($apiInstance->getName()); ?></h4>
    </div>
    <div class="card-body">

        <div class="position-relative">
            <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>

            <form method="post" action="<?php echo esc_url(SPDSGVOEtrackerIntegration::formURL()) ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOEtrackerIntegration::action()) ?>">
                <?php wp_nonce_field(esc_attr(SPDSGVOEtrackerIntegration::action()) . '-nonce'); ?>

                <?php
                spDsgvoWriteInput('switch', '', $apiInstance->getSlug().'_enable', $settings['isEnabled'],
                    sprintf(__('Use %s', 'shapepress-dsgvo'), $apiInstance->getName()),
                    '',
                    sprintf(__("Enabling inserts the js code of %s.",'shapepress-dsgvo'), $apiInstance->getName()));
                ?>

                <?php

                spDsgvoWriteInput('text', '',  $apiInstance->getSlug().'_property_id', $settings['propertyId'],
                    __('Secure Code', 'shapepress-dsgvo'),
                    'XXXXXX',
                    '');

                ?>


                    <?php

                    spDsgvoWriteInput('switch', '', $apiInstance->getSlug().'_own_code', $settings['useOwnCode'],
                        __('Use own tracking code', 'shapepress-dsgvo'),
                        '',
                        __('You can customize the tracking code by yourself. Wrong codes results in invalid or no functionality.','shapepress-dsgvo'), true,'own-code-toggle');

                    ?>


                    <?php

                    $jsCode = $settings['jsCode'];
                    if ($jsCode == '') {
                        $jsCode = $apiInstance->getDefaultJsCode($settings['propertyId']);
                    }

                    spDsgvoWriteInput('textarea', '', $apiInstance->getSlug().'_code',
                        $jsCode,
                        $apiInstance->getName() .' '.__('code', 'shapepress-dsgvo'),
                        '',
                        __('If left blank, the standard script will be used.', 'shapepress-dsgvo'), true, 'own-code-text', '1', $settings['useOwnCode'] == '1');
                    ?>


                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </form>
        </div>
    </div>
</div>

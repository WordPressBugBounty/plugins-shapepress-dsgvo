
<?php
$isPremium = isValidPremiumEdition();
$hasValidLicense = $isPremium;

$settings = SPDSGVOMatomoTagmanagerApi::getInstance()->getSettings();
$settings['useOwnCode'] = '1';
$apiInstance = SPDSGVOMatomoTagmanagerApi::getInstance();
?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?php echo esc_html($apiInstance->getName()); ?></h4>
    </div>
    <div class="card-body">
        <div class="position-relative">
            <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>
            <form method="post" action="<?php echo esc_url(SPDSGVOMatomoTagmanagerIntegration::formURL()) ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOMatomoTagmanagerIntegration::action()) ?>">
                <?php wp_nonce_field(esc_attr(SPDSGVOMatomoTagmanagerIntegration::action()) . '-nonce'); ?>

                <?php
                spDsgvoWriteInput('switch', '', $apiInstance->getSlug().'_enable', $settings['isEnabled'],
                    sprintf(__('Use %s', 'shapepress-dsgvo'), $apiInstance->getName()),
                    '',
                    sprintf(__("Enabling inserts the js code of %s.",'shapepress-dsgvo'), $apiInstance->getName()));
                ?>


                <div class="">

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

                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </form>
        </div>
    </div>
</div>

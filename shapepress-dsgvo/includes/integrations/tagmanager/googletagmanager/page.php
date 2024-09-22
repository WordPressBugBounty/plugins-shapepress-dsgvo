
<?php
$isPremium = isValidPremiumEdition();
$hasValidLicense = $isPremium;

$settings = SPDSGVOGoogleTagmanagerApi::getInstance()->getSettings();
$apiInstance = SPDSGVOGoogleTagmanagerApi::getInstance();
?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?php echo esc_html($apiInstance->getName()); ?></h4>
    </div>
    <div class="card-body">
        <div class="position-relative">
            <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>
            <form method="post" action="<?php echo esc_url(SPDSGVOGoogleTagmanagerIntegration::formURL()) ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOGoogleTagmanagerIntegration::action()) ?>">
	            <?php wp_nonce_field(esc_attr(SPDSGVOGoogleTagmanagerIntegration::action()) . '-nonce'); ?>

                <?php
                spDsgvoWriteInput('switch', '', 'gtag_enable', $settings['isEnabled'],
                    __('Use Google TagManager', 'shapepress-dsgvo'),
                    '',
                    __('Enabling inserts the js code of Google TagManager.','shapepress-dsgvo'));
                ?>

                <?php
                spDsgvoWriteInput('text', '', 'gtag_tag_number', $settings['propertyId'],
                    __('GTAG Id', 'shapepress-dsgvo'),
                    'XX-XXXXXX-X',
                    '');
                ?>

                <div class="form-group">
                    <label><?php _e('Google TagMananger code', 'shapepress-dsgvo') ?></label>
                </div>

                <div class="">


                    <?php
                    spDsgvoWriteInput('switch', '', 'gtag_own_code', $settings['useOwnCode'],
                        __('Use own tracking code', 'shapepress-dsgvo'),
                        '',
                        __('You can customize the tracking code by yourself. Wrong codes results in invalid or no functionality.','shapepress-dsgvo'), true,'own-code-toggle');
                    ?>


                    <?php

                    $ga_code = $settings['jsCode'];
                    if ($ga_code == '') {
                        $ga_code = SPDSGVOGoogleTagmanagerApi::getInstance()->getDefaultJsCode($settings['propertyId']);
                    }

                    spDsgvoWriteInput('textarea', '', 'gtag_code',
                        $ga_code,
                        $apiInstance->getName() .' '.__('code', 'shapepress-dsgvo'),
                        '',
                        __('If left blank, the standard script will be used.', 'shapepress-dsgvo'), true,'own-code-text', '1', $settings['useOwnCode'] == '1');
                    ?>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </form>
        </div>
    </div>
</div>

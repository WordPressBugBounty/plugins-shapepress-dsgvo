
<?php
$isPremium = isValidPremiumEdition();
$hasValidLicense = $isPremium;
$apiInstance = SPDSGVOLinkedInPixelApi::getInstance();
$settings = $apiInstance->getSettings();
$settings['useOwnCode'] = '1';

?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?php echo esc_html($apiInstance->getName()); ?></h4>
    </div>
    <div class="card-body">

        <div class="position-relative">
            <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>

            <form method="post" action="<?php echo esc_url(SPDSGVOLinkedInPixelIntegration::formURL()) ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOLinkedInPixelIntegration::action()) ?>">
                <?php wp_nonce_field(esc_attr(SPDSGVOLinkedInPixelIntegration::action()) . '-nonce'); ?>

                <?php
                spDsgvoWriteInput('switch', '', $apiInstance->getSlug().'_enable', $settings['isEnabled'],
                    sprintf(__('Use %s', 'shapepress-dsgvo'), $apiInstance->getName()),
                    '',
                    sprintf(__("Enabling inserts the js code of %s.",'shapepress-dsgvo'), $apiInstance->getName()));
                ?>

                <?php
                /*
                spDsgvoWriteInput('text', '',  $apiInstance->getSlug().'_tag_number', $settings['propertyId'],
                    __('GTAG number', 'shapepress-dsgvo'),
                    'XX-XXXXXX-X',
                    '');
                */
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
                /*
                spDsgvoWriteInput('switch', '', $apiInstance->getSlug().'_own_code', $settings['useOwnCode'],
                    __('Use own tracking code', 'shapepress-dsgvo'),
                    '',
                    __('You can customize the tracking code by yourself. Wrong codes results in invalid or no functionality.','shapepress-dsgvo'), true,'own-code-toggle');
                */
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

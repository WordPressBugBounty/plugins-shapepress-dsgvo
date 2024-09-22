
<?php
$isPremium = isValidPremiumEdition();
$hasValidLicense = $isPremium;
$settings = SPDSGVOPiwikApi::getInstance()->getSettings();
$apiInstance = SPDSGVOPiwikApi::getInstance();
?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?php echo esc_html($apiInstance->getName()); ?></h4>
    </div>
    <div class="card-body integration-container">

        <div class="position-relative">
            <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>

            <form method="post" action="<?php echo esc_url(SPDSGVOPiwikIntegration::formURL()) ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOPiwikIntegration::action()) ?>">
                <?php wp_nonce_field(esc_attr(SPDSGVOPiwikIntegration::action()) . '-nonce'); ?>

                <?php
                spDsgvoWriteInput('switch', '', $apiInstance->getSlug().'_enable', $settings['isEnabled'],
                    sprintf(__('Use %s', 'shapepress-dsgvo'), $apiInstance->getName()),
                    '',
                    sprintf(__("Enabling inserts the js code of %s.",'shapepress-dsgvo'), $apiInstance->getName()));
                ?>


                <?php

                if ($apiInstance->getSupportsMultipleImplementationModes())
                {
                    spDsgvoWriteSelect($apiInstance->getImplementationModes(), '', $apiInstance->getSlug() . '_implementationMode', $settings['implementationMode'],
                        __('Way of integration', 'shapepress-dsgvo'),
                        '',
                        sprintf(__('Defines the way how you integrate %s or rather host %s .', 'shapepress-dsgvo'), $apiInstance->getName(), $apiInstance->getName()),
                        true, 'implementation-mode');


                    spDsgvoWriteInput('text', '', $apiInstance->getSlug() .'_meta_agency', $settings['meta']['agency'],
                        __('Agency address', 'shapepress-dsgvo'),
                        __('Company, Address, Zip, Location, Country', 'shapepress-dsgvo'),
                        __('Because you set the way of integration to "agency", you need to specifiy the full address of this agency in the text field above. This information is needed in the privacy policy.','shapepress-dsgvo'),
                        true, 'meta-agency ' ,'1', true, ($settings['implementationMode'] == 'by-agency'));
                }
                ?>

                <?php

                if ($apiInstance->getIsTechMandatoryOptionEnabled())
                {
                    spDsgvoWriteInput('switch', '', $apiInstance->getSlug().'_showAsTechMandatory', $settings['showAsTechMandatory'],
                        __('Show in category "technically necessary" in popup', 'shapepress-dsgvo'),
                        '',
                        sprintf(__("Enable if you have configured %s not to collect private data (according to it's documentation). If yes you does not need an opt-in by your visitors and %s will be enabled by default.",'shapepress-dsgvo'), $apiInstance->getName(), $apiInstance->getName()));
                }

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

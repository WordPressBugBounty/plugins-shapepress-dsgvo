<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

?>

<div class="card-columns">




        <?php
        $integrations = SPDSGVOIntegration::getAllIntegrations(SPDSGVOConstants::CATEGORY_SLUG_STATISTICS, FALSE);

        $integrationsMandatory = SPDSGVOIntegration::getAllIntegrations(SPDSGVOConstants::CATEGORY_SLUG_MANDATORY, FALSE);
        foreach($integrationsMandatory as $key => $integration)
        {
            if ($integration->apiInstance->getCategory(true) == SPDSGVOConstants::CATEGORY_SLUG_STATISTICS)
            {
                $integrations[] = $integration;
            }
        }

        uasort($integrations, function($a, $b) {
            return $a->isPremium < $b->isPremium ? -1 : 1;
        });

        //sort_integrations_by_premium_and_name($integrations,array('isPremium', 'title'));
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



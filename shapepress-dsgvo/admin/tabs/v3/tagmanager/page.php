<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

?>

<div class="card-columns">




        <?php
        $integrations = SPDSGVOIntegration::getAllIntegrations(SPDSGVOConstants::CATEGORY_SLUG_TAGMANAGER, FALSE);


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



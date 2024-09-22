<?php

class SPDSGVOCookieCategoryApi
{

    public static function getAllCategoryNames()
    {
        $result[] = SPDSGVOConstants::CATEGORY_SLUG_STATISTICS;
        $result[] = SPDSGVOConstants::CATEGORY_SLUG_TARGETING;
        $result[] = SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS;
        $result[] = SPDSGVOConstants::CATEGORY_SLUG_LIVECHAT;
        $result[] = SPDSGVOConstants::CATEGORY_SLUG_CHATBOTS;
        $result[] = SPDSGVOConstants::CATEGORY_SLUG_MANDATORY;

        return $result;
    }

    public static function getCookieCategories()
    {
        $cookieCategories = array(
            SPDSGVOConstants::CATEGORY_SLUG_STATISTICS => array(
                'title' => __('Analysis / Statistics', 'shapepress-dsgvo'),
                'slug' => SPDSGVOConstants::CATEGORY_SLUG_STATISTICS,
                'description' => __('Anonymous evaluation for troubleshooting and further development', 'shapepress-dsgvo'),
                'orderId' => '10'
            ),
            SPDSGVOConstants::CATEGORY_SLUG_TARGETING => array(
                'title' => __('Targeting / Profiling / Ads', 'shapepress-dsgvo'),
                'slug' => SPDSGVOConstants::CATEGORY_SLUG_TARGETING,
                'description' => __('Target group-specific information outside our website', 'shapepress-dsgvo'),
                'orderId' => '20'
            ),
            SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS => array(
                'title' => __('Additional Content', 'shapepress-dsgvo'),
                'slug' => SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS,
                'description' => __('Integration of additional information', 'shapepress-dsgvo'),
                'orderId' => '30'
            ),
            SPDSGVOConstants::CATEGORY_SLUG_LIVECHAT => array(
                'title' => __('Live Chat', 'shapepress-dsgvo'),
                'slug' => SPDSGVOConstants::CATEGORY_SLUG_LIVECHAT,
                'description' => __('Personal support from our support team', 'shapepress-dsgvo'),
                'orderId' => '40'
            ),
            SPDSGVOConstants::CATEGORY_SLUG_CHATBOTS => array(
                'title' => __('Chat Bots', 'shapepress-dsgvo'),
                'slug' => SPDSGVOConstants::CATEGORY_SLUG_CHATBOTS,
                'description' => __('Support from our support team', 'shapepress-dsgvo'),
                'orderId' => '50'
            ),
            SPDSGVOConstants::CATEGORY_SLUG_MANDATORY => array(
                'title' => __('Necessary Services', 'shapepress-dsgvo'),
                'slug' => SPDSGVOConstants::CATEGORY_SLUG_MANDATORY,
                'description' => __('Unconditional technically necessary services. No consent needed.', 'shapepress-dsgvo'),
                'orderId' => '100'
            )
        );

        uasort($cookieCategories, function($a, $b) {
            return $a['orderId'] > $b['orderId'] ? 1 : -1;
        });

        return $cookieCategories;
    }

    public static function getCookieCategory($categorySlug)
    {
        if (array_key_exists($categorySlug, self::getCookieCategories()) == false) return null;

        return self::getCookieCategories()[$categorySlug];
    }



}
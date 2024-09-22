<?php

class SPDSGVOWoocommerceIntegration extends SPDSGVOIntegration
{

    public $slug = 'woocommerce';

    public $title = 'WooCommerce';

    public function boot()
    {
        $this->isHidden = TRUE;
        $this->integrationCategory = SPDSGVOConstants::CATEGORY_SLUG_PLUGINS;
    }

    public function view()
    {
        if (file_exists(dirname(__FILE__) .'/page.php')) {
            include dirname(__FILE__) . '/page.php';
        }
    }

    public function viewSubmit()
    {
        $this->redirectBack();
    }

    // -----------------------------------------------------
    // Actions
    // -----------------------------------------------------
    public function onSuperUnsubscribe($email, $firstName = NULL, $lastName = NULL, $user = NULL)
    {
        if (isValidPremiumEdition() == false) return;
        
        if (!class_exists( 'WooCommerce' )) return;
        
        //error_log('Woo.onSuperUnsubscribe of email: '.$email);
        // Get orders from the customer with email $email
        $query = new WC_Order_Query();
        $query->set('customer', $email);
        $customer_orders = $query->get_orders();
        
        $args = array(
            'billing_email' => $email,
        );
        $ordersByMail = wc_get_orders( $args );
        $customer_orders = array_merge($customer_orders, $ordersByMail);
        
        $wooAction = SPDSGVOSettings::get('su_woo_data_action');
        //error_log('Woo.onSuperUnsubscribe.$wooAction: '.$wooAction);
        
        if ($wooAction != 'ignore') {
            
            foreach ($customer_orders as $order) {
                
                //error_log('Woo.onSuperUnsubscribe.$order->ID'.$order->get_id() );
                
                if ($wooAction == 'pseudo') {
                    //error_log('Woo.onSuperUnsubscribe: setting values of $order->ID'.$order->get_id() );
                    
                    $order->set_billing_first_name('User');
                    $order->set_billing_last_name('Deleted');
                    $order->set_billing_address_1('Street');
                    $order->set_billing_address_2('');
                    $order->set_billing_city('City');
                    $order->set_billing_address_2('');
                    $order->set_billing_email('email@deleteduser.at');
                    
                    $order->set_customer_ip_address('');
                    $order->set_customer_user_agent('');
                    
                    if ($order->has_shipping_address()) {
                        $order->set_shipping_first_name('User');
                        $order->set_shipping_last_name('Deleted');
                        $order->set_shipping_address_1('Street');
                        $order->set_shipping_address_2('');
                        $order->set_shipping_city('City');
                        $order->set_shipping_address_2('');
                        $order->set_shipping_email('email@deleteduser.at');
                    }
                    
                    $order->save();
                    
                } else if ($wooAction == 'del') {
                    
                    $order->delete(FALSE);
                }
            }
        }
    }

    public function onSubjectAccessRequest($email, $firstName = NULL, $lastName = NULL, $user = NULL)
    {
        if (isValidPremiumEdition() == false) return;
        
        if (!class_exists( 'WooCommerce' )) return;
        
        $data = array();
        
        // $customer_orders = get_posts( array(
        // 'numberposts' => -1,
        // 'meta_key' => '_customer_user',
        // 'meta_value' => $user->ID,
        // 'post_type' => wc_get_order_types(),
        // 'post_status' => array_keys( wc_get_order_statuses() ),
        // ) );
        
        // Get orders from the customer with email $email
        $query = new WC_Order_Query();
        $query->set('customer', $email);
        $customer_orders = $query->get_orders();
        
        // Iterating through each Order
        foreach ($customer_orders as $order) {
            
            $orderData = array();
            $orderData[] = __('Order','shapepress-dsgvo') .' ' . $order->get_order_number() . ' '.__('of','shapepress-dsgvo').' ' . wc_format_datetime($order->get_date_created());
            
            // Going through each current customer order items
            foreach ($order->get_items() as $item_id => $item_values) {
                // $product_id = $item_values['product_id']; // product ID
                $productName = $item_values['name'];
                
                // Order Item meta data
                // $item_meta_data = wc_get_order_item_meta($item_id);
                
                $orderData[] = __('Product','shapepress-dsgvo') .": " . $productName;
            }
            
            $orderData[] = $order->get_formatted_billing_address();
            if ($order->has_shipping_address()) {
                $orderData[] = $order->get_formatted_shipping_address();
            }
            
            $orderData[] = ' ';
            
            $data[] = $orderData;
        }
        
        return $data;
    }
}

SPDSGVOWoocommerceIntegration::register();
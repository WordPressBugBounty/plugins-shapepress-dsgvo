<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since 1.0.0
 * @package WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author Shapepress eU
 */
class SPDSGVODataCollecter
{

    public $email;

    public $firstName;

    public $lastName;

    public $user = NULL;

    public $totalFound = 0;

    public $data = array();

    public $identifiers = array();

    public $tables = array();

    public $sensativeKeys = array(
        'company',
        'country',
        'county',
        'city',
        'state',
        'address',
        'first_name',
        'last_name',
        'zip',
        'zip_code',
        'post_code',
        'postcode',
        'email',
        'phone',
        'ip',
        'ip_address'
    );

    public function __construct($email, $firstName = '', $lastName = '')
    {
        $this->email = $email;

        if (! empty($firstName)) {
            $this->addIdentifier($firstName, __('Name','shapepress-dsgvo'));
            $this->firstName = $firstName;
        }

        if (! empty($lastName)) {
            $this->addIdentifier($lastName, __('Name','shapepress-dsgvo'));
            $this->lastName = $lastName;
        }

        $this->user = get_user_by('email', $this->email);
        if (is_a($this->user, 'WP_User')) {
            $this->addIdentifier($this->user->user_login, __('Login','shapepress-dsgvo'));
            $this->addIdentifier($this->user->user_nicename, __('Name','shapepress-dsgvo'));
            $this->addIdentifier($this->user->user_email, __('Email','shapepress-dsgvo'));
            $this->addIdentifier($this->user->user_url, __('Url','shapepress-dsgvo'));
            $this->addIdentifier($this->user->display_name, __('Display Name','shapepress-dsgvo'));
            $this->addIdentifier(str_replace('www.', '', @parse_url($this->user->user_url)['host']), __('Url','shapepress-dsgvo'));
        }
    }

    public function sar()
    {
        if (is_a($this->user, 'WP_User')) {
            $this->crawlLocal();
        }else
        {
            $this->crawlLocal(); // both for now because it only crawls comments
        }

        $this->integrationsSAR();

        if (isValidPremiumEdition()) 
        {
            try {
                $customData = apply_filters('spdsgvo_custom_sar', $this->email);
    
                //error_log('custom filter result. '.$customData);
                if ($customData === $this->email) $customData = NULL;
                if ($customData)
                {
                    foreach ($customData as $data) {
                        $this->addData($data, __('Advanced', 'shapepress-dsgvo'), 'spdsgvo_custom_sar');
                    }
                }
    
            } catch (Exception $e) {
                error_log($e);
            }
        }

        return $this->getData();
    }

    public function crawlLocal()
    {
        global $wpdb;

        if (! is_a($this->user, 'WP_User')) {

            // search public comments and then return

            $comments = get_comments(array(
                'author_email' => $this->email,
                'type' => ''
            ));
            foreach ($comments as $comment) {
                $this->addData($comment->comment_author, __('Name','shapepress-dsgvo'));
                $this->addData($comment->comment_author_email, __('Email','shapepress-dsgvo'));
                $this->addData($comment->comment_author_url, __('Url','shapepress-dsgvo'));
                $this->addData($comment->comment_author_IP, __('IP Address','shapepress-dsgvo'));
                $this->addData($comment->comment_content, __('Comment','shapepress-dsgvo'));
            }

            return;
        }

        // ====================================================
        // WP_User
        // ====================================================
        $this->addData($this->user->user_login, __('User name','shapepress-dsgvo'));
        $this->addData($this->user->user_nicename, __('Name','shapepress-dsgvo'));
        $this->addData($this->user->user_url, __('Url','shapepress-dsgvo'));
        $this->addData($this->user->display_name, __('Display name','shapepress-dsgvo'));

        // ====================================================
        // WP_Usermeta
        // ====================================================
        foreach (get_user_meta($this->user->ID) as $key => $meta) {
            if ($this->isSensativeKey($key)) {
                foreach ($meta as $metaValue) {
                    $this->addData($metaValue);
                }
            }
        }

        // ====================================================
        // WP_Comments
        // ====================================================
        $comments = get_comments(array(
            'user_id' => $this->user->ID
        ));
        //error_log('comments1: '.implode(', ',$comments));
        foreach ($comments as $comment) {
            $this->addData($comment->comment_author, __('Name','shapepress-dsgvo'));
            $this->addData($comment->comment_author_email, __('Email','shapepress-dsgvo'));
            $this->addData($comment->comment_author_url, __('Url','shapepress-dsgvo'));
            $this->addData($comment->comment_author_IP, __('IP Address','shapepress-dsgvo'));
            $this->addData($comment->comment_content, __('Comment','shapepress-dsgvo'));
        }


    }

    public function integrationsSAR()
    {
        foreach (SPDSGVOIntegration::getAllIntegrations(SPDSGVOConstants::CATEGORY_SLUG_PLUGINS) as $integration) {
            if (method_exists($integration, 'onSubjectAccessRequest')) {
                try {
                    $data = $integration->onSubjectAccessRequest($this->email, $this->firstName, $this->lastName, $this->user);
                    if (is_array($data)) {
                        foreach ($data as $value) {
                            if (is_string($value)) {
                                $this->addData($value, $integration->title, $integration->name);
                            } else if (is_array($value)) {
                                foreach ($value as $valueItem) {
                                    if (is_string($valueItem)) {
                                        $this->addData($valueItem, $integration->title, $integration->name);
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $e) {}
            }
        }
    }

    public function superUnsubscribe()
    {
        $this->user = get_user_by('email', $this->email);

        if (is_a($this->user, 'WP_User')) {
            $this->superUnsubscribeLocal();
        } else
        {
            $this->superUnsubscribeLocal();
        }

        if (isValidPremiumEdition()) 
        {
            try {
                apply_filters('spdsgvo_custom_unsubscribe', $this->email);
    
            } catch (Exception $e) {
                error_log($e);
            }
        }

        $this->superUnsubscribeIntegrations();
    }

    public function superUnsubscribeLocal()
    {
        global $wpdb;

        if (! is_a($this->user, 'WP_User')) { // only do commments for not registered ones

            // ======================================================================
            // WP_Comments
            // ======================================================================
            //error_log('not a user '.$this->email);
            $wpdb->get_results($wpdb->prepare("
				UPDATE $wpdb->comments
				SET
					comment_author 			= 'Deleted User',
					comment_author_email 	= %s,
					comment_author_url 		= '',
					comment_author_IP 		= '000.000.000.00'
				WHERE comment_author_email = '".  $this->email ."'", 'deleted_user_' . wp_generate_password(10, FALSE, FALSE) . '@example.com'));


            return;
        }

        $userID = wp_update_user(array(
            'ID' => $this->user->ID,
            'user_pass' => wp_generate_password(),
            'user_nicename' => 'Deleted User',
            'user_url' => '',
            'display_name' => 'Deleted User',
            'nickname' => 'Deleted User',
            'first_name' => 'Deleted',
            'last_name' => 'User',
            'description' => '',
            'rich_editing' => '',
            'user_registered' => '',
            'role' => '',
            'jabber' => '',
            'aim' => '',
            'yim' => '',
            'show_admin_bar_front' => ''
        ));

        $wpdb->get_results($wpdb->prepare("
				UPDATE $wpdb->users
				SET
					user_login = %s,
					user_email = %s
				WHERE ID = {$this->user->ID}", 'deleted_user_' . wp_generate_password(10, FALSE, FALSE), 'deleted_user_' . wp_generate_password(10, FALSE, FALSE) . '@example.com'));

        // ======================================================================
        // WP_Comments
        // ======================================================================
        $wpdb->get_results($wpdb->prepare("
				UPDATE $wpdb->comments
				SET
					comment_author 			= 'Deleted User',
					comment_author_email 	= %s,
					comment_author_url 		= '',
					comment_author_IP 		= '000.000.000.00'
				WHERE user_id = %d", $this->user->ID, 'deleted_user_' . wp_generate_password(10, FALSE, FALSE) . '@example.com'));

        // ======================================================================
        // WP_UserMeta
        // ======================================================================
        $meta = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->usermeta WHERE user_id = %d", $this->user->ID));

        foreach ($meta as $row) {
            if ($this->isSensativeKey($row->meta_key)) {
                $wpdb->get_results($wpdb->prepare("
						UPDATE $wpdb->usermeta
						SET
							meta_value = 'Deleted'
						WHERE umeta_id  = %d", $row->umeta_id));
            }
        }
    }

    public function superUnsubscribeIntegrations()
    {
        foreach (SPDSGVOIntegration::getAllIntegrations(SPDSGVOConstants::CATEGORY_SLUG_PLUGINS) as $integration) {
            if (method_exists($integration, 'onSuperUnsubscribe')) {
                try {
                    $integration->onSuperUnsubscribe($this->email, $this->firstName, $this->lastName, $this->user);
                } catch (Exception $e) {}
            }
        }
    }

    // ======================================================================
    // Helpers
    // ======================================================================
    public function addIdentifier($identifier, $type)
    {
        $identifier = strtolower($identifier);

        if (empty($identifier)) {
            return;
        }

        if (! in_array($identifier, $this->identifiers)) {
            $this->identifiers[] = (object) [
                'value' => $identifier,
                'type' => $type
            ];
        }
    }

    public function addData($data, $type = 'misc', $source = 'database')
    {
        // $data = strtolower($data);
        if (empty($data)) {
            return;
        }
        if ($data === '::1') {
            return;
        }

        foreach ($this->data as $d) {
            if ($d->data === $data) {
                return;
            }
        }

        if ($type === 'misc') {
            $type = $this->guessDataType($data);
            $type = ($type === FALSE) ? 'misc' : $type;
        }

        $this->data[] = (object) array(
            'data' => $data,
            'type' => $type,
            'source' => $source
        );
        $this->totalFound ++;
    }

    public function guessDataType($data)
    {
        $dataToCheck = strtolower($data);

        // IP Addresses
        preg_match_all('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $dataToCheck, $IPAddresses);
        foreach ($IPAddresses[0] as $ip) {
            return 'IP';
        }

        // Email
        preg_match_all('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $dataToCheck, $emailAdresses);
        foreach ($emailAdresses[0] as $emailAddress) {
            return __('Email','shapepress-dsgvo');
        }

        // Post Code
        preg_match_all('/((GIR 0AA)|((([A-PR-UWYZ][0-9][0-9]?)|(([A-PR-UWYZ][A-HK-Y][0-9][0-9]?)|(([A-PR-UWYZ][0-9][A-HJKSTUW])|([A-PR-UWYZ][A-HK-Y][0-9][ABEHMNPRVWXY])))) [0-9][ABD-HJLNP-UW-Z]{2}))/i', $dataToCheck, $postCodes);
        foreach ($postCodes[0] as $postCode) {
            return __('ZIP Code','shapepress-dsgvo');
        }

        // Phone Number
        preg_match_all('/^[().+\d -]{5,15}$/', $dataToCheck, $phoneNumbers);
        foreach ($phoneNumbers[0] as $phoneNumber) {
            if (strlen($phoneNumber) >= 7) {
                return __('Phone number','shapepress-dsgvo');
            }
        }

        // URLs
        preg_match_all('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $dataToCheck, $URLs);
        foreach ($URLs[0] as $url) {
            if (! empty($url)) {
                if (strpos($url, @parse_url($url)['host']) === FALSE) {
                    if (filter_var($url, FILTER_VALIDATE_URL)) {
                        return __('Url','shapepress-dsgvo');
                    }
                }
            }
        }

        // Address
        if (strpos($dataToCheck, 'road') !== FALSE || strpos($dataToCheck, 'street') !== FALSE) {
            return __('Address','shapepress-dsgvo');
        }

        foreach ($this->identifiers as $key => $identifier) {
            if ($identifier->value == $dataToCheck) {
                return $identifier->type;
            }
        }

        return false;
    }

    public function getData()
    {
        $done = array();
        $data = array();

        foreach ($this->data as $d) {
            if (! in_array($d->data, $done)) {
                $done[] = $d->data;
                $data[] = $d;
            }
        }

        return $data;
    }

    public function getDataByType()
    {
        $done = array();
        $data = array();

        foreach ($this->data as $d) {
            if (! in_array($d->data, $done)) {
                $done[] = $d->data;

                if (! isset($data[$d->type])) {
                    $data[$d->type] = array();
                }

                $data[$d->type][] = $d;
            }
        }

        return $data;
    }

    public function isSensativeKey($key)
    {
        return (str_replace($this->sensativeKeys, '', $key) !== $key);
    }

    public function searchStringForKnownIdentifiers($string)
    {
        $identifiers = array_unique($this->identifiers);

        foreach ($identifiers as $identifier) {
            if (strpos($string, $identifier) !== FALSE) {
                $this->addData($string);
            }
        }
    }
}

<?php

class SPDSGVOBuddypressIntegration extends SPDSGVOIntegration
{

    public $slug = 'bbp';

    public $title = 'buddyPress';

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
        global $wpdb;
        
        if (isValidPremiumEdition() == false) return;
        
        if (! class_exists('BuddyPress'))
            return;
        
        $buddypressAction = SPDSGVOSettings::get('su_buddypress_data_action');
        
        
        if ($buddypressAction == 'ignore')
            return;
        
        if ($user == NULL) {
            $user = get_user_by('email', $email);
        }
        
        if ($user == NULL || ! is_a($user, 'WP_User')) {
            // error_log('user null or not a wp_user');
            return;
        }
        
        if ($buddypressAction == 'del') {
            bp_activity_remove_all_user_data($user->ID);
            bp_core_delete_account($user->ID);
        } elseif ($buddypressAction == 'pseudo') {
            $wpdb->get_results($wpdb->prepare("
				UPDATE {$wpdb->prefix}bp_messages_messages
				SET
					subject 			= '".__('Deleted content','shapepress-dsgvo')."', 
					message         	= '". __('Deleted content','shapepress-dsgvo')."' 
				WHERE sender_id = " . $user->ID));
            
            $wpdb->get_results($wpdb->prepare("
				UPDATE {$wpdb->prefix}bp_xprofile_data
				SET
					value         	= '".__('Deleted content','shapepress-dsgvo')."'
				WHERE user_id = " . $user->ID));
        }
    }

    public function onSubjectAccessRequest($email, $firstName = NULL, $lastName = NULL, $user = NULL)
    {
        if (isValidPremiumEdition() == false) return;
        
        if (! class_exists('BuddyPress')) {
            //error_log('buddypress not active');
            return;
        }
        
        if ($user == NULL) {
            $user = get_user_by('email', $email);
        }
        
        if ($user == NULL || ! is_a($user, 'WP_User')) {
            return;
        }
        
        $data = array();
        
		try {
			// private messages
			$aParams['user_id'] = $user->ID;
			$aParams['max'] = FALSE;
			$aParams['box'] = 'sentbox';
			if (bp_has_message_threads($aParams)) {
				while (bp_message_threads()) {
					bp_message_thread();
					
					// error_log('foreach ($allPns->messages ' . $pn->excerpt);
					$data[] = __('PM between','shapepress-dsgvo') .' ' . bp_get_message_thread_to();
					$data[] = __('Title:','shapepress-dsgvo'). ' ' . bp_get_message_thread_subject();
					$data[] = __('Message: ','shapepress-dsgvo'). ' <i>' . bp_get_message_thread_excerpt() . '</i>';
				}
			}
		} catch (Exception $e)
		{
		}
        
        // blogs
		try {
			
			$blogParams['user_id'] = $user->ID;
			if (bp_has_blogs($blogParams)) {
				while (bp_blogs()) {
					bp_the_blog();
					
				   // error_log('while blogs');
					$data[] = __('Blog','shapepress-dsgvo'). ' ' . bp_blog_name();
				}
			}
        } catch (Exception $e)
		{
		}
        // profile fields
        // $profileParams['user_id'] = $user->ID;
        // $profileParams['hide_empty_groups'] = FALSE;
        // $profileParams['fetch_fields'] = TRUE;
        // $profileParams['fetch_fields_data'] = TRUE;
        // if ( bp_has_profile($profileParams) ) {
        
        // $data[] = 'Erweiterte Profilfelder';
        // while ( bp_profile_groups() )
        // {
        // bp_the_profile_group();
        // if ( bp_profile_group_has_fields() ){
        
        // bp_the_profile_group_name();
        // while ( bp_profile_fields() ) {
        
        // bp_the_profile_field();
        // if ( bp_field_has_data() )
        // {
        // $data[] = bp_the_profile_field_name(). ':' .bp_the_profile_field_value();
        // }
        // }
        // }
        // }
        // }
        
		try {
			$data[] = __('Profildaten','shapepress-dsgvo');
			$groups = bp_xprofile_get_groups(array(
				'user_id' => $user->ID,
				'hide_empty_groups' => true,
				'hide_empty_fields' => true,
				'fetch_fields' => true,
				'fetch_field_data' => true
			));
			foreach ((array) $groups as $group) {
				if (empty($group->fields)) {
					continue;
				}
				
				foreach ((array) $group->fields as $field) {
					
					$data[] = __('Field group','shapepress-dsgvo') .': ' . $group->name . ':' . $field->name . ':' . $field->data->value;
					// $profile_data[ $field->name ] = array(
					// 'field_group_id' => $group->id,
					// 'field_group_name' => $group->name,
					// 'field_id' => $field->id,
					// 'field_type' => $field->type,
					// 'field_data' => $field->data->value,
					// );
				}
			}
		} catch (Exception $e)
		{
		}
        
        return $data;
    }

    /**
     * Returns an object with messages for the current user
     *
     * @return Object Messages
     */
    public function get_messages($user)
    {
        /*
         * Possible parameters:
         * String box: the box you the messages are in (possible values are 'inbox', 'sentbox', 'notices', default is 'inbox')
         * int per_page: items to be displayed per page (default 10)
         * boolean limit: maximum numbers of emtries (default no limit)
         */
        //error_log('buddyPress.get_messages of userid ' . $user->ID);
        
        $messages = array();
        $aParams['user_id'] = $user->ID;
        $aParams['max'] = FALSE;
        $aParams['box'] = 'sentbox';
        if (bp_has_message_threads($aParams)) {
            while (bp_message_threads()) {
                bp_message_thread();
                $aTemp = new stdClass();
                $aTemp->id = bp_get_message_thread_id();
                $aTemp->from = bp_get_message_thread_from();
                $aTemp->to = bp_get_message_thread_to();
                $aTemp->subject = bp_get_message_thread_subject();
                $aTemp->excerpt = bp_get_message_thread_excerpt();
                $aTemp->link = bp_get_message_thread_view_link();
                $messages[] = $aTemp;
            }
        } else {
            return $this->error('message');
        }
        
        return $messages;
    }
}

SPDSGVOBuddypressIntegration::register();
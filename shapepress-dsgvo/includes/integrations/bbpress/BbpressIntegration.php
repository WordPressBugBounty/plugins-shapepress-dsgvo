<?php

class SPDSGVOBbpressIntegration extends SPDSGVOIntegration
{

    public $slug = 'bbp';

    public $title = 'bbPress';

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
        
        if (! class_exists('bbPress'))
            return;
        
        $bbpAction = SPDSGVOSettings::get('su_bbpress_data_action');
       
        if ($bbpAction == 'ignore') return; 
        
        if ($user == NULL) {
            $user = get_user_by('email', $email);
        }
        
        if ($user == NULL || ! is_a($user, 'WP_User')) {
            //error_log('user null or not a wp_user');
            return;
        }
        
        
        $args = array(
            'author' => $user->ID,
            'post_type' => array(
                'forum',
                'topic',
                'reply'
            )
        );
        
        $userPosts = get_posts($args);
        
        if ($userPosts) {
            foreach ($userPosts as $post) {
                //error_log('bbpAction: '.$bbpAction .'foreach ($userPosts: '.$post->ID);
                if ($bbpAction == 'del')
                {
                    wp_delete_post( $post->ID, FALSE );
                    //error_log('wp_delete_post: '.$post->ID);
                } elseif ($bbpAction == 'pseudo') {
                    
                    $post->post_content = __('Deleted content','shapepress-dsgvo');
                    $post->post_title = __('Deleted content','shapepress-dsgvo');
                    wp_update_post($post);
                }
            }
        }
    }

    public function onSubjectAccessRequest($email, $firstName = NULL, $lastName = NULL, $user = NULL)
    {
        if (isValidPremiumEdition() == false) return;
        
        if (! class_exists('bbPress')) {
            // error_log('bbPress not active');
            return;
        }
        
        if ($user == NULL) {
            $user = get_user_by('email', $email);
        }
        
        if ($user == NULL || ! is_a($user, 'WP_User')) {
            // error_log('user null or not a wp_user');
            return;
        }
        
        $data = array();
        
        $args = array(
            'author' => $user->ID,
            'post_type' => array(
                'forum',
                'topic',
                'reply'
            )
        );
        
        $userPosts = get_posts($args);
        
        if ($userPosts) {
            foreach ($userPosts as $post) {
                if ($post->post_type == 'forum') {
                    $data[] = __('Forum','shapepress-dsgvo')." '" . $post->post_title . "' " . __('on','shapepress-dsgvo')." ". date("d.m.Y H:i", strtotime($post->post_date));
                } elseif ($post->post_type == 'topic') {
                    $data[] = __('Forum thread','shapepress-dsgvo'). " '" . $post->post_title . "' ". __('on','shapepress-dsgvo')." ". date("d.m.Y H:i", strtotime($post->post_date));
                } elseif ($post->post_type == 'reply') {
                    $data[] = __('Forum entry','shapepress-dsgvo'). " ". __('on','shapepress-dsgvo')." ". date("d.m.Y H:i", strtotime($post->post_date));
                }
                
                $data[] = '<i>' . $post->post_content . '</i>';
            }
        }
        
        return $data;
    }
}

SPDSGVOBbpressIntegration::register();
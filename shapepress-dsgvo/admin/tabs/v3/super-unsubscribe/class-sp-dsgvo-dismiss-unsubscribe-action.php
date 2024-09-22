<?php
/* i592995 */
Class SPDSGVODismissUnsubscribeAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-dismiss-unsubscribe';

    protected function run(){

		$this->requireAdmin();
		$this->checkCSRF();

        $id = $this->get('id');
		if (is_numeric($id)) {
			$postType = get_post_type($id );
			if ($postType == "subjectaccessrequest" || $postType == "spdsgvo_unsubscriber") {
				wp_delete_post( $id );
			}
		}
        die();
    }
}

SPDSGVODismissUnsubscribeAction::listen();

/* i592995 */

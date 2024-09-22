<?php

Class DoDSGVODeleteDataRequest extends SPDSGVOCron{

    public $interval = array(
        'days'     => 1,
    );

    public function handle(){
        $delCron = SPDSGVOSettings::get('su_auto_del_time');
        if($delCron !== '0'){

            $daysAgo = strtotime('-'.$delCron.' day');

            error_log(__('DoDSGVODeleteDataRequest with days:', 'shapepress-dsgvo').' '.$delCron . ' ' . __('and intval:', 'shapepress-dsgvo') . ' '.$daysAgo);

            foreach(SPDSGVOUnsubscriber::finder('pending') as $sar){

	            $post = $sar->_post;//  get_post($sar->ID);
	            error_log(__('doing sar', 'shapepress-dsgvo') . ' '. $sar->ID . ' ' . __('with intval', 'shapepress-dsgvo') . ' '. intval(strtotime($post->post_date)));

	            if (intval(strtotime($post->post_date)) <= intval($daysAgo))
	            {
	                $sar->doSuperUnsubscribe();
	            } else
	            {
	                error_log(__('sar', 'shapepress-dsgvo') . ' '. $sar->ID . ' ' . __('has not the date to process', 'shapepress-dsgvo'));
	            }
	        }
	    }
    }
}

DoDSGVODeleteDataRequest::register();

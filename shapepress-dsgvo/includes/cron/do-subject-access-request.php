<?php

Class DoDSGVOSubjectAccessRequest extends SPDSGVOCron{

    public $interval = array(
        'days'     => 1,
    );

    public function handle(){
        $sarCron = SPDSGVOSettings::get('sar_cron');
        if($sarCron !== '0'){

            $daysAgo = strtotime('-'.$sarCron.' day');

            //error_log('DoDSGVOSubjectAccessRequest with days: '.$sarCron . ' and intval: '.$daysAgo);

	        foreach(SPDSGVOSubjectAccessRequest::finder('pending') as $sar){

	            $post = $sar->_post;//  get_post($sar->ID);
	            //error_log('doing sar '. $sar->ID . ' with intval '. intval(strtotime($post->post_date)));

	            if (intval(strtotime($post->post_date)) <= intval($daysAgo))
	            {
	        	  $sar->doSubjectAccessRequest();
	            } else
	            {
	                //error_log('sar '. $sar->ID . ' has not the date to process');
	            }
	        }
	    }
    }
}

DoDSGVOSubjectAccessRequest::register();

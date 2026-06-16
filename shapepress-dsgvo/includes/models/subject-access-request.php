<?php

Class SPDSGVOSubjectAccessRequest extends SPDSGVOModel {

	public $postType = 'subjectaccessrequest';
	public $dataCollecter;
	public $collectedData;
	public $attributes = array(
		'first_name',
		'last_name',
		'email',
	    'dsgvo_accepted',
		'owner_user_id',

		'token',
		'status',
		'pdf_path',
		'json_path',
		'download_key_hash',
		'download_expires_at',
		'download_used_at',
	);
	public $default = array(
		'status' => 'pending'
	);


	//======================================================================
	// doSubjectAccessRequest()
	//======================================================================
	public function doSubjectAccessRequest($displayEmail = FALSE){
		$this->status = 'in-progress';
		$this->save();


		// SAR
		$dataCollecter = new SPDSGVODataCollecter($this->email, $this->first_name, $this->last_name);
        $dataCollecter->sar();
        $this->collectedData = $dataCollecter->getDataByType();
		$this->buildPDF();
		$this->buildJSON();


		// WP_Mail - loop refactor?
		$breakdown = '';
		$i = 0;
		foreach($this->collectedData as $type => $rows){
			$breakdown .= sprintf('<p><strong>%s</strong></p>', ucwords(str_replace('_', ' ', $type)));

			$breakdown .= '<p style="padding-left:20px;">';

			$data = array();
			foreach($rows as $key => $row){
				if($key < 3){
					array_push($data, $row->data);
				}
			}
			$breakdown .= implode(', ', $data);
			$breakdown .= '</p>';

			$i++;
			if($i > 5){
				break;
			}
		}

		$locale = SPDSGVOLanguageTools::getInstance()->getCurrentLanguageCode();
		$downloadKey = $this->issueDownloadKey();

		/* p912419 */
        $title = !empty( SPDSGVOSettings::get('sar_email_title') ) ? SPDSGVOSettings::get('sar_email_title') : __('Subject access request','shapepress-dsgvo');
        if(function_exists('icl_translate')) {
            $title = icl_translate('shapepress-dsgvo', 'sar_email_title', $title);
        }

        $content = SPDSGVOSettings::get('sar_email_content');
        if(function_exists('icl_translate')) {
            $content = icl_translate('shapepress-dsgvo', 'sar_email_content', $content);
        }
        /* p912419 end */


		// Send Email
		$email = SPDSGVOMail::init()
		    ->from(SPDSGVOSettings::get('admin_email'))
		    ->to($this->email)
		    ->subject($title. ': '. parse_url(home_url(), PHP_URL_HOST)) // p912419
		    ->beforeTemplate(SPDSGVO::pluginDir('/templates/'.$locale.'/emails/header.php'))
		    ->afterTemplate( SPDSGVO::pluginDir('/templates/'.$locale.'/emails/footer.php'))
		    ->template(SPDSGVO::pluginDir('/templates/'.$locale.'/emails/subject-access-request.php'), array(
		        'title' 		=> $title,
                'content'       => $content, // p912419

                'zip_link' 		=> SPDSGVODownloadSubjectAccessRequestAction::url(array(
                	'token' 	=> $this->token,
                	'download_key' => $downloadKey,
                	'file'  	=> 'zip',
                )),

				'count'			=> $dataCollecter->totalFound,
				'breakdown'		=> $breakdown,

                'home_url' 		=> home_url(),
		        'website' 		=> home_url(),
				'admin_email' 	=> SPDSGVOSettings::get('admin_email'),
            ));


		try{
			$email->attach(array(
				$this->pdf_path,
			));
		}catch(Exception $e){

		}


		$email->send();
		$this->status = 'done';
		$this->save();

		if($displayEmail){
			echo wp_kses_post($email->render());
			die;
		}
	}

	public static function doByID($ID, $displayEmail = FALSE){
		if (is_numeric($ID) == FALSE) return FALSE;

		$sar = SPDSGVOSubjectAccessRequest::find($ID);
        if(!is_null($sar)){
            $sar->doSubjectAccessRequest($displayEmail);
            return TRUE;
        }

        return FALSE;
	}


	//======================================================================
	// Finders
	//======================================================================
	public function _finderToken($args){
		 return array(
            'meta_query' => array(
                array(
                    'key'	=> 'token',
                    'value' => $args['token']
               	)
            )
        );
	}

	public function _postFinderToken($results, $args){
		return @$results[0];
	}

	public function _finderPending($args){
		 return array(
            'meta_query' => array(
                array(
                    'key'	=> 'status',
                    'value' => 'pending'
               	)
            )
        );
	}


	//======================================================================
	// Hooks
	//======================================================================
	public function inserting(){
		$this->token = self::randomString();
	}


	//======================================================================
	// Misc
	//======================================================================
	public function name(){
		return $this->first_name .' '. $this->last_name;
	}

	public function filename($extension){
		return preg_replace('/\s+/', '', sprintf('SAR-%s-%s-%s.%s', ucfirst($this->first_name), ucfirst($this->last_name), $this->ID, $extension));
	}

	public static function randomString($len = 20){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for($i = 0; $i < $len; $i++){
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

    public function issueDownloadKey($ttl = NULL){
        if($ttl === NULL){
            $ttl = defined('DAY_IN_SECONDS') ? DAY_IN_SECONDS : 86400;
        }

        $downloadKey = wp_generate_password(48, FALSE, FALSE);
        $this->download_key_hash = wp_hash_password($downloadKey);
        $this->download_expires_at = (string) (current_time('timestamp') + absint($ttl));
        $this->download_used_at = '';
        $this->save();

        return $downloadKey;
    }

    public function hasValidDownloadKey($downloadKey){
        if(empty($downloadKey) || empty($this->download_key_hash)){
            return FALSE;
        }

        if(!empty($this->download_used_at)){
            return FALSE;
        }

        $expiresAt = intval($this->download_expires_at);
        if($expiresAt > 0 && current_time('timestamp') > $expiresAt){
            return FALSE;
        }

        return wp_check_password($downloadKey, $this->download_key_hash);
    }

    public function consumeDownloadKey(){
        $this->download_used_at = (string) current_time('timestamp');
        $this->download_key_hash = '';
        $this->download_expires_at = '';
        $this->save();
    }

    public function isOwnedByCurrentUser(){
        if(!is_user_logged_in()){
            return FALSE;
        }

        $user = wp_get_current_user();
        if(!$user || empty($user->ID)){
            return FALSE;
        }

        if(!empty($this->owner_user_id) && intval($this->owner_user_id) === intval($user->ID)){
            return TRUE;
        }

        return !empty($this->email) && strcasecmp($this->email, $user->user_email) === 0;
    }

    public function buildPDF(){

        if(!class_exists( 'DSGVOTCPDF' )){
            require_once SPDSGVO::pluginDir('includes/lib/tcpdf/DSGVOTCPDF.php');
            require_once SPDSGVO::pluginDir('includes/class-sp-dsgvo-pdf.php');
        }

        $pdf = new SPDSGVOPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle(__('All data of', 'shapepress-dsgvo') . ' '.   $this->name());
        $pdf->SetSubject(__('All data of', 'shapepress-dsgvo') . ' '. $this->name());

        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, __('All data of', 'shapepress-dsgvo') . " {$this->name()}", sprintf(__('Date', 'shapepress-dsgvo') . ": %s \n" . __('Source', 'shapepress-dsgvo') . ": %s", date('j. F Y, G:i:s'), home_url()));
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFont('helvetica', '', 12);
        $pdf->AddPage();
        $pdf->coloredTable($this->collectedData);

        $path = '';
        $fileName = $this->filename('pdf');
        $upload = wp_upload_bits($fileName, NULL, $pdf->Output($path, 'S'));
        $this->pdf_path = $this->getUploadedFilePath($upload);
        $this->save();
    }

    public function buildJSON(){
        $json = json_encode($this->collectedData);
        $fileName = 'SAR-'.self::randomString().'.json';
        $upload = wp_upload_bits($fileName, NULL, $json);
        $this->json_path = $this->getUploadedFilePath($upload);
        $this->save();
    }

    protected function getUploadedFilePath($upload){
        if(!is_array($upload)){
            return '';
        }

        if(!empty($upload['error'])){
            return '';
        }

        if(empty($upload['file'])){
            return '';
        }

        return $upload['file'];
    }
}


SPDSGVOSubjectAccessRequest::register(array(
	'show_in_nav_menus'   => FALSE,
	'show_in_menu' 		  => FALSE,
	'show_ui' 			  => FALSE,
	'publicly_queryable'  => FALSE,
	'exclude_from_search' => FALSE,
	'public' 			  => FALSE,
));

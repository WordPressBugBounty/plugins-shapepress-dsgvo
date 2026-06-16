<?php

Class SPDSGVODownloadSubjectAccessRequestAction extends SPDSGVOAjaxAction{

    protected $action = 'download-subject-access-request';

    public $sar;
    protected $authorizedByGrant = FALSE;

    public function run(){
        if(!$this->has('token')){
            $this->error(__('No token provided.', 'shapepress-dsgvo'));
        }

        $this->sar = SPDSGVOSubjectAccessRequest::finder('token', array(
            'token' => $this->get('token')
        ));

        if(is_null($this->sar)){
            $this->error(__('Bad token provided.', 'shapepress-dsgvo'));
        }

        $this->authorizeRequest();

        switch($this->get('file', 'zip')){
            case 'json':
                $json = $this->sar->json_path;
                $this->download($json, TRUE);
                break;

            case 'pdf':
                $pdf = $this->sar->pdf_path;
                $this->download($pdf, TRUE);
                break;

            case 'zip':
            default:
                $this->archive(TRUE);
                break;
        }
    }

    public function archive($consumeGrant = FALSE){
        if(!class_exists('ZipArchive')){
            $pdf = $this->sar->pdf_path;
            $this->download($pdf, $consumeGrant);
        }

        $zipFile = $this->sar->filename('zip');
        $zipPath = wp_upload_dir()['path'] .'/'. $zipFile;
        $zip = new ZipArchive();
        $opened = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        if($opened !== TRUE){
            $this->error(__('Could not create archive.', 'shapepress-dsgvo'));
        }

        $addedFiles = 0;
        if($this->addExistingFileToArchive($zip, $this->sar->pdf_path, $this->sar->filename('pdf'))){
            $addedFiles++;
        }
        if($this->addExistingFileToArchive($zip, $this->sar->json_path, $this->sar->filename('json'))){
            $addedFiles++;
        }

        $zip->close();

        if($addedFiles === 0 || !$this->hasDownloadableFile($zipPath)){
            if(file_exists($zipPath)){
                unlink($zipPath);
            }

            $this->error(__('No export files available for download.', 'shapepress-dsgvo'));
        }

        $this->consumeGrantIfRequired($consumeGrant);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='. basename($zipPath));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '. filesize($zipPath));

        ob_clean();
        flush();
        readfile($zipPath);
        die();
    }

    public function download($path, $consumeGrant = FALSE){
        if(!$this->hasDownloadableFile($path)){
            _e('Error', 'shapepress-dsgvo');
            die();
        }

        $this->consumeGrantIfRequired($consumeGrant);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='. basename($path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '. filesize($path));

        ob_clean();
        flush();
        readfile($path);
        die();
    }

    protected function addExistingFileToArchive($zip, $path, $filename){
        if(!$this->hasDownloadableFile($path)){
            return FALSE;
        }

        $archiveFolder = trim($this->sar->name());
        if($archiveFolder === ''){
            $archiveFolder = 'subject-access-request';
        }

        return $zip->addFile($path, $archiveFolder .'/'. $filename);
    }

    protected function hasDownloadableFile($path){
        return !empty($path) && file_exists($path) && is_file($path);
    }

    protected function authorizeRequest(){
        if(current_user_can('manage_options')){
            return;
        }

        if($this->sar->isOwnedByCurrentUser()){
            return;
        }

        $downloadKey = $this->get('download_key');
        if($this->sar->hasValidDownloadKey($downloadKey)){
            $this->authorizedByGrant = TRUE;
            return;
        }

        $this->error(__('You are not allowed to download this export.', 'shapepress-dsgvo'));
    }

    protected function consumeGrantIfRequired($consumeGrant){
        if($consumeGrant && $this->authorizedByGrant){
            $this->sar->consumeDownloadKey();
            $this->authorizedByGrant = FALSE;
        }
    }
}

SPDSGVODownloadSubjectAccessRequestAction::listen();

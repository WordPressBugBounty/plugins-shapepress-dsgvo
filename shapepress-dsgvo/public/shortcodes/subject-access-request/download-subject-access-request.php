<?php

Class SPDSGVODownloadSubjectAccessRequestAction extends SPDSGVOAjaxAction{

    protected $action = 'download-subject-access-request';

    public $sar;

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

        switch($this->get('file', 'zip')){
            case 'json':
                $json = $this->sar->json_path;
                $this->download($json);
                break;

            case 'pdf':
                $pdf = $this->sar->pdf_path;
                $this->download($pdf);
                break;

            case 'zip':
            default:
                $this->archive();
                break;
        }
    }

    public function archive(){
        if(!class_exists('ZipArchive')){
            $pdf = $this->sar->pdf_path;
            $this->download($pdf);
        }

        $zipFile = $this->sar->filename('zip');
        $zipPath = wp_upload_dir()['path'] .'/'. $zipFile;
        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFile($this->sar->pdf_path,  $this->sar->name() .'/'. $this->sar->filename('pdf'));
        $zip->addFile($this->sar->json_path, $this->sar->name() .'/'. $this->sar->filename('json'));
        $zip->close();

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

    public function download($path){
        if(!file_exists($path)){
            _e('Error', 'shapepress-dsgvo');
            die();
        }

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
}

SPDSGVODownloadSubjectAccessRequestAction::listen();

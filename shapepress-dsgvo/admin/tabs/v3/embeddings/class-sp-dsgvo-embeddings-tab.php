<?php

class SPDSGVOEmbeddingsIntegrationsTab extends SPDSGVOAdminTab{

    public $title = 'Embeddings';
    public $slug = 'embeddings-integrations';
    public $isHidden = FALSE;

    public function __construct(){

        $this->title = __('Embeddings','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}

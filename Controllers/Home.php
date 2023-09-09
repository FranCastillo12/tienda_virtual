<?php

    class Home extends Controllers{

        public function __construct()
        {
            parent::__construct();
            
        }

        public function home()
        {
            $data['tag_page'] = "Home";
            $data['page_title'] = "Pagina Principal";
            $data['tag_name'] = "Home";
           //Invocar la vista home
            $this->views->getView($this,"home",$data);
        }
    }

?>
<?php

    class dashboard extends Controllers{

        public function __construct()
        {
            parent::__construct();
            session_start();
            session_regenerate_id(true);
            if(empty($_SESSION['login'])){
                header('Location '.base_Url().'/login');
            }
            //Se envia por parametro el id del modulo
            getPermisos(1);
            
        }

        public function dashboard()
        {
            $data['page_id'] = 2;
            $data['page_tag'] = "Dashboard - Tienda Virtual";
            $data['page_title'] = "Dashboard - Tienda Virtual";
            $data['tag_name'] = "dashboard";
           //Invocar la vista home
            $this->views->getView($this,"dashboard",$data);
        }
    }

?>
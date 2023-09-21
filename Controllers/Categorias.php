<?php 
    class Usuarios extends Controllers{

        public function __construct()
        {
            parent::__construct();
            session_start();
            session_regenerate_id(true);
            if(empty($_SESSION['login'])){
                header('Location '.base_Url().'/login');
            }
            getPermisos(2);
        }

        public function Usuarios()
        {
            $data['page_tag'] = "Usuarios";
            $data['page_title'] = "USUARIOS <small>Tienda Virtual</small>";
            $data['page_name'] = "usuarios";
           //Invocar la vista home
            $this->views->getView($this,"usuarios",$data);
        }

?>
<?php

    class Roles extends Controllers{

        public function __construct()
        {
            parent::__construct();
            
        }

        public function Roles()
        {
            $data['page_id'] = 3;
            $data['page_tag'] = "Roles Usuarios";
            $data['page_name'] = "Rol_usuario";
            $data['page_title'] = "Roles Usuarios <small> Tienda Virtual</small>";
           //Invocar la vista home
            $this->views->getView($this,"roles",$data);
        }
    }

?>
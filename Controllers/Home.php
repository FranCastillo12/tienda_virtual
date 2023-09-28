<?php
    require_once("Models/TCategoria.php");
    require_once("Models/TProducto.php");

    class Home extends Controllers{
        //Hacer uso de un trait
        use TCategoria,TProducto;
        public function __construct()
        {
            parent::__construct();
            
        }

        public function home()
        {
            $data['page_tag'] = "Tienda Virtual";
            $data['page_title'] = "Tienda Virtual";
            $data['page_name'] = "tienda_virtual";
            $data['slider'] = $this->getCategoriasT(CAT_SLIDER);
            $data['banner'] = $this->getCategoriasT(CAT_BANNER);
            $data['productos'] = $this->getProductosT();
           //Invocar la vista home
            $this->views->getView($this,"home",$data);
        }
    }

?>
<?php
    require_once("Models/TCategoria.php");
    require_once("Models/TProducto.php");

    class Tienda extends Controllers{
        //Hacer uso de un trait
        use TCategoria,TProducto;
        public function __construct()
        {
            parent::__construct();
            
        }

        public function tienda()
        {
            $data['page_tag'] = "Tienda Virtuallll";
            $data['page_title'] = "Tienda Virtual";
            $data['page_name'] = "tienda";
            $data['productos'] = $this->getProductosT();

            
           //Invocar la vista home
            $this->views->getView($this,"tienda",$data);
        }

        public function categoria($params){
            //saber  se los parametros vienen vacios
            if(empty($params)){
                //redirecciona a la pantalla principal
                header("Location:".base_Url());
            }
            else{
                $categoria = strClean($params);
                
                $data['page_tag'] = "Tienda Virtual"." | ".$categoria;
                $data['page_title'] = $categoria;
                $data['page_name'] = "categoria";
                $data['productos'] = $this->getProductosCategoriaT($categoria);

                
            //Invocar la vista home
                $this->views->getView($this,"categoria",$data);
            }
        }
        public function producto($params){
            //saber  se los parametros vienen vacios
            if(empty($params)){
                //redirecciona a la pantalla principal
                header("Location:".base_Url());
            }
            else{
                $producto = strClean($params);
                $arrProducto = $this->getProductoT($producto);
                $data['page_tag'] = "Tienda Virtual"." | ".$producto;
                $data['page_title'] = $producto;
                $data['page_name'] = "producto";
                $data['producto'] = $arrProducto;
                $data['productos'] = $this->getProductosRandom($arrProducto['categoriaid'],8,"r"); 
            //Invocar la vista home
                $this->views->getView($this,"producto",$data);
            }
        }
        
    }

?>
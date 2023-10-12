<?php
    require_once("Models/TCategoria.php");
    require_once("Models/TProducto.php");
    require_once("Models/TTipoPago.php");
    require_once("Models/TCliente.php");



    class Carrito extends Controllers{
        //Hacer uso de un trait
        use TCategoria,TProducto,TTipoPago,TCliente ;
        public function __construct()
        {
            parent::__construct();
            session_start();
            
        }

        public function carrito()
        {
            $data['page_tag'] = "Tienda Virtual - Carrito";
            $data['page_title'] = "Carrito de compras";
            $data['page_name'] = "carrito";

           //Invocar la vista home
            $this->views->getView($this,"carrito",$data);
        }

        
        public function procesarpago()
        {

            if(empty($_SESSION['arrCarrito'])){
                header("Location: ".base_Url());
                die();
            }

            //Obtener la informacion del pedido
            $infoOrden = $this->getPedido();
            $dataEmailOrden = array('pedido' => $infoOrden);

            $mail = getFile("Template/Email/confirmar_order",$dataEmailOrden);

            $data['page_tag'] = "Tienda Virtual - Procesar pago";
            $data['page_title'] = "Procesar pago";
            $data['page_name'] = "procesarpago";
            $data['tiposPago'] = $this->getTiposPago();



           //Invocar la vista procesarpago
            $this->views->getView($this,"procesarpago",$data);
        }
        


    }

?>
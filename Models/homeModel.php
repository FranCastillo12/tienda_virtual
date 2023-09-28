<?php
    //require_once('CategoriasModel.php');
    class homeModel extends mysql
    {

        private $objCategoria;
        public function __construct()
        {
            parent::__construct();
            //Se crea un objeto del archivo CategoriasModel para usar el misma
            //Funcion de llamar las categoriaas
            //$this->objCategoria = new CategoriasModel();
        }

        public function getCategorias(){
            //Aqui se retorna la funcion que se encuentra en el archivo CategoriasModel
           // return $this->objCategoria->selectCategorias();
        }
    }
?>
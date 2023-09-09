<?php

    class Errors extends Controllers{

        public function __construct()
        {
            parent::__construct();
            
        }

        public function notFound()
        {
            echo 'mensaje';
           //Invocar la vista home
            $this->views->getView($this,"error");
        }
    }

    $notFound = new Errors();
    $notFound->notFound();    

?>
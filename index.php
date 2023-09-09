<?php
    require_once("config/config.php");
    
    require_once("Helpers/Helpers.php");

    //El la url se almacena ruta que viene despues del
    //archivo raiz(Es decir el index.php)
    
    //Si no se envia ningun parametro por la url lo que hace es 
    //Hacer una validación para asignas la rura que tiene por default
    
    $url = !empty($_GET['url'])? $_GET['url'] :'home/home' ;
    $arrUrl = explode("/",$url);
    $controller = $arrUrl[0];
    $method = $arrUrl[0];
    $params = "";

    //Validacion para saber si el parametro del 
    //metodo viene vacio o no para asignar a la variable
    if(!empty($arrUrl[1])){
        if($arrUrl[1] != ""){
            $method = $arrUrl[1];
        }
    }
    //Validacion para los parametros
    if(!empty($arrUrl[2])){
        if($arrUrl[2] != ""){
            //se utiliza un for para saber la cantidad de parametros que se enviaron
            //Y se concatencan en la variables params utlizando una coma
            for ($i=2; $i < count($arrUrl); $i++) { 
                $params .= $arrUrl[$i].',';
            }
            $params = trim($params,","); 
        }
    }

    require_once("Libraries/Core/Autoload.php");

    require_once("Libraries/Core/Load.php");

?>

<?php

    class Usuarios extends Controllers{

        public function __construct()
        {
            parent::__construct();
            
        }

        public function Usuarios()
        {
            $data['page_tag'] = "Usuarios";
            $data['page_title'] = "USUARIOS <small>Tienda Virtual</small>";
            $data['page_name'] = "usuarios";
           //Invocar la vista home
            $this->views->getView($this,"usuarios",$data);
        }
        public function setUsuario()
        {
            if($_POST){
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoId = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));
                    $strPassword =  empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);
                    $request_user = $this->model->insertUsuario($strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strPassword,$intTipoId,$intStatus,);

                    if($request_user >0){
                        $arrReponse = array('status'=> true,'msg'=>'Datos guardados correctamente');
                    }
                    else if($request_user == 'exist'){
                        $arrReponse = array('status'=> false,'msg'=>'Atencion el email o la identificacion ya existe,ingrese otro');
                    }
                    else{
                        $arrReponse = array('status'=> true,'msg'=>'No es posible almacenar los dartos');

                    }
                    echo json_encode($arrReponse,JSON_UNESCAPED_UNICODE);
            }   
            die();
            
            
            
        }







        
    }

?>
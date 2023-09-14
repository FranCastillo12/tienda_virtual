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
                    $idUsuario =  intval($_POST['idUsuario']);
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoId = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));
                    $request_user = "";
            

                    if($idUsuario== 0){
                        $opcion = 1;
                        $strPassword =  empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);
                        $request_user = $this->model->insertUsuario($strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strPassword,$intTipoId,$intStatus);
                    }
                    else{
                        $opcion = 2;
						$strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
                        $request_user = $this->model->updateUsuario($idUsuario,$strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strPassword,$intTipoId,$intStatus);
                    }
                    if($request_user > 0){
                        if($opcion == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
                        
                    }
                    else if($request_user == 'exist'){
                        $arrResponse = array('status'=> false,'msg'=>'Atencion el email o la identificacion ya existe,ingrese otro');
                    }
                    else{
                        $arrResponse = array('status'=> true,'msg'=>'No es posible almacenar los dartos');

                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }   
            die();
            
            
            
        }
        

        public function getUsuarios()
        {
            $arrData = $this->model->selectUsuarios();
            for ($i= 0; $i< count($arrData) ; $i++) { 
                //IF para saber si el status es 1
                if ($arrData[$i]['status']== 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                    # code...
                }
                else{
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                 //Se le agrega al array de los datos el columna opcions 
                $arrData[$i]['options'] ='<div class="text-center">
                <button class="btn btn-secondary btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['idpersona'].')" title="Ver usuario"><i class="fas fa-eye"></i></button>
                <button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario('.$arrData[$i]['idpersona'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['idpersona'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                </div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getUsuario(int $idpersona)
        {
            $idusuario = intval($idpersona);
            if($idusuario >0){
                
                $arrData = $this->model->selectUsuario($idusuario);
                if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        
        public function delUsuario(){
            $idUsario = intval($_POST['idUsuario']);
            $requestDelete = $this->model->deleteUsuario($idUsario);
            if($requestDelete == 'ok')
            {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usario');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    die();
        }


        
    }

?>
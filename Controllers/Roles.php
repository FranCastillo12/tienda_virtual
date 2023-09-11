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

        //Metodo para obtener los roles
        public function getRoles(){
            $arrData = $this->model->selectRoles();

            //For para recorrer el json para saber el status
            for ($i=0; $i < count($arrData); $i++) { 
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
                <button class="btn btn-secondary btn-sm btnPermisosRol" rl="'.$arrData[$i]['idrol'].'" title="Permisos"><i class="fas fa-key"></i></button>
                <button class="btn btn-primary btn-sm btnEditRol" rl="'.$arrData[$i]['idrol'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger btn-sm btnDelRol" rl="'.$arrData[$i]['idrol'].'" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                </div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getRol(int $idrol){

            $intidrol = intval(strClean(($idrol)));

            if ($intidrol > 0){

                $arrData = $this->model->selectRol($intidrol);

                if(empty($arrData))
                {
                    $arrResponse = array('status' => false, 'mgs' => 'Datos no encontrados');
                }else{
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();

        }        
        public function setRol(){
            $intIdRol = intval($_POST['idRol']);
            $strRol =  strClean($_POST['txtNombre']);
            $strDescipcion = strClean($_POST['txtDescripcion']);
            $intStatus = intval($_POST['listStatus']);
            //Valiacion para saber los el intIdRol trae datos para saber si se modifica o se crea
            if($intIdRol == 0){
                //Crear
                $request_rol = $this->model->insertRol($strRol, $strDescipcion,$intStatus);
                $option = 1;
            }else{
                //Actualizar
                $request_rol = $this->model->updateRol($intIdRol,$strRol, $strDescipcion,$intStatus);
                $option = 2;

            }
            //Fin de la validacion
            if($request_rol > 0 )
            {
                if($option == 1)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                }else{
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                }

            }else if($request_rol == 'exist')
            {
				$arrResponse = array('status' => false, 'msg' => '¡Atención! El Rol ya existe.');
            }else{
				$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
			}
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
        }
    }

    require_once "Models/rolesModel.php";

?>
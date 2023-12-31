<?php
    

    class Roles extends Controllers{

        public function __construct()
        {
            session_start();
            session_regenerate_id(true);
            if(empty($_SESSION['login'])){
                header('Location '.base_Url().'/login');
            }
            parent::__construct();
            getPermisos(2);
        }

        public function Roles()
        {
            $data['page_id'] = 3;
            $data['page_tag'] = "Roles Usuarios";
            $data['page_name'] = "roles";
            $data['page_title'] = "Roles Usuarios <small> Tienda Virtual</small>";
           //Invocar la vista home
            $this->views->getView($this,"roles",$data);
        }

        //Metodo para obtener los roles
        public function getRoles(){

            if($_SESSION['permisosMod']['r']){

                $arrData = $this->model->selectRoles();

                
                //For para recorrer el json para saber el status
                for ($i=0; $i < count($arrData); $i++) { 
                    $btnView = "";
                    $btnEdit = "";
                    $btnDelete="";

                    //IF para saber si el status es 1
                    if ($arrData[$i]['status']== 1) {
                        $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                        # code...
                    }
                    else{
                        $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                    }
                    if($_SESSION['permisosMod']['u']){
                        $btnView = '<button class="btn btn-secondary btn-sm btnPermisosRol" rl="'.$arrData[$i]['idrol'].'" title="Permisos"><i class="fas fa-key"></i></button>';

                        $btnEdit = '<button class="btn btn-primary btn-sm btnEditRol" rl="'.$arrData[$i]['idrol'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>';            
                    }
                    if($_SESSION['permisosMod']['d']){
                        $btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" rl="'.$arrData[$i]['idrol'].'" title="Eliminar"><i class="far fa-trash-alt"></i></button>';            
                    }
                    //Se le agrega al array de los datos el columna opcions 
                    $arrData[$i]['options'] ='<div class="text-center">' . $btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                }
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        }
            die();
        }

        public function getSelectRoles()
        {
            $HtmlOption = "";
            $arrData = $this->model->selectRoles();
            if(count($arrData)>0){
                for ($i=0; $i < count($arrData) ; $i++) { 
                    if($arrData[$i]['status']== 1){
                        $htmlOptions .= '<option value="'.$arrData[$i]['idrol'].'">'.$arrData[$i]['nombrerol'].'</option>';
                    }
                    
                }
            }
            echo $htmlOptions;
            die();
        }
        public function getRol(int $idrol){
            if($_SESSION['permisosMod']['r']){

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
        }
            die();

        }        
        public function setRol(){
            if($_SESSION['permisosMod']['r']){
            //se descompone el json que envia
            $intIdRol = intval($_POST['idRol']);
            $strRol =  strClean($_POST['txtNombre']);
            $strDescipcion = strClean($_POST['txtDescripcion']);
            $intStatus = intval($_POST['listStatus']);
            $request_rol = "";
            //Valiacion para saber los el intIdRol trae datos para saber si se modifica o se crea
            if($intIdRol == 0){


                if($_SESSION['permisosMod']['w']){
                       //Crear
                $option = 1;
                    $request_rol = $this->model->insertRol($strRol, $strDescipcion,$intStatus);
                }
            }else{
                if($_SESSION['permisosMod']['u']){
                    $request_rol = $this->model->updateRol($intIdRol,$strRol, $strDescipcion,$intStatus);
                $option = 2;
                }
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
        }
                die();
        }

        public function delRol(){
            if($_SESSION['permisosMod']['d'])
                {
            $intIdrol = intval($_POST['idrol']);
            $requestDelete = $this->model->deleteRol($intIdrol);
            if($requestDelete == 'ok')
            {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
            }else if($requestDelete == 'exist'){
                $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol asociado a usuarios.');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
            die();
        }
    }
    
    require_once "Models/rolesModel.php";

?>
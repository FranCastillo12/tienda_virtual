<?php

    class Login extends Controllers{

        public function __construct()
        {
            session_start();
            parent::__construct();
            
        }

        public function Login()
        {
            $data['tag_page'] = "Home";
            $data['page_title'] = "Pagina Principal";
            $data['tag_name'] = "Home";
           //Invocar la vista home
            $this->views->getView($this,"login",$data);
        }

        public function LoginUser()
        {
            if($_POST){
                
                $strEmail = $_POST["txtEmail"];
                $strPass = $_POST["txtPassword"];
                $requestUser = $this->model->LoginUser($strEmail,$strPass);

                if(empty($requestUser))
                {
                    $arrResponse = array('status' => false, 'mgs' => 'Los datos no coinciden');
                }else{
                    $arrData = $requestUser;
                    if($arrData['status'] == 1){
                        $_SESSION['idUser'] = $arrData['idpersona'];
                        $_SESSION['login'] = true;						
                        $arrResponse = array('status' => true, 'msg' => 'ok');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.');
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }
            
        }

    }

    require_once "Models/LoginModel.php";

?>
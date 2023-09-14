<?php

    class LoginModel extends mysql
    {
        public $strUsuario;
		public $strPassword;
        public function __construct()
        {
            parent::__construct();
        }




        public function LoginUser($email,$password){
            $this->strUsuario = $email;
            $this->strPassword = $password;

            $sql = "SELECT idpersona,status FROM persona WHERE 
				email_user = '$this->strUsuario' and 
				password = '$this->strPassword' and 
                status != 0 ";
			$request = $this->select($sql);
			return $request;
        }
    }
?>
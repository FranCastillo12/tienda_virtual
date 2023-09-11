<?php


    class rolesModel extends Mysql
    {
		public $intIdrol;
		public $strRol;
		public $strDescripcion;
		public $intStatus;
        public function __construct()
        {
            parent::__construct();
        }

        public function selectRoles(){
            //Extraer los daots
            $sql = "SELECT * FROM rol WHERE status != 0";
            $request = $this->select_all($sql);
			return $request;
        }

		public function selectRol(int $idRol){
            //Extraer los datos por rol
			$this->intIdrol = $idRol;
            $sql = "SELECT * FROM rol WHERE idrol = $this->intIdrol";
            $request = $this->select ($sql);
			return $request;
        }


        public function insertRol(string $rol, string $descripcion, int $status){

			$return = "";
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM rol WHERE nombrerol = '{$this->strRol}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO rol(nombrerol,descripcion,status) VALUES(?,?,?)";
	        	$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function updateRol(int $idRol,string $rol,string $descripcion, int $status ){

			$return = "";
			$this->intIdrol = $idRol;
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;
            //Extraer los datos por rol
			$sql = "SELECT * FROM rol WHERE nombrerol = '$this->strRol' AND idrol != $this->intIdrol";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE rol SET nombrerol = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdrol ";
				$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		return $request;
        }



        
    }
?>
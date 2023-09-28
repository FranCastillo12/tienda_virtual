<?php

    class Productos extends Controllers{

        public function __construct()
        {
            parent::__construct();
            session_start();
            session_regenerate_id(true);
            if(empty($_SESSION['login'])){
                header('Location '.base_Url().'/login');
            }
            getPermisos(4);
        }

        public function Productos()
        {
            if(empty($_SESSION['permisosMod']['r'])){
                header('Location '.base_Url().'/dashboard');
            }
            $data['page_tag'] = "Productos";
            $data['page_title'] = "PRODUCTOS <small>Tienda Virtual</small>";
            $data['page_name'] = "productos";
           //Invocar la vista home
            $this->views->getView($this,"productos",$data);
        }


        public function getProductos()
        {
            if($_SESSION['permisosMod']['r']){

                $arrData = $this->model->selectProductos();
                for ($i= 0; $i< count($arrData) ; $i++) { 
                    $btnView = "";
                    $btnEdit = "";
                    $btnDelete="";
        
                    if($arrData[$i]['status'] == 1)
                            {
                                $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                            }else{
                                $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                            }
        
                    //Agregar el simbolo del dollar
                    $arrData[$i]['precio'] = CURRENCY.' '.formatMoney($arrData[$i]['precio']);
                    if($_SESSION['permisosMod']['r']){
                        $btnView = '<button class="btn btn-secondary btn-sm"  onClick="fntViewInfo('.$arrData[$i]['idproducto'].')" title="Ver Producto"><i class="fas fa-eye"></i></button>';
                    }
                    if($_SESSION['permisosMod']['u']){
                            $btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditInfo('.$arrData[$i]['idproducto'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';            
                    }
                    if($_SESSION['permisosMod']['d']){
                            $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idproducto'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
        
                    }
                     //Se le agrega al array de los datos el columna opcions 
                    $arrData[$i]['options'] ='<div class="text-center">' . $btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                }
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
                }
                die();
        }
        public function setProducto(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['txtPrecio']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					
					$idProducto = intval($_POST['idProducto']);
					$strNombre = strClean($_POST['txtNombre']);
					$strDescripcion = strClean($_POST['txtDescripcion']);
					$strCodigo = strClean($_POST['txtCodigo']);
					$intCategoriaId = intval($_POST['listCategoria']);
					$strPrecio = strClean($_POST['txtPrecio']);
					$intStock = intval($_POST['txtStock']);
					$intStatus = intval($_POST['listStatus']);
					$request_producto = "";
					//Variable para guarda la ruta del producto
					$ruta = strtolower(clear_cadena($strNombre));
					$ruta = str_replace(" ","-",$ruta);

					//$ruta = strtolower(clear_cadena($strNombre));
					//$ruta = str_replace(" ","-",$ruta);

					if($idProducto == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_producto = $this->model->insertProducto($strNombre, 
																		$strDescripcion, 
																		$strCodigo, 
																		$intCategoriaId,
																		$strPrecio,
																		$intStock,
																		$ruta,
																		$intStatus);
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_producto = $this->model->updateProducto($idProducto,
																		$strNombre,
																		$strDescripcion, 
																		$strCodigo, 
																		$intCategoriaId,
																		$strPrecio, 
																		$intStock,
																		$ruta,
																		$intStatus);
						}
					}
					if($request_producto > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'idproducto' => $idProducto, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_producto == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el Código Ingresado.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
        public function getProducto($idproducto){
            //Se guarda el parametro en una variable

            if($_SESSION['permisosMod']['r']){
            $idproducto = intval($idproducto);
            if($idproducto > 0){
                $arrData = $this->model->selectProducto($idproducto);
                if(empty($arrData)){
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                }
                else{
                    $arrImg = $this->model->selectImages($idproducto);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
                                //Se le agrega un nuevo elemento al array
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
                        //Se le agrega el array arrData el elemento images que tiene el array arrImg
						$arrData['images'] = $arrImg;
						$arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            }
        die();
        }

        public function setImage()
        {
            if($_POST){
            
				//if(empty($_POST['idproducto'])){
					///$arrResponse = array('status' => false, 'msg' => 'Error de dato.');
				//}else{
					$idProducto = intval($_POST['idproducto']);
					$foto      = $_FILES['foto'];
					$imgNombre = 'pro_'.md5(date('d-m-Y H:i:s')).'.jpg';
					$request_image = $this->model->insertImage($idProducto,$imgNombre);
					if($request_image){
						$uploadImage = uploadImage($foto,$imgNombre);
						$arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error de carga.');
					}
				//}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
        }

        public function delFile(){
			if($_POST){
				if(empty($_POST['idproducto']) || empty($_POST['file'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					//Eliminar de la DB
					$idProducto = intval($_POST['idproducto']);
					$imgNombre  = strClean($_POST['file']);
					$request_image = $this->model->deleteImage($idProducto,$imgNombre);

					if($request_image){
						$deleteFile =  deleteFile($imgNombre);
						$arrResponse = array('status' => true, 'msg' => 'Archivo eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delProducto(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdproducto = intval($_POST['idProducto']);
					$requestDelete = $this->model->deleteProducto($intIdproducto);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el producto');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
        
    }
?>
<?php
    require_once("Models/TCategoria.php");
    require_once("Models/TProducto.php");
    require_once("Models/TCliente.php");
    require_once("Models/LoginModel.php");



    class Tienda extends Controllers{
        //Hacer uso de un trait
        use TCategoria,TProducto,TCliente;
        public $login;
        public function __construct()
        {
            parent::__construct();
            session_start();
            $this->login = new LoginModel();
            
        }

        public function tienda()
        {
            $data['page_tag'] = "Tienda Virtuallll";
            $data['page_title'] = "Tienda Virtual";
            $data['page_name'] = "tienda";
            $data['productos'] = $this->getProductosT();

            
           //Invocar la vista home
            $this->views->getView($this,"tienda",$data);
        }

        public function categoria($params){
            //saber  se los parametros vienen vacios
            if(empty($params)){
                //redirecciona a la pantalla principal
                header("Location:".base_Url());
            }
            else{
                //Guaedar los parametros de la url en un array
                $arrParams = explode(",",$params);
                $idcategoria = intval($arrParams[0]);
                $ruta = strClean($arrParams[1]);
                $infoCategoria = $this->getProductosCategoriaT($idcategoria,$ruta);

                $categoria = strClean($params);
                
                $data['page_tag'] = "Tienda Virtual"." | ".$infoCategoria['categoria'];
                $data['page_title'] = $infoCategoria['categoria'];
                $data['page_name'] = "categoria";
                $data['productos'] = $infoCategoria['productos'];

                
            //Invocar la vista home
                $this->views->getView($this,"categoria",$data);
            }
        }
        public function producto($params){
            //saber  se los parametros vienen vacios
            if(empty($params)){
                //redirecciona a la pantalla principal
                header("Location:".base_Url());
            }
            else{
                $arrParams = explode(",",$params);
				$idproducto = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$infoProducto = $this->getProductoT($idproducto,$ruta);
                if(empty($infoProducto)){
					header("Location:".base_url());
				}
                $data['page_tag'] = "Tienda Virtual"." | ".$infoProducto['nombre'];
                $data['page_title'] = $infoProducto['nombre'];
                $data['page_name'] = "producto";
                $data['producto'] = $infoProducto;
                $data['productos'] = $this->getProductosRandom($infoProducto['categoriaid'],8,"r"); 
            //Invocar la vista home
                $this->views->getView($this,"producto",$data);
            }
        }
        public function addCarrito(){
            if($_POST){
                $cantCarrito = 0;
                $arrCarrito = array();
                //Forma de desencriptar el id del producto
                $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
                //Saber la cantidad del producto
                $cantidad = $_POST['cant'];
                //Saber si los datos que se enviaron son numericos
                if(is_numeric($idproducto) and is_numeric($cantidad)){
                    //Obtener los datos el  producto
                    $arrInfoProducto = $this->getProductoIDT($idproducto);
                    if(!empty($arrInfoProducto)){
                        $arrProducto = array('idproducto' => $idproducto,
                        'producto' => $arrInfoProducto['nombre'],
                        'cantidad' => $cantidad,
                        'precio' => $arrInfoProducto['precio'],
                        'imagen' => $arrInfoProducto['images'][0]['url_image']
                        );
                        //isset sirve para saber si existe
                        if(isset($_SESSION['arrCarrito'])){
                            $on = true;
							$arrCarrito = $_SESSION['arrCarrito'];
							for ($pr=0; $pr < count($arrCarrito); $pr++) {
								if($arrCarrito[$pr]['idproducto'] == $idproducto){
									$arrCarrito[$pr]['cantidad'] += $cantidad;
									$on = false;
								}
							}
							if($on){
								array_push($arrCarrito,$arrProducto);
							}
							$_SESSION['arrCarrito'] = $arrCarrito;
                        }
                        else{
                            //Agregar un elemento al array del carrito para agregarlo al modal
                            //Se le esta agregando a arrCarrito lo que tiene arrProducto
                            array_push($arrCarrito,$arrProducto);
                            $_SESSION['arrCarrito'] = $arrCarrito;
                        }
                        foreach ($_SESSION['arrCarrito'] as $pro) {
							$cantCarrito += $pro['cantidad'];
						}
                        $htmlCarrito ="";
						$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
						$arrResponse = array("status" => true, 
											"msg" => '¡Se agrego al corrito!',
											"cantCarrito" => $cantCarrito,
											"htmlCarrito" => $htmlCarrito
										);
                    }

                }
                else{
                    $arrResponse = array("status"=> false,"msg"=>"Datos incorrectos");
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function delCarrito(){
			if($_POST){
				$arrCarrito = array();
				$cantCarrito = 0;
				$subtotal = 0;
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$option = $_POST['option'];
				if(is_numeric($idproducto) and ($option == 1 or $option == 2)){
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($pr=0; $pr < count($arrCarrito); $pr++) {
						if($arrCarrito[$pr]['idproducto'] == $idproducto){
                            //sirve para eliminar un elemento del array
							unset($arrCarrito[$pr]);
						}
					}
                    //sort organiza el array
					sort($arrCarrito);
					$_SESSION['arrCarrito'] = $arrCarrito;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$cantCarrito += $pro['cantidad'];
						$subtotal += $pro['cantidad'] * $pro['precio'];
					}
					$htmlCarrito = "";
					if($option == 1){
						$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
					}
					$arrResponse = array("status" => true, 
											"msg" => '¡Producto eliminado!',
											"cantCarrito" => $cantCarrito,
											"htmlCarrito" => $htmlCarrito,
											"subTotal" => SMONEY.formatMoney($subtotal),
											"total" => SMONEY.formatMoney($subtotal + 12)
										);
				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
        public function updCarrito(){
			if($_POST){
				$arrCarrito = array();
				$totalProducto = 0;
				$subtotal = 0;
				$total = 0;
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$cantidad = intval($_POST['cantidad']);
				if(is_numeric($idproducto) and $cantidad > 0){
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($p=0; $p < count($arrCarrito); $p++) { 
						if($arrCarrito[$p]['idproducto'] == $idproducto){
							$arrCarrito[$p]['cantidad'] = $cantidad;
							$totalProducto = $arrCarrito[$p]['precio'] * $cantidad;
							break;
						}
					}
					$_SESSION['arrCarrito'] = $arrCarrito;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio']; 
					}
					$arrResponse = array("status" => true, 
										"msg" => '¡Producto actualizado!',
										"totalProducto" => SMONEY.formatMoney($totalProducto),
										"subTotal" => SMONEY.formatMoney($subtotal),
										"total" => SMONEY.formatMoney($subtotal + 333)
									);

				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
        public function registro(){
			error_reporting(0);
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmailCliente']));
					$intTipoId = 30; 
					$request_user = "";
					
					$strPassword =  passGenerator();
					$strPasswordEncript = hash("SHA256",$strPassword);
					$request_user = $this->insertCliente($strNombre, 
														$strApellido, 
														$intTelefono, 
														$strEmail,
														$strPasswordEncript,
														$intTipoId );
					if($request_user > 0 )
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						$nombreUsuario = $strNombre.' '.$strApellido;
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'password' => $strPassword,
											 'asunto' => 'Bienvenido a tu tienda en línea');
						$_SESSION['idUser'] = $request_user;
						$_SESSION['login'] = true;
						$this->login->sessionLogin($request_user);
						//sendEmail($dataUsuario,'email_bienvenida');

					}else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}public function procesarVenta(){
			if($_POST){
				$idtransaccionpaypal = NULL;
				$datospaypal = NULL;
				$personaid = $_SESSION['idUser'];
				$monto = 0;
				$tipopagoid = intval($_POST['inttipopago']);
				$direccionenvio = strClean($_POST['direccion']).', '.strClean($_POST['ciudad']);
				$status = "Pendiente";
				$subtotal = 0;
				$costo_envio = COSTOENVIO;

				if(!empty($_SESSION['arrCarrito'])){
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio']; 
					}
					$monto = $subtotal + COSTOENVIO;
					//Pago contra entrega
					if(empty($_POST['datapay'])){
						//Crear pedido
						$request_pedido = $this->insertPedido($idtransaccionpaypal, 
															$datospaypal, 
															$personaid,
															$costo_envio,
															$monto, 
															$tipopagoid,
															$direccionenvio, 
															$status);
						if($request_pedido > 0 ){
							//Insertamos detalle
							foreach ($_SESSION['arrCarrito'] as $producto) {
								$productoid = $producto['idproducto'];
								$precio = $producto['precio'];
								$cantidad = $producto['cantidad'];
								$this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
							}

							$infoOrden = $this->getPedido($request_pedido);
							$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $_SESSION['userData']['email_user'], 
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden );
							sendEmail($dataEmailOrden,"email_notificacion_orden");

							$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
							$transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
							$arrResponse = array("status" => true, 
											"orden" => $orden, 
											"transaccion" =>$transaccion,
											"msg" => 'Pedido realizado'
										);
							$_SESSION['dataorden'] = $arrResponse;
							unset($_SESSION['arrCarrito']);
							session_regenerate_id(true);
						}
					}else{ //Pago con PayPal
						$jsonPaypal = $_POST['datapay'];
						$objPaypal = json_decode($jsonPaypal);
						$status = "Aprobado";
						if(is_object($objPaypal)){
							$datospaypal = $jsonPaypal;
							$idtransaccionpaypal = $objPaypal->purchase_units[0]->payments->captures[0]->id;
							if($objPaypal->status == "COMPLETED"){
								$totalPaypal = formatMoney($objPaypal->purchase_units[0]->amount->value);
								if($monto == $totalPaypal){
									$status = "Completo";
								}
								//Crear pedido
								$request_pedido = $this->insertPedido($idtransaccionpaypal, 
																	$datospaypal, 
																	$personaid,
																	$costo_envio,
																	$monto, 
																	$tipopagoid,
																	$direccionenvio, 
																	$status);
								if($request_pedido > 0 ){
									//Insertamos detalle
									foreach ($_SESSION['arrCarrito'] as $producto) {
										$productoid = $producto['idproducto'];
										$precio = $producto['precio'];
										$cantidad = $producto['cantidad'];
										$this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
									}
									$infoOrden = $this->getPedido($request_pedido);
									$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $_SESSION['userData']['email_user'], 
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden );

									sendEmail($dataEmailOrden,"email_notificacion_orden");

									$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
									$transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
									$arrResponse = array("status" => true, 
													"orden" => $orden, 
													"transaccion" =>$transaccion,
													"msg" => 'Pedido realizado'
												);
									$_SESSION['dataorden'] = $arrResponse;
									unset($_SESSION['arrCarrito']);
									session_regenerate_id(true);
								}else{
									$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
								}
							}else{
								$arrResponse = array("status" => false, "msg" => 'No es posible completar el pago con PayPal.');
							}
						}else{
							$arrResponse = array("status" => false, "msg" => 'Hubo un error en la transacción.');
						}
					}
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
				}
			}else{
				$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		public function confirmarpedido(){
			if(empty($_SESSION['dataorden'])){
				header("Location: ".base_url());
			}else{
				$dataorden = $_SESSION['dataorden'];
				$idpedido = openssl_decrypt($dataorden['orden'], METHODENCRIPT, KEY);
				$transaccion = openssl_decrypt($dataorden['transaccion'], METHODENCRIPT, KEY);
				$data['page_tag'] = "Confirmar Pedido";
				$data['page_title'] = "Confirmar Pedido";
				$data['page_name'] = "confirmarpedido";
				$data['orden'] = $idpedido;
				$data['transaccion'] = $transaccion;
				$this->views->getView($this,"confirmarpedido",$data);
			}
			unset($_SESSION['dataorden']);
		}
    }

?>
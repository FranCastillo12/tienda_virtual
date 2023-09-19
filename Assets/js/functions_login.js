//Enviar los datos por ajax


var divLoading = document.querySelector("#divLoading");

document.addEventListener("DOMContentLoaded",function(){
    if(document.querySelector("#formLogin")){
        var formLogin = document.querySelector('#formLogin');
        formLogin.onsubmit = function(e){
    
            e.preventDefault();
            //Obtener los valores que se van a enviar
            var strEmail = document.querySelector("#txtEmail").value;
            var strPassword = document.querySelector("#txtPassword").value;
    
            //Validar si los campos estan vacios
            if(strEmail == "" || strPassword == ""){
                swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
			divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Login/LoginUser';
            var formData = new FormData(formLogin);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
    
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        //Se las credenciales son correctas lo redicrecciona
                        window.location = base_url+'/dashboard';
                    }else{
                        swal.fire("Error", objData.msg , "error");
                        document.querySelector("#txtEmail").value = "";
                        document.querySelector("#txtPassword").value = "";
                    }              
                }else{
                    swal.fire("Atencion","Error en el proceso","error");
                }
				divLoading.style.display = "none";
				return false;
            }

        }
    }
    //Funcion para recuperar la contraseña
    if(document.querySelector("#formRecetPass")){		
		let formRecetPass = document.querySelector("#formRecetPass");
		formRecetPass.onsubmit = function(e) {
			e.preventDefault();
			let strEmail = document.querySelector('#txtEmailReset').value;
			if(strEmail == "")
			{
				swal("Por favor", "Escribe tu correo electrónico.", "error");
				return false;
			}else{
				divLoading.style.display = "flex";
				var request = (window.XMLHttpRequest) ? 
								new XMLHttpRequest() : 
								new ActiveXObject('Microsoft.XMLHTTP');
								
				var ajaxUrl = base_url+'/Login/resetPass'; 
				var formData = new FormData(formRecetPass);
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					if(request.readyState != 4) return;

					if(request.status == 200){
						
						var objData = JSON.parse(request.responseText);
						if(objData.status)
						{
							swal.fire({
								title: "",
								text: objData.msg,
								type: "success",
								confirmButtonText: "Aceptar",
								closeOnConfirm: false,
							}, function(isConfirm) {
								if (isConfirm) {
									window.location = base_url;
								}
							});
						}else{
							swal.fire("Atención", objData.msg, "error");
						}
					}else{
						swal.fire("Atención","Error en el proceso", "error");
					}
					divLoading.style.display = "none";
					return false;
					
				}	
			}
		}
	}
	//Saber si existe el siguiente elemento
	if(document.querySelector("#formCambiarpass")){
		//Le pasamos el formulario a la siguiente variable
		let formCambiarPass = document.querySelector("#formCambiarpass");
		//Se crea un evento al presionar un boton
		formCambiarPass.onsubmit = function(e){
			//Evita que se recargue la pagina
			e.preventDefault();

			let strPassword = document.querySelector('#txtPassword').value;
			let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
			let idUsuario = document.querySelector('#idUsuario').value;

			if(strPassword == "" || strPasswordConfirm == ""){
				swal.fire("Por favor", "Escribe la nueva contraseña." , "error");
				//Al retornar un false se hace que la proceso ya no continue
				return false;
			}else{
				
				if(strPassword.length < 5 ){
					swal.fire("Atención", "La contraseña debe tener un mínimo de 5 caracteres." , "info");
					return false;
				}
				if(strPassword != strPasswordConfirm){
					swal.fire("Atención", "Las contraseñas no son iguales." , "error");
					return false;
				}
				divLoading.style.display = "flex";
				var request = (window.XMLHttpRequest) ? 
							new XMLHttpRequest() : 
							new ActiveXObject('Microsoft.XMLHTTP');
				var ajaxUrl = base_url+'/Login/setPassword'; 
				var formData = new FormData(formCambiarPass);
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					if(request.readyState != 4) return;
					if(request.status == 200){
						var objData = JSON.parse(request.responseText);
						if(objData.status)
						{
							swal.fire({
								title: "",
								text: objData.msg,
								type: "success",
								confirmButtonText: "Iniciar sessión",
								closeOnConfirm: false,
							}, function(isConfirm) {
								if (isConfirm) {
									window.location = base_url+'/login';
								}
							});
						}else{
							swal.fire("Atención",objData.msg, "error");
						}
					}else{
						swal.fire("Atención","Error en el proceso", "error");
					}
					divLoading.style.display = "none";
				}
			}
		};
	}




},false);









// Login Page Flipbox control
$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
});

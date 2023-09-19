document.addEventListener('DOMContentLoaded',function(){

    if(document.querySelector('#formCliente')){
        var formCliente = document.querySelector('#formCliente');
        formCliente.onsubmit = function(e){
            e.preventDefault();
            //Capturar los datos
            var strIdentificacion = document.querySelector('#txtIdentificacion').value;
            var strNombre = document.querySelector('#txtNombre').value;
            var strApellido = document.querySelector('#txtApellido').value;
            var strEmail = document.querySelector('#txtEmail').value;
            var intTelefono = document.querySelector('#txtTelefono').value;
            let strNit = document.querySelector('#txtNit').value;
            let strNomFical = document.querySelector('#txtNombreFiscal').value;
            let strDirFiscal = document.querySelector('#txtDirFiscal').value;
            let strPassword = document.querySelector('#txtPassword').value;


            //Validacion para saber si los campos estan vacios
            if(strIdentificacion == '' || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' || strNit == '' || strDirFiscal == '' || strNomFical=='' )
            {
                swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
                for (let i = 0; i < elementsValid.length; i++) { 
                    if(elementsValid[i].classList.contains('is-invalid')) { 
                        swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                        return false;
                    } 
                } 
            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/clientes/setCliente ';
            var formData = new FormData(formCliente);
            request.open("POST",ajaxUrl,true);
            request.send(formData);

            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        $('#modalFormCliente').modal("hide");
                        formCliente.reset();
                        swal.fire("Usuarios", objData.msg ,"success");
                        

                        //tableUsuarios.api().ajax.reload(function(){
                        //});
                    }else{
                        swal.fire("Error", objData.msg , "error");
                    }              
                } 
                divLoading.style.display = "none";
				return false;
                }
        }
    }
},false);
//Abrir el modal
function openModall(){
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
    document.querySelector("#formCliente").reset();
    //Se debe de llamar el modal con el id que se le dio
    //Con la funcion modal.('show') nos muestra el modal
    $('#modalFormCliente').modal('show');
}
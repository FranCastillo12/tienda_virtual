var TablaCliente;
document.addEventListener('DOMContentLoaded',function(){

    TablaCliente = $('#tableClientes').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/clientes/getClientes",
            "dataSrc":""
        },
        "columns":[
            {"data":"idpersona"},
            {"data":"identificacion"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"email_user"},
            {"data":"telefono"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
        
    });

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
            var ajaxUrl ='//Controllers/Clientes.php/setCliente';
            var base_url = window.location.origin;
            alert(base_url);
            alert(ajaxUrl);
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
                        

                        ablaCliente.api().ajax.reload();
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

function fntViewInfo(idpersona){

    var idpersona = idpersona;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
    var AjaxUrl = base_url+'/Clientes/getCliente/'+idpersona;
    request.open('GET',AjaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            //Se convierte en un objeto lo que responde la solicitud
            var objData = JSON.parse(request.responseText);
            alert(objData.status);
            if(objData.status)
            {
                document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                document.querySelector("#celIde").innerHTML = objData.data.nit;
                document.querySelector("#celNomFiscal").innerHTML = objData.data.nombrefiscal;
                document.querySelector("#celDirFiscal").innerHTML = objData.data.direccionfiscal;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro; 
                $('#modalViewInfo').modal('show');
            }else{
                swal.fire("Error", objData.msg , "error");
            }
        }
    }
}
function fntEditInfo(idpersona){
    document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    var idpersona =idpersona;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
    var AjaxUrl = base_url+'/Clientes/getCliente/'+idpersona;
    request.open('GET',AjaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            //Se convierte en un objeto lo que responde la solicitud
            var objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                alert('entro');

                document.querySelector("#idUsuario").value = objData.data.idpersona;
                document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                document.querySelector("#txtNombre").value = objData.data.nombres;
                document.querySelector("#txtApellido").value = objData.data.apellidos;
                document.querySelector("#txtTelefono").value = objData.data.telefono;
                document.querySelector("#txtEmail").value = objData.data.email_user;
                document.querySelector("#txtNit").value = objData.data.nit;
                document.querySelector("#txtNombreFiscal").value =objData.data.nombrefiscal;
                document.querySelector("#txtDirFiscal").value = objData.data.direccionfiscal;
                $('#modalFormCliente').modal('show');
            }else{
                swal.fire("Error", objData.msg , "error");
            }
        }  
    }
}
function fntDelInfo(idpersona){            
    //Obtener los datos del rol que se escogio
    var idUsuario = idpersona;
    Swal.fire({
        title: "Eliminar Cliente",
        text: "¿Realmente desea eliminar el cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
    }).then((result) => {
        alert(result.isConfirmed);
        if (result.isConfirmed) {
            // Tu código AJAX y lógica para la acción confirmada
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url + '/clientes/delCliente/';
            var strData = "idUsuario=" + idUsuario;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    alert(request.responseText);
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire("Eliminar", objData.msg, "success");
                        TablaCliente.api().ajax.reload();
                    } else {
                        Swal.fire("Atención", objData.msg, "error");
                    }
                }
            }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Maneja la acción de cancelación aquí si es necesario
        }
    });            
}

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
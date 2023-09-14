var tableUsuarios;
document.addEventListener('DOMContentLoaded',function(){
    tableUsuarios = $('#tableUsuarios').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Usuarios/getUsuarios",
            "dataSrc":""
        },
        "columns":[
            {"data":"idpersona"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"email_user"},
            {"data":"telefono"},
            {"data":"nombrerol"},
            {"data":"status"},
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

    var formUsuario = document.querySelector('#formUsuario');
    formUsuario.onsubmit = function(e){
        e.preventDefault();
        //Capturar los datos
        var strIdentificacion = document.querySelector('#txtIdentificacion').value;
        var strNombre = document.querySelector('#txtNombre').value;
        var strApellido = document.querySelector('#txtApellido').value;
        var strEmail = document.querySelector('#txtEmail').value;
        var intTelefono = document.querySelector('#txtTelefono').value;
        var intTipousuario = document.querySelector('#listRolid').value;
        var strPassword = document.querySelector('#txtPassword').value;
        var intStatus = document.querySelector('#listStatus').value;
        //Validacion para saber si los campos estan vacios
        if(strIdentificacion == '' || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' || intTipousuario == '')
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

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/Usuarios/setUsuario';
        var formData = new FormData(formUsuario);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                alert(request.responseText);
                var objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalFormUser').modal("hide");
                    formUsuario.reset();
                    swal.fire("Usuarios", objData.msg ,"success");
                    tableUsuarios.api().ajax.reload(function(){
                        fntRolesUsuario();
                    });
                }else{
                    swal("Error", objData.msg , "error");
                }              
            } 
    
            }
    }
},false);



//Evento que sucede cuando se carga la pagina
window.addEventListener("load", function(){
    fntRolesUsuario();
    //fntViewUsuario();
    //fntEditUsuario();
    //fntDelUsuario();
},false);

function fntRolesUsuario(){
    var ajaxUrl = base_url+'/Roles/getSelectRoles'
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listRolid').innerHTML = request.responseText;
                 //linea para actualizar el select
                $('#listRolid').selectpicker('render');
            }
        } 
}
function fntViewUsuario(idpersona){
            var idpersona = idpersona;
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
            var AjaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
            request.open('GET',AjaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    //Se convierte en un objeto lo que responde la solicitud
                    alert(request.responseText);
                    var objData = JSON.parse(request.responseText);
                    alert(objData.status);
                    if(objData.status)
                    {
                        alert('entro');
                        document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                        document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                        document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                        document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                        document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                        document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombrerol;
                        document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
                        if(objData.status == 1){
                            $estado = '<span class="badge badge-success">Activo</span>'
                        }
                        else{
                            $estado = '<span class="badge badge-danger">Inactivo</span>'
                        }
                        document.querySelector("#celStatus").innerHTML = $estado;
                        $('#modalViewUser').modal('show');
                    }else{
                        swal.fire("Error", objData.msg , "error");
                    }
                }
            }
}



function fntEditUsuario(idpersona){
            document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
            document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
            document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
            document.querySelector('#btnText').innerHTML ="Actualizar";
            var idpersona =idpersona;
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
            var AjaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
            request.open('GET',AjaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    //Se convierte en un objeto lo que responde la solicitud
                    alert(request.responseText);
                    var objData = JSON.parse(request.responseText);
                    alert(objData.status);
                    if(objData.status)
                    {
                        alert('entro');

                        document.querySelector("#idUsuario").value = objData.data.idpersona;
                        document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                        document.querySelector("#txtNombre").value = objData.data.nombres;
                        document.querySelector("#txtApellido").value = objData.data.apellidos;
                        document.querySelector("#txtTelefono").value = objData.data.telefono;
                        document.querySelector("#txtEmail").value = objData.data.email_user;
                        document.querySelector("#listRolid").value = objData.data.idrol;
                        $('#listRolid').selectpicker('render');

                        if(objData.status == 1){
                            document.querySelector("#listStatus").value = 1;
                        }
                        else{
                            document.querySelector("#listStatus").value =22;
                        }

                        $('#listStatus').selectpicker('render');

                        $('#modalFormUser').modal('show');
                    }else{
                        swal.fire("Error", objData.msg , "error");
                    }
                }
            }
}

function fntDelUsuario(idpersona){            
            //Obtener los datos del rol que se escogio
            var idUsuario = idpersona;
            Swal.fire({
                title: "Eliminar Usuario",
                text: "¿Realmente desea eliminar el usuario?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "No, cancelar",
            }).then((result) => {
                alert(result.isConfirmed);
                if (result.isConfirmed) {
                    // Tu código AJAX y lógica para la acción confirmada
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxUrl = base_url + '/Usuarios/delUsuario/';
                    var strData = "idUsuario=" + idUsuario;
                    request.open("POST", ajaxUrl, true);
                    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function () {
                        if (request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                Swal.fire("Eliminar", objData.msg, "success");
                                tableUsuarios.api().ajax.reload();
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


//Funciones para abrir el modal de agregar un nuevo usuario
function openModall(){
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuarios";
    document.querySelector("#formUsuario").reset();
    //Se debe de llamar el modal con el id que se le dio
    //Con la funcion modal.('show') nos muestra el modal
    $('#modalFormUser').modal('show');
}



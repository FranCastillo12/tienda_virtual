
document.addEventListener('DOMContentLoaded',function(){
    alert('dddd');
    var formUsuario = document.querySelector('#formUsuario');
    formUsuario.onsubmit = function(e){
        e.preventDefault();
        //Capturar los datos
        alert('dddd');
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

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = baese_url+'/Usuarios/setUsuario';
        var formData = new FormData(formUsuario);
        request.open("POST",ajaxUrl,true);
        Request.send(FormData);

        request.onreadystatechange = function(){
            
            
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalFormUser').modal("hide");
                    formRol.reset();
                    swal.fire("Usuarios", objData.msg ,"success");
                    tableRoles.api().ajax.reload(function(){
                    });
                }else{
                    swal("Error", objData.msg , "error");
                }              
            } 
    
            }



    }
}.false);



//Evento que sucede cuando se carga la pagina
window.addEventListener("load", function(){
    fntRolesUsuario();
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

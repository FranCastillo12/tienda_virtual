var tableRoles;

document.addEventListener('DOMContentLoaded', function(){

	tableRoles = $('#tableRoles').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Roles/getRoles",
            "dataSrc":""
        },
        "columns":[
            {"data":"idrol"},
            {"data":"nombrerol"},
            {"data":"descripcion"},
            {"data":"status"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });
    //Script para capturar los datos del formulario
    // '#formRol' por ser un id se coloca un #, se una clase se coloca un .
    var formRol = document.querySelector('#formRol');
    formRol.onsubmit = function(e){
        //Evitar que la pagina de recargue
        e.preventDefault();
        //capturar las variables de formulario
        var strNombre = document.querySelector('#txtNombre').value;
        var strDescripcion = document.querySelector('#txtDescripcion').value;
        var intStatus = document.querySelector('#listStatus').value;   
        //Validaciones para saber si los campos que se enviaron viene en blanco
        if(strNombre == '' || strDescripcion == '' || intStatus == '')
        {
            swal.fire("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/Roles/setRol';

        //Obtener los datos del formulario
        var formData = new FormData(formRol);
        //Metodo por el cual va a ser enviada la informacion
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            
            
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                $('#modalFormRol').modal("hide");
                formRol.reset();
                swal.fire("Roles de usuario", objData.msg ,"success");
                tableRoles.api().ajax.reload();
            }else{
                swal("Error", objData.msg , "error");
            }              
        } 

        }
    }
});


    
//Funciones para abrir el modal de agregar un nuevo rol
function openModal(){
    document.querySelector('#idRol').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
    document.querySelector("#formRol").reset();
    //Se debe de llamar el modal con el id que se le dio
    //Con la funcion modal.('show') nos muestra el modal
    $('#modalFormRol').modal('show');
}


window.addEventListener('load', function() {
    fntEditRol();
}, false);

$(document).ready(function () {
    alert("sds");
    fntEditRol();
});


//Funcion para los botones de editar que abrir el modal
function fntEditRol(){
    var btnEditRol = document.querySelectorAll(".btnEditRol");
    btnEditRol.forEach(function(btnEditRol){
        btnEditRol.addEventListener('click',function(){
            alert("sdsd");
            document.querySelector('#titleModal').innerHTML ="Actualizar Rol";
            document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
            document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
            document.querySelector('#btnText').innerHTML ="Actualizar";

            //Obtener los datos del rol que se escogio
            var idrol = this.getAttribute("rl");
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Roles/getRol/'+idrol;
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                alert(request.status);
                if(request.readyState == 4 && request.status == 200){
                    //Se convierte en un objeto lo que responde la solicitud
                    alert(request.responseText);
                    var objData = JSON.parse(request.responseText);
                    alert(objData.status);
                    if(objData.status)
                    {
                        alert("status 200");
                        document.querySelector("#idRol").value = objData.data.idrol;
                        document.querySelector("#txtNombre").value = objData.data.nombrerol;
                        document.querySelector("#txtDescripcion").value = objData.data.descripcion;

                        if(objData.data.status == 1)
                        {
                            var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                        }else{
                            var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                        }
                        var htmlSelect = `${optionSelect}
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                        `;
                        document.querySelector("#listStatus").innerHTML = htmlSelect;
                        $('#modalFormRol').modal('show');
                    }else{
                        swal.fire("Error", objData.msg , "error");
                    }
                }
            }
        });
    });
}






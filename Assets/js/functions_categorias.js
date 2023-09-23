
var TablaCategorias;
document.addEventListener('DOMContentLoaded',function(){
	TablaCategorias = $('#tableCategorias').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/categorias/getCategorias",
            "dataSrc":""
        },
        "columns":[
            {"data":"idcategoria"},
            {"data":"nombre"},
            {"data":"descripcion"},
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
    if(document.querySelector("#foto")){
	    let foto = document.querySelector("#foto");
	    foto.onchange = function(e) {
	        let uploadFoto = document.querySelector("#foto").value;
	        let fileimg = document.querySelector("#foto").files;
	        let nav = window.URL || window.webkitURL;
	        let contactAlert = document.querySelector('#form_alert');
	        if(uploadFoto !=''){
	            let type = fileimg[0].type;
	            let name = fileimg[0].name;
	            if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
	                contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
	                if(document.querySelector('#img')){
	                    document.querySelector('#img').remove();
	                }
	                document.querySelector('.delPhoto').classList.add("notBlock");
	                foto.value="";
	                return false;
	            }else{  
	                    contactAlert.innerHTML='';
	                    if(document.querySelector('#img')){
	                        document.querySelector('#img').remove();
	                    }
	                    document.querySelector('.delPhoto').classList.remove("notBlock");
	                    let objeto_url = nav.createObjectURL(this.files[0]);
	                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">";
	                }
	        }else{
	            alert("No selecciono foto");
	            if(document.querySelector('#img')){
	                document.querySelector('#img').remove();
	            }
	        }
	    }
	}

	if(document.querySelector(".delPhoto")){
	    let delPhoto = document.querySelector(".delPhoto");
	    delPhoto.onclick = function(e) {
            document.querySelector("#foto_remove").value= 1;
	        removePhoto();
	    }
	}

		//NUEVA CATEGORIA
		let formCategoria = document.querySelector("#formCategoria");
		formCategoria.onsubmit = function(e) {
			e.preventDefault();
			let strNombre = document.querySelector('#txtNombre').value;
			let strDescripcion = document.querySelector('#txtDescripcion').value;
			let intStatus = document.querySelector('#listStatus').value;        
			if(strNombre == '' || strDescripcion == '' || intStatus == '')
			{
				swal("Atención", "Todos los campos son obligatorios." , "error");
				return false;
			}
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Categorias/setCategoria'; 
			let formData = new FormData(formCategoria);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{	
						$('#modalFormCategorias').modal("hide");
						formCategoria.reset();
						swal.fire("Categoria", objData.msg ,"success");
						removePhoto();
                        TablaCategorias.api().ajax.reload();
					}else{
						swal.fire("Error", objData.msg , "error");
					}              
				} 
				divLoading.style.display = "none";
				return false;
			}
		}

	
},false);
function fntViewInfo(idCategoria){
	
    var idCategoria = idCategoria;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
    var AjaxUrl = base_url+'/Categorias/getCategoria/'+idCategoria;
    request.open('GET',AjaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            //Se convierte en un objeto lo que responde la solicitud
		
            var objData = JSON.parse(request.responseText);
            
            if(objData.status)
            {
				let estado = objData.data.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';
                document.querySelector("#celId").innerHTML = objData.data.idcategoria;
                document.querySelector("#celNombre").innerHTML = objData.data.nombre;
                document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
                document.querySelector("#celEstado").innerHTML = estado;
                document.querySelector("#imgCategoria").innerHTML = '<img src="'+objData.data.url_portada+'"></img>';
                $('#modalViewInfo').modal('show');
            }else{
                swal.fire("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(idcategoria){
    document.querySelector('#titleModal').innerHTML ="Actualizar Categoría";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Categorias/getCategoria/'+idcategoria;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idCategoria").value = objData.data.idcategoria;
                document.querySelector("#txtNombre").value = objData.data.nombre;
                document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                document.querySelector('#foto_actual').value = objData.data.Portada;
                document.querySelector("#foto_remove").value= 0;

                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');
				if(document.querySelector('#img')){
                    document.querySelector('#img').src = objData.data.url_portada;
                }else{
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objData.data.url_portada+">";
                }
				if(objData.data.portada == 'portada_categoria.png'){
                    document.querySelector('.delPhoto').classList.add("notBlock");
                }else{
                    document.querySelector('.delPhoto').classList.remove("notBlock");
                }
                $('#modalFormCategorias').modal('show');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntDelInfo(idcategoria){            
    alert('ddd');
    //Obtener los datos del rol que se escogio
    var idcategoria = idcategoria;
    Swal.fire({
        title: "Eliminar Categoria",
        text: "¿Realmente desea eliminar la categoria?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
    }).then((result) => {
        alert(result.isConfirmed);
        if (result.isConfirmed) {
            alert('ssss');
            // Tu código AJAX y lógica para la acción confirmada
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url + '/Categorias/delCategoria';
            var strData = "idcategoria=" + idcategoria;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    alert(request.responseText);
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire("Eliminar", objData.msg, "success");
                        TablaCategorias.api().ajax.reload();
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

function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if(document.querySelector('#img')){
        document.querySelector('#img').remove();
    }
}

function openModal(){
    document.querySelector('#idCategoria').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoría";
    document.querySelector("#formCategoria").reset();
    $('#modalFormCategorias').modal('show');
	removePhoto(); 
}
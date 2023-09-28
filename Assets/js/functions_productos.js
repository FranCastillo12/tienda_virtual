var TablaProductos;
document.addEventListener('DOMContentLoaded',function(){
	TablaProductos = $('#tableProductos').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/productos/getProductos",
            "dataSrc":""
        },
        "columns":[
            {"data":"idproducto"},
            {"data":"codigo"},
            {"data":"nombre"},
            {"data":"stock"},
            {"data":"precio"},
            {"data":"status"},
            {"data":"options"}
        ],
        "columnDefs": [
            { 'className': "textcenter", "targets": [ 3 ] },
            { 'className': "textright", "targets": [ 4 ] },
            { 'className': "textcenter", "targets": [ 5 ] }
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

    if(document.querySelector("#formProductos")){
        let formProductos = document.querySelector("#formProductos");
        formProductos.onsubmit = function(e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombre').value;
            let intCodigo = document.querySelector('#txtCodigo').value;
            let strPrecio = document.querySelector('#txtPrecio').value;
            let intStock = document.querySelector('#txtStock').value;
            let intStatus = document.querySelector('#listStatus').value;
            if(strNombre == '' || intCodigo == '' || strPrecio == '' || intStock == '' )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            if(intCodigo.length < 5){
                swal("Atención", "El código debe ser mayor que 5 dígitos." , "error");
                return false;
            }
            divLoading.style.display = "flex";
            //tinyMCE.triggerSave();
            let request = (window.XMLHttpRequest) ? 
                            new XMLHttpRequest() : 
                            new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Productos/setProducto'; 
            let formData = new FormData(formProductos);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal.fire("", objData.msg ,"success");
                        document.querySelector("#idProducto").value = objData.idproducto;
                        document.querySelector("#containerGallery").classList.remove("notblock");
                        TablaProductos.api().ajax.reload();
                    }else{
                        swal.fire("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

    //SABER SI EL BOTON PARA AGREGAR IMAGENES EXISTE
    //FUNCIONALIDAD PARA AGREGAR IMAGENES
    if(document.querySelector(".btnAddImage")){
        let btnAddImage =  document.querySelector(".btnAddImage");
        btnAddImage.onclick = function(e){
        let key = Date.now();
        let newElement = document.createElement("div");
        newElement.id= "div"+key;
        newElement.innerHTML = `
            <div class="prevImage"></div>
            <input type="file" name="foto" id="img${key}" class="inputUploadfile">
            <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload "></i></label>
            <button class="btnDeleteImage notblock" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
        document.querySelector("#containerImages").appendChild(newElement);
        document.querySelector("#div"+key+" .btnUploadfile").click();
        fntInputFile();
    
        }
    }

	fntInputFile();
    fntCategorias();
},false);

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});

function fntDelItem(element){
    let nameImg = document.querySelector(element+' .btnDeleteImage').getAttribute("imgname");
    let idProducto = document.querySelector("#idProducto").value;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/delFile'; 

    let formData = new FormData();
    formData.append('idproducto',idProducto);
    formData.append("file",nameImg);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState != 4) return;
        if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let itemRemove = document.querySelector(element);
                itemRemove.parentNode.removeChild(itemRemove);
            }else{
                swal("", objData.msg , "error");
            }
        }
    }

}

function fntViewInfo(idProducto){
    let request = (window.XMLHttpRequest) ? 
    new XMLHttpRequest() : 
    new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
        let objData = JSON.parse(request.responseText);
        if(objData.status)
        {
        let htmlImage = "";
        let objProducto = objData.data;
        let estadoProducto = objProducto.status == 1 ? 
        '<span class="badge badge-success">Activo</span>' : 
        '<span class="badge badge-danger">Inactivo</span>';

        document.querySelector("#celCodigo").innerHTML = objProducto.codigo;
        document.querySelector("#celNombre").innerHTML = objProducto.nombre;
        document.querySelector("#celPrecio").innerHTML = objProducto.precio;
        document.querySelector("#celStock").innerHTML = objProducto.stock;
        document.querySelector("#celCategoria").innerHTML = objProducto.categoria;
        document.querySelector("#celStatus").innerHTML = estadoProducto;
        document.querySelector("#celDescripcion").innerHTML = objProducto.descripcion;

        if(objProducto.images.length > 0){
            let objProductos = objProducto.images;
            for (let p = 0; p < objProductos.length; p++) {
                htmlImage +=`<img src="${objProductos[p].url_image}"></img>`;
            }
        }
        document.querySelector("#celFotos").innerHTML = htmlImage;
        $('#modalViewInfo').modal('show');

        }else{
        swal("Error", objData.msg , "error");
        }
        }
        }
}

function fntEditInfo(idProducto){
    document.querySelector('#titleModal').innerHTML ="Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? 
    new XMLHttpRequest() : 
    new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
        let objData = JSON.parse(request.responseText);
        if(objData.status)
        {
        let htmlImage = "";
        let objProducto = objData.data;
        
        document.querySelector("#idProducto").value = objProducto.idproducto;
        document.querySelector("#txtNombre").value = objProducto.nombre;
        document.querySelector("#txtDescripcion").value = objProducto.descripcion;
        document.querySelector("#txtCodigo").value = objProducto.codigo;
        document.querySelector("#txtPrecio").value = objProducto.precio;
        document.querySelector("#txtStock").value = objProducto.stock;
        document.querySelector("#listCategoria").value = objProducto.categoriaid;
        document.querySelector("#listStatus").value = objProducto.status;
        

        $('#listCategoria').selectpicker('render');
        $('#listStatus').selectpicker('render');

        fntBarcode();

        if(objProducto.images.length > 0){
            let objProductos = objProducto.images;
            for (let p = 0; p < objProductos.length; p++) {
                let key = Date.now()+p;
                htmlImage +=`<div id="div${key}">
                    <div class="prevImage">
                    <img src="${objProductos[p].url_image}"></img>
                    </div>
                    <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objProductos[p].img}">
                    <i class="fas fa-trash-alt"></i></button></div>`;
            }
        }

        document.querySelector("#containerImages").innerHTML = htmlImage; 
        document.querySelector("#divBarCode").classList.remove("notblock");
        document.querySelector("#containerGallery").classList.remove("notblock");           
        $('#modalFormProductos').modal('show');

        }else{
            swal("Error", objData.msg , "error");
        }
        }
        }

}
function fntDelInfo(idProducto){
    //Obtener los datos del rol que se escogio
    var idProducto = idProducto;
    Swal.fire({
        title: "Eliminar Producto",
        text: "¿Realmente desea eliminar el producto?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
    }).then((result) => {
        alert(result.isConfirmed);
        if (result.isConfirmed) {
            // Tu código AJAX y lógica para la acción confirmada
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url + '/Productos/delProducto';
            var strData = "idProducto=" + idProducto;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    alert(request.responseText);
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire("Eliminar", objData.msg, "success");
                        TablaProductos.api().ajax.reload();
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
function fntCategorias(){
    if(document.querySelector('#listCategoria')){
        let ajaxUrl = base_url + '/Categorias/getSelectCategorias';
        let request = (window.XMLHttpRequest) ? 
        new XMLHttpRequest() : 
        new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listCategoria').innerHTML = request.responseText;
            $('#listCategoria').selectpicker('render');
}
}
    }
}

function fntInputFile(){
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");
    inputUploadfile.forEach(function(inputUploadfile) {
        inputUploadfile.addEventListener('change', function(){
            let idProducto = document.querySelector("#idProducto").value;
            let parentId = this.parentNode.getAttribute("id");
            let idFile = this.getAttribute("id");            
            let uploadFoto = document.querySelector("#"+idFile).value;
            let fileimg = document.querySelector("#"+idFile).files;
            let prevImg = document.querySelector("#"+parentId+" .prevImage");
            let nav = window.URL || window.webkitURL;
            if(uploadFoto !=''){
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    prevImg.innerHTML = "Archivo no válido";
                    uploadFoto.value = "";
                    return false;
                }else{
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg" >`;

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+'/Productos/setImage'; 
                    let formData = new FormData();
                    formData.append('idproducto',idProducto);
                    formData.append("foto", this.files[0]);
                    request.open("POST",ajaxUrl,true);
                    alert(formData);
                    request.send(formData);
                    request.onreadystatechange = function(){
                        if(request.readyState != 4) return;
                        if(request.status == 200){
                            let objData = JSON.parse(request.responseText);
                            if(objData.status){
                                prevImg.innerHTML = `<img src="${objeto_url}">`;
                                document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
                                document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notblock");
                                document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notblock");
                            }else{
                                swal.fire("Error", objData.msg , "error");
                            }
                        }
                    }

                }
            }

        });
    });
}

function fntBarcode(){
    let codigo = document.querySelector("#txtCodigo").value;
    JsBarcode("#barcode", codigo);
}
if(document.querySelector("#txtCodigo")){
    let inputCodigo = document.querySelector("#txtCodigo");
    inputCodigo.onkeyup = function() {
        if(inputCodigo.value.length >= 5){
            document.querySelector('#divBarCode').classList.remove("notblock");
            fntBarcode();
       }else{
            document.querySelector('#divBarCode').classList.add("notblock");
       }
    };
}

function fntPrintBarcode(area){
    let elemntArea = document.querySelector(area);
    let vprint = window.open(' ', 'popimpr', 'height=400,width=600');
    vprint.document.write(elemntArea.innerHTML );
    vprint.document.close();
    vprint.print();
    vprint.close();
}
function openModal(){
    document.querySelector('#idProducto').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#formProductos").reset();
    document.querySelector("#divBarCode").classList.add("notblock");
    document.querySelector("#containerGallery").classList.add("notblock");
    document.querySelector("#containerImages").innerHTML = "";
    $('#modalFormProductos').modal('show'); 
}
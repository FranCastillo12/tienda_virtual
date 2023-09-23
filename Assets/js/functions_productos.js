


$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});


window.addEventListener('load',function(){
    fntCategorias();
});


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
    document.querySelector("#formProducto").reset();
    $('#modalFormProductos').modal('show'); 
}
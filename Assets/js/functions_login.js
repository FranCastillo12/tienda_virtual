//Enviar los datos por ajax

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
                        swal.fire("Usuarios", objData.msg ,"success");
                    }else{
                        swal.fire("Error", objData.msg , "error");
                    }              
                }
            }

        }
    }
},false);


// Login Page Flipbox control
$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;





    
});

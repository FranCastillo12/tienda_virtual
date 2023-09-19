<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <!-- Uso de sweetAlert-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login - Vali Admin</title>
</head>

<body>
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
        <div class="logo">
            <h1>Tienda Virtual</h1>
        </div>
        <div class="login-box flipped">
        <div class="divLoading">   
                <div>   
                    <img src="<?= media();?>/images/loading.svg" alt="Loading">
                </div>
            </div>
            <form  id="formCambiarpass" name="formCambiarpass" class="forget-form" action="">
            <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idpersona']; ?>" required >
            <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>" required >
            <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>" required >
            
                <h3 class="login-head"><i class="fas fa-key"></i>Cambiar contraseña</h3>
                <div class="form-group">
                    <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="password" required>
                </div>
                <div class="form-group">
                    <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar Contraseña" required>
                </div>
                <div class="form-group btn-container">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>Reiniciar</button>
                </div>
            </form>
        </div>
    </section>
    <script>
        const base_url = "<?= base_Url();?>"
    </script>
    <script src="https://kit.fontawesome.com/51074424af.js" crossorigin="anonymous"></script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>

    <script src="<?= media();?>/js/functions_login.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
</body>

</html>
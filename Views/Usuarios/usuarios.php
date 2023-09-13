<?php  
//Se llama el header
headerAdmin($data);
require_once "Views/Template/Modals/modalUsuarios.php";
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>

                <button class="btn btn-primary" type="button" onclick="openModall();"><i
                        class="fa fa-plus-circle"></i>Nuevo</button>

            </h1>
            
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_Url()?>/Usuarios"><?php echo $data['page_title'] ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableUsuarios">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Rol</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
    //Se llama el footer
    footerAdmin($data);
    //getModal("modalRoles",$data); require_once "../../Assets/js/functions_usuarios.js";
    ?>
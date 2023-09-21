<?php  
//Se llama el header 
headerAdmin($data); ?>
<main class="app-content">
<?php
    require_once "Views/Template/Modals/modalClientes.php";
    if(empty($_SESSION['permisosMod']['r'])){
?>
    <p>Accesso Restringido</p>
<?php
    }else{

    
?>

    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>
                <?php if($_SESSION['permisosMod']['w']){ ?>
                <button class="btn btn-primary" type="button" onclick="openModall();"><i
                        class="fa fa-plus-circle"></i>Nuevo</button>
                <?php }
                ?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_Url()?>/clientes"><?php echo $data['page_title'] ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableClientes">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Identificacion</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
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
    <?php
    }   
    ?>
</main>

<?php
    //Se llama el footer
    footerAdmin($data);
    //getModal("modalRoles",$data); require_once "../../Assets/js/functions_usuarios.js";
    ?>
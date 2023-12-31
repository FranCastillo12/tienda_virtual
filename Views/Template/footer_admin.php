<script>
const base_url = "<?= base_Url();?>"
</script>


<!-- Essential javascripts for application to work-->
<script src="<?= media();?>/js/jquery-3.3.1.min.js"></script>

<script src="<?= media();?>/js/popper.min.js"></script>
<script src="<?= media();?>/js/bootstrap.min.js"></script>
<script src="<?= media();?>/js/main.js"></script>
<script src="<?= media();?>/js/functions_admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<?php if($data['page_name']=='roles'){
    ?>
<script src="<?= media();?>/js/functions_roles.js"></script>
<?php
    }?>

<?php if($data['page_name']=='usuarios' || ($data['page_name']=='pefil')){
    ?>
<script src="<?= media();?>/js/functions_usuarios.js"></script>
<?php
    }?>

<?php if($data['page_name']=='clientes'){
    ?>
<script src="<?= media();?>/js/functions_clientes.js"></script>
<?php
    }?>

<?php if($data['page_name']=='categorias'){
    ?>
<script src="<?= media();?>/js/functions_categorias.js"></script>
<?php
    }?>

<?php if($data['page_name']=='productos'){
    ?>
<script src="<?= media();?>/js/functions_productos.js"></script>
<?php
    }?>

<?php if($data['page_name']=='pedidos'){
    ?>
<script src="<?= media();?>/js/functions_pedidos.js"></script>
<?php
    }?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!-- Data table plugin-->
<script type="text/javascript" src="<?= media();?>/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= media();?>/js/plugins/dataTables.bootstrap.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


<script src="https://kit.fontawesome.com/51074424af.js" crossorigin="anonymous"></script>

<script type="text/javascript" src="<?= media(); ?>/js/tinymce/tinymce.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

    <script src="<?= media();?>/js/datepicker/jquery-ui.min.js"></script>
</body>

</html>
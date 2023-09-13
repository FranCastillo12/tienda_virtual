<script>
    const base_url = "<?= base_Url();?>"
</script>


<!-- Essential javascripts for application to work-->
    <script src="<?= media();?>/js/jquery-3.3.1.min.js"></script>

    <script src="<?= media();?>/js/popper.min.js"></script>
    <script src="<?= media();?>/js/bootstrap.min.js"></script>
    <script src="<?= media();?>/js/main.js"></script>
    <script src="<?= media();?>/js/functions_admin.js"></script>

    <?php if($data['page_name']=='roles'){
    ?>
    <script src="<?= media();?>/js/functions_roles.js"></script>
    <?php
    }?>

    <?php if($data['page_name']=='usuarios'){
    ?>
    <script src="<?= media();?>/js/functions_usuarios.js"></script>
    <?php
    }?>
    



    </body>

    </html>



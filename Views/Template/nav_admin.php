<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://img2.freepng.es/20180331/khw/kisspng-computer-icons-user-clip-art-user-5abf13d4b67e20.4808850915224718927475.jpg" style="width:35px"
            alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombres']?></p>
            <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombrerol']?></p>
        </div>
    </div>
    <ul class="app-menu">
        <?php if(! empty($_SESSION["permisos"][1]['r'])){?>


        <li> <a class="app-menu__item" href="<?= base_url(); ?>/dashboard"> <i
                    class="app-menu__icon fa fa-dashboard"></i> <span class="app-menu__label">Dashboard</span> </a>
        </li>
        <?php
        }
                
                ?> 
                <?php if(! empty($_SESSION["permisos"][2]['r'])){?>
        <li class="treeview"> <a class="app-menu__item" href="#" data-toggle="treeview"> <i
                    class="app-menu__icon fa fa-users" aria-hidden="true"></i> <span
                    class="app-menu__label">Usuarios</span> <i class="treeview-indicator fa fa-angle-right"></i> </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?= base_url(); ?>/usuarios"><i class="icon fa fa-circle-o"></i>
                        Usuarios</a></li>
                <li><a class="treeview-item" href="<?= base_url(); ?>/roles"><i class="icon fa fa-circle-o"></i>
                        Roles</a></li>
            </ul>
        </li>
        <?php
        }
        ?> 
                <?php if(! empty($_SESSION["permisos"][3]['r'])){?>
        <li> <a class="app-menu__item" href="<?= base_url(); ?>/clientes"> <i class="app-menu__icon fa fa-user"
                    aria-hidden="true"></i> <span class="app-menu__label">Clientes</span> </a> </li>

        <?php
        }
        ?> 
        <?php if(! empty($_SESSION["permisos"][4]['r']) || ! empty($_SESSION["permisos"][4]['r'])){?>

            <li class="treeview"> 
                <a class="app-menu__item" href="#" data-toggle="treeview"> 
                    <i class="app-menu__icon fa fa-archive" aria-hidden="true"></i> 
                    <span class="app-menu__label">Tienda</span> 
                    <i class="treeview-indicator fa fa-angle-right"></i> 
                </a>
            <ul class="treeview-menu">
            <?php if(! empty($_SESSION["permisos"][4]['r'])){?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/produtos"><i class="icon fa fa-circle-o"></i>
                        Prucductos</a></li>

                        <?php
        }
        ?>
        <?php if(!empty($_SESSION["permisos"][4]['r'])){?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/categorias"><i class="icon fa fa-circle-o"></i>
                        Categorias</a></li>
                        <?php
        }
        ?>
            </ul>
        </li>
                    <?php
        }
        ?>

        <?php if(! empty($_SESSION["permisos"][5]['r'])){?>
        <li> <a class="app-menu__item" href="<?= base_url(); ?>/logout"> <i class="app-menu__icon fa fa-sign-out"
                    aria-hidden="true"></i> <span class="app-menu__label">Logout</span> </a> </li>
        <?php
        }
        ?>

    </ul>
</aside>
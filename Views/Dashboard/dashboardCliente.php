<?php  
//Se llama el header
headerAdmin($data);?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i><?php echo $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Blank Page</a></li>
        </ul>
    </div>
    <div class="row">
        <?php if(!empty($_SESSION['permisos'][2]['r'])){?>
        <div class="col-md-6 col-lg-3">
            <a href="<?= base_Url()?>/usuarios" class="linkw">
                <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4>Usuarios</h4>
                        <p><b><?= $data['usuarios']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php
        }
        ?>
        <?php if(!empty($_SESSION['permisos'][3]['r'])){?>
        <div class="col-md-6 col-lg-3">
            <a href="<?= base_Url()?>/clientes" class="linkw">
                <div class="widget-small info coloured-icon"><i class="icon fa fa-user fa-3x" aria-hidden="true"></i>
                    <div class="info">
                        <h4>Clientes</h4>
                        <p><b><?= $data['clientes']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php
        }
        ?>
        <?php if(!empty($_SESSION['permisos'][4]['r'])){?>
        <div class="col-md-6 col-lg-3">
            <a href="<?= base_Url()?>/productos" class="linkw">
                <div class="widget-small warning coloured-icon"><i class="icon fa fa-archive fa-3x"></i>
                    <div class="info">
                        <h4>Productos</h4>
                        <p><b><?= $data['productos']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php
        }
        ?>
        <?php if(!empty($_SESSION['permisos'][5]['r'])){?>
        <div class="col-md-6 col-lg-3">
            <a href="<?= base_Url()?>/pedidos" class="linkw">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-cart fa-3x"></i>
                    <div class="info">
                        <h4>Pedidos</h4>
                        <p><b><?= $data['pedidos']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php
        }
        ?>
    </div>
    <div class="row">
        <?php if(!empty($_SESSION['permisos'][5]['r'])){?>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Utimos Pedidos</h3>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th class="text-right">Monto</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($data['lastOrders'])){
                                foreach ($data['lastOrders'] as $pedido) {
                            
                        ?>
                        <tr>
                            <td><?= $pedido['idpedido']?></td>
                            <td><?= $pedido['nombre']?></td>
                            <td><?= $pedido['status']?></td>
                            <td class="text-right"><?=SMONEY." ".formatMoney($pedido['monto'])?></td>
                            <td><a href="<?= base_Url()?>/pedidos/orden/<?= $pedido['idpedido']?>" target="blank="><i
                                        class="fa fa-eye" aria-hidden="true"></i></a></td>
                        </tr>
                        <?php
                            }   
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        }
        ?>

        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Utimos Productos</h3>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Monto</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($data['productosTen'])){
                                foreach ($data['productosTen'] as $producto) {
                            
                        ?>
                        <tr>
                            <td><?= $producto['idproducto']?></td>
                            <td><?= $producto['nombre']?></td>
                            <td><?= SMONEY. formatMoney($producto['precio'])?></td>
                            <td><a href="<?= base_Url()?>/tienda/producto/<?= $producto['idproducto'].'/'.$producto['ruta']?>" target="blank="><i
                                        class="fa fa-eye" aria-hidden="true"></i></a></td>
                        </tr>
                        <?php
                            }   
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Ventas por mes</h3>
                <div class="dflex">
                    <input class="date-picker ventasMes" name="ventasMes" placeholder="Mes y Año">
                    <button type="button" class="btnVentasMes btn btn-info btn-sm"><i
                            class="fas fa-search"></i></button>
                </div>
                <div id="divpVentasMes">

                </div>
            </div>

        </div> 
    </div>
</main>

<?php
    //Se llama el footer
    footerAdmin($data);?>



<script>
Highcharts.chart('divpVentasMes', {

    title: {
        text: 'Ventas de <?= $data['ventasMDia']['mes'].' '.$data['ventasMDia']['anio ']?>',
        align: 'left'
    },

    subtitle: {
        text: 'Total Ventas <?= SMONEY.'. '.formatMoney($data['ventasMDia']['total']) ?> '
        align: 'left'
    },

    yAxis: {
        title: {
            text: 'Number of Employees'
        }
    },

    xAxis: {
        accessibility: {
            rangeDescription: ''
        }
    },

    legend: {
        layout: '',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 2010
        }
    },

    series: [{
        name: '',
        data: [
            <?php 
                foreach ($data['ventasMDia']['ventas'] as $dia) {
                  echo $dia['total'].",";
                }
            ?>
        ]
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
</script>


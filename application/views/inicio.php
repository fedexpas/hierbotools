<h2>Inicio</h2>
<div class="row">
    <div class="col-md-12">
        <h3><span class="label label-warning">Últimos eventos</span></h3>
        <table class="table table-striped">
        <thead>
          <tr>
            <th><b>Producto</b></th>
            <th><b>Acción</b></th>
            <th><b>Fecha</b></th>
        </tr>
        </thead>
        <tbody>
        <?php $id = 0; ?>
        <?php foreach($nombres as $registro_id => $nombre) { ?>
         <tr>
            <td><?php echo $nombre; ?></td>
            <td><?php echo $acciones[$registro_id]; ?></td>
            <td><?php echo $tiempo[$registro_id]; ?></td>
            <!-- <td><?php echo $registros[$id]->hora.' '.$registros[$id++]->dia; ?></td> -->
         </tr>
        <?php } ?>
         </tbody>
        </table>
        <?php echo anchor('inicio/eventos', 'Ver eventos anteriores', array('style'=>'float: right', 'class'=>'btn btn-default btn-small show-option', 'title'=>'Ver eventos anteriores')); ?>
    </div>
    
    <div class="col-md-6">
        <h3><span class="label label-success">Últimas ventas</span></h3>
        <table class="table table-striped">
            <thead>
          <tr>
            <th><b>Producto</b></th>
            <th><b>Cantidad</b></th>
            <th><b>Fecha</b></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($ventas as $registro_id => $venta) { ?>
         <tr>
            <td><?php echo $venta->nombre_producto; ?></td>
            <td><?php echo $venta->cantidad_vendida; ?></td>
            <td><?php echo $tiempo_venta[$venta->registro_id]; ?></td>
            <!-- <td><?php echo $venta_hora[$registro_id].' '.$venta_dia[$registro_id]; ?></td> -->
         </tr>
        <?php } ?>
         </tbody>
        </table>
        <?php echo anchor('inicio/ventas', 'Ver ventas anteriores', array('style'=>'float: right', 'class'=>'btn btn-default btn-small show-option', 'title'=>'Ver ventas anteriores')); ?>
    </div>
    <div class="col-md-6">
        <h3><span class="label label-primary">Pedidos pendientes</span></h3>
        <table class="table table-striped">
            <thead>
          <tr>
            <th><b>Cliente</b></th>
            <th><b>Precio</b></th>
            <th><b>Estado del Pago</b></th>
            <th><b>Stock</b></th>
            <th><b>Fecha de entrega (limite)</b></th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>Prueba</td>
                <td>Prueba</td>
                <td><span class="label label-info">Pago pendiente</span></td>
                <td>OK</td>
                <td>Prueba</td>
            </tr>
            <tr>
                <td>Prueba</td>
                <td>Prueba</td>
                <td><span class="label label-info">Pago pendiente</span></td>
                <td>Falta 1 producto</td>
                <td>Prueba</td>
            </tr>
            <tr>
                <td>Prueba</td>
                <td>Prueba</td>
                <td><span class="label label-success">Pagado</span></td>
                <td>OK</td>
                <td>Prueba</td>
            </tr>
            <tr>
                <td>Prueba</td>
                <td>Prueba</td>
                <td><span class="label label-info">Pago pendiente</span></td>
                <td>OK</td>
                <td>Prueba</td>
            </tr>
        </tbody>
        </table>
        <?php echo anchor('inicio/pedidos', 'Ver pedidos anteriores', array('style'=>'float: right', 'class'=>'btn btn-default btn-small show-option', 'title'=>'Ver pedidos anteriores')); ?>
    </div>
</div>
<br />
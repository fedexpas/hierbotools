<h2>Ventas</h2>
<?php echo anchor('inicio', 'Inicio', array('style'=>'', 'class'=>'', 'title'=>'Regresar al inicio')).' / Lista de ventas'; ?>
<br /><br />
<div class="row">
    <table class="table table-striped">
    <thead>
      <tr>
        <th><b>Producto</b></th>
        <th><b>Cantidad</b></th>
        <th id="formatoFecha"><b>Fecha</b> <a onclick="changeDateFormat(1)">||</a></th>
    </tr>
    </thead>
    <?php $id = 0;?>
    <tbody id="fechaForm">
    <?php foreach($ventas as $registro_id => $venta) { ?> <!-- @TODO: cambiar fecha (hint: tendria que guardar los datos generados en php por el servidor y pasarselos al scrip)t -->
     <tr>
        <td><?php echo $venta->nombre_producto; ?></td>
        <td><?php echo $venta->cantidad_vendida; ?></td>
        <td class="formato_fecha_1"><?php echo $tiempo[$venta->registro_id]; ?></td>
     </tr>
    <?php } ?>
     </tbody>
    </table>
</div>
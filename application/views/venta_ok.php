<h2>Verificar datos de venta</h2>
<?php echo anchor('producto', 'Lista de Productos', array('style'=>'', 'class'=>'', 'title'=>'Regresar a la lista de productos')).' / '.anchor('producto/vender/'.$datos_venta['producto_id'], 'Vender producto', array('style'=>'', 'class'=>'', 'title'=>'Editar la venta del procuto')).' / Verificar datos de venta'; ?>
<br /><br />
<?php echo form_open_multipart('producto/do_vender'); ?>
<table class="table table-striped">
  <tr>
    <th><b>Nombre</b></th>
    <th><b>Marca</b></th>
    <th><b>Tipo</b></th>
    <th><b>Precio</b></th>
    <?php if ($datos_venta['descuento'] != 0) echo "<th><b>Descuento</b></th>"; ?>
  </tr>
  <?php $cantidad = $datos_venta['cantidad']; // Guarda la cantidad original porque se usa para multiplicar por el precio (*1) y en el while se disminuye (*2) ?>
  <?php while ($datos_venta['cantidad'] > 0) { ?>
  <tr>
      <td><?php echo $datos_venta['nombre']; ?></td>
      <td><?php echo $datos_venta['marca']; ?></td>
      <td><?php echo $datos_venta['tipo']; ?></td>
      <td>$ <?php echo $datos_venta['precio']; ?></td>
      <?php if ($datos_venta['descuento'] != 0) echo "<td></td>"; ?>
  </tr>
  <?php $datos_venta['cantidad']--; } // *2 ?>
  <?php if ($datos_venta['descuento'] != 0) { ?>
  <?php $descuento = ($datos_venta['precio']*$cantidad)*($datos_venta['descuento']/100); // Calcula el descuento: Saca el porcentaje y luego se lo resta al precio
        $precio_descuento = ($datos_venta['precio']*$cantidad)-$descuento; // Importante multiplicar el precio por la cantidad antes de restar el descuento ?>
  <tr>
      <td>Total (sin descuento)</td>
      <td></td>
      <td></td>
      <td>$ <?php echo $datos_venta['precio']*$cantidad; // *1 ?></td>
      <td><?php echo '% '.$datos_venta['descuento']; ?></td>
  </tr>
  <?php } ?>
  <tr>
      <td><b>Total</b></td>
      <td></td>
      <td></td> <!-- Aca abajo checa si es con descuento o no -->
      <td><b>$ <?php echo $datos_venta['descuento']==0?$datos_venta['precio']*$cantidad:$precio_descuento; ?></b></td>
      <?php if ($datos_venta['descuento'] != 0) echo "<td></td>"; ?>
  </tr>
</table>
<input type="hidden" name="precio" value="<?php echo $datos_venta['precio']; ?>">
<input type="hidden" name="cantidad_vendida" value="<?php echo $cantidad; ?>">
<input type="hidden" name="descuento" value="<?php echo $datos_venta['descuento']; ?>">
<input type="hidden" name="producto_id" value="<?php echo $datos_venta['producto_id']; ?>">
<input type="submit" class="btn btn-success" style="float: right;" value="Vender" />
<?php echo form_close(); ?>
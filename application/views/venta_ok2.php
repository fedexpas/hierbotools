<h2><span class="glyphicon glyphicon-shopping-cart"></span> Carrito</h2>
<h3>Verificar datos de venta</h3>
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
    <th><b>Eliminar</b></th>
  </tr>
  
  <?php 
    $precio_total = 0;
    $precio_descuento2 = 0;
  
    foreach($ventas as $venta) {
        $precio_total += $venta[0]->precio*$venta[0]->cantidad; ?>
    <?php while ($venta[0]->cantidad > 0) { ?>
            <tr class='tabla_<?php echo $venta[0]->compra_id;?>_<?php echo $venta[0]->producto_id; ?>'>
                <td><?php echo $venta[0]->nombre; ?></td>
                <td><?php echo $venta[0]->marca; ?></td>
                <td><?php echo $venta[0]->tipo; ?></td>
                <td class='precio_<?php echo $venta[0]->compra_id; ?>_<?php echo $venta[0]->producto_id; ?>' data-value='<?php echo $venta[0]->precio; ?>'>$ <?php echo $venta[0]->precio; ?></td>
                <?php if ($venta[0]->descuento != 0) { 
                    $descuento2 = ($venta[0]->precio*$venta[0]->cantidad)*($venta[0]->descuento/100);
                    $precio_descuento2 += ($venta[0]->precio*$venta[0]->cantidad)-$descuento2;
                    echo "<td></td>"; 
                } ?>
                <td class='equis' data-value='<?php echo $venta[0]->compra_id; ?>_<?php echo $venta[0]->producto_id; ?>'>X</td>
            </tr>
            <?php $venta[0]->cantidad-- ?>
    <?php } ?>
  <?php } ?>
  
  <?php if ($precio_descuento2 != 0) { ?>
  <?php //$descuento = ($datos_venta['precio']*$cantidad)*($datos_venta['descuento']/100); // Calcula el descuento: Saca el porcentaje y luego se lo resta al precio
        //$precio_descuento = ($datos_venta['precio']*$cantidad)-$descuento; // Importante multiplicar el precio por la cantidad antes de restar el descuento ?>
  <tr>
      <td>Total (sin descuento)</td>
      <td></td>
      <td></td>
      <td>$ <?php echo $precio_total ?></td>
      <?php if ($precio_descuento2 != 0) echo "<td></td>"; ?>
      <td></td>
  </tr>
  <?php } ?>
  <tr>
      <td><b>Total</b></td>
      <td></td>
      <td></td> <!-- Aca abajo checa si es con descuento o no -->
      <td id='precio_total' data-value='<?php echo $precio_descuento2==0?$precio_total:$precio_descuento2; ?>'><b>$ <?php echo $precio_descuento2==0?$precio_total:$precio_descuento2; ?></b></td>
      <?php if ($precio_descuento2 != 0) echo "<td></td>"; ?>
      <td></td>
  </tr>
</table>
<div style="float: right;">
    
    <label>Fecha límite de entrega</label>
    <p>ej.: 04/20/2017 (solo aplica si es un pedido)</p>
    <input type="date" name="fecha_entrega" />
    
    <input type="hidden" name="precio" value="<?php echo $datos_venta['precio']; ?>">
    <input type="hidden" name="cantidad_vendida" value="1">
    <input type="hidden" name="descuento" value="<?php echo $datos_venta['descuento']; ?>">
    <input type="hidden" name="producto_id" value="<?php echo $datos_venta['producto_id']; ?>">
    <br /><br /><input type="submit" class="btn btn-success" value="Vender" /> <!-- Aplicar alert que pregunte si esta seguro de querer vender -->
</div>
<?php echo form_close(); ?>
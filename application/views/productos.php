<h2>Productos</h2>
<?php echo anchor('producto/agregar/', '<i class="icon-ok icon-white"></i> Agregar producto', array('style'=>'float: right', 'class'=>'btn btn-success btn-small show-option', 'title'=>'Agregar producto')); ?><br /><br /><br />
<?php if ($productos) { ?>
<?php echo form_open_multipart('producto/buscar'); ?>
    <input type="text" style="width: 35%" name="nombre" />
    <input type="submit" class="btn btn-default" value="Buscar" />
<?php echo form_close(); ?>
<table class="table table-striped">
  <tr>
    <th><b>Nombre</b></th>
    <td><b>Cantidad</b></td>
    <td><b>Precio</b></td>
    <td><b>Marca</b></td>
    <td><b>Tipo</b></td>
    <td><b>Vender</b></td>
    <td><b>Editar</b></td>
    <td><b>Eliminar</b></td>
</tr>
<?php foreach($productos as $producto) { ?>
  <tr>
    <td><?php echo $producto->nombre; ?></td>
    <td><?php echo $producto->cantidad; ?></td>
    <td><?php echo $producto->precio; ?></td>
    <td><?php echo $producto->marca; ?></td>
    <td><?php echo $producto->tipo; ?></td>
    <td><?php echo anchor('producto/vender/'.$producto->producto_id, '<i class="icon-alert icon-white"></i> Vender', array('style'=>'float: right', 'class'=>'btn btn-success btn-small show-option', 'title'=>'Vender')); ?></td>
    <td><?php echo anchor('producto/editar/'.$producto->producto_id, '<i class="icon-alert icon-white"></i> Editar', array('style'=>'float: right', 'class'=>'btn btn-warning btn-small show-option', 'title'=>'Editar')); ?></td>
    <td><a href="#" title="Eliminar" class="btn btn-danger btn-small show-option" style="float: right;" onclick="confirmarDelProd('<?php echo base_url().'index.php/producto/eliminar/'.$producto->producto_id ?>')"><i class="icon-alert icon-white"></i> Eliminar</a></td>
  </tr>
<?php } ?>
</table>
<?php } else { ?>
<h3>No hay productos</h3>
<?php } ?>

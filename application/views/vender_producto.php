<h2>Vender producto</h2>
<?php echo anchor('producto', 'Lista de Productos', array('style'=>'', 'class'=>'', 'title'=>'Regresar a la lista de productos')).' / Vender producto'; ?>
<br /><br />
<?php if ($producto) { 
    if ($producto[0]->cantidad >= 1) { ?>
    <?php echo form_open_multipart('producto/venta_ok'); ?>
    <fieldset>
        <div class="col-md-6">
            <p><b>Nombre</b></p>
            <p><?php echo $producto[0]->nombre; ?></p>
            <input type="hidden" name="nombre" value="<?php echo $producto[0]->nombre; ?>">
            <label>Precio</label><br />
            <input type="text" name="precio" value="<?php echo $producto[0]->precio; ?>" /><br />
            <label>Cantidad vendida</label><br />
            <input type="text" name="cantidad_vendida" value="1" /><br />
        </div>
        <div class="col-md-6">
            <label>Descuento</label><br />
            <input type="text" name="descuento" value="0" /> %<br />
            <p><b>Tipo de producto</b></p>
            <p><?php echo $tipo; ?></p>
            <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
            <p><b>Marca</b></p>
            <p><?php echo $marca; ?></p>
            <input type="hidden" name="marca" value="<?php echo $marca; ?>">
        </div>
        
        <!---------------Inicio session nombre de usuario-------------------------->
        
        <label>Usuario:</label>
        <?php if ($this->session->userdata('usuario')) { ?>
        <p id='usuario' ><b><?php echo $this->session->userdata('usuario'); ?></b></p>
        <label>E-Mail:</label>
        <p><b><?php echo $this->session->userdata('usuario_email'); ?></b></p>
        ><p id='usuario_del' style='color: red;'>Cambiar</p>
        <?php } else { ?>
            <input type="text" name="usuario" value=""><br />
            <label>E-Mail:</label>
            <input type="text" name="usuario_email" value="">
        <?php } ?>
            
        <!-----------------Fin session nombre de usuario--------------------------->    
            
        <div class="probando"></div>
        <input type="hidden" name="producto_id" value="<?php echo $producto[0]->producto_id; ?>">
    </fieldset>
<br />
<input type="submit" class="btn btn-success" value="Ver la cuenta" />
<?php echo form_close(); ?>
<?php } else { ?> 
<p>No hay stock disponible de este producto</p>
<?php } 
} else { ?>
<p>El producto no existe!</p>
<?php } ?>

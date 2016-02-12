<h2><span class="glyphicon glyphicon-shopping-cart"></span> Agregar al carrito</h2>
<?php echo anchor('producto', 'Lista de Productos', array('style'=>'', 'class'=>'', 'title'=>'Regresar a la lista de productos')).' / Agregar al carrito'; ?>
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
            <input type="hidden" name="tipo_id" value="<?php echo $producto[0]->tipo_id; ?>">
            <p><b>Marca</b></p>
            <p><?php echo $marca; ?></p>
            <input type="hidden" name="marca" value="<?php echo $marca; ?>">
            <input type="hidden" name="marca_id" value="<?php echo $producto[0]->marca_id; ?>">
        </div>
        
        <!---------------Inicio session nombre de usuario-------------------------->
        
        <label>Cliente:</label>
        <?php if ($this->session->userdata('cliente')) { ?>
        
        <p id='usuario' ><b><?php echo $this->session->userdata('cliente'); ?></b></p>
        <span class='esconder'><input type="hidden" name="cliente" value="<?php echo $this->session->userdata('cliente'); ?>"></span>
        
        <?php } else { ?>
        
        <input type="text" name="cliente" value=""><br />
        
        <?php } ?>
        
        <label class='esconder'>E-Mail:</label>
        <?php if ($this->session->userdata('cliente_email')) { ?>
        
        <p class='esconder'><b><?php echo $this->session->userdata('cliente_email'); ?></b></p>
        <span class='esconder'><input type="hidden" name="cliente_email" value="<?php echo $this->session->userdata('cliente_email'); ?>"></span>
        
        <p id='usuario_del' class='esconder' style='color: red;'>Cambiar</p>
        
        <?php } else { ?>
        
            <input type="text" name="cliente_email" value="">
            
        <?php } ?>
            
        <!-----------------Fin session nombre de usuario--------------------------->    
            
        <div class="probando"></div>
        <input type="hidden" name="producto_id" value="<?php echo $producto[0]->producto_id; ?>">
    </fieldset>
<br />
<input type="submit" class="btn btn-success" value="Agregar al carrito" />
<?php echo form_close(); ?>
<?php } else { ?> 
<p>No hay stock disponible de este producto</p>
<?php } 
} else { ?>
<p>El producto no existe!</p>
<?php } ?>

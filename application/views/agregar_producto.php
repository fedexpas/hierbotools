<h2>Agregar producto</h2>
<?php echo anchor('producto', 'Lista de Productos', array('style'=>'', 'class'=>'', 'title'=>'Regresar a la lista de productos')).' / Agregar producto'; ?>
<br /><br />
    <?php echo form_open_multipart('producto/do_agregar'); ?>
    <fieldset>
        <div class="span5">
            <label>Nombre</label><br />
            <input type="text" name="nombre" /><br />
            <label>Precio</label><br />
            <input type="text" name="precio" /><br />
            <label>Cantidad</label><br />
            <input type="text" name="cantidad" /><br />
            <label>Tipo de producto</label><br />
            <?php if ($tipos) { ?>
                <select name="tipo_id">
                    <?php foreach($tipos as $tipo) { ?>
                    <option value="<?php echo $tipo->tipo_id; ?>"><?php echo $tipo->nombre; ?></option>
                    <?php } ?>
                    <option value="0">Nuevo tipo de producto</option>
                </select><br />
            <?php } ?>
                <input type="text" style="display:none" name="tipo" /><p style="display:none" id="vertipos">Ver tipos de productos ya existentes</p><br />
            <label>Marca</label><br />
            <?php if ($marcas) { ?>
                <select name="marca_id">
                    <?php foreach($marcas as $marca) { ?>
                    <option value="<?php echo $marca->marca_id; ?>"><?php echo $marca->nombre; ?></option>
                    <?php } ?>
                    <option value="0">Nueva marca</option>
                </select><br /><br />
            <?php } ?>
                <input type="text" style="display:none" name="marca" /><p style="display:none" id="vermarcas">Ver marcas ya existentes</p><br /><br />
        </div>
        <div class="probando"></div>
    </fieldset>
<input type="submit" class="btn btn-success" value="Agregar" />
<?php echo form_close(); ?>
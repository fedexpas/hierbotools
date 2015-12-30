<h2>Eventos</h2>
<?php echo anchor('inicio', 'Inicio', array('style'=>'', 'class'=>'', 'title'=>'Regresar al inicio')).' / Lista de eventos'; ?>
<br /><br />
<div class="row">
    <table class="table table-striped">
    <thead>
      <tr>
        <th><b>Producto</b></th>
        <th><b>Acción</b></th>
        <th><b>Fecha</b></th>
    </tr>
    </thead>
    <tbody>
    <?php $id = 0;?>
    <?php foreach($eventos as $registro_id => $evento) { ?>
     <tr>
        <td><?php echo $evento->nombre_producto; ?></td>
        <td><?php echo $acciones[$evento->registro_id]; ?></td>
        <td><?php echo $tiempo[$evento->registro_id]; ?></td>
     </tr>
    <?php } ?>
     </tbody>
    </table>
</div>
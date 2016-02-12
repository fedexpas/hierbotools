/*$( ".tiponuevo" )
  .change(function() {
    var str = "";
    str = $( "select option:selected" ).val();
    if ( str == 0) {
        alert('entro');
    $( ".probando" ).text('va a ser un nuevo tipo de producto!');
    }
    
  })
  .trigger( "change" );*/
  
  /************** BORRAR ITEM DEL CARRITO ****************/
  
  $('.equis').click(function(){
     var compra_id = $(this).val();
     alert(compra_id);
     $('.tabla_'.compra_id).hide();
  });
  
  /*******************************************************/
  
  
 /***************** Cambiar sesion usuario ****************/
  
  $('#usuario_del').click(function(){
      var html = '<input type="text" name="cliente" value=""><br /><label>E-Mail:</label><br /><input type="text" name="cliente_email" value="">';
      $('#usuario').html(html);
      $('.esconder').html('');
  });
  
  /********************************************************/
  
  //Tipos
  
  $('select[name="tipo_id"]').change(function(){
  var id_producto = $(this).val();
  
  if (id_producto == 0) {
      $('input[name="tipo"]').show();
      $('#vertipos').show();
      $('select[name="tipo_id"]').hide();
  }
});

$('#vertipos').click(function(){
    $('select[name="tipo_id"]').show();
    $('input[name="tipo"]').hide();
      $('#vertipos').hide();
});

//Marcas

  $('select[name="marca_id"]').change(function(){
  var id_producto = $(this).val();
  
  if (id_producto == 0) {
      $('input[name="marca"]').show();
      $('#vermarcas').show();
      $('select[name="marca_id"]').hide();
  }
});

$('#vermarcas').click(function(){
    $('select[name="marca_id"]').show();
    $('input[name="marca"]').hide();
      $('#vermarcas').hide();
});

function confirmarDelProd(url) {
    if (confirm('¿Está seguro de que desea eliminar este producto?')) {
        alert('El producto será eliminado');
        window.location.href = url;
    }
    else {
        alert('El producto NO será eliminado');
    }
}

function changeDateFormat(formato) { // formato = 1 = "Hace X tiempo" / formato = 2 = 'Y-d-m'
    if (formato == 1) {
        var html = '<?php foreach($ventas as $registro_id => $venta) { ?><tr><td><?php echo $venta->nombre_producto; ?></td><td><?php echo $venta->cantidad_vendida; ?></td><td class="formato_fecha_1"><?php echo $venta->dia; ?></td></tr><?php } ?>';
        
        $('#fechaForm').html(html);
        $('#formatoFecha').html('<th id="formatoFecha1"><b>Fecha</b> <a onclick="changeDateFormat(2)">||</a></th>')
    }
    if (formato == 2) {
        var html = '<?php foreach($ventas as $registro_id => $venta) { ?><tr><td><?php echo $venta->nombre_producto; ?></td><td><?php echo $venta->cantidad_vendida; ?></td><td class="formato_fecha_1"><?php echo $tiempo[$venta->registro_id]; ?></td></tr><?php } ?>';
        
        $('#fechaForm').html(html);
        $('#formatoFecha').html('<th id="formatoFecha1"><b>Fecha</b> <a onclick="changeDateFormat(1)">||</a></th>')
    }
}
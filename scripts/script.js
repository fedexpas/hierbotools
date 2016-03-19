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
      alert('hola');
     var ids = $(this).data('value').split('_');
     var compra_id = ids[0];
     var producto_id = ids[1];
     alert('compra id = '+compra_id+' producto id = '+producto_id);
     var precio_producto = $('.precio_'+compra_id+'_'+producto_id).data('value');
     var precio_total = $('#precio_total').data('value');
     alert(precio_total-precio_producto);
     $('.tabla_'+compra_id+'_'+producto_id).hide();
     $('#precio_total').html('<b>$ '+(precio_total-precio_producto)+'</b>');
     $('#precio_total').data('value', precio_total-precio_producto);
     // @TODO: Borrar producto de la base de datos (cliente_compra_temp)
     $.get('del_producto_carrito/'+compra_id+'/'+producto_id, function(data){
         alert(data);
     });
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
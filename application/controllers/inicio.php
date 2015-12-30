<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
        public function __construct()
        {
                parent::__construct();
                // Your own constructor code
                date_default_timezone_set('America/Mexico_City');

                $this->load->model('registro_model');
                $this->load->helper('date');

                global $data;

                $data['activo'] = 'inicio';
                $data['breadcrumbs'] = array('Inicio'=>'inicio');
        }
    
	public function index()
	{
                global $data;
                $acciones = array();
                $nombres = array();
                $data['ventas'] = array();
                $data['venta_hora'] = array();
                $data['venta_dia'] = array();
                
                $registros = $this->registro_model->get(8); // 8 es el limite de registros que quiero (LIMIT 8)
                
                //echo "<pre>";print_r($registros);exit;
                
                $hora = "%h:%i:%s";
                $dia = "%Y-%m-%d";
                
                $hora = mdate($hora, time());
                $dia = mdate($dia, time());
                
                
                $data['registros'] = $registros;
                
                foreach($registros as $registro) {
                    $nombre_producto = ($registro->nombre_producto)==''?'Producto número '.$registro->producto_id:$registro->nombre_producto;
                
                if ($registro->dia == $dia) {
                    $hora_actual = explode(':', $hora);
                    $hora_actual[0] += 12; // Sumamos 12 a la hora actual para usar el formato 24h. ej.: si la hora actual es 4 pm y el producto fue vendido a las 10 am y restamos 4-10 (*) nos dara -6 pero si le sumamos 12 a 4 queda 16 y 16 - 10 es: 6, que es la diferencia de horas entre la venta y la hora actual
                    $hora_producto = explode(':', $registro->hora);
                    $dif_horas = $hora_actual[0]-$hora_producto[0]; // *
                    $data['tiempo'][$registro->registro_id] = $dif_horas!=0?'Hace '.$dif_horas.' horas':'Hace unos minutos';
                    //$data['tiempo'][$registro->registro_id] = strtotime($hora) - strtotime($registro->hora);
                }
                else {
                    $dia_actual = explode('-', $dia);
                    $dia_producto = explode('-', $registro->dia);
                    //echo date('c', strtotime($dia) - strtotime($registro->dia));exit;
                    if ($dia_actual[1] == $dia_producto[1]) { // Checa si el mes es el mismo (ALERTA: no checa el año!)
                        $dif_dias = $dia_actual[2]-$dia_producto[2];
                        $data['tiempo'][$registro->registro_id] = 'Hace '.$dif_dias.' días';
                    }
                    else if ($dia_actual[1]>$dia_producto[1] && $dia_producto[0] != '0000') { // Si el mes actual es mas grande que el mes en el que el producto fue agregado significa que fue agregado en el mismo año
                        $dif_meses = $dia_actual[1]-$dia_producto[1];
                        $data['tiempo'][$registro->registro_id] = 'Hace '.$dif_meses.' meses';
                    }
                    else if ($dia_producto[0] == '0000') { // La fecha no fue ingresada (ej.: 0000-00-00), $dia_producto[0] es el primero: 0000
                        $data['tiempo'][$registro->registro_id] = 'Fecha no registrada';
                    }
                    else { // De lo contrario el mes actual es mas pequeño que el del producto por lo tanto el producto fue agregado hace mas de un año
                        $data['tiempo'][$registro->registro_id] = 'Hace mas de un año';
                    }
                    //$data['tiempo'][$registro->registro_id] = date_diff(date_create($registro->dia), date_create($dia));
                }
                    
                    switch($registro->accion_nombre) {
                        case 'eliminar':
                            $nombres[$registro->registro_id] = 'Producto número '.$registro->producto_id;
                            $acciones[$registro->registro_id] = '<span class="label label-danger">Eliminado</span>';
                            break;
                        case 'editar':
                            $nombres[$registro->registro_id] = $registro->nombre_producto;
                            $acciones[$registro->registro_id] = '<span class="label label-warning">Editado</span>';
                            break;
                        case 'agregar':
                            $nombres[$registro->registro_id] = $nombre_producto;
                            $acciones[$registro->registro_id] = '<span class="label label-success">Agregado</span>';
                            break;
                        case 'venta':
                            $data['ventas'][$registro->registro_id] = $registro->cantidad_vendida; // Si la accion es "venta" guarda los datos en una variable especial para mostrarlos en una tabla separada al inicio
                            $data['nombre_producto'][$registro->registro_id] = $registro->nombre_producto;
                            $data['venta_hora'][$registro->registro_id] = $registro->hora;
                            $data['venta_dia'][$registro->registro_id] = $registro->dia;
                            $nombres[$registro->registro_id] = $registro->nombre_producto;
                            $acciones[$registro->registro_id] = '<span class="label label-info">Vendido</span>';
                            break;
                    }
                }
                
                $ventas = $this->registro_model->getVentas(8); // LIMIT 8
                $data['tiempo_venta'] = $this->calcFecha($ventas);
                $data['ventas'] = $ventas;
                
                //echo "<pre>";print_r($registros);exit;
                
                $data['nombres'] = $nombres;
                $data['acciones'] = $acciones;
                
                $data['vista'] = 'inicio';
		$this->load->view('plantilla', $data);
	}
        
        public function eventos()
        {
            global $data;
            
            $data['tiempo'] = array();
            $eventos = $this->registro_model->get();
            $data['eventos'] = $eventos;
            
            foreach($eventos as $evento) {
                    $nombre_producto = ($evento->nombre_producto)==''?'Producto número '.$evento->producto_id:$evento->nombre_producto;
                
                    $data['tiempo'][$evento->registro_id] = $this->calcFecha($evento);
                    
                    switch($evento->accion_nombre) {
                        case 'eliminar':
                            $nombres[$evento->registro_id] = 'Producto número '.$evento->producto_id;
                            $acciones[$evento->registro_id] = '<span class="label label-danger">Eliminado</span>';
                            break;
                        case 'editar':
                            $nombres[$evento->registro_id] = $evento->nombre_producto;
                            $acciones[$evento->registro_id] = '<span class="label label-warning">Editado</span>';
                            break;
                        case 'agregar':
                            $nombres[$evento->registro_id] = $nombre_producto;
                            $acciones[$evento->registro_id] = '<span class="label label-success">Agregado</span>';
                            break;
                        case 'venta':
                            $data['ventas'][$evento->registro_id] = $evento->cantidad_vendida; // Si la accion es "venta" guarda los datos en una variable especial para mostrarlos en una tabla separada al inicio
                            $data['nombre_producto'][$evento->registro_id] = $evento->nombre_producto;
                            $data['venta_hora'][$evento->registro_id] = $evento->hora;
                            $data['venta_dia'][$evento->registro_id] = $evento->dia;
                            $nombres[$evento->registro_id] = $evento->nombre_producto;
                            $acciones[$evento->registro_id] = '<span class="label label-info">Vendido</span>';
                            break;
                    }
                }
                
                $data['acciones'] = $acciones;
            
            $data['vista'] = 'eventos';
            $this->load->view('plantilla', $data);
        }
        
        public function ventas()
        {
            global $data;
            
            $data['activo'] = 'ventas';
            $data['ventas'] = $this->registro_model->getVentas();
            $data['tiempo'] = $this->calcFecha($data['ventas']);
            
            $data['vista'] = 'ventas';
            $this->load->view('plantilla', $data);
        }
        
        private function calcFecha($registros=NULL)
        {
            //echo "<pre>";print_r($registros);exit;
            
            $hora = "%h:%i:%s";
            $dia = "%Y-%m-%d";

            $hora = mdate($hora, time());
            $dia = mdate($dia, time());
            
            $tiempo = array();
            if (is_array($registros)) { // si $registros es array significa que es mas de un registro
            foreach($registros as $registro) {
                
                if ($registro->dia == $dia) {
                    $hora_actual = explode(':', $hora);
                    $hora_actual[0] += 12; // Sumamos 12 a la hora actual para usar el formato 24h. ej.: si la hora actual es 4 pm y el producto fue vendido a las 10 am y restamos 4-10 (*) nos dara -6 pero si le sumamos 12 a 4 queda 16 y 16 - 10 es: 6, que es la diferencia de horas entre la venta y la hora actual
                    $hora_producto = explode(':', $registro->hora);
                    $dif_horas = $hora_actual[0]-$hora_producto[0]; // *
                    $tiempo[$registro->registro_id] = $dif_horas!=0?'Hace '.$dif_horas.' horas':'Hace unos minutos';
                    //$tiempo[$registro->registro_id] = strtotime($hora) - strtotime($registro->hora);
                }
                else {
                    $dia_actual = explode('-', $dia);
                    $dia_producto = explode('-', $registro->dia);
                    //echo date('c', strtotime($dia) - strtotime($registro->dia));exit;
                    if ($dia_actual[1] == $dia_producto[1]) { // Checa si el mes es el mismo (ALERTA: no checa el año!)
                        $dif_dias = $dia_actual[2]-$dia_producto[2];
                        $tiempo[$registro->registro_id] = 'Hace '.$dif_dias.' días';
                    }
                    else if ($dia_actual[1]>$dia_producto[1] && $dia_producto[0] != '0000') { // Si el mes actual es mas grande que el mes en el que el producto fue agregado significa que fue agregado en el mismo año
                        $dif_meses = $dia_actual[1]-$dia_producto[1];
                        $tiempo[$registro->registro_id] = 'Hace '.$dif_meses.' meses';
                    }
                    else if ($dia_producto[0] == '0000') { // La fecha no fue ingresada (ej.: 0000-00-00), $dia_producto[0] es el primero: 0000
                        $tiempo[$registro->registro_id] = 'Fecha no registrada';
                    }
                    else { // De lo contrario el mes actual es mas pequeño que el del producto por lo tanto el producto fue agregado hace mas de un año
                        $tiempo[$registro->registro_id] = 'Hace mas de un año';
                    }
                    //$data['tiempo'][$registro->registro_id] = date_diff(date_create($registro->dia), date_create($dia));
                }
            }
            }
            else { // de lo contrario, es solo un registro y no hay necesidad de un foreach
                $registro = $registros;
                if ($registro->dia == $dia) {
                    $hora_actual = explode(':', $hora);
                    $hora_actual[0] += 12; // Sumamos 12 a la hora actual para usar el formato 24h. ej.: si la hora actual es 4 pm y el producto fue vendido a las 10 am y restamos 4-10 (*) nos dara -6 pero si le sumamos 12 a 4 queda 16 y 16 - 10 es: 6, que es la diferencia de horas entre la venta y la hora actual
                    $hora_producto = explode(':', $registro->hora);
                    $dif_horas = $hora_actual[0]-$hora_producto[0]; // *
                    $tiempo = $dif_horas!=0?'Hace '.$dif_horas.' horas':'Hace unos minutos'; // $tiempo ya no es una array ($tiempo[$registro->registro_id])
                    //$tiempo[$registro->registro_id] = strtotime($hora) - strtotime($registro->hora);
                }
                else {
                    $dia_actual = explode('-', $dia);
                    $dia_producto = explode('-', $registro->dia);
                    //echo date('c', strtotime($dia) - strtotime($registro->dia));exit;
                    if ($dia_actual[1] == $dia_producto[1]) { // Checa si el mes es el mismo (ALERTA: no checa el año!)
                        $dif_dias = $dia_actual[2]-$dia_producto[2];
                        $tiempo = 'Hace '.$dif_dias.' días';
                    }
                    else if ($dia_actual[1]>$dia_producto[1] && $dia_producto[0] != '0000') { // Si el mes actual es mas grande que el mes en el que el producto fue agregado significa que fue agregado en el mismo año
                        $dif_meses = $dia_actual[1]-$dia_producto[1];
                        $tiempo = 'Hace '.$dif_meses.' meses';
                    }
                    else if ($dia_producto[0] == '0000') { // La fecha no fue ingresada (ej.: 0000-00-00), $dia_producto[0] es el primero: 0000
                        $tiempo = 'Fecha no registrada';
                    }
                    else { // De lo contrario el mes actual es mas pequeño que el del producto por lo tanto el producto fue agregado hace mas de un año
                        $tiempo = 'Hace mas de un año';
                    }
                    //$data['tiempo'][$registro->registro_id] = date_diff(date_create($registro->dia), date_create($dia));
                }
            }
            
            return $tiempo;
        }
        
        public function diseno()
        {
            global $data;
            
            $data['vista'] = 'diseno';
            $this->load->view('plantilla', $data);
        }
}
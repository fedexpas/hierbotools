<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {

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

                $this->load->model('producto_model');
                $this->load->model('cliente_model');
                $this->load->model('compra_model');
                $this->load->helper('date');

                global $data;

                $data['activo'] = 'productos';
                $data['breadcrumbs'] = array('Inicio'=>'inicio');
        }
    
	public function index()
	{
                global $data;
                
                $data['productos'] = $this->producto_model->obtener('todo');
                
                $data['vista'] = 'productos';
		$this->load->view('plantilla', $data);
	}
        
	public function agregar()
	{
                global $data;
                
                $data['marcas'] = $this->producto_model->obtener('marcas');
                $data['tipos'] = $this->producto_model->obtener('tipos');
                
                $data['vista'] = 'agregar_producto';
		$this->load->view('plantilla', $data);
	}
        
	public function do_agregar()
	{
                global $data;
                
                if ($_POST['marca']) { // Si $_POST['marca'] existe significa que es la primer marca agregada
                    $marca_id = $this->producto_model->agregar(array('nombre'=>$_POST['marca']), 'marca');
                }
                else { // De lo contrario el usuario selecciono una marca ya existente
                    $marca_id = $_POST['marca_id'];
                }
                
                if ($_POST['tipo']) {
                    $tipo_id = $this->producto_model->agregar(array('nombre'=>$_POST['tipo']), 'tipo');
                }
                else {
                    $tipo_id = $_POST['tipo_id'];
                }
                
                $datos = array('nombre'=>$_POST['nombre'],
                                'precio'=>$_POST['precio'],
                                'cantidad'=>$_POST['cantidad'],
                                'tipo_id'=>$tipo_id,
                                'marca_id'=>$marca_id);
                
                if (!($producto_id=$this->producto_model->agregar($datos))) {
                    echo "El producto no pudo ser agregado";
                    exit;
                }
                
                $hora = "%h:%i:%s";
                $dia = "%Y-%m-%d";
                
                $registro_acciones = array('accion_id'=>1,
                                        'producto_id'=>$producto_id,
                                        'hora'=>mdate($hora, time()),
                                        'dia'=>mdate($dia, time()));
                
                $this->producto_model->agregar($registro_acciones, 'registro');
                
                redirect('producto/index');
	}
        
        public function editar()
	{
                global $data;
                
                if ($this->uri->segment(3)) {
                
                    $producto_id = $this->uri->segment(3);
                    
                    $data['producto'] = $this->producto_model->obtener($producto_id);
                    $data['marcas'] = $this->producto_model->obtener('marcas');
                    $data['tipos'] = $this->producto_model->obtener('tipos');

                    $data['vista'] = 'editar_producto';
                    $this->load->view('plantilla', $data);
                }
	}
        
        public function do_editar()
	{
                global $data;
                
                if ($_POST['marca']) { // Si $_POST['marca'] existe significa que es la primer marca agregada
                    $marca_id = $this->producto_model->agregar(array('nombre'=>$_POST['marca']), 'marca');
                }
                else { // De lo contrario el usuario selecciono una marca ya existente
                    $marca_id = $_POST['marca_id'];
                }
                
                if ($_POST['tipo']) {
                    $tipo_id = $this->producto_model->agregar(array('nombre'=>$_POST['tipo']), 'tipo');
                }
                else {
                    $tipo_id = $_POST['tipo_id'];
                }
                
                if ($_POST['producto_id']) { // $_POST['producto_id'] es el ID del producto y debe ser obtenido porque esta en un input oculto (hidden)
                    $producto_id = $_POST['producto_id'];
                }
                else { // De lo contrario el programa termina porque es necesario el ID para hacer el update
                    echo "ERROR: ID de producto no encontrado";
                    exit;
                }
                
                $datos = array('nombre'=>$_POST['nombre'],
                                'precio'=>$_POST['precio'],
                                'cantidad'=>$_POST['cantidad'],
                                'tipo_id'=>$tipo_id,
                                'marca_id'=>$marca_id);
                
                if (!$this->producto_model->update($datos, 'producto', $producto_id, 'producto_id')) {
                    echo "El producto no pudo ser editado";
                    exit;
                }
            
                /* Formato hora y dia */
                $hora = "%h:%i:%s";
                $dia = "%Y-%m-%d";
                
                $registro_acciones = array('accion_id'=>2,
                                        'producto_id'=>$producto_id,
                                        'hora'=>mdate($hora, time()),
                                        'dia'=>mdate($dia, time()));
                
                $this->producto_model->agregar($registro_acciones, 'registro');
                
                redirect('producto/index');
	}
        
        public function vender()
	{
                global $data;
                
                if ($this->uri->segment(3)) {
                
                    $producto_id = $this->uri->segment(3);
                    
                    $data['producto'] = $this->producto_model->obtener($producto_id);
                    
                    $data['marca'] = $data['producto'][0]->marca;
                    $data['tipo'] = $data['producto'][0]->tipo;

                    $data['vista'] = 'vender_producto';
                    $this->load->view('plantilla', $data);
                }
                else {
                    echo "<p>ID de producto no proporcionado<p>";
                    exit;
                }
                
                // @TODO: Dar opcion de convertir de pesos a dolares (y viceversa) agregando un campo que tenga el tipo de conversion del momento (que el usuario ingresaria manualmente. ej. 14.5)
	}
        
        public function venta_ok()
        {
            global $data;
            
            /******************* AGREGA CLIENTE A LA DB ***************************/
            
            if ($_POST['cliente'] && $_POST['cliente_email']) {
                $this->session->set_userdata(array('cliente'=>$_POST['cliente'])); // Establece el nombre de usuario para esta sesion
                $this->session->set_userdata(array('cliente_email'=>$_POST['cliente_email'])); // Guarda el email del cliente para esta sesion
                
                
                if (!$this->cliente_model->existe(array('email'=>$this->session->userdata('cliente_email')))) { // si el correo de la sesion no existe en la db de clientes
                    
                    $datos_cliente = array('nombre'=>$this->session->userdata('cliente'),
                                            'email'=>$this->session->userdata('cliente_email'));
                    
                    $cliente_id = $this->cliente_model->agregar($datos_cliente); // agrega al cliente a la db (su nombre o apodo y su correo)
                    $this->session->set_userdata(array('cliente_id'=>$cliente_id));
                }
                else { // Si existe en la db un cliente con el correo suministrado, obtenemos su ID
                    $datos_cliente = $this->cliente_model->existe(array('email'=>$this->session->userdata('cliente_email')));
                    $this->session->set_userdata(array('cliente_id'=>$datos_cliente->cliente_id)); // Esto es por si el usuario esta usando un cliente (con correo) que ya existe en la DB
                }
            }
            
            /*********************************************************************/
            
            // $_POST['descuento'] = 0 // En la vista vender_ok se verifica si el descuento es igual a 0 (cero), asignarlo aqui es una precaución por si el usario dejó el campo vacío            
            
            
            $data['datos_venta'] = array('nombre'=>$_POST['nombre'],
                                        'precio'=>$_POST['precio'],
                                        'cantidad'=>$_POST['cantidad_vendida'],
                                        'descuento'=>$_POST['descuento'],
                                        'tipo'=>$_POST['tipo'],
                                        'marca'=>$_POST['marca'],
                                        'producto_id'=>$_POST['producto_id']);
            
            
            $datos_temp = $data['datos_venta']; // Copia los datos a una nueva variable para modificarlos ligeramente
            
            if ($this->session->userdata('cliente_id') !== NULL) { // Si la variable $cliente_id fue asignada (porque el usuario ingreso un nombre de cliente)
                
                $datos_temp['cliente_id'] = $this->session->userdata('cliente_id'); // se copia a la tabla cliente_compra_Temp
            }
            
            /****************************/
            //Corregimos nombres de variables para que esten de acuerdo con las de la db
            
            $datos_temp['marca_id'] = $_POST['marca_id']; // Copia variable a la que tiene el nombre que queremos (en este caso marca_id por que asi esta en la db)
            unset($datos_temp['marca']); // Borra vieja variable con nombre no deseado (IMPORTANTE: si esto no se hace se produce un ERROR porque intenta insertar un campo en la db con el nombre de la variabla y este no existe)
            
            $datos_temp['tipo_id'] = $_POST['tipo_id'];
            unset($datos_temp['tipo']);
            
            /****************************/
            
            /************* AGREGA COMPRAS A LA DB TEMPORAL ************/ // Y los IDs de la compra (tambien se puede buscar las compras atravez del cliente_id pero puede generar problemas si alguna compra de ese cliente quedo atorada en cliente_compra_temp)
            
            if ($this->session->userdata('compra_temp_ids') !== NULL) { // Si la variable de sesion compra_temp_ids existe procedemos a agregar un nuevo ID
                $compra_temp_id = $this->compra_model->agregarCarrito($datos_temp);
                $this->session->set_userdata(array('compra_temp_ids'=>$this->session->userdata('compra_temp_ids').'/'.$compra_temp_id)); // Funciona?
                $data['datos_venta']['compra_id'] = $compra_temp_id;
            }
            else { // De lo contrario creamos la variable y le asignamos su primer valor
                $compra_temp_id = $this->compra_model->agregarCarrito($datos_temp);
                $this->session->set_userdata(array('compra_temp_ids'=>$compra_temp_id));
                $data['datos_venta']['compra_id'] = $compra_temp_id;
            }
                
            /***********************************************************/
            
            if ($this->session->userdata('cliente_id') !== NULL) { // @TODO: Buscar las compras usando los datos de $this->session->userdata('compra_temp_ids')
                $compra_ids = explode('/', $this->session->userdata('compra_temp_ids'));
                foreach ($compra_ids as $compra_id) {
                    $data['ventas'][$compra_id] = $this->compra_model->getTempByCompraId($compra_id); // cliente_compra_temp
                }
                //$data['ventas'] = $this->compra_model->getTempByClienteId($this->session->userdata('cliente_id'));
                //echo "<pre>";print_r($data['ventas']);exit;
            }
            
            // echo "<pre>";print_r($data['datos_venta']);exit; ('cantidad' aparecia diferente a la original porque se modifica en vista_ok RESUELTO guardando la cantidad original antes de modificar la variable 07/11/15
            
            $data['vista'] = 'venta_ok2';
            
            $this->load->view('plantilla', $data);
        }
        
        public function do_vender() // Checkout del carrito. Cobrar todo lo que esta en carrito (viene desde venta_ok)
        {
            global $data;
            
            if (!empty($_POST['fecha_entrega'])) { // Si la fecha limite para entregar el pedido NO esta vacia entonces esto ES UN PEDIDO
                // @TODO
            }
            
            if ($_POST['producto_id']) { // $_POST['producto_id'] es el ID del producto y debe ser obtenido porque esta en un input oculto (hidden)
                $producto_id = $_POST['producto_id'];
            }
            else { // De lo contrario el programa termina porque es necesario el ID para hacer el update
                echo "ERROR: ID de producto no encontrado";
                exit;
            }
            
            $producto = $this->producto_model->obtener($producto_id);
            
            $producto[0]->cantidad -= $_POST['cantidad_vendida']; // Resta la cantidad vendida a la cantidad total del stock de dicho producto
            
            
            // Se guarda todo el $datos porque $producto[0] contiene campos como 'marca' y 'tipo', los cuales no estan incluidos en la tabla "producto"
            $datos = array('nombre'=>$producto[0]->nombre,
                                'precio'=>$producto[0]->precio,
                                'cantidad'=>$producto[0]->cantidad,
                                'tipo_id'=>$producto[0]->tipo_id,
                                'marca_id'=>$producto[0]->marca_id);
            
            $this->producto_model->update($datos, 'producto', $producto_id, 'producto_id');
            
            if ($_POST['descuento'] != 0) {
                $ganancia_total = $_POST['precio']*$_POST['cantidad_vendida'];
            }
            else { // Si el producto tiene descuento se aplica al precio: se multiplica la ganancia por el descuento dividido 100 (el descuento es en porcentaje) y este resultado luego se resta a la ganancia
                $descuento = ($_POST['precio']*$_POST['cantidad_vendida'])*($_POST['descuento']/100);
                $ganancia_total = ($_POST['precio']*$_POST['cantidad_vendida'])-$descuento;
            }
            
            $datos_venta = array('producto_id'=>$producto_id,
                                'cantidad_vendida'=>$_POST['cantidad_vendida'],
                                'precio_unidad'=>$_POST['precio'],
                                'ganancia_total'=>$ganancia_total);
            
            $venta_id = $this->producto_model->agregar($datos_venta, 'ventas'); // Agrega una nueva venta a la tabla "ventas" y guarda el nuevo ID
            
            $hora = "%H:%i:%s";
            $dia = "%Y-%m-%d";
            
            $registro_acciones = array('accion_id'=>4,
                                        'producto_id'=>$producto_id,
                                        'venta_id'=>$venta_id,       // Guarda el ID de la venta
                                        'hora'=>mdate($hora, time()),
                                        'dia'=>mdate($dia, time()));
            
// WRONG: Registrar accion en la funcion de cada accion (ej. do_editar, do_agregar, eliminar) y checar que campos fueron alterados (en las 2 primeras)
            
            $this->producto_model->agregar($registro_acciones, 'registro');
            
            redirect('producto/index');
        }
        
        public function eliminar() // @TODO: Guardar producto eliminado en tabla producto_del
        {
            global $data;
            
            $producto_id = $this->uri->segment(3);
            if (!$this->producto_model->borrar($producto_id)) {
                echo "El producto no pudo ser borrado";
                exit;
            }
            
            $hora = "%h:%i:%s";
            $dia = "%Y-%m-%d";
            
            $registro_acciones = array('accion_id'=>3,
                                        'producto_id'=>$producto_id,
                                        'hora'=>mdate($hora, time()),
                                        'dia'=>mdate($dia, time()));
                
            $this->producto_model->agregar($registro_acciones, 'registro');
            
            redirect('producto/index');
        }
}

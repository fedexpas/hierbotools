<?php
class Registro_model extends CI_Model {

    function agregar($datos=FALSE, $tabla='producto')
    {
        if ($datos) {
            $query = $this->db->insert($tabla, $datos);
            return $this->db->insert_id();
        }
        return FALSE;
    }
    
    function get($limit = 666)
    {
        $this->db->select('r.*, p.nombre as nombre_producto, a.nombre as accion_nombre, v.cantidad_vendida');
        $this->db->join('producto p', 'p.producto_id=r.producto_id', 'left');
        $this->db->join('acciones a', 'a.accion_id=r.accion_id', 'left');
        $this->db->join('ventas v', 'v.venta_id=r.venta_id', 'left');
        $this->db->order_by('r.dia', 'desc');
        $this->db->order_by('r.hora', 'desc');
        $query = $this->db->get('registro r', $limit);
        return $query->result();
    }
    
    function getVentas($limit = 666)
    {
        $this->db->select('r.hora, r.dia, r.registro_id , p.nombre as nombre_producto, v.cantidad_vendida');
        $this->db->join('registro r', 'r.venta_id=v.venta_id', 'left'); // relaciona por venta_id en lugar de producto_id
        $this->db->join('producto p', 'p.producto_id=v.producto_id', 'left');
        $this->db->order_by('r.dia', 'desc');
        $this->db->order_by('r.hora', 'desc');
        $query = $this->db->get_where('ventas v', 'r.venta_id != 0', $limit);
        return $query->result();
    }
}
<?php
class Compra_model extends CI_Model {

    function agregarCarrito($datos=FALSE) { // cliente_compra_temp
        if ($datos) {
            $query = $this->db->insert('cliente_compra_temp', $datos);
            return $this->db->insert_id();
        }
        else
            return FALSE;
    }
    
    function getTempByClienteID($cliente_id=FALSE) {
        if ($cliente_id) {
            $this->db->select('ccp.*, m.nombre as marca, t.nombre as tipo');
            $this->db->join('marca m', 'm.marca_id=ccp.marca_id');
            $this->db->join('tipo t', 't.tipo_id=ccp.tipo_id');
            $this->db->where(array('cliente_id'=>$cliente_id));
            $query = $this->db->get('cliente_compra_temp ccp');
            return $query->result();
        }
        return FALSE;
    }
    
    function getTempByCompraID($compra_id=FALSE) {
        if ($compra_id) {
            $this->db->select('ccp.*, m.nombre as marca, t.nombre as tipo');
            $this->db->join('marca m', 'm.marca_id=ccp.marca_id');
            $this->db->join('tipo t', 't.tipo_id=ccp.tipo_id');
            $this->db->where(array('compra_id'=>$compra_id));
            $query = $this->db->get('cliente_compra_temp ccp');
            return $query->result();
        }
        return FALSE;
    }
    
    
}
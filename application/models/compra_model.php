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
            $query = $this->db->get_where('cliente_compra_temp', array('cliente_id'=>$cliente_id));
            return $query->result();
        }
        return FALSE;
    }
    
    
}
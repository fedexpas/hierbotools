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
    
    
}
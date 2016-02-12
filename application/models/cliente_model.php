<?php
class Cliente_model extends CI_Model {

    function agregar($datos=FALSE) {
        if ($datos) {
            $query = $this->db->insert('cliente', $datos);
            return $this->db->insert_id();
        }
        else
            return FALSE;
    }
    
    function existe($datos) {
        if ($datos) {
            $query = $this->db->get_where('cliente', $datos);
            if ($query->num_rows() > 0)
                return $query->row();
        }
        return FALSE;
    }
    
}
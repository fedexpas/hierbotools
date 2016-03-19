<?php
class Producto_model extends CI_Model {

    function agregar($datos=FALSE, $tabla='producto')
    {
        if ($datos) {
            $query = $this->db->insert($tabla, $datos);
            return $this->db->insert_id();
        }
        return FALSE;
    }
    
    function update($datos=FALSE, $tabla='producto', $id=FALSE, $nombre_id='producto_id')
    {
        if ($datos && $id) {
            $this->db->where($nombre_id, $id);
            return $query = $this->db->update($tabla, $datos);
        }
    }
    
    function borrar($id=FALSE)
    {
        if ($id) {
            $this->db->where('producto_id', $id);
            return $this->db->delete('producto');
        }
        return FALSE;
    }
    
    function borrar_carrito($compra_id=FALSE, $producto_id=FALSE) { // cliente_compra_temp
        if ($compra_id && $producto_id) {
            $where = array('compra_id'=>$compra_id,
                            'producto_id'=>$producto_id);
            $this->db->where($where);
            return $this->db->delete('cliente_compra_temp');
        }
        return FALSE;
    }
    
    function obtener($id=FALSE) // IDIOTA
    {
        if($id!==FALSE) {
            if ($id == 'marcas') {
                $this->db->select('*');
                $query = $this->db->get('marca');
            }
            else if ($id == 'tipos') {
                $this->db->select('*');
                $query = $this->db->get('tipo');
            }
            else {
                $this->db->select('p.*, m.nombre as marca, t.nombre as tipo');
                $this->db->join('marca m', 'm.marca_id=p.marca_id', 'left');
                $this->db->join('tipo t', 't.tipo_id=p.tipo_id', 'left');
                if ($id != 'todo')
                    $this->db->where('p.producto_id', $id);
                $query = $this->db->get('producto p');
            }
            if ($query->num_rows()>0) {
                return $query->result();
            }
        }
    }
    
    function getMarca($id=FALSE) {
        if ($id !== FALSE) {
            $this->db->select('*');
            $this->db->where('marca_id', $id);
            $query = $this->db->get('marca');
            
            if ($query->num_rows()>0) {
                return $query->result();
            }
        }
    }
    
    function getTipo($id=FALSE) {
        if ($id !== FALSE) {
            $this->db->select('*');
            $this->db->where('tipo_id', $id);
            $query = $this->db->get('tipo');
            
            if ($query->num_rows()>0) {
                return $query->result();
            }
        }
    }
    
}
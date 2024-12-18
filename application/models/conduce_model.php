<?php

class Conduce_Model extends CI_Model { 
    
    public function __construct() {
        parent::__construct();
    }
   
    public function insertar_conduce($numero, $distancia_total, $distancia_carga, $carga_transportada, $trafico_producido, $id_recorrido){
        $data = array(
            'numero' => $numero,
            'distancia_total' => $distancia_total,
            'distancia_carga' => $distancia_carga,
            'carga_transportada' => $carga_transportada, 
            'trafico_producido' =>  $trafico_producido,
            'id_recorrido' => $id_recorrido
        );
        $this->db->insert('conduce', $data); 
    }
          
    public function eliminar_conduce($id_recorrido){
        if($id_recorrido){
            $this->db->where('id_recorrido', $id_recorrido);
            $this->db->delete('conduce');
        }
    }
   
    public function buscar_por_id($id_recorrido){
        $this->db->select('*');
        $this->db->from('conduce');
        $this->db->where('id_recorrido', $id_recorrido);
        $consulta = $this->db->get();
        $resultado = $consulta->result_array();
        return $resultado;
    }
        
    public function km_recorridos($id_recorrido){      
        $consulta = $this->db->query('SELECT SUM(distancia_total) AS distancia_total FROM conduce WHERE id_recorrido='.$id_recorrido.'.');  
        return $consulta->row();
    }

}
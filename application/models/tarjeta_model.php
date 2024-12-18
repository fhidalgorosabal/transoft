<?php

class Tarjeta_Model extends CI_Model { 
    
    public function __construct() {
        parent::__construct();
    }
    
    public function exportar_tarjetas($codigo, $combustible, $credito) {
	$campos = array(
            0 => array('nombre' => 'Codigo'),
            1 => array('nombre' => 'Combustible'),
            2 => array('nombre' => 'Crédito')
	);
        $this->db->select('codigo_tarjeta, combustible, credito');
        $this->db->from('tarjeta'); 
        $this->db->join('combustible', 'combustible.id_combustible=tarjeta.id_combustible');     
        if($codigo!='NULL')
            $this->db->like('codigo_tarjeta', $codigo);  
        if($combustible!='NULL')
            $this->db->like('combustible', $combustible); 
        if($credito!='NULL')
            $this->db->like('credito', $credito); 
        $this->db->order_by('codigo_tarjeta', 'asc');
        $consulta = $this->db->get();
	return array('fields' => $campos, 'query' => $consulta);
    }
   
    public function listar_tarjeta(){
        $this->db->select('*');
        $this->db->from('tarjeta');
        $this->db->join('combustible', 'combustible.id_combustible=tarjeta.id_combustible');  
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function buscar_tarjetas($codigo, $combustible, $credito){
        $this->db->select('*');
        $this->db->from('tarjeta');
        $this->db->join('combustible', 'combustible.id_combustible=tarjeta.id_combustible');       
        if($codigo!='')
            $this->db->like('codigo_tarjeta', $codigo);  
        if($combustible!='')
            $this->db->like('combustible', $combustible); 
        if($credito!='')
            $this->db->like('credito', $credito); 
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
   
    public function insertar_tarjeta($codigo_tarjeta, $id_combustible, $credito){
        $data = array(
            'codigo_tarjeta' => $codigo_tarjeta,
            'id_combustible' => $id_combustible,
            'credito' => $credito
        );
        $this->db->insert('tarjeta', $data); 
    }
   
    public function modificar_tarjeta($id_tarjeta, $codigo_tarjeta, $id_combustible, $credito){
        $data = array(
            'codigo_tarjeta' => $codigo_tarjeta,
            'id_combustible' => $id_combustible,
            'credito' => $credito
        );
        if($id_tarjeta){
           $this->db->where('id_tarjeta', $id_tarjeta);
           $this->db->update('tarjeta', $data);
        }
    }
    
    public function modificar_credito_tarjeta($id_tarjeta, $credito){
        $data = array(
            'credito' => $credito
        );
        if($id_tarjeta){
           $this->db->where('id_tarjeta', $id_tarjeta);
           $this->db->update('tarjeta', $data);
        }
    }
    
    public function eliminar_tarjeta($id_tarjeta){
        if($id_tarjeta){
            $this->db->where('id_tarjeta', $id_tarjeta);
            $this->db->delete('tarjeta');
        }
    }
    
    public function buscar_por_id($id_tarjeta){
       $this->db->select('*');
       $this->db->from('tarjeta');
       $this->db->where('id_tarjeta', $id_tarjeta);
        $this->db->join('combustible', 'combustible.id_combustible=tarjeta.id_combustible');  
       $consulta = $this->db->get();
       $resultado = $consulta->row();
       return $resultado;
    }
    
    public function buscar_por_codigo($codigo){
         $this->db->select('*');
         $this->db->from('tarjeta');
         $this->db->where('codigo_tarjeta', $codigo);
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }
    
    public function buscar_por_codigo_id($codigo, $id_tarjeta){
         $this->db->select('*');
         $this->db->from('tarjeta');
         $this->db->where('codigo_tarjeta', $codigo);
         $this->db->where('id_tarjeta !=', $id_tarjeta);
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }
       
    public function buscar_tarjetas_de_carro($id_carro){
        $consulta = $this->db->query('SELECT t.* FROM tarjeta t, carro c, carro_tarjeta ct 
        WHERE t.id_tarjeta=ct.id_tarjeta AND c.id_carro=ct.id_carro AND c.id_carro='.$id_carro.'.');
        $resultado = $consulta->result();
        return $resultado;
    }
   
    public function buscar_no_tarjetas_de_carro($id_carro){
        $consulta = $this->db->query('SELECT t.* FROM tarjeta t
        WHERE NOT EXISTS (SELECT t.* FROM carro_tarjeta ct, carro c
        WHERE ct.id_carro=c.id_carro AND c.id_carro='.$id_carro.' AND ct.id_tarjeta = t.id_tarjeta)');
        $resultado = $consulta->result();
        return $resultado;
    }
   
    public function cant_tarjetas() {        
        return $this->db->count_all('tarjeta');
    }    
          
    public function es_usada($id_tarjeta){      
        $consulta = $this->db->query('SELECT ca.id_carro AS en_uso FROM carro ca, tarjeta t, carro_tarjeta ct
        WHERE ca.id_carro=ct.id_carro AND t.id_tarjeta=ct.id_tarjeta AND t.id_tarjeta='.$id_tarjeta.' LIMIT 1');  
        $resultado = $consulta->row();
        return $resultado;
    }

}
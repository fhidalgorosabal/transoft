<?php

class Ayudante_Model extends CI_Model { 
    
    public function __construct() {
        parent::__construct();
    }
    
    public function exportar_ayudante($ci, $nombre, $apellidos) {
	$campos = array(
            0 => array('nombre' => 'CI'),
            1 => array('nombre' => 'Nombre'),
            2 => array('nombre' => 'Apellidos')
	);
        $this->db->select('ci, nombre_ayd, apellidos');
        $this->db->from('ayudante');  
        $this->db->where('id_ayudante !=', '1');
        $this->db->where('baja', '0');         
        if($ci!='NULL')
            $this->db->like('ci', $ci);        
        if($nombre!='NULL')
            $this->db->like('nombre_ayd', $nombre);  
        if($apellidos!='NULL')
            $this->db->like('apellidos', $apellidos); 
        $this->db->order_by('ci', 'asc');
        $consulta = $this->db->get();
	return array('fields' => $campos, 'query' => $consulta);
    }
   
    public function listar_ayudante(){
        $this->db->select('*');
        $this->db->from('ayudante');
        $this->db->where('id_ayudante !=', '1');
        $this->db->where('baja', '0');
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function buscar_ayudantes($ci, $nombre, $apellidos){
        $this->db->select('*');
        $this->db->from('ayudante');     
        $this->db->where('id_ayudante !=', '1');
        $this->db->where('baja', '0');      
        if($ci!='')
            $this->db->like('ci', $ci);        
        if($nombre!='')
            $this->db->like('nombre_ayd', $nombre);  
        if($apellidos!='')
            $this->db->like('apellidos', $apellidos);     
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
       
    public function exportar_bajas(){
        $campos = array(
            0 => array('nombre' => 'CI'),
            1 => array('nombre' => 'Nombre'),
            2 => array('nombre' => 'Apellidos')
	);
        $this->db->select('ci, nombre_ayd, apellidos');
        $this->db->from('ayudante');
        $this->db->where('id_ayudante !=', '1');
        $this->db->where('baja', '1');
        $this->db->order_by('ci', 'asc');
        $consulta = $this->db->get();
	return array('fields' => $campos, 'query' => $consulta);
    }
   
    public function listar_bajas(){
        $this->db->select('*');
        $this->db->from('ayudante');
        $this->db->where('id_ayudante !=', '1');
        $this->db->where('baja', '1');
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
   
    public function insertar_ayudante($ci, $nombre, $apellidos){
        $data = array(
            'ci' => $ci,
            'nombre_ayd' => $nombre,
            'apellidos' => $apellidos,
            'baja' => '0'
        );
        $this->db->insert('ayudante', $data); 
    }
   
    public function modificar_ayudante($id_ayudante, $ci, $nombre, $apellidos){
        $data = array(
            'ci' => $ci,
            'nombre_ayd' => $nombre,
            'apellidos' => $apellidos
        );
        $this->db->where('id_ayudante', $id_ayudante);
        $this->db->update('ayudante', $data);
    }
    
    public function baja_ayudante($id_ayudante){
        $data['baja']='1';
        $this->db->where('id_ayudante', $id_ayudante);
        $this->db->update('ayudante', $data);
    }
    
    public function restaurar_ayudante($id_ayudante){
        $data['baja']='0';
        $this->db->where('id_ayudante', $id_ayudante);
        $this->db->update('ayudante', $data);
    }
    
    public function eliminar_ayudante($id_ayudante){
        $this->db->where('id_ayudante', $id_ayudante);
        $this->db->delete('ayudante');
    }

    public function buscar_por_id($id_ayudante){
         $this->db->select('*');
         $this->db->from('ayudante');
         $this->db->where('id_ayudante', $id_ayudante);
         $this->db->where('baja', '0');
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }
    
    public function buscar_por_ci($ci){
         $this->db->select('*');
         $this->db->from('ayudante');
         $this->db->where('ci', $ci);
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }
    
    public function buscar_por_ci_id($ci, $id_ayudante){
         $this->db->select('*');
         $this->db->from('ayudante');
         $this->db->where('ci', $ci);
         $this->db->where('id_ayudante !=', $id_ayudante);
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }
    
    public function cant_ayudantes() {  
        $this->db->from('ayudante');
        $this->db->where('id_ayudante !=', '1');
        $this->db->where('baja', '0');
        return $this->db->count_all_results();
    }    
          
    public function es_usado($d_ayudante){      
        $consulta = $this->db->query('SELECT id_recorrido AS en_uso FROM recorrido WHERE id_ayudante='.$d_ayudante.' LIMIT 1');  
        $resultado = $consulta->row();
        return $resultado;
    }

}
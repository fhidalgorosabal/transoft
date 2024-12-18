<?php

class Chofer_Model extends CI_Model { 
    
    public function __construct() {
        parent::__construct();
    }
    
    public function exportar_chofer($ci, $nombre, $apellidos, $licencia) {
	$campos = array(
            0 => array('nombre' => 'CI'),
            1 => array('nombre' => 'Nombre'),
            2 => array('nombre' => 'Apellidos'),
            3 => array('nombre' => 'Licencia')
	);
        $this->db->select('ci, nombre_chf, apellidos, codigo_licencia');
        $this->db->from('chofer');             
        $this->db->where('baja', '0'); 
        $this->db->join('licencia', 'licencia.id_licencia=chofer.id_licencia');      
        if($ci!='NULL')
            $this->db->like('ci', $ci);        
        if($nombre!='NULL')
            $this->db->like('nombre_chf', $nombre);  
        if($apellidos!='NULL')
            $this->db->like('apellidos', $apellidos); 
        if($licencia!='NULL')
            $this->db->like('codigo_licencia', $licencia); 
        $this->db->order_by('ci', 'asc'); 
        $consulta = $this->db->get();
	return array('fields' => $campos, 'query' => $consulta);
    }
   
    public function listar_chofer(){
        $this->db->select('*');
        $this->db->from('chofer');
        $this->db->where('baja', '0');
        $this->db->join('licencia', 'licencia.id_licencia=chofer.id_licencia'); 
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function buscar_choferes($ci, $nombre, $apellidos, $licencia){
        $this->db->select('*');
        $this->db->from('chofer');             
        $this->db->where('baja', '0'); 
        $this->db->join('licencia', 'licencia.id_licencia=chofer.id_licencia');       
        if($ci!='')
            $this->db->like('ci', $ci);        
        if($nombre!='')
            $this->db->like('nombre_chf', $nombre);  
        if($apellidos!='')
            $this->db->like('apellidos', $apellidos); 
        if($licencia!='')
            $this->db->like('codigo_licencia', $licencia); 
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
       
    public function exportar_bajas(){
        $campos = array(
            0 => array('nombre' => 'CI'),
            1 => array('nombre' => 'Nombre'),
            2 => array('nombre' => 'Apellidos'),
            3 => array('nombre' => 'Licencia')
	);
        $this->db->select('ci, nombre_chf, apellidos, codigo_licencia');
        $this->db->from('chofer');
        $this->db->where('baja', '1');
        $this->db->join('licencia', 'licencia.id_licencia=chofer.id_licencia');
        $this->db->order_by('ci', 'asc');
        $consulta = $this->db->get();
	return array('fields' => $campos, 'query' => $consulta);
    }
    
    public function listar_bajas(){
        $this->db->select('*');
        $this->db->from('chofer');
        $this->db->where('baja', '1');
        $this->db->join('licencia', 'licencia.id_licencia=chofer.id_licencia'); 
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
   
    public function insertar_chofer($ci, $nombre, $apellidos, $id_licencia){
        $data = array(
            'ci' => $ci,
            'nombre_chf' => $nombre,
            'apellidos' => $apellidos,
            'id_licencia' => $id_licencia,
            'baja' => '0'
        );
        $this->db->insert('chofer', $data); 
    }
   
    public function modificar_chofer($id_chofer, $ci, $nombre, $apellidos, $id_licencia){
        $data = array(
            'ci' => $ci,
            'nombre_chf' => $nombre,
            'apellidos' => $apellidos,
            'id_licencia' => $id_licencia
        );
        $this->db->where('id_chofer', $id_chofer);
        $this->db->update('chofer', $data);
    }
    
    public function baja_chofer($id_chofer){
        $data['baja']='1';
        $this->db->where('id_chofer', $id_chofer);
        $this->db->update('chofer', $data);
    }
    
    public function restaurar_chofer($id_chofer){
        $data['baja']='0';
        $this->db->where('id_chofer', $id_chofer);
        $this->db->update('chofer', $data);
    }
    
    public function eliminar_chofer($id_chofer){
        $this->db->where('id_chofer', $id_chofer);
        $this->db->delete('chofer');
   }
   
   public function buscar_por_id($id_chofer){
        $this->db->select('*');
        $this->db->from('chofer');
        $this->db->where('id_chofer', $id_chofer);
        $this->db->where('baja', '0');
        $this->db->join('licencia', 'licencia.id_licencia=chofer.id_licencia');  
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
   }
    
    public function buscar_por_ci($ci){
         $this->db->select('*');
         $this->db->from('chofer');
         $this->db->where('ci', $ci);
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }
    
    public function buscar_por_ci_id($ci, $id_chofer){
         $this->db->select('*');
         $this->db->from('chofer');
         $this->db->where('ci', $ci);
         $this->db->where('id_chofer !=', $id_chofer);
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }
    
    public function cant_choferes() {   
        $this->db->from('chofer');
        $this->db->where('baja', '0');
        return $this->db->count_all_results();
    }    
          
    public function es_usado($d_chofer){      
        $consulta = $this->db->query('SELECT id_recorrido AS en_uso FROM recorrido WHERE id_chofer='.$d_chofer.' LIMIT 1');  
        $resultado = $consulta->row();
        return $resultado;
    }

}
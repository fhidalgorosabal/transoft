<?php

class Actividad_Model extends CI_Model { 
    
    public function __construct() {
        parent::__construct();
    }
    
    public function exportar_actividades($nombre, $tipo_combustible, $estado) {
	$campos = array(
            0 => array('nombre' => 'Nombre'),
            1 => array('nombre' => 'Tipo Combustible'),
            2 => array('nombre' => 'Estado')
	);
        $this->db->select('nombre_act, tipo_combustible, estado');
        $this->db->from('actividad');
        $this->db->join('combustible', 'combustible.id_combustible=actividad.id_combustible');     
        if($nombre!='NULL')
            $this->db->like('nombre_act', $nombre);        
        if($tipo_combustible!='NULL')
            $this->db->like('tipo_combustible', $tipo_combustible);  
        if($estado!='NULL')
            $this->db->like('estado', $estado);         
        $this->db->order_by('nombre_act', 'asc');
        $consulta = $this->db->get();
	return array('fields' => $campos, 'query' => $consulta);
    }
    
    public function listar_all_actividad(){
        $this->db->select('*');
        $this->db->from('actividad');
        $this->db->join('combustible', 'combustible.id_combustible=actividad.id_combustible'); 
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
   
    public function listar_actividad(){
        $this->db->select('*');
        $this->db->from('actividad');
        $this->db->where('estado', 'Activa');
        $this->db->join('combustible', 'combustible.id_combustible=actividad.id_combustible'); 
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function buscar_actividades($nombre, $tipo_combustible, $estado){
        $this->db->select('*');
        $this->db->from('actividad'); 
        $this->db->join('combustible', 'combustible.id_combustible=actividad.id_combustible');     
        if($nombre!='')
            $this->db->like('nombre_act', $nombre);        
        if($tipo_combustible!='')
            $this->db->like('tipo_combustible', $tipo_combustible);  
        if($estado!='')
            $this->db->like('estado', $estado); 
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
        
    public function buscar_combustible_actividad_x_id($id){
        $this->db->select('actividad.id_combustible');
        $this->db->from('actividad');
        $this->db->where('id_actividad', $id);
        $this->db->where('estado', 'Activa');
        $this->db->join('combustible', 'combustible.id_combustible=actividad.id_combustible'); 
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
   
    public function insertar_actividad($nombre, $id_combustible){
        $data = array(
            'nombre_act' => $nombre,
            'id_combustible' => $id_combustible,
            'estado' => 'Activa'
        );
        $this->db->insert('actividad', $data); 
    }
   
    public function modificar_actividad($id_actividad, $nombre, $id_combustible, $estado){
        $data = array(
            'nombre_act' => $nombre,
            'id_combustible' => $id_combustible,
            'estado' => $estado
        );
        if($id_actividad){
           $this->db->where('id_actividad', $id_actividad);
           $this->db->update('actividad', $data);
        }
    }
    
    public function modificar_estado($id_actividad, $estado){
        $data = array(
            'estado' => $estado
        );
        if($id_actividad){
           $this->db->where('id_actividad', $id_actividad);
           $this->db->update('actividad', $data);
        }
    }
    
    public function eliminar_actividad($id_actividad){
        $this->db->where('id_actividad', $id_actividad);
        $this->db->delete('actividad');
    }
   
    public function buscar_por_id($id_actividad){
        $this->db->select('*');
        $this->db->from('actividad');
        $this->db->where('id_actividad', $id_actividad);
        $this->db->join('combustible', 'combustible.id_combustible=actividad.id_combustible');
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }

    public function buscar_id_actividad(){
        $this->db->select('id_actividad');
        $this->db->from('actividad');
        $this->db->limit(1);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function cant_actividades() { 
        $this->db->from('actividad');
        //$this->db->where('estado', 'Activa');
        return $this->db->count_all_results();
    } 
    
    public function es_usada($id_actividad){      
        $consulta = $this->db->query('SELECT id_recorrido AS en_uso FROM recorrido WHERE id_actividad='.$id_actividad.'');  
        $resultado = $consulta->row();
        return $resultado;
    }
}
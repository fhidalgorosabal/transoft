<?php

class Licencia_Model extends CI_Model { 
    
    public function __construct() {
        parent::__construct();
    }
    
    public function exportar_licencias($codigo, $fecha, $puntos) {
	$campos = array(
            0 => array('nombre' => 'Codigo'),
            1 => array('nombre' => 'Fecha Vencimiento'),
            2 => array('nombre' => 'Puntos Acumulados')
	);
        $this->db->select('codigo_licencia, fecha_vencimiento, puntos_acumulados');
        $this->db->from('licencia');     
        if($codigo!='NULL')
            $this->db->like('codigo_licencia', $codigo);        
        if($fecha!='NULL')
            $this->db->like('fecha_vencimiento', $fecha);  
        if($puntos!='NULL')
            $this->db->like('puntos_acumulados', $puntos);         
        $this->db->order_by('codigo_licencia', 'asc');
        $consulta = $this->db->get();
	return array('fields' => $campos, 'query' => $consulta);
    }
   
    public function listar_licencia(){
        $this->db->select('*');
        $this->db->from('licencia');
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function buscar_licencias($codigo, $fecha, $puntos){
        $this->db->select('*');
        $this->db->from('licencia');     
        if($codigo!='')
            $this->db->like('codigo_licencia', $codigo);        
        if($fecha!='')
            $this->db->like('fecha_vencimiento', $fecha);  
        if($puntos!='')
            $this->db->like('puntos_acumulados', $puntos); 
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
   
    public function insertar_licencia($codigo_licencia, $fecha_vencimiento, $puntos_acumulados){
        $data = array(
            'codigo_licencia' => $codigo_licencia,
            'fecha_vencimiento' => $fecha_vencimiento,
            'puntos_acumulados' => $puntos_acumulados
        );
        $this->db->insert('licencia', $data); 
    }
   
    public function modificar_licencia($id_licencia, $codigo_licencia, $fecha_vencimiento, $puntos_acumulados){
        $data = array(
            'codigo_licencia' => $codigo_licencia,
            'fecha_vencimiento' => $fecha_vencimiento,
            'puntos_acumulados' => $puntos_acumulados
        );
        if($id_licencia){
           $this->db->where('id_licencia', $id_licencia);
           $this->db->update('licencia', $data);
        }
    }
    
    public function eliminar_licencia($id_licencia){
      $this->db->where('id_licencia', $id_licencia);
      $this->db->delete('licencia');
    }

    public function buscar_por_id($id_licencia){
       $this->db->select('*');
       $this->db->from('licencia');
       $this->db->where('id_licencia', $id_licencia);
       $consulta = $this->db->get();
       $resultado = $consulta->row();
       return $resultado;
    }
    
    public function buscar_por_codigo($codigo){
         $this->db->select('*');
         $this->db->from('licencia');
         $this->db->where('codigo_licencia', $codigo);
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }
    
    public function buscar_por_codigo_id($codigo, $id_licencia){
         $this->db->select('*');
         $this->db->from('licencia');
         $this->db->where('codigo_licencia', $codigo);
         $this->db->where('id_licencia !=', $id_licencia);
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }
    
    public function cant_licencias() {        
        return $this->db->count_all('licencia');
    }    
          
    public function es_usada($id_licencia){      
        $consulta = $this->db->query('SELECT id_chofer AS en_uso FROM chofer WHERE id_licencia='.$id_licencia.'');  
        $resultado = $consulta->row();
        return $resultado;
    }

}
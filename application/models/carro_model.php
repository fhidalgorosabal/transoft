<?php

class Carro_Model extends CI_Model { 
    
    public function __construct() {
        parent::__construct();
    }
    
    public function exportar_carro($codigo, $chapa, $marca, $tipo, $estado, $tipo_combustible) {
	$campos = array(
            0 => array('nombre' => 'Codigo'),
            1 => array('nombre' => 'Chapa'),
            2 => array('nombre' => 'Tipo'),
            3 => array('nombre' => 'Capacidad'),
            4 => array('nombre' => 'Marca'),
            5 => array('nombre' => 'Año'),
            6 => array('nombre' => 'Estado Técnico'),
            7 => array('nombre' => 'Tipo de Combustible'),
            8 => array('nombre' => 'Norma de Consumo'),
            9 => array('nombre' => 'Capacidad Tanque')
	);
        $this->db->select('codigo,chapa,tipo,capacidad,marca,anno,estado_tecnico,tipo_combustible,norma_consumo,capacidad_tanque');
        $this->db->from('carro'); 
        $this->db->join('combustible', 'combustible.id_combustible=carro.id_combustible');         
        if($codigo!='NULL')
            $this->db->like('codigo', $codigo);        
        if($chapa!='NULL')
            $this->db->like('chapa', $chapa);  
        if($marca!='NULL')
            $this->db->like('marca', $marca); 
        if($tipo!='NULL')
            $this->db->like('tipo', $tipo);        
        if($estado!='NULL')
            $this->db->like('estado_tecnico', $estado);        
        if($tipo_combustible!='NULL')
            $this->db->like('tipo_combustible', $tipo_combustible);        
        $this->db->where('baja', '0');
        $this->db->order_by('codigo', 'asc');
        $consulta = $this->db->get();
	return array('fields' => $campos, 'query' => $consulta);
    }
   
    public function listar_carro(){
        $this->db->select('*');
        $this->db->from('carro');
        $this->db->where('baja', '0');
        $this->db->join('combustible', 'combustible.id_combustible=carro.id_combustible');  
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function listar_carros_buenos(){
        $consulta = $this->db->query("SELECT * FROM carro c WHERE c.estado_tecnico!='Malo' AND c.baja=0
        OR EXISTS (SELECT * FROM recorrido r WHERE r.id_carro=c.id_carro)");
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function buscar_carros($codigo, $chapa, $marca, $tipo, $estado, $tipo_combustible){
        $this->db->select('*');
        $this->db->from('carro');
        $this->db->join('combustible', 'combustible.id_combustible=carro.id_combustible');          
        if($codigo!='')
            $this->db->like('codigo', $codigo);        
        if($chapa!='')
            $this->db->like('chapa', $chapa);  
        if($marca!='')
            $this->db->like('marca', $marca); 
        if($tipo!='')
            $this->db->like('tipo', $tipo);        
        if($estado!='')
            $this->db->like('estado_tecnico', $estado);        
        if($tipo_combustible!='')
            $this->db->like('tipo_combustible', $tipo_combustible);        
        $this->db->where('baja', '0');
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
       
    public function exportar_bajas(){
        $campos = array(
            0 => array('nombre' => 'Codigo'),
            1 => array('nombre' => 'Chapa'),
            2 => array('nombre' => 'Tipo'),
            3 => array('nombre' => 'Capacidad'),
            4 => array('nombre' => 'Marca'),
            5 => array('nombre' => 'Año'),
            6 => array('nombre' => 'Estado Técnico'),
            7 => array('nombre' => 'Tipo de Combustible'),
            8 => array('nombre' => 'Norma de Consumo'),
            9 => array('nombre' => 'Capacidad Tanque')
	);
        $this->db->select('codigo,chapa,tipo,capacidad,marca,anno,estado_tecnico,tipo_combustible,norma_consumo,capacidad_tanque');
        $this->db->from('carro'); 
        $this->db->where('baja', '1');
        $this->db->join('combustible', 'combustible.id_combustible=carro.id_combustible');  
        $this->db->order_by('codigo', 'asc');
        $consulta = $this->db->get();
	return array('fields' => $campos, 'query' => $consulta);
    }
   
    public function listar_bajas(){
        $this->db->select('*');
        $this->db->from('carro');
        $this->db->where('baja', '1');
        $this->db->join('combustible', 'combustible.id_combustible=carro.id_combustible');  
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function buscar_carro_x_combustible($id_combustible){
        $this->db->select('carro.*');
        $this->db->from('carro');
        $this->db->where('carro.id_combustible', $id_combustible);
        $this->db->where('estado_tecnico !=', 'Malo');
        $this->db->where('baja', '0');
        $this->db->join('combustible', 'combustible.id_combustible=carro.id_combustible');  
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
   
    public function insertar_carro($codigo, $chapa, $tipo, $capacidad, $marca, $anno, $estado_tecnico, $id_combustible, $norma_consumo, $capacidad_tanque){
        $data = array(
            'codigo' => $codigo,
            'chapa' => $chapa,
            'tipo' => $tipo,
            'capacidad' => $capacidad,
            'marca' => $marca,
            'anno' => $anno,
            'estado_tecnico' => $estado_tecnico,
            'id_combustible' => $id_combustible,
            'norma_consumo' => $norma_consumo,
            'capacidad_tanque' => $capacidad_tanque,
            'baja' => '0'
        );
        $this->db->insert('carro', $data); 
    }
   
    public function modificar_carro($id_carro, $codigo, $chapa, $tipo, $capacidad, $marca, $anno, $estado_tecnico, $id_combustible, $norma_consumo, $capacidad_tanque){
        $data = array(
            'codigo' => $codigo,
            'chapa' => $chapa,
            'tipo' => $tipo,
            'capacidad' => $capacidad,
            'marca' => $marca,
            'anno' => $anno,
            'estado_tecnico' => $estado_tecnico,
            'id_combustible' => $id_combustible,
            'norma_consumo' => $norma_consumo,
            'capacidad_tanque' => $capacidad_tanque
        );
        $this->db->where('id_carro', $id_carro);
        $this->db->update('carro', $data);
    }
    
    public function baja_carro($id_carro){
        $data['baja']='1';
        $this->db->where('id_carro', $id_carro);
        $this->db->update('carro', $data);
    }
    
    public function restaurar_carro($id_carro){
        $data['baja']='0';
        $this->db->where('id_carro', $id_carro);
        $this->db->update('carro', $data);
    }
    
    public function eliminar_carro($id_carro){
        $this->db->where('id_carro', $id_carro);
        $this->db->delete('carro');
    }

    public function buscar_por_id($id_carro){
        $this->db->select('*');
        $this->db->from('carro');
        $this->db->where('id_carro', $id_carro);
        $this->db->where('baja', '0');
        $this->db->join('combustible', 'combustible.id_combustible=carro.id_combustible');  
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function buscar_por_codigo_chapa($codigo, $chapa){
         $this->db->select('*');
         $this->db->from('carro');
         $this->db->where('codigo', $codigo);
         $this->db->or_where('chapa', $chapa);
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }
    
    public function buscar_por_codigo_chapa_id($codigo, $chapa, $id_carro){
         $this->db->select('*');
         $this->db->from('carro');
         $cadena = "(codigo=".$codigo." OR chapa='".$chapa."') AND id_carro!=".$id_carro."";
         $this->db->where($cadena);
         $consulta = $this->db->get();
         $resultado = $consulta->row();
         return $resultado;
    }

    public function buscar_id_carro(){
        $this->db->select('id_carro');
        $this->db->from('carro');
        $this->db->where('estado_tecnico !=', 'Malo');
        $this->db->where('baja', '0');
        $this->db->limit(1);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function avg_capacidad_carro(){
        $this->db->select_avg('capacidad');
        $this->db->from('carro');
        $this->db->where('estado_tecnico !=', 'Malo');
        $this->db->where('baja', '0');
        $this->db->limit(1);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function cant_carros() { 
        $this->db->from('carro');
        $this->db->where('baja', '0');
        return $this->db->count_all_results();
    }  
    
    public function tiene_tarjeta($id_carro){      
        $consulta = $this->db->query('SELECT ca.id_carro AS en_uso FROM carro ca, tarjeta t, carro_tarjeta ct
        WHERE ca.id_carro=ct.id_carro AND t.id_tarjeta=ct.id_tarjeta AND ca.id_carro='.$id_carro.' LIMIT 1');  
        $resultado = $consulta->row();
        return $resultado;
    }
          
    public function es_usado($id_carro){      
        $consulta = $this->db->query('SELECT id_recorrido AS en_uso FROM recorrido WHERE id_carro='.$id_carro.' LIMIT 1');  
        $resultado = $consulta->row();
        return $resultado;
    }

}
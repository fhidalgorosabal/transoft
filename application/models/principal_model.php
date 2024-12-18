<?php

class Principal_Model extends CI_Model { 
    
    public function __construct() {
        parent::__construct();
    }
        
    public function mes_procesar() {      
        $this->db->select('*');
        $this->db->from('indicador_mes');
        $this->db->limit(1);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function indicadores_mes() {      
        $consulta = $this->db->query("SELECT i.*,
        (SELECT COUNT(ca.id_carro) FROM carro ca) AS carros_existentes_r,
        (SELECT COUNT(ca.id_carro) FROM carro ca WHERE ca.estado_tecnico!='Malo') AS carros_trabajando_r
        FROM indicador_mes i LIMIT 1");  
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function indicadores_acumulado($mes, $anno) { 
        $this->db->select('*');
        $this->db->from('indicador_acumulado');
        $this->db->where('mes', $mes);
        $this->db->where('anno', $anno);
        $this->db->limit(1);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function anno(){      
        $this->db->select('anno');
        $this->db->from('indicador_mes');
        $this->db->limit(1);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function modificar_mes($data){
        if($data != NULL) {
            $this->db->where('id_indicador', 1);
            $this->db->update('indicador_mes', $data);
        }
    }
    
    public function adicionar_acumulado($data){
        if($data != NULL) {
            $this->db->insert('indicador_acumulado', $data);
        }
    }

}
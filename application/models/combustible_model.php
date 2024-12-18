<?php

class Combustible_Model extends CI_Model { 
    
    public function __construct() {
        parent::__construct();
    }
    
    public function listar_combustible(){
        $this->db->select('*');
        $this->db->from('combustible');
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function listar_habilitados($fecha){
        $consulta = $this->db->query("SELECT h.id_habilitar, h.fecha, c.chapa, t.codigo_tarjeta, r.numero_hoja_ruta,
        h.cantidad_combustible FROM habilitar h, carro c, tarjeta t, recorrido r 
        WHERE h.id_carro=c.id_carro AND h.id_tarjeta=t.id_tarjeta AND h.id_recorrido=r.id_recorrido AND
        h.fecha BETWEEN '".$fecha['anno'].'-'.$fecha['mes'].'-01'."' AND '".$fecha['anno'].'-'.$fecha['mes'].'-'.$fecha['max_dias']."'");
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function habilitar($cantidad_combustible, $fecha, $id_carro, $id_tarjeta, $id_recorrido){
        $data = array(
            'cantidad_combustible' => $cantidad_combustible,
            'fecha' => $fecha,
            'id_carro' => $id_carro,
            'id_tarjeta' => $id_tarjeta,
            'id_recorrido' => $id_recorrido
        );
        $this->db->insert('habilitar', $data); 
    }
    
    public function eliminar_habilitado($id_habilitar) {
        if($id_habilitar){
            $this->db->where('id_habilitar', $id_habilitar);
            $this->db->delete('habilitar');
        }
    }
    
    public function eliminar_asignacion_carro($id_carro) {
        if($id_carro){
            $this->db->where('id_carro', $id_carro);
            $this->db->delete('carro_tarjeta');
        }
    }
    
    public function asignar_tarjetas($id_carro, $id_tarjeta) {
        $data = array(
            'id_carro' => $id_carro,
            'id_tarjeta' => $id_tarjeta
        );
        $this->db->insert('carro_tarjeta', $data); 
    }
    
    public function modificar_precio_combustible($id_combustible, $precio){
        if($id_combustible != NULL) {
            $data['precio_combustible'] = $precio;
            $this->db->where('id_combustible', $id_combustible);
            $this->db->update('combustible', $data);
        }
    }
    
    public function precio_combustible(){      
        $this->db->select('precio_combustible');
        $this->db->from('combustible');
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function ultima_fecha(){
        $consulta = $this->db->query('SELECT DISTINCT YEAR(fecha) AS anno FROM habilitar ORDER BY fecha DESC');
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function consumo_combustible_carro($id_carro, $fecha) {
        $consulta = $this->db->query("SELECT SUM(h.cantidad_combustible) AS combustible
        FROM habilitar h WHERE h.id_carro=".$id_carro." AND h.fecha='".$fecha."'");
        $resultado = $consulta->row();
        return $resultado;
    }
 
}
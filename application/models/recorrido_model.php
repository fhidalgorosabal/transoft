<?php

class Recorrido_Model extends CI_Model { 
    
    public function __construct() {
        parent::__construct();
    }
    
    public function buscar_recorrido($id_actividad, $id_carro, $fecha){
        $consulta = $this->db->query("SELECT r.*,
        (SELECT SUM(c.distancia_total) FROM conduce c WHERE c.id_recorrido=r.id_recorrido) AS distancia_total,
        (SELECT SUM(c.distancia_carga) FROM conduce c WHERE c.id_recorrido=r.id_recorrido) AS distancia_carga,
        (SELECT SUM(c.carga_transportada) FROM conduce c WHERE c.id_recorrido=r.id_recorrido) AS carga_transportada,
        (SELECT SUM(c.trafico_producido) FROM conduce c WHERE c.id_recorrido=r.id_recorrido) AS trafico_producido, 
        ca.capacidad
        FROM recorrido r, carro ca WHERE r.id_carro=ca.id_carro
        AND r.id_carro=".$id_carro." AND r.id_actividad=".$id_actividad."
        AND fecha BETWEEN '".$fecha['anno'].'-'.$fecha['mes'].'-01'."' AND '".$fecha['anno'].'-'.$fecha['mes'].'-'.$fecha['max_dias']."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }
    
    public function buscar_recorrido_carro($id_carro, $fecha){
        $consulta = $this->db->query("SELECT r.id_recorrido, r.fecha, r.numero_hoja_ruta FROM recorrido r, carro ca 
        WHERE r.id_carro=ca.id_carro AND r.id_carro=".$id_carro." 
        AND fecha BETWEEN '".$fecha['anno'].'-'.$fecha['mes'].'-01'."' AND '".$fecha['anno'].'-'.$fecha['mes'].'-'.$fecha['max_dias']."'    
        AND NOT EXISTS (SELECT * FROM habilitar h WHERE h.id_recorrido = r.id_recorrido)");
        $resultado = $consulta->result_array();
        return $resultado;
    }
    
    public function cargas_transportadas_chofer($id_chofer, $id_actividad, $fecha){
        $consulta = $this->db->query("SELECT r.id_ayudante,
        (SELECT SUM(c.carga_transportada) FROM conduce c WHERE c.id_recorrido=r.id_recorrido) AS carga_transportada 
        FROM recorrido r WHERE r.id_chofer=".$id_chofer." AND r.id_actividad=".$id_actividad." 
        AND fecha BETWEEN '".$fecha['anno'].'-'.$fecha['mes'].'-01'."' AND '".$fecha['anno'].'-'.$fecha['mes'].'-'.$fecha['max_dias']."'");
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function cargas_transportadas_ayudante($id_ayudante, $id_actividad, $fecha){
        $consulta = $this->db->query("SELECT
        SUM((SELECT SUM(c.carga_transportada) FROM conduce c WHERE c.id_recorrido=r.id_recorrido)) AS carga_transportada 
        FROM recorrido r WHERE r.id_ayudante=".$id_ayudante." AND r.id_actividad=".$id_actividad." 
        AND fecha BETWEEN '".$fecha['anno'].'-'.$fecha['mes'].'-01'."' AND '".$fecha['anno'].'-'.$fecha['mes'].'-'.$fecha['max_dias']."' LIMIT 1");
        $resultado = $consulta->row();
        return $resultado;
    }
        
    public function captar_recorrido($id_recorrido, $fecha, $numero_hoja_ruta, $viajes_carga, $consumo_combustible, $id_actividad, $id_carro, $id_chofer, $id_ayudante){
        $data = array(
            'id_recorrido' => $id_recorrido,
            'fecha' => $fecha,
            'numero_hoja_ruta' => $numero_hoja_ruta,
            'viajes_carga' => $viajes_carga,
            'combustible_habilitado' => '0',
            'consumo_combustible' => $consumo_combustible,
            'id_actividad' => $id_actividad, 
            'id_carro' => $id_carro,
            'id_chofer' => $id_chofer,
            'id_ayudante' => $id_ayudante
        );
        $this->db->insert('recorrido', $data); 
    }
        
    public function modificar_recorrido($id_recorrido, $fecha, $numero_hoja_ruta, $viajes_carga, $consumo_combustible, $id_actividad, $id_carro, $id_chofer, $id_ayudante){
        $data = array(
            'fecha' => $fecha,
            'numero_hoja_ruta' => $numero_hoja_ruta,
            'viajes_carga' => $viajes_carga,
            'consumo_combustible' => $consumo_combustible,
            'id_actividad' => $id_actividad, 
            'id_carro' => $id_carro,
            'id_chofer' => $id_chofer,
            'id_ayudante' => $id_ayudante
        );
        $this->db->where('id_recorrido', $id_recorrido);
        $this->db->update('recorrido', $data);
    }
       
    public function modificar_combustible($id_recorrido, $combustible){
        $data = array(
            'consumo_combustible' => $combustible,
            'combustible_habilitado' => $combustible
        );
        $this->db->where('id_recorrido', $id_recorrido);
        $this->db->update('recorrido', $data);
    }
    
    /*public function contar_recorrido(){      
        $consulta = $this->db->query('SELECT MAX(id_recorrido)AS num FROM recorrido');  
        if($consulta->row())
            return TRUE; 
        return FALSE;
    }*/
          
    public function eliminar_recorrido($id_recorrido){
        if($id_recorrido){
            $this->db->where('id_recorrido', $id_recorrido);
            $this->db->delete('recorrido');
        }
    }
    
    public function ver_recorrido($id_recorrido){
        $consulta = $this->db->query('SELECT DISTINCT r.*,
         ca.capacidad_tanque AS combustible_tanque,   
        (SELECT SUM(c.distancia_total) FROM conduce c WHERE c.id_recorrido=r.id_recorrido) AS distancia_total,
        (SELECT SUM(c.distancia_carga) FROM conduce c WHERE c.id_recorrido=r.id_recorrido) AS distancia_carga,
        (SELECT SUM(c.carga_transportada) FROM conduce c WHERE c.id_recorrido=r.id_recorrido) AS carga_transportada,
        (SELECT SUM(c.trafico_producido) FROM conduce c WHERE c.id_recorrido=r.id_recorrido) AS trafico_producido,
        ca.capacidad, ca.chapa, a.nombre_act, ch.nombre_chf, ay.nombre_ayd  
        FROM recorrido r, carro ca, actividad a, chofer ch, ayudante ay 
        WHERE r.id_carro=ca.id_carro AND r.id_chofer=ch.id_chofer AND r.id_ayudante=ay.id_ayudante 
        AND r.id_actividad=a.id_actividad AND r.id_recorrido='.$id_recorrido.'.');
        $resultado = $consulta->row();
        return $resultado;
    }
   
    public function configuracion($id_actividad){
        $this->db->select('*');
        $this->db->from('configuracion');
        $this->db->where('id_actividad', $id_actividad);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function guardar_configuracion($fecha, $numero_hoja_ruta, $viajes_carga, $consumo_combustible, $conduce, $distancia_total, $distancia_carga, $carga_transportada, $carro, $chofer, $ayudante, $id_actividad, $id_configuracion=null){
      $data = array(
         'fecha' => $fecha,
         'numero_hoja_ruta' => $numero_hoja_ruta,
         'viajes_carga' => $viajes_carga,          
         'consumo_combustible' => $consumo_combustible,
         'conduce' => $conduce,
         'distancia_total' => $distancia_total,
         'distancia_carga' => $distancia_carga,
         'carga_transportada' => $carga_transportada,
         'carro' => $carro,
         'chofer' => $chofer,
         'ayudante' => $ayudante 
      );
      if($id_configuracion!='' && $id_configuracion!=NULL){
         $this->db->where('id_configuracion', $id_configuracion);
         $this->db->update('configuracion', $data);
      }else{
         $data['id_actividad'] = $id_actividad;
         $this->db->insert('configuracion', $data);
      } 
   }
        
    public function contar_recorrido(){      
        $consulta = $this->db->query('SELECT MAX(id_recorrido)AS num FROM recorrido');  
        return $consulta->row();
    }
    
    public function hay_recorrido($fecha){
        $consulta = $this->db->query("SELECT COUNT(*) AS cont FROM recorrido WHERE fecha BETWEEN '".$fecha['anno'].'-'.$fecha['mes'].'-01'."' AND '".$fecha['anno'].'-'.$fecha['mes'].'-'.$fecha['max_dias']."'");  
        return $consulta->row();
    }
   
    public function ultima_fecha(){
        $consulta = $this->db->query('SELECT DISTINCT YEAR(fecha) AS anno FROM recorrido ORDER BY fecha DESC');
        $resultado = $consulta->result();
        return $resultado;
    }
    
    public function reporte_recorrido($fecha) {
        $fecha_str="AND fecha BETWEEN '".$fecha['anno'].'-'.$fecha['mes'].'-01'."' AND '".$fecha['anno'].'-'.$fecha['mes'].'-'.$fecha['max_dias']."'";
        $consulta = $this->db->query("SELECT DISTINCT ca.codigo, ca.chapa, ca.capacidad, ca.norma_consumo, ca.capacidad_tanque,
            (SELECT SUM(r.viajes_carga) FROM recorrido r WHERE r.id_carro=ca.id_carro ".$fecha_str.")AS viajes_realizados,
            (SELECT SUM(c.distancia_total)FROM recorrido r, conduce c WHERE 
            c.id_recorrido=r.id_recorrido AND r.id_carro=ca.id_carro ".$fecha_str.") AS distancia_total,
            (SELECT SUM(c.distancia_carga)FROM recorrido r, conduce c WHERE
            c.id_recorrido=r.id_recorrido AND r.id_carro=ca.id_carro ".$fecha_str.") AS distancia_carga,
            (SELECT SUM(c.carga_transportada)FROM recorrido r, conduce c WHERE
            c.id_recorrido=r.id_recorrido AND r.id_carro=ca.id_carro ".$fecha_str.") AS carga_transportada,
            (SELECT SUM(c.trafico_producido)FROM recorrido r, conduce c WHERE
            c.id_recorrido=r.id_recorrido AND r.id_carro=ca.id_carro ".$fecha_str.") AS trafico_producido,
            (SELECT SUM(r.combustible_habilitado) FROM recorrido r WHERE r.id_carro=ca.id_carro ".$fecha_str.") AS combustible_habilitado,
            (SELECT SUM(r.consumo_combustible) FROM recorrido r WHERE r.id_carro=ca.id_carro ".$fecha_str.") AS consumo_combustible
        FROM carro ca WHERE ca.estado_tecnico!='Malo' AND ca.baja=0
        OR EXISTS (SELECT * FROM recorrido r WHERE r.id_carro=ca.id_carro)");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    public function reporte_x_actividad($id_actividad, $fecha) {
        $fecha_str="AND fecha BETWEEN '".$fecha['anno'].'-'.$fecha['mes'].'-01'."' AND '".$fecha['anno'].'-'.$fecha['mes'].'-'.$fecha['max_dias']."'";
        $consulta = $this->db->query("SELECT DISTINCT ca.codigo, ca.chapa, ca.capacidad, ca.norma_consumo, ca.capacidad_tanque,
            (SELECT SUM(r.viajes_carga) FROM recorrido r WHERE r.id_carro=ca.id_carro ".$fecha_str." AND r.id_actividad=".$id_actividad.")AS viajes_realizados,
            (SELECT SUM(c.distancia_total)FROM recorrido r, conduce c WHERE 
            c.id_recorrido=r.id_recorrido AND r.id_carro=ca.id_carro ".$fecha_str." AND r.id_actividad=".$id_actividad.") AS distancia_total,
            (SELECT SUM(c.distancia_carga)FROM recorrido r, conduce c WHERE
            c.id_recorrido=r.id_recorrido AND r.id_carro=ca.id_carro ".$fecha_str." AND r.id_actividad=".$id_actividad.") AS distancia_carga,
            (SELECT SUM(c.carga_transportada)FROM recorrido r, conduce c WHERE
            c.id_recorrido=r.id_recorrido AND r.id_carro=ca.id_carro ".$fecha_str." AND r.id_actividad=".$id_actividad.") AS carga_transportada,
            (SELECT SUM(c.trafico_producido)FROM recorrido r, conduce c WHERE
            c.id_recorrido=r.id_recorrido AND r.id_carro=ca.id_carro ".$fecha_str." AND r.id_actividad=".$id_actividad.") AS trafico_producido,
            (SELECT SUM(r.combustible_habilitado) FROM recorrido r WHERE r.id_carro=ca.id_carro ".$fecha_str." AND r.id_actividad=".$id_actividad.") AS combustible_habilitado,
            (SELECT SUM(r.consumo_combustible) FROM recorrido r WHERE r.id_carro=ca.id_carro ".$fecha_str." AND r.id_actividad=".$id_actividad.") AS consumo_combustible
        FROM carro ca, actividad a WHERE ca.id_combustible=a.id_combustible AND a.id_actividad=".$id_actividad."
        AND ca.estado_tecnico!='Malo' AND ca.baja=0
        OR EXISTS (SELECT * FROM recorrido r WHERE r.id_carro=ca.id_carro AND r.id_actividad=".$id_actividad.")");
        $resultado = $consulta->result_array();
        return $resultado;
    }
    
    public function indicadores_recorrido($fecha) {
        $fecha_str="r.fecha BETWEEN '".$fecha['anno'].'-'.$fecha['mes'].'-01'."' AND '".$fecha['anno'].'-'.$fecha['mes'].'-'.$fecha['max_dias']."'";
        $consulta = $this->db->query("SELECT 
            SUM((SELECT SUM(c.carga_transportada) FROM conduce c WHERE c.id_recorrido=r.id_recorrido)) AS carga_transportada_r,
            SUM((SELECT SUM(r2.viajes_carga) FROM recorrido r2 WHERE r2.id_recorrido=r.id_recorrido)) AS viajes_carga_r,
            SUM((SELECT SUM(c.trafico_producido) FROM conduce c WHERE c.id_recorrido=r.id_recorrido)) AS trafico_r,
            SUM((SELECT SUM(c.distancia_total) FROM conduce c WHERE c.id_recorrido=r.id_recorrido)) AS distancia_total_r,
            SUM((SELECT SUM(c.distancia_carga) FROM conduce c WHERE c.id_recorrido=r.id_recorrido)) AS distancia_carga_r,
            SUM((SELECT SUM(r3.consumo_combustible) FROM recorrido r3 WHERE r3.id_recorrido=r.id_recorrido)) AS consumo_combustible_r
        FROM recorrido r WHERE ".$fecha_str."");
        $resultado = $consulta->row();
        return $resultado;
    }
}
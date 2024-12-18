<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

    public function __construct() {
	parent::__construct();
        $this->form_validation->set_message('required', 'El campo < %s > es obligatorio.');
        $this->form_validation->set_message('numeric', 'El campo < %s > solo admite n&uacute;meros.');
        $this->load->helper('date');
    }
    
    public function index() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');
        $this->load->view('header', $this->datos_header());
        $this->load->view('container', $this->datos_container());
        $this->load->view('footer', $this->datos_crumb());
    }
    
    public function datos_header() {
	$datos_header = array();
        $datos_header['titulo'] = 'Inicio';
        $this->load->model('actividad_model');
        $datos_header['actividades'] = $this->actividad_model->listar_actividad(); 
        $this->load->model('carro_model');
        $datos_header['carro'] = $this->carro_model->buscar_id_carro(); 
	return $datos_header;
    }
    
    public function datos_content() {
        $data = array();
        $this->load->model('carro_model');
        $data['cant_carros'] = $this->carro_model->cant_carros();
        $this->load->model('chofer_model');
        $data['cant_choferes'] = $this->chofer_model->cant_choferes();
        $this->load->model('ayudante_model');
        $data['cant_ayudantes'] = $this->ayudante_model->cant_ayudantes();
        $this->load->model('licencia_model');
        $data['cant_licencias'] = $this->licencia_model->cant_licencias();
        $this->load->model('tarjeta_model');
        $data['cant_tarjetas'] = $this->tarjeta_model->cant_tarjetas();
        $this->load->model('actividad_model');
        $data['cant_actividades'] = $this->actividad_model->cant_actividades();
        return $data;
    }
    
    public function fecha($anterior=FALSE) {
        $this->load->model('principal_model');
        $var1 = $this->principal_model->mes_procesar();  
        $var2 = $this->principal_model->anno(); 
        $mes = $var1->mes_procesar; 
        $anno = $var2->anno; 
        if($anterior) {
            if($mes==1){
                $mes = '12';
                $anno = $anno-1;
            }
            else 
                $mes = $mes-1;
        }
        $fecha['max_dias'] = days_in_month($mes, $anno);
        $fecha['mes'] = $mes;
        $fecha['anno'] = $anno;
        return $fecha;
    }
    
    public function datos_header_mes_procesar() {
	$datos_header = array();
        $datos_header['titulo'] = 'Mes a procesar';
        $this->load->model('actividad_model');
        $datos_header['actividades'] = $this->actividad_model->listar_actividad(); 
        $this->load->model('carro_model');
        $datos_header['carro'] = $this->carro_model->buscar_id_carro(); 
	return $datos_header;
    }
    
    public function mes_procesar($flag=FALSE, $error=FALSE) {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {
        $this->load->model('principal_model');
        $row = $this->principal_model->mes_procesar(); 
        $data['mensaje'] = $flag;
        if($error)
            $data['error'] = 'No se pudo realizar el cierre de mes, verifique que existan datos registrados en la BD.';
        $data['mes_procesar'] = $row->mes_procesar; 
        $data['carros_existentes'] = $row->carros_existentes; 
        $data['carros_trabajando'] = $row->carros_trabajando;  
        $data['carga_transportada'] = $row->carga_transportada; 
        $data['viajes_realizados'] = $row->viajes_realizados; 
        $data['trafico'] = $row->trafico; 
        $data['distancia_total'] = $row->distancia_total; 
        $data['distancia_carga'] = $row->distancia_carga; 
        $data['carga_posible'] = $row->carga_posible;  
        $data['consumo_combustible'] = $row->consumo_combustible; 
        $this->load->model('combustible_model');
        $combustible = $this->combustible_model->precio_combustible(); 
        $data['precio_1'] = $combustible[0]->precio_combustible;
        $data['precio_2'] = $combustible[1]->precio_combustible;
    	$this->load->view('header', $this->datos_header_mes_procesar());
	$this->load->view('container', $this->datos_mes_procesar($data));
	$this->load->view('footer', $this->datos_crumb_mes_procesar());
    }
    else
        redirect('auth/login', 'refresh');
    }
    
    public function datos_acumulado() {
        $data_reporte = array();
        $fecha = $this->fecha();
        $this->load->model('principal_model');
        $row = $this->principal_model->indicadores_mes();
        $this->load->model('recorrido_model');
        $recorrido = $this->recorrido_model->indicadores_recorrido($fecha);
        $this->load->model('carro_model');
        $carro = $this->carro_model->avg_capacidad_carro();
        $capacidad = $carro->capacidad;
        $data_reporte['mes'] = $fecha['mes'];
        $data_reporte['anno'] = $fecha['anno'];
        $data_reporte['carros_existentes_p'] = $row->carros_existentes; 
        $data_reporte['carros_existentes_r'] = $row->carros_existentes_r; 
        $data_reporte['carros_trabajando_p'] = $row->carros_trabajando; 
        $data_reporte['carros_trabajando_r'] = $row->carros_trabajando_r; 
        $data_reporte['carga_transportada_p'] = $row->carga_transportada; 
        $data_reporte['carga_transportada_r'] = $recorrido->carga_transportada_r;
        $data_reporte['viajes_realizados_p'] = $row->viajes_realizados;
        $data_reporte['viajes_realizados_r'] = $recorrido->viajes_carga_r; 
        $data_reporte['trafico_p'] = $row->trafico; 
        $data_reporte['trafico_r'] = $recorrido->trafico_r;
        $data_reporte['distancia_total_p'] = $row->distancia_total; 
        $data_reporte['distancia_total_r'] = $recorrido->distancia_total_r;
        $data_reporte['distancia_carga_p'] = $row->distancia_carga; 
        $data_reporte['distancia_carga_r'] = $recorrido->distancia_carga_r;
        $data_reporte['carga_posible_p'] = $row->carga_posible;
        $data_reporte['carga_posible_r'] = ($row->viajes_realizados*$capacidad)/1000;  
        $data_reporte['consumo_combustible_p'] = $row->consumo_combustible; 
        $data_reporte['consumo_combustible_r'] = $recorrido->consumo_combustible_r;
        return $data_reporte;
    }
    
    public function mes_procesar_post() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {
        $this->load->model('principal_model');
        $fecha = $this->fecha();
        $this->load->model('recorrido_model');        
        $recorrido = $this->recorrido_model->hay_recorrido($fecha);
        $cont = (int)$recorrido->cont;
        if($this->input->post()){
            if($cont>0){
                $data['carros_existentes'] = $this->input->post('carros_existentes',TRUE);
                $data['carros_trabajando'] = $this->input->post('carros_trabajando',TRUE);
                $data['carga_transportada'] = $this->input->post('carga_transportada',TRUE);
                $data['viajes_realizados'] = $this->input->post('viajes_realizados',TRUE);
                $data['trafico'] = $this->input->post('trafico',TRUE);
                $data['distancia_total'] = $this->input->post('distancia_total',TRUE);
                $data['distancia_carga'] = $this->input->post('distancia_carga',TRUE); 
                $data['carga_posible'] = $this->input->post('carga_posible',TRUE); 
                $data['consumo_combustible'] = $this->input->post('consumo_combustible',TRUE);
                $precio_1 = $this->input->post('precio_1',TRUE);
                $precio_2 = $this->input->post('precio_2',TRUE);   
                $mes_procesar = $this->input->post('nuevo_mes',TRUE);            
                $this->form_validation->set_rules('carros_existentes', 'Carros existentes', 'required|numeric');
                $this->form_validation->set_rules('carros_trabajando', 'Carros trabajando', 'required|numeric');
                $this->form_validation->set_rules('carga_transportada', 'Carga transportada', 'required|numeric');
                $this->form_validation->set_rules('viajes_realizados', 'Viajes realizados', 'required|numeric');
                $this->form_validation->set_rules('trafico', 'Tr&aacute;fico', 'required|numeric');
                $this->form_validation->set_rules('distancia_total', 'Distancia total', 'required|numeric');
                $this->form_validation->set_rules('distancia_carga', 'Distancia carga', 'required|numeric');  
                $this->form_validation->set_rules('carga_posible', 'Carga posible', 'required|numeric'); 
                $this->form_validation->set_rules('consumo_combustible', 'Consumo combustible', 'required|numeric'); 
                $this->form_validation->set_rules('precio_1', 'Precio Diesel', 'required|numeric'); 
                $this->form_validation->set_rules('precio_2', 'Precio Gasolina', 'required|numeric');
                if ($this->form_validation->run()){
                    if($mes_procesar==13) {
                        $row = $this->principal_model->anno(); 
                        $data['mes_procesar'] = 1;
                        $data['anno'] = $row->anno+1;
                    }
                    else
                        $data['mes_procesar'] = $mes_procesar;
                    $this->principal_model->adicionar_acumulado($this->datos_acumulado());
                    $this->principal_model->modificar_mes($data);
                    $this->load->model('combustible_model');
                    $this->combustible_model->modificar_precio_combustible(1, $precio_1);
                    $this->combustible_model->modificar_precio_combustible(2, $precio_2);
                    $this->mes_procesar(TRUE);
                }
                else {
                    $data['precio_1'] = $precio_1;
                    $data['precio_2'] = $precio_2;
                    $this->load->view('header', $this->datos_header_mes_procesar());
                    $this->load->view('container', $this->datos_mes_procesar($data));
                    $this->load->view('footer', $this->datos_crumb_mes_procesar());
                }
            }
            else 
                $this->mes_procesar(FALSE, TRUE);
        }
    }
    else
        redirect('auth/login', 'refresh');
    }

    public function datos_container() {
        $datos_container = array(
            'sidebar' => $this->load->view('sidebar', '', true),
            'content' => $this->load->view('principal/content', $this->datos_content(), true)
	);
	return $datos_container;
    }
    
    public function datos_mes_procesar($data) {
        $datos_container['content'] = $this->load->view('principal/mes_procesar', $data, true);
	return $datos_container;
    }
    
    public function datos_reporte($title) {
        $datos = $data_reporte = array();
        $datos['titulo'] = $title;
        $fecha = $this->fecha();
        $this->load->model('principal_model');
        $row = $this->principal_model->indicadores_mes();
        $this->load->model('recorrido_model');
        $recorrido = $this->recorrido_model->indicadores_recorrido($fecha);
        $this->load->model('carro_model');
        $carro = $this->carro_model->avg_capacidad_carro();
        $capacidad = $carro->capacidad;
        $data_reporte['carros_existentes'] = $row->carros_existentes; 
        $data_reporte['carros_existentes_r'] = $row->carros_existentes_r; 
        $data_reporte['carros_trabajando'] = $row->carros_trabajando; 
        $data_reporte['carros_trabajando_r'] = $row->carros_trabajando_r; 
        $data_reporte['carga_transportada'] = $row->carga_transportada; 
        $data_reporte['carga_transportada_r'] = $recorrido->carga_transportada_r;
        $data_reporte['viajes_realizados'] = $row->viajes_realizados;
        $data_reporte['viajes_realizados_r'] = $recorrido->viajes_carga_r; 
        $data_reporte['trafico'] = $row->trafico; 
        $data_reporte['trafico_r'] = $recorrido->trafico_r;
        $data_reporte['distancia_total'] = $row->distancia_total; 
        $data_reporte['distancia_total_r'] = $recorrido->distancia_total_r;
        $data_reporte['distancia_carga'] = $row->distancia_carga; 
        $data_reporte['distancia_carga_r'] = $recorrido->distancia_carga_r;
        $data_reporte['carga_posible'] = $row->carga_posible;
        $data_reporte['carga_posible_r'] = ($row->viajes_realizados*$capacidad)/1000;
        $data_reporte['consumo_combustible'] = $row->consumo_combustible; 
        $data_reporte['consumo_combustible_r'] = $recorrido->consumo_combustible_r;
        $data_reporte['fecha'] = $fecha;
        $datos['reporte'] = $this->load->view('principal/tabla_reporte', $data_reporte, TRUE);
        return $datos;
    }
    
    public function reporte_indicadores() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $this->load->view('reporte_i', $this->datos_reporte('Reporte de los indicadores'));
    }
    
    public function datos_reporte_a($title) {
        $datos = array();
        $datos['titulo'] = $title;
        $datos['acumulado'] = TRUE;
        if($this->input->post()) {
            $mes = $this->input->post('mes',TRUE);
            $anno = $this->input->post('anno',TRUE);
            $id_actividad = $this->input->post('actividad',TRUE);
            $fecha['mes'] = $mes;
            $fecha['anno'] = $anno;
        }
        else
            $fecha = $this->fecha(TRUE); 
        $this->load->model('recorrido_model');
        $data = array();
        $data['fecha'] = $fecha;
        $meses = array();
        $nombre_mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $temp = $this->fecha(TRUE);
        for($i=1; $i<=(int)$temp['mes']; $i++) {
            $meses[$i]['nombre'] = $nombre_mes[$i];
            $meses[$i]['id'] = $i;
        } 
        $data['meses'] = $meses;
        $annos = array();
        $var = $this->recorrido_model->ultima_fecha();
        $i=1;
        foreach ($var as $value) {
            $annos[$i]['id'] = $value->anno;
            $i++;
        }
        $data['anno'] = $annos;
        $this->load->model('principal_model');
        $row = $this->principal_model->indicadores_acumulado($fecha['mes'], $fecha['anno']); 
        $data['carros_existentes'] = $row->carros_existentes_p; 
        $data['carros_existentes_r'] = $row->carros_existentes_r; 
        $data['carros_trabajando'] = $row->carros_trabajando_p; 
        $data['carros_trabajando_r'] = $row->carros_trabajando_r; 
        $data['carga_transportada'] = $row->carga_transportada_p; 
        $data['carga_transportada_r']=$row->carga_transportada_r; 
        $data['viajes_realizados'] = $row->viajes_realizados_p; 
        $data['viajes_realizados_r'] = $row->viajes_realizados_r;
        $data['trafico'] = $row->trafico_p; 
        $data['trafico_r'] = $row->trafico_r;
        $data['distancia_total'] = $row->distancia_total_p; 
        $data['distancia_total_r'] = $row->distancia_total_r; 
        $data['distancia_carga'] = $row->distancia_carga_p;  
        $data['distancia_carga_r'] = $row->distancia_carga_r; 
        $data['carga_posible'] = $row->carga_posible_p;
        $data['carga_posible_r'] = $row->carga_posible_r;    
        $data['consumo_combustible'] = $row->consumo_combustible_p;  
        $data['consumo_combustible_r'] = $row->consumo_combustible_r;
        $datos['reporte'] = $this->load->view('principal/tabla_reporte', $data, TRUE);
        return $datos;
    }
    
    public function reporte_indicadores_acumulado() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');
        $this->load->view('reporte_i', $this->datos_reporte_a('Reporte de los indicadores'));
    }
    
    public function exportar_reporte() {
        $fecha = $this->fecha();
        $this->load->model('principal_model');
        $row = $this->principal_model->indicadores_mes();
        $this->load->model('recorrido_model');
        $recorrido = $this->recorrido_model->indicadores_recorrido($fecha);        
        $carga_transportada_r=$recorrido->carga_transportada_r;
        $viajes_carga_r=$recorrido->viajes_carga_r;
        $trafico_r=$recorrido->trafico_r;
        $distancia_total_r=$recorrido->distancia_total_r;
        $distancia_carga_r=$recorrido->distancia_carga_r;
        $consumo_combustible_r=$recorrido->consumo_combustible_r; 
        $this->load->model('carro_model');
        $carro = $this->carro_model->avg_capacidad_carro();
        $capacidad = $carro->capacidad;
        $data_reporte['carros_existentes'] = $row->carros_existentes;
        $data_reporte['carros_existentes_r'] = $row->carros_existentes_r;  
        $data_reporte['carros_trabajando'] = $row->carros_trabajando;
        $data_reporte['carros_trabajando_r'] = $row->carros_trabajando_r;  
        $data_reporte['carga_transportada'] = $row->carga_transportada;  
        $data_reporte['carga_transportada_r'] = $carga_transportada_r;
        $data_reporte['viajes_realizados'] = $row->viajes_realizados; 
        $data_reporte['viajes_realizados_r'] = $viajes_carga_r;
        $data_reporte['trafico'] = $row->trafico; 
        $data_reporte['trafico_r'] = $trafico_r;
        $data_reporte['distancia_total'] = $row->distancia_total; 
        $data_reporte['distancia_total_r'] = $distancia_total_r;
        $data_reporte['distancia_carga'] = $row->distancia_carga;
        $data_reporte['distancia_carga_r'] = $distancia_carga_r; 
        $data_reporte['carga_posible'] = $row->carga_posible;
        $data_reporte['carga_posible_r'] = ($row->viajes_realizados*$capacidad)/1000;  
        $data_reporte['consumo_combustible'] = $row->consumo_combustible;
        $data_reporte['consumo_combustible_r'] = $consumo_combustible_r;
        $data_reporte['fecha'] = $fecha;
        $this->load->view('principal/exportar_reporte', $data_reporte);
    }
    
    public function exportar_reporte_acumulado($mes_e=NULL, $anno_e=NULL) {
        if($mes_e!=NULL && $anno_e!=NULL) {
            $mes = $mes_e;
            $anno = $anno_e;
            $fecha['max_dias'] = days_in_month($mes, $anno);
            $fecha['mes'] = $data_reporte['n_mes'] = $mes;
            $fecha['anno'] = $data_reporte['n_anno'] = $anno;
        }
        else
            $fecha = $this->fecha(TRUE); 
        $this->load->model('principal_model');
        $row = $this->principal_model->indicadores_acumulado($fecha['mes'], $fecha['anno']); 
        $data['carros_existentes'] = $row->carros_existentes_p; 
        $data['carros_existentes_r'] = $row->carros_existentes_r; 
        $data['carros_trabajando'] = $row->carros_trabajando_p; 
        $data['carros_trabajando_r'] = $row->carros_trabajando_r; 
        $data['carga_transportada'] = $row->carga_transportada_p; 
        $data['carga_transportada_r']=$row->carga_transportada_r; 
        $data['viajes_realizados'] = $row->viajes_realizados_p; 
        $data['viajes_realizados_r'] = $row->viajes_realizados_r;
        $data['trafico'] = $row->trafico_p; 
        $data['trafico_r'] = $row->trafico_r;
        $data['distancia_total'] = $row->distancia_total_p; 
        $data['distancia_total_r'] = $row->distancia_total_r; 
        $data['distancia_carga'] = $row->distancia_carga_p;  
        $data['distancia_carga_r'] = $row->distancia_carga_r; 
        $data['carga_posible'] = $row->carga_posible_p;
        $data['carga_posible_r'] = $row->carga_posible_r;    
        $data['consumo_combustible'] = $row->consumo_combustible_p;  
        $data['consumo_combustible_r'] = $row->consumo_combustible_r;
        $data['fecha'] = $fecha;
        $this->load->view('principal/exportar_reporte', $data);
    }

    //------- Migas de Pan (breadcrumb) -----------------------------------------------
    public function datos_crumb() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
    
    public function datos_crumb_mes_procesar() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Mes a procesar',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }

}

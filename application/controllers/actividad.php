<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actividad extends CI_Controller {

    public function __construct() {
	parent::__construct();
        $this->form_validation->set_message('required', 'El campo < %s > es obligatorio.');
    }

    public function index() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
    	$this->load->view('header', $this->datos_header('Actividad'));
	$this->load->view('container', $this->datos_inicio());
	$this->load->view('footer', $this->datos_crumb());
    }
    
    public function datos_header($title) {
	$datos_header = array();
        $datos_header['titulo'] = $title;
        $this->load->model('actividad_model');
        $datos_header['actividades'] = $this->actividad_model->listar_actividad(); 
        $this->load->model('carro_model');
        $datos_header['carro'] = $this->carro_model->buscar_id_carro(); 
	return $datos_header;
    }
    
    public function datos_inicio() {
        $datos_container['content'] = $this->load->view('actividad/listar', $this->listar_actividades(), true);
	return $datos_container;
    }
    
    public function listar_actividades() {
        $listado = array();
        $this->load->model('actividad_model');
        $listado['listado'] = $this->actividad_model->listar_all_actividad();
        return $listado;
    }
    
    public function exportar($nombre, $tipo_combustible, $estado) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $this->load->helper('excel_helper');
        $this->load->model('actividad_model');
        to_excel($this->actividad_model->exportar_actividades(urldecode($nombre), urldecode($tipo_combustible), urldecode($estado)), 'actividad');
    }
    
    public function datos_buscar($datos_busqueda) {
        $datos_container['content'] = $this->load->view('actividad/listar', $datos_busqueda, true);
	return $datos_container;
    }
    
    public function buscar() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $datos_busqueda = array();
        if($this->input->post()){
            $nombre = $this->input->post('nombre',TRUE);            
            $tipo_combustible = $this->input->post('tipo_combustible',TRUE);
            $estado = $this->input->post('estado',TRUE);
            $datos_busqueda['nombre_b'] = $nombre;
            $datos_busqueda['tipo_combustible_b'] = $tipo_combustible;
            $datos_busqueda['estado_b'] = $estado;
            $this->load->model('actividad_model');
            $datos_busqueda['listado'] = $this->actividad_model->buscar_actividades($nombre, $tipo_combustible, $estado);
        }
        else {
            redirect('actividad');
        }
        $this->load->view('header', $this->datos_header('Actividad'));
	$this->load->view('container', $this->datos_buscar($datos_busqueda));
	$this->load->view('footer', $this->datos_crumb());
    }
    
    public function datos_insertar($data) {
        $datos_insertar['content'] = $this->load->view('actividad/insertar', $data, true);
	return $datos_insertar;
    }
    
    public function insertar($flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {   
        $data = array();
        $data['mensaje'] = $flag;
        $this->load->model('combustible_model');
        $data['combustible'] = $this->combustible_model->listar_combustible();
        $this->load->view('header', $this->datos_header('Insertar Actividad'));
	$this->load->view('container', $this->datos_insertar($data));
	$this->load->view('footer', $this->datos_crumb_insertar());
    }
    else
        redirect('auth/login', 'refresh');
    }
    
    public function insertar_post(){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        if($this->input->post()){
            $nombre_act = $this->input->post('nombre_act',true);
            $tipo_combustible = $this->input->post('tipo_combustible',true);
            $this->form_validation->set_rules('nombre_act', 'Nombre', 'required|callback_letras');
            $this->form_validation->set_rules('tipo_combustible', 'Tipo de combustible', 'required');
            if ($this->form_validation->run()){
                $this->load->model('actividad_model');
                $this->actividad_model->insertar_actividad($nombre_act, $tipo_combustible);
                $this->insertar(true);
            }
            else{
                $data = array();
                $data['nombre_act'] = $nombre_act;
                $data['tipo'] = $tipo_combustible;
                $this->load->model('combustible_model');
                $data['combustible'] = $this->combustible_model->listar_combustible();
                $this->load->view('header', $this->datos_header('Insertar Actividad'));
                $this->load->view('container', $this->datos_insertar($data));
                $this->load->view('footer', $this->datos_crumb_insertar());
            }
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }       
    
    public function datos_eliminar_error() {
        $data = array();
        $data['error'] = '¡ No se pudo eliminar la actividad !'; 
        $this->load->model('actividad_model');
        $data['listado'] = $this->actividad_model->listar_actividad();
        $datos_container['content'] = $this->load->view('actividad/listar', $data, true);
	return $datos_container;
    }
    
    public function datos_eliminar() {
        $data = array();
        $this->load->model('actividad_model');
        $data['listado'] = $this->actividad_model->listar_actividad();
        $data['delete'] = '¡ Se ha eliminado la actividad satisfactoriamente !'; 
        $datos_container['content'] = $this->load->view('actividad/listar', $data, true);
	return $datos_container;
    }
    
    public function eliminar($id_actividad){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {     
        $this->load->model('actividad_model');
        $actividad = $this->actividad_model->es_usada($id_actividad);
        if($actividad){
            $this->load->view('header', $this->datos_header('Actividad'));
            $this->load->view('container', $this->datos_eliminar_error());
            $this->load->view('footer', $this->datos_crumb());
        }
        else {
            $this->actividad_model->eliminar_actividad($id_actividad);
            $this->load->view('header', $this->datos_header('Actividad'));
            $this->load->view('container', $this->datos_eliminar());
            $this->load->view('footer', $this->datos_crumb());        
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_modificar($data) {
        $datos_modificar['content'] = $this->load->view('actividad/modificar', $data, true);
	return $datos_modificar;
    }
    
    public function modificar($id_actividad, $flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array(); 
        $data['mensaje'] = $flag; 
        $this->load->model('actividad_model');
        $actividad = $this->actividad_model->buscar_por_id($id_actividad);
        $this->load->model('combustible_model');
        $data['combustible'] = $this->combustible_model->listar_combustible();
        $data['id_actividad'] = $id_actividad;
        $data['nombre_act'] = $actividad->nombre_act;
        $data['tipo'] = $actividad->id_combustible;
        $data['estado'] = $actividad->estado;
        $this->load->view('header', $this->datos_header('Modificar Actividad'));
	$this->load->view('container', $this->datos_modificar($data));
	$this->load->view('footer', $this->datos_crumb_modificar());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function modificar_post($id_actividad){ 
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {     
        if($this->input->post()){
            $nombre_act = $this->input->post('nombre_act',true);
            $tipo_combustible = $this->input->post('tipo_combustible',true);
            $estado = $this->input->post('estado',true);
            $this->form_validation->set_rules('nombre_act', 'Nombre', 'required|callback_letras');
            $this->form_validation->set_rules('tipo_combustible', 'Tipo de combustible', 'required');
            $this->form_validation->set_rules('estado', 'Estado', 'required');
            if ($this->form_validation->run()) { 
                $this->load->model('actividad_model');
                $this->actividad_model->modificar_actividad($id_actividad, $nombre_act, $tipo_combustible, $estado);            
                $this->modificar($id_actividad, true); 
            }
            else {
                $data = array();
                $this->load->model('combustible_model');
                $data['combustible'] = $this->combustible_model->listar_combustible();
                $data['id_actividad'] = $id_actividad;
                $data['nombre_act'] = $nombre_act;
                $data['tipo'] = $id_combustible;
                $data['estado'] = $estado;
                $this->load->view('header', $this->datos_header('Modificar Actividad'));
                $this->load->view('container', $this->datos_modificar($data));
                $this->load->view('footer', $this->datos_crumb_modificar());
            }
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function modificar_estado($id_actividad, $estado) {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        $this->load->model('actividad_model');
        $this->actividad_model->modificar_estado($id_actividad, $estado);
        redirect('actividad');
    }
    else
        redirect('auth/login', 'refresh');
    } 
   
//    public function datos_ver($data) {
//        $datos_ver['content'] = $this->load->view('actividad/ver', $data, true);
//	return $datos_ver;
//    }   
//   
//    public function ver($id_actividad){
//        $data = array(); 
//        $this->load->model('actividad_model');
//        $actividad = $this->actividad_model->buscar_por_id($id_actividad);
//        $data['actividad'] = $actividad;
//        $this->load->view('header', $this->datos_header('Ver Actividad'));
//        $this->load->view('container', $this->datos_ver($data));
//        $this->load->view('footer', $this->datos_crumb_ver());
//    }    
    
    public function letras($str) {
        if (!(bool) preg_match('/^[A-Za-zÁÉÍÓÚáéíóú .Ññ_-]+$/i', $str)){
            $this->form_validation->set_message('letras', 'El campo < %s > solo admite letras, punto [\'.\'] y/o un separador [ \'-\' , \'_\' ] .');
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    //------- Migas de Pan (breadcrumb) -----------------------------------------------
    public function datos_crumb() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Actividad',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
   
    public function datos_crumb_insertar() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Actividad',
		'direccion' => base_url().'actividad'
            ),
            2 => array(
		'nombre' => 'Insertar Actividad',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
   
    public function datos_crumb_modificar() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Actividad',
		'direccion' => base_url().'actividad'
            ),
            2 => array(
		'nombre' => 'Modificar Actividad',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
//   
//    public function datos_crumb_ver() {
//	$datos_crumb['crumb'] = array(
//            0 => array(
//		'nombre' => 'Inicio',
//		'direccion' => base_url()
//            ),
//            1 => array(
//		'nombre' => 'Actividad',
//		'direccion' => base_url().'actividad'
//            ),
//            2 => array(
//		'nombre' => 'Ver Actividad',
//		'direccion' => ''
//            )
//	);
//	return $datos_crumb;
//    }
    

}

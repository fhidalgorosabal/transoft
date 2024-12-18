<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarjeta extends CI_Controller {

    public function __construct() {
	parent::__construct(); 
        $this->form_validation->set_message('required', 'El campo < %s > es obligatorio.');
        $this->form_validation->set_message('numeric', 'El campo < %s > solo admite n&uacute;meros.');
        $this->form_validation->set_message('integer', 'El campo < %s > solo admite n&uacute;meros enteros.');
    }

    public function index() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
    	$this->load->view('header', $this->datos_header('Tarjeta'));
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
        $datos_container['content'] = $this->load->view('tarjeta/listar', $this->listar_tarjetas(), true);
	return $datos_container;
    }
    
    public function listar_tarjetas() {
        $data = array();
        $this->load->model('tarjeta_model');
        $data['listado'] = $this->tarjeta_model->listar_tarjeta();
        $this->load->model('combustible_model');
        $combustible = $this->combustible_model->precio_combustible(); 
        $data['diesel'] = $combustible[0]->precio_combustible;
        $data['gasolina'] = $combustible[1]->precio_combustible;
        return $data;
    }
    
    public function exportar($codigo, $combustible, $credito) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $this->load->helper('excel_helper');
        $this->load->model('tarjeta_model');
        to_excel($this->tarjeta_model->exportar_tarjetas(urldecode($codigo), urldecode($combustible), urldecode($credito)), 'tarjeta');
    }
    
    public function datos_buscar($datos_busqueda) {
        $datos_container['content'] = $this->load->view('tarjeta/listar', $datos_busqueda, true);
	return $datos_container;
    }
    
    public function buscar() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $datos_busqueda = array();
        if($this->input->post()){
            $codigo = $this->input->post('codigo',TRUE);  
            $combustible = $this->input->post('combustible',TRUE);
            $credito = $this->input->post('credito',TRUE);
            $datos_busqueda['codigo_b'] = $codigo;
            $datos_busqueda['combustible_b'] = $combustible;
            $datos_busqueda['credito_b'] = $credito;
            $this->load->model('tarjeta_model');
            $datos_busqueda['listado'] = $this->tarjeta_model->buscar_tarjetas($codigo, $combustible, $credito);
            $this->load->model('combustible_model');
            $combustible = $this->combustible_model->precio_combustible(); 
            $datos_busqueda['diesel'] = $combustible[0]->precio_combustible;
            $datos_busqueda['gasolina'] = $combustible[1]->precio_combustible;
        }
        else {
            redirect('tarjeta');
        }
        $this->load->view('header', $this->datos_header('Tarjeta'));
	$this->load->view('container', $this->datos_buscar($datos_busqueda));
	$this->load->view('footer', $this->datos_crumb());
    }
    
    public function existe_tarjeta($codigo, $id_tarjeta=NULL) {
        $this->load->model('tarjeta_model');
        if($id_tarjeta==NULL)
            $row = $this->tarjeta_model->buscar_por_codigo($codigo);
        else
            $row = $this->tarjeta_model->buscar_por_codigo_id($codigo, $id_tarjeta);
        if($row!=NULL)
            return TRUE;
        else
            return FALSE;
    }
    
    public function datos_insertar($data) {
        $datos_insertar['content'] = $this->load->view('tarjeta/insertar', $data, true);
	return $datos_insertar;
    }
    
    public function insertar($flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array();
        $data['mensaje'] = $flag;
        $this->load->model('combustible_model');
        $data['combustible'] = $this->combustible_model->listar_combustible();
        $this->load->view('header', $this->datos_header('Insertar Tarjeta'));
	$this->load->view('container', $this->datos_insertar($data));
	$this->load->view('footer', $this->datos_crumb_insertar());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function insertar_post(){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        if($this->input->post()){
            $datos_incorrectos=$existe=FALSE;
            $codigo_tarjeta = $this->input->post('codigo_tarjeta',true);
            $tipo_combustible = $this->input->post('tipo_combustible',true);
            $credito = $this->input->post('credito',true);
            $this->form_validation->set_rules('codigo_tarjeta', 'C&oacute;digo', 'required|numeric|integer');
            $this->form_validation->set_rules('tipo_combustible', 'Tipo de combustible', 'required');
            $this->form_validation->set_rules('credito', 'Cr&eacute;dito', 'required|numeric');
            if ($this->form_validation->run()){
                if(!$this->existe_tarjeta($codigo_tarjeta)) {
                    $this->load->model('tarjeta_model');
                    $this->tarjeta_model->insertar_tarjeta($codigo_tarjeta, $tipo_combustible, $credito);
                    $this->insertar(true);
                }
                else 
                    $existe = TRUE;
            }
            else
                $datos_incorrectos = TRUE;
            if($datos_incorrectos || $existe) {
                $data = array();
                if($existe)
                    $data['error'] = 'Esta tarjeta ya existe en la BD.';
                $this->load->model('combustible_model');
                $data['combustible'] = $this->combustible_model->listar_combustible();
                $data['codigo_tarjeta'] = $codigo_tarjeta;
                $data['tipo'] = $tipo_combustible;
                $data['credito'] = $credito;
                $this->load->view('header', $this->datos_header('Insertar Tarjeta'));
                $this->load->view('container', $this->datos_insertar($data));
                $this->load->view('footer', $this->datos_crumb_insertar());                
            }
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_eliminar_error($id_chofer) {
        $data = array();
        $data['error'] = '¡ No se pudo eliminar la tarjeta !'; 
        $data['id_chofer'] = $id_chofer;
        $this->load->model('tarjeta_model');
        $data['listado'] = $this->tarjeta_model->listar_tarjeta();
        $this->load->model('combustible_model');
        $combustible = $this->combustible_model->precio_combustible(); 
        $data['diesel'] = $combustible[0]->precio_combustible;
        $data['gasolina'] = $combustible[1]->precio_combustible;
        $datos_container['content'] = $this->load->view('tarjeta/listar', $data, true);
	return $datos_container;
    }
    
    public function datos_eliminar() {
        $data = array();
        $this->load->model('tarjeta_model');
        $data['listado'] = $this->tarjeta_model->listar_tarjeta();
        $this->load->model('combustible_model');
        $combustible = $this->combustible_model->precio_combustible(); 
        $data['diesel'] = $combustible[0]->precio_combustible;
        $data['gasolina'] = $combustible[1]->precio_combustible;
        $data['delete'] = '¡ Se ha eliminado la tarjeta satisfactoriamente !';
        $datos_container['content'] = $this->load->view('tarjeta/listar', $data, true);
	return $datos_container;
    }
    
    public function eliminar($id_tarjeta){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $this->load->model('tarjeta_model');
        $tarjeta = $this->tarjeta_model->es_usada($id_tarjeta);
        if($tarjeta){
            $id_chofer = $tarjeta->en_uso;
            $this->load->view('header', $this->datos_header('Tarjeta'));
            $this->load->view('container', $this->datos_eliminar_error($id_chofer));
            $this->load->view('footer', $this->datos_crumb());
        }
        else {
            $this->tarjeta_model->eliminar_tarjeta($id_tarjeta);
            $this->load->view('header', $this->datos_header('Tarjeta'));
            $this->load->view('container', $this->datos_eliminar());
            $this->load->view('footer', $this->datos_crumb());        
        }   
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_modificar($data) {
        $datos_modificar['content'] = $this->load->view('tarjeta/modificar', $data, true);
	return $datos_modificar;
    }
    
    public function modificar($id_tarjeta, $flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array(); 
        $data['mensaje'] = $flag;
        $this->load->model('combustible_model');
        $data['combustible'] = $this->combustible_model->listar_combustible();
        $this->load->model('tarjeta_model');
        $tarjeta = $this->tarjeta_model->buscar_por_id($id_tarjeta);
        $data['id_tarjeta'] = $id_tarjeta;
        $data['codigo_tarjeta'] = $tarjeta->codigo_tarjeta;
        $data['tipo'] = $tarjeta->id_combustible;
        $data['credito'] = $tarjeta->credito;
        $this->load->view('header', $this->datos_header('Modificar Tarjeta'));
	$this->load->view('container', $this->datos_modificar($data));
	$this->load->view('footer', $this->datos_crumb_modificar());
    }
    else
        redirect('auth/login', 'refresh');    
    }
   
    public function modificar_post($id_tarjeta){   
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {   
        if($this->input->post()){ 
            $datos_incorrectos=$existe=FALSE;              
            $codigo_tarjeta = $this->input->post('codigo_tarjeta',true);
            $tipo_combustible = $this->input->post('tipo_combustible',true);
            $credito = $this->input->post('credito',true);            
            $this->form_validation->set_rules('codigo_tarjeta', 'C&oacute;digo', 'required|numeric');
            $this->form_validation->set_rules('tipo_combustible', 'Tipo de combustible', 'required');
            $this->form_validation->set_rules('credito', 'Cr&eacute;dito', 'required|numeric');
            if ($this->form_validation->run()){ 
                if(!$this->existe_tarjeta($codigo_tarjeta, $id_tarjeta)) {
                    $this->load->model('tarjeta_model');
                    $this->tarjeta_model->modificar_tarjeta($id_tarjeta, $codigo_tarjeta, $tipo_combustible, $credito);
                    $this->modificar($id_tarjeta, true);
                }
                else 
                    $existe = TRUE;
            }
            else
                $datos_incorrectos = TRUE;
            if($datos_incorrectos || $existe) {
                $data = array();
                if($existe)
                    $data['error'] = 'Esta tarjeta ya existe en la BD.';
                $this->load->model('combustible_model');
                $data['combustible'] = $this->combustible_model->listar_combustible();
                $data['id_tarjeta'] = $id_tarjeta;
                $data['codigo_tarjeta'] = $codigo_tarjeta;
                $data['tipo'] = $tipo_combustible;
                $data['credito'] = $credito;
                $this->load->view('header', $this->datos_header('Modificar Tarjeta'));
                $this->load->view('container', $this->datos_modificar($data));
                $this->load->view('footer', $this->datos_crumb_modificar());
            }
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }

    //------- Migas de Pan (breadcrumb) -----------------------------------------------
    public function datos_crumb() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Tarjeta',
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
		'nombre' => 'Tarjeta',
		'direccion' => base_url().'tarjeta'
            ),
            2 => array(
		'nombre' => 'Insertar Tarjeta',
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
		'nombre' => 'Tarjeta',
		'direccion' => base_url().'tarjeta'
            ),
            2 => array(
		'nombre' => 'Modificar Tarjeta',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
   
//    public function datos_crumb_ver() {
//	$datos_crumb['crumb'] = array(
//            0 => array(
//		'nombre' => 'Inicio',
//		'direccion' => base_url()
//            ),
//            1 => array(
//		'nombre' => 'Tarjeta',
//		'direccion' => base_url().'tarjeta'
//            ),
//            2 => array(
//		'nombre' => 'Ver Tarjeta',
//		'direccion' => ''
//            )
//	);
//	return $datos_crumb;
//    }
    

}

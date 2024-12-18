<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Licencia extends CI_Controller {

    public function __construct() {
	parent::__construct(); 
        $this->form_validation->set_message('required', 'El campo < %s > es obligatorio.');
        $this->form_validation->set_message('numeric', 'El campo < %s > solo admite n&uacute;meros enteros.');
        $this->form_validation->set_message('integer', 'El campo < %s > solo admite n&uacute;meros enteros.');
        $this->form_validation->set_message('alpha_numeric', 'El campo < %s > solo admite letras y n&uacute;meros.');
        $this->form_validation->set_message('exact_length', 'El campo < %s > admite exactamente 7 caracteres.');  
    }

    public function index() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
    	$this->load->view('header', $this->datos_header('Licencia'));
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
        $datos_container['content'] = $this->load->view('licencia/listar', $this->listar_licencias(), true);
	return $datos_container;
    }
    
    public function listar_licencias() {
        $listado = array();
        $this->load->model('licencia_model');
        $listado['listado'] = $this->licencia_model->listar_licencia();
        return $listado;
    }
    
    public function exportar($codigo, $fecha, $puntos) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $this->load->helper('excel_helper');
        $this->load->model('licencia_model');
        to_excel($this->licencia_model->exportar_licencias(urldecode($codigo), urldecode($fecha), urldecode($puntos)), 'licencia');
    } 
    
    public function datos_buscar($datos_busqueda) {
        $datos_container['content'] = $this->load->view('licencia/listar', $datos_busqueda, true);
	return $datos_container;
    }
    
    public function buscar() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $datos_busqueda = array();
        if($this->input->post()){
            $codigo = $this->input->post('codigo',TRUE);            
            $fecha = $this->input->post('fecha',TRUE);
            $puntos = $this->input->post('puntos',TRUE);
            $datos_busqueda['codigo_b'] = $codigo;
            $datos_busqueda['fecha_b'] = $fecha;
            $datos_busqueda['puntos_b'] = $puntos;
            $this->load->model('licencia_model');
            $datos_busqueda['listado'] = $this->licencia_model->buscar_licencias($codigo, $fecha, $puntos);
        }
        else {
            redirect('licencia');
        }
        $this->load->view('header', $this->datos_header('Licencia'));
	$this->load->view('container', $this->datos_buscar($datos_busqueda));
	$this->load->view('footer', $this->datos_crumb());
    }
    
    public function existe_licencia($codigo, $id_licencia=NULL) {
        $this->load->model('licencia_model');
        if($id_licencia==NULL)
            $row = $this->licencia_model->buscar_por_codigo($codigo);
        else
            $row = $this->licencia_model->buscar_por_codigo_id($codigo, $id_licencia);
        if($row!=NULL)
            return TRUE;
        else
            return FALSE;
    }
    
    public function datos_insertar($data) {
        $datos_insertar['content'] = $this->load->view('licencia/insertar', $data, true);
	return $datos_insertar;
    }
    
    public function insertar($flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array();
        $data['mensaje'] = $flag;
        $this->load->view('header', $this->datos_header('Insertar Licencia'));
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
            $codigo_licencia = $this->input->post('codigo_licencia',true);
            $fecha_vencimiento = $this->input->post('fecha_vencimiento',true);
            $puntos_acumulados = $this->input->post('puntos_acumulados',true);
            $this->form_validation->set_rules('codigo_licencia', 'C&oacute;digo', 'required|alpha_numeric|exact_length[7]');
            $this->form_validation->set_rules('fecha_vencimiento', 'Fecha de vencimiento', 'required');
            $this->form_validation->set_rules('puntos_acumulados', 'Puntos acumulados', 'required|numeric|integer');
            if ($this->form_validation->run()){
                if(!$this->existe_licencia($codigo_licencia)) {
                    $this->load->model('licencia_model');
                    $this->licencia_model->insertar_licencia($codigo_licencia, $fecha_vencimiento, $puntos_acumulados);
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
                    $data['error'] = 'Esta licencia ya existe en la BD.';
                $data['codigo_licencia'] = $codigo_licencia;
                $data['fecha_vencimiento'] = $fecha_vencimiento;
                $data['puntos_acumulados'] = $puntos_acumulados;
                $this->load->view('header', $this->datos_header('Insertar Licencia'));
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
        $data['error'] = '¡ No se pudo eliminar la licencia !'; 
        $data['id_chofer'] = $id_chofer;
        $this->load->model('licencia_model');
        $data['listado'] = $this->licencia_model->listar_licencia();
        $datos_container['content'] = $this->load->view('licencia/listar', $data, true);
	return $datos_container;
    }
    
    public function datos_eliminar() {
        $data = array();
        $this->load->model('licencia_model');
        $data['listado'] = $this->licencia_model->listar_licencia();
        $data['delete'] = '¡ Se ha eliminado la licencia satisfactoriamente !';
        $datos_container['content'] = $this->load->view('licencia/listar', $data, true);
	return $datos_container;
    }
    
    public function eliminar($id_licencia) {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $this->load->model('licencia_model');
        $licencia = $this->licencia_model->es_usada($id_licencia);
        if($licencia){
            $id_chofer = $licencia->en_uso;
            $this->load->view('header', $this->datos_header('Licencia'));
            $this->load->view('container', $this->datos_eliminar_error($id_chofer));
            $this->load->view('footer', $this->datos_crumb());
        }
        else {
            $this->licencia_model->eliminar_licencia($id_licencia);
            $this->load->view('header', $this->datos_header('Licencia'));
            $this->load->view('container', $this->datos_eliminar());
            $this->load->view('footer', $this->datos_crumb());        
        } 
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_modificar($data) {
        $datos_modificar['content'] = $this->load->view('licencia/modificar', $data, true);
	return $datos_modificar;
    }
    
    public function modificar($id_licencia, $flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array(); 
        $data['mensaje'] = $flag; 
        $this->load->model('licencia_model');
        $licencia = $this->licencia_model->buscar_por_id($id_licencia);
        $data['id_licencia'] = $id_licencia;
        $data['codigo_licencia'] = $licencia->codigo_licencia;
        $data['fecha_vencimiento'] = $licencia->fecha_vencimiento;
        $data['puntos_acumulados'] = $licencia->puntos_acumulados;
        $this->load->view('header', $this->datos_header('Modificar Licencia'));
	$this->load->view('container', $this->datos_modificar($data));
	$this->load->view('footer', $this->datos_crumb_modificar());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function modificar_post($id_licencia){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        if($this->input->post()){    
            $datos_incorrectos=$existe=FALSE;        
            $codigo_licencia = $this->input->post('codigo_licencia',true);
            $fecha_vencimiento = $this->input->post('fecha_vencimiento',true);
            $puntos_acumulados = $this->input->post('puntos_acumulados',true);
            $this->form_validation->set_rules('codigo_licencia', 'C&oacute;digo', 'required|alpha_numeric|exact_length[7]');
            $this->form_validation->set_rules('fecha_vencimiento', 'Fecha de vencimiento', 'required');
            $this->form_validation->set_rules('puntos_acumulados', 'Puntos acumulados', 'required|numeric|integer');
            if ($this->form_validation->run()){
                if(!$this->existe_licencia($codigo_licencia, $id_licencia)) {
                    $this->load->model('licencia_model');
                    $this->licencia_model->modificar_licencia($id_licencia, $codigo_licencia, $fecha_vencimiento, $puntos_acumulados);
                    $this->modificar($id_licencia, true);
                }
                else 
                    $existe = TRUE;
            }
            else
                $datos_incorrectos = TRUE;
            if($datos_incorrectos || $existe) {
                $data = array();
                if($existe)
                    $data['error'] = 'Esta licencia ya existe en la BD.';
                $data['id_licencia'] = $id_licencia;
                $data['codigo_licencia'] = $codigo_licencia;
                $data['fecha_vencimiento'] = $fecha_vencimiento;
                $data['puntos_acumulados'] = $puntos_acumulados;
                $this->load->view('header', $this->datos_header('Modificar Licencia'));
                $this->load->view('container', $this->datos_insertar($data));
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
		'nombre' => 'Licencia',
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
		'nombre' => 'Licencia',
		'direccion' => base_url().'licencia'
            ),
            2 => array(
		'nombre' => 'Insertar Licencia',
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
		'nombre' => 'Licencia',
		'direccion' => base_url().'licencia'
            ),
            2 => array(
		'nombre' => 'Modificar Licencia',
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
//		'nombre' => 'Licencia',
//		'direccion' => base_url().'licencia'
//            ),
//            2 => array(
//		'nombre' => 'Ver Licencia',
//		'direccion' => ''
//            )
//	);
//	return $datos_crumb;
//    }
    

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ayudante extends CI_Controller {

    public function __construct() {
	parent::__construct();
        $this->form_validation->set_message('required', 'El campo < %s > es obligatorio.');
        $this->form_validation->set_message('integer', 'El campo< %s > solo admite n&uacute;meros enteros.');
        $this->form_validation->set_message('exact_length', 'El campo < %s > solo admite 11 caracteres.');
    }

    public function index() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
    	$this->load->view('header', $this->datos_header('Ayudante'));
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
        $datos_container['content'] = $this->load->view('ayudante/listar', $this->listar_ayudantes(), true);
	return $datos_container;
    }
    
    public function listar_ayudantes() {
        $listado = array();
        $this->load->model('ayudante_model');
        $listado['listado'] = $this->ayudante_model->listar_ayudante();
        return $listado;
    }
    
    public function exportar($ci, $nombre, $apellidos) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $this->load->helper('excel_helper');
        $this->load->model('ayudante_model');
        to_excel($this->ayudante_model->exportar_ayudante(urldecode($ci), urldecode($nombre), urldecode($apellidos)), 'ayudantes');
    } 
    
    public function datos_buscar($datos_busqueda) {
        $datos_container['content'] = $this->load->view('ayudante/listar', $datos_busqueda, true);
	return $datos_container;
    }
    
    public function buscar() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $datos_busqueda = array();
        if($this->input->post()){
            $ci = $this->input->post('ci',TRUE);            
            $nombre = $this->input->post('nombre',TRUE);
            $apellidos = $this->input->post('apellidos',TRUE);
            $datos_busqueda['ci_b'] = $ci;
            $datos_busqueda['nombre_b'] = $nombre;
            $datos_busqueda['apellidos_b'] = $apellidos;
            $this->load->model('ayudante_model');
            $datos_busqueda['listado'] = $this->ayudante_model->buscar_ayudantes($ci, $nombre, $apellidos);
        }
        else {
            redirect('ayudante');
        }
        $this->load->view('header', $this->datos_header('Ayudante'));
	$this->load->view('container', $this->datos_buscar($datos_busqueda));
	$this->load->view('footer', $this->datos_crumb());
    }
    
    public function exportar_bajas() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {   
        $this->load->helper('excel_helper');
        $this->load->model('ayudante_model');
        to_excel($this->ayudante_model->exportar_bajas(), 'ayudantes_bajas');
    }
    else
        redirect('auth/login', 'refresh');
    }
    
    public function datos_baja() {
        $datos_container['content'] = $this->load->view('ayudante/bajas', $this->bajas_ayudantes(), true);
	return $datos_container;
    }
    
    public function bajas_ayudantes() {
        $listado = array();
        $this->load->model('ayudante_model');
        $listado['listado'] = $this->ayudante_model->listar_bajas();
        return $listado;
    }
    
    public function baja() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {  
    	$this->load->view('header', $this->datos_header('Bajas Ayudante'));
	$this->load->view('container', $this->datos_baja());
	$this->load->view('footer', $this->datos_crumb_baja());
    }
    else
        redirect('auth/login', 'refresh');
    }
    
    public function existe_ayudante($ci, $id_ayudante=NULL) {
        $this->load->model('ayudante_model');
        if($id_ayudante==NULL)
            $row = $this->ayudante_model->buscar_por_ci($ci);
        else
            $row = $this->ayudante_model->buscar_por_ci_id($ci, $id_ayudante);
        if($row!=NULL)
            return TRUE;
        else
            return FALSE;
    }
    
    public function datos_insertar($data) {
        $datos_insertar['content'] = $this->load->view('ayudante/insertar', $data, true);
	return $datos_insertar;
    }
    
    public function insertar($flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array();
        $data['mensaje'] = $flag;
        $this->load->view('header', $this->datos_header('Insertar Ayudante'));
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
            $ci = $this->input->post('ci',true);
            $nombre_ayd = $this->input->post('nombre_ayd',true);
            $apellidos = $this->input->post('apellidos',true);
            $this->form_validation->set_rules('ci', 'Carnet de identidad', 'required|integer|exact_length[11]|callback_ci');
            $this->form_validation->set_rules('nombre_ayd', 'Nombre del ayudante', 'required|callback_letras');
            $this->form_validation->set_rules('apellidos', 'Apellidos del ayudante', 'required|callback_letras');
            if ($this->form_validation->run()) {
                if(!$this->existe_ayudante($ci)) {
                    $this->load->model('ayudante_model');
                    $this->ayudante_model->insertar_ayudante($ci, $nombre_ayd, $apellidos);
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
                    $data['error'] = 'Ya existe un ayudante con este CI en la BD.';
                $data['ci'] = $ci;
                $data['nombre_ayd'] = $nombre_ayd;
                $data['apellidos'] = $apellidos;
                $this->load->view('header', $this->datos_header('Insertar Ayudante'));
                $this->load->view('container', $this->datos_insertar($data));
                $this->load->view('footer', $this->datos_crumb_insertar());
            }
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_eliminar() {
        $data = array();
        $this->load->model('ayudante_model');
        $data['listado'] = $this->ayudante_model->listar_ayudante();
        $data['delete'] = '¡ Se ha dado de baja al ayudante satisfactoriamente !'; 
        $datos_container['content'] = $this->load->view('ayudante/listar', $data, true);
	return $datos_container;
    }
    
    public function datos_eliminar_baja() {
        $data = array();
        $this->load->model('ayudante_model');
        $data['listado'] = $this->ayudante_model->listar_bajas();
        $data['delete'] = '¡ Se ha eliminado al ayudante satisfactoriamente !'; 
        $datos_container['content'] = $this->load->view('ayudante/bajas', $data, true);
	return $datos_container;
    }
    
    public function datos_restaurar_baja() {
        $data = array();
        $this->load->model('ayudante_model');
        $data['listado'] = $this->ayudante_model->listar_bajas();
        $data['restaurar'] = '¡ Se ha restaurado al ayudante satisfactoriamente !'; 
        $datos_container['content'] = $this->load->view('ayudante/bajas', $data, true);
	return $datos_container;
    }
    
    public function eliminar($id_ayudante){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {     
        $this->load->model('ayudante_model');
        $this->ayudante_model->baja_ayudante($id_ayudante);
        $this->load->view('header', $this->datos_header('Ayudante'));
	$this->load->view('container', $this->datos_eliminar());
	$this->load->view('footer', $this->datos_crumb());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function restaurar($id_ayudante){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {     
        $this->load->model('ayudante_model');
        $this->ayudante_model->restaurar_ayudante($id_ayudante);
        $this->load->view('header', $this->datos_header('Ayudante'));
	$this->load->view('container', $this->datos_restaurar_baja());
	$this->load->view('footer', $this->datos_crumb_baja());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_eliminar_error() {
        $data = array();
        $data['error'] = '¡ No se pudo eliminar el ayudante !'; 
        $this->load->model('ayudante_model');
        $data['listado'] = $this->ayudante_model->listar_bajas();
        $datos_container['content'] = $this->load->view('ayudante/bajas', $data, true);
	return $datos_container;
    }
    
    public function eliminar_baja($id_ayudante){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {     
        $this->load->model('ayudante_model');
        $ayudante = $this->ayudante_model->es_usado($id_ayudante);
        if($ayudante){
            $this->load->view('header', $this->datos_header('Ayudante'));
            $this->load->view('container', $this->datos_eliminar_error());
            $this->load->view('footer', $this->datos_crumb_baja());
        }
        else {        
            $this->ayudante_model->eliminar_ayudante($id_ayudante);
            $this->load->view('header', $this->datos_header('Ayudante'));
            $this->load->view('container', $this->datos_eliminar_baja());
            $this->load->view('footer', $this->datos_crumb_baja());
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_modificar($data) {
        $datos_modificar['content'] = $this->load->view('ayudante/modificar', $data, true);
	return $datos_modificar;
    }
    
    public function modificar($id_ayudante, $flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array();
        $data['mensaje'] = $flag;
        $this->load->model('ayudante_model');
        $ayudante = $this->ayudante_model->buscar_por_id($id_ayudante);
        $data['id_ayudante'] = $id_ayudante;
        $data['ci'] = $ayudante->ci;
        $data['nombre_ayd'] = $ayudante->nombre_ayd;
        $data['apellidos'] = $ayudante->apellidos;
        $this->load->view('header', $this->datos_header('Modificar Ayudante'));
	$this->load->view('container', $this->datos_modificar($data));
	$this->load->view('footer', $this->datos_crumb_modificar());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function modificar_post($id_ayudante){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {     
        if($this->input->post()){
            $datos_incorrectos=$existe=FALSE;
            $ci = $this->input->post('ci',true);
            $nombre_ayd = $this->input->post('nombre_ayd',true);
            $apellidos = $this->input->post('apellidos',true);
            $this->form_validation->set_rules('ci', 'Carnet de identidad', 'required|integer|exact_length[11]|callback_ci');
            $this->form_validation->set_rules('nombre_ayd', 'Nombre del ayudante', 'required|callback_letras');
            $this->form_validation->set_rules('apellidos', 'Apellidos del ayudante', 'required|callback_letras');
            if ($this->form_validation->run()) {
                if(!$this->existe_ayudante($ci, $id_ayudante)) {
                    $this->load->model('ayudante_model');
                    $this->ayudante_model->modificar_ayudante($id_ayudante, $ci, $nombre_ayd, $apellidos);
                    $this->modificar($id_ayudante, true);
                }
                else 
                    $existe = TRUE;
            }
            else
                $datos_incorrectos = TRUE;
            if($datos_incorrectos || $existe) {
                $data = array();
                if($existe)
                    $data['error'] = 'Ya existe un ayudante con este CI en la BD.';
                $data['id_ayudante'] = $id_ayudante;
                $data['ci'] = $ci;
                $data['nombre_ayd'] = $nombre_ayd;
                $data['apellidos'] = $apellidos;
                $this->load->view('header', $this->datos_header('Modificar Ayudante'));
                $this->load->view('container', $this->datos_modificar($data));
                $this->load->view('footer', $this->datos_crumb_modificar());
            }
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }   
    
    public function letras($str) {
        if (!(bool) preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/i', $str)){
            $this->form_validation->set_message('letras', 'El campo < %s > solo admite letras.');
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    
    public function ci($str) {
        if (!(bool) $this->ci_fecha($str)){
            $this->form_validation->set_message('ci', 'El campo < %s > no es un carnet v&aacute;lido.');
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    
    public function ci_fecha($ci) {
    	$anno='10'.$ci[0].$ci[1];
        $mes=$ci[2].$ci[3];
        $dia=$ci[4].$ci[5];
        return (((int)$mes>0 && (int)$mes<=12) && ((int)$dia>0 && (int)$dia<=days_in_month((int)$mes, (int)$anno))); 
    }

    //------- Migas de Pan (breadcrumb) -----------------------------------------------
    public function datos_crumb() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Ayudante',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
   
    public function datos_crumb_baja() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Bajas Ayudante',
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
		'nombre' => 'Ayudante',
		'direccion' => base_url().'ayudante'
            ),
            2 => array(
		'nombre' => 'Insertar Ayudante',
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
		'nombre' => 'Ayudante',
		'direccion' => base_url().'ayudante'
            ),
            2 => array(
		'nombre' => 'Modificar Ayudante',
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
//		'nombre' => 'Ayudante',
//		'direccion' => base_url().'ayudante'
//            ),
//            2 => array(
//		'nombre' => 'Ver Ayudante',
//		'direccion' => ''
//            )
//	);
//	return $datos_crumb;
//    }
    

}

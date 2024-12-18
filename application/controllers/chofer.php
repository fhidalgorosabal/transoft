<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chofer extends CI_Controller {

    public function __construct() {
	parent::__construct();
        $this->form_validation->set_message('required', 'El campo < %s > es obligatorio.');
        $this->form_validation->set_message('integer', 'El campo< %s > solo admite n&uacute;meros enteros.');
        $this->form_validation->set_message('exact_length', 'El campo < %s > solo admite 11 caracteres.');
    }

    public function index() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
    	$this->load->view('header', $this->datos_header('Chofer'));
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
        $datos_container['content'] = $this->load->view('chofer/listar', $this->listar_choferes(), true);
	return $datos_container;
    }
    
    public function listar_choferes() {
        $listado = array();
        $this->load->model('chofer_model');
        $listado['listado'] = $this->chofer_model->listar_chofer();
        return $listado;
    }
    
    public function exportar($ci, $nombre, $apellidos, $licencia) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $this->load->helper('excel_helper');
        $this->load->model('chofer_model');
        to_excel($this->chofer_model->exportar_chofer(urldecode($ci), urldecode($nombre), urldecode($apellidos), urldecode($licencia)), 'choferes');
    } 
    
    public function datos_buscar($datos_busqueda) {
        $datos_container['content'] = $this->load->view('chofer/listar', $datos_busqueda, true);
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
            $licencia = $this->input->post('licencia',TRUE);
            $datos_busqueda['ci_b'] = $ci;
            $datos_busqueda['nombre_b'] = $nombre;
            $datos_busqueda['apellidos_b'] = $apellidos;
            $datos_busqueda['licencia_b'] = $licencia;
            $this->load->model('chofer_model');
            $datos_busqueda['listado'] = $this->chofer_model->buscar_choferes($ci, $nombre, $apellidos, $licencia);
        }
        else {
            redirect('chofer');
        }
        $this->load->view('header', $this->datos_header('Chofer'));
	$this->load->view('container', $this->datos_buscar($datos_busqueda));
	$this->load->view('footer', $this->datos_crumb());
    }
    
    public function exportar_bajas() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {      
        $this->load->helper('excel_helper');
        $this->load->model('chofer_model');
        to_excel($this->chofer_model->exportar_bajas(), 'choferes_bajas');
    }
    else
        redirect('auth/login', 'refresh');
    }
    
    public function datos_baja() {
        $datos_container['content'] = $this->load->view('chofer/bajas', $this->bajas_choferes(), true);
	return $datos_container;
    }
    
    public function bajas_choferes() {
        $listado = array();
        $this->load->model('chofer_model');
        $listado['listado'] = $this->chofer_model->listar_bajas();
        return $listado;
    }
    
    public function baja() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {     
    	$this->load->view('header', $this->datos_header('Bajas Chofer'));
	$this->load->view('container', $this->datos_baja());
	$this->load->view('footer', $this->datos_crumb_baja());
    }
    else
        redirect('auth/login', 'refresh');
    }
    
    public function existe_chofer($ci, $id_chofer=NULL) {
        $this->load->model('chofer_model');
        if($id_chofer==NULL)
            $row = $this->chofer_model->buscar_por_ci($ci);
        else
            $row = $this->chofer_model->buscar_por_ci_id($ci, $id_chofer);
        if($row!=NULL)
            return TRUE;
        else
            return FALSE;
    }
    
    public function datos_insertar($data) {
        $datos_insertar['content'] = $this->load->view('chofer/insertar', $data, true);
	return $datos_insertar;
    }
    
    public function insertar($flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array();
        $data['mensaje'] = $flag;
        $this->load->model('licencia_model');
        $data['licencias'] = $this->licencia_model->listar_licencia();
        $this->load->view('header', $this->datos_header('Insertar Chofer'));
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
            $nombre_chf = $this->input->post('nombre_chf',true);
            $apellidos = $this->input->post('apellidos',true);
            $id_licencia = $this->input->post('id_licencia',true);
            $this->form_validation->set_rules('ci', 'Carnet de identidad', 'required|integer|exact_length[11]|callback_ci');
            $this->form_validation->set_rules('nombre_chf', 'Nombre del chofer', 'required|callback_letras');
            $this->form_validation->set_rules('apellidos', 'Apellidos del chofer', 'required|callback_letras');
            $this->form_validation->set_rules('id_licencia', 'Licencia de conducción', 'required');           
            if ($this->form_validation->run()) {
                    if(!$this->existe_chofer($ci)) {
                    $this->load->model('chofer_model');
                    $this->chofer_model->insertar_chofer($ci, $nombre_chf, $apellidos, $id_licencia);
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
                    $data['error'] = 'Ya existe un chofer con este CI en la BD.';
                $this->load->model('licencia_model');
                $data['licencias'] = $this->licencia_model->listar_licencia();
                $data['ci'] = $ci;
                $data['nombre_chf'] = $nombre_chf;
                $data['apellidos'] = $apellidos;
                $data['id_licencia'] = $id_licencia; 
                $this->load->view('header', $this->datos_header('Insertar Chofer'));
                $this->load->view('container', $this->datos_insertar($data));
                $this->load->view('footer', $this->datos_crumb()); 

            }
        }
    }
    else
        redirect('auth/login', 'refresh');     
    }
    
    public function datos_eliminar() {
        $data = array();
        $this->load->model('chofer_model');
        $data['listado'] = $this->chofer_model->listar_chofer();
        $data['delete'] = '¡ Se ha dado de baja al chofer satisfactoriamente !'; 
        $datos_container['content'] = $this->load->view('chofer/listar', $data, true);
	return $datos_container;
    }
    
    public function datos_eliminar_baja() {
        $data = array();
        $this->load->model('chofer_model');
        $data['listado'] = $this->chofer_model->listar_bajas();
        $data['delete'] = '¡ Se ha eliminado al chofer satisfactoriamente !'; 
        $datos_container['content'] = $this->load->view('chofer/bajas', $data, true);
	return $datos_container;
    }
    
    public function datos_restaurar_baja() {
        $data = array();
        $this->load->model('chofer_model');
        $data['listado'] = $this->chofer_model->listar_bajas();
        $data['restaurar'] = '¡ Se ha restaurado al chofer satisfactoriamente !'; 
        $datos_container['content'] = $this->load->view('chofer/bajas', $data, true);
	return $datos_container;
    }
    
    public function eliminar($id_chofer){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        $this->load->model('chofer_model');
        $this->chofer_model->baja_chofer($id_chofer);
        $this->load->view('header', $this->datos_header('Chofer'));
	$this->load->view('container', $this->datos_eliminar());
	$this->load->view('footer', $this->datos_crumb());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function restaurar($id_chofer){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        $this->load->model('chofer_model');
        $this->chofer_model->restaurar_chofer($id_chofer);
        $this->load->view('header', $this->datos_header('Bajas Chofer'));
	$this->load->view('container', $this->datos_restaurar_baja());
	$this->load->view('footer', $this->datos_crumb_baja());
    }
    else
        redirect('auth/login', 'refresh'); 
    }
    
    public function datos_eliminar_error() {
        $data = array();
        $data['error'] = '¡ No se pudo eliminar el chofer !'; 
        $this->load->model('chofer_model');
        $data['listado'] = $this->chofer_model->listar_bajas();
        $datos_container['content'] = $this->load->view('chofer/bajas', $data, true);
	return $datos_container;
    }
    
    public function eliminar_baja($id_chofer){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        $this->load->model('chofer_model');
        $chofer = $this->chofer_model->es_usado($id_chofer);
        if($chofer){
            $this->load->view('header', $this->datos_header('Bajas Chofer'));
            $this->load->view('container', $this->datos_eliminar_error());
            $this->load->view('footer', $this->datos_crumb_baja());
        }
        else {        
            $this->chofer_model->eliminar_chofer($id_chofer);
            $this->load->view('header', $this->datos_header('Bajas Chofer'));
            $this->load->view('container', $this->datos_eliminar_baja());
            $this->load->view('footer', $this->datos_crumb_baja());
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_modificar($data) {
        $datos_modificar['content'] = $this->load->view('chofer/modificar', $data, true);
	return $datos_modificar;
    }
    
    public function modificar($id_chofer, $flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array();
        $data['mensaje'] = $flag;
        $this->load->model('licencia_model');
        $data['licencias'] = $this->licencia_model->listar_licencia();
        $this->load->model('chofer_model');
        $chofer = $this->chofer_model->buscar_por_id($id_chofer);
        $data['id_chofer'] = $id_chofer;
        $data['ci'] = $chofer->ci;
        $data['nombre_chf'] = $chofer->nombre_chf;
        $data['apellidos'] = $chofer->apellidos;
        $data['id_licencia'] = $chofer->id_licencia;
        $this->load->view('header', $this->datos_header('Modificar Chofer'));
	$this->load->view('container', $this->datos_modificar($data));
	$this->load->view('footer', $this->datos_crumb_modificar());
    }
    else
        redirect('auth/login', 'refresh');     
   }
    
    public function modificar_post($id_chofer){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        if($this->input->post()){
            $datos_incorrectos=$existe=FALSE;
            $ci = $this->input->post('ci');
            $nombre_chf = $this->input->post('nombre_chf');
            $apellidos = $this->input->post('apellidos');
            $id_licencia = $this->input->post('id_licencia');
            $this->form_validation->set_rules('ci', 'Carnet de identidad', 'required|integer|exact_length[11]|callback_ci');
            $this->form_validation->set_rules('nombre_chf', 'Nombre del chofer', 'required|callback_letras');
            $this->form_validation->set_rules('apellidos', 'Apellidos del chofer', 'required|callback_letras');
            $this->form_validation->set_rules('id_licencia', 'Licencia de conducción', 'required');           
            if ($this->form_validation->run()) {    
                if(!$this->existe_chofer($ci, $id_chofer)) {        
                    $this->load->model('chofer_model');
                    $this->chofer_model->modificar_chofer($id_chofer, $ci, $nombre_chf, $apellidos, $id_licencia);
                    $this->modificar($id_chofer, true);
                }
                else 
                    $existe = TRUE;
            }
            else
                $datos_incorrectos = TRUE;
            if($datos_incorrectos || $existe) {
                $data = array();
                if($existe)
                    $data['error'] = 'Ya existe un chofer con este CI en la BD.';
                $this->load->model('licencia_model');
                $data['licencias'] = $this->licencia_model->listar_licencia();
                $data['id_chofer'] = $id_chofer;
                $data['ci'] = $ci;
                $data['nombre_chf'] = $nombre_chf;
                $data['apellidos'] = $apellidos;
                $data['id_licencia'] = $id_licencia;
                $this->load->view('header', $this->datos_header('Modificar Chofer'));
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
		'nombre' => 'Chofer',
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
		'nombre' => 'Bajas Chofer',
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
		'nombre' => 'Chofer',
		'direccion' => base_url().'chofer'
            ),
            2 => array(
		'nombre' => 'Insertar Chofer',
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
		'nombre' => 'Chofer',
		'direccion' => base_url().'chofer'
            ),
            2 => array(
		'nombre' => 'Modificar Chofer',
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
//		'nombre' => 'Chofer',
//		'direccion' => base_url().'chofer'
//            ),
//            2 => array(
//		'nombre' => 'Ver Chofer',
//		'direccion' => ''
//            )
//	);
//	return $datos_crumb;
//    }
    

}

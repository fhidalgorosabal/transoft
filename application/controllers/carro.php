<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carro extends CI_Controller {
    

    public function __construct() {
	parent::__construct();
        $this->form_validation->set_message('required', 'El campo < %s > es obligatorio.');
        $this->form_validation->set_message('numeric', 'El campo < %s > solo admite n&uacute;meros.');
        $this->form_validation->set_message('integer', 'El campo < %s > solo admite n&uacute;meros enteros.');
        $this->form_validation->set_message('alpha_numeric', 'El campo < %s > solo admite letras y n&uacute;meros.');
        $this->form_validation->set_message('exact_length', 'El campo < %s > admite exactamente 4 caracteres.'); 
        $this->form_validation->set_message('max_length', 'El campo < %s > admite hasta 7 caracteres.'); 
        $this->form_validation->set_message('alpha_dash', 'El campo < %s > solo admite letras, n&uacute;meros y un separador [ \'-\' , \'_\' ] .');             
    }

    public function index() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
    	$this->load->view('header', $this->datos_header('Carro'));
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
        $datos_container['content'] = $this->load->view('carro/listar', $this->listar_carros(), true);
	return $datos_container;
    }
    
    public function listar_carros() {
        $listado = array();
        $this->load->model('carro_model');
        $listado['listado'] = $this->carro_model->listar_carro();
        return $listado;
    }
    
    public function exportar($codigo, $chapa, $marca, $tipo, $estado, $tipo_combustible) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $this->load->helper('excel_helper');
        $this->load->model('carro_model');
        to_excel($this->carro_model->exportar_carro(urldecode($codigo), urldecode($chapa), urldecode($marca), urldecode($tipo), urldecode($estado), urldecode($tipo_combustible)), 'carros');
    }  
    
    public function datos_buscar($datos_busqueda) {
        $datos_container['content'] = $this->load->view('carro/listar', $datos_busqueda, true);
	return $datos_container;
    }  
    
    public function buscar() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $datos_busqueda = array();
        if($this->input->post()){
            $codigo = $this->input->post('codigo',TRUE);            
            $chapa = $this->input->post('chapa',TRUE);
            $marca = $this->input->post('marca',TRUE);
            $tipo = $this->input->post('tipo',TRUE);
            $estado = $this->input->post('estado',TRUE);
            $tipo_combustible = $this->input->post('tipo_combustible',TRUE);
            $datos_busqueda['codigo_b'] = $codigo;
            $datos_busqueda['chapa_b'] = $chapa;
            $datos_busqueda['marca_b'] = $marca;
            $datos_busqueda['tipo_b'] = $tipo;
            $datos_busqueda['estado_b'] = $estado;
            $datos_busqueda['tipo_combustible_b'] = $tipo_combustible;
            $this->load->model('carro_model');
            $datos_busqueda['listado'] = $this->carro_model->buscar_carros($codigo, $chapa, $marca, $tipo, $estado, $tipo_combustible);
        }
        else {
            redirect('carro');
        }
        $this->load->view('header', $this->datos_header('Carro'));
	$this->load->view('container', $this->datos_buscar($datos_busqueda));
	$this->load->view('footer', $this->datos_crumb());
    }
    
    public function exportar_bajas() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {     
        $this->load->helper('excel_helper');
        $this->load->model('carro_model');
        to_excel($this->carro_model->exportar_bajas(), 'carros_bajas');
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_baja() {
        $datos_container['content'] = $this->load->view('carro/bajas', $this->bajas_carros(), true);
	return $datos_container;
    }
    
    public function bajas_carros() {
        $listado = array();
        $this->load->model('carro_model');
        $listado['listado'] = $this->carro_model->listar_bajas();
        return $listado;
    }
    
    public function baja() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {     
    	$this->load->view('header', $this->datos_header('Bajas Carro'));
	$this->load->view('container', $this->datos_baja());
	$this->load->view('footer', $this->datos_crumb_baja());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function existe_carro($codigo, $chapa, $id_carro=NULL) {
        $this->load->model('carro_model');
        if($id_carro==NULL)
            $row = $this->carro_model->buscar_por_codigo_chapa($codigo, $chapa);
        else
            $row = $this->carro_model->buscar_por_codigo_chapa_id($codigo, $chapa, $id_carro);
        if($row!=NULL)
            return TRUE;
        else
            return FALSE;
    }
    
    public function datos_insertar($data) {
        $datos_insertar['content'] = $this->load->view('carro/insertar', $data, true);
	return $datos_insertar;
    }
    
    public function insertar($flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array();
        $data['mensaje'] = $flag;
        $this->load->model('combustible_model');
        $data['combustible'] = $this->combustible_model->listar_combustible();
        $this->load->view('header', $this->datos_header('Insertar Carro'));
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
            $codigo = $this->input->post('codigo',true);
            $chapa = $this->input->post('chapa',true);
            $tipo = $this->input->post('tipo',true);
            $capacidad = $this->input->post('capacidad',true);
            $marca = $this->input->post('marca',true);            
            $anno = $this->input->post('anno',true);
            $estado_tecnico = $this->input->post('estado_tecnico',true);
            $tipo_combustible = $this->input->post('tipo_combustible',true);
            $norma_consumo = $this->input->post('norma_consumo',true);
            $capacidad_tanque = $this->input->post('capacidad_tanque',true);
            $this->form_validation->set_rules('codigo', 'C&oacute;digo del carro', 'required|numeric');
            $this->form_validation->set_rules('chapa', 'Chapa del carro', 'required|alpha_numeric|max_length[7]'); 
            $this->form_validation->set_rules('tipo', 'Tipo', 'required');
            $this->form_validation->set_rules('capacidad', 'Capacidad de carga', 'required|numeric');
            $this->form_validation->set_rules('marca', 'Marca y modelo', 'required|alpha_dash');
            $this->form_validation->set_rules('anno', 'A&ntilde;o de fabricaci&oacute;n', 'required|integer|exact_length[4]'); 
            $this->form_validation->set_rules('estado_tecnico', 'Estado t&eacute;cnico', 'required');
            $this->form_validation->set_rules('tipo_combustible', 'Tipo de combustible', 'required');
            $this->form_validation->set_rules('norma_consumo', 'Norma de consumo', 'required|numeric');
            $this->form_validation->set_rules('capacidad_tanque', 'Capacidad del tanque', 'required|numeric');
            if ($this->form_validation->run()){
                if(!$this->existe_carro($codigo, $chapa)) {
                    $this->load->model('carro_model');
                    $this->carro_model->insertar_carro($codigo, $chapa, $tipo, $capacidad, $marca, $anno, $estado_tecnico, $tipo_combustible, $norma_consumo, $capacidad_tanque);
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
                    $data['error'] = 'No se pudo insertar el carro, verifique que el c&oacute;digo y la chapa sean &uacute;nicos.';
                $this->load->model('combustible_model');
                $data['combustible'] = $this->combustible_model->listar_combustible();
                $data['codigo'] = $codigo;
                $data['chapa'] = $chapa;
                $data['tipo'] = $tipo;
                $data['capacidad'] = $capacidad;           
                $data['marca'] = $marca;           
                $data['anno'] = $anno;           
                $data['estado_tecnico'] = $estado_tecnico;
                $data['tipo_combustible'] = $tipo_combustible;
                $data['norma_consumo'] = $norma_consumo;
                $data['capacidad_tanque'] = $capacidad_tanque;
                $this->load->view('header', $this->datos_header('Insertar Carro'));
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
        $this->load->model('carro_model');
        $data['listado'] = $this->carro_model->listar_carro();
        $data['delete'] = '¡ Se ha dado de baja al carro satisfactoriamente !'; 
        $datos_container['content'] = $this->load->view('carro/listar', $data, true);
	return $datos_container;
    }
    
    public function datos_eliminar_baja() {
        $data = array();
        $this->load->model('carro_model');
        $data['listado'] = $this->carro_model->listar_bajas();
        $data['delete'] = '¡ Se ha eliminado el carro satisfactoriamente !'; 
        $datos_container['content'] = $this->load->view('carro/bajas', $data, true);
	return $datos_container;
    }
    
    public function datos_restaurar_baja() {
        $data = array();
        $this->load->model('carro_model');
        $data['listado'] = $this->carro_model->listar_bajas();
        $data['restaurar'] = '¡ Se ha restaurado el carro satisfactoriamente !'; 
        $datos_container['content'] = $this->load->view('carro/bajas', $data, true);
	return $datos_container;
    }
    
    public function eliminar($id_carro){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) { 
        $this->load->model('carro_model');
        $this->carro_model->baja_carro($id_carro);
        $this->load->view('header', $this->datos_header('Carro'));
	$this->load->view('container', $this->datos_eliminar());
	$this->load->view('footer', $this->datos_crumb());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function restaurar($id_carro){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        $this->load->model('carro_model');
        $this->carro_model->restaurar_carro($id_carro);
        $this->load->view('header', $this->datos_header('Carro'));
	$this->load->view('container', $this->datos_restaurar_baja());
	$this->load->view('footer', $this->datos_crumb_baja());
    }
    else
        redirect('auth/login', 'refresh');     
    }
    
    public function datos_eliminar_error() {
        $data = array();
        $data['error'] = '¡ No se pudo eliminar el carro !'; 
        $this->load->model('carro_model');
        $data['listado'] = $this->carro_model->listar_bajas();
        $datos_container['content'] = $this->load->view('carro/bajas', $data, true);
	return $datos_container;
    }
    
    public function eliminar_baja($id_carro){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {     
        $this->load->model('carro_model');
        $carro_usado = $this->carro_model->es_usado($id_carro);
        $tiene_tarjeta = $this->carro_model->tiene_tarjeta($id_carro);
        if($carro_usado || $tiene_tarjeta){
            $this->load->view('header', $this->datos_header('Carro'));
            $this->load->view('container', $this->datos_eliminar_error());
            $this->load->view('footer', $this->datos_crumb_baja());
        }
        else {        
            $this->carro_model->eliminar_carro($id_carro);
            $this->load->view('header', $this->datos_header('Carro'));
            $this->load->view('container', $this->datos_eliminar_baja());
            $this->load->view('footer', $this->datos_crumb_baja());
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_modificar($data) {
        $datos_modificar['content'] = $this->load->view('carro/modificar', $data, true);
	return $datos_modificar;
    }
    
    public function modificar($id_carro, $flag=false){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        $data = array(); 
        $data['mensaje'] = $flag;
        $this->load->model('combustible_model');
        $data['combustible'] = $this->combustible_model->listar_combustible();
        $this->load->model('carro_model');
        $carro = $this->carro_model->buscar_por_id($id_carro);
        $data['id_carro'] = $id_carro;
        $data['codigo'] = $carro->codigo;
        $data['chapa'] = $carro->chapa;
        $data['tipo'] = $carro->tipo;
        $data['capacidad'] = $carro->capacidad;           
        $data['marca'] = $carro->marca;           
        $data['anno'] = $carro->anno;           
        $data['estado_tecnico'] = $carro->estado_tecnico;
        $data['tipo_combustible'] = $carro->id_combustible;
        $data['norma_consumo'] = $carro->norma_consumo;
        $data['capacidad_tanque'] = $carro->capacidad_tanque;
        $this->load->view('header', $this->datos_header('Modificar Carro'));
	$this->load->view('container', $this->datos_modificar($data));
	$this->load->view('footer', $this->datos_crumb_modificar());
    }
    else
        redirect('auth/login', 'refresh');    
   }
    
    public function modificar_post($id_carro){  
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {     
        if($this->input->post()){
            $datos_incorrectos=$existe=FALSE;
            $codigo = $this->input->post('codigo',true);
            $chapa = $this->input->post('chapa',true);
            $tipo = $this->input->post('tipo',true);
            $capacidad = $this->input->post('capacidad',true);
            $marca = $this->input->post('marca',true);
            $anno = $this->input->post('anno',true);
            $estado_tecnico = $this->input->post('estado_tecnico',true);
            $tipo_combustible = $this->input->post('tipo_combustible',true);
            $norma_consumo = $this->input->post('norma_consumo',true);
            $capacidad_tanque = $this->input->post('capacidad_tanque',true);
            $this->form_validation->set_rules('codigo', 'C&oacute;digo del carro', 'required|numeric');
            $this->form_validation->set_rules('chapa', 'Chapa del carro', 'required|alpha_numeric|max_length[7]'); 
            $this->form_validation->set_rules('tipo', 'Tipo', 'required');
            $this->form_validation->set_rules('capacidad', 'Capacidad de carga', 'required|numeric');
            $this->form_validation->set_rules('marca', 'Marca y modelo', 'required|alpha_dash');
            $this->form_validation->set_rules('anno', 'A&ntilde;o de fabricaci&oacute;n', 'required|integer|exact_length[4]');  
            $this->form_validation->set_rules('estado_tecnico', 'Estado t&eacute;cnico', 'required');
            $this->form_validation->set_rules('tipo_combustible', 'Tipo de combustible', 'required');
            $this->form_validation->set_rules('norma_consumo', 'Norma de consumo', 'required|numeric');
            $this->form_validation->set_rules('capacidad_tanque', 'Capacidad del tanque', 'required|numeric');
            if ($this->form_validation->run()){ 
                if(!$this->existe_carro($codigo, $chapa, $id_carro)) {  
                    $this->load->model('carro_model');
                    $this->carro_model->modificar_carro($id_carro, $codigo, $chapa, $tipo, $capacidad, $marca, $anno, $estado_tecnico, $tipo_combustible, $norma_consumo, $capacidad_tanque);
                    $this->modificar($id_carro, true);
                }
                else 
                    $existe = TRUE;
            }
            else
                $datos_incorrectos = TRUE;
            if($datos_incorrectos || $existe) {
                $data = array();
                if($existe)
                    $data['error'] = 'No se pudo modificar el carro, verifique que el c&oacute;digo y la chapa sean &uacute;nicos.';
                $this->load->model('combustible_model');
                $data['combustible'] = $this->combustible_model->listar_combustible();
                $data['id_carro'] = $id_carro;
                $data['codigo'] = $codigo;
                $data['chapa'] = $chapa;
                $data['tipo'] = $tipo;
                $data['capacidad'] = $capacidad;           
                $data['marca'] = $marca;           
                $data['anno'] = $anno;           
                $data['estado_tecnico'] = $estado_tecnico;
                $data['tipo_combustible'] = $tipo_combustible;
                $data['norma_consumo'] = $norma_consumo;
                $data['capacidad_tanque'] = $capacidad_tanque;
                $this->load->view('header', $this->datos_header('Modificar Carro'));
                $this->load->view('container', $this->datos_modificar($data));
                $this->load->view('footer', $this->datos_crumb());
            }
        }
    }
    else
        redirect('auth/login', 'refresh');    
   }
    
    public function datos_ver($data) {
        $datos_ver['content'] = $this->load->view('carro/ver', $data, true);
	return $datos_ver;
    }   
   
    public function ver($id_carro){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        $data = array(); 
        $this->load->model('carro_model');
        $carro = $this->carro_model->buscar_por_id($id_carro);
        $data['carro'] = $carro;
        $this->load->view('header', $this->datos_header('Ver Carro'));
        $this->load->view('container', $this->datos_ver($data));
        $this->load->view('footer', $this->datos_crumb_ver());
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
		'nombre' => 'Carro',
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
		'nombre' => 'Bajas Carro',
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
		'nombre' => 'Carro',
		'direccion' => base_url().'carro'
            ),
            2 => array(
		'nombre' => 'Insertar Carro',
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
		'nombre' => 'Carro',
		'direccion' => base_url().'carro'
            ),
            2 => array(
		'nombre' => 'Modificar Carro',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
   
    public function datos_crumb_ver() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Carro',
		'direccion' => base_url().'carro'
            ),
            2 => array(
		'nombre' => 'Ver Carro',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
    

}

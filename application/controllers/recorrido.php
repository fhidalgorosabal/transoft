<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recorrido extends CI_Controller {
    private $actividad;
    private $carro;

    public function __construct() {
	parent::__construct();
        $this->form_validation->set_message('required', 'El campo < %s > es obligatorio.');
        $this->form_validation->set_message('numeric', 'El campo < %s > solo admite n&uacute;meros.');
        $this->load->helper('date');
        $this->actividad=0;
        $this->carro=0;
    }

    public function index() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');
        $this->load->model('actividad_model');
        $actividad = $this->actividad_model->buscar_id_actividad(); 
        $this->load->model('carro_model');
        $carro = $this->carro_model->buscar_id_carro(); 
        redirect('recorrido/listar/'.$actividad->id_actividad.'/'.$carro->id_carro.'');
    }
    
    public function fecha_correcta($fecha) {
        $this->load->model('principal_model');
        $var1 = $this->principal_model->mes_procesar();   
        $var2 = $this->principal_model->anno();
        $mes = $var1->mes_procesar; 
        $anno = $var2->anno; 
        $array = preg_split('/(-)/', $fecha);
        if(count($array)==1)
           $array = preg_split('/(\/)/', $fecha);
        return ((int)$array[1]==(int)$mes && (int)$array[0]==(int)$anno);
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
    
    public function listar($id_actividad, $id_carro) {
    if (!$this->ion_auth->logged_in())
        redirect('auth/login', 'refresh');    
        $this->actividad=$id_actividad;
        $this->carro=$id_carro;
    	$this->load->view('header', $this->datos_header('Recorridos'));
	$this->load->view('container', $this->datos_inicio($id_actividad, $id_carro));
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
    
    public function datos_inicio($id_actividad, $id_carro) {
        $datos_container['content'] = $this->load->view('recorrido/listar', $this->listar_recorridos($id_actividad, $id_carro, $this->fecha()), TRUE); 
	return $datos_container;
    }
    
    public function listar_recorridos($id_actividad, $id_carro) {   
        $data = array();
        $this->load->model('actividad_model');
        $data['actividad']=  $this->actividad_model->buscar_por_id($id_actividad, $this->fecha());
        $combustible = $this->actividad_model->buscar_combustible_actividad_x_id($id_actividad);
        $this->load->model('carro_model');
        $data['carros'] = $this->carro_model->buscar_carro_x_combustible($combustible->id_combustible);  
        $data['selected'] = $id_carro;
        $this->load->model('recorrido_model');
        $data['listado'] = $this->recorrido_model->buscar_recorrido($id_actividad, $id_carro, $this->fecha());
        return $data;
    }
    
    public function listar_post() {
    if (!$this->ion_auth->logged_in())
        redirect('auth/login', 'refresh');     
        if($this->input->post()){
            $carro = $this->input->post('carro',TRUE);
            $actividad = $this->input->post('actividad',TRUE);
            $this->actividad=$actividad;
            $this->carro=$carro;
            $this->listar($actividad, $carro);
        }
    }  
    
    public function exportar($id_actividad, $id_carro) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $data = array();
        $this->load->model('recorrido_model');
        $data['listado'] = $this->recorrido_model->buscar_recorrido($id_actividad, $id_carro, $this->fecha());
        $this->load->view('recorrido/exportar_recorridos', $data);
    }    
    
    public function datos_captar($data) {
        $datos['content'] = $this->load->view('recorrido/captar_recorrido', $data, TRUE);
	return $datos;
    }
    
    public function captar($id_actividad, $flag=FALSE, $id_carro=NULL) {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {      
        $data=array();
        $data['mensaje'] = $flag;
        $this->load->model('recorrido_model');
        $configuracion = $this->recorrido_model->configuracion($id_actividad);
        $data['configuracion'] = $configuracion;
        $this->load->model('actividad_model');
        $combustible = $this->actividad_model->buscar_combustible_actividad_x_id($id_actividad);
        $data['actividad'] = $this->actividad_model->buscar_por_id($id_actividad);
        $this->load->model('carro_model');
        $data['carros'] = $this->carro_model->buscar_carro_x_combustible($combustible->id_combustible);
            if($id_carro)
                $data['carro'] = $this->carro = $id_carro;
        $this->load->model('chofer_model');
        $data['choferes'] = $this->chofer_model->listar_chofer();
        if(isset($configuracion->ayudante) && $configuracion->ayudante==1) {
            $this->load->model('ayudante_model');
            $data['ayudantes'] = $this->ayudante_model->listar_ayudante();         
        }
    	$this->load->view('header', $this->datos_header('Captar Recorrido'));
	$this->load->view('container', $this->datos_captar($data));
	$this->load->view('footer', $this->datos_crumb_captar());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function captar_post($id_actividad) {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {      
        $this->load->model('recorrido_model');        
        $configuracion = $this->recorrido_model->configuracion($id_actividad);
        $cant_recorridos = $this->recorrido_model->contar_recorrido();
        $this->load->model('conduce_model');
        if($this->input->post()){
            $datos_incorrectos=$fecha_error=FALSE;
            $cont = $this->input->post('cont',TRUE);
            //-----Recorrido-----------------------
            $id_recorrido = $cant_recorridos->num+1;
            $fecha = $this->input->post('fecha',TRUE);
            $this->form_validation->set_rules('fecha', 'Fecha', 'required');
            if(isset($configuracion->numero_hoja_ruta) && $configuracion->numero_hoja_ruta==1) {
                $numero_hoja_ruta = $this->input->post('numero_hoja_ruta',TRUE);
                $this->form_validation->set_rules('numero_hoja_ruta', 'No. hoja de ruta', 'required|numeric');
            }
            else
                $numero_hoja_ruta = 0;
            if(isset($configuracion->viajes_carga) && $configuracion->viajes_carga==1) {
                $viajes_carga = $this->input->post('viajes_carga',TRUE);
                $this->form_validation->set_rules('viajes_carga', 'Viajes con carga', 'required|numeric');
            }
            else
                $viajes_carga = 0;
            if(isset($configuracion->consumo_combustible) && $configuracion->consumo_combustible==1) {
                $consumo_combustible = $this->input->post('consumo_combustible',TRUE);
                $this->form_validation->set_rules('consumo_combustible', 'C. de combustible', 'numeric');
            }
            else
                $consumo_combustible = 0;
            $id_carro = $this->input->post('id_carro',TRUE);
            $this->form_validation->set_rules('id_carro', 'Chapa del carro', 'required');
            $id_chofer = $this->input->post('id_chofer',TRUE);
            $this->form_validation->set_rules('id_chofer', 'Nombre del chofer', 'required');
            if(isset($configuracion->ayudante) && $configuracion->ayudante==1)
                $id_ayudante = $this->input->post('id_ayudante',TRUE);
            else
                $id_ayudante = 1;
            //-----Conduce-------------------------
            $data = array();
            for ($i = 0; $i < $cont; $i++) {
                if(isset($configuracion->conduce) && $configuracion->conduce==1) {
                    $data[$i]['numero'] = $this->input->post('numero'.$i,TRUE);  
                    $this->form_validation->set_rules('numero'.$i, 'Conduce #:'.($i+1).'', 'callback_numeros'); 
                }
                else 
                    $data[$i]['numero'] = '0';
                if(isset($configuracion->distancia_total) && $configuracion->distancia_total==1) {
                    $data[$i]['distancia_total'] = $this->input->post('distancia_total'.$i,TRUE);               
                    $this->form_validation->set_rules('distancia_total'.$i, 'Distancia total #:'.($i+1).'', 'required|numeric');
                }
                else 
                    $data[$i]['distancia_total'] = '0';
                if(isset($configuracion->distancia_carga) && $configuracion->distancia_carga==1) {
                    $data[$i]['distancia_carga'] = $this->input->post('distancia_carga'.$i,TRUE);
                    if(empty($data[$i]['numero']))
                        $regla = 'numeric';
                    else
                        $regla = 'required|numeric';                
                    $this->form_validation->set_rules('distancia_carga'.$i, 'Distancia con carga #:'.($i+1).'', $regla); 
                }
                else
                    $data[$i]['distancia_carga'] = '0';
                if(isset($configuracion->carga_transportada) && $configuracion->carga_transportada==1) {
                    $data[$i]['carga_transportada'] = $this->input->post('carga_transportada'.$i,TRUE);
                    if(empty($data[$i]['numero']) || $data[$i]['numero']!='0')
                        $regla = 'numeric';
                    else
                        $regla = 'required|numeric';
                    $this->form_validation->set_rules('carga_transportada'.$i, 'Carga transportada #:'.($i+1).'', $regla);
                }
                else
                    $data[$i]['carga_transportada'] = '0';
            }
            if ($this->form_validation->run()){
                if($this->fecha_correcta($fecha)) {
                    $this->recorrido_model->captar_recorrido($id_recorrido, $fecha, $numero_hoja_ruta, $viajes_carga, $consumo_combustible, $id_actividad, $id_carro, $id_chofer, $id_ayudante);            
                    $total_distancia_carga = 0;
                    foreach ($data as $value) {
                        if($value['carga_transportada']!='0' && $value['distancia_carga']!='0') {
                            $total_distancia_carga += $value['distancia_carga'];
                            $trafico_producido = $total_distancia_carga * $value['carga_transportada'];
                        }
                        else 
                            $trafico_producido = '0';
                        $this->conduce_model->insertar_conduce($value['numero'], $value['distancia_total'], $value['distancia_carga'], $value['carga_transportada'], $trafico_producido, $id_recorrido);
                    }
                    $this->captar($id_actividad, TRUE, $id_carro);
                }
                else
                    $fecha_error=TRUE;
            }
            else 
                $datos_incorrectos=TRUE;
            if($datos_incorrectos || $fecha_error) {
                $datos_recorrido = array();
                if($fecha_error)
                    $datos_recorrido['error'] = 'No se pudo captar el recorrido, verifique que la fecha sea correcta.';
                $datos_recorrido['configuracion'] = $configuracion;
                $this->load->model('actividad_model');
                $combustible = $this->actividad_model->buscar_combustible_actividad_x_id($id_actividad);
                $datos_recorrido['actividad'] = $this->actividad_model->buscar_por_id($id_actividad);
                $this->load->model('carro_model');
                $datos_recorrido['carros'] = $this->carro_model->buscar_carro_x_combustible($combustible->id_combustible);
                $this->load->model('chofer_model');
                $datos_recorrido['choferes'] = $this->chofer_model->listar_chofer();
                $this->load->model('ayudante_model');
                $datos_recorrido['ayudantes'] = $this->ayudante_model->listar_ayudante();
                $datos_recorrido['fecha'] = $fecha;                
                $datos_recorrido['numero_hoja_ruta'] = $numero_hoja_ruta;                
                $datos_recorrido['viajes_carga'] = $viajes_carga;                
                $datos_recorrido['consumo_combustible'] = $consumo_combustible;                
                $datos_recorrido['id_actividad'] = $id_actividad;                
                $datos_recorrido['id_carro'] = $id_carro;                
                $datos_recorrido['id_chofer'] = $id_chofer;                
                $datos_recorrido['id_ayudante'] = $id_ayudante;
                $datos_recorrido['listado_conduce']=$data;
                $this->load->view('header', $this->datos_header('Captar Recorrido'));
                $this->load->view('container', $this->datos_captar($datos_recorrido));
                $this->load->view('footer', $this->datos_crumb_captar());
            }
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }    
    
    public function datos_modificar($data) {
        $datos['content'] = $this->load->view('recorrido/modificar_recorrido', $data, TRUE);
	return $datos;
    }
    
    public function modificar($id_recorrido ,$id_actividad, $flag=FALSE) {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        $data=array();
        $data['mensaje'] = $flag;
        $data['id_recorrido'] = $id_recorrido;
        $this->load->model('recorrido_model');
        $configuracion = $this->recorrido_model->configuracion($id_actividad);
        $recorridos = $this->recorrido_model->ver_recorrido($id_recorrido); 
        $data['configuracion'] = $configuracion;
        $this->load->model('actividad_model');
        $combustible = $this->actividad_model->buscar_combustible_actividad_x_id($id_actividad);
        $data['actividad'] = $this->actividad_model->buscar_por_id($id_actividad);
        $this->load->model('carro_model');
        $data['carros'] = $this->carro_model->buscar_carro_x_combustible($combustible->id_combustible);
        $this->load->model('chofer_model');
        $data['choferes'] = $this->chofer_model->listar_chofer();         
        $this->load->model('conduce_model');
        $data['listado_conduce'] = $this->conduce_model->buscar_por_id($id_recorrido);
        if(isset($configuracion->fecha) && $configuracion->fecha==1)
            $data['fecha'] = $recorridos->fecha;   
        if(isset($configuracion->numero_hoja_ruta) && $configuracion->numero_hoja_ruta==1)
            $data['numero_hoja_ruta'] = $recorridos->numero_hoja_ruta; 
        if(isset($configuracion->viajes_carga) && $configuracion->viajes_carga==1)
            $data['viajes_carga'] = $recorridos->viajes_carga;  
        if(isset($configuracion->consumo_combustible) && $configuracion->consumo_combustible==1)
            $data['consumo_combustible'] = $recorridos->consumo_combustible; 
        if(isset($configuracion->ayudante) && $configuracion->ayudante==1) {
            $this->load->model('ayudante_model');
            $data['ayudantes'] = $this->ayudante_model->listar_ayudante();                
            $data['id_ayudante'] = $recorridos->id_ayudante;   
        }               
        $data['id_actividad'] = $this->actividad = $recorridos->id_actividad;                
        $data['id_carro'] = $this->carro = $recorridos->id_carro;                
        $data['id_chofer'] = $recorridos->id_chofer;   
    	$this->load->view('header', $this->datos_header('Modificar Recorrido'));
	$this->load->view('container', $this->datos_modificar($data));
	$this->load->view('footer', $this->datos_crumb_modificar());
    }
    else
        redirect('auth/login', 'refresh');
    }
    
    public function modificar_post($id_recorrido, $id_actividad) {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        $this->load->model('recorrido_model');        
        $configuracion = $this->recorrido_model->configuracion($id_actividad);
        $this->load->model('conduce_model');
        if($this->input->post()){
            $datos_incorrectos=$fecha_error=FALSE;
            $cont = $this->input->post('cont',TRUE);            
            //-----Recorrido-----------------------
            $fecha = $this->input->post('fecha',TRUE);
            $this->form_validation->set_rules('fecha', 'Fecha', 'required');
            if(isset($configuracion->numero_hoja_ruta) && $configuracion->numero_hoja_ruta==1) {
                $numero_hoja_ruta = $this->input->post('numero_hoja_ruta',TRUE);
                $this->form_validation->set_rules('numero_hoja_ruta', 'No. hoja de ruta', 'required|numeric');
            }
            else
                $numero_hoja_ruta = 0;
            if(isset($configuracion->viajes_carga) && $configuracion->viajes_carga==1) {
                $viajes_carga = $this->input->post('viajes_carga',TRUE);
                $this->form_validation->set_rules('viajes_carga', 'Viajes con carga', 'required|numeric');
            }
            else
                $viajes_carga = 0;
            if(isset($configuracion->consumo_combustible) && $configuracion->consumo_combustible==1) {
                $consumo_combustible = $this->input->post('consumo_combustible',TRUE);
                $this->form_validation->set_rules('consumo_combustible', 'C. de combustible', 'numeric');
            }
            else
                $consumo_combustible = 0;
            $id_carro = $this->input->post('id_carro',TRUE);
            $this->form_validation->set_rules('id_carro', 'Chapa del carro', 'required');
            $id_chofer = $this->input->post('id_chofer',TRUE);
            $this->form_validation->set_rules('id_chofer', 'Nombre del chofer', 'required');
            if(isset($configuracion->ayudante) && $configuracion->ayudante==1)
                $id_ayudante = $this->input->post('id_ayudante',TRUE);
            else
                $id_ayudante = 1;
            //-----Conduce-------------------------
            $data = array();
            for ($i = 0; $i < $cont; $i++) {
                if(isset($configuracion->conduce) && $configuracion->conduce==1) {
                    $data[$i]['numero'] = $this->input->post('numero'.$i,TRUE);  
                    $this->form_validation->set_rules('numero'.$i, 'Conduce #:'.($i+1).'', 'callback_numeros'); 
                }
                else 
                    $data[$i]['numero'] = '0';
                if(isset($configuracion->distancia_total) && $configuracion->distancia_total==1) {
                    $data[$i]['distancia_total'] = $this->input->post('distancia_total'.$i,TRUE);               
                    $this->form_validation->set_rules('distancia_total'.$i, 'Distancia total #:'.($i+1).'', 'required|numeric');
                }
                else 
                    $data[$i]['distancia_total'] = '0';
                if(isset($configuracion->distancia_carga) && $configuracion->distancia_carga==1) {
                    $data[$i]['distancia_carga'] = $this->input->post('distancia_carga'.$i,TRUE);
                    if(empty($data[$i]['numero']))
                        $regla = 'numeric';
                    else
                        $regla = 'required|numeric';                
                    $this->form_validation->set_rules('distancia_carga'.$i, 'Distancia con carga #:'.($i+1).'', $regla); 
                }
                else
                    $data[$i]['distancia_carga'] = '0';
                if(isset($configuracion->carga_transportada) && $configuracion->carga_transportada==1) {
                    $data[$i]['carga_transportada'] = $this->input->post('carga_transportada'.$i,TRUE);
                    if(empty($data[$i]['numero']) || $data[$i]['numero']!='0')
                        $regla = 'numeric';
                    else
                        $regla = 'required|numeric';
                    $this->form_validation->set_rules('carga_transportada'.$i, 'Carga transportada #:'.($i+1).'', $regla);
                }
                else
                    $data[$i]['carga_transportada'] = '0';
            }
            if ($this->form_validation->run()){
                if($this->fecha_correcta($fecha)) {
                    $this->recorrido_model->modificar_recorrido($id_recorrido, $fecha, $numero_hoja_ruta, $viajes_carga, $consumo_combustible, $id_actividad, $id_carro, $id_chofer, $id_ayudante);            
                    $this->conduce_model->eliminar_conduce($id_recorrido);
                    $total_distancia_carga = 0;                
                    foreach ($data as $value) {
                        if($value['carga_transportada']!='0' && $value['distancia_carga']!='0') {
                            $total_distancia_carga += $value['distancia_carga'];
                            $trafico_producido = $total_distancia_carga * $value['carga_transportada'];
                        }
                        else 
                            $trafico_producido = '0';
                        $this->conduce_model->insertar_conduce($value['numero'], $value['distancia_total'], $value['distancia_carga'], $value['carga_transportada'], $trafico_producido, $id_recorrido);
                    }
                    $this->modificar($id_recorrido, $id_actividad, TRUE);
                }
                else
                    $fecha_error=TRUE;
            }
            else 
                $datos_incorrectos=TRUE;
            if($datos_incorrectos || $fecha_error) {
                $datos_recorrido = array();
                if($fecha_error)
                    $datos_recorrido['error'] = 'No se pudo modificar el recorrido, verifique que la fecha sea correcta.';
                $datos_recorrido['configuracion'] = $configuracion;
                $this->load->model('actividad_model');
                $combustible = $this->actividad_model->buscar_combustible_actividad_x_id($id_actividad);
                $datos_recorrido['actividad'] = $this->actividad_model->buscar_por_id($id_actividad);
                $this->load->model('carro_model');
                $datos_recorrido['carros']  = $this->carro_model->buscar_carro_x_combustible($combustible->id_combustible);
                $this->load->model('chofer_model');
                $datos_recorrido['choferes'] = $this->chofer_model->listar_chofer();
                $this->load->model('ayudante_model');
                $datos_recorrido['ayudantes'] = $this->ayudante_model->listar_ayudante();
                $datos_recorrido['fecha'] = $fecha;                
                $datos_recorrido['numero_hoja_ruta'] = $numero_hoja_ruta;                
                $datos_recorrido['viajes_carga'] = $viajes_carga;                
                $datos_recorrido['consumo_combustible'] = $consumo_combustible;                
                $datos_recorrido['id_actividad'] = $id_actividad;                
                $datos_recorrido['id_carro'] = $id_carro;                
                $datos_recorrido['id_chofer'] = $id_chofer;                
                $datos_recorrido['id_ayudante'] = $id_ayudante;
                $datos_recorrido['listado_conduce']=$data;
                $datos_recorrido['id_recorrido']=$id_recorrido;
                $this->load->view('header', $this->datos_header('Modificar Recorrido'));
                $this->load->view('container', $this->datos_modificar($datos_recorrido));
                $this->load->view('footer', $this->datos_crumb_modificar());
            }
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_eliminar($id_actividad, $id_carro) {
        $data = array();
        $data['delete'] = '¡ Se ha eliminado el recorrido satisfactoriamente !';
        $this->load->model('actividad_model');
        $data['actividad']=  $this->actividad_model->buscar_por_id($id_actividad);
        $this->load->model('carro_model');
        $data['carros'] = $this->carro_model->listar_carro();  
        $data['selected'] = $id_carro;
        $this->load->model('recorrido_model');
        $data['listado'] = $this->recorrido_model->buscar_recorrido($id_actividad, $id_carro, $this->fecha());
        $datos_container['content'] = $this->load->view('recorrido/listar', $data, TRUE); 
	return $datos_container;
    }
    
    public function eliminar($id_recorrido, $id_actividad, $id_carro){
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        $this->load->model('conduce_model');
        $this->conduce_model->eliminar_conduce($id_recorrido);
        $this->load->model('recorrido_model');
        $this->recorrido_model->eliminar_recorrido($id_recorrido);
        $this->load->view('header', $this->datos_header('Recorridos'));
	$this->load->view('container', $this->datos_eliminar($id_actividad, $id_carro));
	$this->load->view('footer', $this->datos_crumb());
    }
    else
        redirect('auth/login', 'refresh');    
    }  
    
    public function datos_ver($data) {
        $datos_ver['content'] = $this->load->view('recorrido/ver', $data, TRUE);
	return $datos_ver;
    }   
   
    public function ver($id_recorrido, $id_actividad, $id_carro){
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $data = array(); 
        $this->load->model('conduce_model');
        $data['conduces'] = $this->conduce_model->buscar_por_id($id_recorrido);
        $this->load->model('recorrido_model');
        $data['recorrido'] = $this->recorrido_model->ver_recorrido($id_recorrido);
        $data['id_actividad'] = $this->actividad = $id_actividad;
        $data['id_carro'] = $this->carro = $id_carro;
        $this->load->view('header', $this->datos_header('Ver Recorrido'));
        $this->load->view('container', $this->datos_ver($data));
        $this->load->view('footer', $this->datos_crumb_ver());
    }
    
    public function datos_x_actividad($actividad, $flag=FALSE) {
        $this->load->model('recorrido_model');
        $data['configuracion'] = $this->recorrido_model->configuracion($actividad);
        $data['actividad'] = $actividad;
        $data['mensaje'] = $flag;
        $datos_container['content'] = $this->load->view('recorrido/configuracion', $data, TRUE); 
	return $datos_container;
    }
    
    public function configuracion() { 
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {    
        if($this->input->post()){
            $actividad = $this->input->post('actividad',TRUE);  
            $this->load->view('header', $this->datos_header('Configuraci&oacute;n'));
            $this->load->view('container', $this->datos_x_actividad($actividad));
            $this->load->view('footer', $this->datos_crumb_configuracion());
        }
        else {
            $this->load->model('actividad_model');
            $actividad = $this->actividad_model->buscar_id_actividad();
            $this->load->view('header', $this->datos_header('Configuraci&oacute;n'));
            $this->load->view('container', $this->datos_x_actividad($actividad->id_actividad));
            $this->load->view('footer', $this->datos_crumb_configuracion());
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function configuracion_post() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {     
        if($this->input->post()){
            $fecha = '1';             
            $hoja_ruta = $this->input->post('hoja_ruta',TRUE); 
            if($hoja_ruta==NULL)
                $hoja_ruta='0';
            $viajes_carga = $this->input->post('viajes_carga',TRUE); 
            if($viajes_carga==NULL)
                $viajes_carga='0';
            $consumo_combustible = $this->input->post('consumo_combustible',TRUE); 
            if($consumo_combustible==NULL)
                $consumo_combustible='0';
            $conduce = $this->input->post('conduce',TRUE); 
            if($conduce==NULL)
                $conduce='0';
            $distancia_total = $this->input->post('distancia_total',TRUE);
            if($distancia_total==NULL)
                $distancia_total='0';
            $distancia_carga = $this->input->post('distancia_carga',TRUE);
            if($distancia_carga==NULL)
                $distancia_carga='0';
            $carga_transportada = $this->input->post('carga_transportada',TRUE); 
            if($carga_transportada==NULL)
                $carga_transportada='0';
            $carro = '1'; 
            $chofer = '1';  
            $ayudante = $this->input->post('ayudante',TRUE);
            if($ayudante==NULL)
                $ayudante='0';
            $actividad = $this->input->post('actividad',TRUE);
            $id_configuracion = $this->input->post('id_configuracion',TRUE);
            $this->load->model('recorrido_model');
            $this->recorrido_model->guardar_configuracion($fecha, $hoja_ruta, $viajes_carga, $consumo_combustible, $conduce, $distancia_total, $distancia_carga, $carga_transportada, $carro, $chofer, $ayudante, $actividad, $id_configuracion);
            $this->load->view('header', $this->datos_header('Configuraci&oacute;n'));
            $this->load->view('container', $this->datos_x_actividad($actividad, TRUE));
            $this->load->view('footer', $this->datos_crumb_configuracion());
        } 
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_reporte($title, $data) {
	$datos = array();
        $datos['titulo'] = $title; 
        $datos['actividades'] = $data['actividades'];
        $datos['actividad'] = $data['actividad'];
        $datos['reporte'] = $this->load->view('recorrido/tabla_reporte', $data, TRUE);
	return $datos;
    }
    
    public function reporte_recorrido() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh'); 
        $data = array();
        $this->load->model('recorrido_model');
        $data['listado'] = $this->recorrido_model->reporte_recorrido($this->fecha());
        $data['actividades'] = NULL;
        $data['actividad'] = NULL;
        $data['fecha'] = $this->fecha();
        $this->load->view('reporte_r', $this->datos_reporte('Reporte de todos los recorridos', $data));
    }
    
    public function reporte_recorrido_acumulado() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh'); 
        $data = array();
        if($this->input->post()) {
            $mes = $this->input->post('mes',TRUE);
            $anno = $this->input->post('anno',TRUE);
            $id_actividad = $this->input->post('actividad',TRUE);
            $fecha['max_dias'] = days_in_month($mes, $anno);
            $fecha['mes'] = $mes;
            $fecha['anno'] = $anno;
        }
        else
            $fecha = $this->fecha(TRUE); 
        $this->load->model('recorrido_model');
        if(isset($id_actividad) && $id_actividad!='general') {
            $data['actividad'] = $id_actividad;
            $data['listado'] = $this->recorrido_model->reporte_x_actividad($id_actividad, $fecha);
        }
        else {
            $data['actividad'] = NULL;
            $data['listado'] = $this->recorrido_model->reporte_recorrido($fecha);
        }
        $this->load->model('actividad_model');
        $data['actividades'] = $this->actividad_model->listar_actividad(); 
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
        $this->load->view('reporte_r', $this->datos_reporte('Reporte de los recorridos', $data));
    }
    
    
    public function reporte_recorrido_exportar() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');  
        $data = array();
        $this->load->model('recorrido_model');
        $data['listado'] = $this->recorrido_model->reporte_recorrido($this->fecha());
        $this->load->view('recorrido/exportar_reporte', $data);
    }
    
    public function reporte_por_actividad($id_actividad) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');
        $data = array();
        $this->load->model('recorrido_model');
        $data['listado'] = $this->recorrido_model->reporte_x_actividad($id_actividad, $this->fecha());
        $this->load->model('actividad_model');
        $data['actividades'] = $this->actividad_model->listar_actividad(); 
        $data['actividad'] = $id_actividad;
        $data['fecha'] = $this->fecha();
        $this->load->view('reporte_r', $this->datos_reporte('Reporte de los recorridos por actividad', $data));
    }
    
    public function reporte_por_actividad_post() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        if($this->input->post()){
            $data = array();
            $id_actividad = $this->input->post('actividad',TRUE);
            $this->load->model('recorrido_model');
            $data['listado'] = $this->recorrido_model->reporte_x_actividad($id_actividad, $this->fecha());
            $this->load->model('actividad_model');
            $data['actividades'] = $this->actividad_model->listar_actividad(); 
            $data['actividad'] = $id_actividad;
            $data['fecha'] = $this->fecha();
            $this->load->view('reporte_r', $this->datos_reporte('Reporte por actividad', $data));
        }
    }
    
    public function reporte_por_actividad_exportar($id_actividad) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');  
        $data = array();
        $this->load->model('recorrido_model');
        $data['listado'] = $this->recorrido_model->reporte_x_actividad($id_actividad, $this->fecha());
        $data['n_act'] = $id_actividad;
        $this->load->view('recorrido/exportar_reporte', $data);
    }
        
    public function datos_carga_transportada($title, $data) {
        $datos = array();
        $datos['titulo'] = $title; 
        $datos['reporte'] = $this->load->view('recorrido/tabla_reporte_carga', $data, TRUE);
	return $datos;
    }
    
    public function reporte_carga_transportada() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');
        $data = array();        
        $data['fecha'] = $fecha = $this->fecha();
        $this->load->model('actividad_model');
        $this->load->model('chofer_model');
        $this->load->model('ayudante_model');   
        $this->load->model('recorrido_model');      
        $actividades = $this->actividad_model->listar_actividad();
        $choferes = $this->chofer_model->listar_chofer();
        $ayudantes = $this->ayudante_model->listar_ayudante();
        $listado = $listado_actividades = $listado_personas = array();
        $i=1;
        foreach ($actividades as $actividad) {
            $listado_actividades[$i]['nombre']=$actividad->nombre_act;
            $listado_actividades[$i]['id']=$actividad->id_actividad;
            foreach ($choferes as $chofer) {
                $recorridos = $this->recorrido_model->cargas_transportadas_chofer($chofer->id_chofer, $actividad->id_actividad, $fecha);
                $carga = 0;
                foreach ($recorridos as $value) {
                    if($value->id_ayudante==1)
                        $carga += $value->carga_transportada;
                    else
                        $carga += $value->carga_transportada/2;
                }
                $listado[$actividad->id_actividad][$chofer->ci] = $carga;
            }
            foreach ($ayudantes as $ayudante) {
                $row = $this->recorrido_model->cargas_transportadas_ayudante($ayudante->id_ayudante, $actividad->id_actividad, $fecha);
                $carga = $row->carga_transportada/2;
                $listado[$actividad->id_actividad][$ayudante->ci] = $carga;
            }
            $i++;
        }
        $j=1;
        foreach ($choferes as $chofer) {
            $listado_personas[$j]['nombre'] = $chofer->nombre_chf;
            $listado_personas[$j]['id'] = $chofer->ci;
            $listado_personas[$j]['tipo'] = 1;
            $j++;
        }
        foreach ($ayudantes as $ayudante) {
            $listado_personas[$j]['nombre'] = $ayudante->nombre_ayd;
            $listado_personas[$j]['id'] = $ayudante->ci;
            $listado_personas[$j]['tipo'] = 2;
            $j++;
        }
        $data['listado'] = $listado;
        $data['actividades'] = $listado_actividades;
        $data['personas'] = $listado_personas;
        $this->load->view('reporte_cg', $this->datos_carga_transportada('Reporte de las cargas transportadas', $data));
    }
        
    public function datos_carga_transportada_acumulado($title, $data) {
        $datos = array();
        $datos['titulo'] = $title; 
        $datos['acumulado'] = TRUE;
        $meses = array();
        $nombre_mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $temp = $this->fecha(TRUE);
        for($i=1; $i<=(int)$temp['mes']; $i++) {
            $meses[$i]['nombre'] = $nombre_mes[$i];
            $meses[$i]['id'] = $i;
        } 
        $datos['meses'] = $meses;
        $annos = array();
        $var = $this->recorrido_model->ultima_fecha();
        $i=1;
        foreach ($var as $value) {
            $annos[$i]['id'] = $value->anno;
            $i++;
        }
        $datos['anno'] = $annos;
        $datos['reporte'] = $this->load->view('recorrido/tabla_reporte_carga', $data, TRUE);
	return $datos;
    }
    
    public function reporte_carga_transportada_acumulado() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');
        $data = array();     
        $this->load->model('recorrido_model');  
        if($this->input->post()) {
            $mes = $this->input->post('mes',TRUE);
            $anno = $this->input->post('anno',TRUE);
            $fecha['max_dias'] = days_in_month($mes, $anno);
            $fecha['mes'] = $mes;
            $fecha['anno'] = $anno;
        }
        else
            $fecha = $this->fecha(TRUE);     
        $data['fecha'] = $fecha;
        $this->load->model('actividad_model');
        $this->load->model('chofer_model');
        $this->load->model('ayudante_model');   
        $this->load->model('recorrido_model');      
        $actividades = $this->actividad_model->listar_actividad();
        $choferes = $this->chofer_model->listar_chofer();
        $ayudantes = $this->ayudante_model->listar_ayudante();
        $listado = $listado_actividades = $listado_personas = array();
        $i=1;
        foreach ($actividades as $actividad) {
            $listado_actividades[$i]['nombre']=$actividad->nombre_act;
            $listado_actividades[$i]['id']=$actividad->id_actividad;
            foreach ($choferes as $chofer) {
                $recorridos = $this->recorrido_model->cargas_transportadas_chofer($chofer->id_chofer, $actividad->id_actividad, $fecha);
                $carga = 0;
                foreach ($recorridos as $value) {
                    if($value->id_ayudante==1)
                        $carga += $value->carga_transportada;
                    else
                        $carga += $value->carga_transportada/2;
                }
                $listado[$actividad->id_actividad][$chofer->ci] = $carga;
            }
            foreach ($ayudantes as $ayudante) {
                $row = $this->recorrido_model->cargas_transportadas_ayudante($ayudante->id_ayudante, $actividad->id_actividad, $fecha);
                $carga = $row->carga_transportada/2;
                $listado[$actividad->id_actividad][$ayudante->ci] = $carga;
            }
            $i++;
        }
        $j=1;
        foreach ($choferes as $chofer) {
            $listado_personas[$j]['nombre'] = $chofer->nombre_chf;
            $listado_personas[$j]['id'] = $chofer->ci;
            $listado_personas[$j]['tipo'] = 1;
            $j++;
        }
        foreach ($ayudantes as $ayudante) {
            $listado_personas[$j]['nombre'] = $ayudante->nombre_ayd;
            $listado_personas[$j]['id'] = $ayudante->ci;
            $listado_personas[$j]['tipo'] = 2;
            $j++;
        }
        $data['listado'] = $listado;
        $data['actividades'] = $listado_actividades;
        $data['personas'] = $listado_personas;
        $this->load->view('reporte_cg', $this->datos_carga_transportada_acumulado('Reporte de las cargas transportadas', $data));
    }
    
    public function exportar_reporte_carga_transportada($mes=NULL, $anno=NULL) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');
        $data = array();   
        if($mes!=NULL && $anno!=NULL) {
            $fecha['max_dias'] = days_in_month($mes, $anno);
            $fecha['mes'] = $data['n_mes'] = $mes;
            $fecha['anno'] = $data['n_anno'] = $anno; 
        }
        else
            $fecha = $this->fecha();
        $this->load->model('actividad_model');
        $this->load->model('chofer_model');
        $this->load->model('ayudante_model');   
        $this->load->model('recorrido_model');      
        $actividades = $this->actividad_model->listar_actividad();
        $choferes = $this->chofer_model->listar_chofer();
        $ayudantes = $this->ayudante_model->listar_ayudante();
        $listado = $listado_actividades = $listado_personas = array();
        $i=1;
        foreach ($actividades as $actividad) {
            $listado_actividades[$i]['nombre']=$actividad->nombre_act;
            $listado_actividades[$i]['id']=$actividad->id_actividad;
            foreach ($choferes as $chofer) {
                $recorridos = $this->recorrido_model->cargas_transportadas_chofer($chofer->id_chofer, $actividad->id_actividad, $fecha);
                $carga = 0;
                foreach ($recorridos as $value) {
                    if($value->id_ayudante==1)
                        $carga += $value->carga_transportada;
                    else
                        $carga += $value->carga_transportada/2;
                }
                $listado[$actividad->id_actividad][$chofer->ci] = $carga;
            }
            foreach ($ayudantes as $ayudante) {
                $row = $this->recorrido_model->cargas_transportadas_ayudante($ayudante->id_ayudante, $actividad->id_actividad, $fecha);
                $carga = $row->carga_transportada/2;
                $listado[$actividad->id_actividad][$ayudante->ci] = $carga;
            }
            $i++;
        }
        $j=1;
        foreach ($choferes as $chofer) {
            $listado_personas[$j]['nombre'] = $chofer->nombre_chf;
            $listado_personas[$j]['id'] = $chofer->ci;
            $listado_personas[$j]['tipo'] = 1;
            $j++;
        }
        foreach ($ayudantes as $ayudante) {
            $listado_personas[$j]['nombre'] = $ayudante->nombre_ayd;
            $listado_personas[$j]['id'] = $ayudante->ci;
            $listado_personas[$j]['tipo'] = 2;
            $j++;
        }
        $data['listado'] = $listado;
        $data['actividades'] = $listado_actividades;
        $data['personas'] = $listado_personas;
        $this->load->view('recorrido/exportar_reporte_carga', $data);
    }
    
    public function reporte_recorrido_acumulado_exportar($actividad_e=NULL, $mes_e=NULL, $anno_e=NULL) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh'); 
        $data = array();
        $this->load->model('principal_model');  
        if($mes_e!=NULL && $anno_e!=NULL) {
            $mes = $mes_e;
            $anno = $anno_e;
            $fecha['max_dias'] = days_in_month($mes, $anno);
            $fecha['mes'] = $data['n_mes'] = $mes;
            $fecha['anno'] = $data['n_anno'] = $anno;
        }
        else {
            $fecha = $this->fecha(TRUE); 
        }  
        if($actividad_e!=NULL)
            $id_actividad = urldecode($actividad_e); 
        else
            $id_actividad = $actividad_e; 
        $this->load->model('recorrido_model');
        if($id_actividad==NULL || $id_actividad=='NULL') {
            $data['actividad'] = NULL;
            $data['listado'] = $this->recorrido_model->reporte_recorrido($fecha);
        }
        else {
            $data['n_act'] = $id_actividad;
            $data['actividad'] = $id_actividad;
            $data['listado'] = $this->recorrido_model->reporte_x_actividad($id_actividad, $fecha);
        }
        $this->load->view('recorrido/exportar_reporte', $data);
    }
    
    public function numeros($str) {
        if ($str!='' &&!(bool) preg_match('/^[0-9]+(-[0-9]+)?$/i', $str)){
            $this->form_validation->set_message('numeros', 'El campo < %s > solo admite n&uacute;meros y/o un separador ( - ).');
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
		'nombre' => 'Recorrido',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
    
    public function datos_crumb_captar() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Captar Recorrido',
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
		'nombre' => 'Recorrido',
		'direccion' => base_url().'recorrido/listar/'.$this->actividad.'/'.$this->carro
            ),
            2 => array(
		'nombre' => 'Modificar Recorrido',
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
		'nombre' => 'Recorrido',
		'direccion' => base_url().'recorrido/listar/'.$this->actividad.'/'.$this->carro
            ),
            2 => array(
		'nombre' => 'Ver Recorrido',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
    
    public function datos_crumb_configuracion() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Configuraci&oacute;n',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
    
}


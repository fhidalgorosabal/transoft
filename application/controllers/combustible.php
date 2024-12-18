<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Combustible extends CI_Controller {

    public function __construct() {
	parent::__construct();
        $this->form_validation->set_message('required', 'El campo < %s > es obligatorio.');
        $this->form_validation->set_message('numeric', 'El campo < %s > solo admite n&uacute;meros.');
    }

    public function index() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');     
    	$this->load->view('header', $this->datos_header('Ver Habilitados'));
	$this->load->view('container', $this->datos_inicio());
	$this->load->view('footer', $this->datos_crumb());
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
    
    public function datos_inicio() {
        $datos_container['content'] = $this->load->view('combustible/listar', $this->listar_habilitados(), true);
	return $datos_container;
    }
    
    public function listar_habilitados() {
        $listado = array();
        $this->load->model('combustible_model');
        $listado['listado'] = $this->combustible_model->listar_habilitados($this->fecha());
        return $listado;
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
    
    public function datos_habilitar($flag=FALSE) {
        $this->load->model('carro_model');
        $data['carros'] = $this->carro_model->listar_carro(); 
        $data['tarjetas'] = NULL;
        $data['mensaje'] = $flag;
        $datos_container['content'] = $this->load->view('combustible/habilitar', $data, true);
	return $datos_container;
    }
    
    public function habilitar($flag=FALSE) {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
    	$this->load->view('header', $this->datos_header('Habilitar'));
	$this->load->view('container', $this->datos_habilitar($flag));
	$this->load->view('footer', $this->datos_crumb_habilitar());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_listar($data) {
        $datos_container['content'] = $this->load->view('combustible/habilitar', $data, true);
	return $datos_container;
    }
    
    public function listar_tarjetas() {
        $data = array();
        $this->load->model('carro_model');
        $data['carros'] = $this->carro_model->listar_carro(); 
        if($this->input->post()){
            $fecha_error=$datos_incorrectos=FALSE;
            $fecha = $this->input->post('fecha',TRUE);
            $this->form_validation->set_rules('fecha', 'Fecha', 'required');
            $carro = $this->input->post('carro',TRUE);
            $this->form_validation->set_rules('carro', 'Carro', 'required');
            if ($this->form_validation->run()){
                if($this->fecha_correcta($fecha)) {
                    $this->load->model('tarjeta_model');
                    $this->load->model('combustible_model');
                    $combustible = $this->combustible_model->precio_combustible(); 
                    $data['precio_1'] = $combustible[0]->precio_combustible;
                    $data['precio_2'] = $combustible[1]->precio_combustible;
                    $data['tarjetas'] = $this->tarjeta_model->buscar_tarjetas_de_carro($carro);
                    $data['fecha'] = $fecha;
                    $data['id_carro'] = $carro;
                    $this->load->view('header', $this->datos_header('Habilitar'));
                    $this->load->view('container', $this->datos_listar($data));
                    $this->load->view('footer', $this->datos_crumb_habilitar());
                }
                else
                    $fecha_error=TRUE;
            }
            else 
                $datos_incorrectos=TRUE;
            if($datos_incorrectos || $fecha_error) {
                if($fecha_error)
                    $data['error'] = 'No se pueden listar las tarjetas, verifique que la fecha sea correcta y luego seleccione un carro de la lista.';
                    $data['fecha'] = $fecha;
                    $this->load->view('header', $this->datos_header('Habilitar'));
                    $this->load->view('container', $this->datos_listar($data));
                    $this->load->view('footer', $this->datos_crumb_habilitar());
            }
        }
        else {
            redirect('habilitar');
       }
    }
    
    public function listar_recorridos() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        $data = array();
        $this->load->model('carro_model');
        $this->load->model('tarjeta_model');
        $data['carros'] = $this->carro_model->listar_carro(); 
        if($this->input->post()){ 
            $fecha = $this->input->post('fecha_2',TRUE);
            $this->form_validation->set_rules('fecha_2', 'Fecha', 'required');
            $id_carro = $this->input->post('id_carro',TRUE);
            $this->form_validation->set_rules('id_carro', 'Carro', 'required');
            $id_tarjeta = $this->input->post('id_tarjeta',TRUE);
            $this->form_validation->set_rules('id_tarjeta', 'Tarjeta', 'required');            
            $data['fecha'] = $fecha;
            $data['id_carro'] = $id_carro;
            $data['id_tarjeta'] = $id_tarjeta;
            $this->load->model('combustible_model');
            $combustible = $this->combustible_model->precio_combustible(); 
            $data['precio_1'] = $combustible[0]->precio_combustible;
            $data['precio_2'] = $combustible[1]->precio_combustible;
            $data['tarjetas'] = $this->tarjeta_model->buscar_tarjetas_de_carro($id_carro);
            if ($this->form_validation->run()){
                $this->load->model('recorrido_model');
                $data['listado'] = $this->recorrido_model->buscar_recorrido_carro($id_carro, $this->fecha());
                $data['b'] = TRUE;
                $this->load->view('header', $this->datos_header('Habilitar'));
                $this->load->view('container', $this->datos_listar($data));
                $this->load->view('footer', $this->datos_crumb_habilitar());
            }
            else {
                $this->load->view('header', $this->datos_header('Habilitar'));
                $this->load->view('container', $this->datos_listar($data));
                $this->load->view('footer', $this->datos_crumb_habilitar());
            }
        }
        else {
            redirect('habilitar');
       }
    }
    else
        redirect('auth/login', 'refresh');   
    }
    
    public function habilitar_post() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        if($this->input->post()){
            $this->load->model('combustible_model');
            $combustible = $this->combustible_model->precio_combustible(); 
            $tarjeta_invalida=$datos_incorrectos=FALSE;
            $cant = $this->input->post('cont',TRUE);
            $fecha = $this->input->post('fecha_habilitar',TRUE);
            $this->form_validation->set_rules('fecha_habilitar', 'Fecha', 'required');
            $carro = $this->input->post('carro_habilitar',TRUE);
            $this->form_validation->set_rules('carro_habilitar', 'Carro', 'required');
            $tarjeta = $this->input->post('tarjeta_habilitar',TRUE);
            $this->form_validation->set_rules('tarjeta_habilitar', 'Tarjeta', 'required');
            $comb_tarjeta = $this->input->post('comb_tarjeta',TRUE);
            $this->form_validation->set_rules('comb_tarjeta', 'Tarjeta', 'required');
            $cant_combustible = $this->input->post('cant_combustible',TRUE);
            $this->form_validation->set_rules('cant_combustible', 'Cantidad de combustible', 'required|numeric');
            $this->load->model('conduce_model');
            $recorridos=array();
            $km_total=0;
            $j=0;
            for($i=0; $i<$cant; $i++){
                if($this->input->post('var'.$i.'',TRUE)){
                    $id_recorrido = $this->input->post('var'.$i.'',TRUE);
                    $this->form_validation->set_rules('var'.$i, 'Recorridos', 'required');
                    $this->form_validation->set_message('required', 'Debe escoger al menos un recorrido para habilitar.');
                    $recorridos[$j]['id_recorrido'] = $id_recorrido;
                    $conduce = $this->conduce_model->km_recorridos($id_recorrido);
                    $km_recorridos = $conduce->distancia_total;
                    $recorridos[$j]['km_recorridos'] = $km_recorridos;
                    $km_total+=$km_recorridos;
                    $j++;
                }
            }
            if ($this->form_validation->run()){
                if($comb_tarjeta>=$cant_combustible){
                    $indicador = $cant_combustible/$km_total;
                    foreach ($recorridos as $value) {
                        $cantidad_combustible = $indicador*$value['km_recorridos'];
                        $this->load->model('combustible_model');
                        $this->combustible_model->habilitar($cantidad_combustible, $fecha, $carro, $tarjeta, $value['id_recorrido']);
                        $this->load->model('recorrido_model');
                        $this->recorrido_model->modificar_combustible($value['id_recorrido'], $cantidad_combustible);
                    }   
                    $this->load->model('tarjeta_model');
                    $var = $this->tarjeta_model->buscar_por_id($tarjeta);
                    $num = $var->id_combustible;
                    if($num==1) 
                        $precio = $combustible[0]->precio_combustible; 
                    else 
                        $precio = $combustible[1]->precio_combustible; 
                    $nueva_cantidad=($comb_tarjeta-$cant_combustible)*$precio;
                    $this->tarjeta_model->modificar_tarjeta($tarjeta, $var->codigo_tarjeta, $var->id_combustible, $this->my_functions->n($nueva_cantidad));
                    $this->habilitar(TRUE);
                }
                else 
                    $tarjeta_invalida=TRUE;
            }
            else 
                $datos_incorrectos=TRUE;
            if($datos_incorrectos || $tarjeta_invalida) {
                if($tarjeta_invalida)
                    $data['error'] = 'No se pudo habilitar correctamente, la cantidad de combustible en la tarjeta es insuficiente.';
                $this->load->model('carro_model');
                $data['carros'] = $this->carro_model->listar_carro(); 
                $this->load->model('tarjeta_model');
                $data['tarjetas'] = $this->tarjeta_model->buscar_tarjetas_de_carro($carro);
                $this->load->model('recorrido_model');
                $data['listado'] = $this->recorrido_model->buscar_recorrido_carro($carro, $this->fecha());                
                $data['precio_1'] = $combustible[0]->precio_combustible;
                $data['precio_2'] = $combustible[1]->precio_combustible;
                $data['b'] = TRUE;
                $data['fecha'] = $fecha;
                $data['id_carro'] = $carro;
                $data['id_tarjeta'] = $tarjeta; 
                $data['comb_tarjeta'] = $comb_tarjeta;
                $this->load->view('header', $this->datos_header('Habilitar'));
                $this->load->view('container', $this->datos_listar($data));
                $this->load->view('footer', $this->datos_crumb_habilitar());
            }
        }
        else {
            redirect('habilitar');
       }
    }
    else
        redirect('auth/login', 'refresh');   
    }
    
    public function datos_eliminar() {
        $data = array();
        $data['delete'] = '¡ La información se ha eliminado de la BD satisfactoriamente !';    
        $this->load->model('combustible_model');
        $data['listado'] = $this->combustible_model->listar_habilitados($this->fecha());
        $datos_container['content'] = $this->load->view('combustible/listar', $data, true);
	return $datos_container;
    }
    
    public function eliminar($id_habilitar) {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {     
        $this->load->model('combustible_model');
        $this->combustible_model->eliminar_habilitado($id_habilitar);
    	$this->load->view('header', $this->datos_header('Ver Habilitados'));
	$this->load->view('container', $this->datos_eliminar());
	$this->load->view('footer', $this->datos_crumb());
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_asignar() {
        $this->load->model('carro_model');
        $data['carros'] = $this->carro_model->listar_carro();
        $carro = $this->carro_model->buscar_id_carro(); 
        $this->load->model('tarjeta_model');
        $data['tarjetas'] = $this->tarjeta_model->buscar_no_tarjetas_de_carro($carro->id_carro);
        $data['tarjetas_carro'] = $this->tarjeta_model->buscar_tarjetas_de_carro($carro->id_carro);        
        $datos_container['content'] = $this->load->view('combustible/asignar', $data, true);
	return $datos_container;
    }
    
    public function datos_buscar_carro($id_carro, $flag=FALSE) {
        $this->load->model('carro_model');
        $data['carros'] = $this->carro_model->listar_carro();
        $data['carro_select'] = $id_carro;
        $data['mensaje'] = $flag;
        $this->load->model('tarjeta_model');
        $data['tarjetas'] = $this->tarjeta_model->buscar_no_tarjetas_de_carro($id_carro);
        $data['tarjetas_carro'] = $this->tarjeta_model->buscar_tarjetas_de_carro($id_carro);        
        $datos_container['content'] = $this->load->view('combustible/asignar', $data, true);
	return $datos_container;
    }
    
    public function asignar_tarjetas() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        if($this->input->post()) {
            $id_carro = $this->input->post('carro',TRUE);
            $this->load->view('header', $this->datos_header('Asignaci&oacute;n de tarjetas'));
            $this->load->view('container', $this->datos_buscar_carro($id_carro));
            $this->load->view('footer', $this->datos_crumb_asignar());
        }
        else {
            $this->load->view('header', $this->datos_header('Asignaci&oacute;n de tarjetas'));
            $this->load->view('container', $this->datos_asignar());
            $this->load->view('footer', $this->datos_crumb_asignar());
        }
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function asignar_post() {
    if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {    
        if($this->input->post()){
            $tarjetas_asig = $this->input->post('tarjetas_asig',TRUE);
            $id_carro = $this->input->post('carro',TRUE);
            if($id_carro==NULL) {
               $this->load->model('carro_model'); 
               $carro = $this->carro_model->buscar_id_carro(); 
               $id_carro = $carro->id_carro; 
            }
            $this->load->model('combustible_model');
            $this->combustible_model->eliminar_asignacion_carro($id_carro);
            foreach ($tarjetas_asig as $id_tarjeta) {
                $this->combustible_model->asignar_tarjetas($id_carro, $id_tarjeta);
            }
            $this->load->view('header', $this->datos_header('Asignaci&oacute;n de tarjetas'));
            $this->load->view('container', $this->datos_buscar_carro($id_carro, TRUE));
            $this->load->view('footer', $this->datos_crumb_asignar());
        }
        else
            redirect ('combustible/asignar_tarjetas');
    }
    else
        redirect('auth/login', 'refresh');    
    }
    
    public function datos_reporte($title) {
	$datos = array();
        $datos['titulo'] = $title; 
        $this->load->model('carro_model');
        $this->load->model('combustible_model');
        $carros = $this->carro_model->listar_carros_buenos();
        $reporte = $chapas = array();
        $fecha = $this->fecha();
        $i=1;
        foreach ($carros as $value) {
            $chapas[$i]=$chapa=$value->chapa;
            for($j=1; $j<=$fecha['max_dias']; $j++) {
                $str_fecha=$fecha['anno'].'-'.$fecha['mes'].'-'.$j;
                $row = $this->combustible_model->consumo_combustible_carro($value->id_carro, $str_fecha);
                if($row->combustible!=NULL)
                    $reporte[$chapa][$j]=$row->combustible;
                else
                    $reporte[$chapa][$j]='0';
            }
            $i++;
        }
        $data_reporte['reporte'] = $reporte;
        $data_reporte['chapas'] = $chapas;
        $data_reporte['fecha'] = $fecha;
        $datos['reporte'] = $this->load->view('combustible/tabla_reporte', $data_reporte, TRUE);
	return $datos;
    }
        
    public function reporte_combustible() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh');    
        $this->load->view('reporte_c', $this->datos_reporte('Reporte del combustible habilitado'));
    }
    
    public function datos_reporte_acumulado($title) {
	$datos = array();
        $datos['titulo'] = $title; 
        $datos['acumulado'] = TRUE;
        $this->load->model('combustible_model');
        $this->load->model('actividad_model');
        $this->load->model('carro_model');
        $carros = $this->carro_model->listar_carros_buenos();
        $reporte = $chapas = array();
        if($this->input->post()) {
            $mes = $this->input->post('mes',TRUE);
            $anno = $this->input->post('anno',TRUE);
            $fecha['max_dias'] = days_in_month($mes, $anno);
            $fecha['mes'] = $mes;
            $fecha['anno'] = $anno;
        }
        else
            $fecha = $this->fecha(TRUE);
        $i=1;
        foreach ($carros as $value) {
            $chapas[$i]=$chapa=$value->chapa;
            for($j=1; $j<=$fecha['max_dias']; $j++) {
                $str_fecha=$fecha['anno'].'-'.$fecha['mes'].'-'.$j;
                $row = $this->combustible_model->consumo_combustible_carro($value->id_carro, $str_fecha);
                if($row->combustible!=NULL)
                    $reporte[$chapa][$j]=$row->combustible;
                else
                    $reporte[$chapa][$j]='0';
            }
            $i++;
        }
        $data_reporte['reporte'] = $reporte;
        $data_reporte['chapas'] = $chapas;
        $data_reporte['fecha'] = $fecha;
        $data_reporte['actividades'] = $this->actividad_model->listar_actividad();
        $meses = array();
        $nombre_mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $temp = $this->fecha(TRUE);
        for($i=1; $i<=(int)$temp['mes']; $i++) {
            $meses[$i]['nombre'] = $nombre_mes[$i];
            $meses[$i]['id'] = $i;
        } 
        $datos['meses'] = $meses;
        $annos = array();
        $var = $this->combustible_model->ultima_fecha();
        $i=1;
        foreach ($var as $value) {
            $annos[$i]['id'] = $value->anno;
            $i++;
        }
        $datos['anno'] = $annos;
        $datos['reporte'] = $this->load->view('combustible/tabla_reporte', $data_reporte, TRUE);
	return $datos;
    }
    
    public function reporte_combustible_acumulado() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh'); 
        $this->load->view('reporte_c', $this->datos_reporte_acumulado('Reporte del combustible habilitado', TRUE));
    }
    
    public function exportar_reporte() {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh'); 
        $this->load->model('carro_model');
        $this->load->model('combustible_model');
        $carros = $this->carro_model->listar_carros_buenos();
        $reporte = $chapas = array();
        $fecha = $this->fecha();
        $i=1;
        foreach ($carros as $value) {
            $chapas[$i]=$chapa=$value->chapa;
            for($j=1; $j<=$fecha['max_dias']; $j++) {
                $str_fecha=$fecha['anno'].'-'.$fecha['mes'].'-'.$j;
                $row = $this->combustible_model->consumo_combustible_carro($value->id_carro, $str_fecha);
                if($row->combustible!=NULL)
                    $reporte[$chapa][$j]=$row->combustible;
                else
                    $reporte[$chapa][$j]='0';
            }
            $i++;
        }
        $data_reporte['reporte'] = $reporte;
        $data_reporte['chapas'] = $chapas;
        $data_reporte['fecha'] = $this->fecha();
        $this->load->view('combustible/exportar_reporte', $data_reporte);
    }
    
    public function exportar_reporte_acumulado($mes_e=NULL, $anno_e=NULL) {
    if (!$this->ion_auth->logged_in()) 
        redirect('auth/login', 'refresh'); 
        $this->load->model('carro_model');
        $this->load->model('combustible_model');
        $carros = $this->carro_model->listar_carros_buenos();
        $reporte = $chapas = array();
        if($mes_e!=NULL && $anno_e!=NULL) {
            $mes = $mes_e;
            $anno = $anno_e;
            $fecha['max_dias'] = days_in_month($mes, $anno);
            $fecha['mes'] = $data_reporte['n_mes'] = $mes;
            $fecha['anno'] = $data_reporte['n_anno'] = $anno;
        }
        else
            $fecha = $this->fecha(TRUE); 
        $i=1;
        foreach ($carros as $value) {
            $chapas[$i]=$chapa=$value->chapa;
            for($j=1; $j<=$fecha['max_dias']; $j++) {
                $str_fecha=$fecha['anno'].'-'.$fecha['mes'].'-'.$j;
                $row = $this->combustible_model->consumo_combustible_carro($value->id_carro, $str_fecha);
                if($row->combustible!=NULL)
                    $reporte[$chapa][$j]=$row->combustible;
                else
                    $reporte[$chapa][$j]='0';
            }
            $i++;
        }
        $data_reporte['reporte'] = $reporte;
        $data_reporte['chapas'] = $chapas;
        $data_reporte['fecha'] = $fecha;
        $this->load->view('combustible/exportar_reporte', $data_reporte);
    }
    
    //------- Migas de Pan (breadcrumb) -----------------------------------------------
    public function datos_crumb() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Ver Habilitados',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
    
    public function datos_crumb_habilitar() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Ver Habilitados',
		'direccion' => base_url().'combustible'
            ),
            2 => array(
		'nombre' => 'Habilitar',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
    
    public function datos_crumb_asignar() {
	$datos_crumb['crumb'] = array(
            0 => array(
		'nombre' => 'Inicio',
		'direccion' => base_url()
            ),
            1 => array(
		'nombre' => 'Asignaci&oacute;n de tarjetas',
		'direccion' => ''
            )
	);
	return $datos_crumb;
    }
}
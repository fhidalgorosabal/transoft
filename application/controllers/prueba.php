<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prueba extends CI_Controller {

    public function __construct() {
	parent::__construct();
        $this->load->helper('date');
    }

    public function index() {
        echo days_in_month(2, 2020);
    }
            
    public function ci($ci) {
    	$anno=$ci[0].$ci[1];
        $mes=$ci[2].$ci[3];
        $dia=$ci[4].$ci[5];
        return (((int)$mes>0 && (int)$mes<=12) && ((int)$dia>0 && (int)$dia<=days_in_month((int)$mes, (int)$anno))); 
    }
    
}
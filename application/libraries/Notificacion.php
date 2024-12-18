<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// para manejar las notificaciones del sistema
class Notificacion {

    // atributos
    protected $messages;
    protected $errors;
    protected $message_start_delimiter;
    protected $message_end_delimiter;
    protected $error_start_delimiter;
    protected $error_end_delimiter;

    // constructor
    public function __construct() {
        // inicializar los mensajes y errores
        $this->messages = array();
        $this->errors = array();
        // definir los delimitadores de los errores y mensajes, se usan los mismos de ion_auth
        $this->config->load('ion_auth', TRUE);        
        $this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
        $this->message_end_delimiter = $this->config->item('message_end_delimiter', 'ion_auth');
        $this->error_start_delimiter = $this->config->item('error_start_delimiter', 'ion_auth');
        $this->error_end_delimiter = $this->config->item('error_end_delimiter', 'ion_auth');
    }

    // obtener los mensajes
    public function get_messages() {
        $output = '';
        foreach ($this->messages as $message) {
            $output .= $this->message_start_delimiter . $message . $this->message_end_delimiter;
        }
        return $output;
    }

    // obtener los errores
    public function get_errors() {
        $output = '';
        foreach ($this->errors as $error) {
            $output .= $this->error_start_delimiter . $error . $this->error_end_delimiter;
        }
        return $output;
    }

    // adicionar un nuevo mensaje
    public function add_message($message) {
        $this->messages[] = $message;
        return $message;
    }

    // adicionar un nuevo error
    public function add_error($error) {
        $this->errors[] = $error;
        return $error;
    }

    public function __get($var) {
        return get_instance()->$var;
    }

}

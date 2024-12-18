<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->model('Ion_auth_model');
		$this->load->library('notificacion');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	// redirect if needed, otherwise display the user list
	function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Usted no es administrador para ver esta página.');
		}
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
                        $this->load->view('header', $this->datos_header('Usuario'));
                        $this->_render_page('auth/index', $this->data);
                        $this->load->view('footer', $this->datos_crumb());
			
		}
	}       
        
        
        function datos_header($titulo) {
            $datos_header = array();
            $datos_header['titulo'] = $titulo;
            $this->load->model('actividad_model');
            $datos_header['actividades'] = $this->actividad_model->listar_actividad(); 
            $this->load->model('carro_model');
            $datos_header['carro'] = $this->carro_model->buscar_id_carro(); 
            return $datos_header;
        }
    
	// log the user in
	function login()
	{
		$this->data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', '< Usuario >', 'required');
		$this->form_validation->set_rules('password', '< Contrase&ntilde;a >', 'required');

		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/', 'refresh');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);

			$this->_render_page('auth/login', $this->data);
		}
	}

	// log the user out
	function logout()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	
	// activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}
        
        function deactivate($id)
	{
                if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Usted no es administrador para ver esta página.');
		}

		$id = (int) $id;    
            
                if ($this->ion_auth->is_admin() && $this->ion_auth->get_user_id()!=$id)
		{
			$activation = $this->ion_auth->deactivate($id);
		}
                
                if($this->ion_auth->get_user_id()==$id) {
                   $this->ion_auth->set_error('No se puede desactivar una cuenta en uso'); 
                }

		if (isset($activation) && $activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth", 'refresh');
		}
	}

	

	// create a new user
	function create_user()
    {
        $this->data['title'] = "Create User";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
//            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
//        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
//        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
//                'company'    => $this->input->post('company'),
//                'phone'      => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("/auth", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
//            $this->data['company'] = array(
//                'name'  => 'company',
//                'id'    => 'company',
//                'type'  => 'text',
//                'value' => $this->form_validation->set_value('company'),
//            );
//            $this->data['phone'] = array(
//                'name'  => 'phone',
//                'id'    => 'phone',
//                'type'  => 'text',
//                'value' => $this->form_validation->set_value('phone'),
//            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );
            $this->load->view('header', $this->datos_header('Crear Usuario'));
            $this->_render_page('auth/create_user', $this->data);
            $this->load->view('footer', $this->datos_crumb_insertar());
        }
    }

	// edit a user
	function edit_user($id)
	{
		$this->data['title'] = "Edit User";

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
                if($this->input->post('identity')!= '' && $user->username!=$this->input->post('identity')) {
                    $tables = $this->config->item('tables','ion_auth');
                    $identity_column = $this->config->item('identity','ion_auth');
                    $this->data['identity_column'] = $identity_column;
                    $regla = 'required|is_unique['.$tables['users'].'.'.$identity_column.']';
                }
                else
                    $regla = 'required';
		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
                $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'), $regla);
//		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
//		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'username'    => $this->input->post('identity'),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$group = $this->input->post('group');

					if (isset($group) && !empty($group)) {

						$this->ion_auth->remove_from_group('', $id);
                                                $this->ion_auth->add_to_group($group, $id);

					}
				}

			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
                $this->data['identity'] = array(
                    'name'  => 'identity',
                    'id'    => 'identity',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('identity', $user->username),
                );
//		$this->data['company'] = array(
//			'name'  => 'company',
//			'id'    => 'company',
//			'type'  => 'text',
//			'value' => $this->form_validation->set_value('company', $user->company),
//		);
//		$this->data['phone'] = array(
//			'name'  => 'phone',
//			'id'    => 'phone',
//			'type'  => 'text',
//			'value' => $this->form_validation->set_value('phone', $user->phone),
//		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);
                $this->load->view('header', $this->datos_header('Modificar Usuario'));
                $this->_render_page('auth/edit_user', $this->data);
		$this->load->view('footer', $this->datos_crumb_modificar());

		
	}
        
        // edit a user
	function edit_perfil()
	{
		$id = $this->ion_auth->get_user_id();
                
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
                if($this->input->post('identity')!= '' && $user->username!=$this->input->post('identity')) {
                    $tables = $this->config->item('tables','ion_auth');
                    $identity_column = $this->config->item('identity','ion_auth');
                    $this->data['identity_column'] = $identity_column;
                    $regla = 'required|is_unique['.$tables['users'].'.'.$identity_column.']';
                }
                else
                    $regla = 'required';
		// validate form input $user->username
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
                $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'), $regla);
//		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
//		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password') || $this->input->post('old'))
			{
                                $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'username'    => $this->input->post('identity'),
//					'phone'      => $this->input->post('phone'),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
                                    $pass = $this->ion_auth->hash_password_db($user->id, $this->input->post('old'));  
                                    if(!$pass)
                                        $this->ion_auth->set_error('La contraseña antigua es incorrecta');
                                    $data['password'] = $this->input->post('password');
				}
                                else {
                                    $pass = TRUE;    
                               }



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}
                               
                        // check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data) && $pass)
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages());
				    if ($id == $this->ion_auth->get_user_id())
					{
						redirect('auth/edit_perfil', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($id == $this->ion_auth->get_user_id())
					{
						redirect('auth/edit_perfil', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
                $this->data['identity'] = array(
                    'name'  => 'identity',
                    'id'    => 'identity',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('identity', $user->username),
                );
//		$this->data['company'] = array(
//			'name'  => 'company',
//			'id'    => 'company',
//			'type'  => 'text',
//			'value' => $this->form_validation->set_value('company', $user->company),
//		);
//		$this->data['phone'] = array(
//			'name'  => 'phone',
//			'id'    => 'phone',
//			'type'  => 'text',
//			'value' => $this->form_validation->set_value('phone', $user->phone),
//		);
                $this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);
                $this->load->view('header', $this->datos_header('Editar mi perfil'));
                $this->_render_page('auth/edit_perfil', $this->data);
		$this->load->view('footer', $this->datos_crumb_editar());

		
	}

    //delete e exist user
    public function delete_user($id)
	{
		if ($this->ion_auth->logged_in() || $this->ion_auth->is_admin())
		{
			$this->Ion_auth_model->delete_user($id);
			$this->session->set_flashdata('error', $this->notificacion->get_errors());
			$this->session->set_flashdata('message', $this->notificacion->get_messages());
			redirect('Auth/index', 'refresh');
		} else {
			redirect('/auth', 'refresh');
		}
	}


	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}

        function datos_crumb() {
            $datos_crumb['crumb'] = array(
                0 => array(
                    'nombre' => 'Inicio',
                    'direccion' => base_url()
                ),
                1 => array(
                    'nombre' => 'Usuarios',
                    'direccion' => ''
                )
            );
            return $datos_crumb;
        }
        
        function datos_crumb_insertar() {
            $datos_crumb['crumb'] = array(
                0 => array(
                    'nombre' => 'Inicio',
                    'direccion' => base_url()
                ),
                1 => array(
                    'nombre' => 'Usuarios',
                    'direccion' => base_url().'auth'
                ),
                2 => array(
                    'nombre' => 'Crear Usuario',
                    'direccion' => ''
                )
            );
            return $datos_crumb;
        }

        function datos_crumb_modificar() {
            $datos_crumb['crumb'] = array(
                0 => array(
                    'nombre' => 'Inicio',
                    'direccion' => base_url()
                ),
                1 => array(
                    'nombre' => 'Usuarios',
                    'direccion' => base_url().'auth'
                ),
                2 => array(
                    'nombre' => 'Modificar Usuario',
                    'direccion' => ''
                )
            );
            return $datos_crumb;
        }

        function datos_crumb_editar() {
            $datos_crumb['crumb'] = array(
                0 => array(
                    'nombre' => 'Inicio',
                    'direccion' => base_url()
                ),
                1 => array(
                    'nombre' => 'Editar mi perfil',
                    'direccion' => ''
                )
            );
            return $datos_crumb;
        }

}

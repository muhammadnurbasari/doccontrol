<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Result_model');
	}

	function index()
	{
		if (!$this->session->userdata('user')) {
			$data['title'] = 'Login';
			$this->load->view('login', $data);
		} else {
			redirect('result/dashboard');
		}
	}

	function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$this->form_validation->set_rules('username','Username','required',['required' => 'username tidak boleh kosong']);
		$this->form_validation->set_rules('password','Password','required',['required' => 'password tidak boleh kosong']);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
		} else {
			$cek_user = $this->Result_model->get_by_name('user', 'user_name', $username);
			if ($cek_user) {
				if (password_verify($password, $cek_user[0]['password'])) {
					$this->session->set_userdata(['user' => $cek_user]);
					echo 1;
				} else {
					echo "Password Salah";
				}
			} else {
				echo "Anda Belum Terdaftar";
			}
		}
	}

	function dashboard()
	{
		$this->_sessionguard();
		$data['title'] = 'Dashboard';
		$data['table'] = 'user';
		$this->templating('dashboard', $data);
	}

	function user($parameter = '')
	{
		if ($parameter == '') {
			$data['title'] = 'Users';
			$this->db->where('status', 1);
			$data['users'] = $this->Result_model->getData('user');
			$data['table'] = 'user';
			$this->templating('user/index', $data);
		} elseif ($parameter == 'add') {
			$this->_sessionguard();
			$username = $this->input->post('username');
			$fullname = $this->input->post('fullname');
			$password = $this->input->post('password');
			$address = $this->input->post('address');
			$email = $this->input->post('email');
			$phone_number = $this->input->post('phone_number');
			$level = $this->input->post('level');
			$department = $this->input->post('department');
			$this->form_validation->set_rules('username','Username','required|is_unique[user.user_name]',['is_unique' => 'username sudah tersedia','required' => 'Username tidak boleh kosong']);
			$this->form_validation->set_rules('fullname','Fullname','required',['required' => 'Full Name tidak boleh kosong']);
			$this->form_validation->set_rules('password','Password','required',['required' => 'Password tidak boleh kosong']);
			$this->form_validation->set_rules('address','Address','required',['required' => 'Address tidak boleh kosong']);
			$this->form_validation->set_rules('email','Email','required|is_unique[user.email]|valid_email',['is_unique' => 'Email sudah tersedia','required' => 'Email tidak boleh kosong','valid_email' => 'Email tidak valid']);
			$this->form_validation->set_rules('phone_number','Phone_number','required',['required' => 'Phone Number tidak boleh kosong']);
			$this->form_validation->set_rules('level','level','required',['required' => 'Level tidak boleh kosong']);
			$this->form_validation->set_rules('department','Department','required',['required' => 'Department tidak boleh kosong']);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			} else {
				$data = [
					'user_name' => $username,
					'name' => $fullname,
					'password' => password_hash($password, PASSWORD_DEFAULT),
					'level_id' => $level,
					'address' => $address,
					'email' => $email,
					'phone_number' => $phone_number,
					'department_id' => $department,
					'created_at' => date('Y-m-d'),
					'updated_at' => NULL,
					'deleted_at' => NULL,
					'created_by' => $this->session->userdata('user')[0]['user_id'],
					'updated_by' => NULL,
					'deleted_by' => NULL,
					'status' => 1
				];
				$this->db->insert('user', $data);
				echo 1;
			}
		} elseif ($parameter == 'update') {
			$this->_sessionguard();
			$user_id = $this->input->post('user_id');
			$username = $this->input->post('username');
			$fullname = $this->input->post('fullname');
			$address = $this->input->post('address');
			$email = $this->input->post('email');
			$phone_number = $this->input->post('phone_number');
			$level = $this->input->post('level');
			$department = $this->input->post('department');
			$this->form_validation->set_rules('username','Username','required',['required' => 'Username tidak boleh kosong']);
			$this->form_validation->set_rules('fullname','Fullname','required',['required' => 'Full Name tidak boleh kosong']);
			$this->form_validation->set_rules('address','Address','required',['required' => 'Address tidak boleh kosong']);
			$this->form_validation->set_rules('email','Email','required|valid_email',['required' => 'Email tidak boleh kosong','valid_email' => 'Email tidak valid']);
			$this->form_validation->set_rules('phone_number','Phone_number','required',['required' => 'Phone Number tidak boleh kosong']);
			$this->form_validation->set_rules('level','level','required',['required' => 'Level tidak boleh kosong']);
			$this->form_validation->set_rules('department','Department','required',['required' => 'Department tidak boleh kosong']);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			} else {
				$data = [
					'user_name' => $username,
					'name' => $fullname,
					'level_id' => $level,
					'address' => $address,
					'email' => $email,
					'phone_number' => $phone_number,
					'department_id' => $department,
					'created_at' => date('Y-m-d'),
					'updated_at' => date('Y-m-d'),
					'deleted_at' => NULL,
					'created_by' => $this->session->userdata('user')[0]['user_id'],
					'updated_by' => $this->session->userdata('user')[0]['user_id'],
					'deleted_by' => NULL,
					'status' => 1
				];
				$this->Result_model->update_by_id('user', $user_id, $data);
				echo 1;
			}
		} elseif ($parameter == 'delete') {
			$this->_sessionguard();
			$user_id = $this->input->post('user_id');
			$data = ['status' => 0,'deleted_by' => $this->session->userdata('user')[0]['user_id'],'deleted_at' => date('Y-m-d')];
			$this->Result_model->update_by_id('user', $user_id, $data);
			echo 1;
		}
	}

	function department($parameter='')
	{
		if ($parameter == '') {
			$data['title'] = 'Departments';
			$this->db->where('status', 1);
			$data['departments'] = $this->Result_model->getData('department');
			$data['table'] = 'department';
			$this->templating('department/index', $data);
		} elseif ($parameter == 'add') {
			$this->_sessionguard();
			$department_code = $this->input->post('department_code');
			$department_name = $this->input->post('department_name');
			$this->form_validation->set_rules('department_code','Department_code','required',['required' => 'Department Code tidak boleh kosong']);
			$this->form_validation->set_rules('department_name','Department_name','required',['required' => 'Department Name tidak boleh kosong']);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			} else {
				$data = [
					'department_code' => $department_code,
					'department_name' => $department_name,
					'created_at' => date('Y-m-d'),
					'updated_at' => NULL,
					'deleted_at' => NULL,
					'created_by' => $this->session->userdata('user')[0]['user_id'],
					'updated_by' => NULL,
					'deleted_by' => NULL,
					'status' => 1
				];
				$this->db->insert('department', $data);
				echo 1;
			}
		} elseif ($parameter == 'update') {
			$this->_sessionguard();
			$department_id = $this->input->post('department_id');
			$department_code = $this->input->post('department_code');
			$department_name = $this->input->post('department_name');
			$this->form_validation->set_rules('department_code','Department_code','required',['required' => 'Department Code tidak boleh kosong']);
			$this->form_validation->set_rules('department_name','Department_name','required',['required' => 'Department Name tidak boleh kosong']);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			} else {
				$data = [
					'department_code' => $department_code,
					'department_name' => $department_name,
					'created_at' => date('Y-m-d'),
					'updated_at' => date('Y-m-d'),
					'deleted_at' => NULL,
					'created_by' => $this->session->userdata('user')[0]['user_id'],
					'updated_by' => $this->session->userdata('user')[0]['user_id'],
					'deleted_by' => NULL,
					'status' => 1
				];
				$this->Result_model->update_by_id('department', $department_id, $data);
				echo 1;
			}
		} elseif ($parameter == 'delete') {
			$department_id = $this->input->post('department_id');
			$data = ['status' => 0,'deleted_by' => $this->session->userdata('user')[0]['user_id'],'deleted_at' => date('Y-m-d')];
			$this->Result_model->update_by_id('department', $department_id, $data);
			echo 1;
		}
	}

	function document($parameter='')
	{
		if ($parameter == '') {
			$data['title'] = 'Documents';
			$this->db->where('status', 1);
			$data['documents'] = $this->Result_model->getData('document');
			$data['table'] = 'document';
			$this->templating('document/index', $data);
		} elseif ($parameter == 'add') {
			$this->_sessionguard();
			$document_code = $this->input->post('document_code');
			$document_name = $this->input->post('document_name');
			$this->form_validation->set_rules('document_code','Document_code','required',['required' => 'document Code tidak boleh kosong']);
			$this->form_validation->set_rules('document_name','Document_name','required',['required' => 'document Name tidak boleh kosong']);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			} else {
				$data = [
					'document_code' => $document_code,
					'document_name' => $document_name,
					'created_at' => date('Y-m-d'),
					'updated_at' => NULL,
					'deleted_at' => NULL,
					'created_by' => $this->session->userdata('user')[0]['user_id'],
					'updated_by' => NULL,
					'deleted_by' => NULL,
					'status' => 1
				];
				$this->db->insert('document', $data);
				echo 1;
			}
		} elseif ($parameter == 'update') {
			$this->_sessionguard();
			$document_id = $this->input->post('document_id');
			$document_code = $this->input->post('document_code');
			$document_name = $this->input->post('document_name');
			$this->form_validation->set_rules('document_code','Document_code','required',['required' => 'document Code tidak boleh kosong']);
			$this->form_validation->set_rules('document_name','Document_name','required',['required' => 'document Name tidak boleh kosong']);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			} else {
				$data = [
					'document_code' => $document_code,
					'document_name' => $document_name,
					'created_at' => date('Y-m-d'),
					'updated_at' => date('Y-m-d'),
					'deleted_at' => NULL,
					'created_by' => $this->session->userdata('user')[0]['user_id'],
					'updated_by' => $this->session->userdata('user')[0]['user_id'],
					'deleted_by' => NULL,
					'status' => 1
				];
				$this->Result_model->update_by_id('document', $document_id, $data);
				echo 1;
			}
		} elseif ($parameter == 'delete') {
			$document_id = $this->input->post('document_id');
			$data = ['status' => 0,'deleted_by' => $this->session->userdata('user')[0]['user_id'],'deleted_at' => date('Y-m-d')];
			$this->Result_model->update_by_id('document', $document_id, $data);
			echo 1;
		}
	}

	function doc_category($parameter='')
	{
		if ($parameter == '') {
			$data['title'] = 'Document Categories';
			$this->db->where('status', 1);
			if ($this->session->userdata('user')[0]['level_id'] != 5) {
				$this->db->where('department_id', $this->session->userdata('user')[0]['department_id']);
			}
			$data['doc_categorys'] = $this->Result_model->getData('doc_category');
			$data['table'] = 'doc_category';
			$this->templating('doc_category/index', $data);
		} elseif ($parameter == 'add') {
			$this->_sessionguard();
			$doc_category_name = $this->input->post('doc_category_name');
			$department_id = $this->input->post('department_id');
			$this->form_validation->set_rules('doc_category_name','Doc_category_name','required',['required' => 'doc_category Name tidak boleh kosong']);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			} else {
				$data = [
					'doc_category_name' => $doc_category_name,
					'department_id' => $department_id,
					'created_at' => date('Y-m-d'),
					'updated_at' => NULL,
					'deleted_at' => NULL,
					'created_by' => $this->session->userdata('user')[0]['user_id'],
					'updated_by' => NULL,
					'deleted_by' => NULL,
					'status' => 1
				];
				$this->db->insert('doc_category', $data);
				echo 1;
			}
		} elseif ($parameter == 'update') {
			$this->_sessionguard();
			$doc_category_id = $this->input->post('doc_category_id');
			$department_id = $this->input->post('department_id');
			$doc_category_name = $this->input->post('doc_category_name');
			$this->form_validation->set_rules('doc_category_name','doc_category_name','required',['required' => 'doc_category Name tidak boleh kosong']);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			} else {
				$data = [
					'doc_category_name' => $doc_category_name,
					'department_id' => $department_id,
					'created_at' => date('Y-m-d'),
					'updated_at' => date('Y-m-d'),
					'deleted_at' => NULL,
					'created_by' => $this->session->userdata('user')[0]['user_id'],
					'updated_by' => $this->session->userdata('user')[0]['user_id'],
					'deleted_by' => NULL,
					'status' => 1
				];
				$this->Result_model->update_by_id('doc_category', $doc_category_id, $data);
				echo 1;
			}
		} elseif ($parameter == 'delete') {
			$doc_category_id = $this->input->post('doc_category_id');
			$data = ['status' => 0,'deleted_by' => $this->session->userdata('user')[0]['user_id'],'deleted_at' => date('Y-m-d')];
			$this->Result_model->update_by_id('doc_category', $doc_category_id, $data);
			echo 1;
		}
	}

	function doc_release_header($parameter='')
	{
		if ($parameter == '') {
			$data['title'] = 'Release Document Propose';
			$cek_department = $this->Result_model->get_name_by_id('department', $this->session->userdata('user')[0]['department_id'], 'department_code');
			if ($this->session->userdata('user')[0]['level_id'] != 5 ) {
				$this->db->where('department_id', $this->session->userdata('user')[0]['department_id']);
			}
			$this->db->where('doc_status !=', 1);
			$this->db->where('doc_status !=', 4);
			$this->db->where('doc_status !=', 5);
			$data['doc_release_headers'] = $this->Result_model->getData('doc_release_header');
			$data['table'] = 'doc_release_header';
			$this->templating('doc_release_header/index', $data);
		} elseif ($parameter == 'add') {
			$doc_release_code = $this->input->post('doc_release_code');
			$doc_release_date = date('Y-m-d', strtotime($this->input->post('doc_release_date')));
			$doc_title = $this->input->post('doc_title');
			$doc_type_id = explode('/', $this->input->post('doc_type_id'))[0];
			$department_id = $this->session->userdata('user')[0]['department_id'];
			$doc_category_id = $this->input->post('doc_category_id');
			$doc_no = $this->input->post('doc_no');
			$revisi_no = NULL;
			$description = $this->input->post('description');
			$revisi_note = NULL;
			$expired_note = NULL;
			$doc_status = 0;
			$created_at = date('Y-m-d');
			$revised_at = NULL;
			$deleted_at = NULL;
			$created_by = $this->session->userdata('user')[0]['user_id'];
			$revised_by = NULL;
			$deleted_by = NULL;
			$this->form_validation->set_rules('doc_title','Doc_title','required',['required' => 'Document Name tidak boleh kosong']);
			$this->form_validation->set_rules('doc_type_id','Doc_type_id','required',['required' => 'Document tidak boleh kosong']);
			$this->form_validation->set_rules('doc_category_id','Doc_category_id','required',['required' => 'Doc Category tidak boleh kosong']);
			$this->form_validation->set_rules('description','Description','required',['required' => 'Release Description tidak boleh kosong']);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			} else {
		        $config['overwrite']            = true;
		        $config['max_size']             = 3000;
				$config['upload_path']= "./assets/files/release/";
				$config['allowed_types']        = 'pdf';
		        $config['overwrite']            = true;
		         
		        $this->load->library('upload',$config);
		        if($this->upload->do_upload('doc_file')){
		 
					$data = [
						'doc_release_code' => $doc_release_code,
						'doc_release_date' => $doc_release_date,
						'doc_title' => $doc_title,
						'doc_type_id' => $doc_type_id,
						'department_id' => $department_id,
						'doc_category_id' => $doc_category_id,
						'doc_no' => $doc_no,
						'revisi_no' => $revisi_no,
						'description' => $description,
						'doc_file' => $this->upload->data('file_name'),
						'revisi_note' => $revisi_note,
						'expired_note' => $expired_note,
						'doc_status' => $doc_status,
						'created_at' => $created_at,
						'revised_at' => $revised_at,
						'deleted_at' => $deleted_at,
						'created_by' => $created_by,
						'revised_by' => $revised_by,
						'deleted_by' => $deleted_by
					];
					$this->db->insert('doc_release_header', $data);
					echo 1;

		        } else {
		        	$error = array('error' => $this->upload->display_errors());

            		echo $error['error'];
		        }
			}
		} elseif ($parameter == 'update') {
			if (!empty($_FILES['doc_file']['name'])) {
				
				$doc_release_header_id = $this->input->post('doc_release_header_id');
				$doc_release_code = $this->input->post('doc_release_code');
				$doc_release_date = date('Y-m-d', strtotime($this->input->post('doc_release_date')));
				$doc_title = $this->input->post('doc_title');
				$doc_type_id = explode('/', $this->input->post('doc_type_id'))[0];
				$department_id = $this->session->userdata('user')[0]['department_id'];
				$doc_category_id = $this->input->post('doc_category_id');
				$doc_no = $this->input->post('doc_no');
				$revisi_no = NULL;
				$description = $this->input->post('description');
				$revisi_note = NULL;
				$expired_note = NULL;
				$doc_status = 0;
				$created_at = date('Y-m-d');
				$revised_at = NULL;
				$deleted_at = NULL;
				$created_by = $this->session->userdata('user')[0]['user_id'];
				$revised_by = NULL;
				$deleted_by = NULL;
				$this->form_validation->set_rules('doc_title','Doc_title','required',['required' => 'Document Name tidak boleh kosong']);
				$this->form_validation->set_rules('doc_type_id','Doc_type_id','required',['required' => 'Document tidak boleh kosong']);
				$this->form_validation->set_rules('doc_category_id','Doc_category_id','required',['required' => 'Doc Category tidak boleh kosong']);
				$this->form_validation->set_rules('description','Description','required',['required' => 'Release Description tidak boleh kosong']);
				if ($this->form_validation->run() == false) {
					echo validation_errors();
				} else {
						$config['overwrite']            = true;
						$config['max_size']             = 3000;
						$config['upload_path']= "./assets/files/release/";
						$config['allowed_types']        = 'pdf';
						$config['overwrite']            = true;
						 
						$this->load->library('upload',$config);
						if($this->upload->do_upload('doc_file')){
				 
							$data = [
								'doc_release_code' => $doc_release_code,
								'doc_release_date' => $doc_release_date,
								'doc_title' => $doc_title,
								'doc_type_id' => $doc_type_id,
								'department_id' => $department_id,
								'doc_category_id' => $doc_category_id,
								'doc_no' => $doc_no,
								'revisi_no' => $revisi_no,
								'description' => $description,
								'doc_file' => $this->upload->data('file_name'),
								'revisi_note' => $revisi_note,
								'expired_note' => $expired_note,
								'doc_status' => $doc_status,
								'created_at' => $created_at,
								'revised_at' => $revised_at,
								'deleted_at' => $deleted_at,
								'created_by' => $created_by,
								'revised_by' => $revised_by,
								'deleted_by' => $deleted_by
							];
							$this->Result_model->update_by_id('doc_release_header', $doc_release_header_id, $data);
							echo 1;
							
						} else {
							$error = array('error' => $this->upload->display_errors());
							
							echo $error['error'];
						}
				}
			} else {
				$doc_release_header_id = $this->input->post('doc_release_header_id');
				$doc_release_code = $this->input->post('doc_release_code');
				$doc_release_date = date('Y-m-d', strtotime($this->input->post('doc_release_date')));
				$doc_title = $this->input->post('doc_title');
				$doc_type_id = explode('/', $this->input->post('doc_type_id'))[0];
				$department_id = $this->session->userdata('user')[0]['department_id'];
				$doc_category_id = $this->input->post('doc_category_id');
				$doc_no = $this->input->post('doc_no');
				$revisi_no = NULL;
				$description = $this->input->post('description');
				$revisi_note = NULL;
				$expired_note = NULL;
				$doc_status = 0;
				$created_at = date('Y-m-d');
				$revised_at = NULL;
				$deleted_at = NULL;
				$created_by = $this->session->userdata('user')[0]['user_id'];
				$revised_by = NULL;
				$deleted_by = NULL;
				$this->form_validation->set_rules('doc_title','Doc_title','required',['required' => 'Document Name tidak boleh kosong']);
				$this->form_validation->set_rules('doc_type_id','Doc_type_id','required',['required' => 'Document tidak boleh kosong']);
				$this->form_validation->set_rules('doc_category_id','Doc_category_id','required',['required' => 'Doc Category tidak boleh kosong']);
				$this->form_validation->set_rules('description','Description','required',['required' => 'Release Description tidak boleh kosong']);
				if ($this->form_validation->run() == false) {
					echo validation_errors();
				} else {
				 
							$data = [
								'doc_release_code' => $doc_release_code,
								'doc_release_date' => $doc_release_date,
								'doc_title' => $doc_title,
								'doc_type_id' => $doc_type_id,
								'department_id' => $department_id,
								'doc_category_id' => $doc_category_id,
								'doc_no' => $doc_no,
								'revisi_no' => $revisi_no,
								'description' => $description,
								'doc_file' => $this->input->post('doc_file_old'),
								'revisi_note' => $revisi_note,
								'expired_note' => $expired_note,
								'doc_status' => $doc_status,
								'created_at' => $created_at,
								'revised_at' => $revised_at,
								'deleted_at' => $deleted_at,
								'created_by' => $created_by,
								'revised_by' => $revised_by,
								'deleted_by' => $deleted_by
							];
							$this->Result_model->update_by_id('doc_release_header', $doc_release_header_id, $data);
							echo 1;
				}
			}
		} elseif ($parameter == 'revise') {
			// revise for staff department
			if (!empty($_FILES['doc_file']['name'])) {
				
				$doc_release_header_id = $this->input->post('doc_release_header_id');
				$doc_release_code = $this->input->post('doc_release_code');
				$doc_release_date = date('Y-m-d', strtotime($this->input->post('doc_release_date')));
				$doc_title = $this->input->post('doc_title');
				$doc_type_id = explode('/', $this->input->post('doc_type_id'))[0];
				$department_id = $this->session->userdata('user')[0]['department_id'];
				$doc_category_id = $this->input->post('doc_category_id');
				$doc_no = $this->input->post('doc_no');
				$description = $this->input->post('description');
				$expired_note = NULL;
				$doc_status = 0;
				$deleted_at = NULL;
				$deleted_by = NULL;
				$this->form_validation->set_rules('doc_title','Doc_title','required',['required' => 'Document Name tidak boleh kosong']);
				$this->form_validation->set_rules('doc_type_id','Doc_type_id','required',['required' => 'Document tidak boleh kosong']);
				$this->form_validation->set_rules('doc_category_id','Doc_category_id','required',['required' => 'Doc Category tidak boleh kosong']);
				$this->form_validation->set_rules('description','Description','required',['required' => 'Release Description tidak boleh kosong']);
				if ($this->form_validation->run() == false) {
					echo validation_errors();
				} else {
						$config['overwrite']            = true;
						$config['max_size']             = 3000;
						$config['upload_path']= "./assets/files/release/";
						$config['allowed_types']        = 'pdf';
						$config['overwrite']            = true;
						 
						$this->load->library('upload',$config);
						if($this->upload->do_upload('doc_file')){
				 
							$data = [
								'doc_release_code' => $doc_release_code,
								'doc_release_date' => $doc_release_date,
								'doc_title' => $doc_title,
								'doc_type_id' => $doc_type_id,
								'department_id' => $department_id,
								'doc_category_id' => $doc_category_id,
								'doc_no' => $doc_no,
								'description' => $description,
								'doc_file' => $this->upload->data('file_name'),
								'expired_note' => $expired_note,
								'doc_status' => $doc_status,
								'deleted_at' => $deleted_at,
								'deleted_by' => $deleted_by
							];
							$this->Result_model->update_by_id('doc_release_header', $doc_release_header_id, $data);

							// delete rows table doc_release_details
							$this->db->where('doc_release_header_id', $doc_release_header_id);
							$this->db->delete('doc_release_details');
							// finish delete rows
							echo 1;
							
						} else {
							$error = array('error' => $this->upload->display_errors());
							
							echo $error['error'];
						}
				}
			} else {
				$doc_release_header_id = $this->input->post('doc_release_header_id');
				$doc_release_code = $this->input->post('doc_release_code');
				$doc_release_date = date('Y-m-d', strtotime($this->input->post('doc_release_date')));
				$doc_title = $this->input->post('doc_title');
				$doc_type_id = explode('/', $this->input->post('doc_type_id'))[0];
				$department_id = $this->session->userdata('user')[0]['department_id'];
				$doc_category_id = $this->input->post('doc_category_id');
				$doc_no = $this->input->post('doc_no');
				$description = $this->input->post('description');
				$expired_note = NULL;
				$doc_status = 0;
				$deleted_at = NULL;
				$deleted_by = NULL;
				$this->form_validation->set_rules('doc_title','Doc_title','required',['required' => 'Document Name tidak boleh kosong']);
				$this->form_validation->set_rules('doc_type_id','Doc_type_id','required',['required' => 'Document tidak boleh kosong']);
				$this->form_validation->set_rules('doc_category_id','Doc_category_id','required',['required' => 'Doc Category tidak boleh kosong']);
				$this->form_validation->set_rules('description','Description','required',['required' => 'Release Description tidak boleh kosong']);
				if ($this->form_validation->run() == false) {
					echo validation_errors();
				} else {
				 
							$data = [
								'doc_release_code' => $doc_release_code,
								'doc_release_date' => $doc_release_date,
								'doc_title' => $doc_title,
								'doc_type_id' => $doc_type_id,
								'department_id' => $department_id,
								'doc_category_id' => $doc_category_id,
								'doc_no' => $doc_no,
								'description' => $description,
								'doc_file' => $this->upload->data('file_name'),
								'expired_note' => $expired_note,
								'doc_status' => $doc_status,
								'deleted_at' => $deleted_at,
								'deleted_by' => $deleted_by
							];
							$this->Result_model->update_by_id('doc_release_header', $doc_release_header_id, $data);

							// delete rows table doc_release_details
							$this->db->where('doc_release_header_id', $doc_release_header_id);
							$this->db->delete('doc_release_details');
							// finish delete rows
							echo 1;
				}
			}
		} elseif ($parameter == 'delete') {
			$doc_release_header_id = $this->input->post('doc_release_header_id');
			$this->db->where('doc_release_header_id', $doc_release_header_id);
			$this->db->delete('doc_release_header');

			$this->db->where('doc_release_header_id', $doc_release_header_id);
			$this->db->delete('doc_release_details');
			echo 1;
		}
	}

	function release_approves($parameter = '')
	{
		if ($parameter == '') {
			$data['title'] = 'Release Approves';
			$this->db->select('doc_release_header.doc_release_header_id');
			$this->db->select('doc_release_header.doc_release_code');
			$this->db->select('doc_release_header.doc_release_date');
			$this->db->select('doc_release_header.doc_title');
			$this->db->select('doc_release_header.doc_type_id');
			$this->db->select('doc_release_header.department_id');
			$this->db->select('doc_release_header.doc_category_id');
			$this->db->select('doc_release_header.doc_no');
			$this->db->select('doc_release_header.revisi_no');
			$this->db->select('doc_release_header.description');
			$this->db->select('doc_release_header.doc_file');
			$this->db->select('doc_release_header.revisi_note');
			$this->db->select('doc_release_header.expired_note');
			$this->db->select('doc_release_header.doc_status');
			$this->db->select('doc_release_header.created_at');
			$this->db->select('doc_release_header.revised_at');
			$this->db->select('doc_release_header.deleted_at');
			$this->db->select('doc_release_header.created_by');
			$this->db->select('doc_release_header.revised_by');
			$this->db->select('doc_release_header.deleted_by');
			$this->db->from('doc_release_header');
			$this->db->join('release_approves', 'doc_release_header.doc_release_header_id = release_approves.doc_release_header_id', 'left');
			$this->db->where('doc_release_header.doc_status', 0); // doc_status waiting
			if ($this->session->userdata('user')[0]['level_id'] == 2) {
				$this->db->where('release_approves.doc_release_header_id', NULL);
				$this->db->where('doc_release_header.department_id', $this->session->userdata('user')[0]['department_id']);
				$this->db->where('release_approves.approve_dept_by', NULL);
				$this->db->where('release_approves.approve_dc_by', NULL);
				$this->db->where('release_approves.approve_mr_by', NULL);
			}
			if ($this->session->userdata('user')[0]['level_id'] == 3) {
				$this->db->where('release_approves.approve_dept_by !=', NULL);
				$this->db->where('release_approves.approve_dc_by', NULL);
				$this->db->where('release_approves.approve_mr_by', NULL);
			}
			if ($this->session->userdata('user')[0]['level_id'] == 4) {
				$this->db->where('release_approves.approve_dept_by !=', NULL);
				$this->db->where('release_approves.approve_dc_by !=', NULL);
				$this->db->where('release_approves.approve_mr_by', NULL);
			}
			$data['doc_release_headers'] = $this->db->get()->result_array();
			$data['table'] = 'release_approves';
			$this->templating('release_approves/index', $data);
		} elseif ($parameter == 'approves') {
			$approve_note = $this->input->post('approve_note');
			$doc_release_header_id = $this->input->post('doc_release_header_id');
			$approve_status = 1;
			$approve_date = date('Y-m-d');
			$approve_by = $this->session->userdata('user')[0]['user_id'];
			if ($this->session->userdata('user')[0]['level_id'] == 2) {
				$data = [
					'doc_release_header_id' => $doc_release_header_id,
					'approve_status' => $approve_status,
					'approve_dept_date' => $approve_date,
					'approve_dept_note' => $approve_note,
					'approve_dept_by' => $approve_by
				];
				$this->db->insert('release_approves', $data);
				echo 1;
			}
			if ($this->session->userdata('user')[0]['level_id'] == 3) {
				$data_detail = $this->input->post('distribution_to');
				$data = [
					'approve_dc_date' => $approve_date,
					'approve_dc_note' => $approve_note,
					'approve_dc_by' => $approve_by
				];
				$this->db->where('doc_release_header_id', $doc_release_header_id);
				$this->db->update('release_approves', $data);
				$data_insert_detail = [];
				for ($i=0; $i < count($data_detail) ; $i++) { 
					$arr = [
						'doc_release_header_id' => $doc_release_header_id,
						'department_id' => $data_detail[$i],
					];
					$data_insert_detail[] = $arr;
				}
				// insert table distribusi
				 $this->db->insert_batch('doc_release_details', $data_insert_detail);
				echo 1;
			}
			if ($this->session->userdata('user')[0]['level_id'] == 4) {
				$data = [
					'approve_mr_date' => $approve_date,
					'approve_mr_note' => $approve_note,
					'approve_mr_by' => $approve_by
				];
				$this->db->where('doc_release_header_id', $doc_release_header_id);
				$this->db->update('release_approves', $data);
				$this->db->where('doc_release_header_id', $doc_release_header_id);
				$this->db->update('doc_release_header', ['doc_status' => 1]); // 1 for approves

				// masih cari cari koding watermark ( belum nemu )
				echo 1;
			}
			
		} elseif ($parameter == 'revised') {
			$approve_note = $this->input->post('approve_note');
			$doc_release_header_id = $this->input->post('doc_release_header_id');
			$approve_status = 1;
			$approve_date = date('Y-m-d');
			$approve_by = $this->session->userdata('user')[0]['user_id'];

				$cek_approve = $this->Result_model->get_by_name('release_approves','doc_release_header_id', $doc_release_header_id);
				if ($cek_approve) {
					// delete row on table release_approve
					$this->db->where('doc_release_header_id', $doc_release_header_id);
					$this->db->delete('release_approves');
					// finish delete release_approves
				}

				// update doc_release_header
				// $revisi_no = $this->Result_model->get_name_by_id('doc_release_header', $doc_release_header_id, 'revisi_no');
				// if ($revisi_no == NULL) {
				// 	$revisi_no = 1;
				// } else {
				// 	$revisi_no += 1;
				// }
				$data = [
					// 'revisi_no' => $revisi_no,
					'revisi_note' => $approve_note,
					'doc_status' => 2,
					'revised_at' => $approve_date,
					'revised_by' => $approve_by
				];
				$this->Result_model->update_by_id('doc_release_header', $doc_release_header_id, $data);
				echo 1;
		} elseif ($parameter == 'rejected') {
			$approve_note = $this->input->post('approve_note');
			$doc_release_header_id = $this->input->post('doc_release_header_id');
			$approve_status = 1;
			$approve_date = date('Y-m-d');
			$approve_by = $this->session->userdata('user')[0]['user_id'];

				$cek_approve = $this->Result_model->get_by_name('release_approves','doc_release_header_id', $doc_release_header_id);
				if ($cek_approve) {
					// delete row on table release_approve
					$this->db->where('doc_release_header_id', $doc_release_header_id);
					$this->db->delete('release_approves');
					// finish delete release_approves
				}

				// update doc_release_header
				$data = [
					'revisi_note' => $approve_note,
					'doc_status' => 3,
					'revised_at' => $approve_date,
					'revised_by' => $approve_by
				];
				$this->Result_model->update_by_id('doc_release_header', $doc_release_header_id, $data);
				echo 1;
		}
	}

	function distributions($parameter='', $parameter2 = '')
	{
		if ($parameter == '') {
			$data['title'] = 'Distributions';
			$this->db->select('doc_release_header.doc_release_header_id');
			$this->db->select('doc_release_header.doc_release_code');
			$this->db->select('doc_release_header.doc_release_date');
			$this->db->select('doc_release_header.doc_title');
			$this->db->select('doc_release_header.doc_type_id');
			$this->db->select('doc_release_header.department_id');
			$this->db->select('doc_release_header.doc_category_id');
			$this->db->select('doc_release_header.doc_no');
			$this->db->select('doc_release_header.revisi_no');
			$this->db->select('doc_release_header.description');
			$this->db->select('doc_release_header.doc_file');
			$this->db->select('doc_release_header.revisi_note');
			$this->db->select('doc_release_header.expired_note');
			$this->db->select('doc_release_header.doc_status');
			$this->db->select('doc_release_header.created_at');
			$this->db->select('doc_release_header.revised_at');
			$this->db->select('doc_release_header.deleted_at');
			$this->db->select('doc_release_header.created_by');
			$this->db->select('doc_release_header.revised_by');
			$this->db->select('doc_release_header.deleted_by');
			$this->db->select('doc_release_details.doc_release_details_id');
			$this->db->from('doc_release_header');
			$this->db->join('doc_release_details', 'doc_release_header.doc_release_header_id = doc_release_details.doc_release_header_id', 'left');
			$this->db->where('doc_release_header.doc_status', 1);
			$this->db->where('doc_release_details.department_id', $this->session->userdata('user')[0]['department_id']);
			$data['doc_release_headers'] = $this->db->get()->result_array();
			$data['table'] = 'doc_release_header';
			$this->templating('distributions/index', $data);
		} elseif ($parameter == 'confirmed') {
			$doc_release_details_id = $parameter2;
			$data = [
				'doc_release_details_id' => $doc_release_details_id,
				'confirm_by' => $this->session->userdata('user')[0]['user_id'],
				'confirm_date' => date('Y-m-d')
			];
			$this->db->insert('distributions', $data);
			echo "Confirmed Doc Distribution Success";
		} elseif ($parameter == 'details') {
			$doc_release_header_id = $parameter2;
			$cek_distribution = $this->db->query("SELECT doc_release_details.department_id FROM doc_release_details RIGHT JOIN distributions ON doc_release_details.doc_release_details_id = distributions.doc_release_details_id WHERE doc_release_details.doc_release_header_id = '$doc_release_header_id'")->result_array();
			$cek_all_department = $this->db->query("SELECT doc_release_details.department_id FROM doc_release_details WHERE doc_release_details.doc_release_header_id = '$doc_release_header_id'")->result_array();

			foreach ($cek_all_department as $key => $value) :
				$arr_department = [
					'department_id' => $value['department_id'],
					'department_code' => $this->Result_model->get_name_by_id('department', $value['department_id'], 'department_code')
				];

				$total_distribusi_department[] = $arr_department;
			endforeach;

			foreach ($cek_distribution as $key => $value) :
				$arr_department_confirm = [
					'department_id' => $value['department_id'],
					'department_code' => $this->Result_model->get_name_by_id('department', $value['department_id'], 'department_code')
				];

				$total_distribusi_department_confirm[] = $arr_department_confirm;
			endforeach;

			$result = [];
			$result[] = $total_distribusi_department;
			$result[] = $total_distribusi_department_confirm;

			echo json_encode($result);
		}
	}

	function revise($parameter='')
	{
		if ($parameter == '') {
			$data['title'] = 'Revise';
			$cek_department = $this->Result_model->get_name_by_id('department', $this->session->userdata('user')[0]['department_id'], 'department_code');
			if ($this->session->userdata('user')[0]['level_id'] != 5 ) {
				$this->db->where('department_id', $this->session->userdata('user')[0]['department_id']);
			}
			$this->db->where('doc_status', 1);
			$data['doc_release_headers'] = $this->Result_model->getData('doc_release_header');
			$data['table'] = 'doc_release_header';
			$this->templating('revise/index', $data);
		} elseif ($parameter == 'revise') {
			if (!empty($_FILES['doc_file']['name'])) {
				
				$doc_release_header_id = $this->input->post('doc_release_header_id');
				$doc_release_code = $this->input->post('doc_release_code_new');
				$doc_release_date = date('Y-m-d', strtotime($this->input->post('doc_release_date')));
				$doc_title = $this->input->post('doc_title');
				$doc_type_id = explode('/', $this->input->post('doc_type_id'))[0];
				$department_id = $this->session->userdata('user')[0]['department_id'];
				$doc_category_id = $this->input->post('doc_category_id');
				$doc_no = $this->input->post('doc_no');
				$revisi_no = $this->input->post('revisi_no');
				$description = $this->input->post('description');
				$revisi_note = $this->input->post('revise_note');
				$expired_note = NULL;
				$doc_status = 0;
				$created_at = date('Y-m-d');
				$revised_at = date('Y-m-d');
				$deleted_at = NULL;
				$created_by = $this->session->userdata('user')[0]['user_id'];
				$revised_by = NULL;
				$deleted_by = NULL;
				$this->form_validation->set_rules('doc_title','Doc_title','required',['required' => 'Document Name tidak boleh kosong']);
				$this->form_validation->set_rules('doc_type_id','Doc_type_id','required',['required' => 'Document tidak boleh kosong']);
				$this->form_validation->set_rules('doc_category_id','Doc_category_id','required',['required' => 'Doc Category tidak boleh kosong']);
				$this->form_validation->set_rules('description','Description','required',['required' => 'Release Description tidak boleh kosong']);
				$this->form_validation->set_rules('revise_note','Revise_note','required',['required' => 'Note tidak boleh kosong']);
				if ($this->form_validation->run() == false) {
					echo validation_errors();
				} else {
						$config['overwrite']            = true;
						$config['max_size']             = 3000;
						$config['upload_path']= "./assets/files/release/";
						$config['allowed_types']        = 'pdf';
						$config['overwrite']            = true;
						 
						$this->load->library('upload',$config);
						if($this->upload->do_upload('doc_file')){
				 
							$data = [
								'doc_release_code' => $doc_release_code,
								'doc_release_date' => $doc_release_date,
								'doc_title' => $doc_title,
								'doc_type_id' => $doc_type_id,
								'department_id' => $department_id,
								'doc_category_id' => $doc_category_id,
								'doc_no' => $doc_no,
								'revisi_no' => $revisi_no,
								'description' => $description,
								'doc_file' => $this->upload->data('file_name'),
								'revisi_note' => $revisi_note,
								'expired_note' => $expired_note,
								'doc_status' => $doc_status,
								'created_at' => $created_at,
								'revised_at' => $revised_at,
								'deleted_at' => $deleted_at,
								'created_by' => $created_by,
								'revised_by' => $revised_by,
								'deleted_by' => $deleted_by
							];
							$this->db->insert('doc_release_header', $data);
							$this->Result_model->update_by_id('doc_release_header', $doc_release_header_id, ['doc_status' => 4,'revised_by' => $this->session->userdata('user')[0]['user_id'], 'revised_at' => date('Y-m-d'), 'expired_note' => $revisi_note]); // expired
							echo 1;
							
						} else {
							$error = array('error' => $this->upload->display_errors());
							
							echo $error['error'];
						}
				}
			} else {
				echo 2; // belum upload document revise
			}
		} elseif ($parameter == 'destroyed') {
			$doc_release_header_id = $this->input->post('doc_release_header_id');
			$revise_note = $this->input->post('revise_note');
			$this->Result_model->update_by_id('doc_release_header', $doc_release_header_id, ['doc_status' => 5, 'deleted_by' => $this->session->userdata('user')[0]['user_id'], 'deleted_at' => date('Y-m-d'), 'revisi_note' => $revise_note]); // destroyed
			echo 1;
		}
	}

	function master_doc_list($parameter='')
	{
		if ($parameter == '') {
			$data['title'] = 'Master Doc List';
			$this->db->select('doc_release_header.doc_release_header_id');
			$this->db->select('doc_release_header.doc_release_code');
			$this->db->select('doc_release_header.doc_release_date');
			$this->db->select('doc_release_header.doc_title');
			$this->db->select('doc_release_header.doc_type_id');
			$this->db->select('doc_release_header.department_id');
			$this->db->select('doc_release_header.doc_category_id');
			$this->db->select('doc_release_header.doc_no');
			$this->db->select('doc_release_header.revisi_no');
			$this->db->select('doc_release_header.description');
			$this->db->select('doc_release_header.doc_file');
			$this->db->select('doc_release_header.revisi_note');
			$this->db->select('doc_release_header.expired_note');
			$this->db->select('doc_release_header.doc_status');
			$this->db->select('doc_release_header.created_at');
			$this->db->select('doc_release_header.revised_at');
			$this->db->select('doc_release_header.deleted_at');
			$this->db->select('doc_release_header.created_by');
			$this->db->select('doc_release_header.revised_by');
			$this->db->select('doc_release_header.deleted_by');
			$this->db->select('doc_release_details.doc_release_details_id');
			$this->db->from('doc_release_header');
			$this->db->join('doc_release_details', 'doc_release_header.doc_release_header_id = doc_release_details.doc_release_header_id', 'left');
			$this->db->where('doc_release_header.doc_status', 1);
			$this->db->where('doc_release_details.department_id', $this->session->userdata('user')[0]['department_id']);
			$data['doc_release_headers'] = $this->db->get()->result_array();
			$data['table'] = 'doc_release_header';
			$this->templating('master_doc_list/index', $data);
		} 
	}

	function expired($parameter='')
	{
		if ($parameter == '') {
			$data['title'] = 'Expired';
			$this->db->where('doc_status', 4);
			$data['doc_release_headers'] = $this->Result_model->getData('doc_release_header');
			$data['table'] = 'doc_release_header';
			$this->templating('expired/index', $data);
		}
	}

	function destroyed($parameter='')
	{
		if ($parameter == '') {
			$data['title'] = 'Destroyed';
			$this->db->where('doc_status', 5);
			$data['doc_release_headers'] = $this->Result_model->getData('doc_release_header');
			$data['table'] = 'doc_release_header';
			$this->templating('destroyed/index', $data);
		}
	}

	function report($parameter='')
	{
		if ($parameter == '') {
			$data['table'] = 'doc_release_header';
			$data['title'] = 'Report';
				$this->db->select('doc_release_header.doc_release_header_id');
				$this->db->select('doc_release_header.doc_release_code');
				$this->db->select('doc_release_header.doc_release_date');
				$this->db->select('doc_release_header.doc_title');
				$this->db->select('doc_release_header.doc_type_id');
				$this->db->select('doc_release_header.department_id');
				$this->db->select('doc_release_header.doc_category_id');
				$this->db->select('doc_release_header.doc_no');
				$this->db->select('doc_release_header.revisi_no');
				$this->db->select('doc_release_header.description');
				$this->db->select('doc_release_header.doc_file');
				$this->db->select('doc_release_header.revisi_note');
				$this->db->select('doc_release_header.expired_note');
				$this->db->select('doc_release_header.doc_status');
				$this->db->select('doc_release_header.created_at');
				$this->db->select('doc_release_header.revised_at');
				$this->db->select('doc_release_header.deleted_at');
				$this->db->select('doc_release_header.created_by');
				$this->db->select('doc_release_header.revised_by');
				$this->db->select('doc_release_header.deleted_by');
				$this->db->select('release_approves.approve_dept_by');
				$this->db->select('release_approves.approve_dc_by');
				$this->db->select('release_approves.approve_mr_by');
				$this->db->from('doc_release_header');
				$this->db->join('release_approves', 'doc_release_header.doc_release_header_id = release_approves.doc_release_header_id', 'left');
				$this->db->where('doc_release_header.doc_status', 1);
				$this->db->order_by('release_approves.approve_mr_date','ASC');
				$data['release'] = $this->db->get()->result_array();
			$this->templating('report/index', $data);
		} elseif ($parameter == 'pdf') {
			$jenis	= $this->input->post('jenis');
			$tgl_awal	= $this->input->post('tgl_awal');
			$tgl_akhir	= $this->input->post('tgl_akhir');
			$mpdf = new \Mpdf\Mpdf();

			if ($jenis == 'release') {
				$this->db->select('doc_release_header.doc_release_header_id');
				$this->db->select('doc_release_header.doc_release_code');
				$this->db->select('doc_release_header.doc_release_date');
				$this->db->select('doc_release_header.doc_title');
				$this->db->select('doc_release_header.doc_type_id');
				$this->db->select('doc_release_header.department_id');
				$this->db->select('doc_release_header.doc_category_id');
				$this->db->select('doc_release_header.doc_no');
				$this->db->select('doc_release_header.revisi_no');
				$this->db->select('doc_release_header.description');
				$this->db->select('doc_release_header.doc_file');
				$this->db->select('doc_release_header.revisi_note');
				$this->db->select('doc_release_header.expired_note');
				$this->db->select('doc_release_header.doc_status');
				$this->db->select('doc_release_header.created_at');
				$this->db->select('doc_release_header.revised_at');
				$this->db->select('doc_release_header.deleted_at');
				$this->db->select('doc_release_header.created_by');
				$this->db->select('doc_release_header.revised_by');
				$this->db->select('doc_release_header.deleted_by');
				$this->db->select('release_approves.approve_dept_by');
				$this->db->select('release_approves.approve_dc_by');
				$this->db->select('release_approves.approve_mr_by');
				$this->db->from('doc_release_header');
				$this->db->join('release_approves', 'doc_release_header.doc_release_header_id = release_approves.doc_release_header_id', 'left');
				$this->db->where('doc_release_header.doc_status', 1);
				$this->db->where('release_approves.approve_mr_date >=', date('Y-m-d',strtotime($tgl_awal)));
				$this->db->where('release_approves.approve_mr_date <=', date('Y-m-d',strtotime($tgl_akhir)));
				$this->db->order_by('release_approves.approve_mr_date','ASC');
				$release = $this->db->get()->result_array();

				if (!$release) {
					$data = '<div style="text-align: center;">';

	                $data .= '<h3>DOCUMENT CONTROL</h3>
	                            <h3>Laporan Document Release</h3>
	                            <h4>'.date('d F Y', strtotime($tgl_awal));
	                $data .= ' s/d '.date('d F Y', strtotime($tgl_akhir));
	                $data .= '</h4>
	                         </div>
	                        <hr/>';
	                $data .= '<h3 style="background-color:red;text-align:center;">Maaf Tidak ada Report Release untuk tanggal yang di pilih</h3>';
				} else {
	                $data = '<div style="text-align: center;">';

	                $data .= '<h3>DOCUMENT CONTROL</h3>
	                            <h3>Laporan Document Release</h3>
	                            <h4>'.date('d F Y', strtotime($tgl_awal));
	                $data .= ' s/d '.date('d F Y', strtotime($tgl_akhir));
	                $data .= '</h4>
	                         </div>
	                        <hr/>';
	                $data .= '<table border="1">
	                          <thead>
	                            <tr>
	                              <th>No</th>
	                              <th>Propose Date</th>
	                              <th>Doc Propose No</th>
	                              <th>Doc No</th>
	                              <th>Doc Title</th>
	                              <th>Created By</th>
	                              <th>Approved Head Of Dept By</th>
	                              <th>Approved Staff DC By</th>
	                              <th>Approved Head Of MR By</th>
	                            </tr>
	                          </thead>
	                          <tbody>';
	                        $no = 1; $sw = 0; foreach ($release as $s => $value) :
	                        // make doc_no
		                      $doc_no = 'ILP-'.$this->Result_model->get_name_by_id('document', $value['doc_type_id'], 'document_code');
		                      $doc_no .= '-'.$this->Result_model->get_name_by_id('department', $value['department_id'], 'department_code');
		                      if ($value['doc_category_id'] < 10) {
		                        $doc_category_id = '0'.$value['doc_category_id'];
		                      } else {
		                        $doc_category_id = $value['doc_category_id'];
		                      }
		                      $doc_no .= '-'.$doc_category_id;
		                      if ($value['doc_no'] < 10) {
		                        $doc_nomor_urut = '0'.$value['doc_no'];
		                      } else {
		                        $doc_nomor_urut = $value['doc_no'];
		                      }
		                      $doc_no .= '-'.$doc_nomor_urut;
		                      $revisi_no = $this->Result_model->get_name_by_id('doc_release_header', $value['doc_release_header_id'], 'revisi_no');
		                      if ($revisi_no == NULL) {
		                        $revisi_no = '00';
		                      } else {
		                        if ($revisi_no < 10) {
		                          $revisi_no = '0'.$revisi_no;
		                        } else {
		                          $revisi_no = $revisi_no;
		                        }
		                      }
		                      $doc_no .= '-'.$revisi_no;
		                      // finish mak doc_no
	                    $data .= '<tr>
	                              <th scope="row">'.$no++;
	                    $data .='</th>
	                            <td>'.date('d-m-Y',strtotime($value['doc_release_date']));
	                    $data .='</td>
	                             <td>'.$value['doc_release_code'];
	                    $data .='</td>
	                             <td>'.$doc_no;
	                    $data .='</td>
	                             <td>'.$value['doc_title'];
	                    $data .='</td>
	                             <td style="text-align:center;">'.$this->Result_model->get_name_by_id('user', $value['created_by'], 'user_name');
	                    $data .='</td>
	                             <td style="text-align:center;">'.$this->Result_model->get_name_by_id('user', $value['approve_dept_by'], 'user_name');
	                    $data .='</td>
	                             <td style="text-align:center;">'.$this->Result_model->get_name_by_id('user', $value['approve_dc_by'], 'user_name');
	                    $data .='</td>
	                             <td style="text-align:center;">'.$this->Result_model->get_name_by_id('user', $value['approve_mr_by'], 'user_name');
	                    $data .='</td>
	                            </tr>';
	                    endforeach;
	                  $data .='</tbody>
	                            </table>';
	                $data .= '<p class="mb-0 text-right">CREATED BY</p>
	                        <footer class="blockquote-footer text-right">Doc Control</footer>';
	            }
			} elseif ($jenis == 'expired') {
				$this->db->order_by('revised_at','ASC');
				$this->db->where('doc_status', 4);
				$expired = $this->Result_model->getData('doc_release_header');
				if (!$expired) {
					$data = '<div style="text-align: center;">';

	                $data .= '<h3>DOCUMENT CONTROL</h3>
	                            <h3>Laporan Document Expired</h3>
	                            <h4>'.date('d F Y', strtotime($tgl_awal));
	                $data .= ' s/d '.date('d F Y', strtotime($tgl_akhir));
	                $data .= '</h4>
	                         </div>
	                        <hr/>';
	                $data .= '<h3 style="background-color:red;text-align:center;">Maaf Tidak ada Report Expired untuk tanggal yang di pilih</h3>';
				} else {
					$data = '<div style="text-align: center;">';

	                $data .= '<h3>DOCUMENT CONTROL</h3>
	                            <h3>Laporan Document Expired</h3>
	                            <h4>'.date('d F Y', strtotime($tgl_awal));
	                $data .= ' s/d '.date('d F Y', strtotime($tgl_akhir));
	                $data .= '</h4>
	                         </div>
	                        <hr/>';
	                $data .= '<table border="1">
	                          <thead>
	                            <tr>
	                              <th>No</th>
	                              <th>Expired Date</th>
	                              <th>Doc Propose No</th>
	                              <th>Doc No</th>
	                              <th>Doc Title</th>
	                              <th>Expired Note</th>
	                            </tr>
	                          </thead>
	                          <tbody>';
	                        $no = 1; $sw = 0; foreach ($expired as $s => $value) :
	                        // make doc_no
		                      $doc_no = 'ILP-'.$this->Result_model->get_name_by_id('document', $value['doc_type_id'], 'document_code');
		                      $doc_no .= '-'.$this->Result_model->get_name_by_id('department', $value['department_id'], 'department_code');
		                      if ($value['doc_category_id'] < 10) {
		                        $doc_category_id = '0'.$value['doc_category_id'];
		                      } else {
		                        $doc_category_id = $value['doc_category_id'];
		                      }
		                      $doc_no .= '-'.$doc_category_id;
		                      if ($value['doc_no'] < 10) {
		                        $doc_nomor_urut = '0'.$value['doc_no'];
		                      } else {
		                        $doc_nomor_urut = $value['doc_no'];
		                      }
		                      $doc_no .= '-'.$doc_nomor_urut;
		                      $revisi_no = $this->Result_model->get_name_by_id('doc_release_header', $value['doc_release_header_id'], 'revisi_no');
		                      if ($revisi_no == NULL) {
		                        $revisi_no = '00';
		                      } else {
		                        if ($revisi_no < 10) {
		                          $revisi_no = '0'.$revisi_no;
		                        } else {
		                          $revisi_no = $revisi_no;
		                        }
		                      }
		                      $doc_no .= '-'.$revisi_no;
		                      // finish mak doc_no
	                    $data .= '<tr>
	                              <th scope="row">'.$no++;
	                    $data .='</th>
	                            <td>'.date('d-m-Y',strtotime($value['revised_at']));
	                    $data .='</td>
	                             <td>'.$value['doc_release_code'];
	                    $data .='</td>
	                             <td>'.$doc_no;
	                    $data .='</td>
	                             <td>'.$value['doc_title'];
	                    $data .='</td>
	                             <td>'.$value['expired_note'];
	                    $data .='</td>
	                            </tr>';
	                    endforeach;
	                  $data .='</tbody>
	                            </table>';
	                $data .= '<p class="mb-0 text-right">CREATED BY</p>
	                        <footer class="blockquote-footer text-right">Doc Control</footer>';
	            }
			} elseif ($jenis == 'destroyed') {
				$this->db->order_by('deleted_at', 'ASC');
				$this->db->where('doc_status', 5);
				$destroyed = $this->Result_model->getData('doc_release_header');
				if (!$destroyed) {
					$data = '<div style="text-align: center;">';

	                $data .= '<h3>DOCUMENT CONTROL</h3>
	                            <h3>Laporan Document Destroyed</h3>
	                            <h4>'.date('d F Y', strtotime($tgl_awal));
	                $data .= ' s/d '.date('d F Y', strtotime($tgl_akhir));
	                $data .= '</h4>
	                         </div>
	                        <hr/>';
	                $data .= '<h3 style="background-color:red;text-align:center;">Maaf Tidak ada Report Destroyed untuk tanggal yang di pilih</h3>';
				} else {
					$data = '<div style="text-align: center;">';

	                $data .= '<h3>DOCUMENT CONTROL</h3>
	                            <h3>Laporan Document Destroyed</h3>
	                            <h4>'.date('d F Y', strtotime($tgl_awal));
	                $data .= ' s/d '.date('d F Y', strtotime($tgl_akhir));
	                $data .= '</h4>
	                         </div>
	                        <hr/>';
	                $data .= '<table border="1">
	                          <thead>
	                            <tr>
	                              <th>No</th>
	                              <th>Destroyed Date</th>
	                              <th>Doc Propose No</th>
	                              <th>Doc No</th>
	                              <th>Doc Title</th>
	                              <th>Destroyed Note</th>
	                            </tr>
	                          </thead>
	                          <tbody>';
	                        $no = 1; $sw = 0; foreach ($destroyed as $s => $value) :
	                        // make doc_no
		                      $doc_no = 'ILP-'.$this->Result_model->get_name_by_id('document', $value['doc_type_id'], 'document_code');
		                      $doc_no .= '-'.$this->Result_model->get_name_by_id('department', $value['department_id'], 'department_code');
		                      if ($value['doc_category_id'] < 10) {
		                        $doc_category_id = '0'.$value['doc_category_id'];
		                      } else {
		                        $doc_category_id = $value['doc_category_id'];
		                      }
		                      $doc_no .= '-'.$doc_category_id;
		                      if ($value['doc_no'] < 10) {
		                        $doc_nomor_urut = '0'.$value['doc_no'];
		                      } else {
		                        $doc_nomor_urut = $value['doc_no'];
		                      }
		                      $doc_no .= '-'.$doc_nomor_urut;
		                      $revisi_no = $this->Result_model->get_name_by_id('doc_release_header', $value['doc_release_header_id'], 'revisi_no');
		                      if ($revisi_no == NULL) {
		                        $revisi_no = '00';
		                      } else {
		                        if ($revisi_no < 10) {
		                          $revisi_no = '0'.$revisi_no;
		                        } else {
		                          $revisi_no = $revisi_no;
		                        }
		                      }
		                      $doc_no .= '-'.$revisi_no;
		                      // finish mak doc_no
	                    $data .= '<tr>
	                              <th scope="row">'.$no++;
	                    $data .='</th>
	                            <td>'.date('d-m-Y',strtotime($value['deleted_at']));
	                    $data .='</td>
	                             <td>'.$value['doc_release_code'];
	                    $data .='</td>
	                             <td>'.$doc_no;
	                    $data .='</td>
	                             <td>'.$value['doc_title'];
	                    $data .='</td>
	                             <td>'.$value['revisi_note'];
	                    $data .='</td>
	                            </tr>';
	                    endforeach;
	                  $data .='</tbody>
	                            </table>';
	                $data .= '<p class="mb-0 text-right">CREATED BY</p>
	                        <footer class="blockquote-footer text-right">Doc Control</footer>';
	            }
			}
                $mpdf->WriteHTML($data);
                $mpdf->Output();
		} elseif ($parameter == 'pengesahan') {
			$doc_release_header_id = $this->input->post('doc_release_header_id');
				$this->db->select('doc_release_header.doc_release_header_id');
				$this->db->select('doc_release_header.doc_release_code');
				$this->db->select('doc_release_header.doc_release_date');
				$this->db->select('doc_release_header.doc_title');
				$this->db->select('doc_release_header.doc_type_id');
				$this->db->select('doc_release_header.department_id');
				$this->db->select('doc_release_header.doc_category_id');
				$this->db->select('doc_release_header.doc_no');
				$this->db->select('doc_release_header.revisi_no');
				$this->db->select('doc_release_header.description');
				$this->db->select('doc_release_header.doc_file');
				$this->db->select('doc_release_header.revisi_note');
				$this->db->select('doc_release_header.expired_note');
				$this->db->select('doc_release_header.doc_status');
				$this->db->select('doc_release_header.created_at');
				$this->db->select('doc_release_header.revised_at');
				$this->db->select('doc_release_header.deleted_at');
				$this->db->select('doc_release_header.created_by');
				$this->db->select('doc_release_header.revised_by');
				$this->db->select('doc_release_header.deleted_by');
				$this->db->select('release_approves.approve_dept_by');
				$this->db->select('release_approves.approve_dc_by');
				$this->db->select('release_approves.approve_mr_by');
				$this->db->select('release_approves.approve_dept_date');
				$this->db->select('release_approves.approve_dc_date');
				$this->db->select('release_approves.approve_mr_date');
				$this->db->from('doc_release_header');
				$this->db->join('release_approves', 'doc_release_header.doc_release_header_id = release_approves.doc_release_header_id', 'left');
				$this->db->where('doc_release_header.doc_status', 1);
				$this->db->where('doc_release_header.doc_release_header_id', $doc_release_header_id);
				$this->db->order_by('release_approves.approve_mr_date','ASC');
				$pengesahan = $this->db->get()->result_array();

			$mpdf = new \Mpdf\Mpdf();
					$data = '<style>
								#box1{
									width:150px;
									height:150px;
									border-style: groove;
									border-width: 25px;
								}
							 </style>
							<div style="text-align: center;">';

	                $data .= '<h3>LEMBAR PENGESAHAN</h3>';
	                $data .= '</div>
	                        <hr/>';
	                		$no = 1; $sw = 0; foreach ($pengesahan as $s => $value) :
	                        // make doc_no
		                      $doc_no = 'ILP-'.$this->Result_model->get_name_by_id('document', $value['doc_type_id'], 'document_code');
		                      $doc_no .= '-'.$this->Result_model->get_name_by_id('department', $value['department_id'], 'department_code');
		                      if ($value['doc_category_id'] < 10) {
		                        $doc_category_id = '0'.$value['doc_category_id'];
		                      } else {
		                        $doc_category_id = $value['doc_category_id'];
		                      }
		                      $doc_no .= '-'.$doc_category_id;
		                      if ($value['doc_no'] < 10) {
		                        $doc_nomor_urut = '0'.$value['doc_no'];
		                      } else {
		                        $doc_nomor_urut = $value['doc_no'];
		                      }
		                      $doc_no .= '-'.$doc_nomor_urut;
		                      $revisi_no = $this->Result_model->get_name_by_id('doc_release_header', $value['doc_release_header_id'], 'revisi_no');
		                      if ($revisi_no == NULL) {
		                        $revisi_no = '00';
		                      } else {
		                        if ($revisi_no < 10) {
		                          $revisi_no = '0'.$revisi_no;
		                        } else {
		                          $revisi_no = $revisi_no;
		                        }
		                      }
		                      $doc_no .= '-'.$revisi_no;
	                $data .= '<h3 style="color:red;text-align:center;">'.$doc_no.'</h3>';
	                $data .= '<h6 style="color:red;text-align:center;">Revisi        : 0'.$value['revisi_no'].'</h6>';
	                $data .= '<h6>Document Name : '.$value['doc_title'].'</h6>';
	                $data .= '<h6>Release Date : '.date('d F Y',strtotime($value['approve_mr_date'])).'</h6>';
	                $data .= '<table border="1" style="text-align:center;position:fixed">
	                          <thead>
	                            <tr>
	                              <th>Created</th>
	                              <th>Approve Head Of Dept</th>
	                              <th>Approve Staff DC</th>
	                              <th>Approve Head Of MR</th>
	                            </tr>
	                          </thead>
	                          <tbody>';
	                $data .= '<tr>';
	                $data .= '<td>1</td>';
	                $data .= '<td><div id="box1">APPROVED</div></td>';
	                $data .= '<td>1</td>';
	                $data .= '<td>1</td>';
	                $data .= '</tr>';
	                $data .='</tbody>
	                        </table>';
	            			endforeach;
			$mpdf->WriteHTML($data);
            $mpdf->Output();
		}
	}
	
	function ajax_load($table, $action, $id = '')
    {
        if ($action ==  "add") {
			$this->_sessionguard();
            $data['title'] = 'Add '.$table;
            $data['table'] = $table;
            $page = 'back/'.$table.'/'.$table.'-add';
			
            return $this->load->view($page, $data);
        } elseif ($action == "edit") {
			$this->_sessionguard();
            $data['results'] = $this->db->get_where($table,[$table.'_id' => $id])->row();
            $data['title'] = 'Edit '.$table;
            $data['table'] = $table;
            $page = 'back/'.$table.'/'.$table.'-edit';
			
            return $this->load->view($page, $data);
        }
	}

	function load_revise($id ='')
	{
		$this->_sessionguard();
        $data['results'] = $this->db->get_where('doc_release_header',['doc_release_header_id' => $id])->row();
        $data['title'] = 'Revise Document';
        $data['table'] = 'doc_release_header';
        $page = 'back/revise/revise';
			
        return $this->load->view($page, $data);	
	}
	
	function ajax_load_approves($info, $id)
    {
		if ($info ==  "dc") {
			$this->_sessionguard();
			$data['results'] = $this->db->get_where('doc_release_header',['doc_release_header_id' => $id])->row();
            $data['title'] = 'Approves Menu';
            $data['table'] = 'doc_release_header';
            $page = 'back/release_approves/approves-dc';
			
            return $this->load->view($page, $data);
        } elseif ($info == "nondc") {
			$this->_sessionguard();
			$data['results'] = $this->db->get_where('doc_release_header',['doc_release_header_id' => $id])->row();
            $data['title'] = 'Approves Menu';
            $data['table'] = 'doc_release_header';
            $page = 'back/release_approves/approves-non-dc';

            return $this->load->view($page, $data);
        }
    }

    // this function use on master user to validation level user
    function ajax_set_dept_and_level($dept_id)
    {
    	$department_code = $this->Result_model->get_name_by_id('department', $dept_id, 'department_code');
    	$department_name = $this->Result_model->get_name_by_id('department', $dept_id, 'department_name');

    	if ($department_code == 'QA' || $department_name == 'Quality Assurance') {
    		echo "QA";
    	} elseif ($department_code == 'MGN' || $department_code == 'MGNT' || $department_name == 'Management') {
    		echo "Management";
    	} elseif ($department_code == 'IT') {
    		echo "IT";
    	} else {
    		echo "Other";
    	}
    }

    // this function use for validation duplicate data on master
    function validation($table, $select, $select_value, $select2 = '', $select_value2 = '')
    {
    	$value1 = explode('%20', $select_value);
    	$select_value_fix = '';
    	for ($i=0; $i < count($value1); $i++) : 
    			if (count($value1) - $i == 1) {
    				$select_value_fix .= $value1[$i];
    			} else {
    				$select_value_fix .= $value1[$i].' ';
    			}
    	endfor;	

    	if ($select2 != '' && $select_value2 != '') {
    		$this->db->where($select2,  $select_value2);
    	}

    	$this->db->where('status', 1);
    	$validation = $this->Result_model->get_by_name($table, $select, $select_value_fix);
    	if ($validation) {
    		echo 0;
    	} else {
    		echo 1;
    	}
    }

    // this function use for make number for document number of doc_category value
    function make_doc_no($doc_type_id, $department_id, $doc_category_id)
    {
    	$doc_no = $this->db->query("
    		SELECT MAX(doc_no) + 1 AS doc_no FROM doc_release_header 
    		WHERE doc_type_id = '$doc_type_id' 
    		AND department_id ='$department_id' 
    		AND doc_category_id ='$doc_category_id'
    		")->row()->doc_no;

    	if ($doc_no) {
    		if ($doc_no < 10) {
    			$no = '0';
    		} else {
    			$no = '';
    		}
    		echo $no.$doc_no;
    	} else {
    		echo '01';
    	}
	}
	
	function validation_change_password($type, $user_id, $value = '')
	{
		if ($type == 'password_old') {
			$password_enkripsi = $this->Result_model->get_name_by_id('user', $user_id, 'password');
			if ($password_enkripsi) {
				if (password_verify($value, $password_enkripsi)) {
					echo 1;
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}
		} elseif ($type == 'change_password') {
			$this->Result_model->update_by_id('user', $user_id, ['password' => password_hash($value, PASSWORD_DEFAULT)]);
			echo 1;
		}
	}

	function templating($page, $data)
	{
		$this->_sessionguard();
		$this->load->view('back/_partials/header', $data);
		$this->load->view('back/_partials/sidebar');
		$this->load->view('back/'.$page, $data);
		$this->load->view('back/_partials/footer', $data);
	}

	function logout()
	{
		$this->session->unset_userdata('user');
		echo 1;
	}

	function _sessionguard()
	{
		if (!$this->session->userdata('user')) {
			redirect('result');
		}
	}

	function notfound()
	{
		$data['title'] = 'NOT FOUND';
		$this->templating('not-found', $data);
	}
}

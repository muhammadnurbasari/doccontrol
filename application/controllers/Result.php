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
			$radios = $this->input->post('radios');
			$this->form_validation->set_rules('approve_note','Approve_note','required',['required' => 'Note tidak boleh kosong']);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			}
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

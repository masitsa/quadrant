<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Doctors extends admin {
	var $doctor_path;
	var $doctor_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('doctor_model');
		$this->load->model('department_model');
		$this->load->model('file_model');
		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->doctor_path = realpath(APPPATH . '../assets/doctor');
		$this->doctor_location = base_url().'assets/doctor/';
	}
    
	/*
	*
	*	Default action is to show all the registered doctor
	*
	*/
	public function index() 
	{
		$where = 'doctor.doctor_id > 0';
		$table = 'doctor';
		$segment = 3;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'administration/all-doctors';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->doctor_model->get_all_doctors($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$v_data['doctor_location'] = $this->doctor_location;
			$data['content'] = $this->load->view('doctor/all_doctors', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'administration/add-doctor" class="btn btn-success pull-right">Add Doctor</a>There are no doctors';
		}
		$data['title'] = 'All Doctors';
		
		$this->load->view('templates/general_admin', $data);
	}
	
	function add_doctor()
	{
		$v_data['doctor_location'] = 'http://placehold.it/500x500';
		
		$this->session->unset_userdata('doctor_error_message');
		
		//upload image if it has been selected
		$response = $this->doctor_model->upload_doctor_image($this->doctor_path);
		if($response)
		{
			$v_data['doctor_location'] = $this->doctor_location.$this->session->userdata('doctor_file_name');
		}
		
		//case of upload error
		else
		{
			$v_data['doctor_error'] = $this->session->userdata('doctor_error_message');
		}
		
		$doctor_error = $this->session->userdata('doctor_error_message');
		
		$this->form_validation->set_rules('doctor_fname', 'First name', 'required|xss_clean');
		$this->form_validation->set_rules('doctor_onames', 'Other names', 'required|xss_clean');
		$this->form_validation->set_rules('doctor_email', 'Email', 'valid_email|xss_clean');
		$this->form_validation->set_rules('doctor_phone', 'Phone', 'trim|xss_clean');
		$this->form_validation->set_rules('doctor_title', 'Designation', 'trim|xss_clean');
		$this->form_validation->set_rules('doctor_qualifications', 'Qualifications', 'xss_clean');
		$this->form_validation->set_rules('doctor_about', 'About', 'xss_clean');

		if ($this->form_validation->run())
		{	
			if(empty($doctor_error))
			{
				$data2 = array(
					'doctor_fname'=>$this->input->post("doctor_fname"),
					'doctor_onames'=>$this->input->post("doctor_onames"),
					'doctor_email'=>$this->input->post("doctor_email"),
					'doctor_phone'=>$this->input->post("doctor_phone"),
					'doctor_title'=>$this->input->post("doctor_title"),
					'doctor_qualifications'=>$this->input->post("doctor_qualifications"),
					'doctor_about'=>$this->input->post("doctor_about"),
					'doctor_status'=>1,
					'doctor_image_name'=>$this->session->userdata('doctor_file_name')
				);
				
				$table = "doctor";
				$this->db->insert($table, $data2);
				$this->session->unset_userdata('doctor_file_name');
				$this->session->unset_userdata('doctor_thumb_name');
				$this->session->unset_userdata('doctor_error_message');
				$this->session->set_userdata('success_message', 'Doctor has been added');
				
				redirect('administration/all-doctors');
			}
		}
		
		$doctor = $this->session->userdata('doctor_file_name');
		
		if(!empty($doctor))
		{
			$v_data['doctor_location'] = $this->doctor_location.$this->session->userdata('doctor_file_name');
		}
		$v_data['error'] = $doctor_error;
		$v_data['active_departments'] = $this->department_model->get_active_departments();
		
		$data['content'] = $this->load->view("doctor/add_doctor", $v_data, TRUE);
		$data['title'] = 'Add Doctor';
		
		$this->load->view('templates/general_admin', $data);
	}
	
	function edit_doctor($doctor_id, $page)
	{
		//get doctor data
		$table = "doctor";
		$where = "doctor_id = ".$doctor_id;
		
		$this->db->where($where);
		$doctors_query = $this->db->get($table);
		$doctor_row = $doctors_query->row();
		$v_data['doctor_row'] = $doctor_row;
		$v_data['doctor_location'] = $this->doctor_location.$doctor_row->doctor_image_name;
		
		$this->session->unset_userdata('doctor_error_message');
		
		//upload image if it has been selected
		$response = $this->doctor_model->upload_doctor_image($this->doctor_path, $edit = $doctor_row->doctor_image_name);
		if($response)
		{
			$v_data['doctor_location'] = $this->doctor_location.$this->session->userdata('doctor_file_name');
		}
		
		//case of upload error
		else
		{
			$v_data['doctor_error'] = $this->session->userdata('doctor_error_message');
		}
		
		$doctor_error = $this->session->userdata('doctor_error_message');
		
		$this->form_validation->set_rules('doctor_fname', 'First name', 'required|xss_clean');
		$this->form_validation->set_rules('doctor_onames', 'Other names', 'required|xss_clean');
		$this->form_validation->set_rules('doctor_email', 'Email', 'valid_email|xss_clean');
		$this->form_validation->set_rules('doctor_phone', 'Phone', 'trim|xss_clean');
		$this->form_validation->set_rules('doctor_title', 'Designation', 'trim|xss_clean');
		$this->form_validation->set_rules('doctor_qualifications', 'Qualifications', 'xss_clean');
		$this->form_validation->set_rules('doctor_about', 'About', 'xss_clean');

		if ($this->form_validation->run())
		{	
			if(empty($doctor_error))
			{
				$data2 = array(
					'doctor_fname'=>$this->input->post("doctor_fname"),
					'doctor_onames'=>$this->input->post("doctor_onames"),
					'doctor_email'=>$this->input->post("doctor_email"),
					'doctor_phone'=>$this->input->post("doctor_phone"),
					'doctor_title'=>$this->input->post("doctor_title"),
					'doctor_qualifications'=>$this->input->post("doctor_qualifications"),
					'doctor_about'=>$this->input->post("doctor_about"),
					'doctor_status'=>1,
					'doctor_image_name'=>$this->session->userdata('doctor_file_name')
				);
				$doctor = $this->session->userdata('doctor_file_name');
				
				if($doctor == FALSE)
				{
					$doctor = $doctor_row->doctor_image_name;
				}
				
				$table = "doctor";
				$this->db->where('doctor_id', $doctor_id);
				$this->db->update($table, $data2);
				$this->session->unset_userdata('doctor_file_name');
				$this->session->unset_userdata('doctor_thumb_name');
				$this->session->unset_userdata('doctor_error_message');
				$this->session->set_userdata('success_message', 'Doctor has been edited');
				
				redirect('administration/all-doctors/'.$page);
			}
		}
		
		$doctor = $this->session->userdata('doctor_file_name');
		
		if(!empty($doctor))
		{
			$v_data['doctor_location'] = $this->doctor_location.$this->session->userdata('doctor_file_name');
		}
		$v_data['error'] = $doctor_error;
		$v_data['active_departments'] = $this->department_model->get_active_departments();
		
		$data['content'] = $this->load->view("doctor/edit_doctor", $v_data, TRUE);
		$data['title'] = 'Edit Doctor';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing doctor
	*	@param int $doctor_id
	*
	*/
	function delete_doctor($doctor_id, $page)
	{
		//get doctor data
		$table = "doctor";
		$where = "doctor_id = ".$doctor_id;
		
		$this->db->where($where);
		$doctors_query = $this->db->get($table);
		$doctor_row = $doctors_query->row();
		$doctor_path = $this->doctor_path;
		
		$image_name = $doctor_row->doctor_image_name;
		
		//delete any other uploaded image
		$this->file_model->delete_file($doctor_path."\\".$image_name);
		
		//delete any other uploaded thumbnail
		$this->file_model->delete_file($doctor_path."\\thumbnail_".$image_name);
		
		if($this->doctor_model->delete_doctor($doctor_id))
		{
			$this->session->set_userdata('success_message', 'Doctor has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Doctor could not be deleted');
		}
		redirect('administration/all-doctors/'.$page);
	}
    
	/*
	*
	*	Activate an existing doctor
	*	@param int $doctor_id
	*
	*/
	public function activate_doctor($doctor_id, $page)
	{
		if($this->doctor_model->activate_doctor($doctor_id))
		{
			$this->session->set_userdata('success_message', 'Doctor has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Doctor could not be activated');
		}
		redirect('administration/all-doctors/'.$page);
	}
    
	/*
	*
	*	Deactivate an existing doctor
	*	@param int $doctor_id
	*
	*/
	public function deactivate_doctor($doctor_id, $page)
	{
		if($this->doctor_model->deactivate_doctor($doctor_id))
		{
			$this->session->set_userdata('success_message', 'Doctor has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Doctor could not be disabled');
		}
		redirect('administration/all-doctors/'.$page);
	}
    
	/*
	*
	*	Default action is to show all the registered doctor
	*
	*/
	public function assign_doctor() 
	{
		$where = 'doctor.doctor_id > 0';
		$table = 'doctor';
		
		$query = $this->doctor_model->get_doctors($table, $where);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['doctor_location'] = $this->doctor_location;
			$v_data['assigned_doctors'] = $this->doctor_model->get_assigned_doctors();
			$v_data['active_departments'] = $this->department_model->get_active_departments();
			$v_data['branches'] = $this->branches_model->all_child_branches();
			$data['content'] = $this->load->view('doctor/assign_doctor', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'administration/add-doctor" class="btn btn-success pull-right">Add Doctor</a>There are no doctors';
		}
		$data['title'] = 'All Doctors';
		
		$this->load->view('templates/general_admin', $data);
	}
	
	public function remove_assigned_doctor($branch_doctor_id)
	{
		$this->db->where('branch_doctor_id', $branch_doctor_id);
		if($this->db->delete('branch_doctor'))
		{
			echo 'true';
		}
		
		else
		{
			echo 'false';
		}
	}
	
	public function assign_doctor2($branch_id, $doctor_id)
	{
		//check if exists
		$data = array(
			'branch_id' => $branch_id,
			'doctor_id' => $doctor_id
		);
		
		$this->db->where($data);
		$query = $this->db->get('branch_doctor');
		
		//if exists
		if($query->num_rows() > 0)
		{
			$this->db->where($data);
			if($this->db->delete('branch_doctor'))
			{
				echo 'true';
			}
			
			else
			{
				echo 'false';
			}
		}
		
		//doesnt exist
		else
		{
			if($this->db->insert('branch_doctor', $data))
			{
				echo 'true';
			}
			
			else
			{
				echo 'false';
			}
		}
	}
}
?>
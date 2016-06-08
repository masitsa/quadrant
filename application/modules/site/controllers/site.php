<?php session_start();
/*
	This module loads the head, header, footer &/or Social media sections.
*/
class Site extends CI_Controller 
{	
	var $slideshow_location;
	var $service_location;
	var $gallery_location;
	
	function __construct() 
	{
		parent:: __construct();
		
		$this->load->model('site_model');
		$this->load->model('admin/review_model');
		$this->load->model('admin/blog_model');
		$this->load->model('admin/gallery_model');
		$this->load->model('admin/training_model');
		$this->load->model('admin/users_model');
		$this->load->model('site/departments_model');
		
		$this->slideshow_location = base_url().'assets/slideshow/';
		$this->service_location = base_url().'assets/service/';
		$this->gallery_location = base_url().'assets/gallery/';
  	}
	
	public function index()
	{
		redirect('home');
	}
	
	function home_page()
	{
		//Retrieve active slides
		$data['company_details'] = $this->site_model->get_contacts();
		$data['slides'] = $this->site_model->get_slides();
		$data['latest_posts'] = $this->blog_model->get_recent_posts(3);
		$data['departments'] = $this->site_model->get_departments();
		$data['trainings'] = $this->training_model->get_recent_trainings(3);
		$data['reviews'] = $this->review_model->get_recent_reviews(6);
		
		$data['slideshow_location'] = $this->slideshow_location;
		$data['service_location'] = $this->service_location;
		
		$v_data['title'] = 'Home';
		$v_data['content'] = $this->load->view("home", $data, TRUE);
		
		$this->load->view("includes/templates/general", $v_data);
	}
	
	public function about()
	{
		$data['title'] = 'About us';
		$v_data['title'] = 'About us';
		$data['company_details'] = $this->site_model->get_contacts();
		$data['reviews'] = $this->review_model->get_recent_reviews(3);
		$v_data['content'] = $this->load->view('about_us/about_us', $data, true);
		
		$this->load->view("includes/templates/general", $v_data);
	}
	
	public function services($department_web_name = NULL)
	{
  		$table = "service, department";
		$where = "service.service_status = 1 AND service.department_id = department.department_id";
		
		if($department_web_name != NULL)
		{
			$department_name = $this->site_model->decode_web_name($department_web_name);
			$where .= ' AND department.department_name = \''.$department_name.'\'';
			$data['services'] = $this->site_model->get_services($table, $where, NULL);
		}
		
		else
		{
			$data['services'] = $this->site_model->get_services($table, $where, 12);
		}
		$data['service_location'] = $this->service_location;
		
		$data['title'] = 'Services';
		$v_data['title'] = 'Services';
		$v_data['class'] = '';
		$v_data['content'] = $this->load->view("services", $data, TRUE);
		
		$this->load->view("includes/templates/general", $v_data);
	}
	
	public function view_service($web_name)
	{
		$service_name = $this->site_model->decode_web_name($web_name);
		
		if($service_name)
		{
			$query = $this->site_model->get_service($service_name);
	
			if ($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{
					$service_name = $row->service_name;
				}
				$data['title'] = $service_name;
				$v_data['title'] = $service_name;
				$v_data['row'] = $query->row();
				$data['content'] = $this->load->view('single_service', $v_data, true);
			}
			
			else
			{
				$data['title'] = 'Services';
				$v_data['title'] = 'Services';
				$data['content'] = 'Service not found';
			}
		}
		
		else
		{
			$data['title'] = 'Services';
			$v_data['title'] = 'Services';
			$data['content'] = 'Service not found';
		}
		
		$this->load->view("includes/templates/general", $data);
	}
	
	public function contact()
	{
		$data['contacts'] = $this->site_model->get_contacts();
		$data['title'] = 'Contact us';
		$v_data['title'] = 'Contact us';
		$v_data['class'] = '';
		$v_data['content'] = $this->load->view("contacts", $data, TRUE);
		
		$this->load->view("includes/templates/general", $v_data);
	}
    
	public function gallery() 
	{
		$where = 'gallery.department_id = department.department_id AND gallery_status = 1';
		$segment = 2;
		$base_url = site_url().'gallery';
		
		$table = 'department, gallery';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = $base_url;
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 24;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<div class="wp-pagenavi">';
		$config['full_tag_close'] = '</div>';
		
		$config['next_link'] = 'Next';
		
		$config['prev_link'] = 'Prev';
		
		$config['cur_tag_open'] = '<span class="current">';
		$config['cur_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->site_model->get_all_gallerys($table, $where);
		
		if ($query->num_rows() > 0)
		{
			$v_data['gallery'] = $query;
			$v_data['page'] = $page;
			$v_data['title'] = 'Gallery';
			$v_data['gallery_departments'] = $this->site_model->get_gallery_departments($table, $where, $config["per_page"], $page);
			$v_data['gallery_location'] = $this->gallery_location;
			$data['content'] = $this->load->view('gallery/gallery_list', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<p>There are no pictures posted yet</p>';
		}
		$data['title'] = 'Gallery';
		$this->load->view("includes/templates/general", $data);
	}
	
	public function departments() 
	{
		$where = 'department_status = 1';
		$segment = 2;
		$base_url = base_url().'departments';
		
		$table = 'department';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = $base_url;
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<div class="wp-pagenavi">';
		$config['full_tag_close'] = '</div>';
		
		$config['next_link'] = 'Next';
		
		$config['prev_link'] = 'Prev';
		
		$config['cur_tag_open'] = '<span class="current">';
		$config['cur_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->departments_model->get_all_departments($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$v_data['title'] = 'Departments';
			$data['content'] = $this->load->view('departments/department_list', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<p>There are no departments posted yet</p>';
		}
		$data['title'] = 'Departments';
		$this->load->view("includes/templates/general", $data);
	}
	
	public function trainings() 
	{
		$v_data['title'] = $data['title'] = 'Microsoft Excel';
		$v_data['trainings'] = $this->training_model->get_department_trainings(1);
		$data['content'] = $this->load->view('trainings', $v_data, true);
		$this->load->view("includes/templates/general", $data);
	}
	
	public function it_application() 
	{
		$v_data['title'] = $data['title'] = 'IT Business Application';
		$v_data['trainings'] = $this->training_model->get_department_trainings(4);
		$data['content'] = $this->load->view('it_training', $v_data, true);
		$this->load->view("includes/templates/general", $data);
	}
	
	function register($training_id)
	{
		$this->session->sess_destroy();
		$v_data['title'] = $data['title'] = 'Register';
		$v_data['training_id'] = $training_id;
		$v_data['training'] = $this->training_model->get_training($training_id);
		$data['content'] = $this->load->view('choose_method', $v_data, true);
		$this->load->view("includes/templates/general", $data);
	}
	
	function register_group($training_id)
	{
		$v_data['training_id'] = $training_id;
		$v_data['training'] = $this->training_model->get_training($training_id);
		$data['content'] = $this->load->view('register_group', $v_data, true);
		$this->load->view("includes/templates/general", $data);
	}
	
	function register_individual($training_id)
	{
		$v_data['training'] = $this->training_model->get_training($training_id);
		$v_data['training_id'] = $training_id;
		$this->form_validation->set_rules('trainee_fname', 'First name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('trainee_mname', 'Middle name', 'trim|xss_clean');
		$this->form_validation->set_rules('trainee_lname', 'Last name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('trainee_company', 'Company', 'trim|required|xss_clean');
		$this->form_validation->set_rules('trainee_role', 'Position', 'trim|required|xss_clean');
		$this->form_validation->set_rules('trainee_email', 'Emai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('trainee_phone', 'Phone', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{	
			if(empty($department_error))
			{
				$table = "trainee";
				
				//check if trainee has registered before
				$this->db->where('trainee_email', $this->input->post("trainee_email"));
				$query = $this->db->get($table);
				
				//has registered before
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					$trainee_id = $row->trainee_id;
				}
				
				//hasnt registered before
				else
				{
					$data2 = array(
						'trainee_fname'=>$this->input->post("trainee_fname"),
						'trainee_mname'=>$this->input->post("trainee_mname"),
						'trainee_lname'=>$this->input->post("trainee_lname"),
						'trainee_company'=>$this->input->post("trainee_company"),
						'trainee_role'=>$this->input->post("trainee_role"),
						'trainee_email'=>$this->input->post("trainee_email"),
						'trainee_phone'=>$this->input->post("trainee_phone"),
						'training_id'=>$training_id,
						'created' => date('Y-m-d H:i:s')
					);
				
					$this->db->insert($table, $data2);
					$trainee_id = $this->db->insert_id();
				}
				
				//add trainee to training
				if($trainee_id > 0)
				{
					$data3 = array(
						'trainee_id'=>$trainee_id,
						'training_id'=>$training_id,
						'created' => date('Y-m-d H:i:s')
					);
					
					$table = "attendee";
					if($this->db->insert($table, $data3))
					{
						$attendee_id = $this->db->insert_id();
						$this->session->set_userdata('success_message', 'You have successfully registered for this training');
						
						//var_dump($response);die();
						redirect('success/'.$attendee_id);
					}
					
					else
					{
						$this->session->set_userdata('error_message', 'Oops! Something went wrong and we were unable to sign you up to the training. Please try again.');
					}
				}
				
			
				else
				{
					$this->session->set_userdata('error_message', 'Oops! Something went wrong and we were unable to register you. Please try again.');
				}
			}
		}
		
		$data['content'] = $this->load->view("register", $v_data, TRUE);
		$data['title'] = 'Register';
		
		$this->load->view("includes/templates/general", $data);
	}
	
	function group_registration($training_id)
	{
		$v_data['content'] = 1;
		$v_data['training_id'] = $training_id;
		$v_data['training'] = $this->training_model->get_training($training_id);
		
		$this->form_validation->set_rules('trainee_fname', 'First name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('trainee_mname', 'Middle name', 'trim|xss_clean');
		$this->form_validation->set_rules('trainee_lname', 'Last name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('trainee_company', 'Company', 'trim|xss_clean');
		$this->form_validation->set_rules('trainee_role', 'Position', 'trim|xss_clean');
		$this->form_validation->set_rules('trainee_email', 'Emai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('trainee_phone', 'Phone', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			$table = "trainee";
			$this->session->set_userdata('company_name', $this->input->post("trainee_fname"));
			
			//check if trainee has registered before
			$this->db->where(array('trainee_email' => $this->input->post("trainee_email"), 'training_id' => $training_id));
			$query = $this->db->get($table);
			
			//has registered before
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$trainee_id = $row->trainee_id;
			}
			
			//hasnt registered before
			else
			{
				$data2 = array(
					'trainee_fname'=>$this->input->post("trainee_fname"),
					'trainee_mname'=>$this->input->post("trainee_mname"),
					'trainee_lname'=>$this->input->post("trainee_lname"),
					'trainee_company'=>$this->input->post("trainee_company"),
					'trainee_role'=>$this->input->post("trainee_role"),
					'trainee_email'=>$this->input->post("trainee_email"),
					'trainee_phone'=>$this->input->post("trainee_phone"),
					'training_id'=>$training_id,
					'created' => date('Y-m-d H:i:s')
				);
				$trainee_parent = $this->session->userdata('trainee_id');
				if(!empty($trainee_parent))
				{
					$data2['trainee_parent'] = $trainee_parent;
				}
			
				$this->db->insert($table, $data2);
				$trainee_id = $this->db->insert_id();
				if(empty($trainee_parent))
				{
					$this->session->set_userdata('trainee_id', $trainee_id);
				}
			}
			
			//add trainee to training
			if($trainee_id > 0)
			{
				$data3 = array(
					'trainee_id'=>$trainee_id,
					'training_id'=>$training_id,
					'created' => date('Y-m-d H:i:s')
				);
				
				$table = "attendee";
				if($this->db->insert($table, $data3))
				{
					$attendee_id = $this->db->insert_id();
					$this->session->set_userdata('success_message', 'You have successfully registered for this training');
					
					//var_dump($response);die();
					//redirect('success/'.$attendee_id);
				}
				
				else
				{
					$this->session->set_userdata('error_message', 'Oops! Something went wrong and we were unable to sign you up to the training. Please try again.');
				}
			}
			
		
			else
			{
				$this->session->set_userdata('error_message', 'Oops! Something went wrong and we were unable to register you. Please try again.');
			}

		}
		
		$trainee_parent = $this->session->userdata('trainee_id');
		$this->db->where('trainee_parent', $trainee_parent);
		$v_data['registered_trainees'] = $this->db->get('trainee');
		$v_data['trainee_parent'] = $trainee_parent;
		
		$data['content'] = $this->load->view("register_group", $v_data, TRUE);
		$data['title'] = 'Group Registration';
		
		$this->load->view("includes/templates/general", $data);
	}
	
	public function profoma($training_id)
	{
		$v_data['training_id'] = $training_id;
		$v_data['training'] = $this->training_model->get_training($training_id);
		$trainee_parent = $this->session->userdata('trainee_id');
		$this->db->where('trainee_parent', $trainee_parent);
		$v_data['registered_trainees'] = $this->db->get('trainee');
		$v_data['trainee_parent'] = $trainee_parent;
		$v_data['contacts'] = $this->site_model->get_contacts();
		
		$html = $this->load->view('print_proforma', $v_data, true);
		
		$this->db->where('trainee_id', $trainee_parent);
		$query = $this->db->get('trainee');
		$res = $query->row();

		$trainee_fname = $res->trainee_fname;
		$trainee_mname = $res->trainee_mname;
		$trainee_lname = $res->trainee_lname;
		$trainee_company = $res->trainee_company;
		$trainee_role = $res->trainee_role;
		$trainee_email = $res->trainee_email;
		$trainee_phone = $res->trainee_phone;
		
		$training_name = $start_date = $end_date = '';
		
		if($v_data['training']->num_rows() > 0)
		{
			$row = $v_data['training']->row();
			
			$training_name = $row->training_name;
			$start_date = $row->start_date;
			$end_date = $row->end_date;
			$date = date('jS F Y',strtotime($start_date));
		}
		
		//$data = array();
        //load the view and saved it into $html variable
        //$html=$this->load->view('welcome_message', $data, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = $trainee_fname." invoice for ".$training_name." on ".$date.".pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
	}
	
	public function success($attendee_id)
	{
		$this->session->set_userdata('payment_attendee_id', $attendee_id);
		$this->load->model('payments_model');
		$iframe = $this->payments_model->make_pesapal_payment();
		$v_data['iframe'] = $iframe;
		$data['content'] = $this->load->view('pesapal_payment', $v_data, true);
		$this->load->view("includes/templates/general", $data);
	}
	/*
	*
	*	Payment success Page
	*
	*/
	public function payment()
	{
		//mark booking as paid in the database
		$payment_data = $this->input->get();
		$v_data['pesapal_transaction_tracking_id'] = $payment_data['pesapal_transaction_tracking_id'];
		$booking_id = $payment_data['pesapal_merchant_reference'];
		
		/*if($this->site_model->update_booking($transaction_tracking_id, $booking_id))
		{
			redirect('flight/payment');
		}*/
		//var_dump($payment_data);
		
		$data['content'] = $this->load->view('pesapal_payment_confirmation', $v_data, true);
		$this->load->view("includes/templates/general", $data);
	}
	
	public function success_to_tna()
	{
		$attendee_id = $this->session->userdata('payment_attendee_id');
		$this->db->where('tna_page', 1);
		$v_data['tna_questions'] = $this->db->get('tna');
		
		if($v_data['tna_questions']->num_rows() > 0)
		{
			$submitted = 0;
			//check if form has been submitted
			foreach($v_data['tna_questions']->result() as $res)
			{
				$tna_id = $res->tna_id;
				$response = $this->input->post('option'.$tna_id);
				
				if(!empty($response))
				{
					$submitted = 1;
					//check if response exists
					$this->db->where(array('attendee_id' => $attendee_id, 'tna_id' => $tna_id));
					$tna_result = $this->db->get('tna_result');
					
					//result exists
					if($tna_result->num_rows() > 0)
					{
						$this->db->where(array('attendee_id' => $attendee_id, 'tna_id' => $tna_id));
						$this->db->update('tna_result', array('tna_result_status' => $response));
					}
					
					//result doesnt exist
					else
					{
						$this->db->insert('tna_result', array('tna_result_status' => $response, 'attendee_id' => $attendee_id, 'tna_id' => $tna_id));
					}
				}
			}
			
			if($submitted == 0)
			{
				//get results
				$this->db->where('attendee_id', $attendee_id);
				$v_data['tna_results'] = $this->db->get('tna_result');
				$v_data['title'] = $data['title'] = 'TNA - Introduction';
				$v_data['page'] = 1;
				$v_data['attendee_id'] = $attendee_id;
				$data['content'] = $this->load->view('success', $v_data, true);
			}
			
			else
			{
				$this->session->set_userdata('tna_form', 1);
				redirect('intermediate/'.$attendee_id);
			}
		}
		
		else
		{
			$data['content'] = 'Questions not set. Please check back later.';
		}
		$this->load->view("includes/templates/general", $data);
	}
	
	public function intermediate($attendee_id)
	{
		$this->db->where('tna_page', 2);
		$v_data['tna_questions'] = $this->db->get('tna');
		
		if($v_data['tna_questions']->num_rows() > 0)
		{
			$submitted = 0;
			//check if form has been submitted
			foreach($v_data['tna_questions']->result() as $res)
			{
				$tna_id = $res->tna_id;
				$response = $this->input->post('option'.$tna_id);
				
				if(!empty($response))
				{
					$submitted = 1;
					//check if response exists
					$this->db->where(array('attendee_id' => $attendee_id, 'tna_id' => $tna_id));
					$tna_result = $this->db->get('tna_result');
					
					//result exists
					if($tna_result->num_rows() > 0)
					{
						$this->db->where(array('attendee_id' => $attendee_id, 'tna_id' => $tna_id));
						$this->db->update('tna_result', array('tna_result_status' => $response));
					}
					
					//result doesnt exist
					else
					{
						$this->db->insert('tna_result', array('tna_result_status' => $response, 'attendee_id' => $attendee_id, 'tna_id' => $tna_id));
					}
				}
			}
			
			if($submitted == 0)
			{
				//get results
				$this->db->where('attendee_id', $attendee_id);
				$v_data['tna_results'] = $this->db->get('tna_result');
				$v_data['title'] = $data['title'] = 'TNA - Intermediate';
				$v_data['page'] = 2;
				$v_data['attendee_id'] = $attendee_id;
				$data['content'] = $this->load->view('success', $v_data, true);
			}
			
			else
			{
				$this->session->set_userdata('tna_form', 2);
				redirect('advanced/'.$attendee_id);
			}
		}
		
		else
		{
			$data['content'] = 'Questions not set. Please check back later.';
		}
		$this->load->view("includes/templates/general", $data);
	}
	
	public function advanced($attendee_id)
	{
		$this->db->where('tna_page', 3);
		$v_data['tna_questions'] = $this->db->get('tna');
		
		if($v_data['tna_questions']->num_rows() > 0)
		{
			$submitted = 0;
			//check if form has been submitted
			foreach($v_data['tna_questions']->result() as $res)
			{
				$tna_id = $res->tna_id;
				$response = $this->input->post('option'.$tna_id);
				
				if(!empty($response))
				{
					$submitted = 1;
					//check if response exists
					$this->db->where(array('attendee_id' => $attendee_id, 'tna_id' => $tna_id));
					$tna_result = $this->db->get('tna_result');
					
					//result exists
					if($tna_result->num_rows() > 0)
					{
						$this->db->where(array('attendee_id' => $attendee_id, 'tna_id' => $tna_id));
						$this->db->update('tna_result', array('tna_result_status' => $response));
					}
					
					//result doesnt exist
					else
					{
						$this->db->insert('tna_result', array('tna_result_status' => $response, 'attendee_id' => $attendee_id, 'tna_id' => $tna_id));
					}
				}
			}
			
			if($submitted == 0)
			{
				//get results
				$this->db->where('attendee_id', $attendee_id);
				$v_data['tna_results'] = $this->db->get('tna_result');
				$v_data['title'] = $data['title'] = 'TNA - Advanced';
				$v_data['page'] = 3;
				$v_data['attendee_id'] = $attendee_id;
				$data['content'] = $this->load->view('success', $v_data, true);
			}
			
			else
			{
				$this->session->set_userdata('tna_form', 3);
				//Send confirmation SMS
						$phone = $this->input->post("trainee_phone");
						$response = $this->site_model->sms( 'You have successfully registered for the training on 20th February 2016. Quadrant Africa Limited', '+254'.$phone);
				redirect('thank-you/'.$attendee_id);
			}
		}
		
		else
		{
			$data['content'] = 'Questions not set. Please check back later.';
		}
		$this->load->view("includes/templates/general", $data);
	}
	
	public function thank_you($attendee_id)
	{
		//get results
		$v_data['title'] = $data['title'] = 'TNA - Completed';
		$v_data['attendee_id'] = $attendee_id;
		$data['content'] = $this->load->view('thank_you', $v_data, true);
		$this->load->view("includes/templates/general", $data);
	}
	
	public function test()
	{
		echo '
		<table border="1">
			<tr>
				<th>#</th>
				<th>Trainee</th>
				<th>Number</th>
				<th>Status</th>
				<th>Cost</th>
			</tr>
		';
		//Send confirmation SMS
		$phone = '0710822159';
		$response = $this->site_model->sms( 'Spreadsheet Solutions tomorrow from 8.00am at Amber Hotel on Ngong Lane off Ngong Road 100m from Nakumatt Prestige coming from town. Quadrant Africa Ltd', '+254'.$phone);
		
		$number = '';
		$status = '';
		$cost = '';
		
		foreach($response as $result) {
			// status is either "Success" or "error message"
			$number = $result->number;
			$status = $result->status;
			$cost = $result->cost;
		}
		
		echo '
		<tr>
			<td>'.$count.'</td>
			<td>'.$trainee_fname.' '.$trainee_mname.' '.$trainee_lname.'</td>
			<td>'.$number.'</td>
			<td>'.$status.'</td>
			<td>'.$cost.'</td>
		</tr>
		';
	}
	
	public function feedback()
	{
		$this->form_validation->set_rules('trainee_email', 'Emai', 'trim|required|valid_email|exists[trainee.trainee_email]|xss_clean');

		if ($this->form_validation->run())
		{	
			$table = "trainee";
			
			//check if trainee has registered before
			$this->db->where('trainee_email', $this->input->post("trainee_email"));
			$query = $this->db->get($table);
			
			//has registered before
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$trainee_id = $row->trainee_id;
				$trainee_fname = $row->trainee_fname;
				
				//$this->session->userdata('trainee_id', $trainee_id);
				$this->session->set_userdata('trainee_fname', $trainee_fname);
				
				//get attendee_id
				$this->db->where('trainee_id', $trainee_id);
				$query2 = $this->db->get('attendee');
				
				if($query2->num_rows() > 0)
				{
					$row2 = $query2->row();
					$attendee_id = $row2->attendee_id;
					$this->session->set_userdata('attendee_id', $attendee_id);
					
					redirect('feedback-introduction');
				}
				
				else
				{
					$this->session->set_userdata('error_message', 'Oops we can\'t seem to find your attendance. Please contact a facilitator');
				}
			}
			
		
			else
			{
				$this->session->set_userdata('error_message', 'Oops we can\'t seem to find your name. Kindly ensure that you had registered');
			}
		}
		
		else
		{
			$this->session->set_userdata('error_message', validation_errors());
		}
		
		$data['content'] = $this->load->view("feedback", '', TRUE);
		$data['title'] = 'Feedback';
		
		$this->load->view("includes/templates/general", $data);
	}
	
	public function feedback_introduction()
	{
		$attendee_id = $this->session->userdata('attendee_id');
		$this->db->where('tna_page', 1);
		$v_data['tna_questions'] = $this->db->get('tna');
		
		if($v_data['tna_questions']->num_rows() > 0)
		{
			$submitted = 0;
			//check if form has been submitted
			foreach($v_data['tna_questions']->result() as $res)
			{
				$tna_id = $res->tna_id;
				$response = $this->input->post('option'.$tna_id);
				
				if(!empty($response))
				{
					$submitted = 1;
					//check if response exists
					$this->db->where(array('attendee_id' => $attendee_id, 'tna_id' => $tna_id));
					$tna_feedback = $this->db->get('tna_feedback');
					
					//result exists
					if($tna_feedback->num_rows() > 0)
					{
						$this->db->where(array('attendee_id' => $attendee_id, 'tna_id' => $tna_id));
						$this->db->update('tna_feedback', array('tna_feedback_status' => $response));
					}
					
					//result doesnt exist
					else
					{
						$this->db->insert('tna_feedback', array('tna_feedback_status' => $response, 'attendee_id' => $attendee_id, 'tna_id' => $tna_id));
					}
				}
			}
			
			if($submitted == 0)
			{
				//get results
				$this->db->where('attendee_id', $attendee_id);
				$v_data['tna_feedbacks'] = $this->db->get('tna_feedback');
				$v_data['title'] = $data['title'] = 'TNA Feedback - Introduction';
				$v_data['page'] = 1;
				$v_data['attendee_id'] = $attendee_id;
				$data['content'] = $this->load->view('feedback_questions', $v_data, true);
			}
			
			else
			{
				$this->session->set_userdata('tna_form', 1);
				redirect('feedback-intermediate');
			}
		}
		
		else
		{
			$data['content'] = 'Questions not set. Please check back later.';
		}
		$this->load->view("includes/templates/general", $data);
	}
	
	public function feedback_intermediate()
	{
		$attendee_id = $this->session->userdata('attendee_id');
		$this->db->where('tna_page', 2);
		$v_data['tna_questions'] = $this->db->get('tna');
		
		if($v_data['tna_questions']->num_rows() > 0)
		{
			$submitted = 0;
			//check if form has been submitted
			foreach($v_data['tna_questions']->result() as $res)
			{
				$tna_id = $res->tna_id;
				$response = $this->input->post('option'.$tna_id);
				
				if(!empty($response))
				{
					$submitted = 1;
					//check if response exists
					$this->db->where(array('attendee_id' => $attendee_id, 'tna_id' => $tna_id));
					$tna_feedback = $this->db->get('tna_feedback');
					
					//result exists
					if($tna_feedback->num_rows() > 0)
					{
						$this->db->where(array('attendee_id' => $attendee_id, 'tna_id' => $tna_id));
						$this->db->update('tna_feedback', array('tna_feedback_status' => $response));
					}
					
					//result doesnt exist
					else
					{
						$this->db->insert('tna_feedback', array('tna_feedback_status' => $response, 'attendee_id' => $attendee_id, 'tna_id' => $tna_id));
					}
				}
			}
			
			if($submitted == 0)
			{
				//get results
				$this->db->where('attendee_id', $attendee_id);
				$v_data['tna_feedbacks'] = $this->db->get('tna_feedback');
				$v_data['title'] = $data['title'] = 'TNA Feedback - Intermediate';
				$v_data['page'] = 2;
				$v_data['attendee_id'] = $attendee_id;
				$data['content'] = $this->load->view('feedback_questions', $v_data, true);
			}
			
			else
			{
				$this->session->set_userdata('tna_form', 1);
				redirect('feedback-conclusion');
			}
		}
		
		else
		{
			$data['content'] = 'Questions not set. Please check back later.';
		}
		$this->load->view("includes/templates/general", $data);
	}
	
	public function feedback_conclusion()
	{
		//get results
		$attendee_id = $this->session->userdata('attendee_id');
		$v_data['title'] = $data['title'] = 'TNA Feedback - Completed';
		$v_data['attendee_id'] = $attendee_id;
		$data['content'] = $this->load->view('feedback_conclusion', $v_data, true);
		$this->load->view("includes/templates/general", $data);
	}
    
	/*
	*
	*	Booking Page
	*
	*/
	public function book_training($flight_id)
	{
		$v_data['traveller_types'] = $this->flights_model->get_traveller_types();
		$v_data['flight'] = $this->flights_model->get_flight_details($flight_id);
		$v_data['airports_query'] = $this->airports_model->all_active_airports();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		$v_data['price_range'] = $this->site_model->generate_price_range();
		$v_data['flight_id'] = $flight_id;
		$v_data['airline_logo_location'] = $this->airlines_location;
		$v_data['payments_error'] = '';
		$flight_data = $v_data['flight']->row();
		$seats_sold = $this->site_model->calculate_seats_sold($flight_id);
		$available_seats = ($flight_data->flight_seats - $seats_sold);
		$v_data['available_seats'] = $available_seats;
		
		$v_data['iframe'] = '';
		
		//form validation rules
		$this->form_validation->set_rules('amount', 'Amount', 'required|xss_clean');
		$this->form_validation->set_rules('type', 'Type', 'required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
		$this->form_validation->set_rules('traveller_type_id', 'Traveller Type', 'required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|xss_clean');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|xss_clean');
		$this->form_validation->set_rules('seats', 'Seat', 'less_than_equal['.$available_seats.']|required|xss_clean');
		$this->form_validation->set_rules('additional_info', 'Additional Information', 'required|xss_clean');
		$this->form_validation->set_rules('terms_agree', 'Terms & Conditions', 'required');
		$this->form_validation->set_message('less_than_equal', 'Must contain not more than '.$available_seats.' seats');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$this->load->model('payments_model');
			if ($_POST['seats'] == 0)
			{
				$v_data['payments_error'] = "there are no seats available";
			}else
			{
				$iframe = $this->payments_model->make_pesapal_payment($flight_id);
				$v_data['iframe'] = $iframe;
			}
			
			
		}
		
		else
		{
			$v_data['payments_error'] = validation_errors();
		}
		
		$data['content'] = $this->load->view('products/payments', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
}
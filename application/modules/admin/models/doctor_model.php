<?php

class Doctor_model extends CI_Model 
{	
	public function upload_doctor_image($doctor_path, $edit = NULL)
	{
		//upload product's gallery images
		$resize['width'] = 500;
		$resize['height'] = 500;
		
		if(!empty($_FILES['doctor_image']['tmp_name']))
		{
			$image = $this->session->userdata('doctor_file_name');
			
			if((!empty($image)) || ($edit != NULL))
			{
				if($edit != NULL)
				{
					$image = $edit;
				}
				//delete any other uploaded image
				$this->file_model->delete_file($doctor_path."\\".$image, $doctor_path);
				
				//delete any other uploaded thumbnail
				$this->file_model->delete_file($doctor_path."\\thumbnail_".$image, $doctor_path);
			}
			//Upload image
			$response = $this->file_model->upload_file($doctor_path, 'doctor_image', $resize, 'height');
			if($response['check'])
			{
				$file_name = $response['file_name'];
				$thumb_name = $response['thumb_name'];
				
				//crop file to 1920 by 1010
				$response_crop = $this->file_model->crop_file($doctor_path."\\".$file_name, $resize['width'], $resize['height']);
				
				if(!$response_crop)
				{
					$this->session->set_userdata('doctor_error_message', $response_crop);
				
					return FALSE;
				}
				
				else
				{
					//Set sessions for the image details
					$this->session->set_userdata('doctor_file_name', $file_name);
					$this->session->set_userdata('doctor_thumb_name', $thumb_name);
				
					return TRUE;
				}
			}
		
			else
			{
				$this->session->set_userdata('doctor_error_message', $response['error']);
				
				return FALSE;
			}
		}
		
		else
		{
			$this->session->set_userdata('doctor_error_message', '');
			return FALSE;
		}
	}
	
	public function get_doctors($table, $where)
	{
		//retrieve all doctors
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('doctor.doctor_fname, doctor.doctor_onames');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_assigned_doctors()
	{
		//retrieve all doctors
		$this->db->from('branch_doctor');
		$this->db->select('*');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_all_doctors($table, $where, $per_page, $page)
	{
		//retrieve all doctors
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('doctor.doctor_fname, doctor.doctor_onames');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Delete an existing doctor
	*	@param int $doctor_id
	*
	*/
	public function delete_doctor($doctor_id)
	{
		if($this->db->delete('doctor', array('doctor_id' => $doctor_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated doctor
	*	@param int $doctor_id
	*
	*/
	public function activate_doctor($doctor_id)
	{
		$data = array(
				'doctor_status' => 1
			);
		$this->db->where('doctor_id', $doctor_id);
		
		if($this->db->update('doctor', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated doctor
	*	@param int $doctor_id
	*
	*/
	public function deactivate_doctor($doctor_id)
	{
		$data = array(
				'doctor_status' => 0
			);
		$this->db->where('doctor_id', $doctor_id);
		
		if($this->db->update('doctor', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function get_active_doctors()
	{
  		$table = "doctor";
		$where = "doctor_status = 1";
		
		$this->db->where($where);
		$query = $this->db->get($table);
		
		return $query;
	}
}

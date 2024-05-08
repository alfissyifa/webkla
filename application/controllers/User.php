<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class User extends CI_Controller {

	public function __construct(){

		parent::__construct();
		/*-- Check Session  --*/
		is_login();
		/*-- untuk mengatasi error confirm form resubmission  --*/
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		$this->load->model('admin_model');
		if ($this->session->userdata('level')!='User') {
			redirect('Admin');
		}
	}

	public function index(){

		$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
		  
		$data['ttlklaster'] = $this->admin_model->getCountKlaster_user();
		$data['ttlsubklaster'] = $this->admin_model->getCountSubklaster_user();
		$data['ttlsoal'] = $this->admin_model->getCountSoal_user();
		$data['parent'] = "Dashbord";
		$data['page'] = "Dashboard";
		$this->template->load('user/layout/user_template','user/user_dashboard',$data);

	}

	public function checklist_check() {
        // Tangkap data yang di-post dari form
        $selected_soals = $this->input->post('fruit'); 
        $id_soal = $this->input->post('id_soal');
        $id_user = $this->input->post('id_user');
        $pilihan = $this->input->post('pilihan');
        $catatan = $this->input->post('catatan');
        $lampiran = $this->input->post('lampiran');
        $id_subklaster = $this->input->post('id_subklaster');
        

        $this->db->delete('tb_userjawaban',['id_soal' => $id_soal,'id_user' => $id_user]);
        $this->db->delete('tb_userchecklist',['id_soal' => $id_soal,'id_user' => $id_user]);

        if ($pilihan=='Ya'){
        	$jawaban = $this->input->post('jawaban_b');
        	$this->admin_model->simpanJawaban($id_user,$id_soal, $pilihan, $jawaban, $catatan, $lampiran);
        	// Periksa apakah ada soal yang dipilih
	        if (!empty($selected_soals) && is_array($selected_soals)) {
	            // Loop melalui setiap id soal yang dipilih
	            foreach ($selected_soals as $soal_id) {
	                // Panggil model untuk menyimpan data soal
		            $this->admin_model->simpanCheklist($id_user,$id_soal, $soal_id); // id_user = 1
	            }
	        }
        } else {
        	$jawaban = $this->input->post('jawaban_c');
        	$this->admin_model->simpanJawaban($id_user,$id_soal, $pilihan, $jawaban, $catatan, $lampiran);
        }
        
        redirect('user/soal/'.$this->encrypt->encode($id_subklaster));
    }

	public function jawaban($id = null){
		$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
		$data['subklaster'] = $this->admin_model->getOneQKlasterJawaban($this->encrypt->decode($id));
		$data['nosoal'] = $this->admin_model->getusersoal($this->encrypt->decode($id)); 
		$data['jawaban'] = $this->admin_model->getjawaban($this->encrypt->decode($id),$this->session->userdata('id_user')); 
		$data['soal'] = $this->admin_model->getAllChecklist($this->encrypt->decode($id));
		$data['catatan'] = ''; 
		
		$data['parent'] = "Data Soal";
		$data['page'] = "Soal";
		$this->template->load('user/layout/user_template','user/modul_soal/jawabansoal',$data);
	}

	public function klaster(){
		$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
		$data['parent'] = "Data Klaster";
		$data['page'] = "Klaster";
		$this->template->load('user/layout/user_template','user/modul_klaster/klaster',$data);
	}

	public function subklaster($id = null){
		$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
		$data['klaster'] = $this->admin_model->getOneklaster($this->encrypt->decode($id));
		$data['parent'] = "Data Sub Klaster";
		$data['page'] = "Sub Klaster";
		$this->template->load('user/layout/user_template','user/modul_subklaster/subklaster',$data);
	}


	public function soal($id = null){
		$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
		$data['subklaster'] = $this->admin_model->getOneQKlaster($this->encrypt->decode($id));
		$data['parent'] = "Data Soal";
		$data['page'] = "Soal";
		$this->template->load('user/layout/user_template','user/modul_soal/soal',$data);
	}




	public function Profile(){

		$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();

		$data['parent'] = "Profile";
		$data['page'] = "Profile";
		$this->template->load('user/layout/user_template','user/user_profile',$data);
	}

	public function editProfile(){

		$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
		
		$this->form_validation->set_rules('fullname','Fullname','required');

		if($this->form_validation->run() == false){

			$data['parent'] = "Profile";
			$data['page'] = "Profile";
			$this->template->load('user/layout/user_template','user/user_profile',$data);

		}else{

			//check jika ada gmabar yang akan diupload, "f" itu nama inputnya
			// $upload_image = $_FILES['photo']['name'];
				$filename = trim($this->session->userdata('username'));

				$config['allowed_types'] = 'png';
				$config['max_size']     = '5120'; // dalam hitungan kilobyte(kb), aslinya 1mb itu 1024kb
				$config['upload_path'] = './assets/sips/img/admin/';
				$config['overwrite'] = "TRUE";
				$config['file_name'] = $filename;

				$this->load->library('upload', $config);
				$this->upload->overwrite = true;
				if(! $this->upload->do_upload('photo')){

					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
					redirect('user/profile');

				}else{

					$data = [

						'full_name' => $this->input->post('fullname'),
						'email' => $this->input->post('email'),
					];

					$this->db->where('id', $this->input->post('z'));
					$this->db->update('tb_users',$data);
					$this->toastr->success('Profile Telah Di Update!');
					redirect('user/profile');
				}

			}
		}


		public function changePassword(){

			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();

			$this->form_validation->set_rules('bb', 'New Password','required|trim|min_length[4]|matches[cc]');
			$this->form_validation->set_rules('cc', 'Confirm New Password','required|trim|min_length[4]|matches[bb]');

			if($this->form_validation->run() == false){

				$data['parent'] = "Profile";
				$data['page'] = "Profile";
				$this->template->load('user/layout/user_template','user/user_profile',$data);

			}else{


				$new_password = $this->input->post('bb');


				$password_hash = password_hash($new_password, PASSWORD_DEFAULT);

				$this->db->set('password', $password_hash);
				$this->db->where('id', $this->input->post('dd'));
				$this->db->update('tb_users');

				$this->toastr->success('password Berahasil Di Ubah!');
				redirect('user/profile');
			}

		}




}




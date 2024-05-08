<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Admin extends CI_Controller {

	public function __construct(){

		parent::__construct();
		/*-- Check Session  --*/
		is_login();
		/*-- untuk mengatasi error confirm form resubmission  --*/
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		$this->load->model('admin_model');
		if ($this->session->userdata('level')!='Admin') {
			redirect('User');
		}
	}

	public function index(){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['ttlklaster'] = $this->admin_model->getCountKlaster();
			$data['ttlsubklaster'] = $this->admin_model->getCountSubklaster();
			$data['ttlsoal'] = $this->admin_model->getCountSoal();
			$data['ttluser'] = $this->admin_model->getCountUser();
			$data['parent'] = "Dashbord";
			$data['page'] = "Dashboard";
			$this->template->load('admin/layout/admin_template','admin/admin_dashboard',$data);
		} else {
			redirect('User');
		}
	}

	public function klaster($id = null){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['parent'] = "Data Klaster";
			$data['page'] = "Klaster";
			$this->template->load('admin/layout/admin_template','admin/modul_klaster/klaster',$data);
		} else {
			redirect('User');
		}
	}

	public function jawaban_klaster($id){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
		$data['user'] = $this->admin_model->getOneUser($this->encrypt->decode($id));
		$data['parent'] = "Data Klaster";
		$data['page'] = "Klaster";
		$this->template->load('admin/layout/admin_template','admin/modul_klaster/klaster_jawaban',$data);
		} else {
			redirect('User');
		}
	}

	public function jawaban_subklaster($id,$id_user){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
		$data['klaster'] = $this->admin_model->getOneklaster($this->encrypt->decode($id));
		$data['user'] = $this->admin_model->getOneUser($this->encrypt->decode($id_user));
		$data['parent'] = "Data Sub Klaster";
		$data['page'] = "Sub Klaster";
		$this->template->load('admin/layout/admin_template','admin/modul_subklaster/subklaster_jawaban',$data);
		} else {
			redirect('User');
		}
	}

	public function soaluser_delete(){
		if ($this->session->userdata('level')=='Admin') {
			$id_jawaban = $this->input->post("id_jawaban");

			$id_jawaban = $this->input->post("id_jawaban");
			$data_jawaban = $this->admin_model->get_soal_user_id($id_jawaban);

			// Mendapatkan id_soal dan id_user dari data jawaban
			$id_soal = $data_jawaban['id_soal'];
			$id_user = $data_jawaban['id_user'];


			$this->db->delete('tb_userjawaban',['id' => $id_jawaban]);
			$this->db->delete('tb_userchecklist',['id_user' => $id_user,'id_soal' => $id_soal]);
			$sukses = "Deleted successfully.";
			echo json_encode($sukses);
		} else {
			redirect('User');
		}
	}

	public function checklist_check() {
        if ($this->session->userdata('level')=='Admin') {
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
	        
	        redirect('admin/jawaban_soal/'.$this->encrypt->encode($id_subklaster).'/'.$this->encrypt->encode($id_user));
		} else {
			redirect('User');
		}
        
    }

	public function jawaban($id,$id_user){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['userdata'] = $this->admin_model->getOneUser($this->encrypt->decode($id_user));
			$data['subklaster'] = $this->admin_model->getOneQKlasterJawaban($this->encrypt->decode($id));
			$data['nosoal'] = $this->admin_model->getusersoal($this->encrypt->decode($id)); 
			$data['jawaban'] = $this->admin_model->getjawaban($this->encrypt->decode($id),$this->encrypt->decode($id_user)); 
			$data['soal'] = $this->admin_model->getAllChecklist($this->encrypt->decode($id));
			$data['catatan'] = ''; 
			
			$data['parent'] = "Data Soal";
			$data['page'] = "Soal";
			$this->template->load('admin/layout/admin_template','admin/modul_soal/jawabansoal',$data);
		} else {
			redirect('User');
		}
	}

	public function jawaban_soal($id,$id_user){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['subklaster'] = $this->admin_model->getOneQKlaster($this->encrypt->decode($id));
			$data['user'] = $this->admin_model->getOneUser($this->encrypt->decode($id_user));
			$data['parent'] = "Data Soal";
			$data['page'] = "Soal";
			$this->template->load('admin/layout/admin_template','admin/modul_soal/soal_jawaban',$data);
		} else {
			redirect('User');
		}
	}

	public function pilih_user($id = null){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['user'] = $this->admin_model->getOneUser($this->encrypt->decode($id));
			$data['parent'] = "Data Setting Soal";
			$data['page'] = "Setting Soal";
			$this->template->load('admin/layout/admin_template','admin/modul_setting/klaster',$data);
		} else {
			redirect('User');
		}
	}

	public function pilih_klaster($id = null,$id_user = null){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['user'] = $this->admin_model->getOneUser($this->encrypt->decode($id_user));
			$data['klaster'] = $this->admin_model->getOneklaster($this->encrypt->decode($id));
			$data['parent'] = "Data Sub Klaster";
			$data['page'] = "Sub Klaster";
			$this->template->load('admin/layout/admin_template','admin/modul_setting/subklaster',$data);
		} else {
			redirect('User');
		}
	}

	public function pilih_soal($id = null,$id_user = null){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['subklaster'] = $this->admin_model->getOneQKlaster($this->encrypt->decode($id));
			$data['soal'] = $this->admin_model->getAllOptions($this->encrypt->decode($id)); 
			$data['user'] = $this->admin_model->getOneUser($this->encrypt->decode($id_user));
			
			$data['parent'] = "Data Soal";
			$data['page'] = "Soal";
			$this->template->load('admin/layout/admin_template','admin/modul_setting/soal',$data);
		} else {
			redirect('User');
		}	
	}

	public function soal_check() {
		if ($this->session->userdata('level')=='Admin') {
			$selected_soals = $this->input->post('fruit'); 
	        $id_subklaster = $this->input->post('id_subklaster');
	        $id_user = $this->input->post('id_user');
	        $this->db->delete('tb_usersoal',['id_subklaster' => $id_subklaster,'id_user' => $id_user]);
	        $id_klaster = $this->input->post('id_klaster');
	        // Periksa apakah ada soal yang dipilih
	        if (!empty($selected_soals) && is_array($selected_soals)) {
	            // Loop melalui setiap id soal yang dipilih
	            foreach ($selected_soals as $soal_id) {
	                // Panggil model untuk menyimpan data soal
		            $this->admin_model->simpanSoal($id_subklaster,$id_user, $soal_id); // id_user = 1
	            }
	        }
	        redirect('admin/pilih_klaster/'.$this->encrypt->encode($id_klaster).'/'.$this->encrypt->encode($id_user));
		} else {
			redirect('User');
		}
    }

	public function klaster_add(){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$this->form_validation->set_rules('no_urut','Nomor Urut','required');
			$this->form_validation->set_rules('nama_klaster','Nama Klaster','required');
			
			if($this->form_validation->run() == false){
				$data['parent'] = "Klaster";
				$data['page'] = "Klaster Add";
				$data['no_urut'] = $this->input->post('no_urut');
				$data['nama_klaster'] = $this->input->post('nama_klaster');
				$this->template->load('admin/layout/admin_template','admin/modul_klaster/add',$data);

			}else{
				$data = [
					'no_urut' => $this->input->post('no_urut'),
					'nama_klaster' => $this->input->post('nama_klaster'),
				];

				$this->db->insert('tb_klaster', $data);
				$this->toastr->success('Klaster  Telah Ditambahkan!');
				redirect('admin/klaster');
			}
		} else {
			redirect('User');
		}
	}

	public function klaster_edit($id = null){
		if ($this->session->userdata('level')=='Admin') {
			if (count($this->uri->segment_array()) > 3) {
				redirect('admin');
			}
			if (!isset($id)) {
				$this->toastr->error('Data yang Anda Inginkan Tidak Mempunyai ID');
				redirect('admin/klaster');
			}
			if (is_numeric($id)) {
				$this->toastr->error('Hanya Bisa Menggunakan Enkripsi');
				redirect('admin/klaster');
			} 

			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['klaster'] = $this->admin_model->getOneKlaster($this->encrypt->decode($id));
			
			$this->form_validation->set_rules('no_urut','Nomor Urut','required');
			$this->form_validation->set_rules('nama_klaster','Nama Klaster','required');

			if($this->form_validation->run() == false){
				$data['parent'] = "Klaster";
				$data['page'] = "Klaster Edit";
				$this->template->load('admin/layout/admin_template','admin/modul_klaster/edit',$data);

			}else{
				$data = [
					'no_urut' => $this->input->post('no_urut'),
					'nama_klaster' => $this->input->post('nama_klaster'),
				];

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tb_klaster',$data);
				$this->toastr->success('List Klaster Telah Di Update!');
				redirect('admin/klaster');

			}
		} else {
			redirect('User');
		}
	}

	public function klaster_delete(){
		if ($this->session->userdata('level')=='Admin') {
			$id = $this->input->post("id");
			$this->db->delete('tb_klaster',['id' => $id]);
			$sukses = "Deleted successfully.";
			echo json_encode($sukses);
		} else {
			redirect('User');
		}
	}

	public function jawaban_delete(){
		if ($this->session->userdata('level')=='Admin') {
			$id_user = $this->input->post("id");
			$this->db->delete('tb_userjawaban',['id_user' => $id_user]);
			$this->db->delete('tb_userchecklist',['id_user' => $id_user]);
			$sukses = "Deleted successfully.";
			echo json_encode($sukses);
		} else {
			redirect('User');
		}
		
	}

	public function user(){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['parent'] = "Data User";
			$data['page'] = "User";
			$this->template->load('admin/layout/admin_template','admin/modul_user/user',$data);
		} else {
			redirect('User');
		}
	}

	public function user_add(){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('email','Email','required');
			$this->form_validation->set_rules('full_name','Nama Lengkap','required');
			$this->form_validation->set_rules('jns_kelamin','Jenis Kelamin','required');
			$this->form_validation->set_rules('tgl_lahir','Tanggal Lahir','required');
			$this->form_validation->set_rules('phone','Phone','required');
			$this->form_validation->set_rules('instansi','Instansi','required');
			
			if($this->form_validation->run() == false){
				$data['parent'] = "User";
				$data['page'] = "User Add";
				$data['username'] = $this->input->post('username');
				$data['email'] = $this->input->post('email');
				$data['full_name'] = $this->input->post('full_name');
				$data['jns_kelamin'] = $this->input->post('jns_kelamin');
				$data['tgl_lahir'] = $this->input->post('tgl_lahir');
				$data['phone'] = $this->input->post('phone');
				$data['instansi'] = $this->input->post('instansi');
				$this->template->load('admin/layout/admin_template','admin/modul_user/add',$data);

			}else{
				$username = $this->input->post('username');
				$existing_user = $this->db->get_where('tb_users', ['username' => $username])->row();

				if ($existing_user) {
				    $data['parent'] = "User";
					$data['page'] = "User Add";
					$data['username'] = $this->input->post('username');
					$data['email'] = $this->input->post('email');
					$data['full_name'] = $this->input->post('full_name');
					$data['jns_kelamin'] = $this->input->post('jns_kelamin');
					$data['tgl_lahir'] = $this->input->post('tgl_lahir');
					$data['phone'] = $this->input->post('phone');
					$data['instansi'] = $this->input->post('instansi');
					$this->session->set_flashdata('error', 'Username sudah terdaftar!');
					$this->template->load('admin/layout/admin_template','admin/modul_user/add',$data);
					$this->session->set_flashdata('error', '');
				} else {
					$data = [
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'full_name' => $this->input->post('full_name'),
					'jns_kelamin' => $this->input->post('jns_kelamin'),
					'tgl_lahir' => $this->input->post('tgl_lahir'),
					'phone' => $this->input->post('phone'),
					'instansi' => $this->input->post('instansi'),
					'level' => 'User',
					'status' => '1',
					'password' => password_hash('User123', PASSWORD_DEFAULT),
				];

					$this->db->insert('tb_users', $data);
					$this->toastr->success('User  Telah Ditambahkan!');
					redirect('admin/user');
				}
			}
		} else {
			redirect('User');
		}
	}

	public function user_edit($id = null){
		if ($this->session->userdata('level')=='Admin') {
			if (count($this->uri->segment_array()) > 3) {
				redirect('admin');
			}
			if (!isset($id)) {
				$this->toastr->error('Data yang Anda Inginkan Tidak Mempunyai ID');
				redirect('admin/user');
			}
			if (is_numeric($id)) {
				$this->toastr->error('Hanya Bisa Menggunakan Enkripsi');
				redirect('admin/user');
			} 

			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['user'] = $this->admin_model->getOneUser($this->encrypt->decode($id));
			
			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('email','Email','required');
			$this->form_validation->set_rules('full_name','Nama Lengkap','required');
			$this->form_validation->set_rules('jns_kelamin','Jenis Kelamin','required');
			$this->form_validation->set_rules('tgl_lahir','Tanggal Lahir','required');
			$this->form_validation->set_rules('phone','Phone','required');
			$this->form_validation->set_rules('instansi','Instansi','required');

			if($this->form_validation->run() == false){
				$data['parent'] = "User";
				$data['page'] = "User Edit";
				$this->template->load('admin/layout/admin_template','admin/modul_user/edit',$data);

			}else{

				$data = [
				    'username' => $this->input->post('username'),
				    'email' => $this->input->post('email'),
				    'full_name' => $this->input->post('full_name'),
				    'jns_kelamin' => $this->input->post('jns_kelamin'),
				    'tgl_lahir' => $this->input->post('tgl_lahir'),
				    'phone' => $this->input->post('phone'),
				    'instansi' => $this->input->post('instansi'),
				    'level' => 'User',
				    'status' => '1'
				];

				$password = $this->input->post('password');
				if (!empty($password)) {
				    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
				}

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tb_users',$data);
				$this->toastr->success('List User Telah Di Update!');
				$id_subklaster=$this->input->post('id_subklaster');
				redirect('admin/user/'.$this->encrypt->encode($id_subklaster));

			}
		} else {
			redirect('User');
		}
	}

	public function user_delete(){
		if ($this->session->userdata('level')=='Admin') {
			$id = $this->input->post("id");
			$this->db->delete('tb_users',['id' => $id]);
			$sukses = "Deleted successfully.";
			echo json_encode($sukses);
		} else {
			redirect('User');
		}
	}


	public function subklaster($id = null){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['klaster'] = $this->admin_model->getOneklaster($this->encrypt->decode($id));
			$data['parent'] = "Data Sub Klaster";
			$data['page'] = "Sub Klaster";
			$this->template->load('admin/layout/admin_template','admin/modul_subklaster/subklaster',$data);
		} else {
			redirect('User');
		}
	}

	public function subklaster_add($id = null){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['id_klaster'] = $this->encrypt->decode($id);
			$data['klaster'] = $this->admin_model->getOneklaster($this->encrypt->decode($id));

			$this->form_validation->set_rules('no_urut','Nomor Urut','required');
			$this->form_validation->set_rules('nama_subklaster','Nama Subklaster','required');
			$this->form_validation->set_rules('ukuran','Ukuran','required');
			$this->form_validation->set_rules('keterangan','Keterangan','required');
			$this->form_validation->set_rules('nilai_maksimal','Nilai Maksimal','required');
			
			if($this->form_validation->run() == false){
				$data['parent'] = "Sub Klaster";
				$data['page'] = "Sub Klaster Add";
				$data['no_urut'] = $this->input->post('no_urut');
				$data['nama_subklaster'] = $this->input->post('nama_subklaster');
				$data['ukuran'] = $this->input->post('ukuran');
				$data['keterangan'] = $this->input->post('keterangan');
				$data['nilai_maksimal'] = $this->input->post('nilai_maksimal');
				$this->template->load('admin/layout/admin_template','admin/modul_subklaster/add',$data);

			}else{
				$data = [
					'id_klaster' => $this->input->post('id_klaster'),
					'no_urut' => $this->input->post('no_urut'),
					'nama_subklaster' => $this->input->post('nama_subklaster'),
					'ukuran' => $this->input->post('ukuran'),
					'keterangan' => $this->input->post('keterangan'),
					'nilai_maksimal' => $this->input->post('nilai_maksimal'),
				];

				$this->db->insert('tb_subklaster', $data);
				$this->toastr->success('Subklaster  Telah Ditambahkan!');
				redirect('admin/subklaster/'.$id);
			}
		} else {
			redirect('User');
		}
		
	}

	public function subklaster_edit($id = null){
		if ($this->session->userdata('level')=='Admin') {
			if (count($this->uri->segment_array()) > 3) {
				redirect('admin');
			}
			if (!isset($id)) {
				$this->toastr->error('Data yang Anda Inginkan Tidak Mempunyai ID');
				redirect('admin/subklaster');
			}
			if (is_numeric($id)) {
				$this->toastr->error('Hanya Bisa Menggunakan Enkripsi');
				redirect('admin/subklaster');
			} 

			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['klasterAll'] = $this->admin_model->getKlaster();
			$data['subklaster'] = $this->admin_model->getOneSubklaster($this->encrypt->decode($id));
			$data['klaster'] = $this->admin_model->getOneQKlaster($this->encrypt->decode($id));

			
			$this->form_validation->set_rules('no_urut','Nomor Urut','required');
			$this->form_validation->set_rules('id_klaster','Nama Klaster','required');
			$this->form_validation->set_rules('nama_subklaster','Nama Subklaster','required');
			$this->form_validation->set_rules('ukuran','Ukuran','required');
			$this->form_validation->set_rules('keterangan','Keterangan','required');
			$this->form_validation->set_rules('nilai_maksimal','Nilai Maksimal','required');

			if($this->form_validation->run() == false){
				$data['parent'] = "Sub Klaster";
				$data['page'] = "Sub Klaster Edit";
				$this->template->load('admin/layout/admin_template','admin/modul_subklaster/edit',$data);

			}else{

				$data = [
					'id_klaster' => $this->input->post('id_klaster'),
					'no_urut' => $this->input->post('no_urut'),
					'nama_subklaster' => $this->input->post('nama_subklaster'),
					'ukuran' => $this->input->post('ukuran'),
					'keterangan' => $this->input->post('keterangan'),
					'nilai_maksimal' => $this->input->post('nilai_maksimal'),
				];

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tb_subklaster',$data);
				$this->toastr->success('List Subklaster Telah Di Update!');
				$id_klaster=$this->input->post('id_klaster');
				redirect('admin/subklaster/'.$this->encrypt->encode($id_klaster));

			}
		} else {
			redirect('User');
		}
		
	}

	public function subklaster_delete(){
		if ($this->session->userdata('level')=='Admin') {
			$id = $this->input->post("id");

			$this->db->delete('tb_subklaster',['id' => $id]);

			$sukses = "Deleted successfully.";
			echo json_encode($sukses);
		} else {
			redirect('User');
		}
	}


	public function soal($id = null){
		if ($this->session->userdata('level')=='Admin') {
			if ($this->session->userdata('level')=='Admin') {
				$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
				$data['subklaster'] = $this->admin_model->getOneQKlaster($this->encrypt->decode($id));
				$data['parent'] = "Data Soal";
				$data['page'] = "Soal";
				$this->template->load('admin/layout/admin_template','admin/modul_soal/soal',$data);
			} else {
				redirect('User');
			}
		} else {
			redirect('User');
		}
		
	}

	public function soal_add($id = null){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['id_subklaster'] = $this->encrypt->decode($id);
			$data['subklaster'] = $this->admin_model->getOneQKlaster($this->encrypt->decode($id));

			$this->form_validation->set_rules('no_urut','Nomor Urut','required');
			$this->form_validation->set_rules('nama_soal','Nama Soal','required');
			$this->form_validation->set_rules('jika_ya','Pilihan Jika Ya','required');
			
			if($this->form_validation->run() == false){
				$data['parent'] = "Soal";
				$data['page'] = "Soal Add";
				$data['no_urut'] = $this->input->post('no_urut');
				$data['nama_soal'] = $this->input->post('nama_soal');
				$data['jika_ya'] = $this->input->post('jika_ya');
				$data['lampiran'] = $this->input->post('lampiran');
				$this->template->load('admin/layout/admin_template','admin/modul_soal/add',$data);

			}else{
				$data = [
					'id_subklaster' => $this->input->post('id_subklaster'),
					'no_urut' => $this->input->post('no_urut'),
					'nama_soal' => $this->input->post('nama_soal'),
					'jika_ya' => $this->input->post('jika_ya'),
					'lampiran' => $this->input->post('lampiran'),
				];

				$this->db->insert('tb_soal', $data);
				$this->toastr->success('Soal  Telah Ditambahkan!');
				redirect('admin/soal/'.$id);
			}
		} else {
			redirect('User');
		}
	}


	public function soal_edit($id = null){
		if ($this->session->userdata('level')=='Admin') {
			if (count($this->uri->segment_array()) > 3) {
				redirect('admin');
			}
			if (!isset($id)) {
				$this->toastr->error('Data yang Anda Inginkan Tidak Mempunyai ID');
				redirect('admin/soal');
			}
			if (is_numeric($id)) {
				$this->toastr->error('Hanya Bisa Menggunakan Enkripsi');
				redirect('admin/soal');
			} 

			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['soal'] = $this->admin_model->getOneSoal($this->encrypt->decode($id));

			
			$this->form_validation->set_rules('no_urut','Nomor Urut','required');
			$this->form_validation->set_rules('nama_soal','Nama Soal','required');
			$this->form_validation->set_rules('jika_ya','Pilihan Jika Ya','required');

			if($this->form_validation->run() == false){
				$data['parent'] = "Soal";
				$data['page'] = "Soal Edit";
				$this->template->load('admin/layout/admin_template','admin/modul_soal/edit',$data);

			}else{

				$data = [
					'id_subklaster' => $this->input->post('id_subklaster'),
					'no_urut' => $this->input->post('no_urut'),
					'nama_soal' => $this->input->post('nama_soal'),
					'jika_ya' => $this->input->post('jika_ya'),
					'lampiran' => $this->input->post('lampiran'),
				];

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tb_soal',$data);
				$this->toastr->success('List Soal Telah Di Update!');
				$id_subklaster=$this->input->post('id_subklaster');
				redirect('admin/soal/'.$this->encrypt->encode($id_subklaster));

			}
		} else {
			redirect('User');
		}
	}

	public function soal_delete(){
		if ($this->session->userdata('level')=='Admin') {
			$id = $this->input->post("id");
			$this->db->delete('tb_soal',['id' => $id]);
			$sukses = "Deleted successfully.";
			echo json_encode($sukses);
		} else {
			redirect('User');
		}
	}


	public function checklist($id = null){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['soal'] = $this->admin_model->getOneSoal($this->encrypt->decode($id));
			$data['parent'] = "Data Checklist Soal";
			$data['page'] = "Checklist Soal";
			$this->template->load('admin/layout/admin_template','admin/modul_checklist/checklist',$data);
		} else {
			redirect('User');
		}
		
	}

	public function checklist_add($id = null){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['id_soal'] = $this->encrypt->decode($id);
			$data['soal'] = $this->admin_model->getOneSoal($this->encrypt->decode($id));

			$this->form_validation->set_rules('nama_checklist','Checklist Soal','required');
			
			if($this->form_validation->run() == false){
				$data['parent'] = "Checklist Soal";
				$data['page'] = "Checklist Soal Add";
				$data['checklist_soal'] = $this->input->post('nama_checklist');
				$this->template->load('admin/layout/admin_template','admin/modul_checklist/add',$data);

			}else{
				$data = [
					'id_soal' => $this->input->post('id_soal'),
					'nama_checklist' => $this->input->post('nama_checklist'),
				];

				$this->db->insert('tb_checklist', $data);
				$this->toastr->success('Checklist Soal  Telah Ditambahkan!');
				redirect('admin/checklist/'.$id);
			}
		} else {
			redirect('User');
		}
	}

	public function checklist_edit($id = null){
		if ($this->session->userdata('level')=='Admin') {
			if (count($this->uri->segment_array()) > 3) {
				redirect('admin');
			}
			if (!isset($id)) {
				$this->toastr->error('Data yang Anda Inginkan Tidak Mempunyai ID');
				redirect('admin/checklist');
			}
			if (is_numeric($id)) {
				$this->toastr->error('Hanya Bisa Menggunakan Enkripsi');
				redirect('admin/checklist');
			} 

			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['checklist'] = $this->admin_model->getOneChecklist($this->encrypt->decode($id));

			
			$this->form_validation->set_rules('nama_checklist','Checklist Soal','required');

			if($this->form_validation->run() == false){
				$data['parent'] = "Checklist";
				$data['page'] = "Checklist Edit";
				$this->template->load('admin/layout/admin_template','admin/modul_checklist/edit',$data);

			}else{

				$data = [
					'id_soal' => $this->input->post('id_soal'),
					'nama_checklist' => $this->input->post('nama_checklist'),
				];

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tb_checklist',$data);
				$this->toastr->success('List Checklist Telah Di Update!');
				$id_soal=$this->input->post('id_soal');
				redirect('admin/checklist/'.$this->encrypt->encode($id_soal));
			}
		} else {
			redirect('User');
		}
	}

	public function checklist_delete(){
		if ($this->session->userdata('level')=='Admin') {
			$id = $this->input->post("id");
			$this->db->delete('tb_checklist',['id' => $id]);
			$sukses = "Deleted successfully.";
			echo json_encode($sukses);
		} else {
			redirect('User');
		}
		
	}

	public function Profile(){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			$data['parent'] = "Profile";
			$data['page'] = "Profile";
			$this->template->load('admin/layout/admin_template','admin/admin_profile',$data);
		} else {
			redirect('User');
		}
		
	}

	public function editProfile(){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();
			
			$this->form_validation->set_rules('fullname','Fullname','required');

			if($this->form_validation->run() == false){

				$data['parent'] = "Profile";
				$data['page'] = "Profile";
				$this->template->load('admin/layout/admin_template','admin/admin_profile',$data);

			}else{

				//check jika ada gmabar yang akan diupload, "f" itu nama inputnya
				// $upload_image = $_FILES['photo']['name'];
				$filename = $this->session->userdata('username');

					$config['allowed_types'] = 'png';
					$config['max_size']     = '5120'; // dalam hitungan kilobyte(kb), aslinya 1mb itu 1024kb
					$config['upload_path'] = './assets/sips/img/admin/';
					$config['overwrite'] = "TRUE";
					$config['file_name'] = $filename;

					$this->load->library('upload', $config);
					$this->upload->overwrite = true;
					if(! $this->upload->do_upload('photo')){

						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
						redirect('Admin/profile');

					}else{

						$data = [

							'full_name' => $this->input->post('fullname'),
							'email' => $this->input->post('email'),
						];

						$this->db->where('id', $this->input->post('z'));
						$this->db->update('tb_users',$data);
						$this->toastr->success('Profile Telah Di Update!');
						redirect('Admin/profile');
					}

				}
		} else {
			redirect('User');
		}	
	}


	public function changePassword(){
		if ($this->session->userdata('level')=='Admin') {
			$data['user'] = $this->db->get_where('tb_users',['username' => $this->session->userdata('username')])->row();

			$this->form_validation->set_rules('bb', 'New Password','required|trim|min_length[4]|matches[cc]');
			$this->form_validation->set_rules('cc', 'Confirm New Password','required|trim|min_length[4]|matches[bb]');

			if($this->form_validation->run() == false){

				$data['parent'] = "Profile";
				$data['page'] = "Profile";
				$this->template->load('admin/layout/admin_template','admin/admin_profile',$data);

			}else{
				$new_password = $this->input->post('bb');
				$password_hash = password_hash($new_password, PASSWORD_DEFAULT);
				$this->db->set('password', $password_hash);
				$this->db->where('id', $this->input->post('dd'));
				$this->db->update('tb_users');

				$this->toastr->success('password Berahasil Di Ubah!');
				redirect('Admin/profile');
			}
		} else {
			redirect('User');
		}
	}




}




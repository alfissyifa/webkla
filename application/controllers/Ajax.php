<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Ajax extends CI_Controller {

	public function __construct(){

		parent::__construct();


		/*-- untuk mengatasi error confirm form resubmission  --*/
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		$this->load->model('ajax_model');
		$this->load->model('admin_model');
	}

	/*-- Server-side Data Klaster --*/
	public function klasterData(){
		$list = $this->ajax_model->get_klaster();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_klaster=$field->id;
			$row = array();
			$row[] = $field->no_urut. '. '. $field->nama_klaster;
			if ($field->id_klaster == '') {
				$row[] = '<div style="text-align: center;">' . '
				<a class="btn btn-sm btn-warning" style="margin-right:5px; height:32px; width:32px;" href="../admin/klaster_edit/'.$this->encrypt->encode($field->id).'" title="Edit"><i class="fas fa-edit text-light"></i></a>
				<a class="btn btn-sm btn-danger" style="margin-right:5px; height:32px; width:32px;"  id="'.$field->id.'" onclick="deleteKlaster('.$field->id.')" title="Delete"><i class="fas fa-trash text-white"></i></a>
				<a class="btn btn-sm btn-info" href="../admin/subklaster/'.$this->encrypt->encode($field->id).'" title="Sub Klaster">SUB KLASTER</a>
				';
			} else {
				$row[] = '<div style="text-align: center;">' . '
				<a class="btn btn-sm btn-warning" style="margin-right:5px; height:32px; width:32px;" href="../admin/klaster_edit/'.$this->encrypt->encode($field->id).'" title="Edit"><i class="fas fa-edit text-light"></i></a>
				<a class="btn btn-sm btn-info" href="../admin/subklaster/'.$this->encrypt->encode($field->id).'" title="Sub Klaster">SUB KLASTER</a>
				';	
			}
			
				
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_klaster(),
			"recordsFiltered" => $this->ajax_model->count_filtered_klaster(),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}

	/*-- Server-side Data Klaster --*/
	public function klasterDataUser(){
		$list = $this->ajax_model->get_klasterUser();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_klaster=$field->id;
			$row = array();
			$sisipan_data = $this->admin_model->get_userjawab($field->id_user,$field->id_klaster); 
			if ($sisipan_data) {
				$row[] = $field->no_urut. '. '. $field->nama_klaster . '<i class="fas fa-check" style="margin-left:5px"></i>';
			} else {
				$row[] = $field->no_urut. '. '. $field->nama_klaster;
			}
			$row[] = '<div style="text-align: center;">' . '<a class="btn btn-sm btn-info" href="../user/subklaster/'.$this->encrypt->encode($field->id).'" title="Sub Klaster">SUB KLASTER</a>';
				
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_klasterUser(),
			"recordsFiltered" => $this->ajax_model->count_filtered_klasterUser(),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}

	public function klasterDataUser_jawaban($id){
		$list = $this->ajax_model->get_klasterUser_jawaban($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_klaster=$field->id;
			$row = array();
			$sisipan_data = $this->admin_model->get_userjawab($field->id_user,$field->id_klaster); 
			if ($sisipan_data) {
				$row[] = $field->no_urut. '. '. $field->nama_klaster . '<i class="fas fa-check" style="margin-left:5px"></i>';

				$row[] = '<div style="text-align: center;">' . '
				<a class="btn btn-sm btn-info" style="width:100%" href="../jawaban_subklaster/'.$this->encrypt->encode($field->id).'/'.$this->encrypt->encode($field->id_user).'" title="Sub Klaster">SUB KLASTER</a><br>
				
				';
				
			} else {
				$row[] = $field->no_urut. '. '. $field->nama_klaster;
				$row[] = '<div style="text-align: center;">' . '
				<a class="btn btn-sm btn-info" style="width:100%" href="../jawaban_subklaster/'.$this->encrypt->encode($field->id).'/'.$this->encrypt->encode($field->id_user).'" title="Sub Klaster">SUB KLASTER</a>
				';
			}
			
				
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_klasterUser_jawaban($id),
			"recordsFiltered" => $this->ajax_model->count_filtered_klasterUser_jawaban($id),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}

	public function SklasterData($id_user){
		$list = $this->ajax_model->get_klaster();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_klaster=$field->id;
			$row = array();
			$sisipan_data = $this->admin_model->get_userklaster($id_user,$field->id); // Ganti "your_model" dengan nama model Anda
					if ($sisipan_data) {
						$ket = '';
						$row[] = $field->no_urut. '. '. $field->nama_klaster . ' <i class="fas fa-check" style="margin-left:5px"></i>';
	
					} else {
						$row[] = $field->no_urut. '. '. $field->nama_klaster;
					}
			$row[] = '<div style="text-align: center;">' . '
							<a class="btn btn-sm btn-info" href="../pilih_klaster/'.$this->encrypt->encode($field->id).'/'.$this->encrypt->encode($id_user).'" title="Sub Klaster">SUB KLASTER</a>
										';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_klaster(),
			"recordsFiltered" => $this->ajax_model->count_filtered_klaster(),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}


	/*-- Server-side Data User --*/
	public function userData(){
		$list = $this->ajax_model->get_user();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_user=$field->id;
			$row = array();
			$sisipanb = $this->admin_model->get_userjawaban($id_user); 
			if ($sisipanb) {
				$row[] = $field->username. '<br>' . $field->email . '<br><i class="fas fa-check" style="margin-left:5px"></i>';
			} else {
				$row[] = $field->username. '<br>' . $field->email;
			}
			$row[] = $field->full_name. '<br>' . $field->jns_kelamin;
			$row[] = $field->instansi;
			$sisipan_data = $this->admin_model->get_jawaban($id_user); // Ganti "your_model" dengan nama model Anda
			if ($sisipan_data) {
				$row[] = '<div style="text-align: center;">' . '
				<a class="btn btn-sm btn-warning" style="margin-right:5px; height:32px; width:32px;" href="../admin/user_edit/'.$this->encrypt->encode($field->id).'" title="Edit"><i class="fas fa-edit text-light"></i></a>
				<a class="btn btn-sm btn-danger" style="margin-right:5px; height:32px; width:32px;"  id="'.$field->id.'" onclick="deleteUser('.$field->id.')" title="Delete"><i class="fas fa-trash text-white"></i></a><br>
				<a  style="margin-top:5px;width:100%" class="btn btn-sm btn-success" href="../admin/pilih_user/'.$this->encrypt->encode($field->id).'" title="Jawaban">SETTING SOAL</a><br>
				<a  style="margin-top:5px;width:100%" class="btn btn-sm btn-info" href="../admin/jawaban_klaster/'.$this->encrypt->encode($field->id).'" title="Jawaban">JAWABAN</a><br>
				<a style="margin-top:5px;width:100%;color:white" class="btn btn-sm btn-danger" onclick="deletejawaban('.$field->id.')" title="Delete">HAPUS JAWABAN</a>
				';	
			} else {
				$row[] = '<div style="text-align: center;">' . '
				<a class="btn btn-sm btn-warning" style="margin-right:5px; height:32px; width:32px;" href="../admin/user_edit/'.$this->encrypt->encode($field->id).'" title="Edit"><i class="fas fa-edit text-light"></i></a>
				<a class="btn btn-sm btn-danger" style="margin-right:5px; height:32px; width:32px;"  id="'.$field->id.'" onclick="deleteUser('.$field->id.')" title="Delete"><i class="fas fa-trash text-white"></i></a><br>
				<a  style="margin-top:5px;width:100%" class="btn btn-sm btn-success" href="../admin/pilih_user/'.$this->encrypt->encode($field->id).'" title="Jawaban">SETTING SOAL</a>
				';
			}
			
				
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_user(),
			"recordsFiltered" => $this->ajax_model->count_filtered_user(),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}


	public function subklasterData($id){
    	$list = $this->ajax_model->get_subklaster($id);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_subklaster=$field->id;
			$row = array();
			$row[] = $field->nu . '. '. $field->nama_subklaster;
			if ($field->id_subklaster == '') {
				$row[] = '<div style="text-align: center;">' . '
					<a class="btn btn-sm btn-warning" style="margin-right:5px; height:32px; width:32px;" href="../subklaster_edit/'.$this->encrypt->encode($field->id).'" title="Edit"><i class="fas fa-edit text-light"></i></a>
					<a class="btn btn-sm btn-danger" style="margin-right:5px; height:32px; width:32px;"  id="'.$field->id.'" onclick="deletesubklaster('.$field->id.')" title="Delete"><i class="fas fa-trash text-white"></i></a>
					<a class="btn btn-sm btn-info" href="../soal/'.$this->encrypt->encode($field->id).'" title="Soal">SOAL</a>
					';
			} else {
				$row[] = '<div style="text-align: center;">' . '
				<a class="btn btn-sm btn-warning" style="margin-right:5px; height:32px; width:32px;" href="../subklaster_edit/'.$this->encrypt->encode($field->id).'" title="Edit"><i class="fas fa-edit text-light"></i></a>
				<a class="btn btn-sm btn-info" href="../soal/'.$this->encrypt->encode($field->id).'" title="Soal">SOAL</a>
				';
			}
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_subklaster($id),
			"recordsFiltered" => $this->ajax_model->count_filtered_subklaster($id),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}

	public function subklasterDataUser($id){
    	$list = $this->ajax_model->get_subklasterUser($id);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_subklaster=$field->id;
			$row = array();
			$sisipan_data = $this->admin_model->get_userjawabb($field->id_user,$field->id_subklaster); 
			if ($sisipan_data) {
				$row[] = $field->nu . '. '. $field->nama_subklaster. '<i class="fas fa-check" style="margin-left:5px"></i>';
			} else {
				$row[] = $field->nu . '. '. $field->nama_subklaster;
			} 	

			if ($field->id_subklaster == '') {
				$row[] = '<div style="text-align: center;">' . '
					<a class="btn btn-sm btn-info" href="../soal/'.$this->encrypt->encode($field->id).'" title="Soal">SOAL</a>
					';
			} else {
				$row[] = '<div style="text-align: center;">' . '
				<a class="btn btn-sm btn-info" href="../soal/'.$this->encrypt->encode($field->id).'" title="Soal">SOAL</a>
				';
			}
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_subklasterUser($id),
			"recordsFiltered" => $this->ajax_model->count_filtered_subklasterUser($id),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}


	public function subklasterDataUser_jawaban($id,$id_user){
    	$list = $this->ajax_model->get_subklasterUser_jawaban($id,$id_user);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_subklaster=$field->id;
			$row = array();
			$sisipan_data = $this->admin_model->get_userjawabb($field->id_user,$field->id); 
			if ($sisipan_data) {
				$row[] = $field->nu . '. '. $field->nama_subklaster. '<i class="fas fa-check" style="margin-left:5px"></i>';
			} else {
				$row[] = $field->nu . '. '. $field->nama_subklaster;
			} 	
			if ($field->id_subklaster == '') {
				$row[] = '<div style="text-align: center;">' . '
				    <a class="btn btn-sm btn-info" href="' . base_url('admin/jawaban_soal/' . $this->encrypt->encode($field->id) . '/' . $this->encrypt->encode($field->id_user)) . '" title="Soal">SOAL</a>
				';

			} else {
				$row[] = '<div style="text-align: center;">' . '
				    <a class="btn btn-sm btn-info" href="' . base_url('admin/jawaban_soal/' . $this->encrypt->encode($field->id) . '/' . $this->encrypt->encode($field->id_user)) . '" title="Soal">SOAL</a>
				';

			}
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_subklasterUser_jawaban($id,$id_user),
			"recordsFiltered" => $this->ajax_model->count_filtered_subklasterUser_jawaban($id,$id_user),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}


	public function SsubklasterData($id,$id_user){
    	$list = $this->ajax_model->get_subklaster($id);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_subklaster=$field->id;
			$row = array();
			$sisipan_data = $this->admin_model->get_usersubklaster($id_user,$field->id); 
			if ($sisipan_data) {
				$row[] = $field->nu . '. '. $field->nama_subklaster . ' <i class="fas fa-check" style="margin-left:5px"></i>';
				
			} else {
				$row[] = $field->nu . '. '. $field->nama_subklaster;
			}

				$row[] = '<div style="text-align: center;">' . '
					
					<a class="btn btn-sm btn-info" href="' . base_url('admin/pilih_soal/' . $this->encrypt->encode($field->id)) .'/'.$this->encrypt->encode($id_user).'" title="Soal">SOAL</a>

					';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_subklaster($id),
			"recordsFiltered" => $this->ajax_model->count_filtered_subklaster($id),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}

	public function soalData($id){
    	$list = $this->ajax_model->get_soal($id);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_subklaster=$field->id;
			$row = array();

			if (($field->lampiran == '') || ($field->lampiran == '-')) {
				$row[] = $field->no_urut . '. ' . $field->nama_soal;
			} else {
				$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a>';
			}

			if ($field->id_soal == '') {
				$row[] = '<div style="text-align: center;">' . '
					<a class="btn btn-sm btn-warning" style="margin-right:5px; height:32px; width:32px;" href="../soal_edit/'.$this->encrypt->encode($field->id).'" title="Edit"><i class="fas fa-edit text-light"></i></a>
					<a class="btn btn-sm btn-danger" style="margin-right:5px;height:32px; width:32px;"  id="'.$field->id.'" onclick="deletesoal('.$field->id.')" title="Delete"><i class="fas fa-trash text-white"></i></a>
					<a class="btn btn-sm btn-info" href="../checklist/'.$this->encrypt->encode($field->id).'" title="Soal">CHECKLIST SOAL</a>
					';
			} else {
				$row[] = '<div style="text-align: center;">' . '
					<a class="btn btn-sm btn-warning" style="margin-right:5px; height:32px; width:32px;" href="../soal_edit/'.$this->encrypt->encode($field->id).'" title="Edit"><i class="fas fa-edit text-light"></i></a>
					<a class="btn btn-sm btn-info" href="../checklist/'.$this->encrypt->encode($field->id).'" title="Soal">CHECKLIST SOAL</a>
					';
			}
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_soal($id),
			"recordsFiltered" => $this->ajax_model->count_filtered_soal($id),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}

	public function soalDataUser($id){
    	$list = $this->ajax_model->get_soalUser($id);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_subklaster=$field->id;
			$row = array();

			if (($field->lampiran == '') || ($field->lampiran == '-') || ($field->lampiran == '#')) {
				if ($field->jawaban_a == '') {
					$row[] = $field->no_urut . '. ' . $field->nama_soal;
				} else {
					$sisipan_data = $this->admin_model->get_userchecklist($field->id_user,$field->id_soal); // Ganti "your_model" dengan nama model Anda
					if ($sisipan_data) {
						$jawaban_c = '';
						foreach ($sisipan_data as $datab) {
						    if (isset($datab['nama_checklist'])) {
					            $jawaban_c .= $datab['nama_checklist'] . '<br>';
					        }
						}
						if (($field->lampiranuser == '') || ($field->lampiranuser == '-') || ($field->lampiranuser == '#')) {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'<br>'.$jawaban_c.'</td></tr></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"></td></tr></table>';
						} else {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'<br>'.$jawaban_c.'</td></tr></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"><a class="btn btn-sm btn-success" href="' . $field->lampiranuser . '" target="_blank">Ada</a></td></tr></table>';
						}
					} else {
						if (($field->lampiranuser == '') || ($field->lampiranuser == '-') || ($field->lampiranuser == '#')) {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"></td></tr></table>';
						} else {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"><a class="btn btn-sm btn-success" href="' . $field->lampiranuser . '" target="_blank">Ada</a></td></tr></table>';
						}	
					}
				}
			} else {
				if ($field->jawaban_a == '') {
					$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a>';
				} else {
					$sisipan_data = $this->admin_model->get_userchecklist($field->id_user,$field->id_soal); // Ganti "your_model" dengan nama model Anda
					if ($sisipan_data) {
						$jawaban_c = '';
						foreach ($sisipan_data as $datab) {
						    if (isset($datab['nama_checklist'])) {
					            $jawaban_c .= $datab['nama_checklist'] . '<br>';
					        }
						}
						if (($field->lampiranuser == '') || ($field->lampiranuser == '-') || ($field->lampiranuser == '#')) {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a><br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'<br>'.$jawaban_c.'</td></tr></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"></td></tr></table>';
						} else {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a><br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'<br>'.$jawaban_c.'</td></tr></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"><a class="btn btn-sm btn-success" href="' . $field->lampiranuser . '" target="_blank">Ada</a></td></tr></table>';
						}
					} else {
						if (($field->lampiranuser == '') || ($field->lampiranuser == '-') || ($field->lampiranuser == '#')) {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a><br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"></td></tr></table>';
						} else {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a><br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"><a class="btn btn-sm btn-success" href="' . $field->lampiranuser . '" target="_blank">Ada</a></td></tr></table>';
						}

					}
				}
			}
				if ($field->jawaban_a == '') {
					$row[] = '<div style="text-align: center;">' . '
						<a class="btn btn-sm btn-info" style="color:white;width:100%" href="../jawaban/'.$this->encrypt->encode($field->id_soal).'" title="Jawaban">JAWABAN</a>
						';
				} else {	
					$row[] = '<div style="text-align: center;">' . '
						<a class="btn btn-sm btn-info" style="color:white;width:100%" href="../jawaban/'.$this->encrypt->encode($field->id_soal).'" title="Jawaban">JAWABAN</a><br>
						<a class="btn btn-sm btn-danger" style="margin-top:5px;color:white;width:100%"  id="'.$field->id.'" onclick="deletesoaluser('.$field->id_jawaban.'	)" title="Delete"><i class="fas fa-trash text-white"></i></a>
						';
				}
		
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_soalUser($id),
			"recordsFiltered" => $this->ajax_model->count_filtered_soalUser($id),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}

	public function soalDataUser_jawaban($id,$id_user){
    	$list = $this->ajax_model->get_soalUser_jawaban($id,$id_user);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_subklaster=$field->id;
			$row = array();

			if (($field->lampiran == '') || ($field->lampiran == '-') || ($field->lampiran == '#')) {
				if ($field->jawaban_a == '') {
					$row[] = $field->no_urut . '. ' . $field->nama_soal;
				} else {
					$sisipan_data = $this->admin_model->get_userchecklist($field->id_user,$field->id_soal); // Ganti "your_model" dengan nama model Anda
					if ($sisipan_data) {
						$jawaban_c = '';
						foreach ($sisipan_data as $datab) {
						    if (isset($datab['nama_checklist'])) {
					            $jawaban_c .= $datab['nama_checklist'] . '<br>';
					        }
						}
						if (($field->lampiranuser == '') || ($field->lampiranuser == '-') || ($field->lampiranuser == '#')) {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'<br>'.$jawaban_c.'</td></tr></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"></td></tr></table>';
						} else {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'<br>'.$jawaban_c.'</td></tr></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"><a class="btn btn-sm btn-success" href="' . $field->lampiranuser . '" target="_blank">Ada</a></td></tr></table>';
						}
					} else {
						if (($field->lampiranuser == '') || ($field->lampiranuser == '-') || ($field->lampiranuser == '#')) {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"></td></tr></table>';
						} else {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"><a class="btn btn-sm btn-success" href="' . $field->lampiranuser . '" target="_blank">Ada</a></td></tr></table>';
						}	
					}
				}
			} else {
				if ($field->jawaban_a == '') {
					$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a>';
				} else {
					$sisipan_data = $this->admin_model->get_userchecklist($field->id_user,$field->id_soal); // Ganti "your_model" dengan nama model Anda
					if ($sisipan_data) {
						$jawaban_c = '';
						foreach ($sisipan_data as $datab) {
						    if (isset($datab['nama_checklist'])) {
					            $jawaban_c .= $datab['nama_checklist'] . '<br>';
					        }
						}
						if (($field->lampiranuser == '') || ($field->lampiranuser == '-') || ($field->lampiranuser == '#')) {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a><br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'<br>'.$jawaban_c.'</td></tr></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"></td></tr></table>';
						} else {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a><br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'<br>'.$jawaban_c.'</td></tr></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"><a class="btn btn-sm btn-success" href="' . $field->lampiranuser . '" target="_blank">Ada</a></td></tr></table>';
						}
					} else {
						if (($field->lampiranuser == '') || ($field->lampiranuser == '-') || ($field->lampiranuser == '#')) {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a><br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"></td></tr></table>';
						} else {
							$row[] = $field->no_urut . '. ' . $field->nama_soal . '<br><a class="btn btn-sm btn-success" href="' . $field->lampiran . '" target="_blank">Lampiran</a><br><table><tr style="background:transparent"><td style="border-top:0px">Jawaban</td><td>'.$field->jawaban_a.'<br>'.$field->jawaban_b.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Catatan</td><td style="border-top:0px">'.$field->catatan.'</td></tr><tr style="background:transparent"><td style="border-top:0px">Lampiran</td><td style="border-top:0px"><a class="btn btn-sm btn-success" href="' . $field->lampiranuser . '" target="_blank">Ada</a></td></tr></table>';
						}

					}
				}
			}
				if ($field->jawaban_a == '') {
					$row[] = '<div style="text-align: center;">' . '
						<a class="btn btn-sm btn-info" style="color:white;width:100%" href="' . base_url('admin/jawaban/' . $this->encrypt->encode($field->id_soal) . '/' . $this->encrypt->encode($field->id_user)) . '" title="Jawaban">JAWABAN</a>
						';
				} else {	
					$row[] = '<div style="text-align: center;">' . '
						<a class="btn btn-sm btn-info" style="color:white;width:100%" href="' . base_url('admin/jawaban/' . $this->encrypt->encode($field->id_soal) . '/' . $this->encrypt->encode($field->id_user)) . '" title="Jawaban">JAWABAN</a><br>
						<a class="btn btn-sm btn-danger" style="margin-top:5px;color:white;width:100%" onclick="deletesoalUser_jawaban('.$field->id_jawaban.')" title="Delete">HAPUS JAWABAN</a>
						';
				}
		
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_soalUser_jawaban($id,$id_user),
			"recordsFiltered" => $this->ajax_model->count_filtered_soalUser_jawaban($id,$id_user),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}

	public function checklistData($id){
    	$list = $this->ajax_model->get_checklist($id);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$id_subklaster=$field->id;
			$row = array();
			$row[] = $field->nama_checklist;
			$row[] = '<div style="text-align: center;">' . '
				<a class="btn btn-sm btn-warning" style="margin-right:5px; height:32px; width:32px;" href="../checklist_edit/'.$this->encrypt->encode($field->id).'" title="Edit"><i class="fas fa-edit text-light"></i></a>
				<a class="btn btn-sm btn-danger" style="height:32px; width:32px;"  id="'.$field->id.'" onclick="deletechecklist('.$field->id.')" title="Delete"><i class="fas fa-trash text-white"></i></a>
				';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ajax_model->count_all_checklist($id),
			"recordsFiltered" => $this->ajax_model->count_filtered_checklist($id),
			"data" => $data,
		);

		/*-- Output Dalam Format JSON --*/
		echo json_encode($output);
	}


}
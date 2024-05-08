<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	var $column_orderklaster = array(null, 'a.no_urut', 'a.nama_klaster');
	var $column_searchklaster = array('a.nama_klaster');
	var $orderklaster = array('a.no_urut' => 'asc');

	private function _get_klaster_query(){
	    $this->db->select('a.id, a.no_urut, a.nama_klaster, b.id_klaster');
	    $this->db->from('tb_klaster a');
	    $this->db->join('(SELECT id_klaster FROM tb_subklaster GROUP BY id_klaster) b', 'b.id_klaster = a.id', 'left');
	    
	    $i = 0;
	    foreach ($this->column_searchklaster as $item){
	        if($_POST['search']['value']) {
	            if($i===0){
	                $this->db->group_start(); 
	                $this->db->like($item, $_POST['search']['value']);
	            }else{
	                $this->db->or_like($item, $_POST['search']['value']);
	            }
	            if(count($this->column_searchklaster) - 1 == $i) 
	                $this->db->group_end(); 
	        }
	        $i++;
	    }

	    if(isset($_POST['order'])){
	        $this->db->order_by($this->column_orderklaster[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	    }else if(isset($this->orderklaster)){
	        $orderklaster = $this->orderklaster;
	        $this->db->order_by(key($orderklaster), $orderklaster[key($orderklaster)]);
	    }
	}

	function get_klaster(){
	    $this->_get_klaster_query();
	    if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	    $query = $this->db->get();
	    return $query->result();
	}

	function count_filtered_klaster(){
	    $this->_get_klaster_query();
	    $query = $this->db->get();
	    return $query->num_rows();
	}

	function count_all_klaster(){
	    $this->db->from('tb_klaster a');
	    $this->db->join('(SELECT id_klaster FROM tb_subklaster GROUP BY id_klaster) b', 'b.id_klaster = a.id', 'left');
	    return $this->db->count_all_results();
	}


	/*--  Server Side Data klasterUser --------*/
	var $tableklasterUser = '(SELECT id,e.no_urut,e.nama_klaster,e.id_klaster,e.id_user FROM (SELECT c.*, d.id_user FROM ((select a.id, a.no_urut, a.nama_klaster, b.id_klaster,b.id AS id_subklaster FROM (tb_klaster a left join tb_subklaster b on b.id_klaster = a.id)) c left join tb_usersoal d ON d.id_subklaster=c.id_subklaster) group by c.id,c.no_urut,c.nama_klaster,c.id_klaster, c.id_subklaster, d.id_user) e group by e.id,e.no_urut,e.nama_klaster,e.id_klaster, e.id_user) q_klasterUser';
	var $column_orderklasterUser = array(null, 'no_urut', 'nama_klaster');
	var $column_searchklasterUser = array('nama_klaster');
	var $orderklasterUser = array('no_urut' => 'asc');


	private function _get_klasterUser_query($id){
		$this->db->from($this->tableklasterUser);
		$this->db->where('id_user', $id);
		$i = 0;
		foreach ($this->column_searchklasterUser as $item){
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_searchklasterUser) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		if(isset($_POST['order'])){

			$this->db->order_by($this->column_orderklasterUser[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

		}else if(isset($this->orderklasterUser)){

			$orderklasterUser = $this->orderklasterUser;
			$this->db->order_by(key($orderklasterUser), $orderklasterUser[key($orderklasterUser)]);
		}
	}

	function get_klasterUser(){
		$this->_get_klasterUser_query($this->session->userdata('id_user'));
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_klasterUser(){
		$this->_get_klasterUser_query($this->session->userdata('id_user'));
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_klasterUser(){
		$this->db->from($this->tableklasterUser);
		$this->db->where('id_user', $this->session->userdata('id_user'));
		return $this->db->count_all_results();
	}

	/*--  Server Side Data klasterUser_jawaban --------*/
	var $tableklasterUser_jawaban = '(SELECT c.id, c.no_urut, c.nama_klaster, c.id_klaster, d.id_user FROM ((select a.id, a.no_urut, a.nama_klaster, b.id_klaster, b.id AS id_subklaster FROM (tb_klaster a left join tb_subklaster b on b.id_klaster = a.id)) c left join tb_usersoal d ON d.id_subklaster=c.id_subklaster) group by c.id,c.no_urut,c.nama_klaster,c.id_klaster, d.id_user) q_klasterUser_jawaban';
	var $column_orderklasterUser_jawaban = array(null, 'no_urut', 'nama_klaster');
	var $column_searchklasterUser_jawaban = array('nama_klaster');
	var $orderklasterUser_jawaban = array('no_urut' => 'asc');


	private function _get_klasterUser_jawaban_query($id){
		$this->db->from($this->tableklasterUser_jawaban);
		$this->db->where('id_user', $id);
		$i = 0;
		foreach ($this->column_searchklasterUser_jawaban as $item){
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_searchklasterUser_jawaban) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		if(isset($_POST['order'])){

			$this->db->order_by($this->column_orderklasterUser_jawaban[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

		}else if(isset($this->orderklasterUser_jawaban)){

			$orderklasterUser_jawaban = $this->orderklasterUser_jawaban;
			$this->db->order_by(key($orderklasterUser_jawaban), $orderklasterUser_jawaban[key($orderklasterUser_jawaban)]);
		}
	}

	function get_klasterUser_jawaban($id){
		$this->_get_klasterUser_jawaban_query($id);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_klasterUser_jawaban($id){
		$this->_get_klasterUser_jawaban_query($id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_klasterUser_jawaban($id){
		$this->db->from($this->tableklasterUser_jawaban);
		$this->db->where('id_user', $id);
		return $this->db->count_all_results();
	}


	/*--  Server Side Data user --------*/
	var $tableuser = 'tb_users';
	var $column_orderuser = array(null, 'username','email','full_name','jns_kelamin','instansi');
	var $column_searchuser = array('username','email','full_name','jns_kelamin','instansi');
	var $orderuser = array('username' => 'asc');


	private function _get_user_query(){
		$this->db->from($this->tableuser);
		$this->db->where('level', 'User');
		$i = 0;
		foreach ($this->column_searchuser as $item){
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_searchuser) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		if(isset($_POST['order'])){

			$this->db->order_by($this->column_orderuser[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

		}else if(isset($this->orderuser)){

			$orderuser = $this->orderuser;
			$this->db->order_by(key($orderuser), $orderuser[key($orderuser)]);
		}
	}

	function get_user(){
		$this->_get_user_query();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_user(){
		$this->_get_user_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_user(){
		$this->db->from($this->tableuser);
		$this->db->where('level', 'User');
		return $this->db->count_all_results();
	}


	/*--  Server Side Data subklaster --------*/
	var $tablesubklaster = '(select a.id, a.no_urut, a.nama_subklaster,a.id_klaster, a.nama_klaster,a.nu, a.urut,b.id_subklaster FROM (select bb.id, bb.no_urut, bb.nama_subklaster,bb.id_klaster, bb.nama_klaster, bb.nu,"B" AS urut from (select b.id,a.no_urut,b.id_klaster,a.nama_klaster,b.no_urut AS nu,b.nama_subklaster from tb_klaster a left join tb_subklaster b on b.id_klaster = a.id) as bb where bb.nama_subklaster <> "" order by bb.no_urut,bb.nu) a left JOIN tb_soal b ON b.id_subklaster = a.id group by a.id,a.no_urut,a.nama_subklaster, a.id_klaster,a.nama_klaster,a.nu,a.urut,b.id_subklaster) q_subklaster';
	var $column_ordersubklaster = array(null, 'id','id_klaster','no_urut','nama_subklaster','nama_klaster');
	var $column_searchsubklaster = array('nama_subklaster','nama_klaster');
	var $ordersubklaster = array('nu' => 'asc');


	private function _get_subklaster_query($id){
		$this->db->from($this->tablesubklaster);
		$this->db->where('id_klaster', $id);
		$i = 0;
		foreach ($this->column_searchsubklaster as $item){
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_searchsubklaster) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		if(isset($_POST['order'])){

			$this->db->order_by($this->column_ordersubklaster[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

		}else if(isset($this->ordersubklaster)){

			$ordersubklaster = $this->ordersubklaster;
			$this->db->order_by(key($ordersubklaster), $ordersubklaster[key($ordersubklaster)]);
		}
	}

	function get_subklaster($id){
		$this->_get_subklaster_query($id);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_subklaster($id){
		$this->_get_subklaster_query($id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_subklaster($id){
		$this->db->from($this->tablesubklaster);
		$this->db->where('id_klaster', $id);
		return $this->db->count_all_results();
	}

/*--  Server Side Data subklasterUser --------*/
	var $tablesubklasterUser = '(SELECT c.*,d.id_user FROM ((select a.id, a.no_urut, a.nama_subklaster,a.id_klaster, a.nama_klaster,a.nu, a.urut,b.id_subklaster FROM (select bb.id, bb.no_urut, bb.nama_subklaster,bb.id_klaster, bb.nama_klaster, bb.nu,"B" AS urut from (select b.id,a.no_urut,b.id_klaster,a.nama_klaster,b.no_urut AS nu,b.nama_subklaster from tb_klaster a left join tb_subklaster b on b.id_klaster = a.id) as bb where bb.nama_subklaster <> "" order by bb.no_urut,bb.nu) a left JOIN tb_soal b ON b.id_subklaster = a.id group by a.id,a.no_urut,a.nama_subklaster, a.id_klaster,a.nama_klaster,a.nu,a.urut,b.id_subklaster) c LEFT JOIN tb_usersoal d ON d.id_subklaster=c.id_subklaster) GROUP BY c.id, c.no_urut, c.nama_subklaster,c.id_klaster, c.nama_klaster,c.nu, c.urut,c.id_subklaster,d.id_user) q_subklasteruser';
	var $column_ordersubklasterUser = array(null, 'id','id_klaster','no_urut','nama_subklaster','nama_klaster');
	var $column_searchsubklasterUser = array('nama_subklaster','nama_klaster');
	var $ordersubklasterUser = array('nu' => 'asc');


	private function _get_subklasterUser_query($id,$id_user){
		$this->db->from($this->tablesubklasterUser);
		$this->db->where('id_klaster', $id);
		$this->db->where('id_user', $id_user);
		$i = 0;
		foreach ($this->column_searchsubklasterUser as $item){
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_searchsubklasterUser) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		if(isset($_POST['order'])){

			$this->db->order_by($this->column_ordersubklasterUser[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

		}else if(isset($this->ordersubklasterUser)){

			$ordersubklasterUser = $this->ordersubklasterUser;
			$this->db->order_by(key($ordersubklasterUser), $ordersubklasterUser[key($ordersubklasterUser)]);
		}
	}

	function get_subklasterUser($id){
		$this->_get_subklasterUser_query($id,$this->session->userdata('id_user'));
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_subklasterUser($id){
		$this->_get_subklasterUser_query($id,$this->session->userdata('id_user'));
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_subklasterUser($id){
		$this->db->from($this->tablesubklasterUser);
		$this->db->where('id_klaster', $id);
		$this->db->where('id_user', $this->session->userdata('id_user'));
		return $this->db->count_all_results();
	}

	/*--  Server Side Data subklasterUser_jawaban --------*/
	var $tablesubklasterUser_jawaban = '(SELECT c.*,d.id_user FROM ((select a.id, a.no_urut, a.nama_subklaster,a.id_klaster, a.nama_klaster,a.nu, a.urut,b.id_subklaster FROM (select bb.id, bb.no_urut, bb.nama_subklaster,bb.id_klaster, bb.nama_klaster, bb.nu,"B" AS urut from (select b.id,a.no_urut,b.id_klaster,a.nama_klaster,b.no_urut AS nu,b.nama_subklaster from tb_klaster a left join tb_subklaster b on b.id_klaster = a.id) as bb where bb.nama_subklaster <> "" order by bb.no_urut,bb.nu) a left JOIN tb_soal b ON b.id_subklaster = a.id group by a.id,a.no_urut,a.nama_subklaster, a.id_klaster,a.nama_klaster,a.nu,a.urut,b.id_subklaster) c LEFT JOIN tb_usersoal d ON d.id_subklaster=c.id_subklaster) GROUP BY c.id, c.no_urut, c.nama_subklaster,c.id_klaster, c.nama_klaster,c.nu, c.urut,c.id_subklaster,d.id_user) q_subklasterUser_jawaban';
	var $column_ordersubklasterUser_jawaban = array(null, 'id','id_klaster','no_urut','nama_subklaster','nama_klaster');
	var $column_searchsubklasterUser_jawaban = array('nama_subklaster','nama_klaster');
	var $ordersubklasterUser_jawaban = array('nu' => 'asc');


	private function _get_subklasterUser_jawaban_query($id,$id_user){
		$this->db->from($this->tablesubklasterUser_jawaban);
		$this->db->where('id_klaster', $id);
		$this->db->where('id_user', $id_user);
		$i = 0;
		foreach ($this->column_searchsubklasterUser_jawaban as $item){
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_searchsubklasterUser_jawaban) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		if(isset($_POST['order'])){

			$this->db->order_by($this->column_ordersubklasterUser_jawaban[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

		}else if(isset($this->ordersubklasterUser_jawaban)){

			$ordersubklasterUser_jawaban = $this->ordersubklasterUser_jawaban;
			$this->db->order_by(key($ordersubklasterUser_jawaban), $ordersubklasterUser_jawaban[key($ordersubklasterUser_jawaban)]);
		}
	}

	function get_subklasterUser_jawaban($id,$id_user){
		$this->_get_subklasterUser_jawaban_query($id,$id_user);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_subklasterUser_jawaban($id,$id_user){
		$this->_get_subklasterUser_jawaban_query($id,$id_user);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_subklasterUser_jawaban($id,$id_user){
		$this->db->from($this->tablesubklasterUser_jawaban);
		$this->db->where('id_klaster', $id);
		$this->db->where('id_user', $id_user);
		return $this->db->count_all_results();
	}


/*--  Server Side Data soal --------*/
	var $tablesoal = '(select a.id,a.id_subklaster,a.id_klaster,a.no_urut,a.nama_soal,a.jika_ya,a.lampiran,a.nama_klaster,a.nu,a.nama_subklaster,b.id_soal FROM (select a.id,a.id_subklaster,b.id_klaster,a.no_urut,a.nama_soal,a.jika_ya,a.lampiran,b.nama_klaster,b.nu,b.nama_subklaster from tb_soal a left JOIN (select a.id, a.no_urut, a.nama_subklaster,a.id_klaster, a.nama_klaster,a.nu, a.urut,b.id_subklaster FROM (select bb.id, bb.no_urut, bb.nama_subklaster,bb.id_klaster, bb.nama_klaster, bb.nu,"B" AS urut from (select b.id,a.no_urut,b.id_klaster,a.nama_klaster,b.no_urut AS nu,b.nama_subklaster from tb_klaster a left join tb_subklaster b on b.id_klaster = a.id) as bb where bb.nama_subklaster <> "" order by bb.no_urut,bb.nu) a left JOIN tb_soal b ON b.id_subklaster = a.id group by a.id,a.no_urut,a.nama_subklaster, a.id_klaster,a.nama_klaster,a.nu,a.urut,b.id_subklaster) b on b.id = a.id_subklaster) a left join tb_checklist b on b.id_soal = a.id group by a.id,a.id_subklaster,a.id_klaster,a.no_urut,a.nama_soal,a.nama_klaster,a.nu,a.nama_subklaster,b.id_soal) q_soal';
	var $column_ordersoal = array(null, 'id','id_subklaster','no_urut','nama_soal');
	var $column_searchsoal = array('nama_soal');
	var $ordersoal = array('no_urut' => 'asc');


	private function _get_soal_query($id){
		$this->db->from($this->tablesoal);
		$this->db->where('id_subklaster', $id);
		$i = 0;
		foreach ($this->column_searchsoal as $item){
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_searchsoal) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		if(isset($_POST['order'])){

			$this->db->order_by($this->column_ordersoal[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

		}else if(isset($this->ordersoal)){

			$ordersoal = $this->ordersoal;
			$this->db->order_by(key($ordersoal), $ordersoal[key($ordersoal)]);
		}
	}

	function get_soal($id){
		$this->_get_soal_query($id);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_soal($id){
		$this->_get_soal_query($id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_soal($id){
		$this->db->from($this->tablesoal);
		$this->db->where('id_subklaster', $id);
		return $this->db->count_all_results();
	}

	/*--  Server Side Data soalUser --------*/
	var $tablesoalUser = '(SELECT a.id, a.id_subklaster, a.id_soal, a.id_user, b.nama_subklaster, c.no_urut, c.nama_soal,c.lampiran,f.jawaban_a,f.jawaban_b, f.catatan, f.lampiran as lampiranuser, f.id AS id_jawaban FROM tb_usersoal a LEFT JOIN tb_subklaster b ON b.id=a.id_subklaster LEFT JOIN tb_soal c ON c.id=a.id_soal LEFT JOIN tb_userjawaban f ON f.id_user=a.id_user AND f.id_soal=a.id_soal) q_soaluser';
	var $column_ordersoalUser = array(null, 'id','id_subklaster','no_urut','nama_soal');
	var $column_searchsoalUser = array('nama_soalUser');
	var $ordersoalUser = array('no_urut' => 'asc');


	private function _get_soalUser_query($id,$id_user){
		$this->db->from($this->tablesoalUser);
		$this->db->where('id_subklaster', $id);
		$this->db->where('id_user', $id_user);
		$i = 0;
		foreach ($this->column_searchsoalUser as $item){
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_searchsoalUser) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		if(isset($_POST['order'])){

			$this->db->order_by($this->column_ordersoalUser[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

		}else if(isset($this->ordersoalUser)){

			$ordersoalUser = $this->ordersoalUser;
			$this->db->order_by(key($ordersoalUser), $ordersoalUser[key($ordersoalUser)]);
		}
	}

	function get_soalUser($id){
		$this->_get_soalUser_query($id,$this->session->userdata('id_user'));
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_soalUser($id){
		$this->_get_soalUser_query($id,$this->session->userdata('id_user'));
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_soalUser($id){
		$this->db->from($this->tablesoalUser);
		$this->db->where('id_subklaster', $id);
		$this->db->where('id_user', $this->session->userdata('id_user'));
		return $this->db->count_all_results();
	}


	/*--  Server Side Data soalUser_jawaban --------*/
	var $tablesoalUser_jawaban = '(SELECT a.id, a.id_subklaster, a.id_soal, a.id_user, b.nama_subklaster, c.no_urut, c.nama_soal,c.lampiran,f.jawaban_a,f.jawaban_b, f.catatan, f.lampiran as lampiranuser, f.id AS id_jawaban FROM tb_usersoal a LEFT JOIN tb_subklaster b ON b.id=a.id_subklaster LEFT JOIN tb_soal c ON c.id=a.id_soal LEFT JOIN tb_userjawaban f ON f.id_user=a.id_user AND f.id_soal=a.id_soal) q_soalUser_jawaban';
	var $column_ordersoalUser_jawaban = array(null, 'id','id_subklaster','no_urut','nama_soal');
	var $column_searchsoalUser_jawaban = array('nama_soalUser_jawaban');
	var $ordersoalUser_jawaban = array('no_urut' => 'asc');


	private function _get_soalUser_jawaban_query($id,$id_user){
		$this->db->from($this->tablesoalUser_jawaban);
		$this->db->where('id_subklaster', $id);
		$this->db->where('id_user',$id_user);
		$i = 0;
		foreach ($this->column_searchsoalUser_jawaban as $item){
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_searchsoalUser_jawaban) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		if(isset($_POST['order'])){

			$this->db->order_by($this->column_ordersoalUser_jawaban[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

		}else if(isset($this->ordersoalUser_jawaban)){

			$ordersoalUser_jawaban = $this->ordersoalUser_jawaban;
			$this->db->order_by(key($ordersoalUser_jawaban), $ordersoalUser_jawaban[key($ordersoalUser_jawaban)]);
		}
	}

	function get_soalUser_jawaban($id,$id_user){
		$this->_get_soalUser_jawaban_query($id,$id_user);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_soalUser_jawaban($id,$id_user){
		$this->_get_soalUser_jawaban_query($id,$id_user);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_soalUser_jawaban($id,$id_user){
		$this->db->from($this->tablesoalUser_jawaban);
		$this->db->where('id_subklaster', $id);
		$this->db->where('id_user', $id_user);
		return $this->db->count_all_results();
	}


	/*--  Server Side Data checklist --------*/
	var $tablechecklist = 'tb_checklist';
	var $column_orderchecklist = array(null, 'id','id_soal','nama_checklist');
	var $column_searchchecklist = array('nama_checklist');
	var $orderchecklist = array('id' => 'asc');


	private function _get_checklist_query($id){
		$this->db->from($this->tablechecklist);
		$this->db->where('id_soal', $id);
		$i = 0;
		foreach ($this->column_searchchecklist as $item){
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_searchchecklist) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		if(isset($_POST['order'])){

			$this->db->order_by($this->column_orderchecklist[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

		}else if(isset($this->orderchecklist)){

			$orderchecklist = $this->orderchecklist;
			$this->db->order_by(key($orderchecklist), $orderchecklist[key($orderchecklist)]);
		}
	}

	function get_checklist($id){
		$this->_get_checklist_query($id);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_checklist($id){
		$this->_get_checklist_query($id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_checklist($id){
		$this->db->from($this->tablechecklist);
		$this->db->where('id_soal', $id);
		return $this->db->count_all_results();
	}


}
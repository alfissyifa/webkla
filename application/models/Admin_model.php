<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function simpanSoal($id_subklaster, $id_user, $id_soal) {
        // Data yang akan disimpan
        $data = array(
        	'id_subklaster' => $id_subklaster,
            'id_user' => $id_user,
            'id_soal' => $id_soal
        );

        // Simpan data ke dalam tabel 'tb_soal_user' (misalnya)
        $this->db->insert('tb_usersoal', $data);

        // Periksa apakah penyimpanan berhasil
        if ($this->db->affected_rows() > 0) {
            // Jika berhasil, kembalikan true
            return true;
        } else {
            // Jika gagal, kembalikan false
            return false;
        }
    }

    public function simpanCheklist($id_user, $id_soal, $id_checklist) {
        // Data yang akan disimpan
        $data = array(
        	'id_user' => $id_user,
            'id_soal' => $id_soal,
            'id_checklist' => $id_checklist
        );

        // Simpan data ke dalam tabel 'tb_soal_user' (misalnya)
        $this->db->insert('tb_userchecklist', $data);

        // Periksa apakah penyimpanan berhasil
        if ($this->db->affected_rows() > 0) {
            // Jika berhasil, kembalikan true
            return true;
        } else {
            // Jika gagal, kembalikan false
            return false;
        }
    }

    public function get_soal_user_id($id_jawaban) {
	    // Lakukan query untuk mendapatkan id_soal dan id_user dari tabel tb_userjawaban berdasarkan id_jawaban
	    $this->db->select('id_soal, id_user');
	    $this->db->where('id', $id_jawaban);
	    $query = $this->db->get('tb_userjawaban');

	    // Periksa apakah query berhasil
	    if ($query->num_rows() > 0) {
	        // Jika berhasil, kembalikan array asosiatif berisi id_soal dan id_user
	        return $query->row_array();
	    } else {
	        // Jika tidak berhasil, kembalikan null atau nilai default yang sesuai
	        return null;
	    }
	}

    public function simpanJawaban($id_user, $id_soal, $pilihan, $jawaban, $catatan, $lampiran) {
        // Data yang akan disimpan
        $data = array(
        	'id_user' => $id_user,
            'id_soal' => $id_soal,
            'jawaban_a' => $pilihan,
            'jawaban_b' => $jawaban,
            'catatan' => $catatan,
            'lampiran' => $lampiran,
        );

        // Simpan data ke dalam tabel 'tb_soal_user' (misalnya)
        $this->db->insert('tb_userjawaban', $data);

        // Periksa apakah penyimpanan berhasil
        if ($this->db->affected_rows() > 0) {
            // Jika berhasil, kembalikan true
            return true;
        } else {
            // Jika gagal, kembalikan false
            return false;
        }
    }

    public function cekSoalExist($id_user, $id_soal) {
	    // Query untuk memeriksa apakah soal sudah ada dalam tabel usersoal
	    $this->db->where('id_user', $id_user);
	    $this->db->where('id_soal', $id_soal);
	    $query = $this->db->get('tb_usersoal');

	    // Return true jika soal sudah ada, false jika tidak
	    return $query->num_rows() > 0;
	}

	public function cekChecklistExist($id_user, $id_checklist) {
	    // Query untuk memeriksa apakah soal sudah ada dalam tabel usersoal
	    $this->db->where('id_user', $id_user);
	    $this->db->where('id_checklist', $id_checklist);
	    $query = $this->db->get('tb_userchecklist');

	    // Return true jika soal sudah ada, false jika tidak
	    return $query->num_rows() > 0;
	}

	


	public function get_userklaster($id_user,$id_klaster)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('id_klaster', $id_klaster);
        $query = $this->db->get('(SELECT c.id AS id_klaster,d.id_user, if(d.id_user IS NULL,"","OK") AS ket FROM ((SELECT a.*,b.id AS id_subklaster FROM tb_klaster a LEFT JOIN tb_subklaster b ON b.id_klaster=a.id) c LEFT JOIN tb_usersoal d ON d.id_subklaster= c.id_subklaster) GROUP BY c.id,d.id_user) q_userklaster'); 
       return $query->result_array();
    }

    public function get_userjawaban($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('(SELECT a.id_user FROM tb_usersoal a GROUP BY a.id_user) q_userjawaban'); 
       return $query->result_array();
    }


    public function get_jawaban($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('(SELECT * from tb_userjawaban) q_jawaban'); 
       return $query->result_array();
    }

    public function get_usersubklaster($id_user,$id_subklaster)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('id_subklaster', $id_subklaster);
        $query = $this->db->get('(SELECT c.id_subklaster,d.id_user, if(d.id_user IS NULL,"","OK") AS ket FROM ((SELECT a.*,b.id AS id_subklaster FROM tb_klaster a LEFT JOIN tb_subklaster b ON b.id_klaster=a.id) c LEFT JOIN tb_usersoal d ON d.id_subklaster= c.id_subklaster) GROUP BY c.id_subklaster,d.id_user) q_usersubklaster'); 
       return $query->result_array();
    }

    public function get_userchecklist($id_user,$id_soal)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('id_soal', $id_soal);
        $query = $this->db->get('(SELECT a.*, b.nama_checklist FROM tb_userchecklist a LEFT JOIN tb_checklist b ON b.id=a.id_checklist AND b.id_soal=a.id_soal) q_userchecklist'); 
       return $query->result_array();
    }

    public function get_userjawab($id_user,$id_klaster)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('id_klaster', $id_klaster);
        $query = $this->db->get('(SELECT c.*,d.id_klaster FROM (SELECT a.id_user,a.id_soal,b.id_subklaster FROM tb_userjawaban a LEFT JOIN tb_soal b ON b.id=a.id_soal) c LEFT JOIN tb_subklaster d ON d.id=c.id_subklaster) q_userjawab'); 
       return $query->result_array();
    }

    public function get_userjawabb($id_user,$id_subklaster)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('id_subklaster', $id_subklaster);
        $query = $this->db->get('(SELECT c.*,d.id_klaster FROM (SELECT a.id_user,a.id_soal,b.id_subklaster FROM tb_userjawaban a LEFT JOIN tb_soal b ON b.id=a.id_soal) c LEFT JOIN tb_subklaster d ON d.id=c.id_subklaster) q_userjawab'); 
       return $query->result_array();
    }

	public function getKlaster(){
		$query = "SELECT * FROM tb_klaster order by no_urut";
		return $this->db->query($query)->result();
	}

	public function getCountKlaster(){
		$query = "SELECT COUNT(nama_klaster) as nama_klaster FROM tb_klaster";
		return $this->db->query($query)->row()->nama_klaster;
	}

	public function getCountKlaster_user(){
		$id_user = $this->session->userdata('id_user');
		$query = "SELECT COUNT(a.nama_klaster) as nama_klaster FROM (SELECT id,e.no_urut,e.nama_klaster,e.id_klaster,e.id_user FROM (SELECT c.*, d.id_user FROM ((select a.id, a.no_urut, a.nama_klaster, b.id_klaster,b.id AS id_subklaster FROM (tb_klaster a left join tb_subklaster b on b.id_klaster = a.id)) c left join tb_usersoal d ON d.id_subklaster=c.id_subklaster) group by c.id,c.no_urut,c.nama_klaster,c.id_klaster, c.id_subklaster, d.id_user) e group by e.id,e.no_urut,e.nama_klaster,e.id_klaster, e.id_user) a where a.id_user='$id_user'";
		return $this->db->query($query)->row()->nama_klaster;
	}

	public function getCountSubklaster(){
		$query = "SELECT COUNT(nama_subklaster) as nama_subklaster FROM tb_subklaster";
		return $this->db->query($query)->row()->nama_subklaster;
	}

	public function getCountSubklaster_user(){
    $id_user = $this->session->userdata('id_user');
    $query = "
        SELECT COUNT(a.nama_subklaster) as nama_subklaster 
        FROM (
            SELECT c.*,d.id_user 
            FROM (
                (
                    select a.id, a.no_urut, a.nama_subklaster,a.id_klaster, a.nama_klaster,a.nu, a.urut,b.id_subklaster 
                    FROM (
                        select bb.id, bb.no_urut, bb.nama_subklaster,bb.id_klaster, bb.nama_klaster, bb.nu, 'B' AS urut 
                        from (
                            select b.id,a.no_urut,b.id_klaster,a.nama_klaster,b.no_urut AS nu,b.nama_subklaster 
                            from tb_klaster a 
                            left join tb_subklaster b on b.id_klaster = a.id
                        ) as bb 
                        where bb.nama_subklaster <> '' 
                        order by bb.no_urut, bb.nu
                    ) a 
                    left JOIN tb_soal b ON b.id_subklaster = a.id 
                    group by a.id,a.no_urut,a.nama_subklaster, a.id_klaster,a.nama_klaster,a.nu,a.urut,b.id_subklaster
                ) c 
                LEFT JOIN tb_usersoal d ON d.id_subklaster=c.id_subklaster
            )
            GROUP BY c.id, c.no_urut, c.nama_subklaster,c.id_klaster, c.nama_klaster,c.nu, c.urut,c.id_subklaster,d.id_user
        ) a 
        where a.id_user='$id_user'
    ";
    return $this->db->query($query)->row()->nama_subklaster;
}


	public function getCountSoal(){
		$query = "SELECT COUNT(nama_soal) as nama_soal FROM tb_soal";
		return $this->db->query($query)->row()->nama_soal;
	}

	public function getCountSoal_user(){
		$id_user = $this->session->userdata('id_user');
		$query = "SELECT COUNT(a.nama_soal) as nama_soal FROM (SELECT a.id, a.id_subklaster, a.id_soal, a.id_user, b.nama_subklaster, c.no_urut, c.nama_soal,c.lampiran,f.jawaban_a,f.jawaban_b, f.catatan, f.lampiran as lampiranuser, f.id AS id_jawaban FROM tb_usersoal a LEFT JOIN tb_subklaster b ON b.id=a.id_subklaster LEFT JOIN tb_soal c ON c.id=a.id_soal LEFT JOIN tb_userjawaban f ON f.id_user=a.id_user AND f.id_soal=a.id_soal) a where a.id_user='$id_user'";
		return $this->db->query($query)->row()->nama_soal;
	}

	public function getCountUser(){
		$query = "SELECT COUNT(username) as username FROM tb_users where level='User'";
		return $this->db->query($query)->row()->username;
	}


	public function getOneKlaster($id){
		$this->db->select('*');
		$this->db->from('tb_klaster');
		$this->db->where('tb_klaster.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getOneQKlaster($id){
		$this->db->select('*');
		$this->db->from('(select a.id, a.no_urut, a.nama_subklaster,a.id_klaster, a.nama_klaster,a.nu, a.urut,b.id_subklaster FROM (select bb.id, bb.no_urut, bb.nama_subklaster,bb.id_klaster, bb.nama_klaster, bb.nu,"B" AS urut from (select b.id,a.no_urut,b.id_klaster,a.nama_klaster,b.no_urut AS nu,b.nama_subklaster from tb_klaster a left join tb_subklaster b on b.id_klaster = a.id) as bb where bb.nama_subklaster <> "" order by bb.no_urut,bb.nu) a left JOIN tb_soal b ON b.id_subklaster = a.id group by a.id,a.no_urut,a.nama_subklaster, a.id_klaster,a.nama_klaster,a.nu,a.urut,b.id_subklaster) q_subklaster');
		$this->db->where('q_subklaster.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getOneQKlasterJawaban($id){
		$this->db->select('*');
		$this->db->from('(SELECT c.*,d.nama_klaster FROM ((SELECT a.id AS id_soal, b.id_klaster, b.id AS id_subklaster, b.no_urut AS nu,b.nama_subklaster FROM tb_soal a LEFT JOIN tb_subklaster b ON b.id=a.id_subklaster) c LEFT JOIN tb_klaster d ON d.id=c.id_klaster) GROUP BY c.id_soal,c.id_klaster,c.id_subklaster,c.nu,c.nama_subklaster,d.nama_klaster) q_subklasterjawaban');
		$this->db->where('q_subklasterjawaban.id_soal', $id);
		$query = $this->db->get();
		return $query->row();
	}


	public function getOneQ_SubKlaster($id){
		$this->db->select('*');
		$this->db->from('q_subklaster');
		$this->db->where('q_subklaster.id_subklaster', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getOneSubklaster($id){
		$this->db->select('*');
		$this->db->from('tb_subklaster');
		$this->db->where('tb_subklaster.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getOneQSubklaster($id){
		$this->db->select('*');
		$this->db->from('q_subklaster');
		$this->db->where('q_subklaster.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getOneSoal($id){
		$this->db->select('*');
		$this->db->from('(select a.id,a.id_subklaster,a.id_klaster,a.no_urut,a.nama_soal,a.jika_ya,a.lampiran,a.nama_klaster,a.nu,a.nama_subklaster,b.id_soal FROM (select a.id,a.id_subklaster,b.id_klaster,a.no_urut,a.nama_soal,a.jika_ya,a.lampiran,b.nama_klaster,b.nu,b.nama_subklaster from tb_soal a left JOIN (select a.id, a.no_urut, a.nama_subklaster,a.id_klaster, a.nama_klaster,a.nu, a.urut,b.id_subklaster FROM (select bb.id, bb.no_urut, bb.nama_subklaster,bb.id_klaster, bb.nama_klaster, bb.nu,"B" AS urut from (select b.id,a.no_urut,b.id_klaster,a.nama_klaster,b.no_urut AS nu,b.nama_subklaster from tb_klaster a left join tb_subklaster b on b.id_klaster = a.id) as bb where bb.nama_subklaster <> "" order by bb.no_urut,bb.nu) a left JOIN tb_soal b ON b.id_subklaster = a.id group by a.id,a.no_urut,a.nama_subklaster, a.id_klaster,a.nama_klaster,a.nu,a.urut,b.id_subklaster) b on b.id = a.id_subklaster) a left join tb_checklist b on b.id_soal = a.id group by a.id,a.id_subklaster,a.id_klaster,a.no_urut,a.nama_soal,a.nama_klaster,a.nu,a.nama_subklaster,b.id_soal) q_soal');
		$this->db->where('q_soal.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getAllOptions($id){
	    $this->db->select('*');
	    $this->db->from('(select a.id,a.id_subklaster,a.id_klaster,a.no_urut,a.nama_soal,a.jika_ya,a.lampiran,a.nama_klaster,a.nu,a.nama_subklaster,b.id_soal FROM (select a.id,a.id_subklaster,b.id_klaster,a.no_urut,a.nama_soal,a.jika_ya,a.lampiran,b.nama_klaster,b.nu,b.nama_subklaster from tb_soal a left JOIN (select a.id, a.no_urut, a.nama_subklaster,a.id_klaster, a.nama_klaster,a.nu, a.urut,b.id_subklaster FROM (select bb.id, bb.no_urut, bb.nama_subklaster,bb.id_klaster, bb.nama_klaster, bb.nu,"B" AS urut from (select b.id,a.no_urut,b.id_klaster,a.nama_klaster,b.no_urut AS nu,b.nama_subklaster from tb_klaster a left join tb_subklaster b on b.id_klaster = a.id) as bb where bb.nama_subklaster <> "" order by bb.no_urut,bb.nu) a left JOIN tb_soal b ON b.id_subklaster = a.id group by a.id,a.no_urut,a.nama_subklaster, a.id_klaster,a.nama_klaster,a.nu,a.urut,b.id_subklaster) b on b.id = a.id_subklaster) a left join tb_checklist b on b.id_soal = a.id group by a.id,a.id_subklaster,a.id_klaster,a.no_urut,a.nama_soal,a.nama_klaster,a.nu,a.nama_subklaster,b.id_soal) q_soal');
	    $this->db->where('q_soal.id_subklaster', $id); // Mengambil semua opsi soal berdasarkan id_subklaster
	    $query = $this->db->get();
	    return $query->result(); // Mengembalikan hasil dalam bentuk array objek
	}

	public function getAllChecklist($id){
	    $this->db->select('*');
		$this->db->from('tb_checklist');
		$this->db->where('tb_checklist.id_soal', $id);
		$query = $this->db->get();
	    return $query->result(); // Mengembalikan hasil dalam bentuk array objek
	}

	public function getusersoal($id){
		$this->db->select('*');
		$this->db->from('tb_soal');
		$this->db->where('tb_soal.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getjawaban($id,$id_user){
		$this->db->select('*');
		$this->db->from('tb_userjawaban');
		$this->db->where('tb_userjawaban.id_soal', $id);
		$this->db->where('tb_userjawaban.id_user', $id_user);
		$query = $this->db->get();
		return $query->row();
	}

	public function getOneUser($id){
		$this->db->select('*');
		$this->db->from('tb_users');
		$this->db->where('tb_users.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getOneChecklist($id){
		$this->db->select('*');
		$this->db->from('(select a.id ,a.id_soal,a.nama_checklist,b.no_urut,b.nama_soal,b.nama_klaster,b.nu,b.nama_subklaster from tb_checklist a left JOIN (select a.id,a.id_subklaster,a.id_klaster,a.no_urut,a.nama_soal,a.jika_ya,a.lampiran,a.nama_klaster,a.nu,a.nama_subklaster,b.id_soal FROM (select a.id,a.id_subklaster,b.id_klaster,a.no_urut,a.nama_soal,a.jika_ya,a.lampiran,b.nama_klaster,b.nu,b.nama_subklaster from tb_soal a left JOIN (select a.id,a.no_urut,a.nama_subklaster,a.id_klaster, a.nama_klaster,a.nu, a.urut,b.id_subklaster FROM (select bb.id, bb.no_urut, bb.nama_subklaster,bb.id_klaster, bb.nama_klaster, bb.nu,"B" AS urut from (select b.id,a.no_urut,b.id_klaster,a.nama_klaster,b.no_urut AS nu,b.nama_subklaster from tb_klaster a left join tb_subklaster b on b.id_klaster = a.id) as bb where bb.nama_subklaster <> "" order by bb.no_urut,bb.nu) a left JOIN tb_soal b ON b.id_subklaster = a.id group by a.id,a.no_urut,a.nama_subklaster, a.id_klaster,a.nama_klaster,a.nu,a.urut,b.id_subklaster) b on b.id = a.id_subklaster) a left join tb_checklist b on b.id_soal = a.id group by a.id,a.id_subklaster,a.id_klaster,a.no_urut,a.nama_soal,a.nama_klaster,a.nu,a.nama_subklaster,b.id_soal) b on b.id = a.id_soal) q_checklist');
		$this->db->where('q_checklist.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getUsers(){
		$query = "SELECT * FROM tb_users";
		return $this->db->query($query)->result();
	}


	public function getOneUsers($id){
		$query = "SELECT * FROM tb_users WHERE id = '$id' ";
		return $this->db->query($query)->row();
	}

	public function getOneWebsite($id){
		$query = "SELECT * FROM tb_website WHERE id = '$id' ";
		return $this->db->query($query)->row();
	}

}
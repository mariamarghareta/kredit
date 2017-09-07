<?php
class Blok extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function show_all(){
        $query = $this->db->select('kd_blok, nama_blok')
                ->from('blok')
                ->where('deleted',0)
                ->get();
        return $query->result();
    }    
    public function show_all_available(){
        
        $query = $this->db->distinct()
                ->select('t.kd_blok, b.nama_blok')
                ->from('blok b')
                ->join('tanah t', 't.kd_blok = b.kd_blok')
                ->where('t.kd_tanah not in (select kd_tanah from transaksi where deleted = 0)')
                ->where('t.deleted',0)
                ->where('b.deleted',0)
                ->get();
        /*
        $query = $this->db->select('t.kd_tanah')
                ->from('tanah t')
                ->join('transaksi tr', 'tr.kd_tanah = t.kd_tanah')
                ->where('t.deleted',0)
                ->where('b.deleted',0)
                ->where_not_in('t.kd_tanah','tr.kd_tanah')
                ->get();
        
        */
        return $query->result();
    }
    public function show_all_available_except_one($kode){
        
        $query = $this->db->distinct()
                ->select('t.kd_blok, b.nama_blok')
                ->from('blok b')
                ->join('tanah t', 't.kd_blok = b.kd_blok')
                ->where("t.kd_tanah not in (select kd_tanah from transaksi where deleted = 0 and kd_trans != $kode)")
                ->where('t.deleted',0)
                ->where('b.deleted',0)
                ->get();
        /*
        $query = $this->db->select('t.kd_tanah')
                ->from('tanah t')
                ->join('transaksi tr', 'tr.kd_tanah = t.kd_tanah')
                ->where('t.deleted',0)
                ->where('b.deleted',0)
                ->where_not_in('t.kd_tanah','tr.kd_tanah')
                ->get();
        
        */
        return $query->result();
    }
    public function insert($nama){
        $nama = strtoupper($nama);
        $data = array(
            'nama_blok' =>$nama
        );

        $query = $this->db->insert('blok', $data);
        return $query;
    }
   
    public function cek_kembar($kode){
        $this->db->from('blok');
        $this->db->where('nama_blok', $kode);
        $this->db->where('deleted', 0);
        $query = $this->db->count_all_results();
        if($query >= 1){
            return false;
        } else {
            return true;
        }
    }
    public function grab_data($kode){
        $query = $this->db->select('kd_blok, nama_blok')
                ->from('blok')
                ->where('kd_blok', $kode)
                ->where('deleted',0)
                ->get();
        return $query->result_array();
    } 
   
    public function update_data($kode, $nama){
        $nama = strtoupper($nama);
        $data = array(
            'nama_blok' => $nama
        );

        $this->db->where('kd_blok', $kode);
        return $this->db->update('blok', $data);
    }
    public function delete_data($kode){
        $data = array(
            'deleted' => 1
        );
        $this->db->where('kd_blok', $kode);
        return $this->db->update('blok', $data);
    }
}
?>
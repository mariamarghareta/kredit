<?php
class Tanah extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function show_all(){
        $query = $this->db->select('t.kd_tanah, t.nomor_tanah, t.kd_blok, b.nama_blok')
                ->from('blok b')
                ->join('tanah t', 't.kd_blok = b.kd_blok')
                ->where('t.deleted',0)
                ->where('b.deleted',0)
                ->get();
        return $query->result();
    } 
    public function show_all_available(){
        $query = $this->db->select('t.kd_tanah, t.nomor_tanah, t.kd_blok, b.nama_blok')
                ->from('blok b')
                ->join('tanah t', 't.kd_blok = b.kd_blok')
                ->where('t.deleted',0)
                ->where('b.deleted',0)
                ->where('t.kd_tanah not in (select kd_tanah from transaksi where deleted = 0)')
                ->get();
        return $query->result();
    }
    
    public function insert($kode, $nomor){
        $data = array(
            'nomor_tanah' =>$nomor,
            'kd_blok'=> $kode
        );

        $query = $this->db->insert('tanah', $data);
        return $query;
    }
   
    public function cek_kembar($kode, $tanah){
        $this->db->from('tanah');
        $this->db->where('nomor_tanah', $tanah);
        $this->db->where('kd_blok', $kode);
        $this->db->where('deleted', 0);
        $query = $this->db->count_all_results();
        if($query >= 1){
            return false;
        } else {
            return true;
        }
    }
    public function grab_data($kode){
         $query = $this->db->select('t.kd_tanah, t.nomor_tanah, t.kd_blok, b.nama_blok')
                ->from('blok b')
                ->join('tanah t', 't.kd_blok = b.kd_blok')
                ->where('t.kd_tanah', $kode)
                ->where('t.deleted',0)
                ->get();
        return $query->result_array();
    } 
    public function grab_data_byblok($kode){
        
        /*$query = $this->db->select('t.kd_tanah, t.nomor_tanah, t.kd_blok, b.nama_blok')
                ->from('blok b')
                ->join('tanah t', 't.kd_blok = b.kd_blok')
                ->where('t.kd_blok', $kode)
                ->where('t.deleted',0)
                ->get();
        return $query->result_array();
        */
        $query = $this->db->select('t.kd_tanah, t.nomor_tanah, t.kd_blok, b.nama_blok')
                ->from('blok b')
                ->join('tanah t', 't.kd_blok = b.kd_blok')
                ->where('t.deleted',0)
                ->where('b.deleted',0)
                ->where('t.kd_blok', $kode)
                ->where('t.kd_tanah not in (select kd_tanah from transaksi where deleted = 0)')
                ->get();
        return $query->result();
    }
    public function show_all_available_except_one($kode, $kd_trans){
         $query = $this->db->select('t.kd_tanah, t.nomor_tanah, t.kd_blok, b.nama_blok')
                ->from('blok b')
                ->join('tanah t', 't.kd_blok = b.kd_blok')
                ->where('t.deleted',0)
                ->where('b.deleted',0)
                ->where('t.kd_blok', $kode)
                ->where("t.kd_tanah not in (select kd_tanah from transaksi where deleted = 0 and kd_trans != $kd_trans)")
                ->get();
        return $query->result();
    }
    public function update_data($blok, $nomor, $kode){
        $data = array(
            'nomor_tanah' => $nomor,
            'kd_blok' => $blok
        );

        $this->db->where('kd_tanah', $kode);
        return $this->db->update('tanah', $data);
    }
    public function delete_data($kode){
        $data = array(
            'deleted' => 1
        );
        $this->db->where('kd_tanah', $kode);
        return $this->db->update('tanah', $data);
    }
}
?>
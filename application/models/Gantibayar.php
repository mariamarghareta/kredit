<?php
class Gantibayar extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert($kd_trans, $tipe, $karyawan){
        $data = array(
            'kd_trans' => $kd_trans,
            'tipe_bayar' => $tipe,
            'kd_kar' => $karyawan,
        );

        return $this->db->insert('ganti_bayar', $data);
        
    }
    public function check_cash_before($kd_trans){
        $query = $this->db->select('count(*) as jumlah')
            ->from('ganti_bayar')
            ->where('tipe_bayar', 0)
            ->where('kd_trans', $kd_trans)
            ->get()
            ->row();
        return $query;
    }
  
}
?>
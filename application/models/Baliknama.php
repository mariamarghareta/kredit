<?php
class Baliknama extends CI_Model {

    
    public $kd_role;
    public $nama_role;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert($kd_trans, $biaya, $kd_kar, $tgl_trans, $jatuh_tempo, $is_transfer){
        $array = array(
            'kd_trans'=>$kd_trans,
            'bayar'=>$biaya,
            'kd_kar'=>$kd_kar,
            'tgl_trans'=>date('Y-m-d',strtotime($tgl_trans)),
			'jatuh_tempo' => date('Y-m-d',strtotime($jatuh_tempo)),
			'is_transfer' => $is_transfer
        );
        $query = $this->db->insert('balik_nama', $array);
        if($query == 1){
            return $this->get_kode($kd_trans, $biaya, $tgl_trans, $jatuh_tempo);
        }else{
            return null;
        }
    }  
    private function get_kode($kd_trans, $biaya, $tgl_trans, $jatuh_tempo){
        $query = $this->db->select('kd_nota')
            ->from('balik_nama')
            ->where('kd_trans', $kd_trans)
            ->where('bayar', $biaya)
            ->where('tgl_trans', date('Y-m-d',strtotime($tgl_trans)))
            ->where('jatuh_tempo', date('Y-m-d',strtotime($jatuh_tempo)))
            ->get()
            ->row();
        return $query;
    }
    public function grab_data($kd_nota){
        $query = $this->db->select('kd_nota, kd_trans, DATE_FORMAT(tgl_trans, "%d-%m-%Y") as tgl_trans, bayar, kd_kar, updated, deleted, is_transfer, DATE_FORMAT(jatuh_tempo, "%d-%m-%Y") as jatuh_tempo')
            ->from('balik_nama')
            ->where('kd_nota', $kd_nota)
            ->get()
            ->row();
        return $query;
    }
    public function update_bn($kd_nota, $tgl_trans, $bayar, $is_transfer, $jatuh_tempo){
        $array = array(
            'tgl_trans' => date('Y-m-d',strtotime($tgl_trans)),
            'bayar' => $bayar,
            'is_transfer' => $is_transfer,
            'jatuh_tempo' => date('Y-m-d',strtotime($jatuh_tempo))
        );
        $this->db->where('kd_nota', $kd_nota);
        return $this->db->update('balik_nama', $array);
    }
    public function cek_detail_transaksi($kd_trans){
        $query = $this->db->select('bn.kd_nota, DATE_FORMAT(bn.tgl_trans, "%d-%m-%Y") as tgl_trans, bn.bayar, bn.kd_kar, bn.updated, bn.deleted, k.nama, bn.is_transfer, DATE_FORMAT(bn.jatuh_tempo, "%d-%m-%Y") as jatuh_tempo')
            ->from('balik_nama bn')
            ->join('karyawan k','k.kd_kar = bn.kd_kar')
            ->where('kd_trans', $kd_trans)
            ->order_by("bn.tgl_trans","asc")
            ->order_by("bn.updated","asc")
            ->get();
        return $query->result();
    }

}
?>
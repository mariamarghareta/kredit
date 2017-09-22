<?php
class Catatan extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert($kd_trans, $kd_nota, $catatan, $urutan, $tipe){
        $query = array(
            'kd_trans' =>$kd_trans,
            'kd_nota' =>$kd_nota,
            'keterangan'=> $catatan,
            'urutan' => $urutan,
            'tipe' => $tipe
        );

        $query = $this->db->insert('catatan', $query);

        if($query == 1){
            return $this->get_kode($kd_trans, $kd_nota, $catatan);
        }else{
            return null;
        }

    }
    private function get_kode($kd_trans, $kd_nota, $catatan){
        $query = $this->db->select('*', 1)
            ->from('catatan')
            ->where('kd_nota',$kd_nota)
            ->where('kd_trans',$kd_trans)
            ->where('keterangan',$catatan)
            ->where('deleted',0)
            ->order_by("updated","DESC")
            ->get()
            ->row();
        return $query;
    }

    public function cek_detail_transaksi($kd_trans){
        $query = $this->db->query("
        select cat.kd_trans, cat.kd_nota, cat.kd_catatan, cat.keterangan, DATE_FORMAT(cat.updated,'%Y-%m-%d %h:%i:%s') as updated, cat.deleted, cat.tipe, cat.urutan,
        case when cicilan.kd_nota is not null then DATE_FORMAT(cicilan.jatuh_tempo,'%Y-%m-%d') else (case when dp.kd_nota is not null then DATE_FORMAT(dp.jatuh_tempo,'%Y-%m-%d') end) end as jatuh_tempo
        from catatan cat
        left join dp on dp.kd_nota = cat.kd_nota
        left join cicilan on cicilan.kd_nota = cat.kd_nota
        where cat.kd_trans = $kd_trans");
        return $query->result_array();
    }
    public function get_catatan($kd_nota){
        $query = $this->db->select('*')
            ->from('catatan')
            ->where('kd_nota',$kd_nota)
            ->where('deleted',0)
            ->order_by("updated","ASC")
            ->get()
            ->result_array();
        return $query;
    }
}
?>
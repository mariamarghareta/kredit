<?php
class Ppjb extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_ppjb($kd_trans){
        $query = $this->db->select('p.kd_nota, p.kd_trans, p.bayar, DATE_FORMAT(p.tgl_bayar, "%d-%m-%Y") as tgl_bayar, p.kar_jual, p.bonus_agen, p.kd_kar, p.updated, p.deleted , kar.nama as ppjb_kar_nama, kar1.nama as ppjb_agen, p.is_transfer')
            ->from('ppjb p')
            ->join('transaksi t', 't.kd_trans = p.kd_trans')
            ->join('karyawan kar', 'kar.kd_kar = p.kd_kar')
            ->join('karyawan kar1', 'kar1.kd_kar = p.kar_jual')
            ->where('p.kd_trans', $kd_trans)
            ->get()
            ->row();
        return $query;
    } 
    public function insert($kd_trans, $bayar, $tgl_bayar, $kar_jual, $kd_kar, $is_transfer){
        $array = array(
            'kd_trans' => $kd_trans,
            'bayar' => $bayar,
            'tgl_bayar' => date('Y-m-d',strtotime($tgl_bayar)),
            'kar_jual' => $kar_jual,
            'kd_kar' => $kd_kar,
            'is_transfer' => $is_transfer,
            'bonus_agen' => 0
        );
        $query = $this->db->insert('ppjb', $array);
        if($query == 1){
            return $this->get_kode($kd_trans, $bayar, $tgl_bayar, $kar_jual, $kd_kar);
        }else{
            return null;
        }
    }
    public function get_kode($kd_trans, $bayar, $tgl_bayar, $kar_jual, $kd_kar){
        $query = $this->db->select('p.*',1)
            ->from('ppjb p')
            ->where('kd_trans', $kd_trans )
            ->where('bayar', $bayar )
            ->where('tgl_bayar', date('Y-m-d',strtotime($tgl_bayar)) )
            ->where('kar_jual', $kar_jual )
            ->where('kd_kar', $kd_kar )
            ->order_by("updated","DESC")
            ->get()
            ->row();
        return $query;
    }
    public function update_ppjb($kd_nota, $bayar, $tgl_bayar, $kar_jual, $bonus_agen, $is_transfer){
        $array = array(
            'bayar' => $bayar,
            'tgl_bayar' => date('Y-m-d',strtotime($tgl_bayar)),
            'kar_jual' => $kar_jual,
            'bonus_agen' => $bonus_agen,
            'is_transfer' => $is_transfer
        );
        $this->db->where('kd_nota', $kd_nota);
        return $this->db->update('ppjb', $array);
    }
    public function search($range, $par1, $par2){
        $wc="";
        if($range == "bulan"){
            
            $wc .= ("and DATE_FORMAT(ppjb.tgl_bayar, '%m-%Y') =  '$par1' ");
        } else if($range=="jangka"){
            
            $wc .= ("and DATE_FORMAT(ppjb.tgl_bayar,'%Y-%m-%d') >=  STR_TO_DATE('$par1', '%d-%m-%Y') and DATE_FORMAT(ppjb.tgl_bayar,'%Y-%m-%d') <=  STR_TO_DATE('$par2', '%d-%m-%Y')");
        }
        
        
        $query= $this->db->query("select ppjb.kd_nota, ppjb.kd_trans, kar.nama, role.nama_role, ppjb.kar_jual, sum(ppjb.bonus_agen) as total_bonus
        from ppjb, karyawan kar, role , transaksi t
        where ppjb.kar_jual = kar.kd_kar and kar.kd_role = role.kd_role and t.deleted = 0 and t.kd_trans = ppjb.kd_trans $wc group by ppjb.kar_jual order by ppjb.tgl_bayar" );
        return $query->result_array();
    }
    public function detail_karjual($range, $par1, $par2, $kode){
        $wc="";
        if($range == "bulan"){
            
            $wc .= ("and DATE_FORMAT(ppjb.tgl_bayar, '%m-%Y') =  '$par1' ");
        } else if($range=="jangka"){
            
            $wc .= ("and DATE_FORMAT(ppjb.tgl_bayar,'%Y-%m-%d') >=  STR_TO_DATE('$par1', '%d-%m-%Y') and DATE_FORMAT(ppjb.tgl_bayar,'%Y-%m-%d') <=  STR_TO_DATE('$par2', '%d-%m-%Y')");
        }
       
        $query = $this->db->query("select ppjb.kd_trans, DATE_FORMAT(ppjb.tgl_bayar, '%d-%m-%Y') as tgl_bayar, ppjb.bonus_agen, blok.nama_blok, tanah.nomor_tanah from ppjb , transaksi t, blok, tanah where ppjb.kar_jual = '$kode' and t.kd_trans = ppjb.kd_trans and t.kd_tanah = tanah.kd_tanah and tanah.kd_blok = blok.kd_blok and t.deleted = 0 $wc");
        return $query->result_array();
        
    }
}
?>
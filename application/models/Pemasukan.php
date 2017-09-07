<?php
class Pemasukan extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert($biaya, $tgl_trans, $kd_kar, $ket, $pj){
        $array = array(
            'pemasukan'=>$biaya,
            'kd_kar'=>$kd_kar,
            'tgl_pemasukan'=>date('Y-m-d',strtotime($tgl_trans)),
            'keterangan'=>$ket,
            'penanggung_jawab'=>$pj
        );
        $query = $this->db->insert('pemasukan', $array);
        return $query;
    }
    public function update($kd, $biaya, $tgl_trans, $ket, $pj){
        $array = array(
            'pemasukan'=>$biaya,
            'tgl_pemasukan'=>date('Y-m-d',strtotime($tgl_trans)),
            'keterangan'=>$ket,
            'penanggung_jawab'=>$pj
        );
        $this->db->where('kd_pemasukan', $kd);
        $query = $this->db->update('pemasukan', $array);
        return $query;
    }
   
    public function get_data($range, $par1, $par2){
        $wc="";
        if($range == "bulan"){
            
            $wc .= ("and DATE_FORMAT(p.tgl_pemasukan, '%m-%Y') =  '$par1' ");
        } else if($range=="jangka"){
            
            $wc .= ("and DATE_FORMAT(p.tgl_pemasukan,'%Y-%m-%d') >=  STR_TO_DATE('$par1', '%d-%m-%Y') and DATE_FORMAT(p.tgl_pemasukan,'%Y-%m-%d') <=  STR_TO_DATE('$par2', '%d-%m-%Y')");
        }
        $query= $this->db->query("select p.kd_pemasukan, p.pemasukan, DATE_FORMAT(p.tgl_pemasukan, '%d-%m-%Y') as tgl_pemasukan, k.nama as nama_kar, p.keterangan, p.penanggung_jawab
        from pemasukan p, karyawan k
        where p.kd_kar = k.kd_kar
        $wc " );
        return $query->result_array();
    }
    
    public function get_one_data($kd_pemasukan){
        $query = $this->db->select(" p.kd_pemasukan, p.pemasukan, DATE_FORMAT(p.tgl_pemasukan, '%d-%m-%Y') as tgl_pemasukan, p.keterangan, p.penanggung_jawab")
            ->from('pemasukan p')
            ->where('deleted','0')
            ->where('p.kd_pemasukan', $kd_pemasukan)
            ->get()
            ->row();
        return $query;
    }

}
?>
<?php
class Pengeluaran extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert($biaya, $tgl_trans, $kd_kar, $ket, $pj, $jenispengeluaran){
        $array = array(
            'pengeluaran'=>$biaya,
            'kd_kar'=>$kd_kar,
            'tgl_pengeluaran'=>date('Y-m-d',strtotime($tgl_trans)),
            'keterangan'=>$ket,
            'penanggung_jawab'=>$pj,
            'kd_jenispengeluaran' => $jenispengeluaran
        );
        $query = $this->db->insert('pengeluaran', $array);
        return $query;
    }
    public function update($kd, $biaya, $tgl_trans, $ket, $pj, $jenispengeluaran){
        $array = array(
            'pengeluaran'=>$biaya,
            'tgl_pengeluaran'=>date('Y-m-d',strtotime($tgl_trans)),
            'keterangan'=>$ket,
            'penanggung_jawab'=>$pj,
            'kd_jenispengeluaran' => $jenispengeluaran
        );
        $this->db->where('kd_pengeluaran', $kd);
        $query = $this->db->update('pengeluaran', $array);
        return $query;
    }
   
    public function get_data($range, $par1, $par2, $jenispengeluaran){
        $wc="";
        if($range == "bulan"){
            
            $wc .= ("and DATE_FORMAT(p.tgl_pengeluaran, '%m-%Y') =  '$par1' ");
        } else if($range=="jangka"){
            
            $wc .= ("and DATE_FORMAT(p.tgl_pengeluaran,'%Y-%m-%d') >=  STR_TO_DATE('$par1', '%d-%m-%Y') and DATE_FORMAT(p.tgl_pengeluaran,'%Y-%m-%d') <=  STR_TO_DATE('$par2', '%d-%m-%Y')");
        }
        if($jenispengeluaran != "all"){
            $wc .= (" and kd_jenispengeluaran = '". $jenispengeluaran ."'");
        }
        $query= $this->db->query("select p.kd_pengeluaran, p.pengeluaran, DATE_FORMAT(p.tgl_pengeluaran, '%d-%m-%Y') as tgl_pengeluaran, k.nama as nama_kar, p.keterangan, p.penanggung_jawab, jp.name
        from pengeluaran p, karyawan k, jenispengeluaran jp
        where p.kd_kar = k.kd_kar and jp.id = p.kd_jenispengeluaran
        $wc " );
        return $query->result_array();
    }

    public function get_total_pengeluaran($range, $par1, $par2, $jenispengeluaran){
        $wc="";
        if($range == "bulan"){

            $wc .= ("where DATE_FORMAT(p.tgl_pengeluaran, '%m-%Y') =  '$par1' ");
        } else if($range=="jangka"){

            $wc .= ("where DATE_FORMAT(p.tgl_pengeluaran,'%Y-%m-%d') >=  STR_TO_DATE('$par1', '%d-%m-%Y') and DATE_FORMAT(p.tgl_pengeluaran,'%Y-%m-%d') <=  STR_TO_DATE('$par2', '%d-%m-%Y')");
        }
        $query= $this->db->query("select sum(p.pengeluaran) as total_pengeluaran
        from pengeluaran p
        $wc " );
        return $query->row();
    }
    
    public function get_one_data($kd_pengeluaran){
        $query = $this->db->select(" p.kd_pengeluaran, p.pengeluaran, DATE_FORMAT(p.tgl_pengeluaran, '%d-%m-%Y') as tgl_pengeluaran, p.keterangan, p.penanggung_jawab, p.kd_jenispengeluaran")
            ->from('pengeluaran p')
            ->where('deleted','0')
            ->where('p.kd_pengeluaran', $kd_pengeluaran)
            ->get()
            ->row();
        return $query;
    }

}
?>
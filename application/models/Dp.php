<?php
class Dp extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert($data){
        $tgl_trans = date('Y-m-d');
        if ($data["is_transfer"] == null){$data["is_transfer"] = 0;}
        $query = array(
            'kd_trans' =>$data['kd_trans'],
            'tgl_trans'=> $tgl_trans,
            'bayar'=> $data['bayar_final'],
            'kd_kar'=> $data['kar_input'],
            'jatuh_tempo'=> date('Y-m-d',strtotime($data['jatuh_tempo'])),
            'tgl_trans'=> date('Y-m-d',strtotime($data['tgl_bayar'])),
            'deleted'=>0,
            'is_transfer' => $data['is_transfer'],
            'keterangan' => $data['keterangan']
        );

        $query = $this->db->insert('dp', $query);
        if($query == 1){
            return $this->get_kode($data);
        }else{
            return null;
        }
        
    }
    public function get_jumlah($kd_trans){
        $query = $this->db->select('count(*) as jumlah')
            ->where('kd_trans', $kd_trans)
            ->from('dp')
            ->get()
            ->row();
        return $query;
    }
    private function get_kode($data){
        $query = $this->db->select('*', 1)
                ->from('dp')
                ->where('kd_trans',$data['kd_trans'])
                ->where('bayar',$data['bayar_final'])
                ->where('kd_kar',$data['kar_input'])
                ->where('jatuh_tempo',date('Y-m-d',strtotime($data['jatuh_tempo'])))
                ->where('tgl_trans',date('Y-m-d',strtotime($data['tgl_bayar'])))
                ->where('deleted',0)
                ->order_by("updated","DESC")
                ->get()
                ->row();
        return $query;
    }
    public function grab_data($kd_nota){
        $query = $this->db->select('kd_nota, kd_trans, DATE_FORMAT(tgl_trans, "%d-%m-%Y") as tgl_trans, bayar, DATE_FORMAT(jatuh_tempo, "%d-%m-%Y") as jatuh_tempo, kd_kar, updated, deleted, is_transfer')
                ->from('dp')
                ->where('kd_nota',$kd_nota)
                ->where('deleted',0)
                ->get()
                ->row();
        return $query;
    }
    public function update_dp($kd_nota, $tgl_trans, $bayar, $jatuh_tempo, $is_transfer){
         $array = array(
            'tgl_trans' => date('Y-m-d',strtotime($tgl_trans)),
            'bayar' => $bayar,
            'jatuh_tempo' => date('Y-m-d',strtotime($jatuh_tempo)),
             'is_transfer' => $is_transfer
        );
        $this->db->where('kd_nota', $kd_nota);
        return $this->db->update('dp', $array);
    }
    public function get_last_code($kd_trans){
        $query = $this->db->select('kd_nota',1)
            ->from('dp')
            ->where('kd_trans', $kd_trans)
            ->order_by("tgl_trans", "desc")
            ->order_by("kd_nota", "desc")
            ->get()
            ->row();
        return $query;
    }
    public function get_jatuh_tempo($bulan, $tahun, $kavling){
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('GMT+7'));
        $wc = "";
        if($bulan != null && $tahun != null){
            $wc .= " DATE_FORMAT(dp.jatuh_tempo, '%m-%Y') = '$bulan-$tahun' ";
        } else if($bulan != null && $tahun == null){
            $wc .= " DATE_FORMAT(dp.jatuh_tempo, '%m') = '$bulan' ";
        } else if($bulan == null && $tahun != null){
            $wc .= " DATE_FORMAT(dp.jatuh_tempo, '%Y') = '$tahun' ";
        }
        if($kavling != null && $kavling != "all"){
            if ($wc != ""){$wc.= " and ";}
            $wc .= " blok.kd_blok = '$kavling' ";
        }
        if ($wc != ""){$wc = " and " . $wc;}
        $query = $this->db->query("select dp.kd_nota, dp.kd_trans, DATE_FORMAT(dp.tgl_trans, '%d-%m-%Y') as tgl_trans, dp.bayar, DATE_FORMAT(dp.jatuh_tempo, '%d-%m-%Y') as jatuh_tempo, dp.kd_kar, dp.updated, dp.deleted, dp.is_transfer, cust.nama as nama_cust, cust.alamat, 
        cust.telp, cust.telp2, cust.telp3, cust.kecamatan, cust.kelurahan, tr.cicilan, tr.dp_cicilan, kar.nama as nama_agen, blok.nama_blok, ta.nomor_tanah, ROUND(tr.dp/tr.dp_cicilan) as tunggakan,  (YEAR(now()) - YEAR(dp.jatuh_tempo)) * 12 + (MONTH(now()) - MONTH(dp.jatuh_tempo)) as bulan_telat
        from transaksi tr
        left join customer cust on tr.kd_cust = cust.kd_cust 
        left join tanah ta on ta.kd_tanah = tr.kd_tanah
        left join blok on blok.kd_blok = ta.kd_blok
        left join karyawan kar on kar.kd_kar = tr.kd_agen
        left join dp d on d.kd_nota = (
          select dp.kd_nota
          from dp 
          where dp.kd_trans = tr.kd_trans
          order by dp.jatuh_tempo desc, dp.kd_trans desc
          limit 1
        )
        left join dp on tr.kd_trans = dp.kd_trans and dp.kd_nota = d.kd_nota
        left join (select count(kd_nota) as jum, sum(bayar) as bayar, kd_trans from dp where dp.deleted = 0 group by kd_trans) jum_dp on jum_dp.kd_trans = tr.kd_trans
        where DATE_FORMAT(dp.jatuh_tempo, '%d-%m-%Y') < DATE_FORMAT(now(), '%d-%m-%Y') and ((jum_dp.jum < tr.dp_cicilan  and jum_dp.bayar < tr.dp) or ( jum_dp.jum = tr.dp_cicilan  and jum_dp.bayar < tr.dp))
        $wc");
        return $query->result_array();
    }
}
?>
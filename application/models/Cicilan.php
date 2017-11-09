<?php
class Cicilan extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function cek_detail_transaksi($kd_trans){
        $query = $this->db->select("i.kd_nota, i.kd_trans, DATE_FORMAT(i.tgl_trans, '%d-%m-%Y') as tgl_trans, i.bayar, i.denda, DATE_FORMAT(i.jatuh_tempo, '%d-%m-%Y') as jatuh_tempo, kar.kd_kar, kar.nama")
                ->from('cicilan i')
                ->join('karyawan kar', 'kar.kd_kar = i.kd_kar')
                ->where('kd_trans', $kd_trans)
                ->order_by("i.tgl_trans","ASC")
                ->order_by("i.updated","ASC")
                ->get()
                ->result_array();
            return $query;
    }
    public function insert($data){
        $tgl_trans = date('Y-m-d');
        if ($data["is_transfer"] == null){$data["is_transfer"] = 0;}
        $query = array(
            'kd_trans' =>$data['kd_trans'],
            'tgl_trans'=> date('Y-m-d',strtotime($data['tgl_bayar'])),
            'bayar'=> $data['bayar_final'],
            'jatuh_tempo'=> date('Y-m-d',strtotime($data['jatuh_tempo'])),
            'kd_kar'=>$data['kar_input'],
            'deleted'=>0,
            'denda'=>$data['denda'],
            'is_transfer' => $data['is_transfer'],
            'keterangan' => $data['keterangan']
        );
        $query = $this->db->insert('cicilan', $query);
        if($query == 1){
            return $this->get_kode($data);
        }else{
            return null;
        }
        
    }
    private function get_kode($data){
        $query = $this->db->select('*',1)
                ->from('cicilan')
                ->where('kd_trans',$data['kd_trans'])
                ->where('bayar',$data['bayar_final'])
                ->where('kd_kar',$data['kar_input'])
                ->where('tgl_trans',date('Y-m-d',strtotime($data['tgl_bayar'])))
                ->where('jatuh_tempo',date('Y-m-d',strtotime($data['jatuh_tempo'])))
                ->where('deleted',0)
                ->order_by("updated","DESC")
                ->get()
                ->row();
        return $query;
    }
    public function get_bayar($kd_trans){
        $query = $this->db->select('sum(bayar) as bayar')
                ->from('cicilan')
                ->where('kd_trans',$kd_trans)
                ->get()
                ->row();
        return $query;
    }
    public function get_denda($kd_trans){
        $query = $this->db->select('sum(denda) as denda')
                ->from('cicilan')
                ->where('kd_trans',$kd_trans)
                ->get()
                ->row();
        return $query;
    }
    public function get_latest_denda($kd_trans){
        $query = $this->db->select('denda',1)
                ->from('cicilan')
                ->where('kd_trans',$kd_trans)
                ->order_by("updated","DESC")
                ->get()
                ->row();
        return $query;
    }
    public function get_bayar_denda($kd_trans){
        $query = $this->db->select('sum(bayar_denda) as bayar_denda')
                ->from('cicilan')
                ->where('kd_trans',$kd_trans)
                ->get()
                ->row();
        return $query;
    }
    public function grab_data($kd_nota){
        $query = $this->db->select('kd_nota, kd_trans, denda, DATE_FORMAT(tgl_trans, "%d-%m-%Y") as tgl_trans, bayar, DATE_FORMAT(jatuh_tempo, "%d-%m-%Y") as jatuh_tempo, kd_kar, updated, deleted, is_transfer')
                ->from('cicilan')
                ->where('kd_nota',$kd_nota)
                ->where('deleted',0)
                ->get()
                ->row();
        return $query;
    }
    public function update_cicil($kd_nota, $tgl_trans, $bayar, $jatuh_tempo, $denda, $is_transfer){
         $array = array(
            'tgl_trans' => date('Y-m-d',strtotime($tgl_trans)),
            'bayar' => $bayar,
            'jatuh_tempo' => date('Y-m-d',strtotime($jatuh_tempo)),
            'denda' => $denda,
             'is_transfer' => $is_transfer
        );
        $this->db->where('kd_nota', $kd_nota);
        return $this->db->update('cicilan', $array);
    }
    public function get_last_code($kd_trans){
        $query = $this->db->select('kd_nota',1)
            ->from('cicilan')
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
        $wi = "";
        if($bulan != null && $tahun != null){
            $wc .= " DATE_FORMAT(dp.jatuh_tempo, '%m-%Y') = '$bulan-$tahun' ";
            $wi .= " DATE_FORMAT(cicilan.jatuh_tempo, '%m-%Y') = '$bulan-$tahun' ";
        } else if($bulan != null && $tahun == null){
            $wc .= " DATE_FORMAT(dp.jatuh_tempo, '%m') = '$bulan' ";
            $wi .= " DATE_FORMAT(cicilan.jatuh_tempo, '%m') = '$bulan' ";
        } else if($bulan == null && $tahun != null){
            $wc .= " DATE_FORMAT(dp.jatuh_tempo, '%Y') = '$tahun' ";
            $wi .= " DATE_FORMAT(cicilan.jatuh_tempo, '%Y') = '$tahun' ";
        }
        if($kavling != null && $kavling != "all"){
            if ($wc != ""){$wc.= " and ";}
            if ($wi != ""){$wi.= " and ";}
            $wc .= " blok.kd_blok = '$kavling' ";
            $wi .= " blok.kd_blok = '$kavling' ";
        }
        if ($wc != ""){$wc = " and " . $wc;}
        if ($wi != ""){$wi = " and " . $wi;}
        $query = $this->db->query("
        select dp.kd_nota, dp.kd_trans, DATE_FORMAT(dp.tgl_trans, '%d-%m-%Y') as tgl_trans, dp.bayar, DATE_FORMAT(dp.jatuh_tempo, '%d-%m-%Y') as jatuh_tempo, dp.kd_kar, dp.updated, dp.deleted, dp.is_transfer, cust.nama as nama_cust, cust.alamat, 
        cust.telp, cust.telp2, cust.telp3, cust.kecamatan, cust.kelurahan, tr.cicilan, tr.dp_cicilan, kar.nama as nama_agen, blok.nama_blok, ta.nomor_tanah, 0 as denda, ROUND(tr.dp/tr.dp_cicilan) as tunggakan,  (YEAR(now()) - YEAR(dp.jatuh_tempo)) * 12 + (MONTH(now()) - MONTH(dp.jatuh_tempo)) as bulan_telat
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
        left join (select count(kd_nota) as jum, kd_trans from cicilan where deleted = 0 group by kd_trans) cicilan on cicilan.kd_trans = tr.kd_trans
        where dp.jatuh_tempo < now() and jum_dp.jum = tr.dp_cicilan and cicilan.jum is null and jum_dp.bayar >= tr.dp
        $wc
        UNION 
        select cicilan.kd_nota, cicilan.kd_trans, DATE_FORMAT(cicilan.tgl_trans, '%d-%m-%Y') as tgl_trans, cicilan.bayar, DATE_FORMAT(cicilan.jatuh_tempo, '%d-%m-%Y') as jatuh_tempo, cicilan.kd_kar, cicilan.updated, cicilan.deleted, cicilan.is_transfer, cust.nama as nama_cust, cust.alamat, 
        cust.telp, cust.telp2, cust.telp3, cust.kecamatan, cust.kelurahan, tr.cicilan, tr.dp_cicilan, kar.nama as nama_agen, blok.nama_blok, ta.nomor_tanah, cil.denda, ROUND((tr.harga - tr.dp - tr.diskon)/tr.cicilan) as tunggakan,  (YEAR(now()) - YEAR(cicilan.jatuh_tempo)) * 12 + (MONTH(now()) - MONTH(cicilan.jatuh_tempo)) as bulan_telat
        from transaksi tr
        left join customer cust on tr.kd_cust = cust.kd_cust 
        left join tanah ta on ta.kd_tanah = tr.kd_tanah
        left join blok on blok.kd_blok = ta.kd_blok
        left join karyawan kar on kar.kd_kar = tr.kd_agen
        left join cicilan cil on cil.kd_nota = (
          select cicilan.kd_nota
          from cicilan 
          where cicilan.kd_trans = tr.kd_trans
          order by cicilan.jatuh_tempo desc, cicilan.kd_trans desc
          limit 1
        )
        left join cicilan on tr.kd_trans = cicilan.kd_trans and cicilan.kd_nota = cil.kd_nota
        left join (select count(kd_nota) as jum, sum(bayar) as bayar, sum(denda) as denda, kd_trans from cicilan where cicilan.deleted = 0 group by kd_trans) jum_cicilan on jum_cicilan.kd_trans = tr.kd_trans
        left join (select sum(bayar) as bayar, kd_trans from dp where deleted = 0 group by kd_trans  ) dp on dp.kd_trans = tr.kd_trans
        where cicilan.jatuh_tempo < now() and (jum_cicilan.jum <= tr.cicilan and jum_cicilan.bayar < tr.harga - tr.diskon + jum_cicilan.denda - dp.bayar)
        $wi");
        return $query->result_array();
    }
}
?>
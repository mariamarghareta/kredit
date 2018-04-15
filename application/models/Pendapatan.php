<?php
class Pendapatan extends CI_Model {

    
    public $kd_role;
    public $nama_role;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function detail_gabungan($tipe, $pilih, $range, $par1, $par2, $kav, $kd_kav){
        $wc="";
        $fr="";
        if($range == "bulan"){
            
            $wc .= (" DATE_FORMAT(g.tgl_trans, '%m-%Y') =  '$par1' ");
        } else if($range=="jangka"){
            
            $wc .= (" DATE_FORMAT(g.tgl_trans,'%Y-%m-%d') >=  STR_TO_DATE('$par1', '%d-%m-%Y') and DATE_FORMAT(g.tgl_trans,'%Y-%m-%d') <=  STR_TO_DATE('$par2', '%d-%m-%Y')");
        }
        if($kav == "kavling"){
            if($wc != ""){$wc.=" and ";}
            $fr = " left join transaksi t on t.kd_trans = g.kd_trans left join tanah ta on t.kd_tanah = ta.kd_tanah left join blok bl on ta.kd_blok = bl.kd_blok " ;
            $wc .= " bl.kd_blok = '$kd_kav' ";
        }
        if($tipe == "pilih"){
            $temp = explode(";", $pilih);
            
            $ctr = 0;
            foreach($temp as $row){
                if($row != ""){
                    if($ctr == 0 && $wc != ""){
                        $wc .= " and (";    
                    } else if($ctr >= 0 && $wc != ""){
                        $wc .= " or ";
                    } else if($wc == ""){
                        $wc .= "(";
                    }
                    $ctr++;
                    if($row == "cash"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'C' ");
                    } else if($row=="book"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'B' ");
                    }else if($row=="dp"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'D' ");
                    }else if($row=="cicilan"){
                        $wc .= (" substr(g.kd_nota,1,1) = 'I' ");
                    }else if($row=="balik"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'N' ");
                    }else if($row=="ppjb"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'P' ");
                    }else if($row=="lain"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'M' ");
                    }
                }
            }
            if($ctr>0){
                $wc .= ")";
            }
            
            
            
            
        }
        
        
        if($wc != ""){$wc = " where " . $wc;}
        $query= $this->db->query("select g.kd_trans, sum(g.bayar) as bayar, g.keterangan, g.is_transfer, g.catatan, case when k.nama is not null then k.nama else '-' end as nama_karyawan from pendapatan g left join transaksi tr on tr.kd_trans = g.kd_trans left join karyawan k on k.kd_kar = tr.kd_agen $fr $wc group by g.kd_trans order by g.kd_trans desc limit 70" );
        return $query->result_array();
    }  
    public function subdetail_gabungan($tipe, $pilih, $range, $par1, $par2, $kode, $kav, $kd_kav){
        $wc="";
        $fr = "";
        if($range == "bulan"){
            
            $wc .= (" DATE_FORMAT(g.tgl_trans, '%m-%Y') =  '$par1' ");
        } else if($range=="jangka"){
            
            $wc .= (" DATE_FORMAT(g.tgl_trans,'%Y-%m-%d') >=  STR_TO_DATE('$par1', '%d-%m-%Y') and DATE_FORMAT(g.tgl_trans,'%Y-%m-%d') <=  STR_TO_DATE('$par2', '%d-%m-%Y')");
        }
        if($kav == "kavling"){
            if($wc != ""){$wc.=" and ";}
            $fr = ", transaksi t, tanah ta, blok bl " ;
            $wc .= " g.kd_trans = t.kd_trans and t.kd_tanah = ta.kd_tanah and ta.kd_blok=bl.kd_blok and bl.kd_blok = '$kd_kav' ";
        }
        if($tipe == "pilih"){
            $temp = explode(";", $pilih);
            
            $ctr = 0;
            foreach($temp as $row){
                if($row != ""){
                    if($ctr == 0 && $wc != ""){
                        $wc .= " and (";    
                    } else if($ctr >= 0 && $wc != ""){
                        $wc .= " or ";
                    } else if($wc == ""){
                        $wc .= "(";
                    }
                    $ctr++;
                    if($row == "cash"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'C' ");
                    } else if($row=="book"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'B' ");
                    }else if($row=="dp"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'D' ");
                    }else if($row=="cicilan"){
                        $wc .= (" substr(g.kd_nota,1,1) = 'I' ");
                    }else if($row=="balik"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'N' ");
                    }else if($row=="ppjb"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'P' ");
                    }else if($row=="lain"){

                        $wc .= (" substr(g.kd_nota,1,1) = 'M' ");
                    }
                }
            }
            if($ctr > 0){
                $wc .= ")";
            }
        }
        
        
        if($wc != ""){$wc = " and " . $wc;}
        $query= $this->db->query("select DATE_FORMAT(g.tgl_trans, '%d-%m-%Y') as tgl_trans, g.kd_trans, g.kd_nota, g.bayar, g.keterangan, g.is_transfer, g.catatan, jenispemasukan.name
            from pendapatan g $fr 
            left join pemasukan on g.kd_nota = pemasukan.kd_pemasukan
            left join jenispemasukan on jenispemasukan.id = pemasukan.kd_jenispemasukan
            where g.kd_trans = '$kode' $wc order by g.tgl_trans" );
        return $query->result_array();
    }  
        

}
?>
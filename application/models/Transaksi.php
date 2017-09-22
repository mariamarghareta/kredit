<?php
class Transaksi extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert($data){
        if($data['cb_tipebayar'] == "cash"){
            $tipe = 0;
        }else if($data['cb_tipebayar'] == "booking"){
            $tipe = 1;
        }else if($data['cb_tipebayar'] == "cicilan"){
            $tipe = 2;
        }
        $newdata = array(
            'kd_cust' =>$data['hd_kode'],
            'kd_tanah'=> $data['cb_tanah'],
            'kd_tanah'=> $data['cb_tanah'],
            'kar_input'=> $data['kar_input'],
            'tipe'=> $data['tb_tipe'],
            'harga'=> $data['tb_harga'],
            'dp'=> $data['tb_cidp'],
            'dp_cicilan'=> $data['tb_ciberapabulan'],
            'diskon'=> $data['diskon_final'],
            'cicilan'=> $data['cicilan_final'],
            'status'=> 0,
            'tipe_bayar'=>  $tipe,
            'tgl_bayar'=> date('Y-m-d',strtotime($data['tgl_bayar'])),
            'updated'=> date('Y-m-d'),
            'deleted'=> "0",
            'baliknama' => $data['tb_bulanbaliknama'],
            'biayabaliknama' => $data['tb_biayabaliknama'],
            'kd_agen' => $data['cb_agen'],
        );

        $query = $this->db->insert('transaksi', $newdata);
        if($query == 1){
            return $this->grab_data_kodenama($data['cb_tanah']);
        }else{
            return null;
        }
    }
    public function grab_data_kodenama($kode){
        $query = $this->db->select('*')
                ->from('transaksi')
                ->where('kd_tanah',$kode)
                ->where('deleted',0)
                ->get();
        return $query->result_array();
    }
    public function grab_data_final($kode){
        
        $tabel = substr($kode,0,1);
        /*
        if($tabel == "C"){
            $query = $this->db->select('t.tipe_bayar')
                    ->from('transaksi t')
                    ->join('cash c', 'c.kd_trans = t.kd_trans')
                    ->where('c.kd_nota',$kode)
                    ->get()
                    ->row();
        }else if($tabel == "B"){
            $query = $this->db->select('t.tipe_bayar')
                    ->from('transaksi t')
                    ->join('booking b', 'b.kd_trans = t.kd_trans')
                    ->where('b.kd_nota',$kode)
                    ->get()
                    ->row();
        }else if($tabel == "D"){
            $query = $this->db->select('t.tipe_bayar')
                    ->from('transaksi t')
                    ->join('dp d', 'd.kd_trans = t.kd_trans')
                    ->where('d.kd_nota',$kode)
                    ->get()
                    ->row();
        }else if($tabel == "I"){
            $query = $this->db->select('t.tipe_bayar')
                    ->from('transaksi t')
                    ->join('cicilan i', 'i.kd_trans = t.kd_trans')
                    ->where('i.kd_nota',$kode)
                    ->get()
                    ->row();
        }else if($tabel == "N"){
            $query = $this->db->select('t.tipe_bayar')
                    ->from('transaksi t')
                    ->join('balik_nama bn', 'bn.kd_trans = t.kd_trans')
                    ->where('bn.kd_nota',$kode)
                    ->get()
                    ->row();
        }else if($tabel == "P"){
            $query = $this->db->select('t.tipe_bayar')
                    ->from('transaksi t')
                    ->join('ppjb p', 'p.kd_trans = t.kd_trans')
                    ->where('p.kd_nota',$kode)
                    ->get()
                    ->row();
        }
        if($query->tipe_bayar =="0" && $tabel != "P"){
            if($tabel == "C"){
                $finalquery = $this->db->select('t.*, c.tgl_trans, c.bayar, c.jatuh_tempo, c.kd_nota, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama')
                    ->from('transaksi t')
                    ->join('cash c', 'c.kd_trans = t.kd_trans')
                    ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                    ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                    ->join('blok b', 'b.kd_blok = tan.kd_blok')
                    ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                    ->where('c.kd_nota',$kode)
                    ->where('t.deleted',0)
                    ->get()
                    ->row();
                return $finalquery;
            }else if($tabel == "N"){
                $finalquery = $this->db->select('t.*, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama, bn.kd_nota, bn.tgl_trans as tgl_balik_nama')
                    ->from('transaksi t')
                    ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                    ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                    ->join('blok b', 'b.kd_blok = tan.kd_blok')
                    ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                    ->where('bn.kd_nota',$kode)
                    ->where('t.deleted',0)
                    ->get()
                    ->row();
                return $finalquery;
            }
        } else if (($query->tipe_bayar =="1" && $tabel != "P" )||($query->tipe_bayar =="2" && $tabel != "P")){
            if($tabel == "I"){
                $finalquery = $this->db->select('t.*, i.tgl_trans, i.bayar, i.denda, i.jatuh_tempo, i.kd_nota, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama')
                    ->from('transaksi t')
                    ->join('cicilan i', 'i.kd_trans = t.kd_trans')
                    ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                    ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                    ->join('blok b', 'b.kd_blok = tan.kd_blok')
                    ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                    ->where('i.kd_nota',$kode)
                    ->where('t.deleted',0)
                    ->get()
                    ->row();
                return $finalquery;
            }else if($tabel == "N"){
                $finalquery = $this->db->select('t.*, bn.kd_nota, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama, bn.tgl_trans as tgl_balik_nama')
                    ->from('transaksi t')
                    ->join('cicilan i', 'i.kd_trans = t.kd_trans', 'left')
                    ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                    ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                    ->join('blok b', 'b.kd_blok = tan.kd_blok')
                    ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                    ->where('bn.kd_nota',$kode)
                    ->where('t.deleted',0)
                    ->get()
                    ->row();
                return $finalquery;
            }else if($tabel == "B"){
                
                $finalquery = $this->db->select('t.*, book.kd_nota, book.tgl_trans, book.bayar, book.jatuh_tempo, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama, bn.tgl_trans as tgl_balik_nama')
                    ->from('transaksi t')
                    ->join('booking book', 'book.kd_trans = t.kd_trans')
                    ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                    ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                    ->join('blok b', 'b.kd_blok = tan.kd_blok')
                    ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                    ->where('book.kd_nota',$kode)
                    ->where('t.deleted',0)
                    ->get()
                    ->row();
                return $finalquery;
            }else{
                $finalquery = $this->db->select('t.*, d.tgl_trans, d.bayar , d.jatuh_tempo, d.kd_nota, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama')
                    ->from('transaksi t')
                    ->join('dp d', 'd.kd_trans = t.kd_trans')
                    ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                    ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                    ->join('blok b', 'b.kd_blok = tan.kd_blok')
                    ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                    ->where('d.kd_nota',$kode)
                    ->where('t.deleted',0)
                    ->get()
                    ->row();
                return $finalquery;
            }
            
        } 
        */
        if($tabel == "P"){
            
             $finalquery = $this->db->select('t.*, p.tgl_bayar as tgl_trans, k.nama as nama_kar, p.kd_nota, p.bayar , cus.nama, tan.nomor_tanah, b.nama_blok, k1.nama as nama_karyawan, p.is_transfer')
                    ->from('transaksi t')
                    ->join('ppjb p', 'p.kd_trans = t.kd_trans')
                    ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                    ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                    ->join('blok b', 'b.kd_blok = tan.kd_blok')
                    ->join('karyawan k', 'k.kd_kar = p.kar_jual')
                    ->join('karyawan k1', 'k1.kd_kar = p.kd_kar')
                    ->where('p.kd_nota',$kode)
                    ->where('t.deleted',0)
                    ->get()
                    ->row();
                return $finalquery;
        } else if($tabel == "C"){
            $finalquery = $this->db->select('t.*, c.tgl_trans, c.bayar, c.jatuh_tempo, c.kd_nota, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama, k.nama as nama_karyawan, c.is_transfer')
                ->from('transaksi t')
                ->join('cash c', 'c.kd_trans = t.kd_trans')
                ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                ->join('blok b', 'b.kd_blok = tan.kd_blok')
                ->join('karyawan k', 'k.kd_kar = c.kd_kar')
                ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                ->where('c.kd_nota',$kode)
                ->where('t.deleted',0)
                ->get()
                ->row();
            return $finalquery;
        }else if($tabel == "N"){
            $finalquery = $this->db->select('t.*, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama, bn.kd_nota, bn.tgl_trans as tgl_balik_nama, k.nama as nama_karyawan, bn.is_transfer')
                ->from('transaksi t')
                ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                ->join('blok b', 'b.kd_blok = tan.kd_blok')
                ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                ->join('karyawan k', 'k.kd_kar = bn.kd_kar')
                ->where('bn.kd_nota',$kode)
                ->where('t.deleted',0)
                ->get()
                ->row();
            return $finalquery;
        }else if($tabel == "I"){
            $finalquery = $this->db->select('t.*, i.tgl_trans, i.bayar, i.denda, i.jatuh_tempo, i.kd_nota, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama, k.nama as nama_karyawan, i.is_transfer')
                ->from('transaksi t')
                ->join('cicilan i', 'i.kd_trans = t.kd_trans')
                ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                ->join('blok b', 'b.kd_blok = tan.kd_blok')
                ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                ->join('karyawan k', 'k.kd_kar = i.kd_kar')
                ->where('i.kd_nota',$kode)
                ->where('t.deleted',0)
                ->get()
                ->row();
            return $finalquery;
        }else if($tabel == "B"){
                
            $finalquery = $this->db->select('t.*, book.kd_nota, book.tgl_trans, book.bayar, book.jatuh_tempo, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama, bn.tgl_trans as tgl_balik_nama, k.nama as nama_karyawan, book.is_transfer')
                ->from('transaksi t')
                ->join('booking book', 'book.kd_trans = t.kd_trans')
                ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                ->join('blok b', 'b.kd_blok = tan.kd_blok')
                ->join('karyawan k', 'k.kd_kar = book.kd_kar')
                ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                ->where('book.kd_nota',$kode)
                ->where('t.deleted',0)
                ->get()
                ->row();
            return $finalquery;
        }else if($tabel == "D"){
            $finalquery = $this->db->select('t.*, d.tgl_trans, d.bayar , d.jatuh_tempo, d.kd_nota, cus.nama, tan.nomor_tanah, b.nama_blok, ifnull(bn.bayar,0) as balik_nama, k.nama as nama_karyawan, d.is_transfer')
                ->from('transaksi t')
                ->join('dp d', 'd.kd_trans = t.kd_trans')
                ->join('customer cus', 'cus.kd_cust = t.kd_cust')
                ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
                ->join('blok b', 'b.kd_blok = tan.kd_blok')
                ->join('karyawan k', 'k.kd_kar = d.kd_kar')
                ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
                ->where('d.kd_nota',$kode)
                ->where('t.deleted',0)
                ->get()
                ->row();
            return $finalquery;
        }
    }
    public function cek_header_transaksi($kd_trans){
        
        $query = $this->db->select('t.*, c.*, b.nama_blok, b.kd_blok , ta.nomor_tanah, ta.kd_tanah , ifnull(bn.bayar,0) as balik_nama, bn.kd_nota as bn_kd_nota, kar.nama as bn_kar_nama, book.bayar as bayar_book, book.kd_nota as book_kd_nota, t.baliknama as cicilan_baliknama, t.biayabaliknama as besar_baliknama, agen.nama as nama_agen')
            ->from('transaksi t')
            ->join('customer c', 'c.kd_cust = t.kd_cust')
            ->join('tanah ta', 'ta.kd_tanah = t.kd_tanah')
            ->join('blok b', 'b.kd_blok = ta.kd_blok')
            ->join('balik_nama bn', 't.kd_trans = bn.kd_trans', 'left')
            ->join('karyawan kar','kar.kd_kar = bn.kd_kar', 'left')
            ->join('karyawan agen','agen.kd_kar = t.kd_agen', 'left')
            ->join('booking book','book.kd_trans = t.kd_trans', 'left')
            ->where('t.kd_trans', $kd_trans)
            ->where('t.deleted', 0)
            ->get()
            ->row();
        return $query;
        
    }
    public function cek_detail_transaksi($kd_trans, $tipe){
        
        if($tipe== 0){
            $query = $this->db->select("c.kd_nota, c.kd_trans, DATE_FORMAT(c.tgl_trans, '%d-%m-%Y') as tgl_trans, c.bayar, DATE_FORMAT(c.jatuh_tempo, '%d-%m-%Y') as jatuh_tempo, kar.kd_kar, kar.nama")
                ->from('cash c')
                ->join('karyawan kar', 'kar.kd_kar = c.kd_kar')
                ->where('kd_trans', $kd_trans)
                ->order_by("c.tgl_trans","asc")
                ->order_by("c.updated","asc")
                ->get()
                ->result_array();
            return $query;
        } else if($tipe == 1 || $tipe == 2){
            $query = $this->db->select("d.kd_nota, d.kd_trans, DATE_FORMAT(d.tgl_trans, '%d-%m-%Y') as tgl_trans, d.bayar, DATE_FORMAT(d.jatuh_tempo, '%d-%m-%Y') as jatuh_tempo, kar.kd_kar, kar.nama")
                ->from('dp d')
                ->join('karyawan kar', 'kar.kd_kar = d.kd_kar')
                ->where('kd_trans', $kd_trans)
                ->get()
                ->result_array();
            return $query;
        }
    }
    private function select_cash(){
        $finalquery = $this->db->select('t.*, c.tgl_trans, c.bayar, c.jatuh_tempo, c.kd_nota, cus.nama, tan.nomor_tanah, b.nama_blok')
            ->from('transaksi t')
            ->join('cash c', 'c.kd_trans = t.kd_trans')
            ->join('customer cus', 'cus.kd_cust = t.kd_cust')
            ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
            ->join('blok b', 'b.kd_blok = tan.kd_blok')
            ->where('c.kd_nota',$kode)
            ->where('t.deleted',0)
            ->get();
        return $finalquery;
    }
    public function update_booking($kd_trans, $dp, $cicilan_dp, $diskon , $angsuran){
        $query = array(
            'dp' =>$dp,
            'dp_cicilan'=> $cicilan_dp,
            'diskon'=>$diskon,
            'cicilan'=> $angsuran,
            'tipe_bayar'=> 2,
        );
        $this->db->where('kd_trans', $kd_trans);
        return $this->db->update('transaksi', $query);
    }
    public function get_ctr($kd_nota){
        $tabel = substr($kd_nota,0,1);
        $kd_trans = "";
        $tb = "";
        if($tabel == "C" || $tabel == "D" || $tabel == "I" || $tabel == "N"){
            if($tabel == "C"){
                $kd = $this->db->select('kd_trans')
                    ->from('cash')
                    ->where('kd_nota',$kd_nota)
                    ->get()
                    ->row();
                $tb="cash";
            }else if($tabel == "D"){
                 $kd = $this->db->select('kd_trans')
                    ->from('dp')
                    ->where('kd_nota',$kd_nota)
                    ->get()
                    ->row();
                $tb="dp";
            }else if($tabel == "I"){
                $kd = $this->db->select('kd_trans')
                    ->from('cicilan')
                    ->where('kd_nota',$kd_nota)
                    ->get()
                    ->row();
                $tb="cicilan";
            }else if($tabel == "N"){
                $kd = $this->db->select('kd_trans')
                    ->from('balik_nama')
                    ->where('kd_nota',$kd_nota)
                    ->get()
                    ->row();
                $tb="balik_nama";
            } 

            $query = $this->db->select('temp.jumlah')
                ->from("(
                SELECT @rn:=@rn+1 as jumlah, t.kd_nota
                from $tb t
                join (SELECT @rn := 0) x
                WHERE kd_trans = $kd->kd_trans
                order by t.tgl_trans asc
                ) temp")
                ->where('kd_nota',$kd_nota)

                ->get()
                ->row();

            return $query;
        } else{
            return false;
        }
        
    }
    public function total_dp($kd_trans){
        $query = $this->db->select('sum(bayar) as bayar')
            ->from('dp')
            ->where('kd_trans' , $kd_trans)
            ->get()
            ->row();
        return $query;
    }
    public function bayar_dp($kd_trans){
        $query = $this->db->select('dp')
            ->from('transaksi')
            ->where('kd_trans' , $kd_trans)
            ->get()
            ->row();
        return $query;
    }
    public function cek_lunas($kd_trans){
        $jenis = $this->db->select('*')
            ->from('transaksi')
            ->where('kd_trans' , $kd_trans)
            ->get()
            ->row();
        if($jenis->tipe_bayar == 0){
            $total_cash = $this->db->select('sum(bayar) as bayar')
                ->from('cash')
                ->where('kd_trans', $kd_trans)
                ->get()
                ->row();
            if($jenis->harga - $jenis->diskon - $total_cash->bayar <= 0){
                $array = array(
                    'status' => 1
                );
                $this->db->where('kd_trans', $kd_trans);
                return $this->db->update('transaksi', $array);
            }
        }else if($jenis->tipe_bayar == 1 || $jenis->tipe_bayar == 2){
            $total_dp = $this->db->select('sum(bayar) as bayar')
                ->from('dp')
                ->where('kd_trans', $kd_trans)
                ->get()
                ->row();
            $total_cicilan = $this->db->select('sum(bayar) as bayar, sum(denda) as denda')
                ->from('cicilan')
                ->where('kd_trans', $kd_trans)
                ->get()
                ->row();
            if($jenis->harga - $jenis->diskon - $total_dp->bayar -$total_cicilan->bayar + $total_cicilan->denda <= 0){
                $array = array(
                    'status' => 1
                );
                $this->db->where('kd_trans', $kd_trans);
                return $this->db->update('transaksi', $array);
            }
        }
    }
    public function search_kdtrans($nama){
        $query = $this->db->select('t.kd_trans, cus.nama, b.nama_blok, tan.nomor_tanah')
            ->from('transaksi t')
            ->join('customer cus', 'cus.kd_cust = t.kd_cust')
            ->join('tanah tan', 'tan.kd_tanah = t.kd_tanah')
            ->join('blok b', 'b.kd_blok = tan.kd_blok')
            ->where('t.deleted', 0)
            ->group_start()
                ->or_like('cus.nama',$nama)
                ->or_like('b.nama_blok',$nama)
                ->or_like('tan.nomor_tanah',$nama)
            ->group_end()
            ->get();
        
        return $query->result();
            
    }
    public function header_detail($range, $filter, $par1, $par2){
        //$query = $this->db->query("SELECT t.kd_trans, t.harga, t.diskon, bl.nama_blok, ta.nomor_tanah, ifnull(d.bayar,0) as dp, ifnull(c.bayar,0) as cash, ifnull(i.bayar,0) as cicilan, ifnull(i.denda,0) as denda from transaksi t LEFT JOIN (select kd_trans, sum(bayar) as bayar from dp GROUP BY kd_trans) d on d.kd_trans = t.kd_trans LEFT JOIN (select kd_trans, sum(bayar)as bayar from cash GROUP BY kd_trans) as c on c.kd_trans = t.kd_trans LEFT JOIN (SELECT kd_trans, sum(bayar) as bayar , sum(denda) as denda from cicilan GROUP by kd_trans ) as i on i.kd_trans = t.kd_trans LEFT JOIN tanah ta on ta.kd_tanah = t.kd_tanah LEFT JOIN blok bl on bl.kd_blok = ta.kd_blok");
        $wc = "";
        if($filter == "lunas"){
            $wc = ("(t.harga - t.diskon - ifnull(d.bayar,0) - ifnull(c.bayar,0) -ifnull(i.bayar,0) + ifnull(i.denda,0)) <= 0");
        } else if($filter == "blunas"){
            $wc = ("(t.harga - t.diskon - ifnull(d.bayar,0) - ifnull(c.bayar,0) -ifnull(i.bayar,0) + ifnull(i.denda,0))  > 0");
        } else if($filter == "jatuhtempo"){
            $wc = ("fingab.jatuh_tempo <  now() and (t.harga - t.diskon - ifnull(d.bayar,0) - ifnull(c.bayar,0) -ifnull(i.bayar,0) + ifnull(i.denda,0))  > 0");
        }
        
        if($range == "bulan"){
            if($wc != ""){ $wc = $wc . " and ";}
            $wc .= ("DATE_FORMAT(t.tgl_bayar, '%m-%Y') =  '$par1' ");
        } else if($range=="jangka"){
            if($wc != ""){ $wc = $wc . " and ";}
            $wc .= ("DATE_FORMAT(t.tgl_bayar,'%Y-%m-%d') >=  STR_TO_DATE('$par1', '%d-%m-%Y') and DATE_FORMAT(t.tgl_bayar,'%Y-%m-%d') <=  STR_TO_DATE('$par2', '%d-%m-%Y')");
        }
        
        if($wc != ""){$wc = "and " . $wc;}
        $query= $this->db->query("SELECT t.kd_trans, t.harga, t.diskon, bl.nama_blok, ta.nomor_tanah, ifnull(d.bayar,0) as dp, ifnull(c.bayar,0) as cash, ifnull(i.bayar,0) as cicilan, ifnull(i.denda,0) as denda, (t.harga - t.diskon - ifnull(d.bayar,0) - ifnull(c.bayar,0) -ifnull(i.bayar,0) + ifnull(i.denda,0)) as sisa ,DATE_FORMAT(fingab.jatuh_tempo, '%d-%m-%Y') as jatuh_tempo, cust.nama as nama_cust , cust.telp, cust.telp2, cust.telp3 , cust.alamat, cust.rt, cust.kelurahan, cust.kecamatan from transaksi t LEFT JOIN (select kd_trans, sum(bayar) as bayar from dp GROUP BY kd_trans) d on d.kd_trans = t.kd_trans LEFT JOIN (select kd_trans, sum(bayar)as bayar from cash GROUP BY kd_trans) as c on c.kd_trans = t.kd_trans LEFT JOIN (SELECT kd_trans, sum(bayar) as bayar , sum(denda) as denda from cicilan GROUP by kd_trans ) as i on i.kd_trans = t.kd_trans LEFT JOIN tanah ta on ta.kd_tanah = t.kd_tanah JOIN customer cust on cust.kd_cust = t.kd_cust LEFT JOIN blok bl on bl.kd_blok = ta.kd_blok left JOIN (select distinct gab.kd_trans, max(gab.jatuh_tempo) as jatuh_tempo from
(SELECT max(tgl_trans) as tgl_trans, kd_trans from gabungan GROUP BY kd_trans) temp, gabungan gab where gab.kd_trans = temp.kd_trans AND gab.tgl_trans = temp.tgl_trans GROUP BY gab.kd_trans) as fingab on fingab.kd_trans = t.kd_trans where t.deleted = 0 $wc order by fingab.jatuh_tempo" );
        return $query->result_array();
    }
    public function header_detail_onedata($kode){
        //$query = $this->db->query("SELECT t.kd_trans, t.harga, t.diskon, bl.nama_blok, ta.nomor_tanah, ifnull(d.bayar,0) as dp, ifnull(c.bayar,0) as cash, ifnull(i.bayar,0) as cicilan, ifnull(i.denda,0) as denda from transaksi t LEFT JOIN (select kd_trans, sum(bayar) as bayar from dp GROUP BY kd_trans) d on d.kd_trans = t.kd_trans LEFT JOIN (select kd_trans, sum(bayar)as bayar from cash GROUP BY kd_trans) as c on c.kd_trans = t.kd_trans LEFT JOIN (SELECT kd_trans, sum(bayar) as bayar , sum(denda) as denda from cicilan GROUP by kd_trans ) as i on i.kd_trans = t.kd_trans LEFT JOIN tanah ta on ta.kd_tanah = t.kd_tanah LEFT JOIN blok bl on bl.kd_blok = ta.kd_blok where t.kd_trans = $kode");
        $query = $this->db->query("SELECT t.kd_trans, t.harga, t.diskon, bl.nama_blok, ta.nomor_tanah, ifnull(d.bayar,0) as dp, ifnull(c.bayar,0) as cash, ifnull(i.bayar,0) as cicilan, ifnull(i.denda,0) as denda, (t.harga - t.diskon - ifnull(d.bayar,0) - ifnull(c.bayar,0) -ifnull(i.bayar,0) + ifnull(i.denda,0)) as sisa ,DATE_FORMAT(fingab.jatuh_tempo, '%d-%m-%Y') as jatuh_tempo, cust.nama as nama_cust , cust.telp, cust.telp2, cust.telp3 , cust.alamat, cust.rt, cust.kelurahan, cust.kecamatan from transaksi t LEFT JOIN (select kd_trans, sum(bayar) as bayar from dp GROUP BY kd_trans) d on d.kd_trans = t.kd_trans LEFT JOIN (select kd_trans, sum(bayar)as bayar from cash GROUP BY kd_trans) as c on c.kd_trans = t.kd_trans LEFT JOIN (SELECT kd_trans, sum(bayar) as bayar , sum(denda) as denda from cicilan GROUP by kd_trans ) as i on i.kd_trans = t.kd_trans LEFT JOIN tanah ta on ta.kd_tanah = t.kd_tanah JOIN customer cust on cust.kd_cust = t.kd_cust LEFT JOIN blok bl on bl.kd_blok = ta.kd_blok left JOIN (select distinct gab.kd_trans, max(gab.jatuh_tempo) as jatuh_tempo from
(SELECT max(tgl_trans) as tgl_trans, kd_trans from gabungan GROUP BY kd_trans) temp, gabungan gab where gab.kd_trans = temp.kd_trans AND gab.tgl_trans = temp.tgl_trans GROUP BY gab.kd_trans) as fingab on fingab.kd_trans = t.kd_trans where t.kd_trans = $kode and t.deleted=0");
        return $query->row();
    }
    
    public function detail_tanah($range, $filter, $par1, $par2){
        $wc = "";
        if($filter == "jual"){
            $wc = ("t.kd_trans is not null");
        } else if($filter == "bjual"){
            $wc = ("t.kd_trans is null");
        } 
        
        if($range == "bulan"){
            if($wc != ""){ $wc = $wc . " and ";}
            $wc .= ("DATE_FORMAT(t.tgl_bayar, '%m-%Y') =  '$par1' ");
        } else if($range=="jangka"){
            if($wc != ""){ $wc = $wc . " and ";}
            $wc .= ("DATE_FORMAT(t.tgl_bayar,'%Y-%m-%d') >=  STR_TO_DATE('$par1', '%d-%m-%Y') and DATE_FORMAT(t.tgl_bayar,'%Y-%m-%d') <=  STR_TO_DATE('$par2', '%d-%m-%Y')");
        }
        
        if($wc != ""){$wc = "where " . $wc;}
        $query= $this->db->query("select * from 
        (select null as kd_trans, null as tgl_bayar, bl.nama_blok, ta.nomor_tanah
        from blok bl, tanah ta
        WHERE bl.kd_blok = ta.kd_blok and ta.kd_tanah not in (select kd_tanah from transaksi WHERE deleted = 0) and bl.deleted = 0
        union 
        select t.kd_trans, t.tgl_bayar, bl.nama_blok, ta.nomor_tanah
        from transaksi t, tanah ta, blok bl
        WHERE t.kd_tanah = ta.kd_tanah and ta.kd_blok = bl.kd_blok and t.deleted = 0)
        as t $wc order by t.tgl_bayar" );
        return $query->result_array();
    }
    public function get_jatuhtempo($kode){
        $query = $this->db->query("
            SELECT temp.updated, DATE_FORMAT(temp.jatuh_tempo, '%d-%m-%Y') as jatuh_tempo FROM(
            select jatuh_tempo, updated
            from dp
            WHERE updated =
            (select max(updated) from dp where kd_trans = $kode)
            UNION
            select jatuh_tempo, updated
            from cicilan
            WHERE updated =
            (select max(updated) from cicilan where kd_trans = $kode)
            UNION
            select jatuh_tempo, updated
            from booking
            WHERE updated =
            (select max(updated) from booking where kd_trans = $kode)
            UNION
            select jatuh_tempo, updated
            from cash
            WHERE updated =
            (select max(updated) from cash where kd_trans = $kode)) as temp ORDER BY temp.updated desc LIMIT 1");
        return $query->row();
    }
    public function update_header($old, $kd_cust, $kd_tanah, $tipe, $harga, $dp, $dp_cicilan, $diskon, $cicilan, $tipe_bayar, $cicilanbaliknama, $biayabaliknama){
        $array = array(
            'kd_tanah' => $kd_tanah,
            'kd_cust' => $kd_cust,
            'tipe' => $tipe,
            'harga' => $harga,
            'dp' => $dp,
            'dp_cicilan' => $dp_cicilan,
            'diskon' => $diskon,
            'cicilan' => $cicilan,
            'tipe_bayar' => $tipe_bayar,
            'baliknama' => $cicilanbaliknama,
            'biayabaliknama' => $biayabaliknama
        );
        $this->db->where('kd_trans', $old->kd_trans);
        return $this->db->update('transaksi', $array);
    }
    public function update_cash($kd_trans, $diskon, $cicilan){
        $array = array(
            'diskon' => $diskon,
            'cicilan' => $cicilan,
            'tipe_bayar' => 0
            
        );
        $this->db->where('kd_trans', $kd_trans);
        return $this->db->update('transaksi', $array);
    }
    public function hapus_transaksi($kd_trans){
        $array = array(
            'deleted' => 1
            
        );
        $this->db->where('kd_trans', $kd_trans);
        return $this->db->update('transaksi', $array);
    }
    public function get_tipe_bayar($kode){
        $query = $this->db->select("tipe_bayar")
            ->from('transaksi')
            ->where('kd_trans', $kode)
            ->get()
            ->row();
        return $query;
    }
}
?>
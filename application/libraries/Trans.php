<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trans {
    
    
      
    var $kd_trans;
    var $nama_blok;
    var $nomor_tanah;
    var $dp;
    var $cash;
    var $cicilan;
    var $denda;
    var $status;
    var $paydenda; //denda yang dibayarkan bulan itu
    var $jatuh_tempo;
    var $nama;
    var $telp;
    var $telp2;
    var $telp3;
    var $alamat;
    var $rt;
    var $kecamatan;
    var $kelurahan;
    public function baru($kd, $nama, $nomor, $d, $c, $i, $de, $stat, $pd, $jt, $nm, $tel, $tel2, $tel3, $al, $r, $kec, $kel){
        $this->kd_trans = $kd;
        $this->nama_blok = $nama;
        $this->nomor_tanah = $nomor;
        $this->dp = $d;
        $this->cash = $c;
        $this->cicilan = $i;
        $this->denda = $de;
        $this->status = $stat;
        $this->paydenda = $pd;
        
        $this->jatuh_tempo = $jt;
        $this->nama = $nm;
        $this->telp = $tel;
        $this->telp2 = $tel2;
        $this->telp3 = $tel3;
        
        $this->alamat = $al;
        $this->rt = $r;
        $this->kecamatan = $kec;
        $this->kelurahan = $kel;
    }
    
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masteradmin extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('trans');
        $this->load->model('Timeout');
        $this->load->model('Transaksi');
        $this->load->model('Cicilan');
    }
    private $data;
	public function index()
	{
        $this->check_role();
        $this->clear();
        
        $hasil = $this->Transaksi->header_detail("tgl_all","all","","");
        $this->show_data($hasil);
        
        $this->show();
	}
    public function check_role(){
        if(isset($_SESSION['kd_role'])){
            if($_SESSION['kd_role'] != "RL001" && $_SESSION['kd_role'] != "RL002" && $_SESSION['kd_role'] != "RL003"){
                session_destroy();
                redirect('Welcome');
            }else{
                $newdata = array(
                        'kd_role'  => $_SESSION['kd_role'],
                        'uname'     => $_SESSION['uname'],
                        'kd_kar' => $_SESSION['kd_kar']
                );
                $this->session->set_tempdata($newdata, NULL, $this->Timeout->get_time()->lama);
            }
        } else {
            session_destroy();
            redirect('Welcome');
        }
    }
    public function clear(){
        $this->data['mulai']="";
        $this->data['akhir']="";
        $this->data['show_range']="none";
        $this->data['show_bulan']="none";
        $this->data['header']=null;
        $this->data['filter'] = "all";
        $this->data['range'] = "tgl_all";
        $this->data['bulan'] = "tgl_all";
    }
    public function show(){
        
        $this->load->view('data_tanah', $this->data);
    }
    public function show_data($hasil){
        
        if(sizeof($hasil) > 0){
            foreach($hasil as $row){
                $obj = new Trans();
                //$tgl = $this->Transaksi->get_jatuhtempo($row['kd_trans'])->jatuh_tempo;
                //$sisa = $row['harga'] - $row['diskon'] + $row['denda'] - $row['dp'] - $row['cicilan'] - $row['cash'];
                if($row['sisa'] <= 0){
                    $status = 1;
                } else {
                    $status = 0;
                }
                $tipebayar = $this->Transaksi->get_tipe_bayar($row['kd_trans']);
                $denda = 0;
                if($tipebayar->tipe_bayar == 2){
                    $denda = $this->Cicilan->get_latest_denda($row['kd_trans']);
                    if(sizeof($denda) > 0){
                        $denda = $denda->denda;
                    }
                }
                $obj->baru($row['kd_trans'], $row['nama_blok'], $row['nomor_tanah'],$row['dp'], $row['cash'], $row['cicilan'], $row['denda'], $status, $denda, $row['jatuh_tempo'], $row['nama_cust'], $row['telp'], $row['telp2'],$row['telp3'], $row['alamat'], $row['rt'],$row['kecamatan'], $row['kelurahan']);
                $this->data['header'][$row['kd_trans']] = $obj;
            }
        }
        
        
           
    }
    public function search(){
        $this->check_role();
        $this->clear();
        $this->data['filter'] = $this->input->post('filter');
        $this->data['range'] = $this->input->post('range');
        
        if($this->data['range'] == "bulan"){
            $this->data['bulan'] = $this->input->post('bulan');
            $this->data['tahun'] = $this->input->post('tahun');
            //echo $this->data['bulan'];
            $hasil = $this->Transaksi->header_detail($this->data['range'], $this->data['filter'], $this->data['bulan']."-".$this->data['tahun'],"");
        }else if($this->data['range'] == "jangka"){
            $this->data['mulai'] = $this->input->post('mulai');
            $this->data['akhir'] = $this->input->post('akhir');

            $hasil = $this->Transaksi->header_detail($this->data['range'], $this->data['filter'], $this->data['mulai'],$this->data['akhir']);
        }else{
            $hasil = $this->Transaksi->header_detail($this->data['range'],$this->data['filter'],"","");
        }
        
        $this->show_data($hasil);
        $this->show();
       
        
        
        
        
        
        
    }
    public function print_laporan(){
        $this->check_role();
        $this->clear();
        $this->data['filter'] = $this->input->post('filter');
        $this->data['range'] = $this->input->post('range');
        
        if($this->data['range'] == "bulan"){
            $this->data['bulan'] = $this->input->post('bulan');
            $this->data['tahun'] = $this->input->post('tahun');
            //echo $this->data['bulan'];
            $hasil = $this->Transaksi->header_detail($this->data['range'], $this->data['filter'], $this->data['bulan']."-".$this->data['tahun'],"");
        }else if($this->data['range'] == "jangka"){
            $this->data['mulai'] = $this->input->post('mulai');
            $this->data['akhir'] = $this->input->post('akhir');

            $hasil = $this->Transaksi->header_detail($this->data['range'], $this->data['filter'], $this->data['mulai'],$this->data['akhir']);
        }else{
            $hasil = $this->Transaksi->header_detail($this->data['range'],$this->data['filter'],"","");
        }
      
        $this->show_data($hasil);
        $this->load->view('laporantransaksi', $this->data);
       
        
    }
    public function lihat_detail(){
        //echo $this->input->post('kd_trans');
        $array = array(
            'master' => $this->input->post('kd_trans')
        );
        $this->session->set_tempdata($array, NULL, 300);
        redirect('Transaksimaster/cek_nota');
    }
    public function logout(){
        session_destroy();
        redirect('Welcome');
        //echo "log out";
    }
}

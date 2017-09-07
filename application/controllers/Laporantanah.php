<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporantanah extends CI_Controller {
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
    }
    private $data;
	public function index()
	{
        $this->check_role();
        $this->clear();
        
        $this->data['arr'] = $this->Transaksi->detail_tanah("tgl_all","all","","");
        //$this->show_data($hasil);
        
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
        $this->data['bulan'] = "";
    }
    public function show(){
        
        $this->load->view('laporantanah', $this->data);
    }
    /*public function show_data($hasil){
        
        if(sizeof($hasil) > 0){
            foreach($hasil as $row){
                $obj = new Trans();
                //$tgl = $this->Transaksi->get_jatuhtempo($row['kd_trans'])->jatuh_tempo;
                //$sisa = $row['harga'] - $row['diskon'] + $row['denda'] - $row['dp'] - $row['cicilan'] - $row['cash'];
                
                $obj->baru($row['kd_trans'], $row['nama_blok'], $row['nomor_tanah'],$row['dp'], $row['cash'], $row['cicilan'], $row['denda'], $status, $row['jatuh_tempo'], $row['nama_cust'], $row['telp'], $row['alamat'], $row['rt'],$row['kecamatan'], $row['kelurahan']);
                $this->data['header'][$row['kd_trans']] = $obj;
            }
        }
        
        
           
    }*/
    public function search(){
        $this->check_role();
        $this->clear();
        $this->data['filter'] = $this->input->post('filter');
        $this->data['range'] = $this->input->post('range');
        
        if($this->data['range'] == "bulan"){
            $this->data['bulan'] = $this->input->post('bulan');
            $this->data['tahun'] = $this->input->post('tahun');
            //echo $this->data['bulan'];
            $this->data['arr'] = $this->Transaksi->detail_tanah($this->data['range'], $this->data['filter'], $this->data['bulan']."-".$this->data['tahun'],"");
        }else if($this->data['range'] == "jangka"){
            $this->data['mulai'] = $this->input->post('mulai');
            $this->data['akhir'] = $this->input->post('akhir');

            $this->data['arr'] = $this->Transaksi->detail_tanah($this->data['range'], $this->data['filter'], $this->data['mulai'],$this->data['akhir']);
        }else{
            $this->data['arr'] = $this->Transaksi->detail_tanah($this->data['range'],$this->data['filter'],"","");
        }
       
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
            $this->data['arr'] = $this->Transaksi->detail_tanah($this->data['range'], $this->data['filter'], $this->data['bulan']."-".$this->data['tahun'],"");
        }else if($this->data['range'] == "jangka"){
            $this->data['mulai'] = $this->input->post('mulai');
            $this->data['akhir'] = $this->input->post('akhir');

            $this->data['arr'] = $this->Transaksi->detail_tanah($this->data['range'], $this->data['filter'], $this->data['mulai'],$this->data['akhir']);
        }else{
            $this->data['arr'] = $this->Transaksi->detail_tanah($this->data['range'],$this->data['filter'],"","");
        }
        
        $this->load->view('laporantanahterjual', $this->data);
       
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

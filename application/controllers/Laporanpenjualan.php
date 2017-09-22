<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpenjualan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('trans');
        $this->load->model('Timeout');
        $this->load->model('Pendapatan');
        $this->load->model('Blok');
    }
    private $data;
	public function index()
	{
        $this->check_role();
        $this->clear();
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('GMT+7'));
                                    
        //$this->data['arr'] = $this->Pendapatan->detail_gabungan("all", "" , "bulan",$date->format("m") ."-".$date->format("Y"),"", "kav_all","");
        //$this->get_subdetail("all", "" , "bulan",$date->format("m") ."-".$date->format("Y"),"","kav_all", "");
        //$this->show_data($hasil);
        
        $this->show();
	}
    public function check_role(){
        if(isset($_SESSION['kd_role'])){
            if($_SESSION['kd_role'] != "RL001" && $_SESSION['kd_role'] != "RL003"){
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
        $this->data['show_pilih']="none";
        $this->data['show_kav']="none";
        $this->data['header']=null;
        $this->data['filter'] = "all";
        $this->data['range'] = "bulan";
        $this->data['pilih'] = "all";
        $this->data['cbpilih'] = null;
        $this->data['tipe'] = "all";
        $this->data['kavling'] = $this->Blok->show_all();
        $this->data['select_kav'] = null;
        $this->data['kav'] = null;
        
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('GMT+7'));
        $this->data['bulan'] = $date->format("m");
        $this->data['tahun'] = $date->format("Y");
        $this->data['detail'] = null;
    }
    public function show(){
        
        $this->load->view('laporanpenjualan', $this->data);
    }
 
    public function search(){
        $this->check_role();
        $this->clear();
        $this->data['range'] = $this->input->post('range');
        $this->data['cbpilih'] = $this->input->post('cbpilih');
        $this->data['tipe'] = $this->input->post('tipe');
        $this->data['kav'] = $this->input->post('kav');
        $this->data['select_kav'] = $this->input->post('select_kav');
        $temp = "";
        if(sizeof($this->data['cbpilih']) > 0){
            foreach($this->data['cbpilih'] as $item){
                $temp .= $item . ";";
            }
         
        }
       
        if($this->data['range'] == "bulan"){
            $this->data['bulan'] = $this->input->post('bulan');
            $this->data['tahun'] = $this->input->post('tahun');
            //echo $this->data['bulan'];
            $this->data['arr'] = $this->Pendapatan->detail_gabungan($this->data['tipe'], $temp, $this->data['range'], $this->data['bulan']."-".$this->data['tahun'],"",$this->data['kav'], $this->data['select_kav']);
            $this->get_subdetail($this->data['tipe'], $temp, $this->data['range'], $this->data['bulan']."-".$this->data['tahun'],"",$this->data['kav'], $this->data['select_kav']);
            
        }else if($this->data['range'] == "jangka"){
            $this->data['mulai'] = $this->input->post('mulai');
            $this->data['akhir'] = $this->input->post('akhir');

            $this->data['arr'] = $this->Pendapatan->detail_gabungan($this->data['tipe'], $temp , $this->data['range'], $this->data['mulai'],$this->data['akhir'],$this->data['kav'], $this->data['select_kav']);
            $this->get_subdetail($this->data['tipe'], $temp , $this->data['range'], $this->data['mulai'],$this->data['akhir'],$this->data['kav'], $this->data['select_kav']);
            
        }else if($this->data['range'] == "tgl_all"){
            $this->data['arr'] = $this->Pendapatan->detail_gabungan($this->data['tipe'], $temp, "tgl-all","","",$this->data['kav'], $this->data['select_kav']);
            $this->get_subdetail($this->data['tipe'], $temp, "tgl-all","","",$this->data['kav'], $this->data['select_kav']);
        }
        
        $this->show();
      
    }
    public function get_subdetail($tipe,$pilih, $range, $param1, $param2, $kav, $kd_kav){
        if($this->data['arr'] > 0){
            
            foreach($this->data['arr'] as $row){
                
                $this->data['detail'][$row['kd_trans']][0] = $row;
                $this->data['detail'][$row['kd_trans']][1] = $this->Pendapatan->subdetail_gabungan($tipe, $pilih, $range, $param1, $param2,$row['kd_trans'], $kav, $kd_kav);
               
            }
        }
    }
    public function print_laporan(){
        $this->check_role();
        $this->clear();
        $this->data['range'] = $this->input->post('range');
        $this->data['cbpilih'] = $this->input->post('cbpilih');
        $this->data['tipe'] = $this->input->post('tipe');
        $this->data['kav'] = $this->input->post('kav');
        $this->data['select_kav'] = $this->input->post('select_kav');
        $temp = "";
        if(sizeof($this->data['cbpilih']) > 0){
            foreach($this->data['cbpilih'] as $item){
                $temp .= $item . ";";
            }
         
        }
       
        if($this->data['range'] == "bulan"){
            $this->data['bulan'] = $this->input->post('bulan');
            $this->data['tahun'] = $this->input->post('tahun');
            //echo $this->data['bulan'];
            $this->data['arr'] = $this->Pendapatan->detail_gabungan($this->data['tipe'], $temp, $this->data['range'], $this->data['bulan']."-".$this->data['tahun'],"",$this->data['kav'], $this->data['select_kav']);
            $this->get_subdetail($this->data['tipe'], $temp, $this->data['range'], $this->data['bulan']."-".$this->data['tahun'],"",$this->data['kav'], $this->data['select_kav']);
            
        }else if($this->data['range'] == "jangka"){
            $this->data['mulai'] = $this->input->post('mulai');
            $this->data['akhir'] = $this->input->post('akhir');

            $this->data['arr'] = $this->Pendapatan->detail_gabungan($this->data['tipe'], $temp , $this->data['range'], $this->data['mulai'],$this->data['akhir'],$this->data['kav'], $this->data['select_kav']);
            $this->get_subdetail($this->data['tipe'], $temp , $this->data['range'], $this->data['mulai'],$this->data['akhir'],$this->data['kav'], $this->data['select_kav']);
            
        }else if($this->data['range'] == "tgl_all"){
            $this->data['arr'] = $this->Pendapatan->detail_gabungan($this->data['tipe'], $temp, "tgl-all","","",$this->data['kav'], $this->data['select_kav']);
            $this->get_subdetail($this->data['tipe'], $temp, "tgl-all","","",$this->data['kav'], $this->data['select_kav']);
        }
        
        $this->load->view('laporanpenjualanprint', $this->data);
       
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

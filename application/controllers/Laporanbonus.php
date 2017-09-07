<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanbonus extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('trans');
        $this->load->model('Timeout');
        $this->load->model('Ppjb');
    }
    private $data;
	public function index()
	{
        $this->check_role();
        $this->clear();
        
        $this->data['arr'] = $this->Ppjb->search("tgl-all","","");
        foreach($this->data['arr'] as $row){
            $this->data['detail'][$row['kar_jual']][0]=$row;
            $this->data['detail'][$row['kar_jual']][1]=$this->Ppjb->detail_karjual("tgl-all","","", $row['kar_jual']);
        }
        
        $this->show();
	}
    public function check_role(){
        if(isset($_SESSION['kd_role'])){
            if($_SESSION['kd_role'] != "RL001"){
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
        $this->data['detail']=null;
    }
    public function show(){
        
        $this->load->view('laporanbonus', $this->data);
    }
 
    public function search(){
        $this->check_role();
        $this->clear();
        $this->data['range'] = $this->input->post('range');
        
        if($this->data['range'] == "bulan"){
            $this->data['bulan'] = $this->input->post('bulan');
            $this->data['tahun'] = $this->input->post('tahun');
            //echo $this->data['bulan'];
            $this->data['arr'] = $this->Ppjb->search($this->data['range'], $this->data['bulan']."-".$this->data['tahun'],"");
            
            foreach($this->data['arr'] as $row){
                $this->data['detail'][$row['kar_jual']][0]=$row;
                $this->data['detail'][$row['kar_jual']][1]=$this->Ppjb->detail_karjual($this->data['range'], $this->data['bulan']."-".$this->data['tahun'],"", $row['kar_jual']);
            }
        }else if($this->data['range'] == "jangka"){
            $this->data['mulai'] = $this->input->post('mulai');
            $this->data['akhir'] = $this->input->post('akhir');

            $this->data['arr'] = $this->Ppjb->search($this->data['range'], $this->data['mulai'],$this->data['akhir']);
            
            foreach($this->data['arr'] as $row){
                $this->data['detail'][$row['kar_jual']][0]=$row;
                $this->data['detail'][$row['kar_jual']][1]=$this->Ppjb->detail_karjual($this->data['range'], $this->data['mulai'],$this->data['akhir'], $row['kar_jual']);
            }
        }else{
            $this->data['arr'] = $this->Ppjb->search("tgl-all","","");
            foreach($this->data['arr'] as $row){
                $this->data['detail'][$row['kar_jual']][0]=$row;
                $this->data['detail'][$row['kar_jual']][1]=$this->Ppjb->detail_karjual("tgl-all","","", $row['kar_jual']);
            }
        }
        
        $this->show();
      
    }
    public function print_laporan(){
        $this->check_role();
        $this->clear();
        $this->data['range'] = $this->input->post('range');
        
        if($this->data['range'] == "bulan"){
            $this->data['bulan'] = $this->input->post('bulan');
            $this->data['tahun'] = $this->input->post('tahun');
            //echo $this->data['bulan'];
            $this->data['arr'] = $this->Ppjb->search($this->data['range'], $this->data['bulan']."-".$this->data['tahun'],"");
            
            foreach($this->data['arr'] as $row){
                $this->data['detail'][$row['kar_jual']][0]=$row;
                $this->data['detail'][$row['kar_jual']][1]=$this->Ppjb->detail_karjual($this->data['range'], $this->data['bulan']."-".$this->data['tahun'],"", $row['kar_jual']);
            }
        }else if($this->data['range'] == "jangka"){
            $this->data['mulai'] = $this->input->post('mulai');
            $this->data['akhir'] = $this->input->post('akhir');

            $this->data['arr'] = $this->Ppjb->search($this->data['range'], $this->data['mulai'],$this->data['akhir']);
            
            foreach($this->data['arr'] as $row){
                $this->data['detail'][$row['kar_jual']][0]=$row;
                $this->data['detail'][$row['kar_jual']][1]=$this->Ppjb->detail_karjual($this->data['range'], $this->data['mulai'],$this->data['akhir'], $row['kar_jual']);
            }
        }else{
            $this->data['arr'] = $this->Ppjb->search("tgl-all","","");
            foreach($this->data['arr'] as $row){
                $this->data['detail'][$row['kar_jual']][0]=$row;
                $this->data['detail'][$row['kar_jual']][1]=$this->Ppjb->detail_karjual("tgl-all","","", $row['kar_jual']);
            }
        }
        
        $this->load->view('laporanbonusprint', $this->data);
       
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

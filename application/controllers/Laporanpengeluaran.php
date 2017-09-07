<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpengeluaran extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Timeout');
        $this->load->model('Pengeluaran');
        $this->load->model('Jenispengeluaran');
    }
    private $data;
	public function index()
	{
        $this->check_role();
        $this->clear();
        
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('GMT+7'));
        $this->data['arr'] = $this->Pengeluaran->get_data("bulan", $date->format("m")."-".$date->format("Y"),"","all");
        
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
        $this->data['cb_jenis']="";
        
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('GMT+7'));
        $this->data['range']="bulan";
        $this->data['bulan']=$date->format("m");
    }
    public function show(){
        $this->data["jenispengeluaran"] = $this->Jenispengeluaran->show_all();
        $this->load->view('laporanpengeluaran', $this->data);
        
    }
    public function search(){
        $this->check_role();
        $this->clear();
        $this->data['range'] = $this->input->post('range');
        $this->data['bulan'] = $this->input->post('bulan');
        $this->data['tahun'] = $this->input->post('tahun');
        $this->data['mulai'] = $this->input->post('mulai');
        $this->data['akhir'] = $this->input->post('akhir');
        $this->data['cb_jenis'] = $this->input->post('cb_jenis');
        
        if($this->data['range'] == "bulan"){
            $this->data['bulan'] = $this->input->post('bulan');
            $this->data['tahun'] = $this->input->post('tahun');
            //echo $this->data['bulan'];
            $this->data['arr'] = $this->Pengeluaran->get_data($this->data['range'], $this->data['bulan']."-".$this->data['tahun'],"",$this->data['cb_jenis']);
        }else if($this->data['range'] == "jangka"){
            $this->data['mulai'] = $this->input->post('mulai');
            $this->data['akhir'] = $this->input->post('akhir');

            $this->data['arr'] = $this->Pengeluaran->get_data($this->data['range'], $this->data['mulai'],$this->data['akhir'],$this->data['cb_jenis']);
        }else if($this->data['range'] == "tgl_all"){
            $this->data['arr'] = $this->Pengeluaran->get_data("tgl-all","","",$this->data['cb_jenis']);
        }
       
        $this->show();
    }
    public function print_laporan(){
        $this->check_role();
        $this->clear();
        $this->data['range'] = $this->input->post('range');
        $this->data['bulan'] = $this->input->post('bulan');
        $this->data['tahun'] = $this->input->post('tahun');
        $this->data['mulai'] = $this->input->post('mulai');
        $this->data['akhir'] = $this->input->post('akhir');
        $this->data['cb_jenis'] = $this->input->post('cb_jenis');
        
        if($this->data['range'] == "bulan"){
            $this->data['bulan'] = $this->input->post('bulan');
            $this->data['tahun'] = $this->input->post('tahun');
            $this->data['arr'] = $this->Pengeluaran->get_data($this->data['range'], $this->data['bulan']."-".$this->data['tahun'],"",$this->data['cb_jenis']);
        }else if($this->data['range'] == "jangka"){
            $this->data['mulai'] = $this->input->post('mulai');
            $this->data['akhir'] = $this->input->post('akhir');

            $this->data['arr'] = $this->Pengeluaran->get_data($this->data['range'], $this->data['mulai'],$this->data['akhir'],$this->data['cb_jenis']);
        }else if($this->data['range'] == "tgl_all"){
            $this->data['arr'] = $this->Pengeluaran->get_data("tgl-all","","",$this->data['cb_jenis']);
        }
        
        $this->load->view('laporanpengeluaranprint', $this->data);
    }
    public function logout(){
        session_destroy();
        redirect('Welcome');
        //echo "log out";
    }
}

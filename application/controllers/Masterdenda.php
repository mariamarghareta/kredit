<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterdenda extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('trans');
        $this->load->model('Timeout');
        $this->load->model('Denda');
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
        $this->data['nominal']=$this->Denda->get_nominal()->nominal;
        $this->data['msg']="";
    }
    public function show(){

        $this->load->view('masterdenda', $this->data);
    }

    public function change(){
        $this->check_role();
        $this->clear();
        $this->data['nominal']= $this->input->post('nominal');


        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric', array('required'=>'Harus diisi', 'numeric' => 'Harus Berupa Angka'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if($this->form_validation->run() == TRUE){
            $hasil = $this->Denda->change_nominal($this->data['nominal']);
            if($hasil == 1){
                $this->clear();
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Update Berhasil</div>";
            }else {
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Update Gagal</div>";
            }
        }
        $this->show();
    }

    public function logout(){
        session_destroy();
        redirect('Welcome');
        //echo "log out";
    }
}

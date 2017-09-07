<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mastertime extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Timeout');
    }
    private $data;
	public function index()
	{
        $this->check_role();
        $this->clear();
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
        $this->data['time']=$this->Timeout->get_time()->lama;
        $this->data['msg']="";
    }
    public function show(){
        $this->load->view('master_time', $this->data);
    }
    public function change(){
        $this->check_role();
        $this->clear();
        $this->data['time']= $this->input->post('time');
        
        
        $this->form_validation->set_rules('time', 'Waktu', 'required|greater_than[0]', array('required'=>'Harus diisi', 'min_length' => 'Minimal 5 karakter'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if($this->form_validation->run() == TRUE){
            $hasil = $this->Timeout->change_time($this->data['time']);
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

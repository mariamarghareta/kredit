<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Changepass extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Timeout');
        $this->load->model('Karyawan');
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
        $this->data['old']="";
        $this->data['new']="";
        $this->data['renew']="";
        $this->data['msg']="";
    }
    public function show(){
        $this->load->view('masterpass', $this->data);
        
    }
    public function change(){
        $this->check_role();
        $this->clear();
        $this->data['old']= $this->input->post('old');
        $this->data['new']= $this->input->post('new');
        $this->data['renew']= $this->input->post('renew');
        
        $this->form_validation->set_rules('new', 'Passowrd', 'required|min_length[5]', array('required'=>'Harus diisi', 'min_length' => 'Minimal 5 karakter'));
        $this->form_validation->set_rules('renew', 'Password', 'required|matches[new]', array('required'=>'Harus diisi','matches' => 'Password tidak sama'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if($this->form_validation->run() == TRUE){
            $hasil = $this->Karyawan->change_pass($_SESSION['kd_kar'], $this->data['old'], $this->data['new']);
            if($hasil == 1){
                $this->clear();
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Update Berhasil</div>";
            } else if($hasil == 2){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Password Lama Salah</div>";
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

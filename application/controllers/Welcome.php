<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Karyawan');
        $this->load->model('Timeout');
    }
   
	public function index()
	{
        $data['err_msg']="";
        $this->load->view('welcome_message',$data);   
        
	}
    public function login()
    {
        
        $data['err_msg']="";
        if ($this->input->post('submit')==true) {
            $data['uname']=$this->input->post('uname');
            $data['pass']=$this->input->post('pass');
            
            
            $temp=$this->Karyawan->grab_data_login($data['uname'], $data['pass']);
            //echo $data['pass'];
            
            if(sizeof($temp) >= 1){
                if($temp[0]['kd_role']==null){
                    $data['err_msg']=
                        "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>
                        Username atau password salah
                        </div>";
                } else {
                    $role = $temp[0]['kd_role'];

                    if($role=="RL001"){
                        $this->session->set_tempdata($temp[0], NULL, $this->Timeout->get_time()->lama);
                        redirect('Transaksimaster');
                    } else if($role == "RL002"){
                        $this->session->set_tempdata($temp[0], NULL, $this->Timeout->get_time()->lama);
                        redirect('Transaksimaster');
                    } else if($role == "RL003"){
                        $this->session->set_tempdata($temp[0], NULL, $this->Timeout->get_time()->lama);
                        redirect('Transaksimaster');
                    }
                }
            }else{
                $data['err_msg']=
                        "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>
                        Username atau password salah
                        </div>";
                
            }
            
            
        }
       
        $this->load->view('welcome_message',$data);
    }
}

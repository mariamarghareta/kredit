<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mid extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Transaksi');
        $this->load->model('Timeout');
        $this->load->model('Cicilan');
        $this->load->model('Booking');
        $this->load->model('Karyawan');
        $this->load->model('Ppjb');
    }
    private $data;
	public function index()
	{
        $this->clear();
        $this->check_role();
        $this->show();
        
	}
    public function show(){
        $this->load->view('transaksimaster', $this->data);
    }
    
    public function clear(){
    
        
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
   
    public function print_nota_again(){
         if(isset($_SESSION['kd_role'])){
           
        } else {
            session_destroy();
            redirect('Welcome');
        }
        $this->data['kd_nota'] = $this->input->post('kd_nota');
        $this->data['obj'] = $this->Transaksi->grab_data_final($this->data['kd_nota']);
        $this->data['ctr'] = $this->Transaksi->get_ctr($this->data['kd_nota']);
        $this->load->view('nota', $this->data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mastercustomeradmin extends CI_Controller {
    private $data;
  
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Customer');
        $this->load->model('Timeout');
        $this->load->library('session');
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
	public function index()
	{
        $this->check_role();
        $this->clear();
        $this->show();
	}
    public function clear(){
        $this->data['show_insert']="";
        $this->data['show_update']="slhide";
        $this->data['show_delete']="slhide";
        $this->data['ktp']="";
        $this->data['nomor']="";
        $this->data['msg']="";
        $this->data['alamat']=""; 
        $this->data['rt']=""; 
        $this->data['kec']=""; 
        $this->data['kel']=""; 
        $this->data['telp']=""; 
        $this->data['telp2']=""; 
        $this->data['telp3']=""; 
        $this->data['tempat']=""; 
        $this->data['nama']=""; 
        $this->data['gen']=""; 
        $this->data['tanggal']=""; 
        $this->data['kd_cust']=""; 
    }
    private function show_update(){
        $this->data['show_insert']="slhide";
        $this->data['show_update']="slshow";
        $this->data['show_delete']="slhide";
    }
    public function show(){
        $this->data['cust'] = $this->Customer->show_all();
        $this->load->view('master-customer-admin', $this->data);
    }
    public function add_new_data(){
        $this->check_role();
        $this->clear();
        $this->form_validation->set_rules('ktp', 'Nomor KTP', 'required|numeric', array('required' => '%s harus diisi', 'numeric' => '%s harus berupa angka'));
        $this->form_validation->set_rules('nama', 'Nama', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('telp', 'Telepon', 'required|numeric', array('required' => '%s harus diisi' , 'numeric' => '%s harus berupa angka'));
        $this->form_validation->set_rules('telp2', 'Telepon', 'numeric', array('required' => '%s harus diisi' , 'numeric' => '%s harus berupa angka'));
        $this->form_validation->set_rules('telp3', 'Telepon', 'numeric', array('required' => '%s harus diisi' , 'numeric' => '%s harus berupa angka'));
        $this->form_validation->set_rules('tempat', 'Tempat Lahir', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('alamat', 'Alamat', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('rt', 'RT/RW', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('kel', 'Kelurahan', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('kec', 'Kecamatan', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        $this->data['ktp'] = $this->input->post('ktp');
        $this->data['nama'] = $this->input->post('nama');
        $this->data['telp'] = $this->input->post('telp');
        $this->data['telp2'] = $this->input->post('telp2');
        $this->data['telp3'] = $this->input->post('telp3');
        $this->data['tempat'] = $this->input->post('tempat');
        $this->data['tanggal'] = $this->input->post('tanggal');
        $this->data['alamat'] = $this->input->post('alamat');
        $this->data['rt'] = $this->input->post('rt');
        $this->data['kel'] = $this->input->post('kel');
        $this->data['kec'] = $this->input->post('kec');
        $this->data['gen'] = $this->input->post('gen');
        $this->data['kd_cust'] = $this->input->post('kd_cust');
        
        if ($this->form_validation->run() == FALSE)
		{
		} else {
            if($this->Customer->cek_kembar($this->data['ktp'], $this->data['kd_cust']) == false){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Data customer sudah ada</div>";
            } else {
                $result = $this->Customer->insert($this->data);
                if($result == 1){
                    $this->clear();
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Insert Berhasil</div>";
                }else{
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Insert Gagal</div>";
                }   
            }
        }
        $this->show();
    }
    public function edit_data(){
        $this->check_role();
        $this->clear();
        $this->data['kd_cust'] = $this->input->post('kd_cust');
        $query = $this->Customer->grab_data($this->data['kd_cust']);    
        $this->data=$query[0];
        $this->show_update();
        $this->data['msg']="";
        $this->show();
        
    }
    public function update_data(){
        $this->clear();
        $this->form_validation->set_rules('ktp', 'Nomor KTP', 'required|numeric', array('required' => '%s harus diisi', 'numeric' => '%s harus berupa angka'));
        $this->form_validation->set_rules('nama', 'Nama', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('telp', 'Telepon', 'required|numeric', array('required' => '%s harus diisi' , 'numeric' => '%s harus berupa angka'));
        $this->form_validation->set_rules('telp2', 'Telepon', 'numeric', array('required' => '%s harus diisi' , 'numeric' => '%s harus berupa angka'));
        $this->form_validation->set_rules('telp3', 'Telepon', 'numeric', array('required' => '%s harus diisi' , 'numeric' => '%s harus berupa angka'));
        $this->form_validation->set_rules('tempat', 'Tempat Lahir', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('alamat', 'Alamat', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('rt', 'RT/RW', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('kel', 'Kelurahan', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('kec', 'Kecamatan', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        $this->data['ktp'] = $this->input->post('ktp');
        $this->data['nama'] = $this->input->post('nama');
        $this->data['telp'] = $this->input->post('telp');
        $this->data['telp2'] = $this->input->post('telp2');
        $this->data['telp3'] = $this->input->post('telp3');
        $this->data['tempat'] = $this->input->post('tempat');
        $this->data['tanggal'] = $this->input->post('tanggal');
        $this->data['alamat'] = $this->input->post('alamat');
        $this->data['rt'] = $this->input->post('rt');
        $this->data['kel'] = $this->input->post('kel');
        $this->data['kec'] = $this->input->post('kec');
        $this->data['gen'] = $this->input->post('gen');
        $this->data['kd_cust'] = $this->input->post('kd_cust');
        
        if($this->input->post('cancel') == true){
            $this->index();
        } else{
             if ($this->form_validation->run() == TRUE){
                if($this->Customer->cek_kembar($this->data['ktp'], $this->data['kd_cust'])==FALSE){
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown text-center' style='display:none;'>Nomor ktp sudah ada</div>";
                    $this->show_update();
                    
                } else {
                    if($this->Customer->update_data($this->data) == 1){
                        $this->clear();
                        $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Update Berhasil</div>";
                    } else{
                        $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Update Gagal</div>";
                    }
                }
               
             }else {
                $this->show_update();
             }
            $this->show();
        }
    }
    private function show_delete(){
        $this->data['show_insert']="slhide";
        $this->data['show_delete']="slshow";
        $this->data['show_update']="slhide";
    }
    public function delete_data(){
        
        $this->check_role();
        $this->clear();
        $this->show_delete();
        $this->data['kd_cust'] = $this->input->post('kd_cust');
        
        $query = $this->Customer->grab_data($this->data['kd_cust']);   
        
        $this->data = $query[0];
        $this->data['msg']="";
        $this->show_delete();
        
        $this->show();
    }
    public function confirm_del(){
        $this->check_role();
        $this->clear();
        $this->data['kd_cust'] = $this->input->post('kd_cust');
        if($this->input->post('cancel') == true){
            $this->index();
        } else{
            if($this->Customer->delete_data($this->data['kd_cust']) == 1){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Hapus data berhasil</div>";
            } else{
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Hapus data gagal</div>";
            }
            $this->show();
        }
        
    }
     public function logout(){
        session_destroy();
        redirect('Welcome');
    }
}

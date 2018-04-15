<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterblok extends CI_Controller {
    private $data;
  
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Blok');
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
        $this->data['blok'] = $this->Blok->show_all();
        $this->load->view('master_tebar_bibit', $this->data);
	}
    public function clear(){
        $this->data['show_insert']="";
        $this->data['show_update']="";
        $this->data['show_delete']="";
        $this->data['tnama']="";
        $this->data['nama']="";
        $this->data['msg']="";
        $this->data['kd_blok']=""; 
        $this->data['nama_bl']=""; 
    }
    public function add_new_data(){
        $this->check_role();
        $this->clear();
        $this->form_validation->set_rules('tnama', 'Nama blok', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        
        $this->data['tnama'] = $this->input->post('tnama');
        if ($this->form_validation->run() == FALSE)
		{
		} else {
            if($this->Blok->cek_kembar($this->data['tnama']) == false){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Kode blok kembar</div>";
            } else {
                $result = $this->Blok->insert($this->data['tnama']);
                if($result == 1){
                    $this->data['tnama']="";
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Insert Berhasil</div>";
                }else{
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Insert Gagal</div>";
                }   
            }
        }
        $this->data['blok'] = $this->Blok->show_all();
        $this->load->view('master-blok', $this->data);
    }
    public function edit_data(){
        $this->check_role();
        $this->clear();
        $this->form_validation->set_rules('tnama', 'Nama blok', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        $this->data['show_insert']="slhide";
        $this->data['show_delete']="slhide";
        $this->data['show_update']="slshow";
        $this->data['kd_blok']=$this->input->post('kd_blok');
        
        
        $query = $this->Blok->grab_data($this->data['kd_blok']);    
        
        $this->data['nama_bl']=$query[0]['nama_blok'];
        
        $this->data['blok'] = $this->Blok->show_all();
        $this->load->view('master-blok', $this->data);
        
    }
    public function update_data(){
        $this->check_role();
        $this->clear();
        $this->form_validation->set_rules('nama_bl', 'Nama blok', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        $this->data['kd_blok'] = $this->input->post('kd_blok');
        $this->data['nama_bl'] = $this->input->post('nama_bl');
        if($this->input->post('cancel') == true){
            $this->index();
        } else{
             if ($this->form_validation->run() == TRUE){
                if($this->Blok->cek_kembar($this->data['nama_bl']) == false){
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Kode blok kembar</div>";
                    $this->data['show_insert']="slhide";
                    $this->data['show_delete']="slhide";
                    $this->data['show_update']="slshow";
                } else {
                    if($this->Blok->update_data($this->data['kd_blok'], $this->data['nama_bl']) == 1){
                        $this->data['nama_bl'] = "";
                        $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Update Berhasil</div>";
                    } else{
                        $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Update Gagal</div>";
                    }
                }
               
             }else {
                $this->data['show_insert']="slhide";
                $this->data['show_delete']="slhide";
                $this->data['show_update']="slshow";
             }
            $this->data['blok'] = $this->Blok->show_all();
            $this->load->view('master-blok', $this->data);
        }
    }
    public function delete_data(){
        $this->check_role();
        $this->clear();
        $this->data['show_insert']="slhide";
        $this->data['show_delete']="slshow";
        $this->data['show_update']="slhide";
        $this->data['kd_blok'] = $this->input->post('kd_blok');
        $query = $this->Blok->grab_data($this->data['kd_blok']);   
        $this->data['nama_bl']=$query[0]['nama_blok'];
        
        $this->data['blok'] = $this->Blok->show_all();
        $this->load->view('master-blok', $this->data);
    }
    public function confirm_del(){
        $this->check_role();
        $this->clear();
        $this->data['kd_blok'] = $this->input->post('kd_blok');
        if($this->input->post('cancel') == true){
            $this->index();
        } else{
            if($this->Blok->delete_data($this->data['kd_blok']) == 1){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Hapus data berhasil</div>";
            } else{
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Hapus data gagal</div>";
            }
            $this->data['blok'] = $this->Blok->show_all();
            $this->load->view('master-blok', $this->data);
        }
        
    }
    public function logout(){
        session_destroy();
        redirect('Welcome');
    }
}

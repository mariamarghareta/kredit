<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mastertanah extends CI_Controller {
    private $data;
  
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Tanah');
        $this->load->model('Timeout');
        $this->load->model('Blok');
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
        $this->data['tanah'] = $this->Tanah->show_all();
        $this->load->view('master-tanah', $this->data);
	}
    public function clear(){
        $this->data['show_insert']="";
        $this->data['show_update']="";
        $this->data['show_delete']="";
        $this->data['nomor']="";
        $this->data['nama']="";
        $this->data['msg']="";
        $this->data['kd_blok']=""; 
        $this->data['kd_tanah']=""; 
        $this->data['upnomor']=""; 
        $this->data['nama_blok']=""; 
        $this->data['nomor_tanah']=""; 
    }
    public function show(){
        $this->data['blok'] = $this->Blok->show_all();
        $this->data['tanah'] = $this->Tanah->show_all();
        $this->load->view('master-tanah', $this->data);
    }
    public function add_new_data(){
        $this->check_role();
        $this->clear();
        $this->form_validation->set_rules('nomor', 'Nomor tanah', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        $this->data['tblok'] = $this->input->post('cblok');
        $this->data['nomor'] = $this->input->post('nomor');
        if ($this->form_validation->run() == FALSE)
		{
		} else {
            if($this->Tanah->cek_kembar($this->data['tblok'], $this->data['nomor']) == false){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Nomor tanah dengan blok yang berkaitan sudah ada</div>";
            } else {
                $result = $this->Tanah->insert($this->data['tblok'], $this->data['nomor']);
                if($result == 1){
                    $this->data['nomor']="";
                    $this->data['tblok']="";
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
        
        $this->data['show_insert']="slhide";
        $this->data['show_delete']="slhide";
        $this->data['show_update']="slshow";
        $this->data['kd_tanah']=$this->input->post('kd_tanah');
        
        
        $query = $this->Tanah->grab_data($this->data['kd_tanah']);    
        
        $this->data['tblok']=$query[0]['kd_blok'];
        $this->data['upnomor']=$query[0]['nomor_tanah'];
        
        $this->show();
        
    }
    public function update_data(){
        $this->check_role();
        $this->clear();
        $this->form_validation->set_rules('upnomor', 'Nomor tanah', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        $this->data['kd_tanah'] = $this->input->post('kd_tanah');
        $this->data['kd_blok'] = $this->input->post('cblok');
        $this->data['nomor_tanah'] = $this->input->post('upnomor');
        $this->data['upnomor'] = $this->input->post('upnomor');
        
        if($this->input->post('cancel') == true){
            $this->index();
        } else{
             if ($this->form_validation->run() == TRUE){
                if($this->Tanah->cek_kembar($this->data['kd_blok'], $this->data['nomor_tanah']) == false){
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Kode blok dan nomor tanah sudah ada</div>";
                    $this->data['show_insert']="slhide";
                    $this->data['show_delete']="slhide";
                    $this->data['show_update']="slshow";
                    
                } else {
                    if($this->Tanah->update_data($this->data['kd_blok'], $this->data['nomor_tanah'], $this->data['kd_tanah']) == 1){
                        $this->data['upnomor'] = "";
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
            $this->show();
        }
    }
    public function delete_data(){
        $this->check_role();
        $this->clear();
        $this->data['show_insert']="slhide";
        $this->data['show_delete']="slshow";
        $this->data['show_update']="slhide";
        $this->data['kd_tanah'] = $this->input->post('kd_tanah');
        
        $query = $this->Tanah->grab_data($this->data['kd_tanah']);   
        $this->data['nomor_tanah']=$query[0]['nomor_tanah'];
        $this->data['nama_blok']=$query[0]['nama_blok'];
        
        
        $this->show();
    }
    public function confirm_del(){
        $this->check_role();
        $this->clear();
        $this->data['kd_tanah'] = $this->input->post('kd_tanah');
        if($this->input->post('cancel') == true){
            $this->index();
        } else{
            if($this->Tanah->delete_data($this->data['kd_tanah']) == 1){
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

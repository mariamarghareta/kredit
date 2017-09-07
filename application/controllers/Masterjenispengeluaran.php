<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterjenispengeluaran extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Timeout');
        $this->load->model('Jenispengeluaran');
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
            if($_SESSION['kd_role'] != "RL001" && $_SESSION['kd_role'] != "RL002"){
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
        $this->data['name']="";
        $this->data['msg']="";
        $this->data['show_insert']="slshow";
        $this->data['show_delete']="slhide";
        $this->data['show_update']="slhide";
    }
    public function show(){
        $this->data['jenispengeluaran'] = $this->Jenispengeluaran->show_all();
        $this->load->view('masterjenispengeluaran', $this->data);
    }
    public function add_new_data(){
        $this->check_role();
        $this->clear();
        $this->data['name'] = $this->input->post('name');
        $this->data['show_update']="none";
        
        $this->form_validation->set_rules('name', '', 'required', array('required' => 'Harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if ($this->form_validation->run() == TRUE){
            $hasil = $this->Jenispengeluaran->insert($this->data['name']);
            if($hasil == 1){
                $this->clear();
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Jenis Pengeluaran Berhasil ditambahkan</div>";
            }else{
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Jenis Pengeluaran Gagal ditambahkan</div>";
            }   
        }
        $this->show();
    }
    public function ubah_pengeluaran(){
        $this->check_role();
        $this->clear();
        $temp = $this->Jenispengeluaran->get_one_data($this->input->post('id'));
        $this->data['id'] = $this->input->post('id');
        $this->data['name'] = $temp->name;
        $this->data['show_update']="";
        $this->show();
    }
    public function update_data(){
        $this->check_role();
        $this->clear();
        $this->data['id'] = $this->input->post('id');
        $this->data['name'] = $this->input->post('name');
        $this->data['show_update']="";
        
        $this->form_validation->set_rules('name', '', 'required', array('required' => 'Harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if($this->input->post('cancel')==false){
            if ($this->form_validation->run() == TRUE){
                $hasil = $this->Jenispengeluaran->update($this->data['id'], $this->data['name']);
                if($hasil == 1){
                    $this->data['name']="";
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Jenis Pengeluaran Berhasil Terubah</div>";
                }else{
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Jenis Pengeluaran Gagal Terubah</div>";
                }   
            }
        }else{
            $this->data['name']="";
            $this->data['show_update']="slhide";
            $this->data['show_insert']="slshow";
        }
        $this->show();
    }
    public function delete_data(){
        $this->check_role();
        $this->clear();
        $this->data['show_insert']="slhide";
        $this->data['show_delete']="slshow";
        $this->data['show_update']="slhide";
        $this->data['id'] = $this->input->post('id');
        $query = $this->Jenispengeluaran->get_one_data($this->data['id']);   
        $this->data['name']=$query->name;
        
        $this->show();
    }
    public function confirm_del(){
        $this->check_role();
        $this->clear();
        $this->data['id'] = $this->input->post('id');
        if($this->input->post('cancel') == true){
            $this->index();
        } else{
            if($this->Jenispengeluaran->delete($this->data['id']) == 1){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Hapus data berhasil</div>";
                $this->data['show_insert']="slshow";
                $this->data['show_delete']="slhide";
                $this->data['show_update']="slhide";
            } else{
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Hapus data gagal</div>";
            }
            $this->data['jenispengeluaran'] = $this->Jenispengeluaran->show_all();
            $this->load->view('masterjenispengeluaran', $this->data);
        }
        
    }
    public function edit_data(){
        $this->check_role();
        $this->clear();
        $this->form_validation->set_rules('tnama', 'Nama blok', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        $this->data['show_insert']="slhide";
        $this->data['show_delete']="slhide";
        $this->data['show_update']="slshow";
        $this->data['id']=$this->input->post('id');
        
        
        $query = $this->Jenispengeluaran->get_one_data($this->data['id']);    
        
        $this->data['name']=$query->name;
        
        
        $this->show();
    }
    public function logout(){
        session_destroy();
        redirect('Welcome');
        //echo "log out";
    }
}

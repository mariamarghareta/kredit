<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterpemasukan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Timeout');
        $this->load->model('Pemasukan');
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
        $this->data['msg']="";
        $this->data['uang']=0;
        $this->data['ket']="";
        $this->data['tanggal']="";
        $this->data['pj']="";
        $this->data['show_update']="none";
    }
    public function show(){
        $this->load->view('masterpemasukan', $this->data);
    }
    public function add_new_data(){
        $this->check_role();
        $this->clear();
        $this->data['uang'] = $this->input->post('uang');
        $this->data['ket'] = $this->input->post('ket');
        $this->data['tanggal'] = $this->input->post('tanggal');
        $this->data['pj'] = $this->input->post('pj');
        $this->data['show_update']="none";
        
        $this->form_validation->set_rules('uang', '', 'required', array('required' => 'Harus diisi'));
        $this->form_validation->set_rules('ket', '', 'required', array('required' => 'Harus diisi'));
        $this->form_validation->set_rules('pj', '', 'required', array('required' => 'Harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if ($this->form_validation->run() == TRUE){
            $hasil = $this->Pemasukan->insert(str_replace(".", "", $this->data['uang']),$this->data['tanggal'], $_SESSION['kd_kar'], $this->data['ket'], $this->data['pj']);
            if($hasil == 1){
                $this->clear();
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Pemasukan Berhasil ditambahkan</div>";
            }else{
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Pemasukan Gagal ditambahkan</div>";
            }   
        }
        $this->show();
    }
    public function ubah_pemasukan(){
        $this->check_role();
        $this->clear();
        $temp = $this->Pemasukan->get_one_data($this->input->post('kd_pemasukan'));
        $this->data['kd_pemasukan'] = $this->input->post('kd_pemasukan');
        $this->data['uang'] = $temp->pemasukan;
        $this->data['ket'] = $temp->keterangan;
        $this->data['tanggal'] = $temp->tgl_pemasukan;
        $this->data['pj'] = $temp->penanggung_jawab;
        $this->data['show_update']="";
        $this->show();
    }
    public function update_data(){
        $this->check_role();
        $this->clear();
        $this->data['kd_pemasukan'] = $this->input->post('kd_pemasukan');
        $this->data['uang'] = $this->input->post('uang');
        $this->data['ket'] = $this->input->post('ket');
        $this->data['tanggal'] = $this->input->post('tanggal');
        $this->data['pj'] = $this->input->post('pj');
        $this->data['show_update']="";
        
        $this->form_validation->set_rules('uang', '', 'required', array('required' => 'Harus diisi'));
        $this->form_validation->set_rules('ket', '', 'required', array('required' => 'Harus diisi'));
        $this->form_validation->set_rules('pj', '', 'required', array('required' => 'Harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if ($this->form_validation->run() == TRUE){
            $hasil = $this->Pemasukan->update($this->data['kd_pemasukan'], str_replace(".", "", $this->data['uang']),$this->data['tanggal'], $this->data['ket'], $this->data['pj']);
            if($hasil == 1){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Pemasukan Berhasil Terubah</div>";
            }else{
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Pemasukan Gagal Terubah</div>";
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

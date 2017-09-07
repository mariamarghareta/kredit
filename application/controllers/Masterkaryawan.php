<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterkaryawan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Karyawan');
        $this->load->model('Role');
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
        //$this->form_validation->set_rules('uname', 'Uname', 'required');
        $this->check_role();
        $data['tuname']="";
        $data['tname']="";
        $data['talamat']="";
        $data['telp']="";
        $data['msg']="";
        $data['pass']="";
        $data['show_update']="";
        $data['hide_insert']="";
        $data['show_delete']="";
        $data['repass']="";
        $data['uname']="";
        $data['kd_kar']="";
        $data['karyawan']=($this->Karyawan->show_all());
        $data['rolenya']=($this->Role->show_all());
        $this->load->view('master-karyawan',$data);
	}
    public function add_new_data(){
        $this->check_role();
        $data['kd_kar']="";
        $data['tuname']=$this->input->post('uname');
        $data['tname']=$this->input->post('name');
        $data['talamat']=$this->input->post('alamat');
        $data['telp']=$this->input->post('telp');
        $pass = $this->input->post('pass');
        $data['repass'] = "";
        $data['pass']="";
        $kd_role = $this->input->post('jrole');
        $data['jrole'] = $kd_role;
        $data['msg']="";
        $data['show_update']="slhide";
        $data['hide_insert']="slshow";
        $data['show_delete']="slhide";
        
        $this->form_validation->set_rules('uname', 'Username', 'required', array('required' => '%s harus diisi'));
        $this->form_validation->set_rules('telp', 'Telepon', 'numeric', array('numeric' => '%s harus berupa angka'));
        $this->form_validation->set_rules('pass', 'Passowrd', 'required|min_length[5]', array('required'=>'Harus diisi', 'min_length' => 'Minimal 5 karakter'));
        $this->form_validation->set_rules('repass', 'Passowrd', 'required|matches[pass]', array('required'=>'Harus diisi','matches' => 'Password tidak sama'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        if ($this->form_validation->run() == FALSE)
		{
           
		}
		else
		{
            $kembar = $this->Karyawan->cek_uname($data['tuname']);
            if($kembar == false){
                $data['msg'] = "<div id='err_msg' class='alert alert-danger sldown text-center' style='display:none;'>Username Kembar</div>";
                $data['show_update']="slhide";
                $data['hide_insert']="slshow";
                $data['show_delete']="slhide";
            } else {
			     $result = $this->Karyawan->insert($data['tuname'], $data['tname'], $data['talamat'], $data['telp'], $pass, $kd_role);
                if($result == 1){
                    $data['tuname']="";
                    $data['tname']="";
                    $data['talamat']="";
                    $data['telp']="";
                    $data['jrole'] = "";
                    $data['show_update']="slhide";
                    $data['hide_insert']="slshow";
                    $data['show_delete']="slhide";
                    $data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Insert Berhasil</div>";
                } else {
                    $data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Insert Gagal</div>";
                }
            }
		}
        $data['karyawan']=($this->Karyawan->show_all());
        $data['rolenya']=($this->Role->show_all());
        $this->load->view('master-karyawan',$data);
    }
    public function edit_data(){
        $data['kd_kar']=$this->input->post('kd_kar');
        $result = $this->Karyawan->grab_data($data['kd_kar']);
        
        $data['tuname']=$result[0]['uname'];
        $data['tname']=$result[0]['nama'];
        $data['talamat']=$result[0]['alamat'];
        $data['telp']=$result[0]['telp'];
        $data['pass']=$result[0]['pass'];
        $data['repass']=$result[0]['pass'];
        $data['jrole']=$result[0]['kd_role'];
        $data['msg'] = "";
        $data['show_update']="slshow";
        $data['hide_insert']="slhide";
        $data['show_delete']="";
        $data['karyawan']=($this->Karyawan->show_all());
        $data['rolenya']=($this->Role->show_all());
        $this->load->view('master-karyawan',$data);
        
    }
    public function update_data(){
        $this->check_role();
        if ($this->input->post('cancel')) {
            
            $this->index();
        } else{
            $data['tuname']=$this->input->post('uname');
            $data['tname']=$this->input->post('name');
            $data['talamat']=$this->input->post('alamat');
            $data['telp']=$this->input->post('telp');
            $pass = $this->input->post('pass');
            $data['repass']=$this->input->post('repass');
            $data['pass']=$pass;
            $kd_role = $this->input->post('jrole');
            $data['jrole'] = $kd_role;
            $data['msg']="";
            $data['kd_kar']=$this->input->post('kd_kar');

            $this->form_validation->set_rules('uname', 'Username', 'required', array('required' => '%s harus diisi'));
            $this->form_validation->set_rules('telp', 'Telepon', 'numeric', array('numeric' => '%s harus berupa angka'));
            $this->form_validation->set_rules('pass', 'Passowrd', 'required|min_length[5]', array('required'=>'Harus diisi', 'min_length' => 'Minimal 5 karakter'));
            $this->form_validation->set_rules('repass', 'Passowrd', 'required|matches[pass]', array('required'=>'Harus diisi','matches' => 'Password tidak sama'));
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
            if ($this->form_validation->run() == FALSE)
            {
                $data['show_update']="slshow";
                $data['hide_insert']="slhide";
                $data['show_delete']="";
            }
            else
            {

                $kembar = $this->Karyawan->cek_uname_update($data['tuname'], $data['kd_kar']);
                if($kembar == false){
                   $data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Username baru kembar</div>";
                    $data['show_update']="slshow";
                    $data['hide_insert']="slhide";
                    $data['show_delete']="";
                } else {
                     $result = $this->Karyawan->update_data($data['kd_kar'], $data['tuname'], $data['tname'], $data['talamat'], $data['telp'], $pass, $kd_role);
                    if($result == 1){
                        $data['tuname']="";
                        $data['tname']="";
                        $data['talamat']="";
                        $data['telp']="";
                        $data['jrole'] = "";
                        $data['show_update']="";
                        $data['hide_insert']="";
                        $data['show_delete']="";
                        $data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Update Berhasil</div>";
                    } else {
                        $data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Update Gagal</div>";
                        $data['show_update']="slshow";
                        $data['hide_insert']="slhide";
                    }
                }
            }
            $data['karyawan']=($this->Karyawan->show_all());
            $data['rolenya']=($this->Role->show_all());
            $this->load->view('master-karyawan',$data);
        }
    }
    public function delete_data(){
        $data['tuname']="";
        $data['tname']="";
        $data['talamat']="";
        $data['telp']="";
        $data['msg']="";
        $data['pass']="";
        $data['show_update']="";
        $data['hide_insert']="";
        $data['show_update']="slhide";
        $data['hide_insert']="slhide";
        $data['show_delete']="slshow";
        
        $data['kd_kar'] = $this->input->post('kd_kar');
        $result = $this->Karyawan->grab_data($data['kd_kar']);
        $data['uname'] = $result[0]['uname'];
        
        
        $data['karyawan']=($this->Karyawan->show_all());
        $data['rolenya']=($this->Role->show_all());
        $this->load->view('master-karyawan',$data);
    }
    public function confirm_del(){
        $this->check_role();
        if ($this->input->post('cancel')) {
            $this->index();
        }else{
            $data['kd_kar'] = $this->input->post('kd_kar');
            $result = $this->Karyawan->delete_data($data['kd_kar']);
            
            if($result == 1){
                $data['msg'] = "<div id='err_msg' class='alert alert-success sldown' style='display:none;'>Hapus data berhasil</div>";
            } else {
                $data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Hapus data gagal</div>";
            }
            $data['tuname']="";
            $data['tname']="";
            $data['talamat']="";
            $data['telp']="";
            $data['pass']="";
            $data['show_update']="";
            $data['hide_insert']="";
            $data['show_delete']="";
            $data['karyawan']=($this->Karyawan->show_all());
            $data['rolenya']=($this->Role->show_all());
            $this->load->view('master-karyawan',$data);
        }
    }
    public function logout(){
        session_destroy();
        redirect('Welcome');
    }
}

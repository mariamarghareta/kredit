<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksiadmin2_baru extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Customer');
        $this->load->model('Blok');
        $this->load->model('Tanah');
        $this->load->model('Timeout');
        $this->load->model('Karyawan');
    }
    private $data;
	public function index()
	{
        $this->clear();
        $this->check_tahap();
        $this->check_role();
        $this->show();
        
	}
    private function check_tahap(){
        if(isset($_SESSION['hd_kode'])){
            $this->data['hd_kode']=$_SESSION['hd_kode'];
            $this->data['lb_nama']=$_SESSION['hd_nama'];
            $this->data['hd_nama']=$_SESSION['hd_nama'];
            $this->data['cb_blok']=$_SESSION['cb_blok'];
            $this->data['tb_tipe']=$_SESSION['tb_tipe'];
            $this->data['tb_harga']=$_SESSION['tb_harga'];
            $this->data['tb_cashdiskon']=$_SESSION['tb_cashdiskon'];
            $this->data['tb_cashbulan']=$_SESSION['tb_cashbulan'];
            $this->data['cb_tanah']=$_SESSION['cb_tanah'];
            $this->data['cb_tipebayar']=$_SESSION['cb_tipebayar'];
            $this->data['tb_cashbayar']=$_SESSION['tb_cashbayar'];
            $this->data['tb_bookbayar']=$_SESSION['tb_bookbayar'];
            $this->data['tb_cidp']=$_SESSION['tb_cidp'];
            $this->data['tb_ciberapabulan']=$_SESSION['tb_ciberapabulan'];
            $this->data['tb_cidp1']=$_SESSION['tb_cidp1'];
            $this->data['tb_cidiskon']=$_SESSION['tb_cidiskon'];
            $this->data['tb_ciangsuran']=$_SESSION['tb_ciangsuran'];
            $this->data['tb_bulanbaliknama']=$_SESSION['tb_bulanbaliknama'];
        }
    }
    public function show(){
        $this->data['cust']=$this->Customer->show_all();
        $this->data['blok']=$this->Blok->show_all_available();
        $this->load->view('transaksiadmin2_baru', $this->data);
    }
    public function clear(){
        $this->data['hd_kode']="";
        $this->data['lb_nama']="";
        $this->data['hd_nama']="";
        $this->data['cb_blok']="";
        $this->data['tb_tipe']="";
        $this->data['tb_harga']="";
        $this->data['tb_cashdiskon']="";
        $this->data['tb_cashbulan']="";
        $this->data['cb_tanah']="";
        $this->data['cb_tipebayar']="";
        $this->data['tb_cashbayar']="";
        $this->data['tb_bookbayar']="";
        $this->data['tb_cidp']="";
        $this->data['tb_ciberapabulan']="";
        $this->data['tb_cidp1']="";
        $this->data['tb_cidiskon']="";
        $this->data['tb_ciangsuran']="";
        $this->data['tb_bulanbaliknama']="";
    }
    public function check_role(){
        if(isset($_SESSION['kd_role'])){
            if($_SESSION['kd_role'] != "RL003" && $_SESSION['kd_role'] != "RL002" && $_SESSION['kd_role'] != "RL001"){
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
    public function search_cust(){
        $nama = $this->input->post('keyword');
        //echo print_r($_POST);
        echo json_encode($this->Customer->show_all_name($nama));
        //echo print_r($this->Customer->show_all_name($nama));
    }
    public function get_cust(){
        $kode = $this->input->post('keyword');
        echo json_encode($this->Customer->grab_data($kode));
    }
    public function get_tanah(){
        $kode = $this->input->post('keyword');
        echo json_encode($this->Tanah->grab_data_byblok($kode));
    }
    public function get_agen(){
        echo json_encode($this->Karyawan->get_agen());
    }
    public function logout(){
        session_destroy();
        redirect('Welcome');
        //echo "log out";
    }
    public function tahap1(){
        $this->check_role();
        
        
        $this->form_validation->set_rules('hd_kode', 'Customer', 'required', array('required' => '%s harus dipilih'));
        //$this->form_validation->set_rules('cb_tanah', 'Blok Tanah', 'required', array('required' => '%s harus dipilih'));
        $this->form_validation->set_rules('tb_tipe', 'Tipe', 'required', array('required' => '%s harus diisi'));
        //$this->form_validation->set_rules('tb_harga', 'Harga', 'required|numeric', array('required' => '%s harus diisi', 'numeric'=>'%s harus berupa angka'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        $this->data['hd_kode']=$this->input->post('hd_kode');
        $this->data['lb_nama']=$this->input->post('lb_nama');
        $this->data['hd_nama']=$this->input->post('hd_nama');
        $this->data['cb_blok']=$this->input->post('cb_blok');
        $this->data['tb_tipe']=$this->input->post('tb_tipe');
        $this->data['tb_harga']=$this->input->post('tb_harga');
        $this->data['tb_cashdiskon']=$this->input->post('tb_cashdiskon');
        $this->data['tb_cashbulan']=$this->input->post('tb_cashbulan');
        $this->data['cb_tanah']=$this->input->post('cb_tanah');
        $this->data['cb_tipebayar']=$this->input->post('cb_tipebayar');
        $this->data['tb_cashbayar']=$this->input->post('tb_cashbayar');
        $this->data['tb_bookbayar']=$this->input->post('tb_bookbayar');
        $this->data['tb_cidp']=$this->input->post('tb_cidp');
        $this->data['tb_ciberapabulan']=$this->input->post('tb_ciberapabulan');
        $this->data['tb_cidp1']=$this->input->post('tb_cidp1');
        $this->data['tb_cidiskon']=$this->input->post('tb_cidiskon');
        $this->data['tb_ciangsuran']=$this->input->post('tb_ciangsuran');
        $this->data['tb_bulanbaliknama']=$this->input->post('tb_bulanbaliknama');
        
        
        
        if($this->data['cb_tipebayar'] == "cash"){
           //$this->form_validation->set_rules('tb_cashdiskon', 'Diskon', 'numeric', array('numeric' => '%s harus berupa angka'));
           $this->form_validation->set_rules('tb_cashbulan', 'Cicilan', '', array('numeric' => '%s harus berupa angka'));
           //$this->form_validation->set_rules('tb_cashdiskon', 'Dikson', 'numeric', array('numeric' => '%s harus berupa angka'));
        } else if($this->data['cb_tipebayar'] == "booking"){
            $this->form_validation->set_rules('tb_bookbayar', 'Cicilan', 'required', array('required' => '%s harus diisi', 'numeric' => '%s harus berupa angka'));
        } else if($this->data['cb_tipebayar'] == "cicilan"){
            $this->form_validation->set_rules('tb_cidp', 'DP/UM', 'required', array('required' => '%s harus diisi', 'numeric' => '%s harus berupa angka'));
            $this->form_validation->set_rules('tb_ciberapabulan', '', 'greater_than[0]|less_than[11]', array('required' => '%s harus diisi', 'numeric' => '%s harus berupa angka', 'greater_than'=> 'Minimal 1x', 'less_than'=>'Maximal 3x'));
            $this->form_validation->set_rules('tb_cidp1', '', 'required', array('required' => 'Harus diisi', 'numeric' => 'Harus berupa angka'));
            $this->form_validation->set_rules('tb_cidiskon', '', '', array('required' => 'Harus diisi', 'numeric' => 'Harus berupa angka'));
            $this->form_validation->set_rules('tb_ciangsuran', '', 'required|greater_than[0]|less_than[41]', array('required' => 'Harus diisi', 'numeric' => 'Harus berupa angka', 'greater_than'=> 'Minimal 1x', 'less_than'=>'Maximal 40x'));
        }
        $this->form_validation->set_rules('tb_bulanbaliknama', '', 'required|greater_than[0]|less_than[21]', array('required' => 'Harus diisi', 'numeric' => 'Harus berupa angka', 'greater_than'=> 'Minimal 1x', 'less_than'=>'Maximal 20x'));
        $this->form_validation->set_rules('cb_agen', '', 'required', array('required' => 'Harus diisi'));
        
        if ($this->form_validation->run() != FALSE){
            $this->data['tb_harga'] = str_replace(".", "", $this->input->post('tb_harga'));
            $this->data['tb_cashdiskon'] = str_replace(".", "", $this->input->post('tb_cashdiskon'));
            $this->data['tb_cashbayar'] = str_replace(".", "", $this->input->post('tb_cashbayar'));
            $this->data['tb_bookbayar'] = str_replace(".", "", $this->input->post('tb_bookbayar'));
            $this->data['tb_cidp'] = str_replace(".", "", $this->input->post('tb_cidp'));
            $this->data['tb_cidp1'] = str_replace(".", "", $this->input->post('tb_cidp1'));
            $this->data['tb_cidiskon'] = str_replace(".", "", $this->input->post('tb_cidiskon'));
            $this->data['denda'] = str_replace(".", "", $this->input->post('tb_cidiskon'));
            $this->data['tb_bulanbaliknama'] = $this->input->post('tb_bulanbaliknama');
            $this->data['cb_agen'] = $this->input->post('cb_agen');
            $array = array(
                'hd_kode' => $this->data['hd_kode'],
                'hd_nama' => $this->data['hd_nama'],
                'cb_blok' => $this->data['cb_blok'],
                'tb_tipe' => $this->data['tb_tipe'],
                'tb_harga' => $this->data['tb_harga'],
                'tb_cashdiskon' => $this->data['tb_cashdiskon'],
                'tb_cashbulan' => $this->data['tb_cashbulan'],
                'cb_tanah' => $this->data['cb_tanah'],
                'cb_tipebayar' => $this->data['cb_tipebayar'],
                'tb_cashbayar' => $this->data['tb_cashbayar'],
                'tb_bookbayar' => $this->data['tb_bookbayar'],
                'tb_cidp' => $this->data['tb_cidp'],
                'tb_ciberapabulan' => $this->data['tb_ciberapabulan'],
                'tb_cidp1' => $this->data['tb_cidp1'],
                'tb_cidiskon' => $this->data['tb_cidiskon'],
                'tb_ciangsuran' => $this->data['tb_ciangsuran'],
                'cb_agen' => $this->data['cb_agen'],
                'tb_bulanbaliknama' => $this->data['tb_bulanbaliknama']
                
            );
            //echo $this->data['tb_cashbayar'];
            $this->session->set_tempdata($array, NULL, 600);
            redirect('Transaksiadmin2_baru2');
        }else{
            $this->show();
        }
    }
}

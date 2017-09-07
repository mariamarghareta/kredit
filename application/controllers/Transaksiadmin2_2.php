<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksiadmin2_2 extends CI_Controller {
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
        $this->load->model('Transaksi');
        $this->load->model('Cash');
        $this->load->model('Booking');
        $this->load->model('Timeout');
        $this->load->model('Cicilan');
        $this->load->model('Baliknama');
        $this->load->model('Ppjb');
    }
    private $data;
	public function index()
	{
        $this->clear();
        $this->check_role();
        $this->check_tahap();
        $this->show();
        
	}
    private function check_tahap(){
        
        if(!isset($_SESSION['kd_trans'])){
            redirect('Transaksibayar');
        }
    }
    public function show(){
        $this->get_data();
        $this->load->view('transaksiadmin2_2', $this->data);
    }
    public function clear(){
        $this->data['kd_trans']="";
        $this->data['header']=null;
        $this->data['detail']=null;
        $this->data['show_cash']="";
        $this->data['show_book']="";
        $this->data['show_dp']="";
        $this->data['bayar']="";
        $this->data['show_cash_bayar']="none";
        $this->data['status']="";
        $this->data['sisa']="";
        $this->data['show_header'] = "none";
        $this->data['err_nota'] = "";
        $this->data['show_dp']="none";
        $this->data['show_book'] = "none";
        $this->data['dp'] = "";
        $this->data['cicilan_dp'] = "";
        $this->data['dp1'] = "";
        $this->data['diskon'] = "";
        $this->data['angsuran'] = "";
        $this->data['show_dp2']="none";
        $this->data['show_cicilan']="none";
        $this->data['denda']=0;
        $this->data['show_balik']="none";
        $this->data['balik_nama']=0;
        $this->data['temp_denda']=0;
        $this->data['jatuh_tempo']=0;
        $this->data['show_ppjb'] = "none";
        $this->data['ppjb'] = 0;
        $this->data['tgl_bayar'] = "";
        $this->data['msg'] = "";
    }
    public function check_role(){
        if(isset($_SESSION['kd_role'])){
            if($_SESSION['kd_role'] != "RL002" && $_SESSION['kd_role'] != "RL001" && $_SESSION['kd_role'] != "RL003"){
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
    private function get_data(){
        if(isset($_SESSION['kd_trans'])){
            if($_SESSION['tipe_bayar']==6){
                $this->data['kd_trans'] = $_SESSION['kd_trans'];
                $this->data['nama'] = $_SESSION['nama'];
                $this->data['tipe_bayar'] = $_SESSION['tipe_bayar'];
                $this->data['nama_tanah'] = $_SESSION['nama_tanah'];
                $this->data['ppjb'] = str_replace(".", "", $_SESSION['ppjb']);
                $this->data['kd_agen'] = $_SESSION['kd_agen'];
                $this->data['nm_agen'] = $_SESSION['nm_agen'];
                $this->data['angsuran'] = 0;
                $this->data['denda'] = 0;
            } 
        }else{
            $this->data['kd_trans'] = $this->input->post('kd_trans');
            $this->data['nama'] = $this->input->post('nama');
            $this->data['tipe_bayar'] = $this->input->post('tipe_bayar');
            $this->data['nama_tanah'] = $this->input->post('nama_tanah');
            $this->data['kd_agen']= $this->input->post('kd_agen');
            $this->data['nm_agen']= $this->input->post('nm_agen');
            $this->data['ppjb']= $this->input->post('ppjb');
        }
      
       
    }
    public function destroy_data_session(){
        $this->session->unset_userdata('kd_trans');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('tipe_bayar');
        $this->session->unset_userdata('nama_tanah');
        $this->session->unset_userdata('kd_agen');
        $this->session->unset_userdata('nm_agen');
        $this->session->unset_userdata('ppjb');
    }
    public function cetak_nota(){
        $this->check_role();
        $this->clear();
        $this->get_data();
        $this->data['tgl_bayar'] = $this->input->post('tgl_bayar');

        $this->form_validation->set_rules('tgl_bayar', 'Tanggal Bayar', 'required', array('required' => '%s harus dipilih', 'check_date' => 'Tanggal harus lebih besar dari hari ini'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if(($this->input->post('kembali'))== TRUE){
            $array = array(
                'kd_trans'=>$this->data['kd_trans'],
                'ppjb'=>$this->data['ppjb'],
                'kd_agen'=>$this->data['kd_agen']
            );
            $this->session->set_tempdata($array, NULL, 600);
           
            //redirect('Transaksiadmin2/cek_nota');
            if($_SESSION['kd_role'] == "RL002"){
                redirect('Transaksibayar/cek_nota');
            } else if($_SESSION['kd_role'] == "RL003"){
                redirect('Transaksiadmin2/cek_nota');
            }else if($_SESSION['kd_role'] == "RL001"){
                redirect('Transaksimaster/cek_nota');
            }
        }else{
            if ($this->form_validation->run() != FALSE){
                $hasil = $this->Ppjb->insert($this->data['kd_trans'], $this->data['ppjb'], $this->data['tgl_bayar'], $this->data['kd_agen'], $_SESSION['kd_kar']);
                if($hasil != null){
                    $this->destroy_data_session();
                    $this->data['kd_fin']= $hasil->kd_nota;
                    $this->load->view('trans_berhasil2', $this->data);
                }else{
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown text-center' style='display:none;'>Insert data pembayaran gagal</div>";
                    $this->show();
                }
            }else{
                $this->show();
            }
            
        }
    } 
    public function print_nota(){
        $this->data['ctr'] = "";
        $this->data['kd_nota'] = $this->input->post('kd_nota');
        $this->data['obj'] = $this->Transaksi->grab_data_final($this->data['kd_nota']);
        $this->load->view('nota', $this->data);
    }
    public function check_date($tgl){
        $temps = explode("-", $tgl);
        if(sizeof($temps) > 0){
            $tahun = date("Y");
            $bulan = date("m");
            $tgl = date("d");
            if($temps[2] < $tahun){
                return false;
            } else if($temps[2] == $tahun){
                if($temps[1] < $bulan){
                    return false;
                } else if($temps[1] == $bulan) {
                    if($temps[0] <= $tgl){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return true;
                }
            }else{
                return true;
            }
            
            
            
        } else{
            return false;
        }
    }
  
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksiadmin2_baru2 extends CI_Controller {
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
        $this->load->model('Dp');
        $this->load->model('Timeout');
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
        if(!isset($_SESSION['hd_kode'])){
            redirect('Transaksiadmin2_baru');
        }
    }
    public function show(){
        $this->get_data();
        $this->load->view('transaksiadmin2_baru2', $this->data);
    }
    public function clear(){
        $this->data['jatuh_tempo']="";
        $this->data['msg']="";
        $this->data['tgl_bayar']="";
        $this->data['jatuh_tempo_bn']="";
    }
    public function check_role(){
        if(isset($_SESSION['kd_role'])){
            if($_SESSION['kd_role'] != "RL003" && $_SESSION['kd_role'] != "RL001" && $_SESSION['kd_role'] != "RL002"){
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
        $this->data['cb_tanah'] = $_SESSION['cb_tanah'];
        $temp = $this->Tanah->grab_data($_SESSION['cb_tanah']);
        $this->data['nama_tanah'] = $temp[0]['nama_blok']. " " .$temp[0]['nomor_tanah'];
        $this->data['hd_kode'] = $_SESSION['hd_kode'];
        $this->data['hd_nama'] = $_SESSION['hd_nama'];
        $this->data['tb_tipe'] = $_SESSION['tb_tipe'];
        $this->data['tb_harga'] = $_SESSION['tb_harga'];
        $this->data['tb_cashdiskon'] = $_SESSION['tb_cashdiskon'];
        $this->data['tb_cashbulan'] = $_SESSION['tb_cashbulan'];
        $this->data['cb_tipebayar'] = $_SESSION['cb_tipebayar'];
        $this->data['tb_cashbayar'] = $_SESSION['tb_cashbayar'];
        $this->data['tb_bookbayar'] = $_SESSION['tb_bookbayar'];
        $this->data['tb_cidp'] = $_SESSION['tb_cidp'];
        $this->data['tb_ciberapabulan'] = $_SESSION['tb_ciberapabulan'];
        $this->data['tb_cidp1'] = $_SESSION['tb_cidp1'];
        $this->data['tb_cidiskon'] = $_SESSION['tb_cidiskon'];
        $this->data['tb_ciangsuran'] = $_SESSION['tb_ciangsuran'];
        $this->data['cb_agen'] = $_SESSION['cb_agen'];
        $this->data['tb_bulanbaliknama'] = $_SESSION['tb_bulanbaliknama'];
        $this->data['tb_biayabaliknama'] = $_SESSION['tb_biayabaliknama'];

        if($this->data['cb_tipebayar']=="cash"){
            $this->data['bayar_final'] = $this->data['tb_cashbayar'];
            $this->data['cicilan_final'] = $this->data['tb_cashbulan'];
            $this->data['diskon_final'] = $this->data['tb_cashdiskon'];
        } else if($this->data['cb_tipebayar']=="booking"){
            $this->data['bayar_final'] = $this->data['tb_bookbayar'];
            $this->data['cicilan_final'] = 0;
            $this->data['diskon_final'] = 0;
        } else if($this->data['cb_tipebayar']=="cicilan"){
            $this->data['bayar_final'] = $this->data['tb_cidp1'];
            $this->data['cicilan_final'] = $this->data['tb_ciangsuran'];
            $this->data['diskon_final'] = $this->data['tb_cidiskon'];
            $this->data['dp_cicilan_final'] = $this->data['tb_ciberapabulan'];
        }
        
        $array = array(
            'bayar_final' => $this->data['bayar_final'],
            'cicilan_final' => $this->data['cicilan_final'],
            'diskon_final' => $this->data['diskon_final']
        );
        $this->session->set_tempdata($array, NULL, 600);
    }
    public function simpan_trans(){
        $this->check_role();
        
        $this->clear();
        $this->get_data();
        $this->data['jatuh_tempo'] = $this->input->post('jatuh_tempo');
        $this->data['tgl_bayar'] = $this->input->post('tgl_bayar');
        
        if(($this->input->post('is_transfer')) == 1){
            $this->data['is_transfer'] = 1;
        } else {
            $this->data['is_transfer'] = 0;
        }
        
        
        $this->form_validation->set_rules('jatuh_tempo', 'Tanggal', 'required', array('required' => '%s harus dipilih', 'check_date' => 'Tanggal harus lebih besar dari hari ini'));
        $this->form_validation->set_rules('tgl_bayar', 'Tanggal', 'required', array('required' => '%s harus dipilih', 'check_date' => 'Tanggal harus lebih besar dari hari ini'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if ($this->form_validation->run() != FALSE){
            //insert database
            $this->data['kar_input'] = $_SESSION['kd_kar'];
            $nota = $this->Transaksi->insert($this->data);
            if($nota != null){
                $this->data['kd_trans'] = $nota[0]['kd_trans'];
                
                if($this->data['cb_tipebayar']== "cash"){
                    $hasil = $this->Cash->insert($this->data);
                } else if($this->data['cb_tipebayar']== "booking"){
                    $hasil = $this->Booking->insert($this->data);
                }else if($this->data['cb_tipebayar']== "cicilan"){
                    $hasil = $this->Dp->insert($this->data);
                }
                if($hasil != null){
                    $this->data['kd_fin']= $hasil->kd_nota;
                    $this->session->unset_userdata('hd_kode');
                    $this->load->view('trans_berhasil3', $this->data);
                }else{
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Insert data pembayaran cash gagal</div>";
                    $this->load->view('transaksiadmin2_baru2', $this->data);
                }
                
            }else{
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Insert transaksi gagal</div>";
                $this->load->view('transaksiadmin2_baru2', $this->data);
            }
            
            //unset session
            /*
            $this->session->unset_userdata('cb_tanah');
            $this->session->unset_userdata('hd_kode');
            $this->session->unset_userdata('hd_nama');
            $this->session->unset_userdata('tb_tipe');
            $this->session->unset_userdata('tb_harga');
            $this->session->unset_userdata('tb_cashdiskon');
            $this->session->unset_userdata('tb_cashbulan');
            $this->session->unset_userdata('cb_tipebayar');
            $this->session->unset_userdata('tb_cashbayar');
            $this->session->unset_userdata('bayar_final');
            $this->session->unset_userdata('cicilan_final');
            $this->session->unset_userdata('diskon_final');
            */

            
        }else{
            $this->show();
        }   
        
    }
    public function cetak_nota(){
        $this->data['ctr'] = "";
        $this->data['kd_nota'] = $this->input->post('kd_nota');
        $this->data['obj'] = $this->Transaksi->grab_data_final($this->data['kd_nota']);
        $this->data['ctr'] = $this->Transaksi->get_ctr($this->data['kd_nota']);
        $this->load->view('nota', $this->data);
    }
    public function check_date(){
        $temps = explode("-", $this->input->post('jatuh_tempo'));
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

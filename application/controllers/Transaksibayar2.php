<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksibayar2 extends CI_Controller {
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
        $this->load->model('Cicilan');
        $this->load->model('Baliknama');
        $this->load->model('Gantibayar');
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
        $this->load->view('transaksi-bayar2', $this->data);
    }
    public function clear(){
        $this->data['jatuh_tempo']="";
        $this->data['msg']="";
        $this->data['tgl_bayar']="";
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
    private function get_data(){
        if(isset($_SESSION['kd_trans'])){
            if($_SESSION['tipe_bayar']==0 || $_SESSION['tipe_bayar']==3){
                $this->data['kd_trans'] = $_SESSION['kd_trans'];
                $this->data['nama'] = $_SESSION['nama'];
                $this->data['tipe_bayar'] = $_SESSION['tipe_bayar'];
                $this->data['nama_tanah'] = $_SESSION['nama_tanah'];
                $this->data['bayar'] = str_replace(".", "", $_SESSION['bayar']);
                $this->data['ctr'] = $_SESSION['ctr'];
                $this->data['denda'] = str_replace(".", "", $_SESSION['denda']);
                $this->data['angsuran'] = $_SESSION['angsuran'];
                $this->session->unset_userdata('kd_trans');
                $this->session->unset_userdata('nama');
                $this->session->unset_userdata('tipe_bayar');
                $this->session->unset_userdata('nama_tanah');
                $this->session->unset_userdata('bayar');
                $this->session->unset_userdata('ctr');
                $this->session->unset_userdata('denda');
                $this->session->unset_userdata('angsuran');
            } else if($_SESSION['tipe_bayar']==1){
                $this->data['kd_trans'] = $_SESSION['kd_trans'];
                $this->data['nama'] = $_SESSION['nama'];
                $this->data['tipe_bayar'] = $_SESSION['tipe_bayar'];
                $this->data['nama_tanah'] = $_SESSION['nama_tanah'];
                $this->data['dp'] = $_SESSION['dp'];
                $this->data['cicilan_dp'] = $_SESSION['cicilan_dp'];
                $this->data['dp1'] = $_SESSION['dp1'];
                $this->data['diskon'] = $_SESSION['diskon'];
                $this->data['angsuran'] = $_SESSION['angsuran'];
                $this->data['ctr'] = 1;
                $this->data['denda'] = 0;
                $this->session->unset_userdata('kd_trans');
                $this->session->unset_userdata('nama');
                $this->session->unset_userdata('tipe_bayar');
                $this->session->unset_userdata('nama_tanah');
                $this->session->unset_userdata('dp');
                $this->session->unset_userdata('cicilan_dp');
                $this->session->unset_userdata('dp1');
                $this->session->unset_userdata('diskon');
                $this->session->unset_userdata('angsuran');
                $this->session->unset_userdata('ctr');
            } else if($_SESSION['tipe_bayar']==5){
                $this->data['kd_trans'] = $_SESSION['kd_trans'];
                $this->data['nama'] = $_SESSION['nama'];
                $this->data['tipe_bayar'] = $_SESSION['tipe_bayar'];
                $this->data['nama_tanah'] = $_SESSION['nama_tanah'];
                $this->data['balik_nama'] = str_replace(".", "", $_SESSION['balik_nama']);
                $this->data['angsuran'] = 0;
                $this->data['denda'] = 0;
				$this->data['ctr'] = $_SESSION['ctr'];
            } else if($_SESSION['tipe_bayar']==6){
                $this->data['kd_trans'] = $_SESSION['kd_trans'];
                $this->data['nama'] = $_SESSION['nama'];
                $this->data['tipe_bayar'] = $_SESSION['tipe_bayar'];
                $this->data['nama_tanah'] = $_SESSION['nama_tanah'];
                $this->data['ppjb'] = str_replace(".", "", $_SESSION['ppjb']);
                $this->data['kd_agen'] = $_SESSION['kd_agen'];
                $this->data['nm_agen'] = $_SESSION['nm_agen'];
                $this->data['angsuran'] = 0;
                $this->data['denda'] = 0;
            }  else if($_SESSION['tipe_bayar']==7){
                $this->data['kd_trans'] = $_SESSION['kd_trans'];
                $this->data['nama'] = $_SESSION['nama'];
                $this->data['tipe_bayar'] = $_SESSION['tipe_bayar'];
                $this->data['nama_tanah'] = $_SESSION['nama_tanah'];
                $this->data['bayarcash'] = str_replace(".", "", $_SESSION['bayarcash']);
                $this->data['diskon'] = str_replace(".", "", $_SESSION['diskon']);
                $this->data['cicilan'] = $_SESSION['cicilan'];
                $this->data['denda'] = 0;
                $this->session->unset_userdata('bayarcash');
                $this->session->unset_userdata('diskon');
                $this->session->unset_userdata('cicilan');
                $this->session->unset_userdata('kd_trans');
                $this->session->unset_userdata('nama');
                $this->session->unset_userdata('tipe_bayar');
                $this->session->unset_userdata('nama_tanah');
            }
        }else{
            $this->data['kd_trans'] = $this->input->post('kd_trans');
            $this->data['nama'] = $this->input->post('nama');
            $this->data['tipe_bayar'] = $this->input->post('tipe_bayar');
            $this->data['nama_tanah'] = $this->input->post('nama_tanah');
            $this->data['ctr'] = $this->input->post('ctr');
            $this->data['is_transfer'] = $this->input->post('is_transfer');
            $this->data['denda'] = $this->input->post('denda');
            $this->data['angsuran'] = $this->input->post('angsuran');
            $this->data['balik_nama'] = $this->input->post('balik_nama');
            if($this->data['tipe_bayar']==0 || $this->data['tipe_bayar']==3){
                $this->data['bayar'] = str_replace(".", "", $this->input->post('bayar'));
            } else if($this->data['tipe_bayar']==1){
                $this->data['dp']= $this->input->post('dp');
                $this->data['cicilan_dp']= $this->input->post('cicilan_dp');
                $this->data['dp1']= $this->input->post('dp1');
                $this->data['diskon']= $this->input->post('diskon');
                $this->data['angsuran']= $this->input->post('angsuran');
            } else if($this->data['tipe_bayar']==6){
                $this->data['kd_agen']= $this->input->post('kd_agen');
                $this->data['nm_agen']= $this->input->post('nm_agen');
            } else if($this->data['tipe_bayar']==7){
                $this->data['bayarcash']= $this->input->post('bayarcash');
                $this->data['cicilan']= $this->input->post('cicilan');
                $this->data['diskon']= $this->input->post('diskon');
            }
        }
      
       
    }
    public function destroy_data_session(){
        $this->session->unset_userdata('kd_trans');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('tipe_bayar');
        $this->session->unset_userdata('nama_tanah');
        $this->session->unset_userdata('dp');
        $this->session->unset_userdata('cicilan_dp');
        $this->session->unset_userdata('dp1');
        $this->session->unset_userdata('diskon');
        $this->session->unset_userdata('angsuran');
        $this->session->unset_userdata('bayar');
        $this->session->unset_userdata('balik_nama');
        $this->session->unset_userdata('ctr');
        $this->session->unset_userdata('denda');
        $this->session->unset_userdata('kd_agen');
        $this->session->unset_userdata('nm_agen');
    }
    public function cetak_nota(){
        $this->check_role();
        $this->clear();
        $this->get_data();
        $this->data['jatuh_tempo'] = $this->input->post('jatuh_tempo');
        $this->data['tgl_bayar'] = $this->input->post('tgl_bayar');
        $this->data['is_transfer'] = $this->input->post('is_transfer');
        $this->form_validation->set_rules('tgl_bayar', 'Tanggal Bayar', 'required', array('required' => '%s harus dipilih', 'check_date' => 'Tanggal harus lebih besar dari hari ini'));
		$this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required', array('required' => '%s harus dipilih', 'check_date' => 'Tanggal harus lebih besar dari hari ini'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if(($this->input->post('kembali'))== TRUE){
            if($this->input->post('tipe_bayar')==0 || $this->input->post('tipe_bayar')==3 || $this->input->post('tipe_bayar')==2){
                $array = array(
                    'kd_trans'=>$this->data['kd_trans'],
                    'bayar'=>$this->data['bayar'],
                    'denda'=>$this->data['denda']
                );
            } else if($this->input->post('tipe_bayar')==1){
                $array = array(
                    'kd_trans'=>$this->data['kd_trans'],
                    'dp'=>$this->data['dp'],
                    'cicilan_dp'=>$this->data['cicilan_dp'],
                    'dp1'=>$this->data['dp1'],
                    'diskon'=>$this->data['diskon'],
                    'angsuran'=>$this->data['angsuran']
                );
            }else if($this->input->post('tipe_bayar')==5){
                $array = array(
                    'kd_trans'=>$this->data['kd_trans'],
                    'balik_nama'=>$this->data['balik_nama']
                );
            }else if($this->input->post('tipe_bayar')==7){
                $array = array(
                    'bayarcash'=>$this->data['bayarcash'],
                    'kd_trans'=>$this->data['kd_trans'],
                    'diskon'=>$this->data['diskon'],
                    'cicilan'=>$this->data['cicilan'],
                );
            }
            $this->session->set_tempdata($array, NULL, 600);
           if($_SESSION['kd_role'] == "RL002"){
                redirect('Transaksibayar/cek_nota');
           } else if($_SESSION['kd_role'] == "RL003"){
                redirect('Transaksiadmin2/cek_nota');
           }else if($_SESSION['kd_role'] == "RL001"){
                redirect('Transaksimaster/cek_nota');
           }
           
        }else{
            if ($this->form_validation->run() != FALSE){
                //insert database
                
                $this->data['kar_input'] = $_SESSION['kd_kar'];
                
                if($this->data['tipe_bayar']== 0){
                    $this->data['bayar_final'] = $this->input->post('bayar');
                    $hasil = $this->Cash->insert($this->data);
                    //$this->Transaksi->cek_lunas($this->data['kd_trans']);
                } else if($this->data['tipe_bayar']== 1){
                    $temp = $this->Transaksi->update_booking($this->data['kd_trans'],$this->data['dp'], $this->data['cicilan_dp'],$this->data['diskon'],$this->data['angsuran']);
                    $this->data['bayar_final']=$this->input->post('dp1');
                    $hasil = $this->Dp->insert($this->data);
                    
                }else if($this->data['tipe_bayar']== 3){
                    //$data_bayar = $this->Transaksi->header_detail_onedata($this->data['kd_trans']);
                    
                    /*
                    $sudah_dp = $this->DP->get_jumlah($this->data['kd_trans']);
                    if($sudah_dp->jumlah == 0 && $this->data['tipe_bayar']== 1){
                        $temp = $this->Transaksi->update_booking($this->data['kd_trans'],$this->data['dp'], $this->data['cicilan_dp'],$this->data['diskon'],$this->data['angsuran']);
                    } else {
                        $temp =1;
                    }
                    */
                    //$jumlah = $this->DP->get_jumlah($this->data['kd_trans']);
                    //$header = $this->Transaksi->cek_header_transaksi($this->data['kd_trans']);
                    
                    //$total_bayar = $this->Transaksi->total_dp($this->data['kd_trans'])->bayar;
                    //$bayar_dp = $this->Transaksi->bayar_dp($this->data['kd_trans'])->dp;
                    /*
                    if($this->data['tipe_bayar']==1 && $jumlah->jumlah < $header->dp_cicilan && $data_bayar->dp < $header->dp){
                        $this->data['bayar_final']=$this->input->post('dp1');
                        $hasil = $this->DP->insert($this->data);
                        //$this->Transaksi->cek_lunas($this->data['kd_trans']);
                        
                    }else if($this->data['tipe_bayar']==3){
                    */  
                    $this->data['header'] = $this->Transaksi->cek_header_transaksi($this->data['kd_trans']);
                    $this->data['detail_cash'] = $this->Transaksi->cek_detail_transaksi($this->data['header']->kd_trans, 0);
                    $this->data['detail_book'] = $this->Transaksi->cek_detail_transaksi($this->data['header']->kd_trans, 1);
                    $data_bayar = $this->Transaksi->header_detail_onedata($this->data['header']->kd_trans);
                    $this->data['data_bayar'] = $data_bayar;
                    $this->data['subdetail'] = $this->Cicilan->cek_detail_transaksi($this->data['header']->kd_trans);
                    
                    $this->data['bayar_final']=$this->input->post('bayar');
                    if($data_bayar->dp < $this->data['header']->dp  && sizeof($this->data['detail_book']) < $this->data['header']->dp_cicilan && $this->Gantibayar->check_cash_before($this->data['header']->kd_trans)->jumlah <= 0){
                        $hasil = $this->Dp->insert($this->data);
                        //$this->Transaksi->cek_lunas($this->data['kd_trans']);
                    }else{
                        $hasil = $this->Cicilan->insert($this->data);
                        //$this->Transaksi->cek_lunas($this->data['kd_trans']);
                    }
                    /*
                    }else{
                        $hasil = null;
                    }
                    */
                }else if($this->data['tipe_bayar']== 5){
                    $hasil = $this->Baliknama->insert($this->data['kd_trans'], $this->input->post('balik_nama'), $_SESSION['kd_kar'], $this->input->post('tgl_bayar'), $this->input->post('jatuh_tempo'), $this->input->post('is_transfer'));
                    
                }else if($this->data['tipe_bayar']== 7){
                    $hasil = $this->Transaksi->update_cash($this->data['kd_trans'], $this->input->post('diskon'), $this->input->post('cicilan'));
                    if($hasil == 1){
                        $this->data['bayar_final'] = $this->data['bayarcash'];
                        $hasil = $this->Cash->insert($this->data);
                    }else{
                        $hasil = null;
                    }
                    
                }
                
                if($hasil != null){
                    $this->destroy_data_session();
                    $this->data['kd_fin']= $hasil->kd_nota;
                    $this->load->view('trans_berhasil3', $this->data);
                }else{
                    $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown text-center' style='display:none;'>Insert data pembayaran cash gagal</div>";
                    $this->load->view('transaksi-bayar2', $this->data);
                }
            }else if($this->form_validation->run() == ""){
                if($this->data['tipe_bayar']== 6){
                    $hasil = $this->Ppjb->insert($this->data['kd_trans'], $this->data['ppjb'], $this->data['tgl_bayar'], $this->data['kd_agen'], $_SESSION['kd_kar']);
                    if($hasil != null){
                        $this->destroy_data_session();
                        $this->data['kd_fin']= $hasil->kd_nota;
                        $this->load->view('trans_berhasil3', $this->data);
                    }else{
                        $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown' style='display:none;'>Insert data pembayaran cash gagal</div>";
                        $this->load->view('transaksi-bayar2', $this->data);
                    }

                }
                $this->load->view('transaksi-bayar2', $this->data);
            }   
        }
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

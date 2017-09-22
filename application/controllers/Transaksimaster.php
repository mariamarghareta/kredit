<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksimaster extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Transaksi');
        $this->load->model('Timeout');
        $this->load->model('Cicilan');
        $this->load->model('Booking');
        $this->load->model('Karyawan');
        $this->load->model('Ppjb');
        $this->load->model('Gantibayar');
        $this->load->model('Baliknama');
        $this->load->model('Cash');
        $this->load->model('Dp');
        $this->load->model('Cicilan');
        $this->load->model('Catatan');
    }
    private $data;
	public function index()
	{
        $this->clear();
        $this->check_role();
        $this->show();
        
	}
    public function show(){
        $this->load->view('transaksimaster', $this->data);
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
        $this->data['sisa'] = 0;
        $this->data['msg'] = 0;
        $this->data['bayarcash'] = 0;
        $this->data['cicilan'] = "";
        $this->data['error_transaksi_show'] = "";
        $this->data['error_transaksi'] = "";
        $this->data['diskon1'] = "";
        $this->data['besar_baliknama'] = "";
        $this->data['catatan'] = "";
        $this->data['detail_catatan'] = "";

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
    public function load_data(){
        if($this->input->post('tipe_bayar') == 1){
            $this->data['dp']= $this->input->post('dp');
            $this->data['cicilan_dp']= $this->input->post('cicilan_dp');
            $this->data['dp1']= $this->input->post('dp1');
            $this->data['diskon']= $this->input->post('diskon');
            $this->data['angsuran']= $this->input->post('angsuran');
        }
    }
    public function cek_nota(){
        $this->check_role();
        $this->clear();
        $this->load_data();
        $kd_nota = $this->input->post('kd_trans');
        $this->data['kd_trans']=$this->input->post('kd_trans');
        $this->data['denda']=$this->input->post('denda');
        
        if(isset($_SESSION['bayar'])){
            $kd_nota = $_SESSION['kd_trans'];
            $this->data['kd_trans'] = $_SESSION['kd_trans'];
            $this->data['bayar'] = $_SESSION['bayar'];
            $this->data['denda'] = $_SESSION['denda'];
            $this->session->unset_userdata('kd_trans');
            $this->session->unset_userdata('bayar');
            $this->session->unset_userdata('denda');
            
        } else if(isset($_SESSION['dp'])){
            $kd_nota = $_SESSION['kd_trans'];
            $this->data['kd_trans'] = $_SESSION['kd_trans'];
            //echo $_SESSION['dp'];
            $this->data['dp'] = $_SESSION['dp'];
            $this->data['cicilan_dp'] = $_SESSION['cicilan_dp'];
            $this->data['dp1'] = $_SESSION['dp1'];
            $this->data['diskon'] = $_SESSION['diskon'];
            $this->data['angsuran'] = $_SESSION['angsuran'];
            $this->session->unset_userdata('kd_trans');
            $this->session->unset_userdata('dp');
            $this->session->unset_userdata('cicilan_dp');
            $this->session->unset_userdata('dp1');
            $this->session->unset_userdata('diskon');
            $this->session->unset_userdata('angsuran');
        }else if(isset($_SESSION['balik_nama'])){
            $kd_nota = $_SESSION['kd_trans'];
            $this->data['kd_trans'] = $_SESSION['kd_trans'];
            $this->data['balik_nama'] = $_SESSION['balik_nama'];
            $this->session->unset_userdata('kd_trans');
            $this->session->unset_userdata('balik_nama');
        }else if(isset($_SESSION['ppjb'])){
            $kd_nota = $_SESSION['kd_trans'];
            $this->data['kd_trans'] = $_SESSION['kd_trans'];
            $this->data['ppjb'] = $_SESSION['ppjb'];
            $this->data['kd_agen'] = $_SESSION['kd_agen'];
            $this->session->unset_userdata('kd_trans');
            $this->session->unset_userdata('ppjb');
        }else if(isset($_SESSION['master'])){
            $kd_nota = $_SESSION['master'];
            $this->data['kd_trans'] = $_SESSION['master'];
            $this->session->unset_userdata('master');
        }else if(isset($_SESSION['bayarcash'])){
            $kd_nota = $_SESSION['kd_trans'];
            $this->data['kd_trans'] = $_SESSION['kd_trans'];
            $this->data['bayarcash'] = $_SESSION['bayarcash'];
            $this->data['diskon1'] = $_SESSION['diskon'];
            $this->data['cicilan'] = $_SESSION['cicilan'];
            $this->session->unset_userdata('bayarcash');
            $this->session->unset_userdata('kd_trans');
            $this->session->unset_userdata('diskon');
            $this->session->unset_userdata('cicilan');
        }
        
        
        $this->data['header'] = $this->Transaksi->cek_header_transaksi($kd_nota);
        
        
        if($this->data['header'] != null){
            $this->data['detail_cash'] = $this->Transaksi->cek_detail_transaksi($this->data['header']->kd_trans, 0);
            $this->data['detail_book'] = $this->Transaksi->cek_detail_transaksi($this->data['header']->kd_trans, 1);
            $data_bayar = $this->Transaksi->header_detail_onedata($this->data['header']->kd_trans);
            $this->data['data_bayar'] = $data_bayar;
            $this->data['subdetail'] = $this->Cicilan->cek_detail_transaksi($this->data['header']->kd_trans);
            $this->data['detail_baliknama'] = $this->Baliknama->cek_detail_transaksi($this->data['header']->kd_trans);
            $this->data['detail_catatan'] = $this->Catatan->cek_detail_transaksi($this->data['header']->kd_trans);

            if($data_bayar->cicilan > 0){
                $this->data['show_cicilan']="";
            } else{
                $this->data['show_cicilan']="none";
            }
            if($data_bayar->cash > 0){
                $this->data['show_cash'] = "sldown";
            }
            if($data_bayar->dp > 0){
                $this->data['show_book'] = "";
            }
            $this->data['sisa'] = $data_bayar->harga - $data_bayar->diskon + $data_bayar->denda - $data_bayar->dp - $data_bayar->cicilan - $data_bayar->cash;
            if($this->data['sisa'] > 0){
                $this->data['status'] = "Belum Lunas";

            }else{
                $this->data['status'] = "Sudah Lunas";
            }
            
            $ppjb = $this->Ppjb->get_ppjb($this->data['header']->kd_trans);
            $this->data['data_ppjb'] = $ppjb;
            $this->data['agen'] = $this->Karyawan->get_agen();
            $this->data['jatuh_tempo'] = $data_bayar->jatuh_tempo;
            
            if($this->data['header']->tipe_bayar == 1){
                $this->data['show_dp']="";
            } else if($this->data['header']->tipe_bayar == 0){
                
                if(sizeof($this->data['detail_cash'])+sizeof($this->data['subdetail']) < $this->data['header']->cicilan && $this->data['sisa'] > 0){
                    $this->data['show_cash_bayar'] = "";
                } else {
                    
                    if(sizeof($this->data['detail_cash'])+sizeof($this->data['subdetail']) >= $this->data['header']->cicilan && $this->data['sisa'] > 0){
                        $this->data['error_transaksi_show'] = "sldown";
                        $this->data['error_transaksi'] = "Cicilan Cash sudah habis. Silahkan perpanjang cicilan Cash.";
                    }
                    
                    $this->data['show_cash_bayar'] = "none";
                }
                
                $this->data['urutan'] = sizeof($this->data['detail_cash']) +1;
               
                if(sizeof($ppjb) == 0){
                    $this->data['show_ppjb'] = "";
                }
            } else if($this->data['header']->tipe_bayar == 2){
                //DP
                if($data_bayar->dp < $this->data['header']->dp  && sizeof($this->data['detail_book']) < $this->data['header']->dp_cicilan && $this->Gantibayar->check_cash_before($this->data['header']->kd_trans)->jumlah <= 0){
                    $this->data['show_cash_bayar'] = "";
                    $this->data['urutan'] = sizeof($this->data['detail_book'])+1;
                    $this->data['angsuran'] = 0;
                } else {
                    if($data_bayar->dp < $this->data['header']->dp  && sizeof($this->data['detail_book']) >= $this->data['header']->dp_cicilan){
                        $this->data['error_transaksi_show'] = "sldown";
                        $this->data['error_transaksi'] = "Cicilan DP/UM sudah habis dan masih belum lunas. Silahkan perpanjang cicilan DP/UM.";
                    }
                    if($data_bayar->dp >= $this->data['header']->dp ){
                        if($this->data['sisa'] > 0 && sizeof($this->data['subdetail'])+ sizeof($this->data['detail_cash']) < $this->data['header']->cicilan)                         {
                            $this->data['urutan']= sizeof($this->data['subdetail']) +1;
                            $this->data['angsuran'] = 1;
                            $this->data['show_cash_bayar'] = "";
                        }else{
                            if($this->data['sisa'] > 0 && sizeof($this->data['subdetail'])+ sizeof($this->data['detail_cash']) >= $this->data['header']->cicilan){  
                                $this->data['error_transaksi_show'] = "sldown";
                                $this->data['error_transaksi'] = "Cicilan Angsuran sudah habis dan masih belum lunas. Silahkan perpanjang cicilan angsuran.";                    
                            }
                        }
                    }
                }
                if(($data_bayar->dp >= $this->data['header']->dp && sizeof($ppjb) == 0) || ($this->Gantibayar->check_cash_before($this->data['header']->kd_trans)->jumlah > 0 && sizeof($ppjb) == 0) ){
                    $this->data['show_ppjb'] = "";
                }
            }
            
            if(count($this->data['detail_baliknama']) < ($this->data['header']->cicilan_baliknama)){
                $this->data['show_balik'] = "";
            }
            
            $this->data['show_header'] = "";
            $this->show();
            
        }else{
            $this->data['err_nota'] = "sldown";
            $this->data['show_header'] = "none";
            $this->show();
        }
        
    }
   
    public function bayar(){
        $this->check_role();
        $this->clear();
        
        $this->form_validation->set_rules('bayar', 'Pembayaran', 'required', array('required' => 'Harus diisi'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if(($this->input->post('submit') == "catatan")){
            if(($this->input->post('tipe_bayar') == 1 && $this->input->post('angsuran') != 1) || ($this->input->post('tipe_bayar') == 2 && $this->input->post('angsuran') != 1)){
                $kd_nota = $this->Dp->get_last_code($this->input->post('kd_trans'));
                $tipe = "DP";
            }else if(($this->input->post('tipe_bayar') == 1 && $this->input->post('angsuran') == 1) || ($this->input->post('tipe_bayar') == 2 && $this->input->post('angsuran') == 1)){
                $kd_nota = $this->Cicilan->get_last_code($this->input->post('kd_trans'));
                if(sizeof($kd_nota) <= 0){
                    $kd_nota = $this->Dp->get_last_code($this->input->post('kd_trans'));
                }
                $tipe = "Cicilan";
            }

            $hasil = $this->Catatan->insert( $this->input->post('kd_trans'),  $kd_nota->kd_nota, $this->input->post('catatan'), $this->input->post('ctr'), $tipe);
            $this->cek_nota();
        }else {
            if ($this->form_validation->run() == TRUE) {
                if ($this->input->post('tipe_bayar') == 2) {
                    $array = array(
                        'kd_trans' => $this->input->post('kd_trans'),
                        'nama' => $this->input->post('nama'),
                        'tipe_bayar' => 3,
                        'nama_tanah' => $this->input->post('nama_tanah'),
                        'bayar' => $this->input->post('bayar'),
                        'ctr' => $this->input->post('ctr'),
                        'denda' => $this->input->post('denda'),
                        'angsuran' => $this->input->post('angsuran')
                    );
                } else if ($this->input->post('tipe_bayar') == 0) {
                    $array = array(
                        'kd_trans' => $this->input->post('kd_trans'),
                        'nama' => $this->input->post('nama'),
                        'tipe_bayar' => 0,
                        'nama_tanah' => $this->input->post('nama_tanah'),
                        'bayar' => $this->input->post('bayar'),
                        'ctr' => $this->input->post('ctr'),
                        'denda' => $this->input->post('denda'),
                        'angsuran' => $this->input->post('angsuran')
                    );
                }
                $this->session->set_tempdata($array, NULL, 600);
                redirect('Transaksibayar2');
            } else {
                $this->cek_nota();
            }
        }
    }
    public function urus_cash(){
        $this->check_role();
        $this->clear();
        $this->data['kd_trans']=$this->input->post('kd_trans');
        $this->data['bayarcash']=$this->input->post('bayarcash');
        $this->data['diskon']=$this->input->post('diskon');
        $this->data['cicilan']=$this->input->post('cicilan');
        
        $this->form_validation->set_rules('bayarcash', 'DP/UM', 'required', array('required' => 'Harus diisi', 'numeric'=>'Harus berupa angka'));
        $this->form_validation->set_rules('cicilan', '', 'required|numeric', array('required' => 'Harus diisi', 'numeric'=>'Harus berupa angka'));
        
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if($this->form_validation->run() == TRUE){
            $array = array(
                'kd_trans' => $this->input->post('kd_trans'),
                'nama' => $this->input->post('nama'),
                'tipe_bayar' => 7,
                'nama_tanah' => $this->input->post('nama_tanah'),
                'bayarcash' => str_replace(".", "", $this->input->post('bayarcash')),
                'cicilan' => $this->input->post('cicilan'),
                'diskon' => str_replace(".", "", $this->input->post('diskon1')),
            );
            $this->session->set_tempdata($array, NULL, 600);
            redirect('Transaksibayar2');
        } else{
            $this->cek_nota();
        }
    }
    public function urus_dp(){
        $this->check_role();
        $this->clear();
        $this->data['kd_trans']=$this->input->post('kd_trans');
        $this->data['dp']=$this->input->post('dp');
        $this->data['cicilan_dp']=$this->input->post('cicilan_dp');
        $this->data['dp1']=$this->input->post('dp1');
        $this->data['diskon']=$this->input->post('diskon');
        $this->data['angsuran']=$this->input->post('angsuran');
        
        
        $this->form_validation->set_rules('dp', 'DP/UM', 'required', array('required' => 'Harus diisi', 'numeric'=>'Harus berupa angka'));
        $this->form_validation->set_rules('cicilan_dp', '', 'required|less_than[4]|greater_than[0]', array('required' => 'Harus diisi', 'numeric'=>'Harus berupa angka', 'less_than'=>'maksimal 3 kali', 'greater_than'=>'minimal 1 kali'));
        $this->form_validation->set_rules('dp1', '', 'required', array('required' => 'Harus diisi', 'numeric'=>'Harus berupa angka'));
        $this->form_validation->set_rules('diskon', '', '', array( 'numeric'=>'Harus berupa angka'));
        $this->form_validation->set_rules('angsuran', '', 'required|less_than[41]|greater_than[0]', array('required' => 'Harus diisi', 'numeric'=>'Harus berupa angka', 'greater_than' => 'Minimal 1 bulan', 'less_than' => 'Maksimal 40 bulan'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if($this->form_validation->run() == TRUE){
            $array = array(
                'kd_trans' => $this->input->post('kd_trans'),
                'nama' => $this->input->post('nama'),
                'tipe_bayar' => $this->input->post('tipe_bayar'),
                'nama_tanah' => $this->input->post('nama_tanah'),
                'dp' => str_replace(".", "", $this->input->post('dp')),
                'cicilan_dp' => $this->input->post('cicilan_dp'),
                'dp1' => str_replace(".", "", $this->input->post('dp1')),
                'diskon' => str_replace(".", "", $this->input->post('diskon')),
                'angsuran' => $this->input->post('angsuran')
            );
            $this->session->set_tempdata($array, NULL, 600);
            redirect('Transaksibayar2');
            /*
            $hasil = $this->Transaksi->update_booking($this->data['kd_trans'], $this->data['dp'],$this->data['cicilan_dp'], $this->data['angsuran'],$this->data['diskon']);
            if($hasil == 1){
                $this->data['kar_input']=$_SESSION['kd_kar'];
                $this->data['bayar_final']=this->input->post('dp1');
                $this->data['kd_trans']=$this->input->post('kd_trans');
                $this->Dp->insert();
                
            }
            */
        } else{
            $this->cek_nota();
        }
        
    }
    public function balik_nama(){
        $this->check_role();
        $this->clear();
        
        $this->form_validation->set_rules('balik_nama', '', 'required', array('required' => 'Harus diisi', 'number_separator'=>'Harus berupa angka'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if($this->form_validation->run() == TRUE){
            if(($this->input->post('submit') == "catatan")){
                $kd_nota = $this->Baliknama->get_last_code($this->input->post('kd_trans'));
                $hasil = $this->Catatan->insert( $this->input->post('kd_trans'),  $kd_nota->kd_nota, $this->input->post('catatan'));
                $this->cek_nota();
            }else{
                $array = array(
                    'kd_trans' => $this->input->post('kd_trans'),
                    'nama' => $this->input->post('nama'),
                    'tipe_bayar' => 5,
                    'nama_tanah' => $this->input->post('nama_tanah'),
                    'balik_nama' => $this->input->post('balik_nama'),
                    'ctr' => $this->input->post('ctr')
                );

                $this->session->set_tempdata($array, NULL, 600);
                redirect('Transaksibayar2');
            }
        }
    }
    public function search_kdtrans(){
        $nama = $this->input->post('keyword');
        
        //echo print_r($this->Transaksi->search_kdtrans($nama));
        
        echo json_encode($this->Transaksi->search_kdtrans($nama));
        //echo "a";
    }
    public function bayar_ppjb(){
        $this->check_role();
        $this->clear();
        $this->data['kd_trans']=$this->input->post('kd_trans');
        
        $this->form_validation->set_rules('ppjb', 'PPJB', 'required', array('required' => 'Harus diisi', 'number_separator'=>'Harus berupa angka'));
        $this->form_validation->set_rules('cbagen', '', 'required', array('required' => 'Harus dipilih', 'number_separator'=>'Harus berupa angka'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
        
        if($this->form_validation->run() == TRUE){
            $temp = explode(";", $this->input->post('cbagen'));
            $array = array(
                'kd_trans' => $this->input->post('kd_trans'),
                'nama' => $this->input->post('nama'),
                'tipe_bayar' => 6,
                'nama_tanah' => $this->input->post('nama_tanah'),
                'ppjb' => $this->input->post('ppjb'),
                'kd_agen' => $temp[0],
                'nm_agen' => $temp[2]
            );
          
            $this->session->set_tempdata($array, NULL, 600);
            redirect('Transaksiadmin2_2');
        } else{
            $this->cek_nota();
        }
    }
    public function number_separator($angka){
        return preg_match('/[0-9]{1,3}(\.([0-9]{1,3})){0,}/', $angka);
    }
    public function edit_header(){
        $this->data['kd_trans'] = $this->input->post('kd_trans');
        redirect('Editheader');
    }
    public function edit_ppjb(){
        $this->data['kd_nota'] = $this->input->post('kd_nota');
        $this->data['kd_trans'] = $this->input->post('kd_trans');
        $this->data['data_ppjb']= $this->Ppjb->get_ppjb($this->data['kd_trans']);
        $this->data['msg']= "";
        $this->data['agen']= $this->Karyawan->get_agen();
        
        $this->load->view('editppjb', $this->data);
    }
    public function update_ppjb(){
        $this->check_role();
        $this->clear();
        $this->data['kd_nota'] = $this->input->post('kd_nota');
        $this->data['kd_trans'] = $this->input->post('kd_trans');
        $this->data['ppjb'] = $this->input->post('ppjb');
        $this->data['tgl_bayar'] = $this->input->post('tgl_bayar');
        $this->data['kar_jual'] = $this->input->post('lbagen');
        $this->data['bonus_agen'] = $this->input->post('bonus_agen');
        $this->data['is_transfer'] = $this->input->post('is_transfer');

        
        if($this->input->post('kembali')==TRUE){
            $array = array(
                'master'=>$this->data['kd_trans']
            );
            $this->session->set_tempdata($array, null, 600);
            redirect('Transaksimaster/cek_nota');
        } else {
            $this->data['ppjb'] = str_replace(".", "", $this->data['ppjb']);
            $this->data['bonus_agen'] = str_replace(".", "", $this->data['bonus_agen']);
            $hasil = $this->Ppjb->update_ppjb($this->data['kd_nota'], $this->data['ppjb'], $this->data['tgl_bayar'], $this->data['kar_jual'], $this->data['bonus_agen'], $this->data['is_transfer']);
            if($hasil == 1){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown text-center' style='display:none;'>Update Berhasil</div>";
            }else{
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown text-center' style='display:none;'>Update Gagal</div>";
            }
            $this->data['data_ppjb']= $this->Ppjb->get_ppjb($this->data['kd_trans']);
            $this->data['agen']= $this->Karyawan->get_agen();
            $this->load->view('editppjb', $this->data);
        }
    }
    public function edit_baliknama(){
        $this->data['kd_nota'] = $this->input->post('kd_nota');
        $this->data['kd_trans'] = $this->input->post('kd_trans');
        $this->data['msg']= "";
        $this->data['bn']=$this->Baliknama->grab_data($this->data['kd_nota']);
        $this->load->view('editbaliknama', $this->data);
    }
     public function update_baliknama(){
        $this->check_role();
        $this->clear();
        $this->data['kd_nota'] = $this->input->post('kd_nota');
        $this->data['kd_trans'] = $this->input->post('kd_trans');
        $this->data['tgl_trans'] = $this->input->post('tgl_trans');
        $this->data['bayar'] = $this->input->post('bayar');
        $this->data['is_transfer'] = $this->input->post('is_transfer');
        $this->data['tgl_jatuhtempo'] = $this->input->post('tgl_jatuhtempo');
        if($this->input->post('kembali')==TRUE){
            $array = array(
                'master'=>$this->data['kd_trans']
            );
            $this->session->set_tempdata($array, null, 600);
            redirect('Transaksimaster/cek_nota');
        } else {
            $this->data['bayar'] = str_replace(".", "", $this->data['bayar']);
            
            $hasil = $this->Baliknama->update_bn($this->data['kd_nota'], $this->data['tgl_trans'], $this->data['bayar'], $this->data['is_transfer'], $this->data['tgl_jatuhtempo']);
            if($hasil == 1){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown text-center' style='display:none;'>Update Berhasil</div>";
            }else{
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown text-center' style='display:none;'>Update Gagal</div>";
            }
            $this->data['bn']=$this->Baliknama->grab_data($this->data['kd_nota']);
            $this->load->view('editbaliknama', $this->data);
        }
    }
   
    public function edit_nota(){
        $this->check_role();
        $this->clear();
        $this->data['kd_nota'] = $this->input->post('kd_nota');
        $this->data['kd_trans'] = $this->input->post('kd_trans');
        $this->data['msg']= "";
        $this->data['denda']= "";
        $temp = substr($this->data['kd_nota'],0,1);
        
        if($temp == "D"){
            $this->data['nota']=$this->Dp->grab_data($this->data['kd_nota']);
        }else if($temp == "C"){
            $this->data['nota']=$this->Cash->grab_data($this->data['kd_nota']);
        }else if($temp == "I"){
            $this->data['nota']=$this->Cicilan->grab_data($this->data['kd_nota']);
        }   
        $this->load->view('editpembayaran', $this->data);
    }
    public function update_nota(){
        $this->check_role();
        $this->clear();
        $this->data['kd_nota'] = $this->input->post('kd_nota');
        $this->data['kd_trans'] = $this->input->post('kd_trans');
        $this->data['tgl_trans'] = $this->input->post('tgl_trans');
        $this->data['bayar'] = $this->input->post('bayar');
        $this->data['jatuh_tempo'] = $this->input->post('jatuh_tempo');
        $this->data['denda'] = $this->input->post('denda');
        $this->data['is_transfer'] = $this->input->post('is_transfer');

        if($this->input->post('kembali')==TRUE){
            $array = array(
                'master'=>$this->data['kd_trans']
            );
            $this->session->set_tempdata($array, null, 600);
            redirect('Transaksimaster/cek_nota');
        } else {
            $temp = substr($this->data['kd_nota'],0,1);
            $this->data['bayar'] = str_replace(".", "", $this->data['bayar']);
            $this->data['denda'] = str_replace(".", "", $this->data['denda']);
            if($temp == "D"){
                $hasil = $this->Dp->update_dp($this->data['kd_nota'], $this->data['tgl_trans'], $this->data['bayar'], $this->data['jatuh_tempo'], $this->data['is_transfer']);
            }else if($temp == "C"){
                $hasil = $this->Cash->update_cash($this->data['kd_nota'], $this->data['tgl_trans'], $this->data['bayar'], $this->data['jatuh_tempo'], $this->data['is_transfer']);
            }else if($temp == "I"){
                $hasil = $this->Cicilan->update_cicil($this->data['kd_nota'], $this->data['tgl_trans'], $this->data['bayar'], $this->data['jatuh_tempo'], $this->data['denda'], $this->data['is_transfer']);
            }
            if($hasil == 1){
                $this->data['msg'] = "<div id='err_msg' class='alert alert-success sldown text-center' style='display:none;'>Update Berhasil</div>";
            }else{
                $this->data['msg'] = "<div id='err_msg' class='alert alert-danger sldown text-center' style='display:none;'>Update Gagal</div>";
            }

            if($temp == "D"){
                $this->data['nota']=$this->Dp->grab_data($this->data['kd_nota']);
            }else if($temp == "C"){
                $this->data['nota']=$this->Cash->grab_data($this->data['kd_nota']);
            }else if($temp == "I"){
                $this->data['nota']=$this->Cicilan->grab_data($this->data['kd_nota']);
            }   
            $this->load->view('editpembayaran', $this->data);
        }
    }
    public function hapus_transaksi(){
        $this->clear();
        $hasil = $this->Transaksi->hapus_transaksi($this->input->post('kd_trans'));
        $this->show();
    }
}

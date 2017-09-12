<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editheader extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('trans');
        $this->load->model('Timeout');
        $this->load->model('Transaksi');
        $this->load->model('Customer');
        $this->load->model('Blok');
        $this->load->model('Tanah');
        $this->load->model('Gantibayar');
    }
    private $data;
	public function index()
	{
        if($this->input->post('kd_trans')== ""){
            redirect('Transaksimaster');
        }
        $this->check_role();
        $this->clear();
        $this->show();
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
    public function clear(){
        $this->data['tipe']="";
        $this->data['msg']="";
        $this->data['show_range']="none";
        $this->data['show_bulan']="none";
        $this->data['$tb_bulanbaliknama']="";
        $this->data['$tb_biayabaliknama']="";
    }
    public function get_tanah(){
        $kode = $this->input->post('keyword');
        $kd_trans = $this->input->post('kd_trans');
        echo json_encode($this->Tanah->show_all_available_except_one($kode,$kd_trans));
    }
    public function show(){
        $this->data['cust']=$this->Customer->show_all();
        $this->data['blok']=$this->Blok->show_all_available_except_one($this->input->post('kd_trans'));
        $this->load->view('editheader', $this->data);
    }
    public function show_header(){
        $this->check_role();
        $this->clear();
        $this->data['kd_trans']= $this->input->post('kd_trans');
        $this->data['header'] = $this->Transaksi->cek_header_transaksi($this->data['kd_trans']);
        $this->data['hd_kode'] =  $this->data['header']->kd_cust;
        $this->data['hd_nama'] =  $this->data['header']->nama;
        $this->data['cb_tanah'] =  $this->data['header']->kd_tanah;
        $this->data['cb_blok'] =  $this->data['header']->kd_blok;
        $this->data['tipe'] = $this->data['header']->tipe;
        $this->data['harga'] = $this->data['header']->harga;
        $this->data['dp'] = $this->data['header']->dp;
        $this->data['dp_cicilan'] = $this->data['header']->dp_cicilan;
        $this->data['diskon'] = $this->data['header']->diskon;
        $this->data['cicilan'] = $this->data['header']->cicilan;
        $this->data['tipe_bayar'] = $this->data['header']->tipe_bayar;
        $this->data['tb_bulanbaliknama'] = $this->data['header']->cicilan_baliknama;
        $this->data['tb_biayabaliknama'] = $this->data['header']->besar_baliknama;
        $this->show();
    }
    public function update_header(){
        $this->check_role();
        $this->clear();
        $this->data['kd_trans']= $this->input->post('kd_trans');
        $this->data['header'] = $this->Transaksi->cek_header_transaksi($this->data['kd_trans']);
        $this->data['hd_kode'] =  $this->input->post('hd_kode');
        $this->data['hd_nama'] =  $this->input->post('hd_nama');
        $this->data['cb_tanah'] =  $this->input->post('cb_tanah');
        $this->data['cb_blok'] =  $this->input->post('cb_blok');
        $this->data['tipe'] = $this->input->post('tipe');
        $this->data['harga'] = str_replace(".", "", $this->input->post('harga'));
        $this->data['dp'] = str_replace(".", "", $this->input->post('dp'));
        $this->data['dp_cicilan'] = $this->input->post('dp_cicilan');
        $this->data['diskon'] = str_replace(".", "", $this->input->post('diskon'));
        $this->data['cicilan'] = $this->input->post('cicilan');
        $this->data['tipe_bayar'] = $this->input->post('tipe_bayar');
        $this->data['tb_bulanbaliknama'] = $this->input->post('tb_bulanbaliknama');
        $this->data['tb_biayabaliknama'] = $this->input->post('tb_biayabaliknama');

        if(($this->input->post('kembali'))== TRUE){
            $array = array(
                'master' => $this->input->post('kd_trans')
            );
            $this->session->set_tempdata($array, NULL, 600);
            redirect('Transaksimaster/cek_nota');
        }else{
            if(($this->data['header']->tipe_bayar == 1 && $this->data['tipe_bayar'] == 2)){
                $hasil = $this->Transaksi->update_header($this->data['header'], $this->data['hd_kode'], $this->data['cb_tanah'], $this->data['tipe'], $this->data['harga'], $this->data['dp'], $this->data['dp_cicilan'], $this->data['diskon'], $this->data['cicilan'], 1, $this->data['tb_bulanbaliknama'], $this->data['tb_biayabaliknama']);
            }else{
                $this->Gantibayar->insert($this->input->post('kd_trans'), $this->data['header']->tipe_bayar , $_SESSION['kd_kar']);
                $hasil = $this->Transaksi->update_header($this->data['header'], $this->data['hd_kode'], $this->data['cb_tanah'], $this->data['tipe'], $this->data['harga'], $this->data['dp'], $this->data['dp_cicilan'], $this->data['diskon'], $this->data['cicilan'], $this->data['tipe_bayar'], $this->data['tb_bulanbaliknama'], $this->data['tb_biayabaliknama']);
            }
            $this->show();
        }
    }
    
}

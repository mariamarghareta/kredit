<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporancicilannunggak extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('trans');
        $this->load->model('Timeout');
        $this->load->model('Pendapatan');
        $this->load->model('Blok');
        $this->load->model('DP');
        $this->load->model('Cicilan');
        $this->load->model('Catatan');
    }
    private $data;
    public function index()
    {
        $this->check_role();
        $this->clear();
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('GMT+7'));

        //$this->data['arr'] = $this->Pendapatan->detail_gabungan("all", "" , "bulan",$date->format("m") ."-".$date->format("Y"),"", "kav_all","");
        //$this->get_subdetail("all", "" , "bulan",$date->format("m") ."-".$date->format("Y"),"","kav_all", "");
        //$this->show_data($hasil);

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
        $this->data['kavling'] = $this->Blok->show_all();

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('GMT+7'));
        $this->data['bulan'] = $date->format("m");
        $this->data['tahun'] = $date->format("Y");
        $this->data['detail'] = null;
        $this->data['kavling'] = $this->Blok->show_all();
        $this->data['select_kav'] = null;
    }
    public function show(){

        $this->load->view('laporancicilannunggak', $this->data);
    }

    public function search(){
        $this->check_role();
        $this->clear();
        $this->data['select_kav'] = $this->input->post('select_kav');
        $this->data['bulan'] = $this->input->post('bulan');
        $this->data['tahun'] = $this->input->post('tahun');
        $this->data['arr'] = $this->Cicilan->get_jatuh_tempo($this->data['bulan'], $this->data['tahun'], $this->data['select_kav']);
        $this->get_subdetail();

        $this->show();

    }
    public function get_subdetail(){
        if($this->data['arr'] > 0){
            foreach($this->data['arr'] as $row){
                $this->data['detail'][$row['kd_trans']][0] = $row;
                $this->data['detail'][$row['kd_trans']][1] = $this->Catatan->get_catatan($row["kd_nota"]);
            }
        }
    }
    public function print_laporan(){
        $this->check_role();
        $this->clear();
        $this->data['select_kav'] = $this->input->post('select_kav');
        $this->data['bulan'] = $this->input->post('bulan');
        $this->data['tahun'] = $this->input->post('tahun');
        $this->data['arr'] = $this->Cicilan->get_jatuh_tempo($this->data['bulan'], $this->data['tahun'], $this->data['select_kav']);
        $this->get_subdetail();

        $this->load->view('laporancicilannunggakprint', $this->data);

    }

    public function lihat_detail(){
        //echo $this->input->post('kd_trans');
        $array = array(
            'master' => $this->input->post('kd_trans')
        );
        $this->session->set_tempdata($array, NULL, 300);
        redirect('Transaksimaster/cek_nota');
    }
    public function logout(){
        session_destroy();
        redirect('Welcome');
        //echo "log out";
    }
}

<?php
class Cicilan extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function cek_detail_transaksi($kd_trans){
        $query = $this->db->select("i.kd_nota, i.kd_trans, DATE_FORMAT(i.tgl_trans, '%d-%m-%Y') as tgl_trans, i.bayar, i.denda, DATE_FORMAT(i.jatuh_tempo, '%d-%m-%Y') as jatuh_tempo, kar.kd_kar, kar.nama")
                ->from('cicilan i')
                ->join('karyawan kar', 'kar.kd_kar = i.kd_kar')
                ->where('kd_trans', $kd_trans)
                ->order_by("i.tgl_trans","ASC")
                ->get()
                ->result_array();
            return $query;
    }
    public function insert($data){
        $tgl_trans = date('Y-m-d');
        $query = array(
            'kd_trans' =>$data['kd_trans'],
            'tgl_trans'=> date('Y-m-d',strtotime($data['tgl_bayar'])),
            'bayar'=> $data['bayar_final'],
            'jatuh_tempo'=> date('Y-m-d',strtotime($data['jatuh_tempo'])),
            'kd_kar'=>$data['kar_input'],
            'deleted'=>0,
            'denda'=>$data['denda']
        );

        $query = $this->db->insert('cicilan', $query);
        
        if($query == 1){
            return $this->get_kode($data);
        }else{
            return null;
        }
        
    }
    private function get_kode($data){
        $query = $this->db->select('*',1)
                ->from('cicilan')
                ->where('kd_trans',$data['kd_trans'])
                ->where('bayar',$data['bayar_final'])
                ->where('kd_kar',$data['kar_input'])
                ->where('tgl_trans',date('Y-m-d',strtotime($data['tgl_bayar'])))
                ->where('jatuh_tempo',date('Y-m-d',strtotime($data['jatuh_tempo'])))
                ->where('deleted',0)
                ->order_by("updated","DESC")
                ->get()
                ->row();
        return $query;
    }
    public function get_bayar($kd_trans){
        $query = $this->db->select('sum(bayar) as bayar')
                ->from('cicilan')
                ->where('kd_trans',$kd_trans)
                ->get()
                ->row();
        return $query;
    }
    public function get_denda($kd_trans){
        $query = $this->db->select('sum(denda) as denda')
                ->from('cicilan')
                ->where('kd_trans',$kd_trans)
                ->get()
                ->row();
        return $query;
    }
    public function get_latest_denda($kd_trans){
        $query = $this->db->select('denda',1)
                ->from('cicilan')
                ->where('kd_trans',$kd_trans)
                ->order_by("updated","DESC")
                ->get()
                ->row();
        return $query;
    }
    public function get_bayar_denda($kd_trans){
        $query = $this->db->select('sum(bayar_denda) as bayar_denda')
                ->from('cicilan')
                ->where('kd_trans',$kd_trans)
                ->get()
                ->row();
        return $query;
    }
    public function grab_data($kd_nota){
        $query = $this->db->select('kd_nota, kd_trans, denda, DATE_FORMAT(tgl_trans, "%d-%m-%Y") as tgl_trans, bayar, DATE_FORMAT(jatuh_tempo, "%d-%m-%Y") as jatuh_tempo, kd_kar, updated, deleted')
                ->from('cicilan')
                ->where('kd_nota',$kd_nota)
                ->where('deleted',0)
                ->get()
                ->row();
        return $query;
    }
    public function update_cicil($kd_nota, $tgl_trans, $bayar, $jatuh_tempo, $denda){
         $array = array(
            'tgl_trans' => date('Y-m-d',strtotime($tgl_trans)),
            'bayar' => $bayar,
            'jatuh_tempo' => date('Y-m-d',strtotime($jatuh_tempo)),
            'denda' => $denda
        );
        $this->db->where('kd_nota', $kd_nota);
        return $this->db->update('cicilan', $array);
    }
}
?>
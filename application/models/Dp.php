<?php
class Dp extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert($data){
        $tgl_trans = date('Y-m-d');
        $query = array(
            'kd_trans' =>$data['kd_trans'],
            'tgl_trans'=> $tgl_trans,
            'bayar'=> $data['bayar_final'],
            'kd_kar'=> $data['kar_input'],
            'jatuh_tempo'=> date('Y-m-d',strtotime($data['jatuh_tempo'])),
            'tgl_trans'=> date('Y-m-d',strtotime($data['tgl_bayar'])),
            'deleted'=>0,
            'is_transfer' => $data['is_transfer']
        );

        $query = $this->db->insert('dp', $query);
        if($query == 1){
            return $this->get_kode($data);
        }else{
            return null;
        }
        
    }
    public function get_jumlah($kd_trans){
        $query = $this->db->select('count(*) as jumlah')
            ->where('kd_trans', $kd_trans)
            ->from('dp')
            ->get()
            ->row();
        return $query;
    }
    private function get_kode($data){
        $query = $this->db->select('*', 1)
                ->from('dp')
                ->where('kd_trans',$data['kd_trans'])
                ->where('bayar',$data['bayar_final'])
                ->where('kd_kar',$data['kar_input'])
                ->where('jatuh_tempo',date('Y-m-d',strtotime($data['jatuh_tempo'])))
                ->where('tgl_trans',date('Y-m-d',strtotime($data['tgl_bayar'])))
                ->where('deleted',0)
                ->order_by("updated","DESC")
                ->get()
                ->row();
        return $query;
    }
    public function grab_data($kd_nota){
        $query = $this->db->select('kd_nota, kd_trans, DATE_FORMAT(tgl_trans, "%d-%m-%Y") as tgl_trans, bayar, DATE_FORMAT(jatuh_tempo, "%d-%m-%Y") as jatuh_tempo, kd_kar, updated, deleted')
                ->from('dp')
                ->where('kd_nota',$kd_nota)
                ->where('deleted',0)
                ->get()
                ->row();
        return $query;
    }
    public function update_dp($kd_nota, $tgl_trans, $bayar, $jatuh_tempo){
         $array = array(
            'tgl_trans' => date('Y-m-d',strtotime($tgl_trans)),
            'bayar' => $bayar,
            'jatuh_tempo' => date('Y-m-d',strtotime($jatuh_tempo))
        );
        $this->db->where('kd_nota', $kd_nota);
        return $this->db->update('dp', $array);
    }
   
}
?>
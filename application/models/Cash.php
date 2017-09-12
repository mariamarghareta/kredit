<?php
class Cash extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert($data){
        $tgl_trans = date('Y-m-d');
        if ($data["is_transfer"] == null){$data["is_transfer"] = 0;}
        $query = array(
            'kd_trans' =>$data['kd_trans'],
            'bayar'=> $data['bayar_final'],
            'jatuh_tempo'=> date('Y-m-d',strtotime($data['jatuh_tempo'])),
            'tgl_trans'=> date('Y-m-d',strtotime($data['tgl_bayar'])),
            'kd_kar'=>$data['kar_input'],
            'deleted'=>0,
            'is_transfer' => $data['is_transfer']
        );

        $query = $this->db->insert('cash', $query);
        
        if($query == 1){
            return $this->get_kode($data);
        }else{
            return null;
        }
        
    }
    public function grab_data_kodenama($kode){
        $query = $this->db->select('*')
                ->from('transaksi')
                ->where('kd_tanah',$kode)
                ->where('deleted',0)
                ->get();
        return $query->result_array();
    }
    private function get_kode($data){
        $query = $this->db->select('*', 1)
                ->from('cash')
                ->where('kd_trans',$data['kd_trans'])
                ->where('kd_kar',$data['kar_input'])
                ->where('bayar',$data['bayar_final'])
                ->where('jatuh_tempo',date('Y-m-d',strtotime($data['jatuh_tempo'])))
                ->where('tgl_trans',date('Y-m-d',strtotime($data['tgl_bayar'])))
                ->where('deleted',0)
                ->order_by("updated","DESC")
                ->get()
                ->row();
        return $query;
    }
    public function grab_data($kd_nota){
        $query = $this->db->select('kd_nota, kd_trans, DATE_FORMAT(tgl_trans, "%d-%m-%Y") as tgl_trans, bayar, DATE_FORMAT(jatuh_tempo, "%d-%m-%Y") as jatuh_tempo, kd_kar, updated, deleted, is_transfer')
                ->from('cash')
                ->where('kd_nota',$kd_nota)
                ->where('deleted',0)
                ->get()
                ->row();
        return $query;
    }
    public function update_cash($kd_nota, $tgl_trans, $bayar, $jatuh_tempo, $is_transfer){
         $array = array(
            'tgl_trans' => date('Y-m-d',strtotime($tgl_trans)),
            'bayar' => $bayar,
            'jatuh_tempo' => date('Y-m-d',strtotime($jatuh_tempo)),
             'is_transfer' => $is_transfer
        );
        $this->db->where('kd_nota', $kd_nota);
        return $this->db->update('cash', $array);
    }
}
?>
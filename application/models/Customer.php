<?php
class Customer extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function show_all(){
        $query = $this->db->select('kd_cust, ktp, nama, telp, telp2, telp3, alamat, kecamatan, kelurahan, rt, tempat_lahir, DATE_FORMAT(tgl_lahir, "%d-%m-%Y") as tgl_lahir, jenis')
                ->from('customer')
                ->where('deleted',0)
                ->get();
        return $query->result();
    }    
    public function show_all_name($nama){
        $query = $this->db->select('kd_cust, ktp, nama, telp, telp2, telp3 , alamat, kecamatan, kelurahan, rt, tempat_lahir, DATE_FORMAT(tgl_lahir, "%d-%m-%Y") as tgl_lahir, jenis')
                ->from('customer')
                /*->group_start()
                ->where('deleted',0)
                ->like('nama',$nama)
                ->group_end()
                ->group_start()
                ->or_where('deleted',0)
                ->like('ktp',$nama)
                ->group_end()*/
                ->group_start()
                ->or_like('nama',$nama)
                ->or_like('ktp',$nama)
                ->group_end()
                ->where('deleted',0)
                ->get();
        return $query->result();
    }
    public function insert($data){
        $data = array(
            'ktp' =>$data['ktp'],
            'nama'=> $data['nama'],
            'telp'=> $data['telp'],
            'telp2'=> $data['telp2'],
            'telp3'=> $data['telp3'],
            'tgl_lahir'=> date('Y-m-d',strtotime($data['tanggal'])),
            'tempat_lahir'=> $data['tempat'],
            'jenis'=> $data['gen'],
            'alamat'=> $data['alamat'],
            'rt'=> $data['rt'],
            'kecamatan'=> $data['kec'],
            'kelurahan'=> $data['kel']
        );
        $query = $this->db->insert('customer', $data);
        return $query;
    }
   
    public function cek_kembar($kode, $cust){
        $this->db->from('customer');
        $this->db->where('ktp', $kode);
        $this->db->where('deleted', 0);
        $this->db->where('kd_cust!=', $cust);
        $query = $this->db->count_all_results();
        
        if($query >= 1){
            return false;
        } else {
            return true;
        }
    }
    public function grab_data($kode){
         $query = $this->db->select('kd_cust, ktp, nama, telp, telp2, telp3 , alamat, kecamatan as kec, kelurahan as kel, rt, tempat_lahir as tempat, DATE_FORMAT(tgl_lahir, "%d-%m-%Y") as tanggal, jenis as gen')
                ->from('customer')
                ->where('kd_cust',$kode)
                ->where('deleted',0)
                ->get();
        return $query->result_array();
    } 
   
    public function update_data($data){
        $query = array(
            'ktp' =>$data['ktp'],
            'nama'=> $data['nama'],
            'telp'=> $data['telp'],
            'telp2'=> $data['telp2'],
            'telp3'=> $data['telp3'],
            'tgl_lahir'=> date('Y-m-d',strtotime($data['tanggal'])),
            'tempat_lahir'=> $data['tempat'],
            'jenis'=> $data['gen'],
            'alamat'=> $data['alamat'],
            'rt'=> $data['rt'],
            'kecamatan'=> $data['kec'],
            'kelurahan'=> $data['kel']
        );
        $this->db->where('kd_cust', $data['kd_cust']);
        return $this->db->update('customer', $query);
    }
    public function delete_data($kode){
        $data = array(
            'deleted' => 1
        );
        $this->db->where('kd_cust', $kode);
        return $this->db->update('customer', $data);
    }
}
?>
<?php
class Jenispengeluaran extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert($nama){
        $array = array(
            'name'=>$nama
        );
        $query = $this->db->insert('jenispengeluaran', $array);
        return $query;
    }
    public function update($kd, $nama){
        $array = array(
            'name'=>$nama
        );
        $this->db->where('id', $kd);
        $query = $this->db->update('jenispengeluaran', $array);
        return $query;
    }
    public function delete($kd){
        $array = array(
            'deleted'=>1
        );
        $this->db->where('id', $kd);
        $query = $this->db->update('jenispengeluaran', $array);
        return $query;
    }
   
    public function show_all(){
        $query = $this->db->select('*')
                ->from('jenispengeluaran')
                ->where('deleted','0')
                //->limit(50, 0)
                ->get();
        return $query->result();
    }    
    public function show_preview(){
        $query = $this->db->select('*')
                ->from('jenispengeluaran')
                ->where('deleted','0')
                ->limit(30, 0)
                ->get();
        return $query->result();
    }
    public function get_one_data($kd_jenis){
        $query = $this->db->select("*")
            ->from('jenispengeluaran p')
            ->where('deleted','0')
            ->where('p.id', $kd_jenis)
            ->order_by("id","asc")
            ->get()
            ->row();
        return $query;
    }

}
?>
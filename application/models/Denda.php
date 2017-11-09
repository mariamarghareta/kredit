<?php
class Denda extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_nominal()
    {
        $query = $this->db->select('nominal')
            ->from('denda')
            ->where('id',1)
            ->get()
            ->row();
        return $query;
    }
    public function change_nominal($harga){
        $data = array(
            'nominal' => $harga
        );
        return $this->db->update('denda', $data);
    }
}
?>
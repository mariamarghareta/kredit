<?php
class Timeout extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_time()
    {
       $query = $this->db->select('lama')
           ->from('timeout')
           ->get()
           ->row();
        return $query;
    }
    public function change_time($waktu){
        $data = array(
            'lama' => $waktu
        );
        return $this->db->update('timeout', $data);
    }
}
?>
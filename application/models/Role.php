<?php
class Role extends CI_Model {

    
    public $kd_role;
    public $nama_role;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function show_all(){
        $query = $this->db->select('*')
                ->from('role')
                ->get();
        return $query->result();
    }    
    
        

}
?>
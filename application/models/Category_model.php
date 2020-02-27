<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($where=[], $limit='', $offset='')
    {
        $query = $this->db->get_where('category', $where, $limit, $offset);

        return $query->result();
    }
    
    public function delete($where=[])
    {
        $this->db->delete('category', $where);
        return $this->db->affected_rows();
    }
    
    public function insert($data)
    {
        clean_empty_field($data);
        $this->db->insert('category', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updatedAt'] = date('Y-m-d H:i:s');
        clean_empty_field($data);
        $this->db->update('category', $data, array('id_category' => $id));
        return $this->db->affected_rows();
    }
}
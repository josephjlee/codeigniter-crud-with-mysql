<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($where=[], $limit='', $offset='')
    {
        $this->db->select('p.*, c.name AS category');
        $this->db->from('product p');
        $this->db->join('category c', 'c.id_category = p.id_category');
        $this->db->where($where);
        $query = $this->db->get('', $limit, $offset);

        return $query->result();
    }

    public function delete($where=[])
    {
        $this->db->delete('product', $where);
        return $this->db->affected_rows();
    }
    
    public function insert($data)
    {
        clean_empty_field($data);
        $this->db->insert('product', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updatedAt'] = date('Y-m-d H:i:s');
        clean_empty_field($data);
        $this->db->update('product', $data, array('id_product' => $id));
        return $this->db->affected_rows();
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM category';
        return $this->db->query(trim($sql));
    }
    
    public function getOne($where="")
    {
        $sql = "SELECT * FROM category {$where}";
        return $this->db->query($sql);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM category WHERE id_category = ?';
        $prm = [$id];
        $this->db->query($sql, $prm);
        return $this->db->affected_rows();
    }
    
    public function insert($data)
    {
        $sql = 'INSERT INTO category (name, url) VALUES (?,?)';
        $prm = [$data['name'], $data['url']];
        $this->db->query($sql, $prm);
        return $this->db->insert_id();
    }

    public function update($data)
    {
        $sql = 'UPDATE category SET name = ?, url = ?, updatedAt = ? WHERE id_category = ?';
        $prm = [$data['name'], $data['url'], date('Y-m-d H:i:s'), $data['id_category']];
        $this->db->query($sql, $prm);
        return $this->db->affected_rows();
    }
}
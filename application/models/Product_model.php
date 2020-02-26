<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $sql = 
        '
            SELECT p.id_product, c.name AS category, p.name,
                p.description, p.price, p.url, p.createdAt, p.updatedAt 
            FROM product p
            JOIN category c ON (c.id_category = p.id_category)
        ';
        return $this->db->query(trim($sql));
    }
    
    public function getOne($where="")
    {
        $sql = "SELECT * FROM product {$where}";
        return $this->db->query($sql);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM product WHERE id_product = ?';
        $prm = [$id];
        $this->db->query($sql, $prm);
        return $this->db->affected_rows();
    }
    
    public function insert($data)
    {
        $sql = 'INSERT INTO product (id_category, name, description, price, url) VALUES (?,?,?,?,?)';
        $prm = [$data['id_category'], $data['name'], $data['description'], $data['price'], $data['url']];
        $this->db->query($sql, $prm);
        return $this->db->insert_id();
    }

    public function update($data)
    {
        $sql = 'UPDATE product SET id_category = ?, name = ?, description = ?, price = ?, url = ?, updatedAt = ? WHERE id_product = ?';
        $prm = [$data['id_category'], $data['name'], $data['description'], $data['price'], $data['url'], date('Y-m-d H:i:s'), $data['id_product']];
        $this->db->query($sql, $prm);
        return $this->db->affected_rows();
    }
}
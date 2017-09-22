<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Product_model.php
* Handles database interations for products
* Mark Hiscock 10.03.17
*/

class Product_model extends CI_Model{

    /*******************************************************************************
    * Get all products
    *******************************************************************************/
    public function get_all()
    {
        // Build query
        $sql = 'SELECT * FROM products ORDER BY product_name';

        // Execute
        $query = $this->db->query($sql);

        // Return result
        return $query->result_array();
    }


    /*******************************************************************************
    * Get all products - Join collection name
    *******************************************************************************/
    public function get_all_join_collection()
    {
        // Build query
        $sql = 'SELECT product_id, product_name, product_published, collection_name FROM products ';
        $sql .= 'LEFT JOIN collections ON products.collection_id = collections.collection_id';

        // Execute
        $query = $this->db->query($sql);

        // Return result
        return $query->result_array();
    }


    /*******************************************************************************
    * Get product by id
    *******************************************************************************/
    public function get_by_id($id)
    {
        // Build query
        $sql = 'SELECT * FROM products WHERE product_id = ?';

        // Execute
        $query = $this->db->query($sql, array($id));

        // return single result
        return $query->row_array();
    }


    /*******************************************************************************
    * Get products by collection ID
    *******************************************************************************/
    public function get_by_collection($collection_id)
    {
        // Build query
        $sql = 'SELECT product_name, product_slug, product_price_low, product_price_high, image_filename FROM products ';
        $sql .= 'LEFT JOIN images ON products.image_id = images.image_id ';
        $sql .= 'WHERE collection_id = ? AND product_published = 1';

        // Execute
        $query = $this->db->query($sql, array($collection_id));

        // return single result
        return $query->result_array();
    }


    /*******************************************************************************
    * Get products by slug
    *******************************************************************************/
    public function get_by_slug($slug)
    {
        // Build query
        $sql = 'SELECT product_name, product_description, product_paypal_html, image_filename, ';
        $sql .= ' product_price_low, product_price_high, collection_name, collection_slug FROM products ';
        $sql .= 'LEFT JOIN images ON products.image_id = images.image_id ';
        $sql .= 'LEFT JOIN collections ON products.collection_id = collections.collection_id ';
        $sql .= 'WHERE product_slug = ?';

        // Execute
        $query = $this->db->query($sql, array($slug));

        // return single result
        return $query->row_array();
    }


    /*******************************************************************************
    * Adds new product
    *******************************************************************************/
    public function add($data)
    {
        // Build query
        $sql = 'INSERT INTO products (
            product_name,
            product_slug,
            product_description,
            product_price_low,
            product_price_high,
            product_published,
            product_paypal_html,
            collection_id,
            image_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        // Execute
        $this->db->query($sql, array(
            $data['product_name'],
            $data['product_slug'],
            $data['product_description'],
            $data['product_price_low'],
            $data['product_price_high'],
            $data['product_published'],
            $data['product_paypal_html'],
            $data['collection_id'],
            $data['image_id']
            ));
    }


    /*******************************************************************************
    * Update collection
    *******************************************************************************/
    public function update($data)
    {
        // Build query
        $sql = 'UPDATE products SET 
            product_name = ?,
            product_slug = ?,
            product_description = ?,
            product_price_low = ?,
            product_price_high = ?,
            product_published = ?,
            product_paypal_html = ?,
            collection_id = ?,
            image_id = ? WHERE product_id = ?';

        // Execute
        $this->db->query($sql, array(
            $data['product_name'],
            $data['product_slug'],
            $data['product_description'],
            $data['product_price_low'],
            $data['product_price_high'],
            $data['product_published'],
            $data['product_paypal_html'],
            $data['collection_id'],
            $data['image_id'],
            $data['product_id']
            ));
    }


    /*******************************************************************************
    * Get number of published products
    *******************************************************************************/
    public function get_num_published()
    {
        // Build query
        $sql = 'SELECT COUNT(*) AS num_products FROM products WHERE product_published = 1';

        // Execute
        $query = $this->db->query($sql);

        // return single result
        return $query->row_array();
    }
}
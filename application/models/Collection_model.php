<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Collection_model.php
* Handles database interations for collections
* Mark Hiscock 08.03.17
*/

class Collection_model extends CI_Model{

    /*******************************************************************************
    * Get all collections
    *******************************************************************************/
    public function get_all()
    {
        // Build query
        $sql = 'SELECT * FROM collections ORDER BY collection_name';

        // Execute
        $query = $this->db->query($sql);

        // Return result
        return $query->result_array();
    }


    /*******************************************************************************
    * Get collection by id
    *******************************************************************************/
    public function get_by_id($id)
    {
        // Build query
        $sql = 'SELECT * FROM collections WHERE collection_id = ?';

        // Execute
        $query = $this->db->query($sql, array($id));

        // return single result
        return $query->row_array();
    }


    /*******************************************************************************
    * Get collection by id with image
    *******************************************************************************/
    public function get_by_id_join_image($id)
    {
        // Build query
        $sql = 'SELECT collection_id, collection_name, collection_description, collection_featured, collection_published, ';
        $sql .= 'collections.image_id, image_filename FROM collections ';
        $sql .= 'LEFT JOIN images ON collections.image_id = images.image_id ';
        $sql .= 'WHERE collection_id = ?';

        // Execute
        $query = $this->db->query($sql, array($id));

        // return single result
        return $query->row_array();
    }


    /*******************************************************************************
    * Get collection id by slug
    *******************************************************************************/
    public function get_by_slug($slug)
    {
        // Build query
        $sql = 'SELECT * FROM collections WHERE collection_slug = ?';

        // Execute
        $query = $this->db->query($sql, array($slug));

        // return single result
        return $query->row_array();
    }

    /*******************************************************************************
    * Adds new collection
    *******************************************************************************/
    public function add($data)
    {
        // Build query
        $sql = 'INSERT INTO collections (
            collection_name,
            collection_slug,
            collection_description,
            collection_featured,
            collection_published,
            image_id
        ) VALUES (?, ?, ?, ?, ?, ?)';

        // Execute
        $this->db->query($sql, array(
            $data['collection_name'],
            $data['collection_slug'],
            $data['collection_description'],
            $data['collection_featured'],
            $data['collection_published'],
            $data['image_id']
            ));
    }


    /*******************************************************************************
    * Update collection
    *******************************************************************************/
    public function update($data)
    {
        // Build query
        $sql = 'UPDATE collections SET 
            collection_name = ?,
            collection_slug = ?,
            collection_description = ?,
            collection_featured = ?,
            collection_published = ?,
            image_id = ? WHERE collection_id = ?';

        // Execute
        $this->db->query($sql, array(
            $data['collection_name'],
            $data['collection_slug'],
            $data['collection_description'],
            $data['collection_featured'],
            $data['collection_published'],
            $data['image_id'],
            $data['collection_id']
            ));
    }


    /*******************************************************************************
    * Get collection for store front page
    *******************************************************************************/
    public function get_store_front_page()
    {
        // Build query
        $sql = 'SELECT collection_name, collection_slug, image_filename, COUNT(product_id) AS num_products ';
        $sql .= 'FROM collections ';
        $sql .= 'LEFT JOIN images ON collections.image_id = images.image_id ';
        $sql .= 'LEFT JOIN products ON collections.collection_id = products.collection_id ';
        $sql .= 'WHERE collection_published = 1 ';
        $sql .= 'GROUP BY collection_name, collection_slug, image_filename';

        // Execute
        $query = $this->db->query($sql);

        // Return result
        return $query->result_array();
    }


    /*******************************************************************************
    * Get featured collections for home page
    *******************************************************************************/
    public function get_featured()
    {
        // Build query
        $sql = 'SELECT collection_name, collection_slug, image_filename, COUNT(product_id) AS num_products ';
        $sql .= 'FROM collections ';
        $sql .= 'LEFT JOIN images ON collections.image_id = images.image_id ';
        $sql .= 'LEFT JOIN products ON collections.collection_id = products.collection_id ';
        $sql .= 'WHERE collection_published = 1 AND collection_featured = 1 ';
        $sql .= 'GROUP BY collection_name, collection_slug, image_filename ';
        $sql .= 'LIMIT 3';

        // Execute
        $query = $this->db->query($sql);

        // Return result
        return $query->result_array();
    }


    /*******************************************************************************
    * Get number of published collection
    *******************************************************************************/
    public function get_num_published()
    {
        // Build query
        $sql = 'SELECT COUNT(*) AS num_collections FROM collections WHERE collection_published = 1';

        // Execute
        $query = $this->db->query($sql);

        // return single result
        return $query->row_array();
    }
}
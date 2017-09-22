<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Image_model.php
* Handles database interations for images
* Mark Hiscock 06.03.17
*/

class Image_model extends CI_Model{

    /*******************************************************************************
    * Get all images
    *******************************************************************************/
    public function get_all()
    {
        // Build query
        $sql = 'SELECT * FROM images';

        // Execute
        $query = $this->db->query($sql);

        // Return result
        return $query->result_array();
    }


    /*******************************************************************************
    * Get single images by ID
    *******************************************************************************/
    public function get_by_id($id)
    {
        // Build query
        $sql = 'SELECT * FROM images WHERE image_id = ?';

        // Execute
        $query = $this->db->query($sql, array($id));

        // return single result
        return $query->row_array();
    }

    /*******************************************************************************
    * Adds new image
    *******************************************************************************/
    public function add($data)
    {
        // Build query
        $sql = 'INSERT INTO images (image_filename) VALUES (?)';

        // Execute
        $this->db->query($sql, array($data['image_filename']));

        // Return ID of inserted image
        return $this->db->insert_id();
    }
}
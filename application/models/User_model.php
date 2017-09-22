<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* User_model.php
* Handles database interations for users
* Mark Hiscock 31.03.17
*/

class User_model extends CI_Model{

    /*******************************************************************************
    * Get user by email
    *******************************************************************************/
    public function get_by_email($email)
    {
        // Build query
        $sql = 'SELECT * FROM users WHERE user_email = ?';

        // Execute
        $query = $this->db->query($sql, array($email));

        // return single result
        return $query->row_array();
    }


    /*******************************************************************************
    * Adds new user
    *******************************************************************************/
    public function add($email, $hash)
    {
        // Build query
        $sql = 'INSERT INTO users (user_email, user_hash) VALUES (?, ?)';

        // Execute
        $this->db->query($sql, array($email, $hash));

        // Return ID of inserted image
        return $this->db->insert_id();
    }


    /*******************************************************************************
    * Update password
    *******************************************************************************/
    public function update_password($email, $hash)
    {
        // Build query
        $sql = 'UPDATE users SET user_hash = ? WHERE user_email = ?';

        // Execute
        $this->db->query($sql, array($hash, $email));

        // Return ID of inserted image
        return $this->db->insert_id();
    }


    /*******************************************************************************
    * Checks to see if user is unique
    *******************************************************************************/
    public function is_unique($email)
    {
        // Build query
        $sql = 'SELECT COUNT(user_id) AS num_users FROM users WHERE user_email = ?';

        // Execute
        $query = $this->db->query($sql, array($email));

        // Get number of users with this email
        $data = $query->row_array();

        // Check for unique user email
        if($data['num_users'] > 0)
        {
            // Email is NOT unique
            return false;
        }
        else
        {
            // Email is unique
            return true;
        }
    }


    /*******************************************************************************
    * Get all users
    *******************************************************************************/
    public function get_all()
    {
        // Build sql
        $sql = 'SELECT user_id, user_email FROM users';

        // Execute
        $query = $this->db->query($sql);

        // Return result
        return $query->result_array();
    }
}
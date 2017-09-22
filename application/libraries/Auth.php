<?php
/*
* Auth.php
* A simple authentication library
* Mark Hiscock 03.03.17
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth
{
	// Codeigniter 'super' object
	private $CI;

	/*******************************************************************************
    * Constructor
    *******************************************************************************/
    public function __construct()
    {
    	// Get Codeigniter object by reference
    	$this->CI =& get_instance();

    }


    /*******************************************************************************
    * Authenticate user
    *******************************************************************************/
	public function authenticate($email, $password)
	{
        // Load user model
        $this->CI->load->model('user_model');

        // Get user data
        $data = $this->CI->user_model->get_by_email($email);

        // Check we have data for user
        if(!isset($data['user_hash']))
        {
            // Query returned NO results - Authentication failed
            return false;
        }

		// Check username and password
        if(password_verify($password, $data['user_hash']) == true)
		{
            // Regenerate session ID for extra security
            session_regenerate_id(true);

            // Set session data
            $this->CI->session->set_userdata('user_id', $data['user_id']);
            $this->CI->session->set_userdata('user_email', $data['user_email']);

            // Authentication successful
            return true;
        }
        else
        {
            // Authentication failed
            return false;
        }
	}


    /*******************************************************************************
    * Check current user password
    *******************************************************************************/
    public function check_password($password)
    {
        // Get email for current user
        $email = $this->CI->session->user_email;

        // Load user model
        $this->CI->load->model('user_model');

        // Get user data
        $data = $this->CI->user_model->get_by_email($email);

        // Check we have data for user
        if(!isset($data['user_hash']))
        {
            // Query returned NO results - Authentication failed
            return false;
        }

        // Check username and password
        if(password_verify($password, $data['user_hash']) == true)
        {
            // Password OK
            return true;
        }
        else
        {
            // Wrong password
            return false;
        }
    }


    /*******************************************************************************
    * Check current user password
    *******************************************************************************/
    public function update_password($password)
    {
        // Get email for current user
        $email = $this->CI->session->user_email;

        // Hash new password
        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        // Load user model
        $this->CI->load->model('user_model');

        // Update
        $this->CI->user_model->update_password($email, $hash);
    }


    /*******************************************************************************
    * Check user is logged in
    *******************************************************************************/
    public function isLoggedIn()
    {
        if($this->CI->session->user_id === null || $this->CI->session->user_email === null)
        {
            // User is NOT logged in
            return false;
        }
        else
        {
            // User is logged in
            return true;
        }
    }


    /*******************************************************************************
    * Add new user
    *******************************************************************************/
    public function add_user($email, $password)
    {
        // Load user model
        $this->CI->load->model('user_model');

        // Make hash
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // Add user to database
        $this->CI->user_model->add($email, $hash);
    }
}
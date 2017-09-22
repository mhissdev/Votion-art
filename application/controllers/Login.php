<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Login.php
* Admin login page
* Mark Hiscock 03.03.17
*/

class Login extends CI_Controller
{
    // Data to pass to views
    private $data = array();

    /*******************************************************************************
    * Constructor
    *******************************************************************************/
    public function __construct()
    {
        parent::__construct();

        // Load helpers
        $this->load->helper(array('form', 'url'));

        // Load CI libraries
        $this->load->library('form_validation');

        // Load custom libraries
        $this->load->library('auth');

        // Set validation error flag
        $this->data['has_validation_errors'] = false;

        // Set login failed
        $this->data['login_failed'] = false;

    }

    /*******************************************************************************
    * Login form
    *******************************************************************************/
    public function index()
    {
        // Check for POST data
        if(isset($_POST['login-submit']) && !empty($_POST['login-submit']))
        {
            // Create validation rules
            $this->form_validation->set_rules('login-username', 'Username', 'trim|required');
            $this->form_validation->set_rules('login-password', 'Password', 'trim|required');

            // Check validation
            if($this->form_validation->run() == false)
            {
                // Form has validation errors
                $this->data['has_validation_errors'] = true;
            }
            else
            {
                // Form validated OK - Authenticate user
                $this->loginUser();
               
            }
        }

        // Load login view
        $this->load->view('pages/login', $this->data);
    }


    /*******************************************************************************
    * Login user
    *******************************************************************************/
    private function loginUser()
    {
        // Get POST data from form
        $username = $this->input->post('login-username');
        $password = $this->input->post('login-password');

        // Authenticate user
        if($this->auth->authenticate($username, $password) == true)
        {
            // Authentication successful
            // TODO: Get user ID
            //$user_id = 1;

            // Set Session data
            //$this->session->set_userdata('user_id', $user_id);
            // $this->session->set_userdata('username', $username);

            // Redirect to admin
            redirect(base_url() . 'admin');
            die();
        }
        else
        {
            // Authentication failed
            $this->data['login_failed'] = true;
        }
    }


    /*******************************************************************************
    * Logout user
    *******************************************************************************/
    public function logout()
    {
        // Remove session data
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');

        // Redirect to home page
        redirect(base_url());
        die();
    }
}
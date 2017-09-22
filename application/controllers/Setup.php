<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Setup.php
* Allows new users to be added to the CMS
* Mark Hiscock 31.03.17
*/


class Setup extends CI_Controller
{
    // Data to pass to views
    private $data = array();

    // Site name
    private $siteName = '';


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
        $this->load->library('navigation_main');
        $this->load->library('pagemeta');
        $this->load->library('auth');

        // get site name
        $this->siteName = $this->config->item('site_name');

        // Check config for 'Allow New Users'
        if($this->config->item('allow_new_user') == false)
        {
            // Deny access - redirect to home page
            redirect(base_url());
            die();
        }

        // Set validation error flag
        $this->data['has_validation_errors'] = false;

        // Add user success message
        $this->data['success_message'] = '';
    }


    /*******************************************************************************
    * Add new user page
    *******************************************************************************/
    public function index()
    {
        // Set homepage meta data
        $this->pagemeta->setTitle('Setup | ' . $this->siteName);
        $this->pagemeta->setDescription('Remove Me!!');
        $this->pagemeta->setNavName('Setup');

        // Get Post data
        $this->get_post_data();

        // Load new user view
        $this->load->view('admin/new_user', $this->data);
    }


    /*******************************************************************************
    * Checks for PHP password_hash function availability
    *******************************************************************************/
    public function hash($password = 'hello')
    {
        // Set homepage meta data
        $this->pagemeta->setTitle('Hash Test | ' . $this->siteName);
        $this->pagemeta->setDescription('Hash');
        $this->pagemeta->setNavName('Testing');

        // Make hash
        $this->data['hash'] = password_hash($password, PASSWORD_BCRYPT);

        // Load view
        $this->load->view('admin/hash_test', $this->data);
    }


    /*******************************************************************************
    * Checks POST data and adds new user
    *******************************************************************************/
    private function get_post_data()
    {
        // Check for POST data
        if(isset($_POST['add-user']) && !empty($_POST['add-user']))
        {
            // Create validation rules
            $this->form_validation->set_rules('add-user-username', 'Username', 'trim|required|callback__user_check');
            $this->form_validation->set_rules('add-user-password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('add-user-password2', 'Password Confirm', 'trim|required|matches[add-user-password]');

            // Check validation
            if($this->form_validation->run() == false)
            {
                // Form has validation errors
                $this->data['has_validation_errors'] = true;
            }
            else
            {
                // Form validated OK - Create User
                $email = $this->input->post('add-user-username');
                $password = $this->input->post('add-user-password');
                $this->auth->add_user($email, $password);

                // Success message
                $this->data['success_message'] = 'User has been successfully created!';
            }
        }
    }


    /*******************************************************************************
    * Checks for unique username/email
    *******************************************************************************/
    public function _user_check($email)
    {
        // Load user model
        $this->load->model('user_model');

        // Check supplied email is unique
        $is_unique = $this->user_model->is_unique($email);

        if($is_unique == true)
        {
            // Email OK
            return true;
        }
        else
        {
            // Email is already in use
            $this->form_validation->set_message('_user_check', 'Email address is already registered');
            return false;
        }
    }
}
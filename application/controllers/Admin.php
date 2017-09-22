<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Admin.php
* Admin section
* Mark Hiscock 04.03.17
*/

class Admin extends CI_Controller
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
        $this->load->library('navigation_admin');

        // Authorise user
        if($this->auth->isLoggedIn() == false)
        {
            // User is Not logged in - redirect
            redirect(base_url() . 'login');
            die();
        }
    }

    /*******************************************************************************
    * Dashboard
    *******************************************************************************/
    public function index()
    {
        // Set page name
        $this->data['page_name'] = 'Dashboard';

        //  Get username
        $this->data['username'] = $this->session->user_email;

        // Get number of published collections
        $this->load->model('collection_model');
        $data = $this->collection_model->get_num_published();
        $this->data['num_collections'] = $data['num_collections'];

        // Get number of published products
        $this->load->model('product_model');
        $data = $this->product_model->get_num_published();
        $this->data['num_products'] = $data['num_products'];

        // Load dashboard view
        $this->load->view('admin/dashboard', $this->data);
    }


    /*******************************************************************************
    * Users
    *******************************************************************************/
    public function users()
    {
        // Set validation error flag
        $this->data['has_validation_errors'] = false;

        // Add user success message
        $this->data['success_message'] = '';

        // Handle for POST data
        $this->get_post_data();

        // Set page name
        $this->data['page_name'] = 'Users';

        // Get Users
        $this->load->model('user_model');
        $this->data['users'] = $this->user_model->get_all();

        // Load users view
        $this->load->view('admin/users', $this->data);
    }


    /*******************************************************************************
    * Checks POST data for password update
    *******************************************************************************/
    private function get_post_data()
    {
        // Check for POST data
        if(isset($_POST['password-update']) && !empty($_POST['password-update']))
        {
            // Create validation rules
            $this->form_validation->set_rules('user-password', 'Old Password', 'trim|required|callback__password_check');
            $this->form_validation->set_rules('user-new-password', 'New Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('user-new-password2', 'New Password Confirm', 'trim|required|matches[user-new-password]');

            // Check validation
            if($this->form_validation->run() == false)
            {
                // Form has validation errors
                $this->data['has_validation_errors'] = true;
            }
            else
            {
                // Form validated OK - Update password
                $password = $this->input->post('user-new-password');
                $this->auth->update_password($password);

                // Success message
                $this->data['success_message'] = 'Password has been successfully updated!';
            }
        }
    }


    /*******************************************************************************
    * Checks current password for user
    *******************************************************************************/
    public function _password_check($password)
    {
        if($this->auth->check_password($password) == true)
        {
            // password OK
            return true;
        }
        else
        {
            // Wrong password
            $this->form_validation->set_message('_password_check', 'Old password is incorrect');
            return false;
        }
    }
}
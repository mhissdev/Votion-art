<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Images.php
* Manage / upload images
* Mark Hiscock 04.03.17
*/

class Help extends CI_Controller
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
        $this->data['page_name'] = 'Help';

        // Load dashboard view
        $this->load->view('admin/help', $this->data);
    }
}
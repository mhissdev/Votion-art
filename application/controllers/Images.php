<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Images.php
* Manage / upload images
* Mark Hiscock 04.03.17
*/

class Images extends CI_Controller
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

        // Set upload messages
        $this->data['upload_errors'] = '';
    }


    /*******************************************************************************
    * Images main page
    *******************************************************************************/
    public function index()
    {
        // Set page name
        $this->data['page_name'] = 'Images';

        // Check for POST data
        if(isset($_POST['upload-submit']) && !empty($_POST['upload-submit']))
        {
            // Upload image
            $this->upload_image();
        }

        // Load view
        $this->load->view('admin/images', $this->data);
    }


    /*******************************************************************************
    * Attempt to upload the image
    *******************************************************************************/
    private function upload_image()
    {
        // Set upload preferences
        $config['upload_path'] = FCPATH . '/uploads/';
        $config['max_size'] = 4096; // KB
        $config['allowed_types'] = 'gif|jpg|png';

        // Load upload library
        $this->load->library('upload', $config);

        // Attempt upload
        if($this->upload->do_upload('upload-file') == false)
        {
            // Something went wrong
            $this->data['upload_errors'] = $this->upload->display_errors();
        }
        else
        {
            // Upload success
            $this->data['upload_errors'] = "<h1>SUCCESS</h1>";
        }
    }


    /*******************************************************************************
    * AJAX image upload
    *******************************************************************************/
    public function upload()
    {

        $data = array();

        // Upload success
        $data['success'] = true;

        // Message to output for users
        $data['message'] = '';

        // ID for uploaded image
        $data['id'] = 0;

        // Set upload preferences
        $config['upload_path'] = FCPATH . '/uploads/';
        $config['max_size'] = 4096; // KB
        $config['allowed_types'] = 'gif|jpg|png';

        // Load upload library
        $this->load->library('upload', $config);

        // Attempt upload
        if($this->upload->do_upload('upload-file') == false)
        {
            // Something went wrong
            $data['message'] = $this->upload->display_errors();
            $data['success'] = false;
        }
        else
        {
            // Upload success
            $data['message'] = '<p>Image successfully uploaded</p>';

            // Get image data
            $image_data = array();
            $image_data['image_filename'] = $this->upload->data('file_name');

            // Insert filename of image into database and get new image ID
            $this->load->model('image_model');
            $data['id'] = $this->image_model->add($image_data);

            // Add filename top AJAX response
            $data['filename'] = $this->upload->data('file_name'); 
        }


        // Regenerate csrf token to allow multiple AJAX requests
        $data['csrf_token'] = $this->security->get_csrf_hash();

        // Output JSON
        echo json_encode($data);
    }


}
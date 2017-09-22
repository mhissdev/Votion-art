<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Collections.php
* Add/Edit the collections
* Mark Hiscock 06.03.17
*/

class Collections extends CI_Controller
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
    * Collections main page
    *******************************************************************************/
    public function index()
    {
        // Set page name
        $this->data['page_name'] = 'Collections';

        // Retrieve any user messages
        if(isset($_SESSION['collection_message']))
        {
            $this->data['collection_message'] = $_SESSION['collection_message'];
        }
        else
        {
            $this->data['collection_message'] = '';
        }

        // Create collections HTML table
        $this->create_html_table();

        // Load dashboard view
        $this->load->view('admin/collections', $this->data);
    }


    /*******************************************************************************
    * Collections Add/Edit
    *******************************************************************************/
    public function manage($collection_id = 0)
    {
        // Set page name
        $this->data['page_name'] = 'Collections';

        // Form validation error flag
        $this->data['has_validation_errors'] = false;

        // Set default form values
        $this->set_default_values();

        // Set collection ID and form mode
        if($collection_id == 0)
        {
            // Add new collection form mode
            $this->data['form_mode'] = 'add';
            $this->data['button_value'] = 'Add New Collection';
        }
        else
        {
            // Edit collection form mode
            $this->data['form_mode'] = 'edit';
            $this->data['button_value'] = 'Update Collection';

            // Set collection id
            $this->data['collection_id'] = $collection_id;

            // Get values from database
            $this->get_collection_data();
        }

        // Get POST data from form
        $this->get_post_data();

        // Load collections manage view
        $this->load->view('admin/collections_manage', $this->data);
    }


    /*******************************************************************************
    * Set default values for form fields
    *******************************************************************************/
    private function set_default_values()
    {
        // Collection data
        $this->data['collection_id'] = '';
        $this->data['collection_name'] = '';
        $this->data['collection_description'] = '';
        $this->data['collection_featured'] = 0;
        $this->data['collection_published'] = 0;

        // HTML output for checkboxes
        $this->data['feature_checked'] = '';
        $this->data['publish_checked'] = '';

        // Current image selection
        $this->data['image_id'] = '';
        $this->data['image_url'] = '';

        // Images data for selection modal
        $this->load->model('image_model');
        $this->data['images'] = array();
        $this->data['images'] = $this->image_model->get_all();
    }


    /*******************************************************************************
    * Get collection data from database
    *******************************************************************************/
    private function get_collection_data()
    {
        // Load model
        $this->load->model('collection_model');

        // Get data from database
        $data = $this->collection_model->get_by_id_join_image($this->data['collection_id']);

        // Copy values
        $this->data['collection_name'] = $data['collection_name'];
        $this->data['collection_description'] = $data['collection_description'];
        $this->data['collection_featured'] = $data['collection_featured'];
        $this->data['collection_published'] = $data['collection_published'];

        // Set checkboxes states
        $this->set_checkboxes_states();

        // Set URL of image
        $this->data['image_id'] = $data['image_id'];
        $this->data['image_url'] = base_url() . 'uploads/' . $data['image_filename'];
    }


    /*******************************************************************************
    * Get POST data from form
    *******************************************************************************/
    private function get_post_data()
    {
        // Check for POST data
        if(isset($_POST['collection-submit']) && !empty($_POST['collection-submit']))
        {
            // Set Values for text fields
            $this->data['image_id'] = $this->input->post('current-image-selection');
            $this->data['collection_name'] = $this->input->post('collection-name');
            $this->data['collection_description'] = $this->input->post('collection-description');

            // Featured checkbox
            $featured = $this->input->post('collection-featured');

            if(isset($featured))
            {
                $this->data['collection_featured'] = 1;
            }
            else
            {
                $this->data['collection_featured'] = 0;
            }

            // Published checkbox
            $published = $this->input->post('collection-publish');

            if(isset($published))
            {
                $this->data['collection_published'] = 1;
            }
            else
            {
                $this->data['collection_published'] = 0;
            }

            // Set checkboxes states
            $this->set_checkboxes_states();

            // Set URL of current image selection file
            $this->set_current_image_url();

            // Process POST data
            $this->process_post_data();
        }
    }


    /*******************************************************************************
    * Process POST data
    *******************************************************************************/
    private function process_post_data()
    {
        // Create validation rules
        $this->create_rules();

        // Check validation
        if($this->form_validation->run() == false)
        {
            // Form has validation errors
            $this->data['has_validation_errors'] = true;
        }
        else
        {
            // Form validated OK - create slug (replace spaces with underscoress)
            $this->data['collection_slug'] = strtolower(str_replace(' ', '-', $this->data['collection_name']));

            // Load model
            $this->load->model('collection_model');

            // Add / Update collection table in database
            if($this->data['form_mode'] == 'add')
            {
                // Insert into database
                $this->collection_model->add($this->data);

                // Set add success message
                $message = $this->data['collection_name'] . ' has been successfully added!';
                $this->session->set_flashdata('collection_message', $message);
            }
            else
            {
                // Update database
                $this->collection_model->update($this->data);

                // Set add success message
                $message = $this->data['collection_name'] . ' has been successfully updated!';
                $this->session->set_flashdata('collection_message', $message);
            }

            // Redirect to main collections page
            redirect(base_url() . 'admin/collections');
            die();
        }
    }


    /*******************************************************************************
    * Sets URL of the currently selected image
    *******************************************************************************/
    private function set_current_image_url()
    {
        if(isset($this->data['image_id']))
        {
            // User has selected image - load model
            $this->load->model('image_model');

            // Get image data
            $current_image_data = $this->image_model->get_by_id($this->data['image_id']);

            if(isset($current_image_data))
            {   
                // Build URL for image path
                $str = base_url() . 'uploads/' . $current_image_data['image_filename'];
                $this->data['image_url'] = $str;
            }
        }
    }


    /*******************************************************************************
    * Process checkboxes states
    *******************************************************************************/
    private function set_checkboxes_states()
    {
        // Featured checkbox
        if($this->data['collection_featured'] == 1)
        {
            $this->data['feature_checked'] = 'checked';
        }

        // Published checkbox
        if($this->data['collection_published'] == 1)
        {
            $this->data['publish_checked'] = 'checked';
        }
    }


    /*******************************************************************************
    * Create validation rules for contact form
    *******************************************************************************/
    private function create_rules()
    {   
        $this->form_validation->set_rules('collection-name', 'Collection Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('current-image-selection', 'Select Image', 'trim|required');
        $this->form_validation->set_rules('collection-description', 'Collection Description', 'trim|required|max_length[1024]');
    }


    /*******************************************************************************
    * Create collections HTML table
    *******************************************************************************/
    private function create_html_table()
    {
        // Get collection from database
        $this->load->model('collection_model');
        $data = $this->collection_model->get_all();

        if(isset($data))
        {
            // Build table HTML
            $this->data['collection_table'] = '<table id="collections-table" class="table table-striped table-bordered table-hover">';
            $this->data['collection_table'] .= '<thead><tr>';
            $this->data['collection_table'] .= '<th>Collection</th><th>Featured</th><th>Published</th><th>#</th>';
            $this->data['collection_table'] .= '</tr></thead>';
            $this->data['collection_table'] .= '<tbody>';

            // Table rows
            foreach($data as $collection)
            {
                // Start row
                $this->data['collection_table'] .=  '<tr>';

                // Collection name
                $this->data['collection_table'] .= '<td>' . $collection['collection_name'] . '</td>';

                // Font-awesome styles
                $tick = '<i class="fa fa-check text-success" aria-hidden="true"> Yes</i>';
                $cross = '<i class="fa fa-times text-danger" aria-hidden="true"> No</i>';

                // Featured
                if($collection['collection_featured'] == 1)
                {
                    $this->data['collection_table'] .= '<td>' . $tick . '</td>';
                }
                else
                {
                    $this->data['collection_table'] .= '<td>' . $cross . '</td>';
                }


                // published
                if($collection['collection_published'] == 1)
                {
                    $this->data['collection_table'] .= '<td>' . $tick . '</td>';
                }
                else
                {
                    $this->data['collection_table'] .= '<td>' . $cross . '</td>';
                }

                // Edit collection link
                $anchor = '<a href="' . base_url() . 'collections/manage/' . $collection['collection_id'];
                $anchor .= '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>';
                $this->data['collection_table'] .= '<td>' . $anchor . '</td>';

                // End row
                $this->data['collection_table'] .=  '</tr>';
            }

            $this->data['collection_table'] .= '</tbody>';
            $this->data['collection_table'] .= '</table>';
        }
        else
        {
            // No collections to display
            $this->data['collection_table'] = '<p>There are currently no collections</p>';
        }
    }
}
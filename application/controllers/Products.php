<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Products.php
* Add/Edit products
* Mark Hiscock 04.03.17
*/

class Products extends CI_Controller
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
    * Products overview page
    *******************************************************************************/
    public function index()
    {
        // Set page name
        $this->data['page_name'] = 'Products';

        // Retrieve any user messages
        if(isset($_SESSION['product_message']))
        {
            $this->data['product_message'] = $_SESSION['product_message'];
        }
        else
        {
            $this->data['product_message'] = '';
        }

        // Create collections HTML table
        $this->create_html_table();

        // Load products view
        $this->load->view('admin/products', $this->data);
    }


    /*******************************************************************************
    * Products managae (add/edit products)
    *******************************************************************************/
    public function manage($product_id = 0)
    {
        // Set page name
        $this->data['page_name'] = 'Products';

        // Form validation error flag
        $this->data['has_validation_errors'] = false;

        // Set default form values
        $this->set_default_values();

        // Set product ID and form mode
        if($product_id == 0)
        {
            // Add new collection form mode
            $this->data['form_mode'] = 'add';
            $this->data['button_value'] = 'Add New Product';
        }
        else
        {
            // Edit collection form mode
            $this->data['form_mode'] = 'edit';
            $this->data['button_value'] = 'Update Product';

            // Set collection id
            $this->data['product_id'] = $product_id;

            // Get values from database
            $this->get_product_data();
        }

        // Get POST data from form
        $this->get_post_data();

        // Load pruducts manage view
        $this->load->view('admin/products_manage', $this->data);
    }


    /*******************************************************************************
    * Sets the default values for the products form
    *******************************************************************************/
    private function set_default_values()
    {
        // Products data
        $this->data['product_id'] = '';
        $this->data['product_name'] = '';
        $this->data['product_description'] = '';
        $this->data['product_price_high'] = 0;
        $this->data['product_price_low'] = 0;
        $this->data['product_paypal_html'] = '';
        $this->data['product_published'] = 0;

        // HTML output for checkbox
        $this->data['publish_checked'] = '';

        // Product collection ID
        $this->data['collection_id'] = '';

        // Collections data for select drop down
        $this->load->model('collection_model');
        $this->data['collections'] = array();
        $this->data['collections'] = $this->collection_model->get_all();

        // Current image selection
        $this->data['image_id'] = '';
        $this->data['image_url'] = '';

        // Images data for selection modal
        $this->load->model('image_model');
        $this->data['images'] = array();
        $this->data['images'] = $this->image_model->get_all();
    }


    /*******************************************************************************
    * Get POST data from form
    *******************************************************************************/
    private function get_post_data()
    {
        // Check for POST data
        if(isset($_POST['product-submit']) && !empty($_POST['product-submit']))
        {
            // Set Values for text fields
            $this->data['image_id'] = $this->input->post('current-image-selection');
            $this->data['product_name'] = $this->input->post('product-name');
            $this->data['product_description'] = $this->input->post('product-description');
            $this->data['product_price_high'] = $this->input->post('product-price-high');
            $this->data['product_price_low'] = $this->input->post('product-price-low');
            $this->data['product_paypal_html'] = $this->input->post('product-paypal-html');
            $this->data['collection_id'] = $this->input->post('product-collection-id');

            // Published checkbox
            $published = $this->input->post('product-publish');

            if(isset($published))
            {
                $this->data['product_published'] = 1;
                $this->data['publish_checked'] = 'checked';
            }
            else
            {
                $this->data['product_published'] = 0;
            }


            // Set URL of current image selection file
            $this->set_current_image_url();

            // Process POST data
            $this->process_post_data();
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
            $this->data['product_slug'] = strtolower(str_replace(' ', '-', $this->data['product_name']));

            // Load model
            $this->load->model('product_model');

            // Add / Update collection table in database
            if($this->data['form_mode'] == 'add')
            {
                // Insert into database
                $this->product_model->add($this->data);

                // Set add success message
                $message = $this->data['product_name'] . ' has been successfully added!';
                $this->session->set_flashdata('product_message', $message);
            }
            else
            {
                // Update database
                $this->product_model->update($this->data);

                // Set add success message
                $message = $this->data['product_name'] . ' has been successfully updated!';
                $this->session->set_flashdata('product_message', $message);
            }

            // Redirect to main products page
            redirect(base_url() . 'admin/products');
            die();
        }
    }


    /*******************************************************************************
    * Create validation rules for contact form
    *******************************************************************************/
    private function create_rules()
    {   
        $this->form_validation->set_rules('product-name', 'Product Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('product-collection-id', 'Collection', 'callback__collection_check');
        $this->form_validation->set_rules('current-image-selection', 'Select Image', 'trim|required');
        $this->form_validation->set_rules('product-description', 'Product Description', 'trim|required|max_length[2048]');
        $this->form_validation->set_rules('product-price-low', 'Product Price Low', 'trim|required|max_length[8]|greater_than[0]');
        $this->form_validation->set_rules('product-price-high', 'Product Price High', 'trim|required|max_length[8]|greater_than[0]');
        $this->form_validation->set_rules('product-paypal-html', 'Paypal HTML Code', 'trim|required|max_length[2048]');
    }


    /*******************************************************************************
    * Check user has selected an item from the dropdown
    *******************************************************************************/
    public function _collection_check($id)
    {
        if($id > 0)
        {
            // User has selected a collection
            return true;
        }

        // User has NOT chosen a collection
        $this->form_validation->set_message('_collection_check', 'You must select a collection from the dropdown menu');
        return false;
    }


    /*******************************************************************************
    * Get product data from database
    *******************************************************************************/
    private function get_product_data()
    {
        // Load model
        $this->load->model('product_model');

        // Create model
        $data = $this->product_model->get_by_id($this->data['product_id']);

        // Copy values
        $this->data['product_name'] = $data['product_name'];
        $this->data['product_description'] = $data['product_description'];
        $this->data['product_price_high'] = $data['product_price_high'];
        $this->data['product_price_low'] = $data['product_price_low'];
        $this->data['product_paypal_html'] = $data['product_paypal_html'];
        $this->data['collection_id'] = $data['collection_id'];
        $this->data['image_id'] = $data['image_id'];

        // Published checkbox
        if($data['product_published'] == 1)
        {
            $this->data['product_published'] = 1;
            $this->data['publish_checked'] = 'checked';
        }
        else
        {
            $this->data['product_published'] = 0;
        }


        // Set URL of current image selection file
        $this->set_current_image_url();
    }


    /*******************************************************************************
    * Create products HTML table
    *******************************************************************************/
    private function create_html_table()
    {
        // Get collection from database
        $this->load->model('product_model');
        $data = $this->product_model->get_all_join_collection();

        if(isset($data))
        {
            // Build table HTML
            $this->data['product_table'] = '<table id="products-table" class="table table-striped table-bordered table-hover">';
            $this->data['product_table'] .= '<thead><tr>';
            $this->data['product_table'] .= '<th>Product</th><th>Collection</th><th>Published</th><th>#</th>';
            $this->data['product_table'] .= '</tr></thead>';
            $this->data['product_table'] .= '<tbody>';

            // Table rows
            foreach($data as $product)
            {
                // Start row
                $this->data['product_table'] .=  '<tr>';

                // Product name
                $this->data['product_table'] .= '<td>' . $product['product_name'] . '</td>';

                // Collection name
                $this->data['product_table'] .= '<td>' . $product['collection_name'] . '</td>';

                // Font-awesome styles
                $tick = '<i class="fa fa-check text-success" aria-hidden="true"> Yes</i>';
                $cross = '<i class="fa fa-times text-danger" aria-hidden="true"> No</i>';

                // published
                if($product['product_published'] == 1)
                {
                    $this->data['product_table'] .= '<td>' . $tick . '</td>';
                }
                else
                {
                    $this->data['product_table'] .= '<td>' . $cross . '</td>';
                }

                // Edit product link
                $anchor = '<a href="' . base_url() . 'products/manage/' . $product['product_id'];
                $anchor .= '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>';
                $this->data['product_table'] .= '<td>' . $anchor . '</td>';

                // End row
                $this->data['product_table'] .=  '</tr>';
            }

            $this->data['product_table'] .= '</tbody>';
            $this->data['product_table'] .= '</table>';
        }
        else
        {
            // No collections to display
            $this->data['product_table'] = '<p>There are currently no products to display</p>';
        }
    }
}
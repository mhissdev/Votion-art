<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Store.php
* Main static pages for site
* Mark Hiscock 11.03.17
*/

class Store extends CI_Controller
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
        $this->load->helper(array('url'));

        // Load custom libraries
        $this->load->library('navigation_main');
        $this->load->library('pagemeta');

        // get site name
        $this->siteName = $this->config->item('site_name');
    }


    /*******************************************************************************
    * Store front page - Display all published collection
    *******************************************************************************/
    public function index()
    {
        // Set homepage meta data
        $this->pagemeta->setTitle('Store | ' . $this->siteName);
        $this->pagemeta->setDescription('Quality prints of quality art');
        $this->pagemeta->setNavName('Store');

        // Get collections
        $this->load->model('collection_model');
        $this->data['collections'] = $this->collection_model->get_store_front_page();

        // Load Store view
        $this->load->view('pages/store_front_page', $this->data);
    }


    /*******************************************************************************
    * Store collection - Display all published products
    *******************************************************************************/
    public function collection($slug = '')
    {
        // Load model
        $this->load->model('collection_model');

        // Search database for matching slug
        $data = $this->collection_model->get_by_slug($slug);

        // Get collection ID
        $collection_id = $data['collection_id'];

        // Check we have valid data
        if(!isset($collection_id))
        {
            // Redirect to main store page
            redirect(base_url() . 'store');
            die();
        }

        // Set collection name and description
        $this->data['collection_name'] = $data['collection_name'];
        $this->data['collection_description'] = $data['collection_description'];

        // Get products for requested collection
        $this->load->model('product_model');
        $this->data['products'] = $this->product_model->get_by_collection($collection_id);

        // Set  meta data
        $this->pagemeta->setTitle($data['collection_name'] . ' | ' . $this->siteName);
        $this->pagemeta->setDescription($data['collection_description']);
        $this->pagemeta->setNavName('Store');

        // Load Store view
        $this->load->view('pages/store_collection', $this->data);
    }


    /*******************************************************************************
    * Product page
    *******************************************************************************/
    public function product($slug = '')
    {
        // Load model
        $this->load->model('product_model');

        // Get product details
        $this->data['product'] = $this->product_model->get_by_slug($slug);

        // Check we have valid product data
        if(!isset($this->data['product']))
        {
            // Redirect to main store page
            redirect(base_url() . 'store');
            die();
        }

        // Set product price range output
        $this->data['product']['price_range'] = '&pound;' . $this->data['product']['product_price_low'];

        if($this->data['product']['product_price_low'] != $this->data['product']['product_price_high'])
        {
            $this->data['product']['price_range'] .= ' - &pound;' . $this->data['product']['product_price_high'];
        }

        // Create back link
        $this->data['back_link'] = '<p class="back-link"><a href="' . base_url() . 'store/collection/' . $this->data['product']['collection_slug']  . '">Back to ';
        $this->data['back_link'] .= $this->data['product']['collection_name'] . '</a></p>';

        // Set  meta data
        $this->pagemeta->setTitle($this->data['product']['product_name'] . ' | ' . $this->siteName);
        $this->pagemeta->setDescription($this->data['product']['product_name']);
        $this->pagemeta->setNavName('Store');

        // Clean Paypal button
        $this->clean_paypal_button();

        // Load product Store view
        $this->load->view('pages/store_product', $this->data);
    }


    /*******************************************************************************
    * Clean Paypal button - This replaces the default button image
    *******************************************************************************/
    private function clean_paypal_button()
    {
        // Search string
        $search = '<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_cart_LG.gif"';
        $search .= ' border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">';

        // replace string
        $replace = '<input class="btn btn-success btn-lg" type="submit" name="submit" value="Add to Cart">';

        // Check purchase enable config
        if($this->config->item('purchase_enable') == false)
        {
            // Disable 'Add to Cart' buttons
            $replace = '<span class="btn btn-success btn-lg test-only">Add to Cart</span>';
        }

        // Replace HTML
        $this->data['product']['product_paypal_html'] = str_replace($search, $replace, $this->data['product']['product_paypal_html']);
    }

}
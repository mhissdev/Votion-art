<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Pages.php
* Main static pages for site
* Mark Hiscock 23.02.17
*/

class Pages extends CI_Controller
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
    * Homepage
    *******************************************************************************/
    public function home()
    {
        // Get tagline
        $tagline = $this->config->item('site_tagline');

        // Set homepage meta data
        $this->pagemeta->setTitle('Home | ' . $this->siteName);
        $this->pagemeta->setDescription($tagline);
        $this->pagemeta->setNavName('Home');

        // Get featured collections
        $this->load->model('collection_model');
        $this->data['collections'] = $this->collection_model->get_featured();

        // Load homepage
        $this->load->view('pages/home', $this->data);
    }


    /*******************************************************************************
    * About
    *******************************************************************************/
    public function about()
    {
        // Set sabout page meta data
        $this->pagemeta->setTitle('About US | ' . $this->siteName);
        $this->pagemeta->setDescription('Passionate about art and films');
        $this->pagemeta->setNavName('About');

        // Load about page view
        $this->load->view('pages/about');
    }


    /*******************************************************************************
    * FAQ
    *******************************************************************************/
    public function faq()
    {
        // Set sabout page meta data
        $this->pagemeta->setTitle('FAQ | ' . $this->siteName);
        $this->pagemeta->setDescription('Let us make your experience better!');
        $this->pagemeta->setNavName('FAQ');

        // Load about page view
        $this->load->view('pages/faq');
    }


    /*******************************************************************************
    * Custome 404 page
    *******************************************************************************/
    public function custom404()
    {  
        // Set page meta data
        $this->pagemeta->setTitle('404 Error | ' . $this->siteName);
        $this->pagemeta->setDescription('Page cannot be found');
        $this->pagemeta->setNavName('404');

        // Load 404 page view
        $this->load->view('pages/404');
    }


    /*******************************************************************************
    * Terms and conditions page
    *******************************************************************************/
    public function terms()
    {
        // Set sabout page meta data
        $this->pagemeta->setTitle('Terms and Conditions | ' . $this->siteName);
        $this->pagemeta->setDescription('Legal stuff');
        $this->pagemeta->setNavName('NONE');

        // Load about page view
        $this->load->view('pages/terms');
    }


    /*******************************************************************************
    * Returns and refunds page
    *******************************************************************************/
    public function returns()
    {
        // Set sabout page meta data
        $this->pagemeta->setTitle('Returns and Refunds Policy | ' . $this->siteName);
        $this->pagemeta->setDescription('Legal stuff');
        $this->pagemeta->setNavName('NONE');

        // Load about page view
        $this->load->view('pages/returns');
    }
}
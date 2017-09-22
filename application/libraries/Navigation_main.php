<?php
/*
* Navigation_main.php
* Outputs the main navigation bar
* Mark Hiscock 04.03.17
*/
defined('BASEPATH') OR exit('No direct script access allowed');

// Include base navigation class
require_once(APPPATH . '/libraries/Navigation_base.php'); 

class Navigation_main extends Navigation_base
{

    /*******************************************************************************
    * Constructor
    *******************************************************************************/
    public function __construct()
    {
        parent::__construct();

        // Add navigation items
        $this->addItem('Home');
        $this->addItem('Store', 'store');
        $this->addItem('About', 'about');
        $this->addItem('FAQ', 'faq');
        $this->addItem('Contact', 'contact');
    }
}
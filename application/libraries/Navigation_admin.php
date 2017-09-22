<?php
/*
* Navigation_main.php
* Outputs the main navigation bar
* Mark Hiscock 04.03.17
*/
defined('BASEPATH') OR exit('No direct script access allowed');

// Include base navigation class
require_once(APPPATH . '/libraries/Navigation_base.php'); 

class Navigation_admin extends Navigation_base
{

    /*******************************************************************************
    * Constructor
    *******************************************************************************/
    public function __construct()
    {
        parent::__construct();

        // Add navigation items
        $this->addItem('Dashboard', 'admin');
        $this->addItem('Collections', 'admin/collections');
        $this->addItem('Products', 'admin/products');
        $this->addItem('Users', 'admin/users');
        $this->addItem('Help', 'admin/help');
    }
}
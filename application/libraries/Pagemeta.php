<?php
/*
* Pagemeta.php
* Meta data for pages
* Mark Hiscock 22.02.17
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagemeta
{
	// Name as it appers on navigation menu
	private $navName = '';

	// Page title
	private $title = '';

	// Page Description
	private $description = '';

	// Tags
	private $tags = array();


	/*******************************************************************************
    * Sets the nav name as it appers on the menu
    *******************************************************************************/
    public function setNavName($str)
    {
    	$this->navName = $str;
    }


    /*******************************************************************************
    * Get nav name
    *******************************************************************************/
    public function getNavName()
    {
    	return $this->navName;
    }


    /*******************************************************************************
    * Set page title
    *******************************************************************************/
    public function setTitle($str)
    {
    	$this->title = $str;
    }


    /*******************************************************************************
    * Get page title
    *******************************************************************************/
    public function getTitle()
    {
    	return $this->title;
    }


    /*******************************************************************************
    * Output page title
    *******************************************************************************/
    public function outputTitle()
    {
        echo $this->title;
    }

    /*******************************************************************************
    * Set page description
    *******************************************************************************/
    public function setDescription($str)
    {
    	$this->description = $str;
    }


    /*******************************************************************************
    * Get page description
    *******************************************************************************/
    public function getDescription()
    {
    	return $this->description;
    }


    /*******************************************************************************
    * Output description
    *******************************************************************************/
    public function outputDescription()
    {
        echo $this->description;
    }


    /*******************************************************************************
    * Set page tags
    *******************************************************************************/
    public function setTags($array)
    {
    	$this->description = $array;
    }


    /*******************************************************************************
    * Get page tags
    *******************************************************************************/
    public function getTags()
    {
    	return $this->tags;
    }
}
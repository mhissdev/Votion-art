<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
* Contact.php
* Contact page logic with Google recaptcha
* Mark Hiscock 25.02.17
*/

class Contact extends CI_Controller {

    // Data to pass to views
    private $data = array();

    // Site name
    private $site_name = '';

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

        // Load custom liraries
        $this->load->library('navigation_main');
        $this->load->library('pagemeta');

        // get site name
        $this->site_name = $this->config->item('site_name');

        // Show form as default
        $this->data['display_form'] = true;

        // Form has been posted with validation errors
        $this->data['has_validation_errors'] = false;

        // Contact form send success
        $this->data['send_success'] = false;

        // Google recaptcha keys
        $this->data['captcha_site_key'] = $this->config->item('captcha_site_key');

    }


    /*******************************************************************************
    * Load contact page view
    *******************************************************************************/
	public function index()
	{
        // Check for POST data
        if(isset($_POST['contact-submit']) && !empty($_POST['contact-submit']))
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
                // Form validated OK - Send message
                $this->send_message();
            }
        }

        // Set showreel page meta data
        $this->pagemeta->setTitle('Contact Us | ' . $this->site_name);
        $this->pagemeta->setDescription('Please feel free to drop us an email');
        $this->pagemeta->setNavName('Contact');

        // Load contact page
        $this->load->view('pages/contact', $this->data);
	}

    /*******************************************************************************
    * Create validation rules for contact form
    *******************************************************************************/
    private function create_rules()
    {   
        $this->form_validation->set_rules('contact-name', 'Name', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('contact-email', 'Email', 'trim|required|max_length[128]|valid_email');
        $this->form_validation->set_rules('contact-message', 'Message', 'trim|required|max_length[3000]');
        $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback__captcha_check');
    }

    /*******************************************************************************
    * Use Google API to verify captcha
    *******************************************************************************/
    public function _captcha_check($str)
    {

        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
        {
            // Get user IP
            $ip = '';

            if(isset($_SERVER['REMOTE_ADDR']))
            {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            // Build URL string
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $this->config->item('captcha_secret_key');
            $url .= '&response=' . $str;
            $url .= '&remoteip=' . $ip;

            // Get response from Google API
            $response = json_decode(file_get_contents($url), true);
            
            if($response["success"] === true)
            {
                return true;
            }

        }

        // Unable to verify captcha - Set validation error message
        $this->form_validation->set_message('_captcha_check', 'Please ensure you are human');
        return false;
    }
    
    /*******************************************************************************
    * Send email message
    *******************************************************************************/
    private function send_message()
    {
        // Attempting to send email so do not display form
        $this->data['display_form'] = false;

        // Get POST data from form
        $name = $this->input->post('contact-name');
        $email = $this->input->post('contact-email');
        $message = $this->input->post('contact-message');

        // Sanitise data before sending
        $name = $this->security->xss_clean($name);
        $email = $this->security->xss_clean($email);
        $message = filter_var($message, FILTER_SANITIZE_STRING, !FILTER_FLAG_STRIP_LOW);
        
        // Replace newline with <br> for HTML output
        $message = str_replace(array("\r\n", "\r", "\n"), "<br>", $message);
        $message = $this->security->xss_clean($message);

        // Build email subject
        $email_subject = 'Message From ' . $this->site_name . ' Contact Form';

        // Build email HTML body
        $email_body = '<p>You have received a message via the ' . $this->site_name . ' contact form.</p>';
        $email_body .= '<p>From: ' . $name;
        $email_body .= '<br>Email: ' . $email . '</p>';
        $email_body .= $message;

        // Build headers
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <webmaster@' . $this->config->item('contact_domain') . '>' . "\r\n";
        $headers .= "Reply-To: no-reply<" . $this->config->item('contact_domain') . ">";

        // Send Mail
        $this->data['send_success'] = mail($this->config->item('contact_email'), $email_subject, $email_body, $headers);
    }

}
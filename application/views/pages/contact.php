<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 
<?php $this->load->view('templates/header_open'); ?>
<?php $this->load->view('templates/header_close'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Contact Us</h1>
            <p>Here at Votion Art we take your questions and welfare seriously. If you need to contact us personally please feel free to use our office address, email address or telephone. Alternatively you could use our quick and simple contact form which goes straight through to our email. We treat every message with the upmost respect, and will reply as soon as possible.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <?php

        // Contact form
        if($display_form == TRUE)
        {
            // Show contact form
            $this->load->view('partials/contact_form');
        }
        else
        {
            // Show send success message
            if($send_success == true)
            {
                echo '<div class="alert alert-success">Thank you, your message has been successfully sent!</div>';
            }
            else
            {
                echo '<div class="alert alert-danger">Sorry, we were unable to send your message!</div>';
            }
        }
        ?>
        </div>
        <div class="col-md-6">
                <h3>Our Address</h3>
                <p>Votion Art<br>The Guildhall<br>High Street<br>Bath<br>BA1 5EB</p>
                <p>Telephone: +44 (0) 7886 226729<br>Email: <a href="mailto:info@votion-art.co.uk">info@votion-art.co.uk</a></p>
                <div class="map-responsive">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2490.1153944667344!2d-2.3613157842346153!3d51.38255717961494!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48718113b4596cbb%3A0x86c1f954e91d34df!2sBath%2C+Bath+and+North+East+Somerset+BA1+5EB!5e0!3m2!1sen!2suk!4v1464534011775" width="800" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
        </div>
    </div>
</div>
<?php $this->load->view('templates/footer_open'); ?>
<?php
    // Load Google recaptcha script
    if($display_form == TRUE)
    {
        echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
    }
?>
<?php $this->load->view('templates/footer_close'); ?>
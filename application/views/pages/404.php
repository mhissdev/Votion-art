<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 
<?php $this->load->view('templates/header_open'); ?>
<?php $this->load->view('templates/header_close'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Oops - Something went wrong</h1>
            <img src="<?php echo base_url(); ?>img/page-not-found.png" alt="404 error">
        </div>
    </div>
</div>
<?php $this->load->view('templates/footer_open'); ?>
<?php $this->load->view('templates/footer_close'); ?>
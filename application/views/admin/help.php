<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_admin_open'); ?>
<?php $this->load->view('templates/header_admin_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Help</h1>
                    <p>Please click <a href="<?php echo base_url(); ?>pdf/manual.pdf" target="_blank">HERE</a> to view the user manual.</p>
                </div>
            </div>
        </div><!--/.Container -->
<?php $this->load->view('templates/footer_admin_open'); ?>
<?php $this->load->view('templates/footer_admin_close'); ?>
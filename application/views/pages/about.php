<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_open'); ?>
<?php $this->load->view('templates/header_close'); ?>
<!-- Homepage banner -->
<div class="top-container about-top-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Film &amp; Design Nutters</h1>
                <a href="<?php echo base_url() . 'store'; ?>" class="btn btn-primary btn-lg">View Collections</a>
            </div>
        </div>
    </div>
</div>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="underscore">About Us</h1>
                    <p>If we watch something we love, it inspires us to create something unique to that subject. We're just a couple of dudes from Bath who want give a personal tribute to our favourite films.</p>
                    <blockquote>
                        <p>"Everything is designed. Few things are designed well."</p>
                        <footer>Brian Reed</footer>
                    </blockquote>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h3>Frazer King</h3>
                    <p style="margin-top:10px;"><img src="<?php echo base_url(); ?>img/frazer_king.jpg" alt="Frazer King" title="Frazer King" class="img-responsive img-rounded"></p>
                    <p>Company Director and Designer</p>
                </div>
                <div class="col-md-6">
                    <h3>Frazer Fox</h3>
                    <p style="margin-top:10px;"><img src="<?php echo base_url(); ?>img/frazer_fox.jpg" alt="Frazer Fox" title="Frazer Fox" class="img-responsive img-rounded"></p>
                    <p>Designer and Site Management</p>
                </div>
            </div>
        </div><!--/.Container -->
<?php $this->load->view('templates/footer_open'); ?>
<?php $this->load->view('templates/footer_close'); ?>
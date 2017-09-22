<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_admin_open'); ?>
<?php $this->load->view('templates/header_admin_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Dashboard</h1>
                    <h3>Welcome <?php echo $username; ?></h3>
                    <p>
                        <ul>
                            <li>You currently have <?php echo $num_collections; ?> published <a href="<?php echo base_url(); ?>collections">collections</a></li>
                            <li>You currently have <?php echo $num_products; ?> published <a href="<?php echo base_url(); ?>products">products</a></li>
                        </ul>
                    </p>
                </div>
            </div>
        </div><!--/.Container -->
<?php $this->load->view('templates/footer_admin_open'); ?>
<?php $this->load->view('templates/footer_admin_close'); ?>
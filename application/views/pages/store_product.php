<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_open'); ?>
<?php $this->load->view('templates/header_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo base_url() . 'uploads/' . $product['image_filename']; ?>" class="img-responsive" alt="<?php echo $product['product_name']; ?>">
                </div>
                <div class="col-md-6">
                    <h1 class="underscore"><?php echo $product['product_name']; ?></h1>
                    <p><?php echo $product['price_range']; ?></p>
                    <!-- Product Description -->
                    <?php echo $product['product_description']; ?>
                    <!-- Paypal -->
                    <div class="paypal-form well">
                        <h4 style="margin-bottom: 0px;">Buy Options:</h4>
                        <?php echo $product['product_paypal_html']; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php echo $back_link; ?>
                </div>
            </div>
        </div><!--/.Container -->
<?php $this->load->view('templates/footer_open'); ?>
<?php
    // Conditionally load 'Add to Cart' alert
    if($this->config->item('purchase_enable') == false)
    {
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.test-only').on('click', function(){
                // Alert
                alert("The 'Add to Cart' functionality is currently disabled for development purposes!");
            });
        });
    </script>
    <?php    
    }

?>
<?php $this->load->view('templates/footer_close'); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_open'); ?>
<?php $this->load->view('templates/header_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="underscore"><?php echo $collection_name; ?></h1>
                </div>
            </div>
            <!-- Collections -->
                <?php
                // Build HTML string for output
                $str = '';
                $count = 0;
                $close_row = false;

                foreach($products as $product)
                {
                    // Add new row
                    if($count % 3 == 0)
                    {
                        // Start row
                        $str .= '<div class="row">';
                    }

                    // get product URL
                    $product_url = base_url() . 'store/product/' . $product['product_slug'];

                    // Build HTML
                    $str .=  '<div class="col-md-4 text-center">';

                    // Output image
                    $str .= '<a href="' . $product_url . '">';
                    $str .= '<img src="' . base_url() . 'uploads/' . $product['image_filename'] . '" ';
                    
                    // Product name
                    $str .= 'alt="' . $product['product_name'] . '" class="img-responsive img-collection-product">';
                    $str .= '<div class="product-description"><h3>' . $product['product_name'] . '</h3>';

                    // Price range
                    $str .= '<p class="price-range">&pound;' . $product['product_price_low'];

                    if($product['product_price_low'] != $product['product_price_high'])
                    {
                        $str .= ' - &pound;' . $product['product_price_high'];
                    }

                    $str .= '</p></div>';

                    // Choose options
                    $str .= '<p><span class="btn btn-success">Select Options</span></p>';

                    // Closing tags
                    $str .= '</a></div>';

                    $count++;

                    if($count % 3 == 0)
                    {
                        // End row
                        $str .= '</div>';
                        $close_row = true;
                    }
                    else
                    {
                        $close_row = false;
                    }
                }

                // Close row if needed
                if($close_row == false)
                {
                    $str .= '</div>';
                }

                // Output HTML
                echo $str;
                ?>
            <div class="row">
                <div class="col-md-12">
                    <p class="collection-description"><?php echo $collection_description; ?></p>
                    <p class="back-link"><a href="<?php echo base_url(); ?>/store">Back to Store</a></p>
                </div>
            </div>
        </div><!--/.Container -->
<?php $this->load->view('templates/footer_open'); ?>
<?php $this->load->view('templates/footer_close'); ?>
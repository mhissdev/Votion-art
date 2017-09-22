<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_open'); ?>
<?php $this->load->view('templates/header_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="underscore">Art Print Store</h1>
                </div>
            </div>
            <!-- Collections -->
                <?php
                // Build HTML String
                $str = '';
                $count = 0;
                $close_row = false;

                foreach($collections as $collection)
                {
                    // Add new row
                    if($count % 3 == 0)
                    {
                        // Start row
                        $str .= '<div class="row">';
                    }

                    // Add item
                    $str .=  '<div class="col-md-4">';
                    $str .= '<a href="' . base_url() . 'store/collection/' . $collection['collection_slug'] . '">';
                    $str .= '<img src="' . base_url() . 'uploads/' . $collection['image_filename'] . '" ';
                    $str .= 'alt="' . $collection['collection_name'] . '" title="' . $collection['collection_name'] . '" class="img-responsive">';
                    $str .= '<h3 class="text-center">' . $collection['collection_name'] . ' (' . $collection['num_products'] . ')</h3>';
                    $str .= '</a>';
                    $str .= '</div>';

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
        </div><!--/.Container -->
<?php $this->load->view('templates/footer_open'); ?>
<?php $this->load->view('templates/footer_close'); ?>
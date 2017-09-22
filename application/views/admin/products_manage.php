<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_admin_open'); ?>
<?php $this->load->view('templates/header_admin_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Products</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php
                        // Output validation errors
                        if($has_validation_errors == true)
                        {
                            echo '<div class="alert alert-danger"><p>Validation errors have occured. Please fix the following problems and try again:-</p><ul>';
                            echo validation_errors('<li>', '</li>');
                            echo '</ul></div>';
                        }
                    ?>
                    <?php echo form_open(base_url() . 'products/manage/' . $product_id); ?>
                        <input type="hidden" name="current-image-selection" id="current-image-selection" 
                        value="<?php echo($image_id); ?>">
                        <div class="form-group">
                            <label for="product-name">Product Name:</label>
                            <input type="text" class="form-control" id="product-name" name="product-name" placeholder="Please enter product name" 
                            value="<?php echo($product_name); ?>">
                        </div>
                        <div class="form-group">
                            <label for="product-collection-id">Product Collection:</label>
                            <select class="form-control" name="product-collection-id" id="product-collection-id">
                                <option value="0">-- Select Collection --</option>
                                <?php 
                                    // Build options for collections dropdown
                                    $output = '';

                                    foreach($collections as $collection)
                                    {
                                        // Get collection details
                                        $id = $collection['collection_id'];
                                        $name = $collection['collection_name'];

                                        // Check if collection is selected
                                        if($collection_id == $id)
                                        {
                                            $output .= '<option selected="selected" value="' . $id . '">' . $name . '</option>';
                                        }
                                        else
                                        {
                                            $output .= '<option value="' . $id . '">' . $name . '</option>';
                                        }
                                    }

                                    // Output HTML
                                    echo $output;
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#image-select-modal">Select Image</button>
                        </div>
                        <div class="form-group">
                            <label for="product-description">Product Description:</label>
                            <textarea class="form-control" rows="12" id="product-description" name="product-description" 
                            placeholder="Please enter a description"><?php echo($product_description);?></textarea>
                        </div>
                        <!-- Product price range -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product-price-low">Product Price Low (&pound;):</label>
                                    <input type="text" class="form-control" id="product-price-low" name="product-price-low" placeholder="0.00" 
                                    value="<?php echo($product_price_low); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product-price-high">Product Price High (&pound;):</label>
                                    <input type="text" class="form-control" id="product-price-high" name="product-price-high" placeholder="0.00" 
                                    value="<?php echo($product_price_high); ?>">
                                </div>
                            </div>
                        </div>
                        <!-- Paypal HTML button code -->
                        <div class="form-group">
                            <label for="product-paypal-html">Paypal HTML Code:</label><p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_button-management" target="_blank">Open Papal website in new window</a></p>
                            <textarea class="form-control" rows="4" id="product-paypal-html" name="product-paypal-html" 
                            placeholder="Please copy and paste the HTML code provided from Paypal"><?php echo($product_paypal_html);?></textarea>
                        </div>
                        <!-- Product Options -->
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="product-publish" <?php echo($publish_checked); ?>> publish this product
                            </label>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="product-submit" value="<?php echo $button_value; ?>">
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div id="image-select-holder">
                        <?php 
                            if($image_url != '')
                            {
                                // Currently selected image
                                echo '<img src="' . $image_url . '" class="img-responsive">';
                            }
                        ?>
                    </div>
                </div>
            </div>

        </div><!--/.Container -->
<!-- Image select Modal -->
<?php $this->load->view('partials/image_select_modal'); ?>
<?php $this->load->view('templates/footer_admin_open'); ?>
<!-- AJAX Upload -->
<?php $this->load->view('partials/image_select_script'); ?>
<!-- TinyMCE Editor-->
<script src="<?php echo base_url() . 'js/tinymce/tinymce.min.js' ?>"></script>
<script>
     $(document).ready(function(){
        // Init Tiny MCE
        /*
        tinymce.init({
            selector: '#product-description'
        });
        */

        tinymce.init({
            selector: '#product-description',
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code'
        });
     });
</script>
<?php $this->load->view('templates/footer_admin_close'); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_admin_open'); ?>
<?php $this->load->view('templates/header_admin_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Collections</h1>
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
                    <?php echo form_open(base_url() . 'collections/manage/' . $collection_id); ?>
                        <input type="hidden" name="current-image-selection" id="current-image-selection" 
                        value="<?php echo($image_id); ?>">
                        <div class="form-group">
                            <label for="collection-name">Collection Name:</label>
                            <input type="text" class="form-control" id="collection-name" name="collection-name" placeholder="Please enter collection name" 
                            value="<?php echo($collection_name); ?>">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#image-select-modal">Select Image</button>
                        </div>
                        <div class="form-group">
                            <label for="collection-description">Collection Short Description:</label>
                            <textarea class="form-control" rows="4" id="collection-description" name="collection-description" 
                            placeholder="Please enter a description"><?php echo($collection_description);?></textarea>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="collection-featured" <?php echo($feature_checked); ?>> Feature collection on front page
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="collection-publish" <?php echo($publish_checked); ?>> publish this collection
                            </label>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="collection-submit" value="<?php echo $button_value; ?>">
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
<?php $this->load->view('templates/footer_admin_close'); ?>
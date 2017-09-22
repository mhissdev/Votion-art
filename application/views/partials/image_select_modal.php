<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 
<div class="modal fade" tabindex="-1" role="dialog" id="image-select-modal">
    <div class="modal-dialog" role="document" style="width:80%;">
        <div class="modal-content">
            <!-- Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Select Image</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body select-modal-images">
                <?php
                    /*
                    for($i = 0; $i < 50; $i++)
                    {
                        echo '<div class="select-image" id="select-image' . $i . '">';
                        echo '<img src="' . base_url() . 'uploads/test3.jpg" class="img-thumbnail img-responsive">';
                        echo '</div>';
                    }
                    */
                    foreach($images as $image)
                    {
                        // Build HTML output
                        $str = '<div class="select-image" id="select-image' . $image['image_id'] . '">';
                        $str .= '<img src="' . base_url() . 'uploads/' . $image['image_filename'];
                        $str .= '" class="img-thumbnail img-responsive"></div>';

                        // Output
                        echo $str;
                    }
                ?>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="text-left">
                    <!-- Image upload form -->
                    <h4>Upload New Image</h4>
                    <div id="upload-form-container">
                        <?php
                            // Open multipart form
                            $attributes = array('id' => 'upload-form');
                            echo form_open_multipart('admin/images', $attributes);
                        ?>
                            <div class="form-group">
                                <input type="file" id="upload-file" name="upload-file">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="upload-submit" id="upload-submit" value="Upload">
                            </div>
                        <?php echo form_close() ?>
                    </div>
                    <div id="message-upload"></div>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
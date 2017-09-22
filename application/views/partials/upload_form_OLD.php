<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* upload_form.php
* Image upload form
* Mark Hiscock 05.03.17
*/
?>

<?php
// Open multipart form
$attributes = array('id' => 'upload-form');
echo form_open_multipart('admin/images', $attributes);
?>
    <div class="form-group">
        <label for="upload-file">File input</label>
        <input type="file" id="upload-file" name="upload-file">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="upload-submit" id="upload-submit" value="Upload">
    </div>
<?php echo form_close() ?>


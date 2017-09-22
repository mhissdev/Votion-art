<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
    // Output validation errors
    if($has_validation_errors == true)
    {
        echo '<div class="alert alert-danger"><p>Validation errors have occured. Please fix the following problems and try again:-</p><ul>';
        echo validation_errors('<li>', '</li>');
        echo '</ul></div>';
    }
?>
<?php echo form_open(base_url() . 'contact'); ?>
    <div class="form-group">
        <label for="contact-name">Your name:</label>
        <input type="text" class="form-control" id="contact-name" name="contact-name" placeholder="Please enter your name" value="<?php echo set_value('contact-name'); ?>">
    </div>
    <div class="form-group">
        <label for="contact-email">Your email:</label>
        <input type="text" class="form-control" id="contact-email" name="contact-email" placeholder="Please enter your email" value="<?php echo set_value('contact-email'); ?>">
    </div>
    <div class="form-group">
        <label for="contact-message">Your message:</label>
        <textarea class="form-control" rows="8" id="contact-message" name="contact-message" placeholder="Please enter your message"><?php echo set_value('contact-message'); ?></textarea>
    </div>
    <div class="form-group">
        <div class="g-recaptcha" data-sitekey="<?php echo $captcha_site_key; ?>"></div>
    </div>
    <div class="form-group">
        <input class="btn-lg btn-primary" type="submit" name="contact-submit" value="Send">
    </div>
</form>
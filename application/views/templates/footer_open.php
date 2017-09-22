<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 
<!-- Footer -->
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="align-center">
                    <ul class="social">
                        <li><a href="https://www.facebook.com/KvsK.DesignStudio" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a></li>
                        <li><a href="https://twitter.com/votiongraphics" target="_blank"><i class="fa fa-twitter-square fa-2x"></i></a></li>
                        <li><a href="https://www.linkedin.com/in/frazerking/" target="_blank"><i class="fa fa-linkedin-square fa-2x"></i></a></li>
                    </ul>
                </div>
                <div class="align-center">
                    <ul class="legals">
                        <li><a href="<?php echo base_url(); ?>terms-and-conditions">Terms and conditions</a></li>
                        <li>|</li>
                        <li><a href="<?php echo base_url(); ?>returns-and-refunds">Returns and Refunds Policy</a></li>
                    </ul>
                </div>
                <p class="small align-center">&copy; <?php echo $this->config->item('site_name') . ' '; echo date("Y"); ?></p>
            </div>
        </div>
    </div>
</footer>
<!-- Footer scripts-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')</script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
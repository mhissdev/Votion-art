<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_admin_open'); ?>
<?php $this->load->view('templates/header_admin_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Images</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <?php
                        // Show upload form
                        $this->load->view('partials/upload_form');
                    ?>
                </div>
            </div>
        </div><!--/.Container -->
<?php $this->load->view('templates/footer_admin_open'); ?>
<!-- AJAX Upload -->
<script type="text/javascript">
    $(document).ready(function(){

        $("#upload-submit").on('click',function(event){
            //  Stop non-ajax request
            event.preventDefault();

            // Get data from form
            var form = $('#upload-form')[0];
            var data = new FormData(form);


            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'admin/images/upload'; ?>",
                data: data,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    // Set new crsf token
                    $("#upload-form input[name='csrf_token']").val(response.csrf_token);
                    
                    console.log(response);
                }
            });
            
        });

    });
</script>

<?php $this->load->view('templates/footer_admin_close'); ?>
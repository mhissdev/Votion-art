<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* image_select_script.php
* JS / AJAX image upload
* Mark Hiscock 06.03.17
*/
?>
<script type="text/javascript">
    $(document).ready(function(){

        /*******************************************************************************
        * Image click event handler
        *******************************************************************************/
        function onImageClickHandler(obj){

            // Display selected image in page
            var imagePath = $(obj).find('img').attr('src');
            $('#image-select-holder').html('<img src="' + imagePath + '" class="img-responsive">');

            // Add current image selection ID to form
            $('#current-image-selection').val(obj.id.replace('select-image', ''));

            // Close modal
            $('#image-select-modal').modal('toggle');
        }

        /*******************************************************************************
        * AJAX image upload
        *******************************************************************************/
        $("#upload-submit").on('click',function(event){
            //  Stop non-ajax request
            event.preventDefault();

            // Set message
            $('#message-upload').html('<p>Uploading...</p>');

            // Get data from form
            var form = $('#upload-form')[0];
            var data = new FormData(form);

            // Perform AJAX request
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'admin/images/upload'; ?>",
                data: data,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    // Set new crsf token for ALL forms on page
                    $("input[name='csrf_token']").val(response.csrf_token);

                    // Rest filename on upload form
                    $('#upload-file').val('');

                    // Set message
                    $('#message-upload').html(response.message);

                    if(response.success === true)
                    {
                        // Add image to modal
                        var imagePath = '<?php echo base_url(); ?>' + 'uploads/' + response.filename;
                        var imageHTML = '<div class="select-image" id="select-image' + response.id + '">';
                        imageHTML += '<img src="' + imagePath + '" class="img-thumbnail img-responsive">';
                        imageHTML += '</div>';
                        $('.select-modal-images').append(imageHTML);

                        // Set click handler to include new image
                        $('.select-image').on('click', function(){
                            onImageClickHandler(this);
                        });

                    }

                }
            });
            
        });

        /*******************************************************************************
        * Click event for image select
        *******************************************************************************/
        $('.select-image').on('click', function(){
            // Call handler
            onImageClickHandler(this);

        });

    });
</script>
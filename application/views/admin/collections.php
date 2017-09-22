<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_admin_open'); ?>
<!-- Datatables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css"/>
<?php $this->load->view('templates/header_admin_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Collections</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                        // Output user message
                        if($collection_message != '')
                        {
                            echo '<div class="alert alert-success"><p>' . $collection_message . '</p></div>';
                        }

                        // Output collection table
                        echo $collection_table;
                    ?>
                    <!-- New collection button -->
                    <p><a href="<?php echo base_url() . 'admin/collections/manage'; ?>" class="btn btn-primary">Add New Collection</a></p>
                </div>
            </div>

        </div><!--/.Container -->

<?php $this->load->view('templates/footer_admin_open'); ?>
<!-- Datatables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.13/datatables.min.js"></script>
<script>
    // Init datatables
    $(document).ready(function(){
        $('#collections-table').DataTable({
            "columnDefs": [{ "orderable": false, "targets": 3}]
        });
    });  
</script> 
<?php $this->load->view('templates/footer_admin_close'); ?>
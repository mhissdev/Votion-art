<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_open'); ?>
<?php $this->load->view('templates/header_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Add New User</h1>
                    <div class="well" style="margin-top: 20px">
                        <p>Please enter an email address and password</p>
                        <!-- Add user Form -->
                        <?php echo form_open(base_url() . 'setup'); ?>
                            <div class="form-group">
                                <label for="add-user-username">Email:</label>
                                <input type="email" class="form-control" id="add-user-username" name="add-user-username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="add-user-password">Password:</label>
                                <input type="password" class="form-control" id="add-user-password" name="add-user-password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="add-user-password2">Password Confirm:</label>
                                <input type="password" class="form-control" id="add-user-password2" name="add-user-password2" placeholder="Re-enter Password">
                            </div>
                            <?php
                                // Output validation errors
                                if($has_validation_errors == true)
                                {
                                    echo '<div class="alert alert-danger"><ul>';
                                    echo validation_errors('<li>', '</li>');
                                    echo '</ul></div>';
                                }
                            ?>

                            <?php
                                // Output validation errors
                                if($success_message != '')
                                {
                                    echo '<div class="alert alert-success"><p>';
                                    echo $success_message;
                                    echo '</p></div>';
                                }
                            ?>
                            <input class="btn btn-primary" type="submit" name="add-user" value="Add User">
                        </form>
                    </div>
                    
                </div>
            </div>
        </div><!--/.Container -->
<?php $this->load->view('templates/footer_open'); ?>
<?php $this->load->view('templates/footer_close'); ?>
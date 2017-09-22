<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_admin_open'); ?>
<?php $this->load->view('templates/header_admin_close'); ?>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Users</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h3>Change Password</h3>
                    <div class="well" style="margin-top: 20px">
                        <!-- Update password Form -->
                        <?php echo form_open(base_url() . 'admin/users'); ?>
                            <div class="form-group">
                                <label for="user-password">Old Password:</label>
                                <input type="password" class="form-control" id="user-password" name="user-password" placeholder="Old Password">
                            </div>
                            <div class="form-group">
                                <label for="user-new-password">New Password:</label>
                                <input type="password" class="form-control" id="user-new-password2" name="user-new-password" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <label for="user-new-password2">New Password Confirm:</label>
                                <input type="password" class="form-control" id="user-new-password2" name="user-new-password2" placeholder="Re-enter New Password">
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
                            <input class="btn btn-primary" type="submit" name="password-update" value="Update">
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Current Users</h3>
                     <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Output users
                            foreach($users as $user)
                            {
                                echo '<tr><td>' . $user['user_email'] . '</td></tr>';
                            }

                            ?>
                        </tbody>
                     </table>
                </div>
            </div>
        </div><!--/.Container -->
<?php $this->load->view('templates/footer_admin_open'); ?>
<?php $this->load->view('templates/footer_admin_close'); ?>
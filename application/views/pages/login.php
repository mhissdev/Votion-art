<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>

        <!-- Main Content -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <div class="well" style="margin-top: 20px">
                        <h2>Login:</h2>
                        <!-- Login Form -->
                        <?php echo form_open(base_url() . 'login'); ?>
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="login-username" name="login-username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="login-password">Password:</label>
                                <input type="password" class="form-control" id="login-password" name="login-password" placeholder="Password">
                            </div>
                            <?php
                                // Output validation errors
                                if($has_validation_errors == true)
                                {
                                    echo '<div class="alert alert-danger"><ul>';
                                    echo validation_errors('<li>', '</li>');
                                    echo '</ul></div>';
                                }

                                // Output login failed
                                if($login_failed == true)
                                {
                                   echo '<div class="alert alert-danger"><p>Login unsuccessful. Username and password do NOT match!</p></div>'; 
                                }
                            ?>
                            <input class="btn btn-primary" type="submit" name="login-submit" value="Login">
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
</html>
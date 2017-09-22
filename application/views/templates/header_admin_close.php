<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    </head>
    <body>

        <!-- Fixed navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <?php $this->navigation_admin->output($page_name); ?>
                    <!-- Logout -->
                    <ul class="nav navbar-nav navbar-right">
                        <li><p class="navbar-btn"><a href="<?php echo base_url(); ?>login/logout" class="btn btn-primary btn-sm">Log Out</a></p></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
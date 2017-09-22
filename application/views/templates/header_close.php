<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
</head>
<body>
<!-- Site header and navigation -->
<header>
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <i id="custom-toggle" class="fa fa-bars fa-2x" aria-hidden="true"></i>
                </button>
            <a class="navbar-brand navbar-right" href="<?php echo base_url(); ?>"></a>
                </div>
            <div id="navbar" class="navbar-collapse collapse navbar-right">
                <?php $this->navigation_main->output($this->pagemeta->getNavName()); ?>
            </div><!--/.navbar-collapse -->
        </div>
    </nav>
</header>
<!-- Main content-->

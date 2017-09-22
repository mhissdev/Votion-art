<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header_open'); ?>
<?php $this->load->view('templates/header_close'); ?>
<!-- Homepage banner -->
<div class="top-container home-top-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>High quality, unique, and limited edition art prints</h1>
                <a href="<?php echo base_url() . 'store'; ?>" class="btn btn-primary btn-lg">Enter Store</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Featured Collections</h2>
        </div>
    </div>

    <!-- Featured collections -->
    <div class="row">
    <?php
        // Build HTML
        $str = '';

        foreach($collections as $collection)
        {
            // Add item
            $str .= '<div class="col-md-4">';
            $str .= '<a href="' . base_url() . 'store/collection/' . $collection['collection_slug'] . '">';
            $str .= '<img src="' . base_url() . 'uploads/' . $collection['image_filename'] . '" ';
            $str .= 'alt="' . $collection['collection_name'] . '" title="' . $collection['collection_name'] . '" class="img-responsive">';
            $str .= '<h3 class="text-center">' . $collection['collection_name'] . ' (' . $collection['num_products'] . ')</h3>';
            $str .= '</a>';
            $str .= '</div>';
        }

        // Output HTML
        echo $str;
    ?>
    </div>

    <!-- Homepage info -->
    <div class="row">
        <div class="col-md-12 text-center" style="margin-top:50px">
            <p>We specialise in creating Unique and Limited Edition design prints in honour of past, present and upcoming media. Never will we limit ourselves to what we are inspired by, be that Films, Games, Music or Art. Our services will never limit our creativity.</p>
            <p><strong>Printed locally on the highest quality paper, these prints are slick contemporary slices of modern culture for your home.</strong></p>
            <p>It’s never been so easy for you select, purchase and get your very own unique art print delivered. Head on over to the <strong><a href="<?php echo base_url(); ?>store">store</a></strong> and choose your favourite print design. We use local businesses around Bath for printing and delivery is usually around 5-7 days.</p>
        </div>
    </div>
</div>
<?php $this->load->view('templates/footer_open'); ?>
<?php $this->load->view('templates/footer_close'); ?>

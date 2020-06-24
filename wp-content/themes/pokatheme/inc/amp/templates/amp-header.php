<!doctype html>
<html amp <?php echo AMP_HTML_Utils::build_attributes_string( $this->get( 'html_tag_attributes' ) ); ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <?php do_action( 'amp_post_template_head', $this ); ?>
    <style amp-custom>
        <?php $this->load_parts( array( 'style')); ?>
        <?php do_action( 'amp_post_template_css', $this); ?>
    </style>
</head>

<body class="<?php echo esc_attr( $this->get( 'body_class' ) ); ?>">

    <header class="amp-header">
        <div class="container">
            <a href="<?php echo esc_url( home_url() ); ?>" class="amp-logo">
                <?php
                if( get_field('site_logo','options') ){
                    $site_icon_url = get_field('site_logo','options');
                } else {
                    $site_icon_url = get_template_directory_uri().'/images/logo.png';
                }
                ?>
                <amp-img src="<?php echo esc_url( $site_icon_url ); ?>" layout="fill" class="amp-logo-img"></amp-img>
            </a>
            <button class="amp-toggle-menu" on='tap:sidemenu.toggle'><i class="icon-poka icon-poka-menu"></i></button>
        </div>
        <!-- /.container -->
    </header>

    <amp-sidebar id="sidemenu" layout="nodisplay" side="left">
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'menu hidden-md-down', 'container' => false ) ); ?>
    </amp-sidebar>

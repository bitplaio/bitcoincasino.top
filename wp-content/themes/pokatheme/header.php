<?php
// =============================================================================
// The Header for our theme.
// =============================================================================
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php do_action( 'poka_after_body' ); ?>

        <div id="page-wrapper">

        <?php
            //Load the users header style
            if( get_field('header_style','options') ){
                get_template_part( 'inc/templates/header', get_field('header_style','options') );
            } else {
                get_template_part( 'inc/templates/header', 'style1' );
            }
        ?>


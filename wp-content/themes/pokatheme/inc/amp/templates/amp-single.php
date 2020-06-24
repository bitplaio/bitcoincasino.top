<?php
//use of include in order for $this to work in sub templates
include( get_theme_file_path( 'inc/amp/templates/amp-header.php' ) );
?>
    <article class="amp-wp-article">

        <header class="amp-wp-article-header">
            <h1><?php echo wp_kses_data( $this->get( 'post_title' ) ); ?></h1>
            <?php $this->load_parts( apply_filters( 'amp_post_article_header_meta', array( 'meta-author', 'meta-time' ) ) ); ?>
        </header>

        <?php $this->load_parts( array( 'featured-image' ) ); ?>

        <div class="amp-wp-article-content">
            <?php echo $this->get( 'post_amp_content' ); // amphtml content; no kses ?>
        </div>

        <footer class="amp-wp-article-footer">
            <?php $this->load_parts( apply_filters( 'amp_post_article_footer_meta', array( 'meta-taxonomy' ) ) ); ?>
        </footer>

    </article>

<?php include( get_theme_file_path( 'inc/amp/templates/amp-footer.php' ) ); ?>

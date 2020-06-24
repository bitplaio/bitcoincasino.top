<?php
//use of include in order for $this to work in sub templates
include( get_theme_file_path( 'inc/amp/templates/amp-header.php' ) );
?>
    <?php
    if( get_field('full_width_sections') ):
        $counter = 1;
        while ( have_rows('full_width_sections') ) { the_row();
        ?>
            <div class="section <?php if($counter == 1) echo 'section--first'; ?>">
                <div class="container">
                    <div class="textarea">
                        <?php
                        list( $fullwidthcont, $featured_scripts, $featured_styles ) = AMP_Content_Sanitizer::sanitize(
                        get_sub_field('section_content'),
                        array(
                            'AMP_Style_Sanitizer' => array(),
                            'AMP_Img_Sanitizer' => array(),
                            'AMP_Video_Sanitizer' => array(),
                            'AMP_Audio_Sanitizer' => array(),
                            'AMP_Playbuzz_Sanitizer' => array(),
                            'AMP_Iframe_Sanitizer' => array(
                                'add_placeholder' => true,
                            ),
                            'AMP_Tag_And_Attribute_Sanitizer' => array(),
                             ),
                        array(
                            'content_max_width' => $this->get( 'content_max_width' ),
                        )
                        );
                        echo $fullwidthcont;
                        ?>
                    </div>
                    <!-- /.text-area -->
                </div>
                <!-- /.container -->
            </div>
            <!-- /.section -->
        <?php
            $counter++;
        }

    endif; ?>

    <?php if( trim($this->get( 'post_amp_content' )) != "" ): ?>
    <article class="textarea section">
        <div class="container">
            <h1><?php echo wp_kses_data( $this->get( 'post_title' ) ); ?></h1>
            <?php echo $this->get( 'post_amp_content' ); // amphtml content; no kses ?>
        </div>
        <!-- /.container -->
    </article>
    <?php endif; ?>

<?php include( get_theme_file_path( 'inc/amp/templates/amp-footer.php' ) ); ?>

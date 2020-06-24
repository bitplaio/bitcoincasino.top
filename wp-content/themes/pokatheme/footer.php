<?php
// =============================================================================
// The template for displaying the footer.
// =============================================================================
?>
            <footer class="footer">
                <?php
                    if ( is_active_sidebar( 'footer-widget-area-top' ) ) {
                ?>
                    <div class="footer-top">
                        <div class="container">
                        <?php
                            $widget_count = widget_count('footer-widget-area-top');
                        ?>
                            <div class="widget-columns clearfix widget-count-<?php echo $widget_count; ?>">
                                <?php dynamic_sidebar( 'footer-widget-area-top' ); ?>
                            </div><!--.widget-columns-->
                        </div>
                        <!-- /.container -->
                    </div>
                    <!-- /.footer-top -->
                <?php
                    }
                ?>

                <?php
                    if ( is_active_sidebar( 'footer-widget-area-bottom' ) ) {
                ?>
                    <div class="footer-bottom">
                        <div class="container">
                        <?php
                            $widget_count = widget_count('footer-widget-area-bottom');
                        ?>
                            <div class="widget-columns clearfix widget-count-<?php echo $widget_count; ?>">
                                <?php dynamic_sidebar( 'footer-widget-area-bottom' ); ?>
                            </div><!--.widget-columns-->
                        </div>
                        <!-- /.container -->
                    </div>
                    <!-- /.footer-top -->
                <?php
                    }
                ?>

                <?php if( get_field('footer_copyright_text','options') ): ?>
                <div class="footer-copyright">
                    <div class="container">
                        <p><?php the_field('footer_copyright_text','options'); ?></p>
                        <a href="#" class="btn btn-backToTop"><i class="icon-poka icon-poka-arrow-up"></i></a>
                    </div>
                    <!-- /.container -->
                </div>
                <!-- /.footer-copyright -->
                <?php endif; ?>

            </footer>
        </div>
        <!-- /#page-wrapper -->

        <?php if( get_field('google_analytics_code','options') ): ?>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','<?php the_field('google_analytics_code','options'); ?>','auto');ga('send','pageview');
        </script>
        <?php endif; ?>
    <?php
        wp_footer();
    ?>
    </body>
</html>

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
                        <a href="#" class="btn btn-backToTop" aria-label="Back to top"><i class="icon-poka icon-poka-arrow-up"></i></a>
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
        <!-- hit.ua -->
        <a href='http://hit.ua/?x=40521' target='_blank' rel='noreferrer'>
        <script language="javascript" type="text/javascript"><!--
        Cd=document;Cr="&"+Math.random();Cp="&s=1";
        Cd.cookie="b=b";if(Cd.cookie)Cp+="&c=1";
        Cp+="&t="+(new Date()).getTimezoneOffset();
        if(self!=top)Cp+="&f=1";
        //--></script>
        <script language="javascript1.1" type="text/javascript"><!--
        if(navigator.javaEnabled())Cp+="&j=1";
        //--></script>
        <script language="javascript1.2" type="text/javascript"><!--
        if(typeof(screen)!='undefined')Cp+="&w="+screen.width+"&h="+
        screen.height+"&d="+(screen.colorDepth?screen.colorDepth:screen.pixelDepth);
        //--></script>
        <script language="javascript" type="text/javascript"><!--
        Cd.write("<img src='//c.hit.ua/hit?i=40521&g=0&x=1"+Cp+Cr+
        "&r="+escape(Cd.referrer)+"&u="+escape(window.location.href)+
        "' border='0' width='88' height='31' "+
        "alt='hit.ua: сейчас на сайте, посетителей и просмотров за сегодня' title='hit.ua: сейчас на сайте, посетителей и просмотров за сегодня'/>");
        //--></script>
        <noscript>
        <img src='//c.hit.ua/hit?i=40521&amp;g=0&amp;x=1' border='0' width='88' height='31' alt='hit.ua: сейчас на сайте, посетителей и просмотров за сегодня' title='hit.ua: сейчас на сайте, посетителей и просмотров за сегодня'/>
        </noscript></a>
        <!-- / hit.ua -->


        <?php endif; ?>
    <?php
        wp_footer();
    ?>
    </body>
</html>

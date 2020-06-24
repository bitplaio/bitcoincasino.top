    <footer class="amp-footer">
        <div class="container">
            <p>
                <?php the_field('footer_copyright_text','options'); ?>
            </p>
            <a href="#top" class="back-to-top"><?php esc_html_e( 'Back to top', 'poka' ); ?></a>
        </div>
        <!-- /.container -->
    </footer>

    <?php do_action( 'amp_post_template_footer', $this ); ?>

</body>
</html>

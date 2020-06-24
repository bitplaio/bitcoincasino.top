<?php
// =============================================================================
// The Sidebar containing the primary widget areas.
// =============================================================================
?>
    <?php $poka_sidebar_col_class = apply_filters('poka_sidebar_col_class_filter', 'col-md-4'); ?>
    <?php $sidebar_sticky_class   = get_field('make_sidebar_sticky' , 'options') ? 'jsStickySidebar' : ''; ?>
    <div class="<?php echo $poka_sidebar_col_class; ?>" id="sidebar-wrapper">
        <aside class="sidebar <?php echo $sidebar_sticky_class; ?>" id="sidebar">
            <?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
                <?php dynamic_sidebar( 'primary-widget-area' ); ?>
            <?php else: ?>
                <div class="poka-msg"><?php poka_printmsg('inactive_widgets'); ?></div>
            <?php endif; ?>
        </aside>
    </div>
    <!-- /.col-md-3 col-sm-12 -->


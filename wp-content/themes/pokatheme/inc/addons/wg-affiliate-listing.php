<?php
// =============================================================================
// Various Shortcodes
// =============================================================================

/**
** Affiliate listing widget
**/
class poka_affiliatelisting extends WP_Widget
{

	public function __construct(){
		$widget_ops = array('classname' => 'widget_affiliatelisting', 'description' => "List of Affiliate Sites" );
        parent::__construct( 'affiliatelisting', 'Affiliate Sites', $widget_ops );
	}

	/**
	* Displays the Widget
	*/
	public function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
		$lineOne = empty($instance['lineOne']) ? '1' : $instance['lineOne'];
		$sort = empty($instance['sort']) ? '1' : $instance['sort'];
		$Number = empty($instance['Number']) ? '5' : $instance['Number'];
		$reviews = empty($instance['reviewslist']) ? '' : $instance['reviewslist'];

		$term = get_term( $lineOne, 'lists' );
        if( $term ){
            $slug = $term->slug;
        } else {
            $slug = "";
        }

        $query_string = array(
            'post_type' => 'affiliates',
            'lists' => $slug,
            'posts_per_page' => $Number
        );

        if( $reviews != '' ){
            $arrayReviews = explode(',', $reviews);
            $query_string['post__in'] = $arrayReviews;
            $query_string['orderby'] = "post__in";
        } else {
            if($sort == "rating") {
                if( get_field('allow_user_rating_in_reviews','options') ){
                    $query_string['meta_key'] = "_votes_avg";
                } else {
                    $query_string['meta_key'] = "affiliate_rating";
                }
                $query_string['orderby'] = "meta_value_num";
                $query_string['order'] = "DESC";

            } elseif($sort == "title") {
                $query_string['orderby'] = "title";
                $query_string['order'] = "ASC";

            } elseif($sort == "date") {
                $query_string['orderby'] = "date";
                $query_string['order'] = "DESC";
            }
        }
?>
        <div class="widget">
            <h3><?php echo $title ?></h3>
            <ul class="widget-list widget-s1 clearfix">
                <?php // The Query

                    $widget_query = new WP_query();
                    $widget_query->query( $query_string );
                $i=1;

                    if ($widget_query->have_posts()) : while ($widget_query->have_posts()) : $widget_query->the_post(); ?>
                <li class="clearfix">
                    <div class="pull-left number-box">
                        <?php echo $i; ?>.
                    </div>
                    <div class="pull-right widget-sites-group">
                    <div class="img">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('aff-thumb'); ?></a>
                    </div>
                    <!-- /.img -->

                    <div class="text-down clearfix">
                        <p><?php the_field('bonus_promo_title'); ?></p>
                        <?php if( get_field('affiliate_link') ): ?>
                            <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID ); ?>" target="_blank" class="btn btn--green d-none d-lg-inline-block" rel="nofollow" <?php echo poka_link_onclick(get_field('affiliate_link')->ID); ?>><?php echo poka_get_translation('Play!'); ?></a>
                            <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID , 'mobile' ); ?>" target="_blank" class="btn btn--green hidden-lg-up" rel="nofollow" <?php echo poka_link_onclick(get_field('affiliate_link')->ID , 'mobile'); ?>><?php echo poka_get_translation('Play!'); ?></a>
                        <?php endif; ?>
                    </div>
                    <!-- /.text-down -->
                    <?php echo poka_terms_text_return( get_the_ID() ); ?>
                    </div>
                    <!-- /.widget-sites-group -->
                </li>
                <?php $i++; endwhile; endif; wp_reset_query();  ?>
            </ul>
            <!-- /.widget-s1 -->
            <?php
            if($slug !== ""){
                echo '<a class="view-all" href="'.get_term_link($term).'">'.esc_html__('view complete list','poka').'</a>';
            }
            ?>


        </div>
        <!-- /.widget -->
<?php
	}

	/**
	* Saves the widgets settings.
	*/
	public function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['lineOne'] = strip_tags(stripslashes($new_instance['lineOne']));
		$instance['Number'] = strip_tags(stripslashes($new_instance['Number']));
		$instance['sort'] = strip_tags(stripslashes($new_instance['sort']));
		$instance['reviewslist'] = strip_tags(stripslashes($new_instance['reviewslist']));

		return $instance;
	}

	/**
	* Creates the edit form for the widget.
	*/
	public function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'', 'lineOne'=>'1', 'Number'=>'5', 'reviewslist'=>'') );

		$title = htmlspecialchars($instance['title']);
		$lineOne = htmlspecialchars($instance['lineOne']);
		$sort = htmlspecialchars( empty($instance['sort']) ? "date": $instance['sort']);
		$Number = htmlspecialchars($instance['Number']);
		$reviewslist = htmlspecialchars($instance['reviewslist']);

		# Output the options

		# Title
		echo '<p><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input id="' . $this->get_field_id('title') . '" class="widefat" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';

		# Category selector
		echo '<p>
				<label for="' . $this->get_field_name('lineOne') . '">Category Name:';
				wp_dropdown_categories( array('name' => $this->get_field_name('lineOne'), 'id' => $this->get_field_id('lineOne'), 'class' => 'widefat', 'selected' => $lineOne, 'hide_empty' => 0, 'taxonomy' => 'lists', 'show_option_all' => 'Show all') );
		echo '</label></p>';

		# Sort selector
		echo '<p><label for="' . $this->get_field_name('sort') . '">Sort:<br/>';
        echo '<select id="' . $this->get_field_id('sort') . '" name="' . $this->get_field_name('sort') . '">';
        echo '<option value="date" '.(($sort === "date") ? "selected" : "").'>Date</option>';
        echo '<option value="rating" '.(($sort === "rating") ? "selected" : "").'>Rating</option>';
        echo '<option value="title" '.(($sort === "title") ? "selected" : "").'>Title</option>';
        echo '</select></label>';
		echo '</p>';

		# Number of Posts
		echo '<p><label for="' . $this->get_field_name('Number') . '">' . 'Number of Posts' . ' <input id="' . $this->get_field_id('Number') . '" class="widefat" name="' . $this->get_field_name('Number') . '" type="text" value="' . $Number . '" /></label></p>';

		# Number of Posts
		echo '<p><label for="' . $this->get_field_name('reviewslist') . '">' . 'Display only specific reviews (For example: 12,8,20)' . ' <input id="' . $this->get_field_id('reviewslist') . '" name="' . $this->get_field_name('reviewslist') . '" type="text" class="widefat" value="' . $reviewslist . '" /></label></p>';
	}

}

/**
* Register AffiliateListing widget.
*/
function poka_affiliatelistingInit() {
	register_widget('poka_affiliatelisting');
}
add_action('widgets_init', 'poka_affiliatelistingInit');
/**********************************************************************/


/**
** Affiliate listing small widget
**/
class poka_affiliatelisting_sm extends WP_Widget
{

	public function __construct(){
		$widget_ops = array('classname' => 'widget_affiliatelisting', 'description' => "Simple list of Affiliate Sites" );
        parent::__construct( 'affiliatelisting2', 'Affiliate Sites simple', $widget_ops );
	}

	/**
	* Displays the Widget
	*/
	public function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
		$lineOne = empty($instance['lineOne']) ? '1' : $instance['lineOne'];
		$Number = empty($instance['Number']) ? '5' : $instance['Number'];
        $sort = empty($instance['sort']) ? '1' : $instance['sort'];
        $reviews = empty($instance['reviewslist']) ? '' : $instance['reviewslist'];

		$term = get_term( $lineOne, 'lists' );
        if( $term ){
            $slug = $term->slug;
        } else {
            $slug = "";
        }

        $query_string = array(
            'post_type' => 'affiliates',
            'lists' => $slug,
            'posts_per_page' => $Number
        );

        if( $reviews != '' ){
            $arrayReviews = explode(',', $reviews);
            $query_string['post__in'] = $arrayReviews;
            $query_string['orderby'] = "post__in";
        } else {
            if($sort == "rating") {
                if( get_field('allow_user_rating_in_reviews','options') ){
                    $query_string['meta_key'] = "_votes_avg";
                } else {
                    $query_string['meta_key'] = "affiliate_rating";
                }
                $query_string['orderby'] = "meta_value_num";
                $query_string['order'] = "DESC";

            } elseif($sort == "title") {
                $query_string['orderby'] = "title";
                $query_string['order'] = "ASC";

            } elseif($sort == "date") {
                $query_string['orderby'] = "date";
                $query_string['order'] = "DESC";
            }
        }
?>
        <div class="widget">
            <h3><?php echo $title ?></h3>
            <ul class="widget-list widget-s2">
            <?php // The Query

                $widget_query = new WP_query();
                $widget_query->query( $query_string );

                if ($widget_query->have_posts()) : while ($widget_query->have_posts()) : $widget_query->the_post(); ?>
                <li class="clearfix">
                    <div class="clearfix">
                        <div class="text">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('aff-thumb'); ?></a>
                            <p><?php the_field('bonus_promo_title'); ?></p>
                        </div>
                        <!-- /.text -->
                        <?php if( get_field('affiliate_link') ) : ?>
                            <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID ); ?>" class="btn btn--green d-none d-lg-inline-block" target="_blank" rel="nofollow" <?php echo poka_link_onclick(get_field('affiliate_link')->ID); ?>><?php echo poka_get_translation('Play!'); ?></a>
                            <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID , 'mobile' ); ?>" class="btn btn--green hidden-lg-up" target="_blank" rel="nofollow" <?php echo poka_link_onclick(get_field('affiliate_link')->ID , 'mobile'); ?>><?php echo poka_get_translation('Play!'); ?></a>
                        <?php endif; ?>
                    </div>
                    <!-- /.clearfix -->
                    <?php echo poka_terms_text_return( get_the_ID() ); ?>
                </li>
                <?php  endwhile; endif; wp_reset_query();  ?>
            </ul>
            <!-- /.widget-s2 -->
            <?php
            if($slug !== ""){
                echo '<a class="view-all" href="'.get_term_link($term).'">'.esc_html__('view complete list','poka').'</a>';
            }
            ?>
        </div>
        <!-- /.widget -->

<?php
	}

	/**
	* Saves the widgets settings.
	*/
	public function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['lineOne'] = strip_tags(stripslashes($new_instance['lineOne']));
		$instance['Number'] = strip_tags(stripslashes($new_instance['Number']));
        $instance['sort'] = strip_tags(stripslashes($new_instance['sort']));
        $instance['reviewslist'] = strip_tags(stripslashes($new_instance['reviewslist']));

		return $instance;
	}

	/**
	* Creates the edit form for the widget.
	*/
	public function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'', 'lineOne'=>'1', 'Number'=>'5', 'reviewslist'=>'') );

		$title = htmlspecialchars($instance['title']);
		$lineOne = htmlspecialchars($instance['lineOne']);
		$Number = htmlspecialchars($instance['Number']);
        $reviewslist = htmlspecialchars($instance['reviewslist']);
        $sort = htmlspecialchars( empty($instance['sort']) ? "date": $instance['sort']);

		# Output the options

		# Title
		echo '<p><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input id="' . $this->get_field_id('title') . '" class="widefat" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';

		# Category selector
		echo '<p>
				<label for="' . $this->get_field_name('lineOne') . '">Category Name:';
				wp_dropdown_categories( array('name' => $this->get_field_name('lineOne'), 'id' => $this->get_field_id('lineOne'), 'class' => 'widefat', 'selected' => $lineOne, 'hide_empty' => 0, 'taxonomy' => 'lists', 'show_option_all' => 'Show all') );
		echo '</p>';

		# Sort selector
		echo '<p><label for="' . $this->get_field_name('sort') . '">Sort:<br/>';
        echo '<select id="' . $this->get_field_id('sort') . '" name="' . $this->get_field_name('sort') . '">';
        echo '<option value="date" '.(($sort === "date") ? "selected" : "").'>Date</option>';
        echo '<option value="rating" '.(($sort === "rating") ? "selected" : "").'>Rating</option>';
        echo '<option value="title" '.(($sort === "title") ? "selected" : "").'>Title</option>';
        echo '</select></label>';
		echo '</p>';

		# Number of Posts
		echo '<p><label for="' . $this->get_field_name('Number') . '">' . 'Number of Posts' . ' <input id="' . $this->get_field_id('Number') . '" class="widefat" name="' . $this->get_field_name('Number') . '" type="text" value="' . $Number . '" /></label></p>';

		# Number of Posts
		echo '<p><label for="' . $this->get_field_name('reviewslist') . '">' . 'Display only specific reviews (For example: 12,8,20)' . ' <input id="' . $this->get_field_id('reviewslist') . '" name="' . $this->get_field_name('reviewslist') . '" type="text" class="widefat" value="' . $reviewslist . '" /></label></p>';
	}

}

/**
* Register AffiliateListing widget.
*/
function poka_affiliatelisting_sm_init() {
	register_widget('poka_affiliatelisting_sm');
}
add_action('widgets_init', 'poka_affiliatelisting_sm_init');

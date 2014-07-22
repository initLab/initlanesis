<?php
/*
 Add function to widgets_init that'll load our widget.
 */
add_action(  'widgets_init', 'zp_latest_portfolio_widgets'  );

/*
 * Register widget.
 */
function zp_latest_portfolio_widgets(  ) {
	register_widget(  'zp_latest_portfolio_widget'  );
}

/*
 * Widget class.
 */
class zp_latest_portfolio_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function ZP_LATEST_PORTFOLIO_Widget(  ) {
	
		/* Widget settings. */
		$widget_ops = array(  'classname' => 'zp_latest_portfolio_widget', 'description' => __( 'A widget that displays your latest portfolio photos.', 'novo' )  );

		/* Create the widget. */
		$this->WP_Widget(  'zp_latest_portfolio_widget', __( 'ZP Latest Portfolio', 'novo' ), $widget_ops  );
		
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget(  $args, $instance  ) {
		extract(  $args  );

		global $post;
		
		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title']  );
		$portfoliocount = $instance['portfoliocount'];

		/* Before widget ( defined by themes ). */
		echo $before_widget;

		/* Display the widget title if one was input ( before and after defined by themes ). */
		if (  $title  )
			echo $before_title . $title . $after_title;

		/* Display latest portfolio */
			$args= array( 
				  'posts_per_page' => $portfoliocount,
				   'orderby' => 'rand',
				   'post_type' => 'portfolio',
				   'post_status' => 'publish'		
			);				
			query_posts( $args );
			?>
            <ul>
            <?php 
			if(  have_posts(  )  ) {												
				while (  have_posts(  )  ) {
					the_post(  ); 
					?>
					<li>
                    	<a href="<?php echo the_permalink();?>"><?php the_post_thumbnail('latest_portfolio_widget');  ?></a>
                    </li>
					<?php
				}
			}?>
			</ul>

         	<?php
			wp_reset_query();
		/* After widget ( defined by themes ). */
		echo $after_widget;
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update(  $new_instance, $old_instance  ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML ( important for text inputs ). */
		$instance['title'] = strip_tags(  $new_instance['title']  );
		$instance['portfoliocount'] = strip_tags(  $new_instance['portfoliocount']  );

		/* No need to strip tags for.. */

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id(  ) and get_field_name(  ) function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	 
	function form(  $instance  ) {

		/* Set up some default widget settings. */
		$defaults = array( 
		'title' => 'Latest Portfolio Widget',
		'portfoliocount' => '9'
		 );
		$instance = wp_parse_args(  ( array ) $instance, $defaults  ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id(  'title'  ); ?>"><?php _e( 'Title:', 'novo' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id(  'title'  ); ?>" name="<?php echo $this->get_field_name(  'title'  ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- Flickr ID: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id(  'portfoliocount'  ); ?>"><?php _e( 'Number of Posts', 'novo' ) ?> </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id(  'portfoliocount'  ); ?>" name="<?php echo $this->get_field_name(  'portfoliocount'  ); ?>" value="<?php echo $instance['portfoliocount']; ?>" />
		</p>
		
		
	<?php
	}
}

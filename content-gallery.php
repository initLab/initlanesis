<?php  
    
//* Audio post format

	$content = get_the_content(); 
	$title = get_the_title(  );
	$permalink=get_permalink(  );	
	
	wp_enqueue_script(  'jquery_flexslider_js'  );

	echo '<div class="media_container">';
	           zp_gallery($post->ID, 'Blog'); 			
	echo '</div>';
	
	echo '<div class="post_content">';
	do_action( 'genesis_entry_header' );

	do_action( 'genesis_before_entry_content' );
	printf( '<div %s>', genesis_attr( 'entry-content' ) );
		genesis_do_post_content();
	echo '</div>'; //* end .entry-content
	echo '</div>';
  
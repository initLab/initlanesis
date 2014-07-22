<?php 

//* Link Post Format

	$title = get_the_title(  );
	$permalink=get_permalink(  );	

	$link = get_post_meta( $post->ID, 'zp_link_format', true );

	printf( '<div %s>', genesis_attr( 'entry-content' ) );
	echo '<h2><a href="'.$link.'" title="'.$title.'">'.$title.'</a></h2>';	
	echo '<p class="link_source"><a href="'.$link.'">'.$link.'</a></p>';			
	echo '</div>';     
	
	do_action( 'genesis_before_entry_content' );
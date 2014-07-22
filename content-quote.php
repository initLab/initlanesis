<?php 

//* Quote Post Format

	$content = get_the_content(); 
	$title = get_the_title(  );
	$permalink=get_permalink(  );	

	printf( '<div %s>', genesis_attr( 'entry-content' ) );
	echo '<h2>'.$content.'</h2>';	
	echo '<p class="quote_author">'.$title.'</p>';			
	echo '</div>'; 
	
	do_action( 'genesis_before_entry_content' );
<?php 

//* Default standard post

	$content = get_the_content(); 
	$title = get_the_title(  );
	$permalink=get_permalink(  );	
	$image = genesis_get_image(  array(  'format' => 'url', 'size' => genesis_get_option(  'image_size'  )   )   );

//	echo '<div class="media_container">';
		if($image){
//	       printf(  '<a href = "%s" rel = "bookmark"><img class = "post-image" src = "%s" alt="" /></a>', get_permalink(   ), $image   );
		}
//	echo '</div>';
	echo '<div class="post_content">';
	do_action( 'genesis_entry_header' );

	do_action( 'genesis_before_entry_content' );
	printf( '<div %s>', genesis_attr( 'entry-content' ) );
		genesis_do_post_content();
	echo '</div>'; //* end .entry-content
	echo '</div>';

<?php  
    
//* Audio post format

	$content = get_the_content(); 
	$title = get_the_title(  );
	$permalink=get_permalink(  );	
	
	wp_enqueue_script('jquery_fitvids');
	wp_enqueue_script('jquery_jplayer');
	?>
		<script type="text/javascript">
            jQuery(document).ready(function(){
                //fitvideo
               jQuery(".media_container").fitVids();
            });
            
        </script>
	<?php

	echo '<div class="media_container">';
	           zp_audio($post->ID, 1060); 
	echo '</div>';
	
	echo '<div class="post_content">';
	do_action( 'genesis_entry_header' );

	do_action( 'genesis_before_entry_content' );
	printf( '<div %s>', genesis_attr( 'entry-content' ) );
		genesis_do_post_content();
	echo '</div>'; //* end .entry-content
	echo '</div>';

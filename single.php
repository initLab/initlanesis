<?php
/**
 * ZP Custom Single Page 
 */
 
remove_action(	'genesis_loop', 'genesis_do_loop' );

add_action(	'genesis_loop', 'zp_custom_single_template' );

function zp_custom_single_template(){
	global $post, $paged;	

	if ( have_posts() ) : while ( have_posts() ) : the_post();
		
			do_action( 'genesis_before_entry' );

			printf( '<article %s>', genesis_attr( 'entry' ) );

			// check post format and call template
			$format = get_post_format(); 
			get_template_part( 'content', $format );
			
			do_action( 'genesis_after_entry_content' );
			do_action( 'genesis_entry_footer' ); 		
					
			echo '</article>';

			do_action( 'genesis_after_entry' );


		endwhile; 
		
	endif; 


}

genesis();
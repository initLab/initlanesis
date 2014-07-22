<?php 
/* 
 * Archive Page
 *
 */

remove_action(	'genesis_loop', 'genesis_do_loop' );

add_action(	'genesis_loop', 'zp_custom_archive_page' );

function zp_custom_archive_page(){
	global $post, $paged;	
			
	$include = genesis_get_option( 'blog_cat' );
	$exclude = genesis_get_option( 'blog_cat_exclude' ) ? explode( ',', str_replace( ' ', '', genesis_get_option( 'blog_cat_exclude' ) ) ) : '';
	$paged   = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		
	if ( have_posts() ) : while ( have_posts() ) : the_post();
		
			do_action( 'genesis_before_entry' );

			printf( '<article %s>', genesis_attr( 'entry' ) );

			// check post format and call template
			$format = get_post_format(); 
			get_template_part( 'content', $format );

			do_action( 'genesis_after_entry_content' );
		
			//do_action( 'genesis_entry_footer' ); 					
					
			echo '</article>';

			do_action( 'genesis_after_entry' );


		endwhile; 
		
	endif; 
	
	//* Genesis navigation
	genesis_posts_nav();
	
	//* Restore original query
	wp_reset_query();
}

genesis();
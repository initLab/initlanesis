<?php 
/*------------------------------
Template Name: Home Page
------------------------------*/ 

/** Force the full width layout layout on the Portfolio page */

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


// add body class when full width slider is disable add_filter( 'body_class', 'zp_body_class' );
add_filter( 'body_class', 'zp_body_class' );
function zp_body_class( $classes ) {
global $post;
	
$enable = get_post_meta( $post->ID, 'zp_fullwidth_slider_value', true);

if( $enable == 'false' ){
	$classes[] = 'zp_boxed_home';
}
	return $classes;
}

remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'zp_homepage_template' );
function zp_homepage_template() {
?>
<div id="home-wrap">
<?php
	if(  have_posts( ) ) {											
 		while (  have_posts(  )  ) {
			the_post(  ); 
			
			do_shortcode( the_content() );
		}
	}
?>
</div>
<?php
}
genesis();
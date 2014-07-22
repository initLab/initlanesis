<?php
/*
Template Name: Landing
*/

// Add custom body class to the head
add_filter( 'body_class', 'zp_add_body_class' );
function zp_add_body_class( $classes ) {
   $classes[] = 'zp-landing';
   return $classes;
}

add_filter( 'genesis_pre_get_option_site_layout', 'zp_landing_page_layout' );
/**
 * Filter the layout option to force full width.
 *
 */
function zp_landing_page_layout( $opt ) {
	return 'full-width-content';
}

/** Remove navigation, breadcrumbs, footer */
remove_action('genesis_before_header', 'genesis_do_nav');
remove_action('genesis_after_header', 'genesis_do_subnav');
remove_action( 'genesis_before_header', 'genesis_do_subnav' , 5);
remove_action( 'genesis_header', 'genesis_do_nav' );
remove_action( 'genesis_header', 'zp_custom_sidebar_trigger', 8 );

remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'zp_genesis_post_info_sep', 9 );
remove_action( 'genesis_entry_header', 'zp_genesis_page_title_sep', 13 );

remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');

remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_before_content_sidebar_wrap', 'zp_breadcrumb_search_form' );

remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas', 13 );

remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
remove_action( 'genesis_footer', 'zp_do_custom_footer' );

remove_action( 'genesis_footer', 'zp_footer_sep', 5 );

genesis();
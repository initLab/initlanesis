<?php

/**remove loop */

remove_action( 'genesis_loop', 'genesis_do_loop' );





/**remove custom breadcrumbs outside the pgae-wrap id */

remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );



/**add breadcrumbs inside pagewrapID */

add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );



add_action( 'genesis_loop', 'zp_404_page' );

function zp_404_page() { ?>

<article class="page type-page status-publish entry">

	<div class="post entry">

		<?php 
			printf( '<div %s>', genesis_attr( 'entry-content' ) );
		
		?>
        	<h1 class="entrytitle"><?php _e( '404 - Page Not Found!' ,'amelie' ); ?></h1>
			<p><?php printf( __( 'You\'re looking for a page that does not exist! Please try the navigations above..', 'amelie' )); ?></p>

<?php 	echo '</div>'; //* end .entry-content
	echo '</div>'; 
?>
    
</article>

<?php

}

genesis();


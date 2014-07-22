<?php 

// ZP Custom Post Types Initialization

 

function zp_custom_post_type() {

    if ( ! class_exists( 'Super_CPT' ) )

        return;


		
/*----------------------------------------------------*/
// Add Slide Custom Post Type
/*---------------------------------------------------*/
 
 	$slide_custom_default = array(
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'menu_icon' => get_stylesheet_directory_uri().'/include/cpt/images/slide.png',
	);

	// register slide post type
	$slide = new Super_Custom_Post_Type( 'slide', 'Slide', 'Slides',  $slide_custom_default );
	$slideshow = new Super_Custom_Taxonomy( 'slideshow' ,'Slideshow', 'Slideshows', 'cat' );
	connect_types_and_taxes( $slide, array( $slideshow ) );

	// Slide meta boxes
	$slide->add_meta_box( array(
		'id' => 'slider-settings',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			'video_type_value' => array( 'label' => __( 'Video Type','novo'), 'type' => 'select', 'options' => array('youtube' => 'Youtube','vimeo' => 'Vimeo') , 'data-zp_desc' => __( 'Select appropriate video type','novo') ),
			'video_id_value' => array( 'label' => __( 'Video ID','novo'), 'type' => 'text', 'data-zp_desc' => __( 'Enter video ID. Example: VdvEdMMtNMY','novo') ),
			'slider_button_value' => array( 'label' => __( 'Slide Button','novo'), 'type' => 'text' , 'data-zp_desc' => __( 'Enter Button Name','novo') ),				
			'slider_link_value' => array( 'label' => __( 'Slide Link','novo' ), 'type' => 'text' , 'data-zp_desc' => __( 'Put slide link here','novo') ),		
		)
	) );	

	$slide->add_meta_box( array(
		'id' => 'slide-order',
		'context' => 'side',
		'fields' => array(
			'slide_number_value' => array( 'type' => 'text', 'data-zp_desc' => __( 'Define slide order. Ex. 1,2,3,4,...','novo') ),		
		)
	) );		

	// manage slide columns 
	function zp_add_slide_columns($columns) {
		return array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Title', 'novo'),
			'slideshow' => __('Slideshow', 'novo'),
			'slide_order' =>__( 'Slide Order', 'novo'),
			'date' => __('Date', 'novo'),			
		);
	}
	add_filter('manage_slide_posts_columns' , 'zp_add_slide_columns');

	function zp_custom_slide_columns( $column, $post_id ) {
		switch ( $column ) {
		case 'slideshow' :
			$terms = get_the_term_list( $post_id , 'slideshow' , '' , ',' , '' );
			if ( is_string( $terms ) )
				echo $terms;
			else
				_e( 'Unable to get author(s)', 'novo' );
			break;
	
		case 'slide_order' :
			echo get_post_meta( $post_id , 'slide_number_value' , true ); 
			break;
		}
	}
	add_action( 'manage_posts_custom_column' , 'zp_custom_slide_columns', 10, 2 );
	
	
/*----------------------------------------------------*/

// Add Portfolio Custom Post Type

/*---------------------------------------------------*/



	$portfolio_custom_default = array(

		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'excerpt'),	

		'menu_icon' =>  get_stylesheet_directory_uri().'/include/cpt/images/portfolio.png',

	);



	// register portfolio post type

	$portfolio = new Super_Custom_Post_Type( 'portfolio', 'Portfolio', 'Portfolio',  $portfolio_custom_default );

	$portfolio_category = new Super_Custom_Taxonomy( 'portfolio_category' ,'Portfolio Category', 'Portfolio Categories', 'cat' );

	connect_types_and_taxes( $portfolio, array( $portfolio_category ) );



	// Portfolio meta boxes



	$portfolio->add_meta_box( array(

		'id' => 'portfolio-metaItem',

		'context' => 'normal',

		'priority' => 'high',

		'fields' => array(

			'zp_project_label_value' => array( 'label' => __( 'Project Label','novo'), 'type' => 'text', 'data-zp_desc' => __( 'Define project label','novo')  ),	

			'zp_project_link_value' => array( 'label' => __( 'Project Link','novo'), 'type' => 'text', 'data-zp_desc' => __( 'Define project link','novo')  ),			

		)

	) );



	$portfolio->add_meta_box( array(

		'id' => 'portfolio-images',

		'context' => 'normal',

		'priority' => 'high',

		'fields' => array(

			'zp_image_1_value' => array( 'label' => __( 'Image 1','novo'), 'type' => 'text' , 'data-zp_desc' => __( 'Place here the full image path','novo' )),		

			'zp_image_2_value' => array( 'label' => __( 'Image 2','novo'), 'type' => 'text' , 'data-zp_desc' => __( 'Place here the full image path','novo' ) ),	

			'zp_image_3_value' => array( 'label' => __( 'Image 3','novo'), 'type' => 'text' , 'data-zp_desc' => __( 'Place here the full image path','novo' )),	

			'zp_image_4_value' => array( 'label' => __( 'Image 4','novo'), 'type' => 'text' , 'data-zp_desc' => __( 'Place here the full image path','novo' )),	

			'zp_image_5_value' => array( 'label' => __( 'Image 5','novo'), 'type' => 'text' , 'data-zp_desc' => __( 'Place here the full image path','novo' )),															

		)

	) );



	$portfolio->add_meta_box( array(

		'id' => 'portfolio-videos',

		'context' => 'normal',

		'priority' => 'high',

		'fields' => array(

			'zp_video_url_value' => array( 'label' => __( 'Youtube or Vimeo URL','novo'), 'type' => 'text', 'data-zp_desc' => __( 'Place here the video url. Example video url: YOUTUBE: http://www.youtube.com/watch?v=Sv5iEK-IEzw and VIMEO: http://vimeo.com/7585127','novo') ),		

			'zp_video_embed_value' => array( 'label' => __( 'Embed Code','novo'), 'type' => 'text' , 'data-zp_desc' => __( 'If you are using anything else other than YouTube or Vimeo, paste the embed code here. This field will override anything from the above.','novo' )),	
											

		)

	) );		

	

	

	// manage portfolio columns 

	function zp_add_portfolio_columns($columns) {

		return array(

			'cb' => '<input type="checkbox" />',

			'title' => __('Title', 'novo'),

			'portfolio_category' => __('Portfolio Category', 'novo'),

			'author' =>__( 'Author', 'novo'),

			'date' => __('Date', 'novo'),			

		);

	}

	add_filter('manage_portfolio_posts_columns' , 'zp_add_portfolio_columns');



	function zp_custom_portfolio_columns( $column, $post_id ) {

		switch ( $column ) {

		case 'portfolio_category' :

			$terms = get_the_term_list( $post_id , 'portfolio_category' , '' , ',' , '' );

			if ( is_string( $terms ) )

				echo $terms;

			else

				_e( 'Unable to get author(s)', 'novo' );

			break;

		}

	}

	add_action( 'manage_posts_custom_column' , 'zp_custom_portfolio_columns', 10, 2 );




/*----------------------------------------------------*/
// Add Post Custom Meta
/*---------------------------------------------------*/	

	$post_meta = new Super_Custom_Post_Meta( 'post' );

	$post_meta->add_meta_box( array(

		'id' => 'audio-settings',

		'context' => 'side',

		'priority' => 'high',

		'fields' => array(

			'zp_audio_mp3_url' => array( 'label' => __( 'Audio .mp3 URL','novo'), 'type' => 'text', 'data-zp_desc' => __( 'The URL to the .mp3 audio file','novo') ),
			'zp_audio_ogg_url' => array( 'label' => __( 'Audio .ogg, .oga URL','novo'), 'type' => 'text', 'data-zp_desc' => __( 'The URL to the .oga, .ogg audio file','novo') ),
			'zp_audio_prieview_image_url' => array( 'label' => __( 'Preview Image','novo'), 'type' => 'text', 'data-zp_desc' => __( 'The preview image for this audio track','novo') ),
			'zp_audio_prieview_image_height' => array( 'label' => __( 'Preview Image Height','novo'), 'type' => 'text', 'data-zp_desc' => __( 'The height of the poster image. Example: 300','novo') )
		)

	) );

	$post_meta->add_meta_box( array(

		'id' => 'link-settings',

		'context' => 'side',

		'priority' => 'high',

		'fields' => array(
			'zp_link_format' => array( 'label' => __( 'Enter link.  E.g., http://www.yourlink.com','novo'), 'type' => 'text', 'data-zp_desc' => __( 'Input your link. e.g., http://www.yourlink.com','novo') )
		)

	) );

	$post_meta->add_meta_box( array(

		'id' => 'video-settings',

		'context' => 'side',

		'priority' => 'high',

		'fields' => array(
			'zp_video_m4v_url' => array( 'label' => __( 'Video File (.m4v)','novo'), 'type' => 'text', 'data-zp_desc' => __( 'The URL to the .m4v video file','novo') ),
			'zp_video_ogv_url' => array( 'label' => __( 'Video File (.ogv)','novo'), 'type' => 'text', 'data-zp_desc' => __( 'The URL to the .ogv video file','novo') ),
			'zp_video_prieview_image_height' => array( 'label' => __( 'Video Height','novo'), 'type' => 'text', 'data-zp_desc' => __( 'The video height (e.g. 500).','novo') ),
			'zp_video_prieview_image_url' => array( 'label' => __( 'Preview Image','novo'), 'type' => 'text', 'data-zp_desc' => __( 'The preview image for this video.','novo') ),
			'zp_video_format_embed' => array( 'label' => __( 'Embed Video','novo'), 'type' => 'textarea', 'data-zp_desc' => __( 'If you are using something other than self hosted video such as Youtube or Vimeo, paste the embed code here. Width is best at 600px with any height. This field will override the above.','novo') ),
		)

	) );			


}

add_action( 'after_setup_theme', 'zp_custom_post_type' );
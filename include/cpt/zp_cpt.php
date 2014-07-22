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
			'video_type_value' => array( 'label' => __( 'Video Type','initlanesis'), 'type' => 'select', 'options' => array('youtube' => 'Youtube','vimeo' => 'Vimeo') , 'data-zp_desc' => __( 'Select appropriate video type','initlanesis') ),
			'video_id_value' => array( 'label' => __( 'Video ID','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'Enter video ID. Example: VdvEdMMtNMY','initlanesis') ),
			'slider_button_value' => array( 'label' => __( 'Slide Button','initlanesis'), 'type' => 'text' , 'data-zp_desc' => __( 'Enter Button Name','initlanesis') ),
			'slider_link_value' => array( 'label' => __( 'Slide Link','initlanesis' ), 'type' => 'text' , 'data-zp_desc' => __( 'Put slide link here','initlanesis') ),
		)
	) );

	$slide->add_meta_box( array(
		'id' => 'slide-order',
		'context' => 'side',
		'fields' => array(
			'slide_number_value' => array( 'type' => 'text', 'data-zp_desc' => __( 'Define slide order. Ex. 1,2,3,4,...','initlanesis') ),
		)
	) );

	// manage slide columns
	function zp_add_slide_columns($columns) {
		return array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Title', 'initlanesis'),
			'slideshow' => __('Slideshow', 'initlanesis'),
			'slide_order' =>__( 'Slide Order', 'initlanesis'),
			'date' => __('Date', 'initlanesis'),
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
				_e( 'Unable to get author(s)', 'initlanesis' );
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

			'zp_project_label_value' => array( 'label' => __( 'Project Label','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'Define project label','initlanesis')  ),

			'zp_project_link_value' => array( 'label' => __( 'Project Link','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'Define project link','initlanesis')  ),

		)

	) );



	$portfolio->add_meta_box( array(

		'id' => 'portfolio-images',

		'context' => 'normal',

		'priority' => 'high',

		'fields' => array(

			'zp_image_1_value' => array( 'label' => __( 'Image 1','initlanesis'), 'type' => 'text' , 'data-zp_desc' => __( 'Place here the full image path','initlanesis' )),

			'zp_image_2_value' => array( 'label' => __( 'Image 2','initlanesis'), 'type' => 'text' , 'data-zp_desc' => __( 'Place here the full image path','initlanesis' ) ),

			'zp_image_3_value' => array( 'label' => __( 'Image 3','initlanesis'), 'type' => 'text' , 'data-zp_desc' => __( 'Place here the full image path','initlanesis' )),

			'zp_image_4_value' => array( 'label' => __( 'Image 4','initlanesis'), 'type' => 'text' , 'data-zp_desc' => __( 'Place here the full image path','initlanesis' )),

			'zp_image_5_value' => array( 'label' => __( 'Image 5','initlanesis'), 'type' => 'text' , 'data-zp_desc' => __( 'Place here the full image path','initlanesis' )),

		)

	) );



	$portfolio->add_meta_box( array(

		'id' => 'portfolio-videos',

		'context' => 'normal',

		'priority' => 'high',

		'fields' => array(

			'zp_video_url_value' => array( 'label' => __( 'Youtube or Vimeo URL','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'Place here the video url. Example video url: YOUTUBE: http://www.youtube.com/watch?v=Sv5iEK-IEzw and VIMEO: http://vimeo.com/7585127','initlanesis') ),

			'zp_video_embed_value' => array( 'label' => __( 'Embed Code','initlanesis'), 'type' => 'text' , 'data-zp_desc' => __( 'If you are using anything else other than YouTube or Vimeo, paste the embed code here. This field will override anything from the above.','initlanesis' )),


		)

	) );





	// manage portfolio columns

	function zp_add_portfolio_columns($columns) {

		return array(

			'cb' => '<input type="checkbox" />',

			'title' => __('Title', 'initlanesis'),

			'portfolio_category' => __('Portfolio Category', 'initlanesis'),

			'author' =>__( 'Author', 'initlanesis'),

			'date' => __('Date', 'initlanesis'),

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

				_e( 'Unable to get author(s)', 'initlanesis' );

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

			'zp_audio_mp3_url' => array( 'label' => __( 'Audio .mp3 URL','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'The URL to the .mp3 audio file','initlanesis') ),
			'zp_audio_ogg_url' => array( 'label' => __( 'Audio .ogg, .oga URL','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'The URL to the .oga, .ogg audio file','initlanesis') ),
			'zp_audio_prieview_image_url' => array( 'label' => __( 'Preview Image','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'The preview image for this audio track','initlanesis') ),
			'zp_audio_prieview_image_height' => array( 'label' => __( 'Preview Image Height','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'The height of the poster image. Example: 300','initlanesis') )
		)

	) );

	$post_meta->add_meta_box( array(

		'id' => 'link-settings',

		'context' => 'side',

		'priority' => 'high',

		'fields' => array(
			'zp_link_format' => array( 'label' => __( 'Enter link.  E.g., http://www.yourlink.com','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'Input your link. e.g., http://www.yourlink.com','initlanesis') )
		)

	) );

	$post_meta->add_meta_box( array(

		'id' => 'video-settings',

		'context' => 'side',

		'priority' => 'high',

		'fields' => array(
			'zp_video_m4v_url' => array( 'label' => __( 'Video File (.m4v)','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'The URL to the .m4v video file','initlanesis') ),
			'zp_video_ogv_url' => array( 'label' => __( 'Video File (.ogv)','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'The URL to the .ogv video file','initlanesis') ),
			'zp_video_prieview_image_height' => array( 'label' => __( 'Video Height','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'The video height (e.g. 500).','initlanesis') ),
			'zp_video_prieview_image_url' => array( 'label' => __( 'Preview Image','initlanesis'), 'type' => 'text', 'data-zp_desc' => __( 'The preview image for this video.','initlanesis') ),
			'zp_video_format_embed' => array( 'label' => __( 'Embed Video','initlanesis'), 'type' => 'textarea', 'data-zp_desc' => __( 'If you are using something other than self hosted video such as Youtube or Vimeo, paste the embed code here. Width is best at 600px with any height. This field will override the above.','initlanesis') ),
		)

	) );


}

add_action( 'after_setup_theme', 'zp_custom_post_type' );
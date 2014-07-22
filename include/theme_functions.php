<?php
/** Additional Theme Functions */

/** Creates additional image sizes */
add_image_size( 'Feature', 70, 70, TRUE  );
add_image_size( 'Blog', 980 , 550, TRUE  );
add_image_size(  'latest_portfolio_widget', 70, 70, TRUE  );
add_image_size( '3col', 306, 240, TRUE  );
add_image_size( 'portfolio_single', 980, 737, TRUE  );


/**
 * Get portfolio items values ( width, height, columns and number of items )
 * @returns an array of values (width, height, column class) to be used in the template
*/

function zp_portfolio_items_values( $columns ){
	$values = array();
	if(  $columns == 2  )
	{
		$values['size'] = '2col';
		$values['class'] = '-2col';
	}

	if(  $columns == 3  )
	{
		$values['size'] = '3col';
		$values['class'] = '-3col';
	}

	if(  $columns == 4  )
	{
		$values['size'] = '4col';
		$values['class'] = '-4col';
	}

	return $values;

}

/**
 * Portfolio Category Filter function
 * @param boolean $filter - true/false
 * @returns html tag for portfolio category
*/

function zp_portfolio_category_filter(  ){

	$output = '';
		$output .= '<div id="options" class="clearfix">';
		$output .=  '<ul id="portfolio-categories" class="option-set" data-option-key="filter"><li><a href="#" data-option-value="*" class="selected">'.__( 'show all', 'initlanesis').'</a></li>';

		$categories = get_categories( array( 'taxonomy' => 'portfolio_category' ) );
			foreach( $categories as $category ) :
			$tms=str_replace( " ","-",$category->name );
			$output .=  '<li><a href="#" data-option-value=".'.$category->slug.'">'.$category->name.'</a></li>';
			endforeach;

		$output .=  '</ul></div>';

	return $output;
}


/**
 * Get the terms where the portfolio items belong and use as a class
 * Terms was used as a selector on the isotope fitler
 * @param integer $id - ID of the post
 * @returns string - list of terms separated by space
*/

function zp_portfolio_items_term( $id ){

	$output = '';

	$terms = wp_get_post_terms( $id, 'portfolio_category' );
	$term_string = '';
		foreach( $terms as $term ){
			$term_string.=( $term->slug ).',';
		}
	$term_string = substr( $term_string, 0, strlen( $term_string )-1 );

	/** separate terms with space*/
	$string = str_replace( ","," ",$term_string );
	$output = $string." ";

	return $output;

}

/**
 * Displays Portfolio Items in different column layout
 *
 * It accepts values from a portfolio templates
 *
 * @param integer $columns - Number of Columns
 * @param integer $num_items - Number of items to display
 * @param boolean $type - gallery/portfolio
 *
*/

function zp_portfolio_template(  $num_items, $type ){
	global $post, $paged, $wp_query;

	/** Enqueue necessary scripts */
	wp_enqueue_script(  'modernizr_custom'  );
	wp_enqueue_script(  'classie'  );
	wp_enqueue_script(  'thumbnailGridEffects'  );
	wp_enqueue_script(  'jquery_prettyphoto_js'  );

	/** get appropriate columns, image height and image width*/
	$_values = zp_portfolio_items_values( 3 );

	/* creates portfolio items list */
	zp_portfolio_list(  $num_items, $type );

	/** determines if it will be a portfolio layout or gallery layout*/
	$class = ( $type == 'portfolio' ) ? 'element' : 'gallery';


	$html='';
	$nav_button = '';


		if( is_tax('portfolio_category')){

		$term =	$wp_query->queried_object;

			$args= array(
					'posts_per_page' =>$num_items,
					'post_type' => 'portfolio',
					'paged' => $paged,
					'portfolio_category' => $term->slug
				 );

				query_posts( $args );

		}else{


				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

				$args= array(

					'posts_per_page' =>$num_items,

					'post_type' => 'portfolio',

					'paged' => $paged,
				 );
		query_posts( $args );

		}

	printf( '<article %s>', genesis_attr( 'entry' ) );
	?>
    <section class="zp-grid-wrapper">
				<div class="zp-grid <?php echo zp_portfolio_style_effects( genesis_get_option( 'zp_portfolio_animation' , ZP_SETTINGS_FIELD ) ); ?>">

	<?php
	if(  have_posts( ) ) {
 		while (  have_posts(  )  ) {
			the_post(  );

			$t=get_the_title(  );
			$permalink=get_permalink(  );

			$content = get_the_content_limit( 50, '' );

			$thumbnail = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
			$video_url = get_post_meta( $post->ID, 'zp_video_url_value', true);

			if(  $type == 'portfolio'  ){
				$link = $permalink;
				$rel = '';
			}else{
				if( $video_url != '' ){
					$link = zp_video_preg_match( $video_url );
					$rel = 'rel="prettyPhoto[pp_gal]"';
				}else{
					$link = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
					$rel = 'rel="prettyPhoto[pp_gal]"';
				}
			}


			/** generate the final item HTML */
			$html.= '<div class="element '.$class.''.$_values['class'].' "><a href="'.$link.'" title="'.$t.'" '.$rel.'><span class="portfolio_overlay"><h4 class="portfolio_title">'.$t.'</h4></span>'.get_the_post_thumbnail( $post->ID, $_values['size'] , array('alt' => $t) ).'</a></div>';


		}
	}
			echo $html;
		?>
        </div>
        <nav class="zp_portfolio_nav">
      		<?php
			$i=0;
			if( zp_get_portfolio_pages( $num_items ) > 1)
			while( $i < zp_get_portfolio_pages( $num_items ) ){
				if($i == 0){
					$nav_button .= '<a class="zp-current"></a>';
				}else{
					$nav_button .= '<a></a>';
				}
				$i++;
			}

			echo $nav_button;

			?>
        </nav>
       </section>

<?php
	echo '</article>';

wp_reset_query(  );

}

/**
 * Portfolio Style Effects
 */

function zp_portfolio_style_effects( $style ){

	$class= '';

	switch( $style  ){
		case 'fall':		$class = 'zp-effect-fall zp-effect-delay';
							break;
		case 'slide':		$class = 'zp-effect-slide';
							break;
		case 'rotate_fall':	$class = 'zp-stacking-inversed zp-effect-fallrotate zp-effect-delay-reversed';
							break;
		case 'rotate_scale':$class = 'zp-effect-scalerotate zp-effect-delay';
							break;
		case 'stack':		$class = ' zp-effect-stackback zp-effect-delay';
							break;
		case '3D_flip':		$class = 'zp-effect-3dflip zp-effect-delay';
							break;
		case 'bring_back':	$class = 'zp-effect-bringback zp-effect-delay';
							break;
		case 'superscale':	$class = 'zp-effect-superscale zp-effect-delay';
							break;
		case 'center_flip':	$class = 'zp-effect-flip zp-effect-delay';
							break;
		case 'front_row':	$class = 'zp-effect-frontrow zp-effect-delay';
							break;
	}

	return $class;

 }

/**
 * Get number of Portfolio Pages
 * @param integer $items_per_page
 */

function zp_get_portfolio_pages( $items_per_page ){

	$num_pages = 0;

	$list_items = zp_get_portfolio_items();

	// check if there is a remainder
	$r = $list_items % $items_per_page;

	if( $r == 0 ){
		$num_pages = $list_items / $items_per_page;
	}else{
		$num_pages = ($list_items / $items_per_page) +  1;
	}

	return floor($num_pages);
}



/**
 * Get number of Portfolio Items
 */

function zp_get_portfolio_items( ){
	global $post, $wp_query;

	$counter = 0;

	if( is_tax('portfolio_category')){

	$term =	$wp_query->queried_object;

		$args= array(
				'posts_per_page' =>-1,
				'post_type' => 'portfolio',
				'portfolio_category' => $term->slug
			 );

			query_posts( $args );

	}else{
		$args= array(
			'posts_per_page' =>-1,
			'post_type' => 'portfolio'
		 );
		query_posts( $args );
	}
	if(  have_posts( ) ) {
 		while (  have_posts(  )  ) {
			the_post(  );
				$counter++;
		}
	}

wp_reset_query(  );

	return $counter;

}


/**
 * Display items in each page
 * @param $items - items per page
 */

function zp_display_portfolio_items(  $items , $type ){
	global $post,$wp_query;

	/** get appropriate columns, image height and image width*/
	$_values = zp_portfolio_items_values( 3 );
	$num_pages = zp_get_portfolio_pages( $items  );

	$flag = 0;
	$p_num =  zp_get_portfolio_items();
	$output = '';
	$p_array = array();
	$final = array();

	if( is_tax('portfolio_category')){

	$term =	$wp_query->queried_object;
		$args= array(
				'posts_per_page' =>  -1,
				'post_type' => 'portfolio',
				'portfolio_category' => $term->slug
			 );
			query_posts( $args );


	}else{

		$args= array(
			'posts_per_page' =>-1,
			'post_type' => 'portfolio'
		 );
		 query_posts( $args );
	}



	if(  have_posts( ) ) {
 		while (  have_posts(  )  ) {
			the_post(  );
			$flag++;
			$permalink = get_permalink(  );
			$t = get_the_title(  );

			$img = wp_get_attachment_image_src( get_post_thumbnail_id(  $post->ID  ), $_values['size']);
			$video_url = get_post_meta( $post->ID, 'zp_video_url_value', true);

			if(  $type == 'portfolio'  ){
				$link = $permalink;
			}else{
				if( $video_url != '' ){
					$link = zp_video_preg_match( $video_url );
					$rel = 'rel="prettyPhoto[pp_gal]"';
				}else{
					$link = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
					$rel = 'rel="prettyPhoto[pp_gal]"';
				}
			}

			array_push($p_array, array( 'title' => $t,'img'=>$img[0], 'link' => $link ));
			$p_num--;

			if( ($flag == $items) ){
				array_push($final , $p_array );
				$p_array = array();
				$flag=0;
			}else if( ($flag != $items) && ($p_num == 0 ) ){
				array_push($final , $p_array );
				$p_array = array();
				$flag=0;
			}
		}
	}
	wp_reset_query(  );

	$obj = json_decode (json_encode ($final), FALSE);
	return $obj;
}

/**
 * Creates Script List for portfolio items.
 */

function zp_portfolio_list(  $items , $type){

	$output = '';
	$flag1 = 0;
	$p_num =  zp_get_portfolio_items( );
	$flag2 = 0;
	$counter = 0;

	//retrieve all the items
	$item_list = zp_display_portfolio_items( $items , $type );

	// check if is is portfolio / gallery page
	if(  $type == 'portfolio'  ){
		$rel = '';
	}else{
		$rel = 'rel="prettyPhoto[pp_gal]"';
	}

	foreach( $item_list as  $list ){
		$counter++;
		$output .= 'page'.$counter.' : [';
			foreach( $list as $list2){
						$output .= '\'<a href="'.$list2->link.'" title="'.$list2->title.'" '.$rel.'><span class="portfolio_overlay"><h4 class="portfolio_title">'.$list2->title.'</h4></span><img src="'.$list2->img.'" class="" alt="'.$list2->title.'"></a>\'';
						if( ($flag1 < $items-1) && ($p_num != 1) ){
							$output .= ',';
							$flag1++;
						}else{
							$output .= '';
							$flag1=0;
						}
						$p_num--;

			}
		$output .= ']';
		if( $flag2 < zp_get_portfolio_pages( $items )- 1 ){
			$output .= ',';
			$flag2++;
		}else{
			$output .= '';
			$flag=0;
		}
	}
?>
        <script>
		 /* <![CDATA[ */
			var allImages = { <?php echo $output; ?>};
		/* ]]> */
        </script>

<?php

}

/**
 * Displays the related portfolio in the single portfolio page.
 */
function zp_related_portfolio(){
global $post;

	$terms = get_the_terms( $post->ID , 'portfolio_category' );
	$term_ids = array_values( wp_list_pluck( $terms,'term_id' ) );

	$related_columns = genesis_get_option( 'zp_related_portfolio_columns', ZP_SETTINGS_FIELD );


	$args=array(
     'post_type' => 'portfolio',
     'tax_query' => array(
                    array(
                        'taxonomy' => 'portfolio_category',
                        'field' => 'id',
                        'terms' => $term_ids,
                        'operator'=> 'IN'
                     )),
      'posts_per_page' => 3,
      'orderby' => 'rand',
      'post__not_in'=>array( $post->ID )
	);

	query_posts( $args );
?>
    <div class = "related_portfolio">
        <div class="section-title"> <h4><?php echo genesis_get_option( 'zp_related_portfolio_title' , ZP_SETTINGS_FIELD ); ?></h4></div>
    </div>
   <div class="related_container ">

      <?php
	  	  if( have_posts() ) {

		   while ( have_posts() ) {
			  the_post();
				$t = get_the_title();
				$content = get_the_content_limit( 50, '' );
				$permalink=get_permalink();
				$thumbnail= wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

				?>
				<div class="element element-3col <?php echo zp_portfolio_items_term( $post->ID ); ?>">
         			<a href="<?php echo $permalink; ?>" title="<?php echo $t; ?>">
                	<span class="portfolio_overlay">
                    	<h4 class="portfolio_title"><?php echo $t; ?></h4>
                    </span> <?php echo get_the_post_thumbnail( $post->ID, '3col' ); ?>
                 </a>

                </div>


		   <?php
		   	}
		  }else{
				_e('No related projects.', 'initlanesis' );
		  }


		 wp_reset_query(  );
	  ?>

	</div>

<?php }

/**
 * Matches the input video link inserted.
 * @param string $link - Video Link
*/

function zp_video_preg_match( $link ){
	$src = '';

	if( preg_match( '/youtube/', $link ) )
	{
		if( preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i', $link, $matches ) )
		{
			$src = "http://www.youtube.com/watch?v=".$matches[4][0];
		}
	}
	elseif( preg_match( '/vimeo/', $link ) )
	{
		if( preg_match('/^http:\/\/(www\.)?vimeo\.com\/(clip\:)?(\d+).*$/', $link, $matches ) )
		{
			$src = "http://vimeo.com/".$matches[3];
		}
	}
	return $src;
}

/**
 * Displays Portfolio Shortcode in different column layout
 *
 * It accepts values from a portfolio shortcode
 *
 * @param integer $num_items - Number of items to display
 * @param boolean $filter - display filter true/false
 * @param string $pagination - display pagination true/false
 *
*/

function zp_portfolio_shortcode( $num_items, $type, $effect ){

	global $post, $paged, $wp_query;

	/** Enqueue necessary scripts */
	wp_enqueue_script(  'modernizr_custom'  );
	wp_enqueue_script(  'classie'  );
	wp_enqueue_script(  'thumbnailGridEffects'  );
	wp_enqueue_script(  'jquery_prettyphoto_js'  );

	/** get appropriate columns, image height and image width*/
	$_values = zp_portfolio_items_values( 3 );

	/* creates portfolio items list */
	zp_portfolio_list( $num_items, $type );

	/** determines if it will be a portfolio layout or gallery layout*/
	$class = ( $type == 'portfolio' ) ? 'element' : 'gallery';


	$html='';
	$nav_button = '';
	$output = '';


		if( is_tax('portfolio_category')){

		$term =	$wp_query->queried_object;

			$args= array(
					'posts_per_page' =>$num_items,
					'post_type' => 'portfolio',
					'paged' => $paged,
					'portfolio_category' => $term->slug
				 );

				query_posts( $args );

		}else{


				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

				$args= array(

					'posts_per_page' =>$num_items,

					'post_type' => 'portfolio',

					'paged' => $paged,
				 );
		query_posts( $args );

		}

	$output .= '<div class="portfolio_shortcode">';
	$output .= '<section class="zp-grid-wrapper">';
	$output .= '<div class="zp-grid '.zp_portfolio_style_effects( $effect ).'">';

	if(  have_posts( ) ) {
 		while (  have_posts(  )  ) {
			the_post(  );

			$t=get_the_title(  );
			$permalink=get_permalink(  );

			$content = get_the_content_limit( 50, '' );

				$content = get_the_content_limit( 50, '' );

			$thumbnail = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
			$video_url = get_post_meta( $post->ID, 'zp_video_url_value', true);

			if(  $type == 'portfolio'  ){
				$link = $permalink;
				$rel = '';
			}else{
				if( $video_url != '' ){
					$link = zp_video_preg_match( $video_url );
					$rel = 'rel="prettyPhoto[pp_gal]"';
				}else{
					$link = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
					$rel = 'rel="prettyPhoto[pp_gal]"';
				}
			}


			/** generate the final item HTML */
			$html.= '<div class="element '.$class.''.$_values['class'].' "><a href="'.$link.'" title="'.$t.'" '.$rel.'><span class="portfolio_overlay"><span class="portfolio_title">'.$t.'</span></span>'.get_the_post_thumbnail( $post->ID, $_values['size'] , array('alt' => $t) ).'</a></div>';


		}
	}
			$output .= $html;
	        $output .= '</div><nav class="zp_portfolio_nav">';
			$i=0;
			while( $i < zp_get_portfolio_pages( $num_items ) ){
				if($i == 0){
					$nav_button .= '<a class="zp-current"></a>';
				}else{
					$nav_button .= '<a></a>';
				}
				$i++;
			}

			$output .=  $nav_button;

	$output .= '</nav></section>';

	$output .= '</div>';

wp_reset_query(  );

return $output;

}


/**
 * Displays All attached image in the post
 *
 * Used in single portfolio page
 *
 * @parent integer - ID of the parent post
 * @gal integer  - gallery name in prettyphoto
 * @feature string - image used as feature (use to avoid image duplicate)

 *
*/

function zp_show_all_attached_image($parent, $gal, $feature) {
    global $post;
	$args = array(
		'numberposts'     => -1,
		'offset'          => 0,
		'category'        => '',
		'orderby'         => 'post_date',
		'order'           => 'DESC',
		'post_type'       => 'portfolio',
		'post_mime_type'  => '',
		'post_parent'     => $parent,
		'post_status'     => 'publish',
		'suppress_filters' => true );
    $post = get_post($args);

$thumblist ='';
$images = get_children( 'post_type=attachment&post_mime_type=image&output=ARRAY_N&orderby=menu_order&order=ASC&post_parent='.$parent);
	if($images){
		foreach( $images as $imageID => $imagePost ){

		unset($the_b_img);
		$the_b_img = wp_get_attachment_image($imageID, 'thumbnail', false);
		$image_attributes = wp_get_attachment_image_src( $imageID , 'large');

			if( $image_attributes[0] != $feature ){
				$final_img = $image_attributes[0];
				$thumblist .= '<a href="'.$final_img.'" rel="prettyPhoto['.$gal.']" >'.$the_b_img.'</a>';
			}
		}
	}

wp_reset_query();

return $thumblist;


}

/**
 * Displays All Post
 * Used in shortcode
 * @blog_cloumns integer - number of columns
 * @blog_items integer  - number of items
 * @blog_cat string - post category to be displayed (uses the category slud)

 *
*/

function zp_post_shortcode( $blog_cloumns, $blog_items, $blog_cat  ) {
	global $post;

	/** get appropriate columns, image height and image width*/
	$_values = zp_portfolio_items_values( $blog_cloumns );

	$args = array( 'post_type' => 'post', 'posts_per_page'=> $blog_items , 'category_name' => $blog_cat);
	query_posts($args);

    $output = '';
	$html='';

	$output .= ' <div  class="blog_feature_shortcode">';
	$output .= '<ul class="blog_slides">';

	if(have_posts()) {

		 while (have_posts()) {

			the_post();

            $description = get_the_content_limit( 150, '' );
			$Old     = array( '<p>', '</p>' );
			$description = str_replace( $Old ,'', $description );
            $thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

			$html .= '<li class="element'.$_values['class'].'">';
			$html .= '<div class="home_blog_feature">';
			$html .= '<div class="blog_feature_image">';
			$html .= '<a href="'.get_permalink().'">';
			$html .= get_the_post_thumbnail( $post->ID, $_values['size'] );
			$html .= '<div class="blog_feature_content"><h3><a href="'. get_permalink().'">'.get_the_title().'</a></h3>';

            if( genesis_get_option( 'zp_home_blog_itemdesc', ZP_SETTINGS_FIELD )) {
                $html .= '<p><span class="home-blog-post-meta">'.get_the_date( 'F j, Y' ).'</span>';
                $html .= '<span class="post_box_comments">';
                $html .= '<a href="'. get_comments_link( $post->ID ).'">'.zp_custom_comment_number().'</a>';
                $html .= '</span></p>';
                $html .= '<p>'.$description.'[...]</p>';
                 }
              $html .= '</div></div></li>';
                    }
            }
			wp_reset_query();

			$output .= $html;

            $output .= '</ul>';

      		$output .= '</div>';

   return $output;

}


/**
 * Return Comment Number
 *
*/

function zp_custom_comment_number(  ){
	global $post;
		$num_comments = get_comments_number();

		if ( $num_comments == 0 ) {
			$comments = __('No Comments', 'initlanesis');
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __(' Comments','initlanesis' );
		} else {
			$comments = __('1 Comment','initlanesis' );
		}

	return $comments;
}

/**
 *  Output gallery slideshow
 *
 *  @param int $postid the post id
 *  @param int/string $imagesize the image size
*/

if ( !function_exists( 'zp_gallery' ) ) {
    function zp_gallery($postid, $imagesize, $slideshow = false, $thumbs = false) {

        ?>
            <script type="text/javascript">
			jQuery.noConflict();
        		jQuery(document).ready(function($){
                        $("#slider-<?php echo $postid; ?>").flexslider({
							autoplay:false,
        				    slideshow: true,
                            controlNav: false,
							directionNav: true,
                            smoothHeight: true,
							animationLoop: true
                        });
        		});
        	</script>
        <?php

        // get all of the attachments for the post
        $args = array(
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_type' => 'attachment',
            'post_parent' => $postid,
            'post_mime_type' => 'image',
            'post_status' => null,
            'numberposts' => -1
        );
        $attachments = get_posts($args);
        if( !empty($attachments) ) {
            echo "<div class='post_slider flexslider' id='slider-$postid'>";
            echo '<ul class="slides">';

            foreach( $attachments as $attachment ) {
                $src = wp_get_attachment_image_src( $attachment->ID, $imagesize );
                $caption = $attachment->post_excerpt;
                $caption = ($caption) ? "<div class='slide-caption'>$caption</div>" : '';
                $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
                echo "<li><div>$caption<img height='$src[2]' width='$src[1]' src='$src[0]' alt='$alt' /></div></li>";
            }

            echo '</ul>';
            echo "</div>";

        }
    }
}

/**
 *	Output Audio
 *
 *  @param int $postid the post id
 *  @param int $width the width of the audio player
*/

if ( !function_exists( 'zp_audio' ) ) {
    function zp_audio($postid, $width = 640, $height = 440) {


		// enqueue needed scripts
		wp_enqueue_script('jquery_jplayer');

    	$mp3 = get_post_meta( $postid, 'zp_audio_mp3_url', true);
    	$ogg = get_post_meta( $postid, 'zp_audio_ogg_url', true);
    	$poster = get_post_meta( $postid, 'zp_audio_prieview_image_url', true);
    	$height = get_post_meta( $postid, 'zp_audio_prieview_image_height', true);
    ?>
    		<script type="text/javascript">

    			jQuery(document).ready(function($){

    				if( $().jPlayer ) {
    					$("#jquery-jplayer-audio-<?php echo $postid; ?>").jPlayer({
    						ready: function () {
    							$(this).jPlayer("setMedia", {
    							    <?php if($poster != '') : ?>
    							    poster: "<?php echo $poster; ?>",
    							    <?php endif; ?>
    							    <?php if($mp3 != '') : ?>
    								mp3: "<?php echo $mp3; ?>",
    								<?php endif; ?>
    								<?php if($ogg != '') : ?>
    								oga: "<?php echo $ogg; ?>",
    								<?php endif; ?>
    								end: ""
    							});
    						},
    						<?php if( !empty($poster) ) { ?>
    						size: {
            				    width: "<?php echo $width; ?>px",
            				    height: "<?php echo $height . 'px'; ?>"
            				},
            				<?php } ?>
    						swfPath: "<?php echo get_stylesheet_directory_uri(); ?>/js",
    						cssSelectorAncestor: "#jp-audio-interface-<?php echo $postid; ?>",
    						supplied: "<?php if($ogg != '') : ?>oga,<?php endif; ?><?php if($mp3 != '') : ?>mp3<?php endif; ?>"
    					});

    				}
    			});
    		</script>

    	    <div id="jp-container-<?php echo $postid; ?>" class="jp-audio">
                <div class="jp-type-single">
                    <div id="jquery-jplayer-audio-<?php echo $postid; ?>" class="jp-jplayer" data-orig-width="<?php echo $width; ?>" data-orig-height="<?php echo $height; ?>"></div>
                    <div id="jp-audio-interface-<?php echo $postid; ?>" class="jp-interface">
                        <ul class="jp-controls">
                            <li><a href="#" class="jp-play" tabindex="1" title="play">play</a></li>
                            <li><a href="#" class="jp-pause" tabindex="1" title="pause">pause</a></li>
                            <li><a href="#" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                            <li><a href="#" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                        </ul>
                        <div class="jp-progress">
                            <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                            </div>
                        </div>
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                    </div>
                </div>
            </div>
    	<?php
    }
}

/**
 *  Output video
 *
 *  @param int $postid the post id
 *  @param int $width the width of the video player
 */

if ( !function_exists( 'zp_video' ) ) {
    function zp_video($postid, $width = 640, $height = 380) {


		// enqueue needed scripts
		wp_enqueue_script('jquery_jplayer');

    	$height = get_post_meta( $postid, 'zp_video_prieview_image_height', true);
    	$m4v = get_post_meta( $postid, 'zp_video_m4v_url', true);
    	$ogv = get_post_meta( $postid, 'zp_video_ogv_url', true);
    	$poster = get_post_meta( $postid, 'zp_video_prieview_image_url', true);

    ?>
    <script type="text/javascript">
    	jQuery(document).ready(function($){

    		if( $().jPlayer ) {
    			$("#jquery-jplayer-video-<?php echo $postid; ?>").jPlayer({
    				ready: function () {
    					$(this).jPlayer("setMedia", {
    						<?php if($m4v != '') : ?>
    						m4v: "<?php echo $m4v; ?>",
    						<?php endif; ?>
    						<?php if($ogv != '') : ?>
    						ogv: "<?php echo $ogv; ?>",
    						<?php endif; ?>
    						<?php if ($poster != '') : ?>
    						poster: "<?php echo $poster; ?>"
    						<?php endif; ?>
    					});
    				},
    				size: {
                        cssClass: "jp-video-normal",
    				    width: "100%",
    				    height: "<?php echo $height . 'px'; ?>"
    				},
    				swfPath: "<?php echo get_stylesheet_directory_uri(); ?>/js",
    				cssSelectorAncestor: "#jp-video-container-<?php echo $postid; ?>",
    				supplied: "<?php if($m4v != '') : ?>m4v, <?php endif; ?><?php if($ogv != '') : ?>ogv<?php endif; ?>"
    			});

                $('#jquery-jplayer-video-<?php echo $postid; ?>').bind($.jPlayer.event.playing, function(event) {
                    $(this).add('#jp-video-interface-<?php echo $postid; ?>').hover( function() {
                        $('#jp-video-interface-<?php echo $postid; ?>').stop().animate({ opacity: 1 }, 400);
                    }, function() {
                        $('#jp-video-interface-<?php echo $postid; ?>').stop().animate({ opacity: 0 }, 400);
                    });
                });

                $('#jquery-jplayer-video-<?php echo $postid; ?>').bind($.jPlayer.event.pause, function(event) {
                    $('#jquery-jplayer-video-<?php echo $postid; ?>').add('#jp-video-interface-<?php echo $postid; ?>').unbind('hover');
                    $('#jp-video-interface-<?php echo $postid; ?>').stop().animate({ opacity: 1 }, 400);
                });
    		}

    	});
    </script>

    <div id="jp-video-container-<?php echo $postid; ?>" class="jp-video jp-video-normal">
        <div class="jp-type-single">
            <div id="jquery-jplayer-video-<?php echo $postid; ?>" class="jp-jplayer" data-orig-width="<?php echo $width; ?>" data-orig-height="<?php echo $height; ?>"></div>
            <div class="jp-gui">
            <div id="jp-video-interface-<?php echo $postid; ?>" class="jp-interface">
                <ul class="jp-controls">
                    <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                    <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                    <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                    <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                </ul>
                <div class="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                    </div>
                </div>
                <div class="jp-volume-bar">
                    <div class="jp-volume-bar-value"></div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <?php }
}

/*
 * Add like functions for the posts
 */

add_action('wp_ajax_zp_insert_likes', 'zp_insert_likes');
add_action('wp_ajax_nopriv_zp_insert_likes', 'zp_insert_likes');

function zp_insert_likes()
{
	$post_id = $_POST["post_id"];
	zp_add_like($post_id);
	echo get_post_meta($post_id,'zp_like',true);
	die();
}


function zp_add_like($post_id)
{
    $likes = get_post_meta($post_id,'zp_like',true);
    $likes = $likes + 1;
    update_post_meta($post_id,'zp_like',$likes);
}

add_action('publish_post', 'zp_add_custom_likes');
function zp_add_custom_likes($post_id)
{
	global $post;
	setup_postdata( $post );


		add_post_meta($post_id, 'zp_like', 0, true);

return true;
}

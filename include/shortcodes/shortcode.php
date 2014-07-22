<?php
/**
*
* This file contains all the shortcodes and 
* TinyMCE formatting buttons functionality.
*
*/

/**
*	Post Like Shortcode
*/

function zp_post_like( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'text' => __( 'Like this post', 'novo' ),
	 ), $atts ) );
	 global $post;
	$likes = get_post_meta($post->ID,'zp_like',true);
	$like = ( $likes ) ? $likes: '0';	
	
	$output = '<span class="post_like"><span class="likes text-right '.$post->ID.'"><span class="icon-heart '.$post->ID.'">R</span><span class= "textLike">'.$text.'</span><span class="likes_value"><em>( '.$like.')</em></span></span></span>';	
	return  $output;
}

add_shortcode( 'post_like', 'zp_post_like' );

/**
*	Tab Shortcode
*/

function zp_show_tabs( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'titles' => '',
	 ), $atts ) );

	$titlearr=explode( ',',$titles );
	$output='<div class="tabs-container"><ul class="tabs ">';
	foreach( $titlearr as $title ){
		$output.='<li class="w3"><a href="#">'.$title.'</a></li>';
	}
	
	$output.='</ul><div class="panes">'.do_shortcode( $content ).'</div></div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
	
}

add_shortcode( 'tabs', 'zp_show_tabs' );

function zp_show_pane( $atts, $content = null ) {
	return '<div>'.do_shortcode( $content ).'</div>';
}

add_shortcode( 'pane', 'zp_show_pane' );

/**
*	Toggle Shortcode
*
*/
function zp_toggle(  $atts, $content = null  ){
	extract(  shortcode_atts(  array(
		'title'=> ''
	), $atts ) );
	
	$output = '';
	$output .= '<div class="toggle-unit clearfix">';
	
	if(  $title  ) {
		$output .= '<h4>' . $title . '</h4>';
	}
	
	$output .= do_shortcode(  $content  ) ;
	
	$output .= '</div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}

add_shortcode(  'toggle', 'zp_toggle'  );

// Toggle Item Shortcode
function zp_toggleitem(  $atts, $content = null  ){
	extract(  shortcode_atts(  array(
		'title'=> ''
	), $atts ) );
	
	$output = '<div class="toggle-wrap">';
	$output .= '<span class="trigger"><span class="toogle_image"></span><a href="#">' . $title . '</a></span>';
	$output .= '<div class="toggle-container">';
	$output .= do_shortcode (  $content  ) ;
	$output .= '</div></div>';
	
	return $output;
}

add_shortcode(  'toggleitem', 'zp_toggleitem'  );

/**
*	Accordion Shortcode
*/

function zp_accordion(  $atts, $content = null  ){
	extract(  shortcode_atts(  array(
		'title'=> ''
	), $atts ) );
	
	$output = '<div class="accordion-unit clearfix">';
	
	if (  $title  ) {
		$output .= '<h4>' . $title . '</h4>';
	}
	
	$output .= do_shortcode (  $content  );
	$output .= '</div>';
	
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}

add_shortcode(  'accordion', 'zp_accordion'  );

// Accordion Item Shortcode
function zp_accordionitem(  $atts, $content = null  ){
	extract(  shortcode_atts(  array(
		'title'=> ''
	), $atts ) );
	
	$output = '<div class="accordion_container"><span class="trigger-button"><span class="accordion_image"></span><span>' . $title . '</span></span>';
	$output .= '<div class="accordion">';
	
	$output .= do_shortcode (  $content  ) ;
	$output .= '</div></div>';
	
	return $output;
}

add_shortcode(  'accordionitem', 'zp_accordionitem'  );

/**
*	Service Box Shortcode
*/

function zp_servicebox(  $atts, $content = null  ){
	extract(  shortcode_atts(  array(
		'size' => '',
		'last'=> '',
		'title'=> '',
		'icon' => '',
		'name' => '',
		'link' => '',
		'btnsize' => '',
		'rounded' => '',
		'color' => '',
	), $atts ) );
	
	if(  $last == 'true' ) {
		$last_str = " last-column";
		$clear = '<div class="clearfix"></div>';
	}else{
		$last_str="";
		$clear = '';
	}
	
	if( $color == 'grey')
		$color = '';
		
	if( $rounded == 'false')
		$rounded = '';
	else 
		$rounded = 'rounded';
		
	$btn='';
	
	if( $name != ''){
		$btn = '<p><a href="'. $link . '" class=" button ' .$rounded .' '. $btnsize .'-btn '. $color . '" >' .   $name. '</a></p>';
	}
	
	$output ='';
	$output .= '<div class="'.$size.' special-services-box'. $last_str .'">';
	$output .= '<div class="box-wrapper"><div class="zp-icon-effect" ><a href="'.$link.'" class="zp-icon">'.$icon.'</a></div>';
	$output .= '<h4>'. $title . '</h4>';
	$output .= '<p>'. do_shortcode( $content  ). '</p>'.$btn.'</div></div>' ;
	
	$Old     = array( '<br />', '<br>');
	$New     = array( '','');
	$output = str_replace( $Old, $New, $output );

	return $output.$clear;
}

add_shortcode(  'servicebox', 'zp_servicebox'  );


function zp_servicebox_container(  $atts, $content = null  ){
	extract(  shortcode_atts(  array(
	), $atts ) );

	return '<div class="special-services-container">'.do_shortcode( $content  ).'</div>';

}
add_shortcode(  'servicebox_wrapper', 'zp_servicebox_container'  );
/**
*	Button Shortcode
*/

function zp_buttons_shortcode(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'size' => '',
		'color' => '',
		'link' => '',
		'rounded' => ''
	), $atts ) );
	
	$output = '';
	
	if( $color == 'default' )
		$color = '';
	
	if (  $size == 'small'  ) {
		$size = 'small-btn ';
	}elseif (  $size == 'normal'  ) {
		$size = '';
	}elseif(  $size == 'large'  ) {
		$size = 'large-btn ';
	}else {
		$size = '';
	}
	
	if (  $rounded == 'true'  ){
		$rounded = 'rounded ';
	}
	
	$output .= '<a href="'. $link . '" class=" button ' .$rounded .' '. $size . $color . '" >' . do_shortcode (  $content  ) . '</a>';
	
	return $output;
}

add_shortcode(  'button', 'zp_buttons_shortcode'  );

/**
*	Team Shortcode
*/

function zp_team(  $atts, $content = null  ){
	extract(  shortcode_atts(  array(
		'size' => '',
		'last'=> '',
		'name'=> '',
		'title'=> '',
		'icon' => '',
		'facebook' => '',
		'twitter' => '',
		'skype' => '',
		'youtube' => '',
		'linkedin' => '',
		'gmail' => ''
	), $atts ) );
	
	if(  $last == 'true' ) {
		$last_str = " last-column";
		$clear = '<div class="clearfix"></div>';
	}else {
		$last_str="";
		$clear = '';
	}
	
	$team_link='';
	
	if(  $facebook != ''  )
		$team_link .= '<a class="t_facebook hastip" title="facebook" href="'.$facebook.'">F</a>';
	if(  $twitter != ''  )
		$team_link .= '<a class="t_twitter hastip" title="twitter" href="'.$twitter.'">L</a>';
	if(  $gmail != ''  )
		$team_link .= '<a class="t_gmail hastip" title="email" href="mailto:'.$gmail.'">G</a>';
	if(  $skype != ''  )
		$team_link .= '<a class="t_skype hastip" title="skype" href="'.$skype.'">H</a>';
	if(  $youtube != ''  )
		$team_link .= '<a class="t_youtube hastip" title="youtube" href="'.$youtube.'">X</a>';
	if(  $linkedin != ''  )
		$team_link .= '<a class="t_linkedin hastip" title="linkedin" href="'.$linkedin.'">I</a>';		
		
	$output ='';
	$output .= '<div class="'.$size.' team'. $last_str .'">';
	$output .= '<div class="box-wrapper">';
	$output .= '<div class="team_image_block">';
	$output .= '<img src="'.$icon.'"  alt="" /></div>';
	$output .= '<h4>'. $name . '</h4><h5>'. $title . '</h5><p>'. $content . '</p>';
	$output .= '<span class="team_socials">'. $team_link . '</span></div></div>';
	
	return $output.$clear;

}
add_shortcode(  'team', 'zp_team'  );


function zp_team_container(  $atts, $content = null  ){
	extract(  shortcode_atts(  array(
	), $atts ) );

	return '<div class="team-container">'.do_shortcode( $content  ).'</div>';

}
add_shortcode(  'team_wrapper', 'zp_team_container'  );


/**
*	Slider Shortcode
*/

function zp_slider(  $atts, $content = null  ){
	extract(  shortcode_atts(  array(
		'name' => '',
		'height'=> '',
		'width'=> '',
		'slideshow'=> '',
		'animation' => '',
		'caption' => '',
		'directionnav' => '',
		'controlnav' => '',
		'order' => '',
	), $atts ) );
	
	global $post;
	
	wp_enqueue_script(  'jquery_flexslider_js'  );
	
	
	$output ='';
	
	$output .= '<div class="slider_shortcode" style="height: '.$height.'; width:'.$width.';"><div class="flexslider '.$name.'"><ul class="slides">';
	
	$recent = new WP_Query(array('post_type'=> 'slide', 'showposts' => '-1','orderby' => 'meta_value_num', 'meta_key'=>'slide_number_value','order'=>$order, 'slideshow' => $slideshow ));
	
	while($recent->have_posts()) : $recent->the_post();
		$images = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
		$captions = get_the_title('',FALSE);
		$content = get_the_content();
		$type = get_post_meta($post->ID, 'video_type_value', true);
		$video_id = get_post_meta($post->ID, 'video_id_value', true);
		$link  = get_post_meta($post->ID, 'slider_link_value', true);
		$button  = get_post_meta($post->ID, 'slider_button_value', true);
		

		if($type == "youtube"){
			$output .= '<li><iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video_id.'?wmode=opaque" frameborder="0" allowfullscreen></iframe></li>';
		}elseif($type == "vimeo"){
			$output .= '<li><iframe src="http://player.vimeo.com/video/'.$video_id.'?portrait=0&amp;color=ffffff" width="'.$width.'" height="'.$height.';" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe></li>';
		}else{
			$output.= '<li style="background-image: url('.$images.'); height: '.$height.'">';
			
				$output .= '<div class="li-wrap">';
				
				if( $captions ){
					$output .= '<h3>'.$captions.'</h3>';
					$output .= '<div class="clearfix"></div>';
				}
				if( $content ) {
					$output .=  '<div class="excerpt">'.$content.'</div>';
				}
				if( $button ) {
					$output .= '<p><a href="'.$link.'">'.$button.'</a></p>';
				}
				
				$output .=  '</div>';


			$output .= '</li>';
		}
		
		endwhile;
		wp_reset_query();

	    $output .= '</ul> </div><script type="text/javascript">jQuery.noConflict();jQuery(document).ready(function(e){function t(t){var n=e(".'.$name.' .slides li").not(".clone").eq(t.animatingTo),r=e(".'.$name.' .slides li").not(n);r.find("h3").animate({"margin-top":0,opacity:0},1e3);r.find(".excerpt").animate({left:"-680px",opacity:0},1e3);n.find("h3").animate({"margin-top":"20%",opacity:1},1e3);n.find(".excerpt").animate({left:0,opacity:1},1e3)}e(".'.$name.'").flexslider({animation:"'.$animation.'",slideDirection:"horizontal",slideshowSpeed:6e3,animationDuration:7e3,directionNav:"'.$directionnav.'",controlNav:"'.$controlnav.'",pauseOnAction:true,pauseOnHover:true,animationLoop:true,start:t,before:t});e(".'.$name.'").hover(function(){e(this).children("ul.flex-direction-nav").css({display:"block"})},function(){e(this).children("ul.flex-direction-nav").css({display:"none"})})})</script></div>';
		
		//removing extra <br>
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$output = str_replace( $Old, $New, $output );
		
		return $output;
}

add_shortcode(  'slider', 'zp_slider'  );

/**
**	Alert Box
*/

function zp_infobox(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'type' => ''
	), $atts ) );
	
	$output='';
	
	$output .= '<div class="infobox_container"><div class="'.$type.'">'.$content.'</div></div><div class="clearfix"></div>';
	return $output;
}

add_shortcode(  'info_box', 'zp_infobox'  );

/**
**	List Styles
*/

function zp_liststyles(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'style' => ''
	), $atts ) );
	
	$output='';
	
	$output .= '<ul class="bullet_'.$style.' imglist">'.do_shortcode( $content ).'</ul>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'list', 'zp_liststyles'  );

function zp_list_li( $atts, $content = null ) {
	return '<li>'. $content.'</li>';
}
add_shortcode( 'li', 'zp_list_li' );

/**
**	Columns Wrapper
*/
function zp_column_wrapper(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'num' => '',
		'last' => ''
	), $atts ) );
	
	$output='';
	
	$output .= '<div class="columns-wrapper">'.do_shortcode( $content ).'</div><div class="clearfix"></div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}

add_shortcode(  'col_wrapper', 'zp_column_wrapper'  );

/**
**	2 Columns
*/
function zp_2columns(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
	), $atts ) );
	
	$output='';
	
	$output .= '<div class="one-half columns">'.do_shortcode( $content ).'</div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	return $output;
}
add_shortcode(  'col2', 'zp_2columns'  );

function zp_2columns_last(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
	), $atts ) );
	
	$output='';
	
	$output .= '<div class="one-half columns nomargin">'.do_shortcode( $content ).'</div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'col2_last', 'zp_2columns_last'  );

/**
**	3 Columns
*/

function zp_3columns(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
	), $atts ) );
	
	$output='';
	$output .= '<div class="one-third columns">'.do_shortcode( $content ).'</div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'col3', 'zp_3columns'  );

function zp_3columns_last(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
	), $atts ) );
	
	$output='';
	
	$output .= '<div class="one-third columns nomargin">'.do_shortcode( $content ).'</div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'col3_last', 'zp_3columns_last'  );

/**
**	4 Columns
*/
function zp_4columns(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
	), $atts ) );
	
	$output='';
	
	
	$output .= '<div class="one-fourth columns">'.do_shortcode( $content ).'</div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}

add_shortcode(  'col4', 'zp_4columns'  );

function zp_4columns_last(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
	), $atts ) );
	
	$output='';
	
	$output .= '<div class="one-fourth columns nomargin">'.do_shortcode( $content ).'</div>';
	
	//removing extra <br>
	
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}

add_shortcode(  'col4_last', 'zp_4columns_last'  );

/**
**	2/3 Columns
*/

function zp_twothird_columns(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'last' => ''
	), $atts ) );
	
	$last = ($last == 'true' ) ? "nomargin" : ' ';
	
	$output='';
	$output .= '<div class="two-third columns '.$last.'">'.do_shortcode( $content ).'</div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'col2_3', 'zp_twothird_columns'  );

/**
**	3/4 Columns
*/

function zp_threefourth_columns(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'last' => ''
	), $atts ) );
	
	$last = ($last == 'true' ) ? "nomargin" : ' ';
	
	$output='';
	
	$output .= '<div class="three-fourth columns '.$last.'">'.do_shortcode( $content ).'</div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'col3_4', 'zp_threefourth_columns'  );

/***
*	DropCaps
*/

function zp_dropcaps(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
	), $atts ) );
	
	$output='';
	$output .= '<span class="drop-caps">'.$content.'</span>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'dropcaps', 'zp_dropcaps'  );

/**
*	Portfolio Shortcode
*/
function zp_portfolio(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'type' => '',
		'items' => '',
		'filter' => '',
		'effect' => ''
	), $atts ) );
	
	$output='';
	
	$filter = ($filter == "true" )? true:false;
	
	$output = zp_portfolio_shortcode( $items, $type, $effect );

	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'portfolio', 'zp_portfolio'  );

/**
*	Recent Blog Shortcode
*/
function zp_recent_blog(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'columns' => '',
		'items' => '',
		'category' => '',
	), $atts ) );
	
	$output='';
	$output = zp_post_shortcode( $columns, $items, $category);
	
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'recent_blog', 'zp_recent_blog'  );

/**
*	Call to Action Shortcode
*/

function zp_calltoaction(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'link' => '',
		'button_label' => '',
		'rounded' => '',
		'btnsize' => '',
		'color' => '',
	), $atts ) );
	
	$output='';
	
	$rounded = ( $rounded == 'true' )? 'rounded' : '';
	
	$output .= '<div class="call_to_action_box">'. do_shortcode( $content ).'<p><a class=" cta_button button ' .$rounded .' '. $btnsize .'-btn '. $color . '" href="'.$link.'">'.$button_label.'</a></p></div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'call_to_action', 'zp_calltoaction'  );

/**
*	Horizonal Separator
*/

function zp_hr(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
	), $atts ) );
	
	$output='';
	$output = '<hr />';
	
	return $output;
}
add_shortcode(  'hr', 'zp_hr'  );

/**
*	Testimoial
*/

function zp_testimonial(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'size' => ''
	), $atts ) );
	
	wp_enqueue_script(  'jquery_cycle'  );?>

	<script type="text/javascript">jQuery.noConflict();jQuery(document).ready(function(e){
		jQuery('.testimonial_container').cycle({
			speed: 3000,
			timeout: 2000
		});
	});
    </script>
	
	<?php
    
	$output='';
	
	$output = '<div class="'.$size.' testimonial"><div class="testimonial_container">'.do_shortcode( $content ).'</div></div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'testimonial', 'zp_testimonial'  );

function zp_testim_pane(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'name' => '',
		'position' => '',
		'icon' => ''
	), $atts ) );
	
	if(  $icon == '' )
		$icon = get_stylesheet_directory_uri().'/include/shortcodes/shortcode_icons/ico-user.png';
	
	$output = '';
	$output .= '<div>';
	$output .= '<div class="testimonial_content"><p>'.$content.'</p></div>';
	$output .= '<div class="signature"><span class="zp-icon">f</span><span class="testi_name">'.$name.'</span> '.$position.'</div>';
	$output .= '</div>';
	
	return $output;
}
add_shortcode(  'testi_pane', 'zp_testim_pane'  );

/**
*	Client
*/

function zp_client(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
	), $atts ) );
	
	wp_enqueue_script(  'jquery_carouFredSel'   );
	wp_enqueue_script(  'jquery_mousewheel'  );
	wp_enqueue_script(  'jquery_touchswipe' );
	wp_enqueue_script(  'jquery_transit' );
	wp_enqueue_script(  'jquery_throttle'  );
?>
	<script type="text/javascript">jQuery.noConflict();jQuery(document).ready(function(e){
			jQuery(".client_container").carouFredSel({
					auto: true,
					circular: true,
					infinite: true,
					swipe: {
						onMouse: true,
						onTouch: true
				}
			});
			});
            </script>
<?php
	$output='';
	$output .= '<div class="client_carousel">';
	$output .= '<div class="client_container">'.do_shortcode( $content ).'</div>';
	
	$output .= '</div>';
	
	//removing extra <br>
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$output = str_replace( $Old, $New, $output );
	
	return $output;
}
add_shortcode(  'client', 'zp_client'  );

function zp_client_item(  $atts, $content = null  ) {
	extract(  shortcode_atts(  array(
		'name' => '',
		'link' => '',
		'image' => '',
		'width' => '',
		'height' => ''
	), $atts ) );
	
	$output='';
	
	$output .= '<a href="'.$link.'"  title="'.$name.'"><img src="'.$image.'"   alt="'.$name.'" width="'.$width.'" height="'.$height.'" /></a>';
	
	return $output;
}
add_shortcode(  'client_item', 'zp_client_item'  );

/**
*	Add Custom Formatting Buttons
*/

global $shortcode_button, $shortcode_button2;
$shortcode_button=array( "dropcaps","hr","liststyle1","liststyle2","liststyle3","liststyle4","liststyle5","liststyle6","call_to_action", "frame", "lightbox", "button", "infoboxes", "twocolumns", "threecolumns", "fourcolumns");
$shortcode_button2=array( "threefourth","twothird", "toggle","tabs","accordion", "servicebox", "team" , "testimonial", "slider", "portfolio" );

function add_buttons(  ) {
	if (  get_user_option( 'rich_editing' ) == 'true' ) {
		add_filter( 'mce_external_plugins', 'add_btn_tinymce_plugin' );
		add_filter( 'mce_external_plugins', 'add_btn_tinymce_plugin2' );
		add_filter( 'mce_buttons_3', 'register_buttons' );
		add_filter( 'mce_buttons_4', 'register_buttons_2' );
	}
}
add_action( 'init', 'add_buttons' );

/**
* Register the buttons
* @param $buttons
*/
function register_buttons( $buttons ) {
	global $shortcode_button;
	
	array_push( $buttons, implode( ',',$shortcode_button ) );
	return $buttons;
}

function register_buttons_2( $buttons ) {
	global $shortcode_button2;
	
	array_push( $buttons, implode( ',',$shortcode_button2 ) );
	return $buttons;
}

/**
* Add the buttons
* @param $plugin_array
*/

if( !function_exists('add_btn_tinymce_plugin') ){
	function add_btn_tinymce_plugin( $plugin_array ) {
		global $shortcode_button;
		
		foreach( $shortcode_button as $btn ){
			$plugin_array[$btn] = get_stylesheet_directory_uri(  ).'/include/shortcodes/editor-plugin.js';
		}
		
		return $plugin_array;
	}
}

if( !function_exists('add_btn_tinymce_plugin2') ){
	
	function add_btn_tinymce_plugin2( $plugin_array ) {
		global $shortcode_button2;
		
		foreach( $shortcode_button2 as $btn ){
			$plugin_array[$btn] = get_stylesheet_directory_uri(  ).'/include/shortcodes/editor-plugin.js';
		}
		return $plugin_array;
	}
}
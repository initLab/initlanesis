<div id="home_gallery" style="height: <?php echo genesis_get_option( 'zp_slider_height' , ZP_SETTINGS_FIELD );?>px;">
  <?php 	
	wp_enqueue_script(  'jquery_flexslider_js'  );
 ?>
  <div id="slider" class="flexslider homeslider">
    <ul class="slides">
      <?php 
	  global $post;
		 //adjust video height
		 $video_height = genesis_get_option( 'zp_slider_height' , ZP_SETTINGS_FIELD );
		 $slideshow = genesis_get_option( 'zp_home_slideshow', ZP_SETTINGS_FIELD );
	  	$recent = new WP_Query(array('post_type'=> 'slide', 'showposts' => '-1','orderby' => 'meta_value_num', 'meta_key'=>'slide_number_value','order'=>'ASC', 'slideshow' => $slideshow )); 
	
      	 while($recent->have_posts()) : $recent->the_post();
	 		$images = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
			$captions = get_the_title('',FALSE);
			$content = get_the_content();
			$type = get_post_meta($post->ID, 'video_type_value', true);
			$video_id = get_post_meta($post->ID, 'video_id_value', true);
			$link  = get_post_meta($post->ID, 'slider_link_value', true);
			$button  = get_post_meta($post->ID, 'slider_button_value', true);
			
			if($type == "youtube"){?>
      <li>
        <iframe width="100%" height="<?php echo $video_height;?>px;" src="http://www.youtube.com/embed/<?php echo $video_id; ?>?wmode=opaque" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
      </li>
      <?php
            }elseif($type == "vimeo"){?>
      <li>
        <iframe src="http://player.vimeo.com/video/<?php echo $video_id; ?>?portrait=0&amp;color=ffffff" width="100%" height="<?php echo $video_height;?>px;" frameborder="0" webkitallowfullscreen="webkitAllowFullScreen" allowfullscreen="allowFullScreen"></iframe>
      </li>
      <?php	
			}else{
			 ?>
      <li style="background-image: url(<?php echo $images;?>); height: <?php echo genesis_get_option( 'zp_slider_height' , ZP_SETTINGS_FIELD );?>px;">
        <?php if( $content ) { ?>
        <div class="li-wrap">
        <div class="column cta half">
          <h3><?php echo $captions; ?></h3>
          <div class="clearfix"></div>
          <div class="excerpt">
            <?php  echo $content; ?>
          </div>
          <?php if( $button ) { ?>
          <p><a href="<?php echo $link;?>"><?php echo $button;?></a></p>
          <?php } ?>
        </div></div>
        <?php } ?>
      </li>
      <?php }
				endwhile;
				
				wp_reset_query();
			?>
    </ul>
  </div>
  <div class="clearfix"></div>
  <script type="text/javascript">
		jQuery.noConflict();
		jQuery(document).ready(function(jQuery) {      
			jQuery('#home_gallery .homeslider').flexslider({
					animation: "<?php echo genesis_get_option( 'zp_animation' , ZP_SETTINGS_FIELD );?>",              
					slideDirection: "horizontal",                  
					slideshowSpeed: <?php echo genesis_get_option( 'zp_slider_speed' , ZP_SETTINGS_FIELD );?>,           
					animationDuration: <?php echo genesis_get_option( 'zp_animation_duration' , ZP_SETTINGS_FIELD );?>,         
					directionNav: <?php echo genesis_get_option( 'zp_direction_nav' , ZP_SETTINGS_FIELD );?>,             
					controlNav: <?php echo genesis_get_option( 'zp_control_nav' , ZP_SETTINGS_FIELD );?>,                                                                   
					pauseOnAction: <?php echo genesis_get_option( 'zp_pauseonaction' , ZP_SETTINGS_FIELD );?>,         
					pauseOnHover: <?php echo genesis_get_option( 'zp_pauseonhover' , ZP_SETTINGS_FIELD );?>,
				    animationLoop: true,				
					start: zp_sliderCaptionAnimate,
					before: zp_sliderCaptionAnimate



			});
			
			jQuery('.homeslider').hover(function(){	
					jQuery(this).children('ul.flex-direction-nav').css({display: 'block'});
					
			}, function(){
					jQuery(this).children('ul.flex-direction-nav').css({display: 'none'});
			});
								
						
		});
	</script> 
</div>

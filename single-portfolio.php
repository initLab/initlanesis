<?php 
/*------------------------------
 
 Portfolio Single Page 

------------------------------*/ 

/** Force the full width layout layout on the Portfolio page */

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 	'genesis_loop', 'genesis_do_loop'  );
add_action( 'genesis_loop', 'zp_single_portfolio_template'  );

function zp_single_portfolio_template(  ) { 
global  $post;	

wp_enqueue_script(  'jquery_flexslider_js'  );

printf( '<article %s>', genesis_attr( 'entry' ) );
?>

	<script type="text/javascript">
	jQuery.noConflict();
		jQuery(document).ready(function(e){
			jQuery('.portfolio_single_slider').flexslider({
				animation: "slide",
				slideDirection: "horizontal",
				directionNav: true,
				controlNav: true,
				pauseOnAction:true,
				pauseOnHover: true 
			});
		});
        
    </script>

  <div class="portfolio_single_feature">
        <?php if (  have_posts(  )  ) : while (  have_posts(  )  ) : the_post(  ); 
		
		//get portfolio meta settings
		
		$image1 = get_post_meta( $post->ID, 'zp_image_1_value', true );
		$image2 = get_post_meta( $post->ID, 'zp_image_2_value', true );
		$image3 = get_post_meta( $post->ID, 'zp_image_3_value', true );
		$image4 = get_post_meta( $post->ID, 'zp_image_4_value', true );
		$image5 = get_post_meta( $post->ID, 'zp_image_5_value', true );
		
		$thumbnail = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
		
		$video_url = get_post_meta( $post->ID, 'zp_video_url_value', true );
		$video_embed = get_post_meta( $post->ID, 'zp_video_embed_value', true );
		$video_ht = get_post_meta( $post->ID, 'zp_height_value', true );
		
		?>     
        
        <!--if  Video exist -->
        <?php if( $video_url !='' || $video_embed!= '' ){ ?>
        <div class="portfolio_single_video">
        <?php
		wp_enqueue_script('jquery_fitvids');
	
				if( trim( $video_embed ) == '' ) 
					{
						
						if( preg_match( '/youtube/', $video_url ) ) 
						{	
								//preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i',$string,$output)
								
							if( preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i', $video_url, $matches ) )
							{
								$output = '<iframe title="YouTube video player" class="youtube-player" type="text/html"  width="1100" height="619"  src="http://www.youtube.com/embed/'.$matches[4][0].'" frameborder="0" allowFullScreen></iframe>';
							}
							else 
							{
								$output = __( 'Sorry that seems to be an invalid <strong>YouTube</strong> URL. Please check it again.', 'amelie' );
							}	
						}
						elseif( preg_match( '/vimeo/', $video_url ) ) 
						{
							
							if( preg_match('/^http:\/\/(www\.)?vimeo\.com\/(clip\:)?(\d+).*$/', $video_url, $matches ) )
							{
								$output = '<iframe src="http://player.vimeo.com/video/'.$matches[3].'" width="1100" height="619"  frameborder="0"></iframe>';
							}
							else 
							{
								$output = __( 'Sorry that seems to be an invalid <strong>Vimeo</strong> URL. Please check it again. Make sure there is a string of numbers at the end.', 'amelie' );
							}
							
						}
						else 
						{
							$output = __( 'Sorry that is an invalid YouTube or Vimeo URL.', 'amelie' );
						}
						
						echo $output;
						
					}
		else
		{
			echo stripslashes( htmlspecialchars_decode( $video_embed ) );
		}
		
		?>        
        </div>

		<script type="text/javascript">
            jQuery(document).ready(function(){
                //fitvideo
               jQuery(".portfolio_single_video").fitVids();
            });
        </script>
  	   
	
        <!-- if images exists ( slider )-->
        <?php } elseif( $image1 != '' || $image2 != '' || $image3 != '' || $image4 != '' || $image5 != ''   ){?> 
		<div class="portfolio_single_slider flexslider">
        	<ul class="slides">
            	<?php if( $image1 != '' ){ ?><li><img src="<?php echo $image1; ?>" alt="<?php echo get_the_title(  ); ?>"  /></li><?php } ?>
               <?php if( $image2 != '' ){?> <li><img src="<?php echo $image2; ?>" alt="<?php echo get_the_title(  ); ?>" /></li><?php } ?>
                <?php if( $image3 != '' ){ ?><li><img src="<?php echo $image3; ?>" alt="<?php echo get_the_title(  ); ?>" /></li><?php } ?>
               <?php if( $image4 !='' ){ ?> <li><img src="<?php echo $image4; ?>" alt="<?php echo get_the_title(  ); ?>"  /></li><?php } ?>
                <?php if( $image5 !='' ){ ?><li><img src="<?php echo $image5; ?>" alt="<?php echo get_the_title(  ); ?>" /></li><?php } ?>
            </ul>
        </div>        
        <?php }else {?>
        <!-- display fetaured image-->
        <div class="portfolio-items">
			<a href="<?php echo $thumbnail; ?>" title="<?php the_title(  ); ?>" rel="prettyPhoto[pp_gal]"></a>
            <span class="single_image_overlay"></span>
            <?php echo wp_get_attachment_image(  get_post_thumbnail_id(  $post->ID  ), 'portfolio_single' );?>
			
		</div>
        	<div style="display: none; ">
            	<?php echo zp_show_all_attached_image( $post->ID, 'pp_gal' , $thumbnail ); ?>
            </div>
        

		<?php } 
		
		
		?>
               
      </div> <!-- end portfolio_single_feature -->

		<header class="entry-header"><h1 class="entry-title" itemprop="headline"><?php echo the_title('','', false ) ?></h1><hr class="small"></header>
        <?php
			if( get_post_meta( $post->ID, 'zp_portfolio_meta_item_value', true ) != 'true' ){
				$full = 'style="width: 100%;"';
			}else{
				$full = '';
			}
		?>		<?php
		if( get_post_meta( $post->ID, 'zp_portfolio_meta_item_value', true ) == 'true' ){?>
        
        <div class="folio-entry"  <?php echo $full; ?> >
		<?php the_content(  ); ?>
        </div>
   
		<div class="metaItem">
            <div class="projectlink"><a class="button" href="<?php echo get_post_meta( $post->ID, 'zp_project_link_value', true ); ?>"><?php echo get_post_meta( $post->ID, 'zp_project_label_value', true ); ?></a></div>
        </div>            
            <?php } ?>
        
  
    
 <?php
 
endwhile; endif; 
?>
</article>
<?php
if (  genesis_get_option( 'zp_related_portfolio', ZP_SETTINGS_FIELD  ) ):?>
<div class="folio-more">
	<?php  zp_related_portfolio(  ); ?>
</div><!-- End columns. -->
<?php endif;?>

<?php }

genesis(  );
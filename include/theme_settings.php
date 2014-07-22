<?php
/* Define constants
------------------------------------------------------------ */
define( 'ZP_SETTINGS_FIELD', 'zp-settings' );

/* Setup default options
------------------------------------------------------------ */
/**
* zpsettings_default_theme_options function.
*/
function zpsettings_default_theme_options() {
	$options = array(
		'zp_welcome_enable' => 1,
		'zp_welcome_message' => __( 'This is the welcome message section','novo' ),
		'zp_front_enable' => 1,
		'zp_color_scheme' => 'default',
		'zp_css_code' => '',
		'zp_portfolio_archive_columns' => '4',
		'zp_home_blog_itemdesc' => 1,
		'zp_latest_blog_items' => 3,
		'zp_home_blog_columns' => 3,
		'zp_related_portfolio' => 1,
		'zp_related_portfolio_title' => __( 'Related Portfolio','novo' ),
		'zp_num_portfolio_items' => 8,
		'zp_num_archive_items' => '8',
		'zp_logo' => '',
		'zp_logo_height' => 64,
		'zp_logo_width' => 180,
		'zp_footer_text' 	=> ''
	);
	
	return apply_filters( 'zpsettings_default_theme_options', $options );
}
/* Sanitize any inputs
------------------------------------------------------------ */

add_action( 'genesis_settings_sanitizer_init', 'zpsettings_sanitize_inputs' );
/**
* zpsettings_sanitize_inputs function.
*/ 
function zpsettings_sanitize_inputs() {
    genesis_add_option_filter( 'one_zero',
		ZP_SETTINGS_FIELD,
			array(
				'zp_welcome_enable',
			)
		);

	genesis_add_option_filter( 'no_html',
		ZP_SETTINGS_FIELD,
			array(
				'zp_num_portfolio_items',
				'zp_logo_height',
				'zp_logo_height',
				'zp_logo'
			)
		);
		
	genesis_add_option_filter( 'requires_unfiltered_html',
		ZP_SETTINGS_FIELD,
			array(
				'zp_welcome_message',
				'zp_footer_text',
				'zp_logo_upload'
			)
		);
}

/* Register our settings and add the options to the database
------------------------------------------------------------- */

add_action( 'admin_init', 'zpsettings_register_settings' );

/**
* zpsettings_register_settings function.
*/

function zpsettings_register_settings() {
	register_setting( ZP_SETTINGS_FIELD, ZP_SETTINGS_FIELD );
	
	add_option( ZP_SETTINGS_FIELD, zpsettings_default_theme_options() );
	
	if ( genesis_get_option( 'reset', ZP_SETTINGS_FIELD ) ) {
		update_option( ZP_SETTINGS_FIELD, zpsettings_default_theme_options() );
		genesis_admin_redirect( ZP_SETTINGS_FIELD, array( 'reset' => 'true' ) );
		exit;
	}
}

/* Admin notices for when options are saved/reset
------------------------------------------------------------ */

add_action( 'admin_notices', 'zpsettings_theme_settings_notice' );

/**
* zpsettings_theme_settings_notice function.
*/

function zpsettings_theme_settings_notice() {
	if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] != ZP_SETTINGS_FIELD )
		return;
	if ( isset( $_REQUEST['reset'] ) && 'true' == $_REQUEST['reset'] )
		echo '<div id="message" class="updated"><p><strong>' . __( 'Settings reset.', 'novo' ) . '</strong></p></div>';
	elseif ( isset( $_REQUEST['settings-updated'] ) && 'true' == $_REQUEST['settings-updated'] )
		echo '<div id="message" class="updated"><p><strong>' . __( 'Settings saved.', 'novo' ) . '</strong></p></div>';
}

/* Register our theme options page
------------------------------------------------------------ */

add_action( 'admin_menu', 'zpsettings_theme_options' );

/**
* zpsettings_theme_options function.
*/

function zpsettings_theme_options() {
	global $_zpsettings_settings_pagehook;
	
	$_zpsettings_settings_pagehook = add_submenu_page( 'genesis', 'Novo Settings', 'Novo Settings', 'edit_theme_options', ZP_SETTINGS_FIELD, 'zpsettings_theme_options_page' );
	
	//add_action( 'load-'.$_zpsettings_settings_pagehook, 'zpsettings_settings_styles' );
	add_action( 'load-'.$_zpsettings_settings_pagehook, 'zpsettings_settings_scripts' );
	add_action( 'load-'.$_zpsettings_settings_pagehook, 'zpsettings_settings_boxes' );
}

/* Setup our scripts
------------------------------------------------------------ */
/**
* zpsettings_settings_scripts function.
* This function enqueues the scripts needed for the CT Settings settings page.
*/

function zpsettings_settings_scripts() {
	global $_zpsettings_settings_pagehook;
	
	if( is_admin() ){
		wp_register_script( 'zp_image_upload', get_stylesheet_directory_uri() .'/include/upload/image-upload.js', array('jquery','media-upload','thickbox') );
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('zp_image_upload');
		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'postbox' );
	}
}

/* Setup our metaboxes
------------------------------------------------------------ */
/**
* zpsettings_settings_boxes function.
*
* This function sets up the metaboxes to be populated by their respective callback functions.
*
*/
function zpsettings_settings_boxes() {
	global $_zpsettings_settings_pagehook;
	

	add_meta_box( 'zpsettings_appearance_settings', __( 'Appearance Settings', 'novo' ), 'zpsettings_appearance_settings', $_zpsettings_settings_pagehook, 'main' ,'high');
	add_meta_box( 'zpsettings_portfolio', __( 'Portfolio Settings ', 'novo' ), 'zpsettings_portfolio', $_zpsettings_settings_pagehook, 'main','high' );
	add_meta_box( 'zpsettings_footer_settings', __( 'Footer Settings', 'novo' ), 'zpsettings_footer_settings', $_zpsettings_settings_pagehook, 'main','high' );
	add_meta_box( 'zpsettings_responsive_logo_settings', __( 'Responsive Logo Settings', 'novo' ), 'zpsettings_responsive_logo_settings', $_zpsettings_settings_pagehook, 'main' ,'high');	
}

/* Add our custom post metabox for social sharing
------------------------------------------------------------ */

/**
* zpsettings_home_settings function.
*
* Callback function for the ZP Settings Social Sharing metabox.
*
*/


function zpsettings_appearance_settings() { ?>
  <p>

	<label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_color_scheme]"><?php _e( 'Select color scheme.','novo'); ?></label>

	<select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_color_scheme]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_color_scheme]">         

	<option value="default" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'default' ); ?>>Default</option>    
    
	<option  value="alizarin" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'alizarin' ); ?>>alizarin</option>
    <option  value="amethyst" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'amethyst' ); ?>>amethyst</option>
    <option  value="asbestos" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'asbestos' ); ?>>asbestos</option>
    <option  value="belize_hole" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'belize_hole' ); ?>>belize_hole</option>
    <option  value="carrot" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'carrot' ); ?>>carrot</option>
    <option  value="clouds" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'clouds' ); ?>>clouds</option>
    <option  value="concrete" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'concrete' ); ?>>concrete</option>
    <option  value="emerald" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'emerald' ); ?>>emerald</option>
    <option  value="green_sea" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'green_sea' ); ?>>green_sea</option>
    <option  value="midnight_blue" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'midnight_blue' ); ?>>midnight_blue</option>
    <option  value="nephritis" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'nephritis' ); ?>>nephritis</option>
    <option  value="orange" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'orange' ); ?>>orange</option>
    <option  value="peter_river" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'peter_river' ); ?>>peter_river</option>
    <option  value="pomegranate" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'pomegranate' ); ?>>pomegranate</option>
    <option  value="pumpkin" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'pumpkin' ); ?>>pumpkin</option>
    <option  value="silver" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'silver' ); ?>>silver</option>
    <option  value="sunflower" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'sunflower' ); ?>>sunflower</option>
    <option  value="turquoise" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'turquoise' ); ?>>turquoise</option>
    <option  value="wet_asphalt" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'wet_asphalt' ); ?>>wet_asphalt</option>
    <option  value="wisteria" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'wisteria' ); ?>>wisteria</option>
        
    
    </select>

	</p>

   

    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_css_code]"><?php _e( 'Custom CSS Code.', 'novo' ); ?><br>

	<textarea rows="3" cols="55" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_css_code]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_css_code]"><?php echo genesis_get_option( 'zp_css_code', ZP_SETTINGS_FIELD ); ?></textarea>

	</label>

	</p>  

     

    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo]"><?php _e( 'Upload Custom Logo.', 'novo' ); ?></label>  

    <input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo]" value="<?php echo  genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ); ?>" />

    <input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_upload_button]" type="button" class="logo_button button" value="<?php _e( 'Upload Logo', 'novo' ); ?>" />

    </p>  

    <div id="upload_logo_preview">

		<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ); ?>" />

	</div>

    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_height]"><?php _e( 'Custom Logo Height in pixel/percentage.', 'novo' ); ?></label>

	<input type="text" size="20" value="<?php echo genesis_get_option( 'zp_logo_height', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_height]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_height]">

	</p>    

    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_width]"><?php _e( 'Custom Logo Width in pixel/percentage.', 'novo' ); ?></label>

	<input type="text" size="20" value="<?php echo genesis_get_option( 'zp_logo_width', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_width]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_width]">

	</p>   
 	<p> <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_background_pos]"><?php _e( 'Select Logo Position.','novo'); ?></label>
	<select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_background_pos]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_background_pos]">         
	<option value="left top" <?php selected( genesis_get_option( 'zp_logo_background_pos', ZP_SETTINGS_FIELD ), 'left top' ); ?>>left top</option>	
    <option value="left center" <?php selected( genesis_get_option( 'zp_logo_background_pos', ZP_SETTINGS_FIELD ), 'left center' ); ?>>left center</option>
    <option value="left bottom" <?php selected( genesis_get_option( 'zp_logo_background_pos', ZP_SETTINGS_FIELD ), 'left bottom' ); ?>>left bottom</option>
    <option value="right top" <?php selected( genesis_get_option( 'zp_logo_background_pos', ZP_SETTINGS_FIELD ), 'right top' ); ?>>right top</option>
    <option value="right center" <?php selected( genesis_get_option( 'zp_logo_background_pos', ZP_SETTINGS_FIELD ), 'right center' ); ?>>right center</option>
    <option value="right bottom" <?php selected( genesis_get_option( 'zp_logo_background_pos', ZP_SETTINGS_FIELD ), 'right bottom' ); ?>>right bottom</option>
    <option value="center top" <?php selected( genesis_get_option( 'zp_logo_background_pos', ZP_SETTINGS_FIELD ), 'center top' ); ?>>center top</option>
    <option value="center center" <?php selected( genesis_get_option( 'zp_logo_background_pos', ZP_SETTINGS_FIELD ), 'center center' ); ?>>center center</option>
    <option value="center bottom" <?php selected( genesis_get_option( 'zp_logo_background_pos', ZP_SETTINGS_FIELD ), 'center bottom' ); ?>>center bottom</option>	                
    </select>    
    </p>       
    

    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon]"><?php _e( 'Upload Custom Favicon.', 'novo' ); ?></label>  

    <input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon]" value="<?php echo  genesis_get_option( 'zp_favicon', ZP_SETTINGS_FIELD ); ?>" />

    <input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon_upload_button]" type="button" class="button" value="<?php _e( 'Upload Favicon', 'novo' ); ?>" />

    </p>  

    <div id="upload_favicon_preview">

		<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_favicon', ZP_SETTINGS_FIELD ); ?>" />

	</div>

             

    

	<p><span class="description"><?php _e( 'This is the appearance settings.','novo' ); ?></span></p>    

	

<?php } 
function zpsettings_footer_settings() { ?>

    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_text]"><?php _e( 'Footer Text', 'novo' ); ?><br>

	<textarea rows="3" cols="55" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_text]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_text]"><?php echo genesis_get_option( 'zp_footer_text', ZP_SETTINGS_FIELD ); ?></textarea>

	<br><small><strong><?php _e( 'Enter your site copyright here.', 'novo' ); ?></strong></small>

	</label>

	</p>    

	

<?php }


function zpsettings_portfolio() { ?>

    <p>	<input type="checkbox" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_related_portfolio]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_related_portfolio]" value="1" <?php checked( 1, genesis_get_option( 'zp_related_portfolio', ZP_SETTINGS_FIELD ) ); ?> /> <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_related_portfolio]"><?php _e( 'Check to enable related portfolio in single portfolio page.', 'novo' ); ?></label>

    </p>

       

     <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_related_portfolio_title]"><?php _e( 'Related Portfolio Title', 'novo' ) ?></label>

        <input type="text" size="20" value="<?php echo genesis_get_option( 'zp_related_portfolio_title', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_related_portfolio_title]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_related_portfolio_title]"></p> 

        

     <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_portfolio_items]"><?php _e( 'Number of items in the portfolio page', 'novo' ) ?></label>

        <input type="text" size="20" value="<?php echo genesis_get_option( 'zp_num_portfolio_items', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_portfolio_items]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_portfolio_items]"></p> 
     <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_archive_items]"><?php _e( 'Number of items in the portfolio archive', 'novo' ) ?></label>

        <input type="text" size="20" value="<?php echo genesis_get_option( 'zp_num_archive_items', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_archive_items]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_archive_items]">     

        

     <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_portfolio_archive_columns]"><?php _e( 'Portfolio Archive Columns:','novo' );?></label>

	<select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_portfolio_archive_columns]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_portfolio_archive_columns]">         

	<option  value="3" <?php selected( genesis_get_option( 'zp_portfolio_archive_columns', ZP_SETTINGS_FIELD ), '3' ); ?>>Three Columns</option>

    </select></p>
    

     <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_portfolio_animation]"><?php _e( 'Portfolio Animations:','novo' );?></label>

	<select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_portfolio_animation]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_portfolio_animation]">         
	<option  value="fall" <?php selected( genesis_get_option( 'zp_portfolio_animation', ZP_SETTINGS_FIELD ), 'fall' ); ?>>Fall</option>
    <option  value="slide" <?php selected( genesis_get_option( 'zp_portfolio_animation', ZP_SETTINGS_FIELD ), 'slide' ); ?>>Slide</option>
    <option  value="rotate_fall" <?php selected( genesis_get_option( 'zp_portfolio_animation', ZP_SETTINGS_FIELD ), 'rotate_fall' ); ?>>Rotate Fall</option>
    <option  value="rotate_scale" <?php selected( genesis_get_option( 'zp_portfolio_animation', ZP_SETTINGS_FIELD ), 'rotate_scale' ); ?>>Rotate Scale</option>
    <option  value="stack" <?php selected( genesis_get_option( 'zp_portfolio_animation', ZP_SETTINGS_FIELD ), 'stack' ); ?>>Stack</option>
    <option  value="3D_flip" <?php selected( genesis_get_option( 'zp_portfolio_animation', ZP_SETTINGS_FIELD ), '3D_flip' ); ?>>3d Flip</option>
    <option  value="bring_back" <?php selected( genesis_get_option( 'zp_portfolio_animation', ZP_SETTINGS_FIELD ), 'bring_back' ); ?>>Bring Back</option>
    <option  value="superscale" <?php selected( genesis_get_option( 'zp_portfolio_animation', ZP_SETTINGS_FIELD ), 'superscale' ); ?>>Superscale</option>
    <option  value="center_flip" <?php selected( genesis_get_option( 'zp_portfolio_animation', ZP_SETTINGS_FIELD ), 'center_flip' ); ?>>Center Flip</option>
    <option  value="front_row" <?php selected( genesis_get_option( 'zp_portfolio_animation', ZP_SETTINGS_FIELD ), 'front_row' ); ?>>Front Row</option>
    </select></p>                

 

     <p><span class="description"><?php _e( 'This settings applies to portfolio.','novo' ) ?></span></p>  

    

<?php }

function zpsettings_responsive_logo_settings() { ?>

    <h4><?php _e( '600 Max Width Logo', 'novo' ); ?></h4>
    
    
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo]"><?php _e( 'Upload Custom Logo.', 'novo' ); ?></label>  

    <input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo]" value="<?php echo  genesis_get_option( 'zp_600_logo', ZP_SETTINGS_FIELD ); ?>" />

    <input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo_upload_button]" type="button" class="logo_button button" value="<?php _e( 'Upload Logo', 'novo' ); ?>" />

    </p>  

    <div id="upload_600_logo_preview">
	<?php if(genesis_get_option( 'zp_600_logo', ZP_SETTINGS_FIELD )): ?>
		<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_600_logo', ZP_SETTINGS_FIELD ); ?>" />
	<?php endif; ?>
	</div>

    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo_width]"><?php _e( 'Custom Logo Width in pixel/percentage.', 'novo' ); ?></label>

	<input type="text" size="20" value="<?php echo genesis_get_option( 'zp_600_logo_width', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo_width]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo_width]">

	</p>
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo_height]"><?php _e( 'Custom Logo Height in pixel/percentage.', 'novo' ); ?></label>
	<input type="text" size="20" value="<?php echo genesis_get_option( 'zp_600_logo_height', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo_height]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_logo_height]">
	</p>     

    

	<p> <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_background_pos]"><?php _e( 'Select Background Position.','novo'); ?></label>
	<select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_background_pos]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_600_background_pos]">         
	<option value="left top" <?php selected( genesis_get_option( 'zp_600_background_pos', ZP_SETTINGS_FIELD ), 'left top' ); ?>>left top</option>	
    <option value="left center" <?php selected( genesis_get_option( 'zp_600_background_pos', ZP_SETTINGS_FIELD ), 'left center' ); ?>>left center</option>
    <option value="left bottom" <?php selected( genesis_get_option( 'zp_600_background_pos', ZP_SETTINGS_FIELD ), 'left bottom' ); ?>>left bottom</option>
    <option value="right top" <?php selected( genesis_get_option( 'zp_600_background_pos', ZP_SETTINGS_FIELD ), 'right top' ); ?>>right top</option>
    <option value="right center" <?php selected( genesis_get_option( 'zp_600_background_pos', ZP_SETTINGS_FIELD ), 'right center' ); ?>>right center</option>
    <option value="right bottom" <?php selected( genesis_get_option( 'zp_600_background_pos', ZP_SETTINGS_FIELD ), 'right bottom' ); ?>>right bottom</option>
    <option value="center top" <?php selected( genesis_get_option( 'zp_600_background_pos', ZP_SETTINGS_FIELD ), 'center top' ); ?>>center top</option>
    <option value="center center" <?php selected( genesis_get_option( 'zp_600_background_pos', ZP_SETTINGS_FIELD ), 'center center' ); ?>>center center</option>
    <option value="center bottom" <?php selected( genesis_get_option( 'zp_600_background_pos', ZP_SETTINGS_FIELD ), 'center bottom' ); ?>>center bottom</option>	                
    </select>    
    </p>
    <div style="border: 0;margin: 30px 0;border-top: 1px solid #CCC;border-bottom: 1px solid #FFF;"></div>
    
    <h4><?php _e( '480 Max Width Logo', 'novo' ); ?></h4>
    
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo]"><?php _e( 'Upload Custom Logo.', 'novo' ); ?></label>  

    <input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo]" value="<?php echo  genesis_get_option( 'zp_480_logo', ZP_SETTINGS_FIELD ); ?>" />

    <input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo_upload_button]" type="button" class="logo_button button" value="<?php _e( 'Upload Logo', 'novo' ); ?>" />

    </p>  

    <div id="upload_480_logo_preview">
	<?php if(genesis_get_option( 'zp_480_logo', ZP_SETTINGS_FIELD )): ?>
		<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_480_logo', ZP_SETTINGS_FIELD ); ?>" />
	<?php endif; ?>
	</div>

    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo_width]"><?php _e( 'Custom Logo Width in pixel/percentage.', 'novo' ); ?></label>

	<input type="text" size="20" value="<?php echo genesis_get_option( 'zp_480_logo_width', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo_width]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo_width]">

	</p>

    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo_height]"><?php _e( 'Custom Logo Height in pixel/percentage.', 'novo' ); ?></label>

	<input type="text" size="20" value="<?php echo genesis_get_option( 'zp_480_logo_height', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo_height]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_logo_height]">

	</p>    
	<p> <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_background_pos]"><?php _e( 'Select Background Position.','novo'); ?></label>
	<select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_background_pos]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_480_background_pos]">         
	<option value="left top" <?php selected( genesis_get_option( 'zp_480_background_pos', ZP_SETTINGS_FIELD ), 'left top' ); ?>>left top</option>	
    <option value="left center" <?php selected( genesis_get_option( 'zp_480_background_pos', ZP_SETTINGS_FIELD ), 'left center' ); ?>>left center</option>
    <option value="left bottom" <?php selected( genesis_get_option( 'zp_480_background_pos', ZP_SETTINGS_FIELD ), 'left bottom' ); ?>>left bottom</option>
    <option value="right top" <?php selected( genesis_get_option( 'zp_480_background_pos', ZP_SETTINGS_FIELD ), 'right top' ); ?>>right top</option>
    <option value="right center" <?php selected( genesis_get_option( 'zp_480_background_pos', ZP_SETTINGS_FIELD ), 'right center' ); ?>>right center</option>
    <option value="right bottom" <?php selected( genesis_get_option( 'zp_480_background_pos', ZP_SETTINGS_FIELD ), 'right bottom' ); ?>>right bottom</option>
    <option value="center top" <?php selected( genesis_get_option( 'zp_480_background_pos', ZP_SETTINGS_FIELD ), 'center top' ); ?>>center top</option>
    <option value="center center" <?php selected( genesis_get_option( 'zp_480_background_pos', ZP_SETTINGS_FIELD ), 'center center' ); ?>>center center</option>
    <option value="center bottom" <?php selected( genesis_get_option( 'zp_480_background_pos', ZP_SETTINGS_FIELD ), 'center bottom' ); ?>>center bottom</option>	                
    </select>    
    </p>
    <div style="border: 0;margin: 30px 0;border-top: 1px solid #CCC;border-bottom: 1px solid #FFF;"></div>
    
    <h4><?php _e( '320 Max Width Logo', 'novo' ); ?></h4>
   
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo]"><?php _e( 'Upload Custom Logo.', 'novo' ); ?></label>  

    <input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo]" value="<?php echo  genesis_get_option( 'zp_320_logo', ZP_SETTINGS_FIELD ); ?>" />

    <input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo_upload_button]" type="button" class="logo_button button" value="<?php _e( 'Upload Logo', 'novo' ); ?>" />

    </p>  

    <div id="upload_320_logo_preview">
	<?php if(genesis_get_option( 'zp_320_logo', ZP_SETTINGS_FIELD )): ?>
		<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_320_logo', ZP_SETTINGS_FIELD ); ?>" />
	<?php endif; ?>
	</div>

    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo_width]"><?php _e( 'Custom Logo Width in pixel/percentage.', 'novo' ); ?></label>

	<input type="text" size="20" value="<?php echo genesis_get_option( 'zp_320_logo_width', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo_width]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo_width]">

	</p>
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo_height]"><?php _e( 'Custom Logo Height in pixel/percentage. ', 'novo' ); ?></label>

	<input type="text" size="20" value="<?php echo genesis_get_option( 'zp_320_logo_height', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo_height]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_logo_height]">

	</p>    
    
    <p> <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_background_pos]"><?php _e( 'Select Background Position.','novo'); ?></label>
	<select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_background_pos]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_320_background_pos]">         
	<option value="left top" <?php selected( genesis_get_option( 'zp_320_background_pos', ZP_SETTINGS_FIELD ), 'left top' ); ?>>left top</option>	
    <option value="left center" <?php selected( genesis_get_option( 'zp_320_background_pos', ZP_SETTINGS_FIELD ), 'left center' ); ?>>left center</option>
    <option value="left bottom" <?php selected( genesis_get_option( 'zp_320_background_pos', ZP_SETTINGS_FIELD ), 'left bottom' ); ?>>left bottom</option>
    <option value="right top" <?php selected( genesis_get_option( 'zp_320_background_pos', ZP_SETTINGS_FIELD ), 'right top' ); ?>>right top</option>
    <option value="right center" <?php selected( genesis_get_option( 'zp_320_background_pos', ZP_SETTINGS_FIELD ), 'right center' ); ?>>right center</option>
    <option value="right bottom" <?php selected( genesis_get_option( 'zp_320_background_pos', ZP_SETTINGS_FIELD ), 'right bottom' ); ?>>right bottom</option>
    <option value="center top" <?php selected( genesis_get_option( 'zp_320_background_pos', ZP_SETTINGS_FIELD ), 'center top' ); ?>>center top</option>
    <option value="center center" <?php selected( genesis_get_option( 'zp_320_background_pos', ZP_SETTINGS_FIELD ), 'center center' ); ?>>center center</option>
    <option value="center bottom" <?php selected( genesis_get_option( 'zp_320_background_pos', ZP_SETTINGS_FIELD ), 'center bottom' ); ?>>center bottom</option>	                
    </select>    
    </p>


<?php } 

/* Replace the 'Insert into Post Button inside Thickbox'
------------------------------------------------------------ */
function zp_replace_thickbox_text($translated_text, $text ) {	

	if ( 'Insert into Post' == $text ) {

		$referer = strpos( wp_get_referer(), ZP_SETTINGS_FIELD );

		if ( $referer != '' ) {

			return __('Insert Image!', 'novo' );

		}

	}
	return $translated_text;

}
/* Hook to filter Insert into Post Button in thickbox
------------------------------------------------------------ */

function zp_change_insert_button_text() {

		add_filter( 'gettext', 'zp_replace_thickbox_text' , 1, 2 );

}

add_action( 'admin_init', 'zp_change_insert_button_text' );

/* Set the screen layout to one column
------------------------------------------------------------ */

add_filter( 'screen_layout_columns', 'zpsettings_settings_layout_columns', 10, 2 );

/**
 * zpsettings_settings_layout_columns function.
 *
 * This function sets the column layout to one for the CT Settings settings page.
 *
 */

function zpsettings_settings_layout_columns( $columns, $screen ) {
	global $_zpsettings_settings_pagehook;
	if ( $screen == $_zpsettings_settings_pagehook ) {
		$columns[$_zpsettings_settings_pagehook] = 2;
	}
	return $columns;
}

/* Build our theme options page
------------------------------------------------------------ */
/**
 * zpsettings_theme_options_page function.
 *
 * This function displays the content for the CT Settings settings page, builds the forms and outputs the metaboxes.
 *
 */

function zpsettings_theme_options_page() { 
	global $_zpsettings_settings_pagehook, $screen_layout_columns;
	
	$screen = get_current_screen();
	$width = "width: 72%;";
	$hide2 = $hide3 = " display: none;";
	?>	
	<div id="zpsettings" class="wrap genesis-metaboxes">
		<form method="post" action="options.php">
			<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
			<?php settings_fields( ZP_SETTINGS_FIELD ); ?>
			<?php screen_icon( 'options-general' ); ?>
			<h2>
				<?php _e( 'Novo Settings', 'novo' ); ?>
                <input type="submit" class="button-primary genesis-h2-button" value="<?php _e( 'Save Settings', 'novo' ) ?>" />
                <input type="submit" class="button genesis-h2-button" name="<?php echo ZP_SETTINGS_FIELD; ?>[reset]" value="<?php _e( 'Reset Settings', 'novo' ); ?>" onclick="return genesis_confirm('<?php echo esc_js( __( 'Are you sure you want to reset?', 'novo' ) ); ?>');" />
            </h2>
            
		<?php $latest_version = zp_theme_update_check(); ?>
		<?php if(($latest_version !== false) && ($latest_version > ZP_THEME_VERSION)): ?>
        
        	<div class="updated" id="message">
                <p><strong>A theme update is available. The latest version is <?php echo $latest_version; ?> and you are running <?php echo ZP_THEME_VERSION; ?></strong></p>
                <p>Please read <a href="http://demo.zigzagpress.com/How_to_update_zp_theme.txt" target="_blank">"How to Update Theme"</a> instructions to avoid conflicts with your current installation.</p>
                <p>View changelog for more details <a href="http://demo.zigzagpress.com/novo/changelog.txt" target="_blank">here</a>.</p>
                <p>You can download the latest version of the theme <a href="http://zigzagpress.com/" target="_blank">here</a>.</p>
            </div>
            
		<?php endif; ?>
			<div class="metabox-holder">
				<div class="postbox-container" style="<?php echo $width; ?>">
					<?php do_meta_boxes( $_zpsettings_settings_pagehook, 'main', null ); ?>
				</div>
			</div>
		</form>
     </div>

	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('<?php echo $_zpsettings_settings_pagehook; ?>');
		});
		//]]>
	</script>
<?php }
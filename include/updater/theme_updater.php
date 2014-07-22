<?php 
/* Get theme current version */
$theme_data = wp_get_theme();
$version = $theme_data['Version'];
if(!defined('ZP_THEME_VERSION')) 	define('ZP_THEME_VERSION', $version);

/* Check if curl is installed in the server */
if( !function_exists('is_curl_installed') ):
function is_curl_installed()	
{
	if( in_array('curl', get_loaded_extensions()) )
		return true;
	else
		return ;
}
endif;
if( !function_exists('zp_theme_update_check')):
function zp_theme_update_check()
{
	$versions_url =  'http://demo.zigzagpress.com/theme_version.json';	
	$update_period =  60;
	$transient_name = 'zptheme-update';
	//if( false === ( $latest_version = get_transient($transient_name) ) )
	//{
		if( is_curl_installed() )
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $versions_url);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$themes_versions = @curl_exec($ch);
			curl_close($ch);			
		}
		elseif(ini_get('allow_url_fopen')==true)
		{
			$themes_versions = @file_get_contents($versions_url);
		}
		else
		{
			return false;
		}

		if(empty($themes_versions)) {
			set_transient( $transient_name, -1, $update_period );
			return false;
		}
		
		$themes_versions = json_decode($themes_versions, true);
		if($themes_versions === NULL or $themes_versions === FALSE) {
			set_transient( $transient_name, -1, $update_period );
			return false;
		}
		if(!isset($themes_versions[CHILD_THEME_NAME])) {
			set_transient( $transient_name, -1, $update_period );
			return false;
		}
		$latest_version = $themes_versions[CHILD_THEME_NAME];
		
		set_transient( $transient_name, $latest_version, $update_period );
	//}
	
	return $latest_version;
}
endif;

?>
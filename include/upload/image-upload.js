// Script to Upload Image
jQuery.noConflict();
jQuery(document).ready(function(jQuery){
	
	//Upload Custom Logo
	var uploadID = '';
	var previewID = '';
	jQuery('#zp-settings\\[zp_logo_upload_button\\]').click(function() {
		uploadID = jQuery('#zp-settings\\[zp_logo\\]');
		previewID = jQuery('#upload_logo_preview img');
		tb_show('Upload a logo', 'media-upload.php?referer=zp-settings&amp;type=image&amp;TB_iframe=true&amp');
		return false;
	});
	
	window.send_to_editor = function(html) {

		var logo_url = jQuery('img',html).attr('src');
		
		uploadID.val(logo_url);
		previewID.attr('src',logo_url);

		tb_remove();
	
	}
	
	//Upload Custom Favicon
	var uploadID = '';
	var previewID = '';
	jQuery('#zp-settings\\[zp_favicon_upload_button\\]').click(function() {
		uploadID = jQuery('#zp-settings\\[zp_favicon\\]');
		previewID = jQuery('#upload_favicon_preview img');
		tb_show('Upload a Favicon', 'media-upload.php?referer=zp-settings&amp;type=image&amp;TB_iframe=true&amp');
		return false;
	});
	
	window.send_to_editor = function(html) {

		var favicon_url = jQuery('img',html).attr('src');

		uploadID.val(favicon_url);
		previewID.attr('src',favicon_url);
		//jQuery('#zp-settings\\[zp_favicon\\]').attr('value',favicon_url);
		tb_remove();
	
	}


	/*upload image portfolio page slider*/
	var uploadID = '';
	var previewID = '';
	jQuery('.image_button').click(function() {
		uploadID = jQuery(this).parent().children('.image_text');
		tb_show('Upload', 'media-upload.php?referer=zp-settings&amp;type=image&amp;TB_iframe=true&amp');
		return false;
	});
	
	window.send_to_editor = function(html) {

		var image_url = jQuery('img',html).attr('src');

		uploadID.val(image_url);
		tb_remove();
	}	
	
});
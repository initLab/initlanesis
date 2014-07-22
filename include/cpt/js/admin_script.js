// Script to Upload Image
jQuery.noConflict();
jQuery(document).ready(function(jQuery){
	 
	 jQuery('#audio-settings').hide();
	 jQuery('#link-settings').hide();
	 jQuery('#video-settings').hide();
	  
	jQuery('#post-formats-select > .post-format').each(function(i){
		if(jQuery(this).is(':checked')) {
			var val = jQuery(this).val();	
			
			jQuery('#'+val+'-settings').show();		
		}
		
	});
	
	
	jQuery('#post-formats-select > .post-format').click(function(){
			var val = jQuery(this).val();
			
			 jQuery('#audio-settings').hide();
			 jQuery('#link-settings').hide();
			 jQuery('#video-settings').hide();
			 
			 jQuery('#'+val+'-settings').show();	

	});
	
	
});
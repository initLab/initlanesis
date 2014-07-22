
function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else var expires = "";
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}
jQuery(document).ready(function($){
	
	jQuery('article .post_like .icon-heart').each(function(){	
		
	var classname = jQuery(this).attr('class');
	var id=classname.split(" ");		
	var ID = id[1];
	
	if(readCookie('Liked' + ID) == ID)
		{
			jQuery('.likes.'+ID).find('.icon-heart').addClass('liked');
			jQuery('.likes.'+ID+' .textLike').text(like_msg);
		}
	});

    function insert_like(ID){
     if(readCookie('Liked' + ID) != ID)
        {   
            var data = {
                "action" : "zp_insert_likes",
                "post_id" : ID
            };
            jQuery.post(ajax_url,data,function(data){
               
                jQuery('.likes.'+ID).children('.likes_value').text('('+data+')');
				jQuery('.likes.'+ID).animate({'opacity': 0}, 1000, function () {
					jQuery(this).children('.textLike').text(like_msg);
					jQuery(this).children('.icon-heart').addClass('liked');
				}).animate({'opacity': 1}, 1000);
            });

            createCookie('Liked' + ID,ID,365);
            



        }
    }
    jQuery('.icon-heart').click(function(){
		var classname = jQuery(this).attr('class');
		var id=classname.split(" ");
	
		insert_like(id[1]);
    });
	
	

	
});

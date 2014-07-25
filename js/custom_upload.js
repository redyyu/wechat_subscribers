jQuery(document).ready(function($) {
	
	$('.custom_media_upload').click(function() {
		wp.media.editor.add('custom_upload');
		
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        upload_ID =  $(button).prev('input');

        wp.media.editor.send.attachment = function(props, attachment) {
            $(button).prev('input').val(attachment['sizes'][props['size']]['url']);
            $(button).prev('input').trigger("change");
            wp.media.editor.send.attachment = send_attachment_bkp;
        }

       wp.media.editor.open('custom_upload');

	   wp.media.editor.get('custom_upload').on('escape', function(){
	      	//Do some stuff here
	    	wp.media.editor.send.attachment = send_attachment_bkp;
	    });
	    
        return false;
    });
    
});

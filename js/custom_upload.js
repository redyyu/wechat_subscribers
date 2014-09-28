jQuery(document).ready(function($) {
	
	$('.custom_media_upload').click(function() {
		wp.media.editor.add('custom_upload');
		
        var send_attachment_bkp = wp.media.editor.send.attachment;
		var send_insert_bkp = wp.media.editor.insert;
		
        var button = $(this);
        upload_ID =  $(button).prev('input');
		
        wp.media.editor.send.attachment = function(props, attachment) {

            $(button).prev('input').val(attachment['sizes'][props['size']]['url']);
            $(button).prev('input').trigger("change");
			
            wp.media.editor.send.attachment = send_attachment_bkp
        }

        wp.media.editor.insert = function(html) {
			
			var el = document.createElement("div");
			el.innerHTML = html;
			var imgs=el.getElementsByTagName("img");
            $(button).prev('input').val(imgs[0].src);
            $(button).prev('input').trigger("change");

			wp.media.editor.insert = send_insert_bkp;
        }

		wp.media.editor.open('custom_upload');

		wp.media.editor.get('custom_upload').on('escape', function(e){
			wp.media.editor.send.attachment = send_attachment_bkp;
			wp.media.editor.insert = send_insert_bkp;
		});
	    
        return false;
    });
    
});

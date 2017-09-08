jQuery(document).ready( function($) {
	// The "Upload" button
	//jQuery('.scw-image-upload-btn').click(function() {
	jQuery( "body" ).on( "click", ".scw-image-upload-btn", function(e) {
		e.preventDefault();
		
		var currentEditorPage = ( jQuery('body').hasClass('wp-customizer') ? 'wp-customizer':'wp-widgets');
		
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = jQuery(this);
		wp.media.editor.send.attachment = function(props, attachment) {
			jQuery(button).parent().prev().attr('src', attachment.url);
			//jQuery(button).prev().val(attachment.id);
			jQuery(button).prev().attr('value', attachment.url);
			wp.media.editor.send.attachment = send_attachment_bkp;
			
			if (currentEditorPage == "wp-customizer") {
				var widget_id = jQuery(button).closest('div.form').find('input.widget-id').val();
				var widget_form_control = wp.customize.Widgets.getWidgetFormControlForWidget( widget_id )
				widget_form_control.updateWidget();
			}
		}
		wp.media.editor.open(button);
		return false;
	});
	
	// The "Remove" button (remove the value from input type='hidden')
	//jQuery('.scw-image-remove-btn').click(function(event) {
	jQuery( "body" ).on( "click", ".scw-image-remove-btn", function(e) {
		e.preventDefault();
		var currentEditorPage = ( jQuery('body').hasClass('wp-customizer') ? 'wp-customizer':'wp-widgets');
		//var button = jQuery(this);
		var answer = confirm('Are you sure?');
		if (answer === true) {
			var src = jQuery(this).parent().prev().attr('data-src');
			jQuery(this).parent().prev().attr('src', src);
			jQuery(this).prev().prev().val('');
			
			if (currentEditorPage === "wp-customizer") {
				var widget_id = jQuery(this).closest('div.form').find('input.widget-id').val();
				var widget_form_control = wp.customize.Widgets.getWidgetFormControlForWidget( widget_id )
				widget_form_control.updateWidget();
			}
		}
		return false;
	});
});

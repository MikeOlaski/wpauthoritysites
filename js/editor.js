// JavaScript Document

jQuery(document).ready(function($) {
	
	$('#toplevel_page_wpauthorities, li#toplevel_page_wpauthorities > a').addClass('wp-has-current-submenu wp-menu-open').removeClass('wp-not-current-submenu');
	
	$('#awp-evaluate').click(function(e){
		
		// Ser preloader
		$(this).next('.preloader').show();
		
		console.log('Collecting data...');
		
		var url = $('#awp-awp-url').val();
		var id = $('#post_ID').val();
		
		if('' == url){
			url = 'http://' + $('#title').val();
		}
		
		var data = {
			action: 'evaluate_js',
			url: url,
			id: id
		};
		
		console.log('Posting variables...');
		
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(ajax_object.ajax_url, data, function(response) {
			console.log( 'response is ', response );
			
			if('true' == response){
				window.location.href = ajax_object.post_url + '?post=' + id + '&action=edit&message=1';
			} else {
				$(this).next('.preloader').hide();
				$(this).parent().append('<p style="color:#f00;">Error: Cannot run evaluator.</p>');
			}
		});
		
	});
	
});
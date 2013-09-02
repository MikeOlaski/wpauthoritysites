// JavaScript Document
jQuery(document).ready(function($) {
	
	var display;
    
	$('.wpa-display-controls li a.wpa-control').click(function(e) {
		display = $(this).attr('href').replace('#', '');
		$(this).addClass('current').parent().siblings().find('a.wpa-control').removeClass('current');
		$('.wpa-display-archives').toggleClass(function(){
			if('grid' == display){
				return 'list detail';
			} else if('list' == display) {
				return 'grid detail';
			} else if('detail' == display) {
				return 'list grid';
			}
		}, false).addClass( display );
        e.preventDefault();
    });
	
	$('#posts_per_page').change(function(){
		window.location.href = $(this).val();
	});
	
	var toggle = [];
	$('.wpa-screen-options input[type=checkbox]').each(function(i, e){
		$(this).change(function(){
			if( $(this).is(':checked') ){
				$( $(this).val() ).show();
			} else {
				$( $(this).val() ).hide();
			}
		});
	});
	
	jQuery.each(toggle, function(i,e){
		$(e).toggle('show');
	});
});
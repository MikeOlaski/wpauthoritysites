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
	
	$('.wpa-views').each(function(i,e) {
        $(this).click(function(e) {
            selector = $(this).attr('data-column');
			
			if( $(this).hasClass('') ){
				return;
			} else {
				$(this).addClass('current').parent().siblings().find('a.wpa-views').removeClass('current');
			}
			
			$('.metabox-prefs .hide-column-tog').each(function(i,e){
				$(this).removeAttr('checked');
			});
			
			$('th.manage-column').css('display','none');
			$('td').css('display','none');
			
			$('th#cb, th#title').css('display','table-cell');
			$('td.check-column, td.post-title').css('display','table-cell');
			
			switch(selector){
				case 'action':
					var fields = [
						'taxonomy-site-category',
						'taxonomy-site-tag',
						'site-action',
						'site-status',
						'site-include',
						'site-topic',
						'site-type',
						'site-location',
						'site-assignment',
						'rank',
						'date'
					];
					break;
				
				case 'site':
					var fields = [
						'awp-domain',
						'awp-tld',
						'awp-url',
						'awp-date',
						'awp-networked',
						'awp-location',
						'awp-language',
						'site-location'
					];
					break;
				
				case 'project':
					var fields = [
						'awp-founder',
						'awp-owner',
						'awp-publisher',
						'awp-producer',
						'awp-manager',
						'awp-developer',
						'awp-member'
					];
					break;
				
				case 'links':
					var fields = [
						'awp-google',
						'awp-alexa',
						'awp-yahoo',
						'awp-majestic'
					];
					break;
				
				case 'buzz':
					var fields = [
						'awp-shares-goolgeplus',
						'awp-shares-facebook',
						'awp-likes-facebook',
						'awp-shares-twitter',
						'awp-shares-pinterest',
						'awp-shares-linkedin'
					];
					break;
				
				case 'network':
					var fields = [
						'awp-googleplus',
						'awp-facebook',
						'awp-twitter',
						'awp-pinterest',
						'awp-linkedin'
					];
					break;
				
				case 'systems':
					var fields = [
						'awp-staff',
						'awp-automated-processes'
					];
					break;
				
				case 'ranks':
					var fields = [
						'awp-alexa-rank',
						'awp-google-rank',
						'awp-compete-rank',
						'awp-semrush-rank',
						'awp-one-rank'
					];
					break;
				
				case 'traffic':
					var fields = [
						'awp-unique-visitors',
						'awp-page-views',
						'awp-page-speed'
					];
					break;
				
				case 'engagement':
					var fields = [
						'awp-pages-per-visit',
						'awp-time-per-visit',
						'awp-comments-active',
						'awp-comment-system',
						'awp-comments-per-post',
						'awp-percent-longer-15',
						'awp-10-seconds-under-55'
					];
					break;
				
				case 'financials':
					var fields = [
						'awp-net-income',
						'awp-gross-revenue',
						'awp-trailing-12-months'
					];
					break;
				
				case 'valuation':
					var fields = [
						'awp-sale-value',
						'awp-sale-price',
						'awp-revenue-multiplier',
						'awp-income-multiplier',
						'awp-daily-worth',
						'awp-sale-url',
						'awp-sale-date',
						'awp-sale-type'
					];
					break;
				
				case 'content':
					var fields = [
						'awp-silos-number',
						'awp-silos-tag',
						'awp-rich-snippet-types',
						'awp-rich-snippets',
					];
					break;
				
				case 'development':
					var fields = [
						'awp-percent-customized',
						'awp-cost-to-build',
						'awp-cost-to-maintain'
					];
					break;
				
				case 'authors':
					var fields = [
						'awp-authors-number',
						'awp-bio-type',
						'awp-byline-type',
						'awp-author-page-type',
						'awp-profiles-number'
					];
					break;
				
				case 'brand':
					var fields = [
						'awp-brand-keywords'
					];
					break;
			}
			
			jQuery.each(fields, function(i,e){
				$('input[value='+ e +']').attr('checked','checked');
				$('th.manage-column#' + e).css('display', 'table-cell');
				$('td.' + e).css('display', 'table-cell');
			});
			
			e.preventDefault();
        });
    });
	
});
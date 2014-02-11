jQuery(document).ready(function($) {
	
	$('.compute_score_button').click(function(e) {
        if( $(this).hasClass('disabled') ){
			$(this).removeClass('disabled').siblings('.preloader').hide();
			return;
		} else {
			button = $(this);
			button.addClass('disabled').siblings('.preloader').show();
			
			var id = $('#post_ID').val();
			var field = button.siblings('input:first-child').attr('name');
			var input = $('input[name=' + field + ']');
			
			var data = {
				action: 'calculate_metric',
				id: id,
				field: field
			};
			
			jQuery.post(WPAJAX_OBJ.ajax_url, data, function(response) {
				if( response ){
					input.val( response );
					button.removeClass('disabled').siblings('.preloader').hide();
					button.parents('.awp-control-group').css('background-color','yellow').animate({backgroundColor:"#F8F8F8"},1000);
				}
				
				console.log( response );
			});
		}
		
		e.preventDefault();
    });
	
	$('.manual_update_button').click(function(e) {
		if( $(this).hasClass('disabled') ){
			$(this).removeClass('disabled').siblings('.preloader').hide();
			return;
		} else {
			button = $(this);
			button.addClass('disabled').siblings('.preloader').show();
			
			var id = $('#post_ID').val();
			var field = $( $(this).attr('data-field') ).attr('name');
			var value = $( $(this).attr('data-field') ).val();
			
			console.log( value );
			
			var data = {
				action: 'update_metric',
				id: id,
				field: field,
				value: value
			};
			
			jQuery.post(WPAJAX_OBJ.ajax_url, data, function(response) {
				if( response == 'true' ){
					button.removeClass('disabled').siblings('.preloader').hide();
					button.parents('.awp-control-group').css('background-color','yellow').animate({backgroundColor:"#F8F8F8"},1000);
				}
				
				console.log( response );
			});
		}
		
		e.preventDefault();
	});
	
	$('.run_audit_button').click(function(e) {
		if( $(this).hasClass('disabled') ){
			$(this).removeClass('disabled').siblings('.preloader').hide();
			return;
		} else {
			button = $(this);
			button.addClass('disabled').siblings('.preloader').show();
			
			var id = $('#post_ID').val();
			var url = $('#awp-awp-url').val();
			var field = button.siblings('input:first-child').attr('name');
			var input = $('input[name=' + field + ']');
			var value = input.val();
			
			if('' == url){ url = 'http://' + $('#title').val(); }
			
			console.log( 'current values are ', id, url, field, value );
			
			var data = {
				action: 'audit_metric',
				id: id,
				url: url,
				field: field,
				value: value
			};
			
			jQuery.post(WPAJAX_OBJ.ajax_url, data, function(response) {
				if( response != 'false' ){
					input.val( response );
					button.removeClass('disabled').siblings('.preloader').hide();
					button.parents('.awp-control-group').css('background-color','yellow').animate({backgroundColor:"#F8F8F8"},1000);
				}
				
				console.log(response);
			});
		}
    });
	
	$('#toplevel_page_wpauthorities, li#toplevel_page_wpauthorities > a').addClass('wp-has-current-submenu wp-menu-open').removeClass('wp-not-current-submenu');
	
	$('#awp-wp-checker').click(function(e) {
        // Set Preloader
		$(this).parents('ul').next('.preloader').show();
		console.log('Collecting data...');
		
		var url = $('#awp-awp-url').val();
		var id = $('#post_ID').val();
		if('' == url){
			url = 'http://' + $('#title').val();
		}
		
		var data = {
			action: 'wp_checker_js',
			check_link: url,
			id: id
		};
		
		console.log('Posting variables...');
		
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(WPAJAX_OBJ.ajax_url, data, function(response) {
			console.log( 'response is ', response );
			
			if('true' == response){
				window.location.href = WPAJAX_OBJ.post_url + '?post=' + id + '&action=edit&message=1';
			} else {
				$(this).next('.preloader').hide();
				$(this).parent().append('<p style="color:#f00;">Error: Cannot Check for Wordpress.</p>');
			}
		});
    });
	
	$('#awp-evaluate').click(function(e){
		var element = $(this);
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
		
		// Set preloader
		element.parents('ul').siblings('.preloader').show().siblings('p.error').text('');
		
		$.post(WPAJAX_OBJ.ajax_url, data, function(response) {
			if('true' == response){
				window.location.href = WPAJAX_OBJ.post_url + '?post=' + id + '&action=edit&message=1';
			} else {
				element.parents('ul').siblings('.preloader').hide().siblings('p.error').text(response);
			}
		});
	});
	
	$('.wpa-views').live('click', function(e) {
		selector = $(this).attr('data-column');
		changeViewGroups( $(this), selector );
		updateUserDefinedView( $(this) );
		e.preventDefault();
	});
	
	if(WPAJAX_OBJ.defined_view != ''){
		selector = WPAJAX_OBJ.defined_view;
		$this = $('a[data-column=' + WPAJAX_OBJ.defined_view + ']');
		
		if( !$this.hasClass('current') ){
			$this.addClass('current');
		}
		$('a.wpa-views').not($this).removeClass('current');
		
		changeViewGroups( $this, selector );
		updateUserDefinedView( $this );
	}
	
	function updateUserDefinedView( $view ){
		// before anything else make sure that screen options checkboxes are saved
		var iTeration = $('.hide-column-tog').length;
		var dfd=$.Deferred();
		var hidden;
		$i = 1;
		$('.hide-column-tog', '#adv-settings').each(function(i,e) {
            var $t = $(this);
			var column = $t.val();
			//if ( $t.prop('checked') ){
			
			console.log( $t.prop('checked') );
			
			if( $t.is(':checked') ){
				$('.column-' + column).show();
				diff = +1;
			} else {
				$('.column-' + column).hide();
				diff = -1;
			}
			
			var $table = $('table').find('.colspanchange'), n;
			if ( !$table.length ){
				//
			} else {
				n = parseInt( $table.attr('colspan'), 10 ) + diff;
				$table.attr('colspan', n.toString());
			}
			
			hidden = $('.manage-column').filter(':hidden').map(function(){
				return this.id;
			}).get().join(',');
			
			if( iTeration > $i ){
				dfd.resolve();
			}
			$i++;
		});
		
		$.when.apply($, dfd).done(function(){
			// Save our user defined view links option
			jQuery.post(WPAJAX_OBJ.ajax_url, {
					action: 'user_defined_view_groups',
					view: $view.attr('data-column')
				}, function(response) {
					
			});
			
			jQuery.post(WPAJAX_OBJ.ajax_url, {
				action: 'hidden-columns',
				hidden: hidden,
				screenoptionnonce: $('#screenoptionnonce').val(),
				page: pagenow
			}, function(a) {
				console.log( a );
			});
		});
        
	}
	
	function changeViewGroups( $this, selector ){
		if( $this.hasClass('') ){
			return;
		} else {
			$('a.wpa-views').not($this).removeClass('current');
			$this.addClass('current');
		}
		
		$('.metabox-prefs .hide-column-tog').each(function(i,e){
			$(this).attr('checked', false);
		});
		
		var fields = WPAJAX_OBJ.fields[selector];
		if( !fields ){ return; }
		
		/*switch(selector){
			case 'site':
				fields = [
					'awp-domain',
					'awp-tld',
					'awp-url',
					'awp-date',
					'awp-location',
					'awp-language'
				];
				break;
			
			case 'project':
				fields = [
					'awp-founder',
					'awp-owner',
					'awp-publisher',
					'awp-producer',
					'awp-manager',
					'awp-developer',
					'awp-editor',
					'awp-ceo'
				];
				break;
				
			case 'links':
				fields = [
					'awp-google',
					'awp-alexa',
					'awp-yahoo',
					'awp-majestic'
				];
				break;
				
			case 'social':
				fields = [
					'awp-shares-goolgeplus',
					'awp-shares-facebook',
					'awp-likes-facebook',
					'awp-shares-twitter',
					'awp-shares-pinterest',
					'awp-shares-linkedin'
				];
				break;
			
			case 'buzz':
				fields = [
					'awp-recent-comments',
					'awp-recent-post',
					'awp-recent-shares',
					'awp-klout-score'
				];
				break;
			
			case 'framework':
				fields = [
					'awp-plugins-paid',
					'awp-plugins-free',
					'awp-plugins-custom',
					'awp-functions-custom',
					'awp-theme-paid',
					'awp-theme-framework',
					'awp-theme-custom',
					'awp-services-facebook',
					'awp-services-twitter',
					'awp-services-google'
				];
				break;
			
			case 'community':
				fields = [
					'awp-facebook-followers',
					'awp-twitter-followers',
					'awp-youtube-followers',
					'awp-googleplus-followers',
					'awp-linkedin-followers',
					'awp-pinterest-followers',
					'awp-rss',
					'awp-email'
				];
				break;
			
			case 'authors':
				fields = [
					'awp-authors-number',
					'awp-bio-type',
					'awp-byline-type',
					'awp-author-page-type',
					'awp-author-paid',
					'awp-author-free',
					'awp-revenue-share',
					'awp-profiles-number'
				];
				break;
			
			case 'content':
				fields = [
					'awp-silos-number',
					'awp-rich-snippet-types',
					'awp-rich-snippets'
				];
				break;
			
			case 'products':
				fields = [
					'awp-brand-number'
				];
				break;
			
			case 'systems':
				fields = [
					'awp-system-content',
					'awp-system-marketing',
					'awp-system-sales',
					'awp-system-fulfilment',
					'awp-system-management'
				];
				break;
			
			case 'ranks':
				fields = [
					'awp-alexa-rank',
					'awp-google-rank',
					'awp-compete-rank',
					'awp-semrush-rank',
					'awp-one-rank'
				];
				break;
			
			case 'valuation':
				fields = [
					'awp-replacement-content',
					'awp-replacement-technology',
					'awp-replacement-community',
					'awp-trailing-12-months',
					'awp-net-income',
					'awp-cost-expense',
					'awp-last-valuation',
					'awp-revenue-multiplier',
					'awp-income-multiplier'
				];
				break;
			
			case 'scores':
				fields = [
					'awp-site-score',
					'awp-project-score',
					'awp-social-scores',
					'awp-buzz-score',
					'awp-framework-score',
					'awp-community-scores',
					'awp-authors-scores',
					'awp-content-scores',
					'awp-systems-score',
					'awp-ranks-scores',
					'awp-scores-score',
					'awp-valuation-score'
				];
				break;
			
			case 'action':
				fields = [
					'site-action',
					'site-status',
					'site-include',
					'site-topic',
					'site-type',
					'site-location',
					'site-assignment',
					'date'
				];
				break;
		}*/
		
		jQuery.each(fields, function(i,e){
			$('input[value='+ e +']').attr('checked','checked');
		});
	}
	
	$('#doaction, #doaction2').bind('click', function(e){
		if( $(this).siblings('select').val() == 'evaluate' ){
			$('#awp-popup').center();
			console.log('Collecting data');
			
			posts = $('input[name*=post]:checked').map(function(e){
                return $(this).val();
            }).get();
			
			if(posts == ''){
				console.log( 'Auditor is terminated' );
				$('#awp-popup .awp-popup-message').html('Audit unsuccessful!');
				$('#awp-popup').addClass('awp-popup-error').show('slow', '', function(){
					$('#awp-popup').center();
				});
				
				setTimeout(function(e){
					$('#awp-popup').hide('slow');
				}, 3000)
				return false;
			}
			
			var data = {
				action: 'bulk_evaluate',
				post: posts
			};
			
			console.log( 'Auditor Initializing' );
			$('#awp-popup').removeClass('awp-popup-error');
			$('#awp-popup .awp-popup-message').html('Initializing Auditor');
			$('#awp-popup').show('slow', '', function(){
				$('#awp-popup').center();
			});
			
			console.log('Auditor Running in Background');
			setTimeout(function(e){
				$('#awp-popup').removeClass('awp-popup-error');
				$('#awp-popup .awp-popup-message').html('Auditor Running in Background');
				$('#awp-popup').show('slow', '', function(){
					$('#awp-popup').center();
				});
			}, 3000);
			
			$.post(WPAJAX_OBJ.ajax_url, data, function(response) {
				console.log( 'response is ', response );
				if('true' == response){
					$('#awp-popup .awp-popup-message').html('Audit Successful!');
					$('#awp-popup').removeClass('awp-popup-error').center();
					setTimeout(function(e){
						window.location.href = WPAJAX_OBJ.manage_Screen + '&audited=' + posts.length;
					},1500);
				} else {
					setTimeout(function(e){
						$('#awp-popup').addClass('awp-popup-error').show();
						$('#awp-popup .awp-popup-message').html('Audit unsuccessful!');
						$('#awp-popup').show('slow', '', function(){
							$('#awp-popup').center();
						});
					}, 3000);
					
					setTimeout(function(e){
						$('#awp-popup').hide('slow');
					}, 6000);
				}
			});
			
			e.preventDefault();
			return false;
		}
	});
	
	$('.auditinline').click(function(e) {
		$('#awp-popup').center();
		console.log('Collecting data');
		
		posts = [$(this).attr('data-id')];
		
		if(posts == ''){
			console.log( 'Auditor is terminated' );
			$('#awp-popup .awp-popup-message').html('Audit unsuccessful!');
			$('#awp-popup').addClass('awp-popup-error').show('slow', '', function(){
				$('#awp-popup').center();
			});
			
			setTimeout(function(e){
				$('#awp-popup').hide('slow');
			}, 3000)
			return false;
		}
		
		var data = {
			action: 'bulk_evaluate',
			post: posts
		};
		
		console.log( 'Auditor Initializing' );
		$('#awp-popup').removeClass('awp-popup-error');
		$('#awp-popup .awp-popup-message').html('Initializing Auditor');
		$('#awp-popup').show('slow', '', function(){
			$('#awp-popup').center();
		});
		
		console.log('Auditor Running in Background');
		setTimeout(function(e){
			$('#awp-popup').removeClass('awp-popup-error');
			$('#awp-popup .awp-popup-message').html('Auditor Running in Background');
			$('#awp-popup').show('slow', '', function(){
				$('#awp-popup').center();
			});
		}, 3000);
		
		$.post(WPAJAX_OBJ.ajax_url, data, function(response) {
			console.log( 'response is ', response );
			if('true' == response){
				$('#awp-popup .awp-popup-message').html('Audit Successful!');
				$('#awp-popup').removeClass('awp-popup-error').center();
				setTimeout(function(e){
					window.location.href = WPAJAX_OBJ.manage_Screen + '&audited=' + posts.length;
				},1500);
			} else {
				setTimeout(function(e){
					$('#awp-popup').addClass('awp-popup-error').show();
					$('#awp-popup .awp-popup-message').html('Audit unsuccessful!');
					$('#awp-popup').show('slow', '', function(){
						$('#awp-popup').center();
					});
				}, 3000);
				
				setTimeout(function(e){
					$('#awp-popup').hide('slow');
				}, 6000);
			}
		});
		
        e.preventDefault();
		return false;
    });
	
	$('.wrap h2').after('<div id="awp-popup" class="awp-js-popup"><div class="awp-popup-message">Initializing Auditor</div></div>');
});

jQuery.fn.center = function($) {
	var w = jQuery(window);
	this.css({
		'position':'absolute',
		'top':Math.abs(((w.height() - this.outerHeight()) / 2)),
		'left':Math.abs(((w.width() - this.outerWidth()) / 2)),
		'margin-left' : ( 0 - this.outerWidth() / 2 )
	});
	return this;
}
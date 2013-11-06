// JavaScript Document
jQuery(document).ready(function($) {
	
	var display;
    
	$('.wpa-display-controls li a.wpa-control').click(function(e) {
		display = $(this).attr('href').replace('#', '');
		
		if('openSearch' == display || 'export' == display){
		} else {
			$(this).addClass('current').parent().siblings().find('a.wpa-control').removeClass('current');
			$('.wpa-display-archives').toggleClass(function(){
				if('grid' == display){
					return 'list detail line';
				} else if('list' == display) {
					return 'grid detail line';
				} else if('detail' == display) {
					return 'list grid line';
				} else if('line' == display){
					return 'list grid detail';
				}
			}, false).addClass( display );
			switch(display){
				case 'grid':
				case 'line':
					//$('.wpa-group-column').addClass('hide');
					$('.wpa-screen-options').addClass('hide');
					$('#wpa-thumbnail-option').removeAttr('disabled');
					setListScrollArea();
					break;
				
				case 'detail':
					//$('.wpa-group-column').addClass('hide');
					$('.wpa-screen-options').removeClass('hide');
					$('#wpa-thumbnail-option').removeAttr('disabled');
					setListScrollArea();
					break;
				
				case 'list':
					$('.wpa-screen-options').removeClass('hide');
					//$('.wpa-group-column').removeClass('hide');
					$('#wpa-thumbnail-option').attr('disabled', 'disabled');
					setListScrollArea();
					break;
			}
		}
		
		setListHeight();
        e.preventDefault();
    });
	
	$('body').click(function(e){
		var target = $(e.target).attr('class');
		
		if( target == 'wpa-control search' ){
			$('.wpa-screen-options').fadeToggle('fast');
			$('.wpa-filter-groups').fadeOut('fast');
			$('.wpa-export-options').fadeOut('fast');
		} else if( target == 'wpa-screen-options' ) {
			$('.wpa-filter-groups').fadeOut('fast');
			$('.wpa-export-options').fadeOut('fast');
		} else if( $(e.target).parents('.wpa-screen-options').length ) {
			$('.wpa-filter-groups').fadeOut('fast');
			$('.wpa-export-options').fadeOut('fast');
		} else if( target == 'wpa-control export' ) {
			$('.wpa-export-options').fadeToggle('fast');
			$('.wpa-screen-options').fadeOut('fast');
			$('.wpa-filter-groups').fadeOut('fast');
		} else if( target == 'wpa-export-options' ) {
			$('.wpa-screen-options').fadeOut('fast');
			$('.wpa-filter-groups').fadeOut('fast');
		} else if( $(e.target).parents('.wpa-export-options').length ) {
			$('.wpa-screen-options').fadeOut('fast');
			$('.wpa-filter-groups').fadeOut('fast'); 
		} else if( target == 'wpa-filterg-btn' ) {
			$('.wpa-export-options').fadeOut('fast');
			$('.wpa-screen-options').fadeOut('fast');
			$('.wpa-filter-groups').fadeToggle('fast');
		} else if( target == 'wpa-filter-groups' ) {
			$('.wpa-export-options').fadeOut('fast');
			$('.wpa-screen-options').fadeOut('fast');
		} else if( $(e.target).parents('.wpa-filter-groups').length ) {
			$('.wpa-export-options').fadeOut('fast');
			$('.wpa-screen-options').fadeOut('fast');
		} else {
			$('.wpa-filter-groups').fadeOut('fast');
			$('.wpa-screen-options').fadeOut('fast');
			$('.wpa-export-options').fadeOut('fast');
		}
	});
	
	$('#addFilterButton').click(function(e) {
        target = $('.wpa-filter-form');
		
		if( target.hasClass('hide') ){
			target.removeClass('hide');
		} else {
			$cloned = target.find('fieldset').eq(0).clone(false, false);
			$cloned.find('input[type=text]').val('');
			
			$('#wpa-filter-button').before( $cloned );
		}
		e.preventDefault();
    });
	
	$('.wpa-rating').each(function(i,e) {
        $(this).click(function(e) {
            if( $(this).hasClass('checked') && $(this).find('input').is(':checked') ){
				value = $(this).find('input').val();
				$(this).siblings().each(function(index, element) {
                    if( $(this).find('input').val() < value ){
						$(this).addClass('checked').find('input').attr('checked', true);
					} else {
						$(this).removeClass('checked').find('input').attr('checked', false);
					}
                });
				$(this).removeClass('checked').find('input').attr('checked', false);
			} else {
				value = $(this).find('input').val();
				$(this).siblings().each(function(index, element) {
                    if( $(this).find('input').val() < value ){
						$(this).addClass('checked').find('input').attr('checked', true);
					} else {
						$(this).removeClass('checked').find('input').attr('checked', false);
					}
                });
				$(this).addClass('checked').find('input').attr('checked', true);
			}
			e.preventDefault();
        });
    });
	
	$('#posts_per_page').change(function(){
		window.location.href = $(this).val();
	});
	
	var toggle = [];
	$('.wpa-screen-options input[type=checkbox]').each(function(i, e){
		$(this).change(function(){
			if( $(this).is(':checked') ){
				$( $(this).val() ).removeClass('hide');
			} else {
				$( $(this).val() ).addClass('hide');
			}
			
			setListScrollArea();
		});
		
		if( $(this).is(':checked') ){
			$( $(this).val() ).removeClass('hide');
		} else {
			$( $(this).val() ).addClass('hide');
		}
	});
	
	jQuery.each(toggle, function(i,e){
		$(e).toggle('show');
	});
	
	$('.wpa-group-column li a').each(function(i,e) {
		selector = $(this).attr('href');
		toggler = $(this).attr('data-inputs');
		
		if( $(this).parent().hasClass('current') ){
			$(selector).removeClass('hide');
			$(toggler).attr('checked', 'checked');
		}
		
        $(this).click(function(e) {
			selector = $(this).attr('href');
			toggler = $(this).attr('data-inputs');
			
			$('.wpa-col').addClass('hide');
			$('.ch-box').removeAttr('checked');
			
			if( $(this).parent().hasClass('current') ){
			} else {
				$(this).parent().addClass('current').siblings().removeClass('current');
				$(selector).removeClass('hide');
				$(toggler).attr('checked', 'checked');
			}
			setListHeight();
			setListScrollArea();
			e.preventDefault();
        });
    });
	
	$('.wpa-collapse-btn').click(function(e) {
        $(this).next('.wpa-collapse').slideToggle();
		$(this).find('span').toggle();
    });
	
	$('#wpa-taxonomy').change(function(e){
		var taxonomy = $(this).val();
		if(taxonomy === 0){
			$('#wpa-term').attr('disabled', 'disabled');
		} else {
			var data = {
				'action' : 'search_term',
				'taxonomy' : taxonomy
			};
			$.post(wpaObj.ajaxurl, data, function(response) {
				if(response){
					$('#wpa-term').removeAttr('disabled');
					$('#wpa-term option').remove();
					$('#wpa-term').append(response);
				} else {
					$('#wpa-term').attr('disabled', 'disabled');
				}
			});
		}
    });
	
	function setListHeight(){
		var highestCol;
		
		$('.wp-list-item').each(function(i,e) {
			highestCol = 0;
			
			$(this).find('.wpa-td:not(.hide)').each(function(i, e) {
				$(this).height('auto');
                highestCol = Math.max( highestCol, $(this).height() );
            });
			
			$(this).find('.wpa-td:not(.hide)').each(function(i,e) {
                $(this).height( highestCol );
            });
        });
	}
	
	function setListScrollArea(){
		var widestCol = 0;
		$('.wpa-list-header .wpa-th:not(.hide)').each(function(e){
			$(this).css('width', '100%');
			
			widestCol += $(this).outerWidth();
			console.log( $(this).outerWidth() );
			
			$(this).css('width', '');
		});
		
		if( widestCol < $('.wpa-site-wrapper').outerWidth() ){
			widestCol = '100%';
		}
		
		if( $('.wpa-display-archives').hasClass('list') ){
			$('.wpa-list-header, .post').css('width', widestCol);
		} else {
			$('.wpa-list-header, .post').css('width', '');
		}
	}
	
	setListHeight();
	
	if( $.fn.colorbox ){
		$('a.cboxElement[rel=inline]').colorbox({
			inline: true,
			width: '75%'
		});
	}
	
	if( $('#wpa-scores').length > 0 ){
		$('#wpa-scores').tabs();
	}
});
// JavaScript Document
jQuery(document).ready(function($) {
	
	var display;
	$('.wpa-display-controls .grid, .wpa-display-controls .detail, .wpa-display-controls .list').click(function(e) {
		display = $(this).attr('href').replace('#', '');
		
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
				$('.wpa-group-column').addClass('hide');
				$('#wpa-thumbnail-option').removeAttr('disabled');
				setListScrollArea();
				break;
			
			case 'detail':
				$('.wpa-group-column').addClass('hide');
				$('#wpa-thumbnail-option').removeAttr('disabled');
				setListScrollArea();
				break;
			
			case 'list':
				$('.wpa-group-column').removeClass('hide');
				$('#wpa-thumbnail-option').attr('disabled', 'disabled');
				setListScrollArea();
				break;
		}
		
		setListHeight();
		e.preventDefault();
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
				$('.wpa-group-column li').not($(this).parent()).removeClass('current');
				$(this).parent().addClass('current'); // .siblings().removeClass('current');
				$(selector).removeClass('hide');
				$(toggler).attr('checked', 'checked');
			}
			setListHeight();
			setListScrollArea();
			e.preventDefault();
        });
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
		
		$(".wpa-watch-button, .wpas-watch-btn, .wpas-claim-btn").colorbox({inline:true, href:$(this).attr('href')});
	}
	
	$('.wpa-grid-item .entry-title > a').click(function(e) {
        $(this).parents('.entry-header').siblings('.entry-summary').toggle('show');
		e.preventDefault();
    });
	
	$('.wpas-detail-more').click(function(e) {
		if( $(this).hasClass('less') ){
			$(this).removeClass('less').parents('.wpa-detail-item').animate({'height':250},200);
		} else {
			$(this).addClass('less').parents('.wpa-detail-item').animate({ height : '100%' },200);
		}
    });
	
	$('a.wpas-score-tabs-prev').click(function(e) {
		step = $('.wpas-metric-groups-tab li:first-child').outerWidth();
		marginLleft = parseInt($('.wpas-metric-groups-tab').css('margin-left')) + parseInt(step);
        $('.wpas-metric-groups-tab').css('margin-left', (marginLleft > 0) ? 0 : marginLleft );
		e.preventDefault();
    });
	
	$('a.wpas-score-tabs-next').click(function(e) {
		offset = Math.floor( $('.wpas-metric-groups-tab').parent('div').outerWidth() - $('.wpas-metric-groups-tab').outerWidth() );
		step = $('.wpas-metric-groups-tab li:first-child').outerWidth();
		marginLleft = parseInt($('.wpas-metric-groups-tab').css('margin-left')) - parseInt(step);
        $('.wpas-metric-groups-tab').css('margin-left', (marginLleft < offset) ? offset : marginLleft );
		e.preventDefault();
    });
	
	$('.wpa-display-controls .search').qtip({
		hide: { when: { event: 'click' } },
		show: { when: { event: 'click' } },
		content: $('.wpa-screen-options'),
		position: {
			corner: { target: 'leftMiddle', tooltip: 'topRight' }
		},
		style: { name: 'blue', width: 960 }
	});
	
	$('.wpa-display-controls .export').qtip({
		hide: { when: { event: 'click' } },
		show: { when: { event: 'click' } },
		content: $('.wpa-export-options'),
		position: {
			corner: { target: 'leftMiddle', tooltip: 'topRight' }
		},
		style: { name: 'blue', width: 180 }
	});
	
	$('.single-site .wpas-social-subscribers li').each(function(){
		$(this).qtip({
			content: $(this).find('.hover'),
			position: {
				/*corner: { target: 'leftMiddle', tooltip: 'bottomRight' },*/
				target: 'mouse', adjust: { mouse: true }
			},
			hide: { fixed: true },
			style: { background: 'none', name: 'light', border: { width: 0 } }
		});
	});
	
	$('.wpa-control, .filterButtons a').each(function(){
		$(this).qtip({
			content: $(this).attr('data-title'),
			position: { target: 'mouse', adjust: { mouse: true } },
			hide: { fixed: true },
			style: { name: 'blue' }
		});
	});
	
	$('.single-site .wpas-site-team li').each(function(){
		$(this).qtip({
			content: $(this).find('.wpas-people-places'),
			position: { corner: { target: 'bottomMiddle', tooltip: 'topMiddle' } },
			hide: { fixed: true },
			style: { background: 'none', width: 260, name: 'light', border: { width: 0 } }
		});
	});
	
	$('.sites-subscription').each(function(){
		$(this).qtip({
			content: $(this).find('.socials'),
			position: { corner: { target: 'leftMiddle', tooltip: 'rightMiddle' } },
			hide: { fixed: true },
			style: { background: 'none', width: 70, name: 'light', border: { width: 0 } }
		});
	});
});
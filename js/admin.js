// JS Document

jQuery(document).ready(function($) {
	/*$('#addNewMetric').click(function(e) {
        $('.new-metric-wrapper').show();
    });*/
	
	$('a.submitdelete').each(function(i,e) {
        $(this).click(function(e) {
            if( confirm("Are you sure you want to delete this item?") ){
				return true;
			}
			return false;
        });
    });
	
	$('#wpa_metrics_type').change(function(e){
		var val = $(this).val();
		if('select' == val || 'radio' == val || 'checkbox2' == val){
			$('#wpa-options-row').css('display', 'table-row');
		} else {
			$('#wpa-options-row').css('display', 'none');
		}
	});
	
	// Clean admin nav menu items
	var base = $('#adminmenu li#menu-posts-site ul.wp-submenu');
	var target = $('#adminmenu li#menu-posts-site li a[href*="javascript"]').parent('li');
	var subsubmenu = jQuery('<ul/>', {
		id: 'menu-tags-site',
		class: 'wp-submenu wp-submenu-wrap'
	});
	$('#adminmenu li#menu-posts-site ul.wp-submenu li').each(function(i,e) {
		var achr = $(this).find('a[href*="edit-tags.php"]');
		if( achr.text() != '' ){
			$(this).appendTo( subsubmenu );
		}
		
		if( achr.hasClass('current') ){
			target.addClass('current').find('a').addClass('current');
		}
    });
	base.addClass('base-menu-site');
	target.addClass('menu-tags-site');
	subsubmenu.appendTo(target);
	
	if( $('#has_custom_row').length > 0 ){
		$('#has_custom_row').change(function(e) {
			if( $(this).is(':checked') ){
				$('tr.csv_cutom_row').show();
			} else {
				$('tr.csv_cutom_row').hide();
			}
        });
	}
});
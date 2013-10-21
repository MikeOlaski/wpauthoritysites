jQuery(document).ready(function($){
	jQuery( "#bb_sortable" ).sortable({
		placeholder: "ui-state-highlight"
	});
	
	jQuery( ".ui-form-slider" ).slider({
		value: 0,
		min: 0,
		max: 100,
		step: 1,
		slide: function(event, ui){ slideChange( $(this), event, ui ); },
		change: function(event, ui){ slideChange( $(this), event, ui ); }
    });
	
	function slideChange( $this, event, ui ) {
		$this.siblings('input.ui-text-field').val( ui.value + "%" );
		Avg = updateAvgScale();
		
		$( ".ui-form-slider" ).each(function(i, e) {
			if(Avg == 100){
				if( $(this).slider("option", "value") === 0 ){
					$(this).slider( "disable" ).siblings('input.ui-text-field').attr('readonly', true);
				}
			} else if(Avg > 100){
				topDeptsCount = countActiveSlider( $this );
				resultOfMod = Avg % 100;
				resultOfDeduct = Math.round(resultOfMod / topDeptsCount);
				
				if( $(this).slider("option", "value") === 0 ){
					$(this).slider( "disable" ).siblings('input.ui-text-field').attr('readonly', true);
				} else {
					value = parseInt($(this).slider("option", "value") - resultOfDeduct);
					$(this).slider({ value: value });
				}
			} else {
				$(this).slider( "enable" ).siblings('input.ui-text-field').removeAttr('readonly');
			}
			Avg = updateAvgScale();
		});
		
		/*if(Avg == 100){
			$( ".ui-form-slider" ).each(function(i, e) {
				if( $(this).slider("option", "value") === 0 ){
					$(this).slider( "disable" ).siblings('input.ui-text-field').attr('readonly', true);
				}
			});
		} else if(Avg > 100){
			topDeptsCount = countActiveSlider( $this );
			resultOfMod = Avg % 100;
			resultOfDeduct = Math.round(resultOfMod / topDeptsCount);
			
			$( ".ui-form-slider" ).each(function(i, e) {
				if( $(this).slider("option", "value") === 0 ){
					$(this).slider( "disable" ).siblings('input.ui-text-field').attr('readonly', true);
				} else {
					value = parseInt($(this).slider("option", "value") - resultOfDeduct);
					$(this).slider({ value: value });
				}
			});
			
		} else {
			$( ".ui-form-slider" ).each(function(i, e) {
				$(this).slider( "enable" ).siblings('input.ui-text-field').removeAttr('readonly');
			});
		}*/
	}
	
	function countActiveSlider( $this ){
		ActiveSlider = 0;
		$( ".ui-form-slider" ).not( $this ).each(function(i, e) {
			if( $(this).slider("option", "value") > 0 ){
				ActiveSlider++;
			}
		});
		return ActiveSlider;
	}
	
	var scale = 0;
	jQuery('input.ui-text-field').each(function(i,e){
		$(this).on('change blur keyup', function(e){
			scale = $(this).val().replace("%", "");
			if(scale <= 100){
				$(this).siblings('.ui-form-slider').slider({
					value: $(this).val().replace("%", "")
				});
			} else {
				$(this).val( 100 + "%" ).trigger('change');
			}
			
			updateAvgScale();
		});
		
		$(this).on('change',function(e){
			if( $(this).val().indexOf('%') == -1 ){
				$(this).val( scale + "%" );
			}
		})
	});
	
	$('.ui-remove-button').live('click', function(e){
		if (confirm('Are you sure you want to remove this item?')) {
			$(this).parent('li').addClass('removed').hide(500, function(){
				jQuery(this).remove();
			});
		}
		updateAvgScale();
		slideChange( $( ".ui-form-slider li:first-child" ), '', '' );
		e.preventDefault();
	});
	
	// Add button
	$('.ui-add-button').click(function(e) {
        $(this).next('#extra-depts').slideToggle(500);
		e.preventDefault();
    });
	
	// Add label linked
	$('.ui-linked-label').each(function(i,e) {
        $(this).click(function(e) {
			bb_Id = $(this).children('input').val();
			bb_label = $(this).text();
			
			if( checkDupeDept( bb_Id ) ){
				addNewDept(bb_Id, bb_label);
			}
			updateAvgScale();
        });
    });
	
	function addNewDept(bb_Id, bb_label){
		$('ul#bb_sortable').append(
			jQuery('<li />', {
				class : 'ui-state-default ' + bb_Id
			}).append(
				jQuery('<span />', {
					class : 'hand'
				}).append(bb_label),
				jQuery('<label />', {
					class : 'hide',
					for : bb_Id
				}).append(bb_label),
				jQuery('<div />',{
					class : 'ui-form-slider',
					id : bb_Id + '-ui-slider'
				}).slider({
					value: 0,
					min: 0,
					max: 100,
					step: 1,
					slide: function(event, ui){ slideChange( $(this), event, ui ); },
					change: function(event, ui){ slideChange( $(this), event, ui ); }
				}),
				jQuery('<input />', {
					name : 'departments[' + bb_Id + ']',
					class : 'ui-text-field',
					type : 'text',
					id : bb_Id + '-ui-id',
					style : 'border: 0; color: #f6931f; font-weight: bold;',
					value : '0%'
				}),
				jQuery('<a />',{
					class : 'ui-remove-button',
					href : ''
				}).append('Remove Department'),
				jQuery('<div />',{
					class : 'clear'
				})
			)
		);
		slideChange( $( ".ui-form-slider li:first-child" ), '', '' );
	}
	
	function checkDupeDept( department ){
		if( $('ul#bb_sortable li.' + department ).length > 0 ){
			return false;
        };
		return true;
	}
	
	function updateAvgScale(){
		var topDepts;
		var topDeptsCount;
		var totalScale;
		var Avg;
		
		topDepts = jQuery( "#bb_sortable li:not(.removed)" );
		topDeptsCount = topDepts.length;
		totalScale = 0;
		Avg = 0;
		
		if(topDeptsCount > 0){
			topDepts.each(function(i,e) {
                totalScale += parseInt( $(this).find('input.ui-text-field').val().replace("%", "") );
            });
		}
		
		Avg = totalScale; /// topDeptsCount;
		
		$('.ui-total-field').val( Avg + "%" );
		
		return Avg;
	}
	
	// Auto Complete Custom departments
	var arrProducts = [];
	$.each(bbObj, function(i, d) {
		var dept = {};
		dept['value'] = d;
		
		arrProducts.push(dept);
	});
	$('#other-depts').autocomplete({
		source: arrProducts
    });
	
	// Keypress (Enter) Event in custom department
	$('#other-depts').bind('keypress keydown keyup', function(e){
		if(e.keyCode == 13) {
			bb_label = $(this).val();
			bb_Id = bb_label.replace(' ', '-').toLowerCase();
			
			if(bb_label.length > 0 && checkDupeDept( bb_Id )){
				addNewDept(bb_Id, bb_label);
			}
			
			updateAvgScale();
			e.preventDefault();
		}
    });
	
	updateAvgScale();
});
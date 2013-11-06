jQuery(document).ready(function($){
	jQuery( "#bb_dept_templates" ).sortable({
		placeholder: "ui-state-highlight",
		forcePlaceholderSize: true,
		connectWith: "ul"
	});
	
	jQuery( "#bb_sortable" ).sortable({
		placeholder: "ui-state-highlight",
		forcePlaceholderSize: true,
		dropOnEmpty: false
	});
	
	jQuery( "#bb_dept_templates, #bb_sortable" ).disableSelection();
	
	jQuery( ".ui-form-slider" ).slider({
		value: 0,
		min: 0,
		max: 100,
		step: 1,
		slide: function(event, ui){ slideChange( $(this), event, ui ); },
		change: function(event, ui){ slideChange( $(this), event, ui ); }
    });
	
	function slideChange( $this, event, ui ) {
		
		if(ui == ''){
			ui = { value: $this.slider("value") };
		}
		
		$this.siblings('input.ui-text-field').val( ui.value + "%" );
		
		Avg = updateAvgScale( $this );
		
		if($this == ''){
			return;
		} else if($this.hasClass('value_scale')) {
			friends = '.value_scale';
		} else if($this.hasClass('work_scale')) {
			friends = '.work_scale';
		} else if($this.hasClass('influence_scale')) {
			friends = '.influence_scale';
		}
		
		$( ".ui-form-slider" + friends ).each(function(i, e) {
			if(Avg == 100){
				if( $(this).slider("option", "value") === 0 ){
					$(this).slider("disable").siblings('input.ui-text-field').attr('readonly', true);
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
			Avg = updateAvgScale($this);
		});
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
			
			updateAvgScale($(this));
		});
		
		$(this).on('change',function(e){
			if( $(this).val().indexOf('%') == -1 ){
				$(this).val( scale + "%" );
			}
		})
	});
	
	$('.ui-remove-button').live('click', function(e){
		if (confirm('Are you sure you want to remove this item?')) {
			$(this).parent().parent().addClass('removed').hide(500, function(){
				jQuery(this).remove();
			});
		}
		
		updateAvgScale(false);
		
		$( "#bb_sortable li .ui-form-slider" ).each(function(index, element) {
            slideChange( $(this), '', '' );
        });
		
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
			updateAvgScale(false);
        });
    });
	
	function addNewDept(bb_Id, bb_label){
		$('ul#bb_sortable').append(
			jQuery('<li />', {
				class : 'ui-state-default ' + bb_Id
			}).append(
				jQuery('<div />').append(
					jQuery('<span />', {
						class : 'hand'
					}).append(bb_label),
					jQuery('<label />', {
						class : 'hide',
						for : bb_Id
					}).append(bb_label),
					jQuery('<div />',{
						class: 'alignleft wpa-column'
					}).append(
						jQuery('<div />',{
							class : 'value_scale ui-form-slider',
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
							name : 'departments[value][' + bb_Id + ']',
							class : 'value_scale ui-text-field',
							type : 'text',
							id : bb_Id + '-ui-id',
							style : 'border: 0; color: #f6931f; font-weight: bold;',
							value : '0%'
						})
					),
					jQuery('<div />',{
						class: 'alignleft wpa-column'
					}).append(
						jQuery('<div />',{
							class : 'work_scale ui-form-slider',
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
							name : 'departments[work][' + bb_Id + ']',
							class : 'work_scale ui-text-field',
							type : 'text',
							id : bb_Id + '-ui-id',
							style : 'border: 0; color: #f6931f; font-weight: bold;',
							value : '0%'
						})
					),
					jQuery('<div />',{
						class: 'alignleft wpa-column'
					}).append(
						jQuery('<div />',{
							class : 'influence_scale ui-form-slider',
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
							name : 'departments[influence][' + bb_Id + ']',
							class : 'influence_scale ui-text-field',
							type : 'text',
							id : bb_Id + '-ui-id',
							style : 'border: 0; color: #f6931f; font-weight: bold;',
							value : '0%'
						})
					),
					jQuery('<a />',{
						class : 'ui-remove-button',
						href : ''
					}).append('Remove Department'),
					jQuery('<div />',{
						class : 'clear'
					})
				)
			)
		);
		$( "#bb_sortable li .ui-form-slider" ).each(function(index, element) {
            slideChange( $(this), '', '' );
        });
	}
	
	function checkDupeDept( department ){
		if( $('ul#bb_sortable li.' + department ).length > 0 ){
			return false;
        };
		return true;
	}
	
	function updateAvgScale( element ){
		if( !element ){
			updateAvgScale( $('input.value_scale:first-child') );
			updateAvgScale( $('input.work_scale:first-child') );
			updateAvgScale( $('input.influence_scale:first-child') );
			
			return;
		}
		
		var topDepts;
		var topDeptsCount;
		var totalScale;
		var Avg;
		
		if(element.hasClass('value_scale')) {
			target = $('.ui-total-field[name=total_value_scale]');
			scaleCounts = 'input.ui-text-field.value_scale';
		} else if(element.hasClass('work_scale')) {
			target = $('.ui-total-field[name=total_work_scale]');
			scaleCounts = 'input.ui-text-field.work_scale';
		} else if(element.hasClass('influence_scale')) {
			target = $('.ui-total-field[name=total_influence_scale]');
			scaleCounts = 'input.ui-text-field.influence_scale';
		} else {
			return;
		}
		
		topDepts = jQuery( "#bb_sortable li:not(.removed)" );
		topDeptsCount = topDepts.length;
		totalScale = 0;
		Avg = 0;
		
		if(topDeptsCount > 0){
			topDepts.each(function(i,e) {
                totalScale += parseInt( $(this).find( scaleCounts ).val().replace("%", "") );
            });
		}
		
		Avg = totalScale; /// topDeptsCount;
		target.val( Avg + "%" );
		return Avg;
	}
	
	/*Auto Complete Custom departments*/
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
			
			$(this).val('');
			
			updateAvgScale(false);
			e.preventDefault();
		}
    });
	
	updateAvgScale(false);
	
	$('input[name=survey_taker_btn').click(function(e){
		$('#wpa_help_popup').fadeIn(100, '', function(e){
			$(this).center();
		});
		
		e.preventDefault();
	});
	
	$('a#cancel_submit').click(function(e) {
        $('#wpa_help_popup').fadeOut(100, '', function(e){
			$(this).center();
		});
		
		e.preventDefault();
    });
	
	$('a#submit_survey').click(function(e){
		
		// STEP 1: Watch the video
		
		// STEP 2: Create the people/user CPT
		/*var data = {
			action: 'submit_people',
			first_name: $('#survey_fname').val(),
			last_name: $('#survey_lname').val(),
			email: $('#survey_email').val(),
			role: $('#survey_role').val()
		};
		
		$.post(wpaObj.ajaxurl, data, function(response) {
			if( response == 'true' ){
				$('#survey_fname').val('');
				$('#survey_lname').val('');
				$('#survey_email').val('');
				$('#survey_role').val('');
			} else {
				alert( response );
			}
		});*/
		
		// STEP 3: Get the survey data and scores
		var survey = {
			action: 'submit_departments',
			departments: $('form[name=bb_builder_form]').serialize()
		};
		
		$('form[name=bb_builder_form]').submit();
		
		$('#wpa_help_popup').center();
		$('#wpa_help_popup').fadeOut(100, '', function(e){
			$(this).center();
		});
		
		e.preventDefault();
	});
	
	jQuery(window).scroll(function() {
		jQuery('#wpa_help_popup').center();
	});
});

(function($){
	$.fn.extend({
		center: function () {
			return this.each(function() {
				var top = ($(window).height() - $(this).outerHeight()) / 2;
				var left = ($(window).width() - $(this).outerWidth()) / 2;
				top += document.body.scrollTop;
				
				$(this).css({
					position: 'absolute',
					'margin-top': 0 - ($(this).height() / 2),
					'margin-left': 0 - ($(this).width() / 2),
					top: (top > 0 ? top : 0)+'px',
					left: (left > 0 ? left : 0)+'px'
				});
			});
		}
	}); 
})(jQuery);
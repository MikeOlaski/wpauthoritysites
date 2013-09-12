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
});
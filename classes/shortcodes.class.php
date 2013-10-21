<?php
/*
 * Shortcode scripts
 */

add_action('init', 'bb_builder_callback');
function bb_builder_callback(){
	$bb_departments = get_option('bb_departments');
	
	if( isset($_POST['bb_builder_callback']) && $_POST['bb_builder_callback'] == 'true'){
		foreach($_POST as $key=>$val){
			$$key = $val;
		}
		
		foreach($departments as $dept=>$score){
			$bb_departments[$dept] = ucwords(str_replace('-', ' ', $dept));
		}
		
		update_option('bb_departments', $bb_departments);
		
		wp_die( '<pre>' . print_r($_POST, true) . '</pre>' );
	}
	
	return;
}

add_shortcode('business_builder', 'shortcode_bbuilder_callback');
function shortcode_bbuilder_callback( $atts, $content = null ){
	$bb_departments = get_option('bb_departments');
	
	$departments = array(
		'project-business' => 'Project Business',
		'discovery' => 'Discovery',
		'operations' => 'Operations',
		'technology' => 'Technology',
		'content' => 'Content',
		'marketing' => 'Marketing',
		'sales' => 'Sales',
		'service' => 'Service',
		'production' => 'Production',
		'management' => 'Management'
	);
	
	$extras = array();
	if($bb_departments){
		foreach($bb_departments as $key=>$val){
			if( !isset($departments[$key]) )
				$extras[$key] = $val;
		}
	}
	
	wp_register_script('jquery-ui-custom', 'http://code.jquery.com/ui/1.10.3/jquery-ui.js');
	wp_register_script('bb_builder', PLUGINURL . 'js/bb_builder.js', array('jquery-ui-custom', 'jquery-ui-widget'));
	wp_enqueue_style('jquery-ui-theme', PLUGINURL . 'css/jquery-ui.css');
	wp_enqueue_style('bb_builder', PLUGINURL . 'css/bb_builder.css');
	wp_enqueue_script('bb_builder');
	
	wp_localize_script('bb_builder', 'bbObj', $extras);
	
	$html = '';
	
	$html .= "<div class=\"bb_builder\">";
	$html .= do_shortcode($content);
	$html .= "\t<form name=\"bb_builder_form\" action=\"\" method=\"post\">";
	$html .= "\t\t<ul id=\"bb_sortable\">";
	
	foreach($departments as $bb_id=>$dept){
		$html .= "\t\t\t<li class=\"ui-state-default " . $bb_id . "\">";
		
		$html .= "\t\t\t\t<span class=\"hand\">" . $dept . "</span>";
		$html .= "\t\t\t\t<label class=\"hide\" for=\"" . $bb_id . "-ui-id\">" . $dept . "</label>";
		$html .= "\t\t\t\t<div class=\"ui-form-slider\" id=\"" . $bb_id . "-ui-slider\"></div>";
		$html .= "\t\t\t\t<input name=\"departments[" . $bb_id . "]\" class=\"ui-text-field\" type=\"text\" id=\"" . $bb_id . "-ui-id\" style=\"border: 0; color: #f6931f; font-weight: bold;\" value=\"0%\" />";
		$html .= "\t\t\t\t<a class=\"ui-remove-button\" href=\"\">Remove Department</a>";
		
		$html .= "\t\t\t\t<div class=\"clear\"></div>";
		
		$html .= "\t\t\t</li>";
	}
	
	$html .= "\t\t</ul>";
	
	$html .= "\t\t\t<div class=\"ui-check-dept\" id=\"ui-more-dept\">";
	$html .= "\t\t\t\t<a class=\"ui-add-button\" href=\"\">Add Departments</a>";
	
	// More Depts
	$html .= "\t\t\t\t<div id=\"extra-depts\" style=\"display:none;\">";
	// Checkboxes
	$i = 1;
	foreach($extras as $id=>$label){
		if($i <= 5){
			$html .= "\t\t\t\t<label class=\"ui-linked-label\" for=\"" . $id . "\"><input type=\"hidden\" id=\"" . $id . "\" value=\"" . $id . "\" />" . $label . "</label>";
		}
		$i++;
	}
	// Other fields (Text Field)
	$html .= "\t\t\t\t<label for=\"other-depts\">Other:<input type=\"text\" id=\"other-depts\" /></label>";
	
	$html .= "\t\t\t\t</div>";
	$html .= "\t\t\t</div>";
	
	$html .= "\t\t<p class=\"ui-form-footer alignright\">";
	$html .= "\t\t\t<label for=\"total_scale\">Total</label>";
	$html .= "\t\t\t<input name=\"total_scale\" type=\"text\" id=\"total_scale\" class=\"ui-total-field\" value=\"0%\" readonly=\"readonly\" />";
	$html .= "\t\t</p>";
	
	$html .= "\t\t<input type=\"hidden\" name=\"bb_builder_callback\" value=\"true\" />";
	$html .= "\t\t<input type=\"submit\" name=\"ui-form-submit\" value=\"Submit\" />";
	
    $html .= "\t</form>";
	$html .= "</div>";
	
	$content = apply_filters('business_builder_content', $html);
	
	return $content;
}
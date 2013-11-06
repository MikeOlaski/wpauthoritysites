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
	
	$departments = array();
	$extras = array();
	$deptObj = get_posts(array(
		'posts_per_page' => '20',
		'post_type' => 'department'
		/*'orderby' => 'meta_value_num',
		'meta_key' => 'department_score'*/
	));
	
	$i = 1;
	foreach($deptObj as $dep){
		if($i <= 10){
			$departments[$dep->post_name] = $dep->post_title;
		} else {
			$extras[$dep->post_name] = $dep->post_title;
		}
		$i++;
	}
	
	/* $departments = array(
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
	
	if($bb_departments){
		foreach($bb_departments as $key=>$val){
			if( !isset($departments[$key]) )
				$extras[$key] = $val;
		}
	} */
	
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
	
	$html .= "\t\t<div class=\"bb_headers\">";
		$html .= "\t\t\t<span class=\"head order\">Order</span>";
		$html .= "\t\t\t<span class=\"head department\">Department</span>";
		$html .= "\t\t\t<span class=\"head project\">Value %</span>";
		$html .= "\t\t\t<span class=\"head value\">Work %</span>";
		$html .= "\t\t\t<span class=\"head influence\">Influence %</span>";
		$html .= "\t\t\t<div class=\"clear\"></div>";
	$html .= "</div>";
	
	$html .= "\t\t<ul id=\"bb_sortable\">";
	
	foreach($departments as $bb_id=>$dept){
		$html .= "\t\t\t<li class=\"ui-state-default " . $bb_id . "\"><div>";
		
		$html .= "\t\t\t\t<span class=\"hand\">" . $dept;
		$html .= "\t\t\t\t\t<i class=\"wpa_info_icon\" title=\"A description of this Department\"></i>";
		$html .= "\t\t\t\t</span>";
		// $html .= "\t\t\t\t<label class=\"hide\" for=\"" . $bb_id . "-ui-id\">" . $dept . "</label>";
		
		// Value
		$html .= "\t\t\t\t<div class=\"alignleft wpa-column\">";
		$html .= "\t\t\t\t<div class=\"value_scale ui-form-slider\" id=\"" . $bb_id . "-ui-slider\"></div>";
		$html .= "\t\t\t\t<input name=\"departments[value][" . $bb_id . "]\" class=\"value_scale ui-text-field\" type=\"text\" id=\"" . $bb_id . "-ui-id\" style=\"border: 0; color: #f6931f; font-weight: bold;\" value=\"0%\" />";
		$html .= "\t\t\t\t</div>";
		
		// Work
		$html .= "\t\t\t\t<div class=\"alignleft wpa-column\">";
		$html .= "\t\t\t\t<div class=\"work_scale ui-form-slider\" id=\"" . $bb_id . "-ui-slider\"></div>";
		$html .= "\t\t\t\t<input name=\"departments[work][" . $bb_id . "]\" class=\"work_scale ui-text-field\" type=\"text\" id=\"" . $bb_id . "-ui-id\" style=\"border: 0; color: #f6931f; font-weight: bold;\" value=\"0%\" />";
		$html .= "\t\t\t\t</div>";
		
		// Influence
		$html .= "\t\t\t\t<div class=\"alignleft wpa-column\">";
		$html .= "\t\t\t\t<div class=\"influence_scale ui-form-slider\" id=\"" . $bb_id . "-ui-slider\"></div>";
		$html .= "\t\t\t\t<input name=\"departments[influence][" . $bb_id . "]\" class=\"influence_scale ui-text-field\" type=\"text\" id=\"" . $bb_id . "-ui-id\" style=\"border: 0; color: #f6931f; font-weight: bold;\" value=\"0%\" />";
		$html .= "\t\t\t\t</div>";
		
		$html .= "\t\t\t\t<a class=\"ui-remove-button\" href=\"\">Remove Department</a>";
		
		$html .= "\t\t\t\t<div class=\"clear\"></div>";
		$html .= "\t\t\t</div></li>";
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
	
	$html .= "\t\t<div class=\"ui-form-footer\"><div class=\"wpa_total_holder\">";
	
	// value
	$html .= "\t\t\t<label class=\"wpa_total\" for=\"total_scale\">Total <input name=\"total_value_scale\" type=\"text\" id=\"total_scale\" class=\"ui-total-field\" value=\"0%\" readonly=\"readonly\" /></label>";
	
	// Work
	$html .= "\t\t\t<label class=\"wpa_total\" for=\"total_scale\">Total <input name=\"total_work_scale\" type=\"text\" id=\"total_scale\" class=\"ui-total-field\" value=\"0%\" readonly=\"readonly\" /></label>";
	
	// Influence
	$html .= "\t\t\t<label class=\"wpa_total\" for=\"total_scale\">Total <input name=\"total_influence_scale\" type=\"text\" id=\"total_scale\" class=\"ui-total-field\" value=\"0%\" readonly=\"readonly\" /></label>";
	
	$html .= "\t\t\t<div class=\"clear\"></div></div>";
	
	$html .= "\t\t\t<input type=\"hidden\" name=\"bb_builder_callback\" value=\"true\" />";
	$html .= "\t\t\t<input type=\"submit\" class=\"bb_builder_submit\" name=\"ui-form-submit\" value=\"Submit\" />";
	
	$html .= "<div class=\"clear\"></div></div>";
	
    $html .= "\t</form>";
	$html .= "</div>";
	
	$content = apply_filters('business_builder_content', $html);
	
	return $content;
}
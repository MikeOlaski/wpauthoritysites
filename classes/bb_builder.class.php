<?php
/*
 * BB Builder functions
 */

add_action('init', 'install_bb_builder');

function install_bb_builder(){
	$labels = array(
		'name'               => 'Surveys',
		'singular_name'      => 'Survey',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Survey',
		'edit_item'          => 'Edit Survey',
		'new_item'           => 'New Survey',
		'all_items'          => 'All Survey',
		'view_item'          => 'View Survey',
		'search_items'       => 'Search Surveys',
		'not_found'          => 'No surveys found',
		'not_found_in_trash' => 'No surveys found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Surveys'
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'surveys' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'taxonomies'		 => array('site-department'),
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' )
	);
	
	register_post_type( 'survey', $args );
	
	$labels = array(
		'name'              => _x( 'Departments', 'taxonomy general name' ),
		'singular_name'     => _x( 'Department', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Departments' ),
		'all_items'         => __( 'All Departments' ),
		'parent_item'       => __( 'Parent Department' ),
		'parent_item_colon' => __( 'Parent Department:' ),
		'edit_item'         => __( 'Edit Department' ),
		'update_item'       => __( 'Update Department' ),
		'add_new_item'      => __( 'Add New Department' ),
		'new_item_name'     => __( 'New Department Name' ),
		'menu_name'         => __( 'Departments' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'department' ),
	);

	register_taxonomy( 'site-department', array( 'survey' ), $args );
}

function bb_builder_form(){
	global $post;
	
	$departments = array();
	$extras = array();
	
	$deptObj = wp_get_post_terms( $post->ID, 'site-department', array(
		'orderby' => 'name',
		'order' => 'ASC'
	));
	
	$i = 1;
	foreach($deptObj as $dep){
		if($i <= 10){
			$departments[$dep->slug] = $dep->name;
		} else {
			$extras[$dep->slug] = $dep->name;
		}
		$i++;
	}
	
	$html = '';
	
	$html .= "<div class=\"bb_builder\">";
	$html .= do_shortcode($content);
	$html .= "\t<form name=\"bb_builder_form\" action=\"\" method=\"post\">";
	
	$html .= "\t\t<div class=\"bb_headers\">";
		$html .= "\t\t\t<span class=\"head order\"><i class=\"wpa_info_icon\" title=\"Description\"></i>Order</span>";
		$html .= "\t\t\t<span class=\"head department\"><i class=\"wpa_info_icon\" title=\"Description\"></i>Department</span>";
		$html .= "\t\t\t<span class=\"head project\"><i class=\"wpa_info_icon\" title=\"Description\"></i>Value %</span>";
		$html .= "\t\t\t<span class=\"head value\"><i class=\"wpa_info_icon\" title=\"Description\"></i>Work %</span>";
		$html .= "\t\t\t<span class=\"head influence\"><i class=\"wpa_info_icon\" title=\"Description\"></i>Influence %</span>";
		$html .= "\t\t\t<div class=\"clear\"></div>";
	$html .= "</div>";
	
	$html .= "\t\t<ul id=\"bb_sortable\">";
	
	foreach($departments as $bb_id=>$dept){
		$term = get_term_by( 'slug', $bb_id, 'site-department');
		$description = term_description( $term->term_id, 'site-department' );
		
		$html .= "\t\t\t<li class=\"ui-state-default " . $bb_id . "\"><div>";
		
		$html .= "\t\t\t\t<span class=\"hand\">" . $dept;
		
		if($description){
			$html .= "\t\t\t\t\t<i class=\"wpa_info_icon\" title=\"" . strip_tags($description) . "\"></i>";
		}
		
		$html .= "\t\t\t\t</span>";
		// $html .= "\t\t\t\t<label class=\"hide\" for=\"" . $bb_id . "-ui-id\">" . $dept . "</label>";
		
		// Value
		$html .= "\t\t\t\t<div class=\"alignleft wpa-column\">";
		$html .= "\t\t\t\t<div class=\"value_scale ui-form-slider\" id=\"" . $bb_id . "-ui-slider\"></div>";
		$html .= "\t\t\t\t<input name=\"departments[value][" . $bb_id . "]\" class=\"value_scale ui-text-field\" type=\"text\" id=\"" . $bb_id . "-ui-id\" value=\"0%\" />";
		$html .= "\t\t\t\t</div>";
		
		// Work
		$html .= "\t\t\t\t<div class=\"alignleft wpa-column\">";
		$html .= "\t\t\t\t<div class=\"work_scale ui-form-slider\" id=\"" . $bb_id . "-ui-slider\"></div>";
		$html .= "\t\t\t\t<input name=\"departments[work][" . $bb_id . "]\" class=\"work_scale ui-text-field\" type=\"text\" id=\"" . $bb_id . "-ui-id\" value=\"0%\" />";
		$html .= "\t\t\t\t</div>";
		
		// Influence
		$html .= "\t\t\t\t<div class=\"alignleft wpa-column\">";
		$html .= "\t\t\t\t<div class=\"influence_scale ui-form-slider\" id=\"" . $bb_id . "-ui-slider\"></div>";
		$html .= "\t\t\t\t<input name=\"departments[influence][" . $bb_id . "]\" class=\"influence_scale ui-text-field\" type=\"text\" id=\"" . $bb_id . "-ui-id\" value=\"0%\" />";
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
	$html .= "\t\t\t<label class=\"wpa_total\" for=\"total_value_scale\">Total <input name=\"total_value_scale\" type=\"text\" id=\"total_value_scale\" class=\"ui-total-field\" value=\"0%\" readonly=\"readonly\" /></label>";
	
	// Work
	$html .= "\t\t\t<label class=\"wpa_total\" for=\"total_work_scale\">Total <input name=\"total_work_scale\" type=\"text\" id=\"total_work_scale\" class=\"ui-total-field\" value=\"0%\" readonly=\"readonly\" /></label>";
	
	// Influence
	$html .= "\t\t\t<label class=\"wpa_total\" for=\"total_influence_scale\">Total <input name=\"total_influence_scale\" type=\"text\" id=\"total_influence_scale\" class=\"ui-total-field\" value=\"0%\" readonly=\"readonly\" /></label>";
	
	$html .= "\t\t\t<div class=\"clear\"></div></div>";
	
	$html .= "\t\t\t<input type=\"hidden\" name=\"bb_builder_callback\" value=\"true\" />";
	$html .= "\t\t\t<input type=\"submit\" class=\"bb_builder_submit\" name=\"survey_taker_btn\" value=\"Submit\" />";
	
	$html .= "<div class=\"clear\"></div></div>";
	
    $html .= "\t</form>";
	$html .= "</div>";
	
	$content = apply_filters('business_builder_content', $html);
	
	echo $content;
}
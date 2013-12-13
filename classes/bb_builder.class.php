<?php
/*
 * BB Builder functions
 */

add_action('wp_loaded', 'bb_builder_callback');
function bb_builder_callback(){
	$bb_departments = get_option('bb_departments');
	global $post;
	
	if( isset($_POST['bb_builder_callback']) && $_POST['bb_builder_callback'] == 'true'){
		foreach($_POST as $key=>$val){
			$$key = $val;
		}
		
		if( empty($wpa_survey['first_name']) ){
			$return = new WP_Error('broke', __("Error First name"));
		} elseif( empty($wpa_survey['last_name']) ){
			$return = new WP_Error('broke', __("Error Last name"));
		} elseif( empty($wpa_survey['email']) ){
			$return = new WP_Error('broke', __("Error Email"));
		} elseif( !is_email($wpa_survey['email']) ){
			$return = new WP_Error('broke', __("Email cannot be empty"));
		}
		
		if( is_wp_error( $return ) )
			wp_die('Error On Survey Taker Details: ' . $return->get_error_message());
		
		foreach($departments['value'] as $dept=>$score){
			$bb_departments[trim($dept)] = trim(ucwords(str_replace('-', ' ', $dept)));
			$survey_departments[] = trim(ucwords(str_replace('-', ' ', $dept)));
		}
		
		// 1. Create new survey CPT entry.
		if( $survey_id = bb_builder_record_survey() ) {
			$survey = '@' . get_the_title( $survey_id );
			
			// 2. Attach people tag to new survey CPT. Create new people CPT if not exists.
			$people_id = bb_builder_record_people( $wpa_survey );
			if( $people_id ){
				$people = '@' . get_the_title( $people_id );
				$return = wp_set_object_terms( $survey_id, $people, 'survey-include', true );
				
				if( is_wp_error( $return ) )
					wp_die('Error On Survey Taker Details: ' . $return->get_error_message());
			}
			
			// 3. Attach Site tag to people CPT and survey CPT if site exists.
			$site_id = bb_builder_record_website( $wpa_survey['website'] );
			if( $site_id ){
				$site = '@' . get_the_title( $site_id );
				
				$return = wp_set_object_terms( $survey_id, $site, 'survey-include', true );
				$return = wp_set_object_terms( $people_id, $site, 'people-include', true );
				$return = wp_set_object_terms( $site_id, $people, 'site-include', true );
				
				// Step 5
				$return = wp_set_object_terms( $site_id, $survey, 'site-include', true );
				
				if( is_wp_error( $return ) )
					wp_die('Error On Site Details: ' . $return->get_error_message());
			}
			
			// 4. Attach departments tag and to survey CPT and set their scores on meta keys
			$return = wp_set_object_terms( $survey_id, $survey_departments, 'survey-department', true );
			
			if( is_wp_error( $return ) )
				wp_die('Error On Department Details: ' . $return->get_error_message());
			
			update_post_meta($survey_id, '_survey_scores', $departments);
			
			// 5. Attach the survey tag to people CPT and site CPT
			$return = wp_set_object_terms( $people_id, $survey, 'people-include', true );
			
			if( is_wp_error( $return ) )
					wp_die('Error On Site Details: ' . $return->get_error_message());
			
			update_option('bb_departments', $bb_departments);
			
			$redirect = (!empty($redirect_to)) ? $redirect_to : get_permalink($post->ID);
			header('location:'.$redirect_to); exit;
			
		} else {
			wp_die( __("Something wen't wrong!"), __('Bad Page') );
		}
	}
	
	return;
}

function bb_builder_record_website( $website ){
	$post_title = str_replace( array('http://', 'https://'), '', $website );
	
	if( $site = get_page_by_title($post_title, OBJECT, 'site') ){
		$post_id = $site->ID;
	} else {
		$post_id = null;
		/*$post_id = wp_insert_post(array(
			'post_title' => $post_title,
			'post_status' => 'uncheck',
			'post_type' => 'site'
		));*/
	}
	
	return $post_id;
}

function bb_builder_record_survey(){
	$count = true;
	while ($count) { //make sure it's unique
		$post_title = substr(sha1(uniqid('')), rand(1, 24), 12);
		$count = get_page_by_title( $survey_title, 'OBJECT', 'survey' );
	}
	
	$args = array(
		'post_title' => $post_title,
		'post_status' => 'publish',
		'post_type' => 'survey'
	);
	
	return wp_insert_post( $args );
}

function bb_builder_record_people( $args = array() ){
	$post_title = $args['first_name'] . ' ' . $args['last_name'];
	if( $people = get_page_by_title($post_title, OBJECT, 'people') ){
		$post_id = $people->ID;
	} else {
		$post_id = wp_insert_post(array(
			'post_title' => $post_title,
			'post_status' => 'publish',
			'post_type' => 'people'
		));
		
		if($post_id){
			update_post_meta($post_id, '_base_people_fname', $args['first_name']);
			update_post_meta($post_id, '_base_people_lname', $args['last_name']);
			update_post_meta($post_id, '_base_people_email', $args['email']);
			update_post_meta($post_id, '_base_people_website', $args['website']);
			update_post_meta($post_id, '_base_people_role', $args['role']);
		}
	}
	
	return $post_id;
}

add_action('init', 'install_bb_builder');
function install_bb_builder(){
	$args = array(
		'labels'             => array(
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
		),
		'public'             => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'survey' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'taxonomies'		 => array(
			'survey-department',
			'survey-action',
			'survey-status',
			'survey-include',
			'survey-topic',
			'survey-type',
			'survey-location',
			'survey-assigment'
		),
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' )
	);
	
	register_post_type( 'survey', $args );
	
	$survey_taxes = array(
		'survey-department' => 'Department',
		'survey-action' => 'Action',
		'survey-status' => 'Status',
		'survey-include' => 'Include',
		'survey-topic' => 'Topic',
		'survey-type' => 'Type',
		'survey-location' => 'Location',
		'survey-assigment' => 'Assignment'
	);
	
	foreach( $survey_taxes as $tax_slug=>$tax_name ){
		$taxArgs = array(
			'labels'            => array(
				'name'              => _x( $tax_name, 'taxonomy general name' ),
				'singular_name'     => _x( $tax_name, 'taxonomy singular name' ),
				'search_items'      => __( 'Search ' . $tax_name ),
				'all_items'         => __( 'All ' . $tax_name ),
				'parent_item'       => __( 'Parent ' . $tax_name ),
				'parent_item_colon' => __( 'Parent ' . $tax_name ),
				'edit_item'         => __( 'Edit ' . $tax_name ),
				'update_item'       => __( 'Update ' . $tax_name ),
				'add_new_item'      => __( 'Add New ' . $tax_name ),
				'new_item_name'     => __( 'New ' . $tax_name ),
				'menu_name'         => __( $tax_name ),
			),
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => strtolower($tax_name) ),
		);
	
		register_taxonomy( $tax_slug, array( 'survey' ), $taxArgs );
	}
}

function bb_builder_departments(){
	return get_option('bb_builder_depts');
}

function bb_builder_form(){
	global $post, $bb_exclude_templates;
	
	$departments = array();
	$bb_exclude_templates = array();
	$extras = array();
	
	$deptObj = bb_builder_departments();
	
	$i = 1;
	foreach($deptObj as $slug=>$name){
		if($i <= 10){
			$departments[$slug] = $name;
			$bb_exclude_templates[] = $slug;
		} else {
			$extras[$slug] = $name;
		}
		$i++;
	}
	
	$before = '';
	$after = '';
	
	$html = apply_filters('before_bb_builder_form', $before);
	$html .= "<div class=\"bb_builder\">";
	$html .= do_shortcode($content);
	$html .= "\t\t<div class=\"clear\"></div>";
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
		$term = get_term_by( 'slug', $bb_id, 'survey-department');
		$description = term_description( $term->term_id, 'survey-department' );
		
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
	
	$html .= '<input type="hidden" name="send_nonce" value="' . wp_create_nonce( 'wpa_nonce_' . $post->ID ) . '" />';
	
	$html .= "\t\t<div class=\"ui-form-footer\"><div class=\"wpa_total_holder\">";
	
	// value
	$html .= "\t\t\t<label class=\"wpa_total\" for=\"total_value_scale\">Total <input name=\"total_value_scale\" type=\"text\" id=\"total_value_scale\" class=\"ui-total-field\" value=\"0%\" readonly=\"readonly\" /></label>";
	
	// Work
	$html .= "\t\t\t<label class=\"wpa_total\" for=\"total_work_scale\">Total <input name=\"total_work_scale\" type=\"text\" id=\"total_work_scale\" class=\"ui-total-field\" value=\"0%\" readonly=\"readonly\" /></label>";
	
	// Influence
	$html .= "\t\t\t<label class=\"wpa_total\" for=\"total_influence_scale\">Total <input name=\"total_influence_scale\" type=\"text\" id=\"total_influence_scale\" class=\"ui-total-field\" value=\"0%\" readonly=\"readonly\" /></label>";
	
	$html .= "\t\t\t<div class=\"clear\"></div></div>";
	
	$html .= "\t\t\t<input type=\"hidden\" name=\"bb_builder_callback\" value=\"true\" />";
	$html .= "\t\t\t<input type=\"hidden\" name=\"redirect_to\" value=\"". get_permalink($post->ID) ."\" />";
	$html .= "\t\t\t<input type=\"submit\" class=\"bb_builder_submit\" name=\"survey_taker_btn\" value=\"Submit\" />";
	
	$html .= "\t<div class=\"clear\"></div></div>";
	$html .= "</div>";
	$html .= apply_filters('after_bb_builder_form', $after);
	
	$content = apply_filters('business_builder_content', $html);
	
	echo $content;
}
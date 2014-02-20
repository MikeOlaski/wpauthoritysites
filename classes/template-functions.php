<?php
/*
 *
 */

function wpas_claim_form($echo = true, $post_id = null){
	global $post;
	$post_id = (!$post_id) ? $post->ID : $post_id;
	
	$users_can_register = get_option('users_can_register');
	
	$html = sprintf('<form action="%s" method="post">', get_permalink($post_id));
	$html .= sprintf('<h3>%s : %s</h3>', __('Claim', 'wpas'), get_the_title($post_id));
	
	$html .= '<table class="form-table" width="100%">';
		$html .= '<tr valign="top">';
			$html .= sprintf(
				'<th scope="row" align="left"><label for="wpas_claimed_fname">%s:</label></th>',
				__('First name', 'wpas')
			);
			$html .= '<td><input type="text" name="wpas_claimed[fname]" id="wpas_claimed_fname" value="" /></td>';
		$html .= '</tr>';
		
		$html .= '<tr valign="top">';
			$html .= sprintf(
				'<th scope="row" align="left"><label for="wpas_claimed_lname">%s:</label></th>',
				__('Last name')
			);
			$html .= '<td><input type="text" name="wpas_claimed[lname]" id="wpas_claimed_lname" value="" /></td>';
		$html .= '</tr>';
		
		$html .= '<tr valign="top">';
			$html .= sprintf(
				'<th scope="row" align="left"><label for="wpas_claimed_email">%s:</label></th>',
				__('Email', 'wpas')
			);
			$html .= '<td><input type="text" name="wpas_claimed[email]" id="wpas_claimed_email" value="" /></td>';
		$html .= '</tr>';
	$html .= '</table>';
	
	$html .= sprintf('<input type="hidden" name="wpas_claimed[post_id]" value="%s" />', $post_id);
	$html .= '<input type="hidden" name="wpas_claimed[status]" value="Y" />';
	$html .= sprintf('<input type="hidden" name="redirect_to" value="%s" />', get_permalink($post_id));
	$html .= '<input class="alignright" type="submit" name="wpas_claim" value="Submit" />';
	
	$html .= '<div class="clear"></div> </form>';
	
	if(!$users_can_register){
		$html = __('User registration is not allowed. Please contact the site administrator.', 'wpas');
	}
	
	if($echo){ echo $html; } else { return $html; }
}

function wpas_get_claim_popup($echo = true, $post_id = '', $single = false){
	global $post;
	$post_id = (!$post_id) ? $post->ID : $post_id;
	
	$html = sprintf(
		'<a href="#wpas_claim_form_%s" class="wpas-claim-btn">%s</a>',
		$post_id,
		__('CLAIM', 'wpas')
	);
	
	$html .= sprintf('<div style="display:none;"><div id="wpas_claim_form_%s" class="colorboxPopup">', $post_id);
	$html .= wpas_claim_form(false, $post_id);
	$html .= '</div></div>';
	
	if($echo){ echo $html; } else { return $html; }
}

function wpas_calculate_score($post_id, $metric){
	
	$meta_key = substr($metric, 0, -6);
	$standard = get_post_meta($post_id, $meta_key, true);
	$base = preg_replace('/\D/', '', $standard);
	
	switch($metric){
		case 'awp-domain-score':
			if($base <= 10) {
				$score = 0;
			} elseif($base > 10 and $base <= 100) {
				$score = 50;
			} elseif($base > 100 and $base <= 1000) {
				$score = 60;
			} elseif($base > 1000 and $base <= 10000) {
				$score = 70;
			} elseif($base > 10000 and $base <= 100000) {
				$score = 80;
			} elseif($base > 100000 and $base < 1000000) {
				$score = 90;
			} elseif($base >= 1000000) {
				$score = 100;
			}
			break;
		
		case 'awp-domain-age-score':
		case 'awp-domain-expiry-score':
			if($base <= 1){
				$score = 50;
			} elseif($base > 1 and $base <= 2) {
				$score = 60;
			} elseif($base > 2 and $base <= 3) {
				$score = 70;
			} elseif($base > 3 and $base <= 5) {
				$score = 80;
			} elseif($base > 5 and $base < 10) {
				$score = 90;
			} elseif($base > 10) {
				$score = 100;
			}
			break;
		
		case 'awp-authors-number-score':
			if(!$base or $base < 1){
				$score = 10;
			} elseif($base >= 2 and $base < 4) {
				$score = 20;
			} elseif($base >= 4 and $base < 10) {
				$score = 50;
			} elseif($base >= 10 and $base < 20) {
				$score = 70;
			} elseif($base >= 20) {
				$score = 80;
			}
			break;
		
		case 'awp-authors-bio-type-score':
		case 'awp-authors-byline-type-score':
		case 'awp-authors-page-type-score':
			if(!$base or $base < 1){
				$score = 0;
			} elseif(($base >= 1 and $base < 2) or $standard == 'simple') {
				$score = 25;
			} elseif(($base >= 2 and $base < 3) or $standard == 'standard') {
				$score = 50;
			} elseif(($base >= 3 and $base < 4) or $standard == 'advanced') {
				$score = 75;
			} elseif(($base >= 4 and $base < 5) or $standard == 'integrated') {
				$score = 100;
			}
			break;
		
		case 'awp-content-pages-majestic-score':
		case 'awp-content-pages-google-score':
			if($base <= 10){
				$score = 5;
			} elseif($base > 10 and $base <= 100) {
				$score = 25;
			} elseif($base > 100 and $base <= 1000) {
				$score = 60;
			} elseif($base > 1000 and $base <= 10000) {
				$score = 85;
			} elseif($base > 10000 and $base <= 100000) {
				$score = 90;
			} elseif($base > 100000 and $base <= 1000000) {
				$score = 95;
			} elseif($base > 1000000) {
				$score = 100;
			}
			break;
		
		case 'awp-content-post-frequency-score':
			if($base < .25){
				$score = 0;
			} elseif($base >= .25 and $base < 0.5) {
				$score = 15;
			} elseif($base >= 0.5 and $base < 1) {
				$score = 25;
			} elseif($base >= 1 and $base < 3) {
				$score = 35;
			} elseif($base >= 3 and $base <= 6) {
				$score = 50;
			} elseif($base >= 7 and $base < 8) {
				$score = 65;
			} elseif($base >= 8 and $base <= 14) {
				$score = 85;
			} elseif($base > 14){
				$score = 90;
			}
			break;
		
		case 'awp-content-type-snippet-count-score':
			if($base <= 0){
				$score = 0;
			} elseif($base >= 1 and $base <= 3) {
				$score = 90;
			} elseif($base >= 4) {
				$score = 100;
			}
			break;
		
		case 'awp-content-posts-snippet-count-score':
			if($base <= 0){
				$score = 0;
			} elseif($base >= 1 and $base < 100) {
				$score = 60;
			} elseif($base >= 100 and $base < 1000) {
				$score = 70;
			} elseif($base >= 1000 and $base <= 10000) {
				$score = 80;
			} elseif($base > 10000) {
				$score = 100;
			}
			break;
		
		case 'awp-google-score':
		case 'awp-alexa-score':
			if($base <= 0){
				$score = 0;
			} elseif($base >= 1 and $base <= 10) {
				$score = 25;
			} elseif($base > 10 and $base <= 100) {
				$score = 75;
			} elseif($base > 100 and $base <= 1000) {
				$score = 85;
			} elseif($base > 1000){
				$score = 100;
			}
			break;
		
		case 'awp-majestic-score':
			if($base <= 0){
				$score = 0;
			} elseif($base >= 1 and $base <= 100){
				$score = 25;
			} elseif($base > 100 and $base <= 1000){
				$score = 50;
			} elseif($base > 1000 and $base <= 10000){
				$score = 75;
			} elseif($base > 10000 and $base <= 100000){
				$score = 90;
			} elseif($base > 100000){
				$score = 100;
			}
			break;
		
		case 'awp-facebook-followers-score':
		case 'awp-twitter-followers-score':
		case 'awp-youtube-followers-score':
		case 'awp-googleplus-followers-score':
		case 'awp-linkedin-followers-score':
		case 'awp-pinterest-followers-score':
			if($base < 100){
				$score = 0;
			} elseif($base >= 100 and $base < 1000) {
				$score = 60;
			} elseif($base >= 1000 and $base < 5000) {
				$score = 70;
			} elseif($base >= 5000 and $base < 50000) {
				$score = 80;
			} elseif($base >= 50000 and $base < 250000) {
				$score = 90;
			} elseif($base >= 250000){
				$score = 100;
			}
			break;
		
		case 'awp-buzz-recent-comments-score':
			if($base <= 0){
				$score = 0;
			} elseif($base >= 1 and $base <= 25) {
				$score = 10;
			} elseif($base > 25 and $base <= 50) {
				$score = 25;
			} elseif($base > 50 and $base <= 100) {
				$score = 50;
			} elseif($base > 100 and $base <= 200) {
				$score = 75;
			} elseif($base > 200 and $base <= 500) {
				$score = 80;
			} elseif($base > 500 and $base <= 1000) {
				$score = 90;
			} elseif($base > 1000) {
				$score = 100;
			}
			break;
		
		case 'awp-buzz-recent-shares-score':
			if($base <= 0){
				$score = 0;
			} elseif($base >= 1 and $base <= 100){
				$score = 10;
			} elseif($base > 100 and $base <= 500){
				$score = 25;
			} elseif($base > 500 and $base <= 1000){
				$score = 50;
			} elseif($base > 1000 and $base <= 2000){
				$score = 75;
			} elseif($base > 2000 and $base <= 5000){
				$score = 80;
			} elseif($base > 5000 and $base <= 10000){
				$score = 90;
			} elseif($base > 10000) {
				$score = 100;
			}
			break;
		
		case 'awp-shares-googleplus-score':
		case 'awp-shares-facebook-score':
		case 'awp-shares-twitter-score':
		case 'awp-shares-linkedin-score':
			if($base <= 0){
				$score = 0;
			} elseif($base >= 1 and $base <= 10) {
				$score = 60;
			} elseif($base > 10 and $base <= 100) {
				$score = 70;
			} elseif($base > 100 and $base <= 1000) {
				$score = 80;
			} elseif($base > 1000 and $base <= 10000) {
				$score = 90;
			} elseif($base > 10000) {
				$score = 100;
			}
			break;
		
		case 'awp-alexa-rank-score':
			if($base <= 1000){
				$score = 100;
			} elseif($base > 1000 and $base <= 5000) {
				$score = 95;
			} elseif($base > 5000 and $base <= 10000) {
				$score = 90;
			} elseif($base > 10000 and $base <= 100000) {
				$score = 85;
			} elseif($base > 100000 and $base <= 500000) {
				$score = 80;
			} elseif($base > 500000) {
				$score = 50;
			}
			break;
		
		case 'awp-compete-rank-score':
		case 'awp-tachnorati-rank-score':
			if($base <= 10){
				$score = 100;
			} elseif($base > 100 and $base <= 1000) {
				$score = 95;
			} elseif($base > 1000 and $base <= 2500) {
				$score = 90;
			} elseif($base > 2500 and $base <= 10000) {
				$score = 80;
			} elseif($base > 10000 and $base <= 100000) {
				$score = 70;
			} elseif($base > 100000 and $base <= 250000) {
				$score = 60;
			} elseif($base > 250000 and $base <= 1000000) {
				$score = 50;
			} elseif($base > 1000000) {
				$score = 0;
			}
			break;
		
		case 'awp-quantcast-rank-score':
			if($base <= 0){
				$score = 0;
			} elseif($base >= 1 and $base <= 100) {
				$score = 25;
			} elseif($base > 100 and $base <= 1000) {
				$score = 50;
			} elseif($base > 1000 and $base <= 10000) {
				$score = 75;
			} elseif($base > 10000 and $base <= 100000) {
				$score = 90;
			} elseif($base > 100000) {
				$score = 100;
			}
			break;
		
		case 'awp-google-rank-score':
			if($base <= 0){
				$score = 0;
			} elseif($base >= 1 and $base < 2) {
				$score = 50;
			} elseif($base >= 2 and $base < 3) {
				$score = 60;
			} elseif($base >= 3 and $base < 4) {
				$score = 70;
			} elseif($base >= 4 and $base < 5) {
				$score = 80;
			} elseif($base >= 5 and $base <= 6) {
				$score = 90;
			} elseif($base >= 7 and $base <= 10) {
				$score = 100;
			}
			break;
		
		case 'awp-framework-system-host-score':
			if($standard == 'amazon' || $standard == 'liquid'){
				$score = 100;
			} elseif($standard == 'wpengine') {
				$score = 90;
			} elseif($standard == 'hostgator') {
				$score = 80;
			} elseif($standard == 'bluehost') {
				$score = 70;
			} else {
				$score = 0;
			}
			break;
		
		case 'awp-date-score':
		case 'awp-contributors-score':
		case 'awp-authors-aggregated-authority-score':
		case 'awp-authors-markup-score':
		case 'awp-content-post-types-score':
		case 'awp-content-pillars-score':
		case 'awp-valuation-ttm-score':
		case 'awp-valuation-income-score':
		case 'awp-valuation-expenses-score':
		case 'awp-rss-score':
		case 'awp-email-score':
		case 'awp-websites-score':
		case 'awp-buzz-klout-score':
		case 'awp-shares-site-googleplus-score':
		case 'awp-shares-site-facebook-score':
		case 'awp-shares-site-twitter-score':
		case 'awp-shares-site-linkedin-score':
		case 'awp-one-rank-score':
		case 'awp-editor-score':
			$score = 0;
			break;
		
		default:
			$score = 0;
			break;
	}
	
	return $score;
}

function wpas_people_social_places($echo = true, $post_id = '', $type = 'people'){
	global $post;
	$post_id = (!$post_id) ? $post->ID : $post_id;
	
	$places = array(
		'_base_people_fb' => 'facebook',
		'_base_people_tw' => 'twitter',
		'_base_people_gg' => 'google-plus',
		'_base_people_li' => 'linkedin'
	);
	
	$html = '<ul class="wpas-people-places">';
	
	foreach($places as $key=>$social){
		$url = get_post_meta($post_id, $key, true);
		$html .= sprintf(
			'<li><a href="%s" title="%s" target="_blank"><i class="fa fa-%3$s fa-big"></i></a></li>',
			$url,
			sprintf(__('Follow %s on %s', 'wpas'), get_the_title($post_id), $social),
			$social
		);
	}
	
	$html .= '</ul>';
	
	if($echo){ echo $html; } else { return $html; }
}

function wpas_get_watch_popup($echo = true, $post_id = '', $single = false){
	global $post;
	$post_id = (!$post_id) ? $post->ID : $post_id;
	
	if( $single ){
		$html = sprintf(
			'<a class="wpas-watch-btn" href="#wpas_subscriber_form_%s">%s</a>',
			$post_id,
			__('WATCH', 'wpas')
		);
	} else {
		$html = sprintf(
			'<a href="#wpas_subscriber_form_%s" class="wpa-watch-button">%s</a>',
			$post_id,
			__('Watch This', 'wpas')
		);
	}
	
	$html .= sprintf('<div style="display:none;"><div id="wpas_subscriber_form_%s" class="colorboxPopup">', $post_id);
	$html .= wpas_subscribe_form(false, $post_id);
	$html .= '</div></div>';
	
	if($echo){ echo $html; } else { return $html; }
}

function wpas_site_display_options(){
	$metrics = get_post_meta( $post_id );
	$heads = wpa_get_metrics_groups();
	$columns = array();
	
	$columns['awp-action'] = array();
	$taxonomies = get_object_taxonomies('site', 'objects');
	foreach($taxonomies as $tax){
		$columns['awp-action'][] = array(
			'name' => $tax->label,
			'header' => 'wpa-th-'.$tax->name,
			'body' => 'wpa-td-'.$tax->name,
			'taxonomy' => $tax->name
		);
	}
	
	foreach ($heads as $group){
		$columns[$group['id']] = array();
		$metrics = wpa_get_metrics_by_group($group['id']);
		
		foreach($metrics as $field){
			$columns[$group['id']][] = array(
				'name' => $field['name'],
				'header' => 'wpa-th-' . $field['id'],
				'body' => 'wpa-td-' . $field['id'],
				'meta_key' => $field['id'],
				'sortable' => $field['sortable'],
				'format' => ($field['format']) ? $field['format'] : '',
				'link_text' => ($field['link_text']) ? $field['link_text'] : false,
				'meta_value' => ($field['meta_value']) ? $field['meta_value'] : false
			);
		}
	}
	
	$html = '<div class="wpa-screen-options hide">';	
	$html .= sprintf('<span class="displayOptionshead">%s</span>', __('DISPLAY OPTIONS', 'wpas'));
	$html .= '<ul>';
	
	foreach($columns as $group=>$cols){
		$name = strtolower(str_replace('wpa-col-', '', $group));
		$groupLabel = ucwords(str_replace('awp-', '', $name));
		
		$checkboxes = '';
		foreach($cols as $col){
			$label = $col['name'];
			
			if( isset($col['taxonomy']) ){
				$inputID = $col['taxonomy'] . '-option';
				$inputVal = '.metrics-' . $col['taxonomy'];
			} else {
				$inputID = $col['meta_key'] . '-option';
				$inputVal = '.metrics-' . $col['meta_key'];
			}
			
			$checkboxes .= sprintf(
				'<label for="%s"><input type="checkbox" class="ch-box checkbox-%s" id="%1$s" value="%s" %s />%s</label>',
				$inputID,
				$name,
				$inputVal,
				($name == 'wpa-col-site') ? 'checked="checked"' : '',
				$label
			);
		}
		
		$html .= sprintf(
			'<li><strong>%s</strong> %s</li>',
			$groupLabel,
			$checkboxes
		);
		
		// echo '<pre>' . print_r($col, true) . '</pre>';
	}
	
	$html .= '</ul></div>';
	
	echo $html;
}

function wpas_archive_view_groups(){
	$categories = wpas_get_metrics_categories();
	
	$lines = array(
		'Wofkflow' => array('All', 'Summary', 'Action')
	);
	
	foreach( $categories as $category ){
		$groups = wpa_get_metrics_group_by_category($category['id']);
		$lines[$category['name']] = array();
		
		foreach($groups as $group){
			$lines[$category['name']][] = $group['name'];
		}
	}
	
	foreach( $lines as $label=>$views ){
		$html .= sprintf('<ul id="wpas-views-%s">', strtolower($label));
		$html .= sprintf('<li class="first"><span><strong>%s:</strong></span></li>', $label);
			
			$i = 1;
			foreach($views as $view){
				$classes = array();
				$classes[] = ($i >= count($views)) ? 'last' : '';
				$classes[] = ($view == 'Site') ? 'current' : '';
				
				$html .= sprintf(
					'<li class="%s"><a data-inputs=".checkbox-awp-%s" href=".awp-%2$s">%s</a></li>',
					implode(' ', $classes),
					strtolower($view),
					$view
				);
				$i++;
			}
		
		$html .= '</ul>';
	}
	
	echo $html;
}

function wpas_archive_list_content($echo = true, $post_id = ''){
	global $post;
	$post_id = (!$post_id) ? $post->ID : $post_id;
	$wpa_settings = get_option('awp_settings');
	
	$metrics = get_post_meta( $post_id );
	$heads = wpa_get_metrics_groups();
	$columns = array();
	
	$columns['awp-action'] = array();
	$taxonomies = get_object_taxonomies('site', 'objects');
	foreach($taxonomies as $tax){
		$columns['awp-action'][] = array(
			'name' => $tax->label,
			'header' => 'wpa-th-'.$tax->name,
			'body' => 'wpa-td-'.$tax->name,
			'taxonomy' => $tax->name
		);
	}
	
	foreach ($heads as $group){
		$columns[$group['id']] = array();
		$metrics = wpa_get_metrics_by_group($group['id']);
		
		foreach($metrics as $field){
			$columns[$group['id']][] = array(
				'name' => $field['name'],
				'header' => 'wpa-th-' . $field['id'],
				'body' => 'wpa-td-' . $field['id'],
				'meta_key' => $field['id'],
				'sortable' => $field['sortable'],
				'format' => ($field['format']) ? $field['format'] : '',
				'link_text' => ($field['link_text']) ? $field['link_text'] : false,
				'meta_value' => ($field['meta_value']) ? $field['meta_value'] : false
			);
		}
	}
	
	$default_img = PLUGINURL . 'timthumb.php?a=tl&w=290&h=250&src=' . $wpa_settings['default_site_image'];
	$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) );
	$attachmentURL = ($attachment) ? PLUGINURL.'/timthumb.php?src='.$attachment[0].'&a=tl&w=290&h=250' : null;
	$thumbnail = sprintf(
		'<img src="%s" alt="%s" />',
		($attachmentURL) ? $attachmentURL : $default_img, get_the_title()
	);
	
	$html = '<div class="wpa-td wpa-td-change">';
	$html .= wpas_get_authority_level(false, $post_id, 'single');
	$html .= '</div>';
	
	$html .= sprintf('<div class="wpa-td wpa-td-count">%s</div>', $metrics['awp-one-rank'][0]);
	
	$html .= '<div class="wpa-td wpa-td-title">';
	$html .= sprintf('<a href="%s">%s</a>', get_permalink($post_id), get_the_title($post_id));
	$html .= sprintf(
		'<span class="external-link">%s <a href="%s" title="%s>" target="_blank">
		<img src="%s" alt="%3$s" />
		</a></span>',
		sprintf('<a class="post-edit-link" href="%s"> Edit </a>', get_edit_post_link($post_id)),
		'', // Exterbal link
		get_the_title($post_id),
		PLUGINURL.'images/link-icon.png'
	);
	$html .= '</div>';
	
	foreach($columns as $class=>$group){
		foreach($group as $col){
			$classes = array('wpa-td', 'wpa-col', 'awp-all', 'hide');
			$classes[] = $col['body'];
			$classes[] = $class;
			
			if($class == 'awp-site')
				$classes[] = 'wpa-default';
			
			if(isset($col['taxonomy'])){
				$classes[] = 'metrics-' . $col['taxonomy'];
			} else {
				$classes[] = 'metrics-' . $col['meta_key'];
			}
			
			$html .= sprintf('<div class="%s">', implode(' ', $classes));
			if( isset($col['taxonomy']) ){
				$term_list = wp_get_post_terms($post_id, $col['taxonomy']);
				foreach($term_list as $term){
					$html .= sprintf(
						'<a href="%s">%s</a>',
						get_term_link( $term, $term->taxonomy ),
						$term->name
					);
				}
			} else {
				$meta = $metrics[$col['meta_key']][0];
				switch($col['format']){
					case 'image':
						$html .= $thumbnail; break;
					
					case 'link':
						$html .= sprintf(
							'<a href="%s" target="_blank">%s</a>',
							$meta,
							($col['link_text']) ? $col['link_text'] : $meta
						); break;
					
					case 'date':
						$html .= date('F j, Y', strtotime($meta)); break;
					
					case 'meta':
						$text = get_post_meta(get_the_ID(), $col['meta_value'], true);
						$html .= sprintf(
							'<a class="%s" href="%s" target="_blank">%s</a>',
							$col['meta_value'], $meta, wpas_numbers_to_readable_size($text)
						);
						break;
					
					default:
						$html .= wpas_numbers_to_readable_size($meta);
						break;
				}
			}
			$html .= '</div>';
		}
	}
	
	// $html .= $data;
	if( $echo ){ echo $html; } else { return $html; }
}

function wpas_archive_list_header($page = ''){
	$wpa_settings = get_option('awp_settings');
	$heads = wpa_get_metrics_groups();
	$columns = array();
	global $wp_query;
	
	$columns['awp-action'] = array();
	$taxonomies = get_object_taxonomies('site', 'objects');
	foreach($taxonomies as $tax){
		$columns['awp-action'][] = array(
			'name' => $tax->label,
			'header' => 'wpa-th-'.$tax->name,
			'body' => 'wpa-td-'.$tax->name,
			'taxonomy' => $tax->name
		);
	}
	
	foreach ($heads as $group){
		$columns[$group['id']] = array();
		$metrics = wpa_get_metrics_by_group($group['id']);
		
		foreach($metrics as $field){
			$columns[$group['id']][] = array(
				'name' => $field['name'],
				'header' => 'wpa-th-' . $field['id'],
				'body' => 'wpa-td-' . $field['id'],
				'meta_key' => $field['id'],
				'sortable' => $field['sortable'],
				'format' => ($field['format']) ? $field['format'] : '',
				'link_text' => ($field['link_text']) ? $field['link_text'] : false,
				'meta_value' => ($field['meta_value']) ? $field['meta_value'] : false
			);
		}
	}
	
	$page = ( !$page ) ? get_post_type_archive_link( 'site' ) : $page;
	$order = (isset($wp_query->query['order'])) ? (($_REQUEST['order']) ? $_REQUEST['order'] : $wpa_settings['sites_default_order']) : 'asc';
	
	?><div class="wpa-th wpa-th-change"><?php _e('Level', 'wpas'); ?></div>
    <div class="wpa-th wpa-th-count"><?php _e('1Rank', 'wpas'); ?></div>
    <div class="wpa-th wpa-th-title">
        <a href="<?php echo $sortbytitle; ?>" class="wpa-sortable <?php echo $order; echo ($orderby == 'title') ? ' current' : ''; ?>"><?php _e('Blog', 'wpas'); ?></a>
    </div><?php
    
    foreach($columns as $name=>$group){
        foreach($group as $col){
            $oby = 'meta_value';
            if($name == 'wpa-col-ranks')
                $oby = 'meta_value_num';
            
            if( isset($col['taxonomy']) ):
                $sort = add_query_arg(array('orderby' => $col['taxonomy'], 'order' => $order), $page);
            else:
				$sort = add_query_arg(array(
					'meta_key' => $col['meta_key'],
					'orderby' => $oby,
					'order' => $order
				), $page);
            endif;
            
            $class = array('wpa-sortable', $order);
            $class[] = ($meta == $col['meta_key']) ? 'current' : null;
            
            $classes = array('wpa-th', 'wpa-col', 'awp-all', 'hide');
            $classes[] = $col['header'];
            $classes[] = $name;
            
            if($name == 'awp-site')
                $classes[] = 'wpa-default';
            
			if(isset($col['taxonomy'])){
				$classes[] = 'metrics-' . $col['taxonomy'];
			} else {
				$classes[] = 'metrics-' . $col['meta_key'];
			}
			
            ?><div class="<?php echo implode(' ', $classes); ?>"><?php
                if($col['sortable']){
                    echo sprintf(
                        '<a href="%s" class="%s">%s</a>',
                        $sort, implode(' ', $class), $col['name']);
                } else {
                    echo $col['name'];
                }
            ?></div><?php
        }
    }
}

function wpas_count_metric_scores($post_id, $metric){
	$groups = array();
	
	$group_id = str_replace('scores-', '', $metric);
	$groups = wpas_get_metrics_with_score($group_id);
	
	$score = 0;
	$total = 0;
	if(!empty($groups)) {
		$divider = 0;
		foreach( $groups as $group ){
			if( $group_id == 'awp-subscribers' ):
				$meta_key = $group . '-followers-score';
			else:
				$meta_key = $group . '-score';
			endif;
			
			$metric_score = get_post_meta($post_id, $meta_key, true);
			preg_replace('/\D/', '', $metric_score);
			
			if( !empty($metric_score) || $metric_score != '' ){
				$divider++;
			}
			
			$total = $total + $metric_score;
		}
		if($divider > 0):
			$score = $total / $divider;
		else:
			$score = $total;
		endif;
	}
	
	return number_format($score, 2);
}

function wpas_get_metric_score($post_id, $metric){
	return get_post_meta($post_id, 'awp-scores-' . strtolower($metric), true);
}

function wpas_get_metric_grade($post_id, $metric){
	$s = get_post_meta($post_id, 'awp-scores-' . strtolower($metric), true);
	
	$grade = 'F';
	if($s >= 60 and $s < 70){
		$grade = 'D';
	} elseif($s >= 70 and $s < 80) {
		$grade = 'C';
	} elseif($s >= 80 and $s < 90) {
		$grade = 'B';
	} elseif($s >= 90 and $s <= 100) {
		$grade = 'A';
	}
	
	return $grade;
}

function wpas_site_metrics_grade($echo = true, $post_id = ''){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	
	$heads = wpa_get_metrics_groups();
	unset($heads['awp-scores']);
	
	$html = '<ul class="wpas-metric-groups-tab">';
	foreach( $heads as $head ){
		$classes = array('clear');
		
		$score = (int)wpas_get_metric_score($post_id, $head['name']);
		$grade = wpas_get_metric_grade($post_id, $head['name']);
		
		// Get latest site revision and changes
		$change = 0;
		$revisions = new WP_Query(array( 
			'post_parent' => $post_id,
			'post_type'   => 'revision', 
			'numberposts' => 1,
			'post_status' => 'inherit',
			'orderby' => 'date'
		));
		
		if($revisions->have_posts()){
			while($revisions->have_posts()) : $revisions->the_post();
				$change = number_format((int)get_post_meta(get_the_ID(),'awp-scores-' . strtolower($head['name']), true));
			endwhile;
		}
		
		wp_reset_query();
		
		$classes[] = 'grade-' . $grade;
		
		$score = number_format($score, 0);
		$tens = substr($score, -1);
		if($tens <= 2){
			$label = "-{$score}%";
		} elseif($tens >= 7 and $tens <= 9) {
			$label = "+{$score}%";
		} else {
			$label = "{$score}%";
		}
		
		$html .=  sprintf(
			'<li><a class="%1$s" href="#%2$s">
				<span class="group"><strong>%4$s</strong></span>
				<span class="alignright wpas-metric-grade grade-%3$s grade">%3$s</span>
				<span class="description">Sample muna %5$s</span>
				<em class="score">%6$s</em>
				<small class="change">%7$s VS %8$s</small>
			</a></li>',
			implode(' ', $classes),
			$head['id'],
			$grade,
			$head['name'],
			$head['desc'],
			$label,
			$change,
			$score
		);
	}
	$html .= '</ul>';
	
	if( $echo ){ echo $html; } else { return $html; }
}

function wpas_site_network_feed($scho = true, $post_id = '', $limit = 10){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	$settings = get_option('awp_settings');
	
	$feedURL = get_post_meta($post_id, 'awp-rss', true);
	
	include_once( ABSPATH . WPINC . '/feed.php' );
	
	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed( $feedURL );
	
	if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
		// Figure out how many total items there are, but limit it to 5. 
		$maxitems = $rss->get_item_quantity( $limit ); 
	
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems );
	endif;
	
	$html = '<ul class="wpas-populars-slides slides">';
	
	if ( $maxitems > 0 ) :
		foreach ( $rss_items as $item ){
			$classes = array();
			$cat = $item->get_categories();
			if( $cats = $item->get_categories() ) :
				foreach( $cats as $cat ){
					$category = preg_replace('/[^A-Za-z0-9-]+/', '-', $cat->term);
					$classes[$category] = $category;
				}
			endif;
			
			set_time_limit(100);
			
			$thumbnail = null;
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $item->get_content(), $matches);
			
			if( $matches ){
				$i = 0;
				while($thumbnail === null){
					if( isset($matches[1][$i]) ){
						$args = getimagesize( $matches[1][$i] );
						if( $args[0] >= 150 && $args[1] >= 80 ):
							$thumbnail = PLUGINURL . 'timthumb.php?a=tl&w=355&h=170&src=' . $matches[1][$i];
						else:
							$thumbnail = null;
						endif;
					} else {
						$thumbnail = '';
					}
					$i++;
				}
			}
			
			if(empty($thumbnail)){ $thumbnail = PLUGINURL . 'timthumb.php?a=tl&w=355&h=170&src=' . $settings['default_feed_image']; }
			
			$title = (strlen($item->get_title()) > 30) ? substr($item->get_title(), 0, 27).'...' : $item->get_title();
			$excerpt = (strlen($item->get_content()) > 55) ? substr(strip_tags($item->get_content()), 0, 50).'...' : strip_tags($item->get_content());
			
			$details = sprintf(
				'<h3><a href="%s" title="%s">%s</a></h3> <p>%s <a href="%1$s" class="more">%s</a></p>',
				$item->get_permalink(),
				$item->get_title(),
				$title,
				$excerpt,
				__('Read more', 'wpas')
			);
			
			$html .= sprintf(
				'<li class="all %s"><a href="%2$s" title="Posted %3$s" target="_blank">%4$s</a> <div class="detail">%5$s</div></li>',
				implode(' ', $classes),
				$item->get_permalink(),
				$item->get_date('j F Y | g:i a'),
				sprintf('<img src="%s" alt="%s" />', $thumbnail, $item->get_title()),
				$details
			);
		}
	else:
		$html .= sprintf('<li>%s</li>', __('No feed found', 'wpas'));
	endif;
	
	$html .= '</ul>';
	
	if( $echo ){ echo $html; } else { return $html; }
}

function wpas_site_network_feed_categories($post_id = ''){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	
	$feedURL = get_post_meta($post_id, 'awp-rss', true);
	
	include_once( ABSPATH . WPINC . '/feed.php' );
	
	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed( $feedURL );
	
	if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
		// Figure out how many total items there are, but limit it to 5. 
		$maxitems = $rss->get_item_quantity( $limit ); 
	
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems );
	endif;
	
	$categories = array();
	if ( $maxitems > 0 ) :
		foreach ( $rss_items as $item ){
			if( $cats = $item->get_categories() ) :
				foreach( $cats as $cat ){
					$categories[preg_replace('/[^A-Za-z0-9-]+/', '-', $cat->term)] = $cat->term;
				}
			endif;
		}
	else:
		$categories = false;
	endif;
	
	return $categories;
}

function wpas_site_coveraged_feed($echo = true, $post_id = ''){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	$settings = get_option('awp_settings');
	
	$directs = array();
	if( $coveraged = get_the_terms($post_id, array('site-include')) ){
		foreach( $coveraged as $coverage ):
			$page_title = str_replace('@', '', $coverage->name);
			if( $post = get_page_by_title($page_title, OBJECT, 'show') )
				$directs[] = $post;
			if( $post = get_page_by_title($page_title, OBJECT, 'interviews') )
				$directs[] = $post;
			if( $post = get_page_by_title($page_title, OBJECT, 'reviews') )
				$directs[] = $post;
		endforeach;
	}
	
	$generals = wpas_get_sites_generally_related_posts($post_id);
	$shows = array_merge($generals, $directs);
	
	$i = 1;
	$html = '<ul class="wpas-coveraged-feed slides">';
	if($shows){
		foreach( $shows as $show ):
			if( is_archive() and $i > 1 ){
			} else {
				$classes = array('all');
				$classes[] = get_post_type($show->ID);
				
				$thumbnail = get_the_post_thumbnail($show->ID, array(345, 170));
				$default_img = sprintf(
					'<img src="%s" alt="Image:%s" width="345" class="%s" />',
					PLUGINURL . 'timthumb.php?a=tl&w=355&h=170&src=' . $settings['default_' . $show->post_type . '_image'],
					get_the_title($show->ID),
					is_archive() ? 'alignleft' : ''
				);
				
				$details = sprintf(
					'<h3><a href="%s" title="%s">%s</a></h3> <p>%s <a href="%1$s" class="more">%s</a> %s</p>',
					get_permalink($show->ID),
					get_the_title($show->ID),
					(strlen(get_the_title($show->ID)) > 30) ? substr(get_the_title($show->ID), 0, 27).'...' : get_the_title($show->ID),
					(strlen(strip_tags($show->post_content)) > 50) ? substr(strip_tags($show->post_content), 0, 47).'...' : strip_tags($show->post_content),
					__('Read more', 'wpas'),
					sprintf('<span class="alignleft post_type">%s</span>', $show->post_type)
				);
				
				$html .= sprintf(
					'<li class="%s"><a href="%s" title="%s">%s</a> <div class="detail">%s</div></a></li>',
					implode(' ', $classes),
					get_permalink($show->ID),
					get_the_title($show->ID),
					( has_post_thumbnail($show->ID) ) ? $thumbnail : $default_img,
					$details
				);
			}
			
			$i++;
		endforeach;
	} else {
		$html .= sprintf('<li>%s</li>', __('No coveraged feed found', 'wpas') );
	}
	$html .= '</ul>';
	
	if( $echo ){ echo $html; } else { return $html; }
}

function wpas_numbers_to_readable_size($n, $precision = 3){
	if ( !is_numeric( $n ) )
		return $n;
	
	$x = round($n);
	$x_number_format = number_format($x);
	$x_array = explode(',', $x_number_format);
	$x_parts = array('k', 'm', 'b', 't');
	
	$x_count_parts = count($x_array) - 1;
	
	$x_display = $x;
	$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
	$x_display .= $x_parts[$x_count_parts - 1];
	
	return trim($x_display);
}

function wpas_count_total_shares($post_id){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	
	$shares = array(
		'awp-shares-site-googleplus',
		'awp-shares-site-facebook',
		'awp-shares-site-twitter',
		'awp-shares-site-linkedin',
		'awp-shares-googleplus',
		'awp-shares-facebook',
		'awp-shares-twitter',
		'awp-shares-linkedin'
	);
	
	$total = 0;
	foreach( $shares as $share ){
		$total = $total + get_post_meta($post_id, $share, true);
	}
	
	return wpas_numbers_to_readable_size($total);
}

function wpas_count_total_suscribers($post_id){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	
	$subscribers = array(
		'awp-facebook-followers',
		'awp-twitter-followers',
		'awp-youtube-followers',
		'awp-googleplus-followers',
		'awp-linkedin-followers',
		'awp-pinterest-followers'
	);
	
	$total = 0;
	foreach( $subscribers as $subsriber ){
		$total = $total + get_post_meta($post_id, $subsriber, true);
	}
	
	return wpas_numbers_to_readable_size($total);
}

function wpas_get_authorit_ranks($echo = true, $post_id = ''){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	
	$ranks = array(
		'OneRank' => 'awp-one-rank',
		'Alexa' => 'awp-alexa-rank',
		// 'SEOMoz' => 'awp-moz-rank'
		'Technorati' => 'awp-tachnorati-rank',
		'Compete' => 'awp-compete-rank'
	);
	
	$return = '';
	$return .= '<ul class="wpas-authority-ranks">';
		
		foreach($ranks as $label=>$rank){
			$score = get_post_meta($post_id, $rank, true);
			$return .= sprintf(
				'<li><span class="rank-icon wpas-%1$s-icon">%s</span>%s<br class="clear" /></li>',
				$label,
				($score) ? wpas_numbers_to_readable_size($score) : 0
			);
		}
		
		if( is_archive() ){
			$return .= sprintf(
				'<li class="sites-subscription">
					<span class="rank-icon wpas-%1$s-icon">%s</span>%s<span class="socials">%s</span><br class="clear" />
				</li>',
				__('Subscribers', 'wpas'),
				wpas_count_total_suscribers($post_id),
				wpas_site_subscribers(false, $post_id)
			);
			
			$return .= sprintf(
				'<li><span class="rank-icon wpas-%1$s-icon">%s</span>%s<br class="clear" /></li>',
				__('Shares', 'wpas'),
				wpas_count_total_shares($post_id)
			);
		}
		
	$return .= '</ul>';
	
	if( $echo ){ echo $return; } else { return $return; }
}

function wpas_site_team($echo = true, $post_id = ''){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	
	$teams = array();
	if( $include_list = get_the_terms( $post_id, 'site-include' ) ) {
		foreach($include_list as $inc){
			$tagName = str_replace('@', '', $inc->name);
			$people = get_page_by_title($tagName, 'OBJECT', 'people');
			if( $people ){
				if( $tag_list = get_the_terms( $people, 'people-include' ) ){
					foreach($tag_list as $tag):
						$peopleTagName = str_replace('@', '', $tag->name);
						if($peopleTagName == get_the_title($post_id)){
							if( $user = get_user_by_display_name( $tagName ) ) {
								$teams[] = sprintf(
									'<li><a href="%1$s" title="%2$s">%3$s</a> %4$s</li>',
									get_author_posts_url($user->ID),
									$clean_name,
									get_avatar( $user->ID, 48 ),
									wpas_people_social_places(false, $user->ID, 'user')
								);
							} else {
								$email = get_post_meta($people->ID, '_base_people_email', true);
								$teams[] = sprintf(
									'<li><a href="%1$s" title="%2$s">%3$s</a> %4$s</li>',
									get_permalink($people->ID),
									get_the_title($people->ID),
									get_avatar( $email, 48 ),
									wpas_people_social_places(false, $people->ID)
								);
							}
						}
					endforeach;
				}
			}
		}
	}
	
	if( $teams ){
		$return = sprintf( '<ul class="wpas-site-team">%s</ul>', implode(' ', $teams));
	} else {
		$return = sprintf( '<p>%s</p>', __('No one is set as member of this team', 'wpas') );
	}
	
	if( $echo ){ echo $return; } else { return $return; }
}

function wpas_site_subscribers($echo = true, $post_id = ''){
	global $post;
	$post_id = (!$post_id) ? $post->ID : $post_id;
	
	$socials = array(
		'awp-facebook' => 'fa-facebook',
		'awp-twitter' => 'fa-twitter',
		'awp-googleplus' => 'fa-google-plus',
		'awp-linkedin' => 'fa-linkedin',
		'awp-youtube' => 'fa-youtube',
		'awp-pinterest' => 'fa-pinterest',
		'awp-rss' => 'fa-rss'
	);
	
	$labels = array(
		'fa-facebook' => 'Facebook',
		'fa-twitter' => 'Twitter',
		'fa-google-plus' => 'Google+',
		'fa-linkedin' => 'LinkedIn',
		'fa-youtube' => 'YouTube',
		'fa-pinterest' => 'Pinterest',
		'fa-rss' => 'RSS'
	);
	
	$html = '<ul class="wpas-social-subscribers">';
	foreach($socials as $meta_key=>$media){
		$url = get_post_meta($post_id, 'awp-url', true);
		$page = get_post_meta($post_id, $meta_key, true);
		
		$count = get_post_meta($post_id, $meta_key.'-followers', true);
		if( $count === null ) { $count = wpas_get_social_counts($media, $url, $page); }
		$count = (!$count) ? 0 : $count;
		
		if($page){
			$html .= sprintf(
				'<li><a href="%s" data-type="%s" data-text="%s" target="_blank" class="%s"><i class="fa %2$s fa-big"></i></a>
				%s %s</li>',
				$page,
				$media,
				'Follow',
				'wpa-sgl-icon '. $meta_key . '-icon',
				sprintf('<span class="count">%s</span>', wpas_numbers_to_readable_size($count) ),
				sprintf(
					'<a class="hover" href="%s" target="_blank"><i class="fa %s"></i> %s</a>',
					$page,
					$media,
					$labels[$media]
				)
			);
		}
	}
	$html .= '</ul>';
	
	if($echo){ echo $html; } else { return $html; }
}

function wpas_get_authority_level($echo = true, $post_id = '', $type = 'full'){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	
	$authority_level = get_post_meta($post_id, 'awp-authority-level', true);
	if( !$authority_level ){
		$authority_level = 0;
	}elseif( $authority_level > 5 ){
		$authority_level = 5;
	}
	
	if( $type == 'full' ){
		$return = sprintf('<ul class="wpas-site-rates wpas-authority-%s">', $authority_level);
			$i = 1;
			while($i <= 5){
				$active = ($i <= $authority_level) ? 'active' : '';
				$return .= sprintf(
					'<li><a href="javascript:void(0);" data-title="%s"><i class="auth-level fi-score-%s %s"></i></a></li>',
					__('Custom Tooltip text on hover', 'wpas'),
					$i,
					$active
				);
				$i++;
			}
		$return .= '</ul>';
	} else {
		$return .= sprintf('<p><i class="fi-score-%s active"></i></p>', $authority_level);
	}
	
	if( $echo ){ echo $return; } else { return $return; }
}

function wpas_get_sites_generally_related_posts($post_id = ''){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	
	$tag = '@'.$post->post_title;
	
	$termObj = get_terms( array(
			'site-include',
			'show-include',
			'interviews-include',
			'reviews-include'
		),
		array(
			'name__like' => $tag,
			'hide_empty' => true
		)
	);
	
	$terms = array();
	foreach($termObj as $term){
		$terms[] = $term->slug;
	}
	
	$query = new WP_Query(
		array(
			'post_type' => array('show', 'interviews', 'reviews'),
			'post_status' => array('future', 'publish'),
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'asc',
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'site-include',
					'field' => 'slug',
					'terms' => $terms,
					'operator' => 'IN'
				),
				array(
					'taxonomy' => 'show-include',
					'field' => 'slug',
					'terms' => $terms,
					'operator' => 'IN'
				),
				array(
					'taxonomy' => 'interviews-include',
					'field' => 'slug',
					'terms' => $terms,
					'operator' => 'IN'
				),
				array(
					'taxonomy' => 'reviews-include',
					'field' => 'slug',
					'terms' => $terms,
					'operator' => 'IN'
				)
			)
		)
	);
	
	$generals = array();
	if( $query->have_posts() ){
		while( $query->have_posts() ) : $query->the_post();
			$generals[] = $post;
		endwhile;
	}
	
	wp_reset_query();
	
	return $generals;
}
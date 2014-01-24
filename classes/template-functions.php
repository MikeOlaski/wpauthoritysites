<?php

function wpas_count_metric_scores($post_id, $metric){
	$groups = array();
	switch($metric){
		case 'awp-scores-site':
		break;
		
		case 'awp-scores-team':
		break;
		
		case 'awp-scores-authors':
		break;
		
		case 'awp-scores-framework':
		break;
		
		case 'awp-scores-content':
		break;
		
		case 'awp-scores-systems':
		break;
		
		case 'awp-scores-valuation':
		break;
		
		case 'awp-scores-links':
			$groups = array(
				'awp-google',
				'awp-alexa',
				'awp-yahoo',
				'awp-majestic'
			);
		break;
		
		case 'awp-scores-subscribers':
			$groups = array(
				'awp-facebook-followers',
				'awp-twitter-followers',
				'awp-youtube-followers',
				'awp-googleplus-followers',
				'awp-linkedin-followers',
				'awp-pinterest-followers'
			);
		break;
		
		case 'awp-scores-buzz':
			$groups = array(
				'awp-buzz-recent-comments',
				'awp-buzz-recent-posts',
				'awp-buzz-recent-shares',
				'awp-buzz-klout'
			);
		break;
		
		case 'awp-scores-shares':
			$groups = array(
				'awp-shares-site-googleplus',
				'awp-shares-site-facebook',
				'awp-shares-site-twitter',
				'awp-shares-site-linkedin',
				'awp-shares-googleplus',
				'awp-shares-facebook',
				'awp-shares-twitter',
				'awp-shares-linkedin'
			);
		break;
		
		case 'awp-scores-ranks':
			$groups = array(
				'awp-one-rank',
				'awp-alexa-rank',
				'awp-compete-rank',
				'awp-authority-rank',
				'awp-tachnorati-rank'
			);
		break;
	}
	
	$total = 0;
	foreach( $groups as $group ){
		$total = $total + (int)get_post_meta($post_id, $group, true);
	}
	$total = $total / count($groups);
	
	if( $total >= 0 and $total <= 100 ){
		$score = 50;
	} elseif( $total > 100 and $total < 1000 ) {
		$score = 60;
	} elseif( $total > 1000 and $total < 10000 ) {
		$score = 70;
	} elseif( $total > 10000 and $total < 100000 ) {
		$score = 80;
	} elseif( $total > 100000 and $total < 1000000 ) {
		$score = 90;
	} elseif( $total > 1000000 ){
		$score = 100;
	}
	
	return $score;
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
		
		$score = wpas_get_metric_score($post_id, $head['name']);
		$grade = wpas_get_metric_grade($post_id, $head['name']);
		$change = '163 VS 163';
		
		$classes[] = 'grade-' . $grade;
		
		$html .=  sprintf(
			'<li><a class="%1$s" href="#%2$s">
				<span class="alignright wpas-metric-grade grade-%3$s">%3$s</span>
				<span><strong>%4$s</strong></span>
				<span class="description">Sample muna %5$s</span>
				<em>%6$s</em>
				<small>%7$s</small>
			</a></li>',
			implode(' ', $classes),
			$head['id'],
			$grade,
			$head['name'],
			$head['desc'],
			$score,
			$change
		);
	}
	$html .= '</ul>';
	
	if( $echo ){ echo $html; } else { return $html; }
}

function wpas_site_network_feed($scho = true, $post_id = ''){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	
	$html = '';
	
	if( $echo ){ echo $html; } else { return $html; }
}

function wpas_site_coveraged_feed($echo = true, $post_id = ''){
	global $post;
	if( !$post_id ){ $post_id = $post->ID; }
	
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
	$html = '<ul class="wpas-coveraged-feed">';
	if($shows){
		foreach( $shows as $show ):
			if( is_archive() and $i > 1 ){
			} else {
				$thumbnail = get_the_post_thumbnail($show->ID, 'small', array('class' => 'alignleft'));
				$default_img = sprintf(
					'<img src="%s" alt="Image:%s" width="70" class="alignleft" />',
					PLUGINURL . 'images/placeholder.jpg',
					get_the_title($show->ID)
				);
				
				$html .= sprintf(
					'<li><a href="%1$s" title="%2$s">%3$s</a>
						<strong><a href="%1$s" title="%2$s">%2$s</a></strong>
						%4$s
					</li>',
					get_permalink($show->ID),
					get_the_title($show->ID),
					( has_post_thumbnail($show->ID) ) ? $thumbnail : $default_img,
					apply_filters('the_content', substr($show->post_content, 0, 35))
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
	$x = round($n);
	$x_number_format = number_format($x);
	$x_array = explode(',', $x_number_format);
	$x_parts = array('k', 'm', 'b', 't');
	
	$x_count_parts = count($x_array) - 1;
	
	$x_display = $x;
	$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
	$x_display .= $x_parts[$x_count_parts - 1];
	
	return $x_display;
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
		'SEOMoz' => 'awp-moz-rank'
	);
	
	$return = '';
	$return .= '<ul class="wpas-authority-ranks">';
		
		foreach($ranks as $label=>$rank){
			$score = get_post_meta($post_id, $rank, true);
			$return .= sprintf(
				'<li><span class="wpas-%1$s-icon">%s Rank</span>%s<br class="clear" /></li>',
				$label,
				($score) ? wpas_numbers_to_readable_size($score) : 0
			);
		}
		
		if( is_archive() ){
			$return .= sprintf(
				'<li><span class="wpas-%1$s-icon">%s Rank</span>%s<br class="clear" /></li>',
				__('Subscribers', 'wpas'),
				wpas_count_total_suscribers($post_id)
			);
			
			$return .= sprintf(
				'<li><span class="wpas-%1$s-icon">%s Rank</span>%s<br class="clear" /></li>',
				__('Shares', 'wpas'),
				wpas_count_total_shares($post_id)
			);
		}
		
	$return .= '</ul>';
	
	if( $echo ){ echo $return; } else { return $return; }
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
	
	$return = '<div class="wpas-site-rates">';
		
		if( $type == 'full' ){
			$return .= sprintf(
				'<img src="%s" alt="%s" />',
				PLUGINURL . 'images/wpas-authority-' . $authority_level . '.png',
				$authority_level
			);
		} else {
			$return .= sprintf(
				'<span class="%s" title="%s"></span>',
				'wpas-authority-level level-' . $authority_level,
				$authority_level
			);
		}
		
	$return .= '</div>';
	
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
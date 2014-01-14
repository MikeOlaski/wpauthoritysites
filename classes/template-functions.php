<?php

function get_sites_generally_related_posts(){
	global $post;
	
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
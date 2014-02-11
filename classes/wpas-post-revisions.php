<?php
/*
 * Site Custom Field revisions / History
 */

function wpas_filter_revisions_to_keep( $num, $post ) {
	if( 'site' == $post->post_type ) {
    	$num = true;
	}
	
	return $num;
}
add_filter( 'wp_revisions_to_keep', 'wpas_filter_revisions_to_keep', 10, 2 );

function wpas_save_post_revision( $post_id ) {
	$parent_id = wp_is_post_revision( $post_id );
	
	if ( $parent_id ) {
		$parent  = get_post($parent_id);
		$meta_data = get_post_meta($parent->ID);
		
		if ( $meta_data ){
			// Make sure that all meta data are saved by increasing the execution time limit
			set_time_limit(500);
			
			foreach( $meta_data as $key=>$meta ){
				add_metadata('post', $post_id, $key, $meta[0]);
			}
		}
	}
	
	return $post_id;
}
add_action( 'save_post', 'wpas_save_post_revision' );

function wpas_restore_post_revision( $post_id, $revision_id ) {
	$post     = get_post( $post_id );
	$revision = get_post( $revision_id );
	
	$meta_data = get_metadata('post', $revision->ID);
	if ( $meta_data ){
		foreach( $meta_data as $key=>$meta ){
			add_metadata('post', $post_id, $key, $meta[0]);
		}
	}
	
	return $post_id;
}
add_action( 'wp_restore_post_revision', 'wpas_restore_post_revision', 10, 2 );

function wpas_post_revision_fields( $fields ) {
	$fields = wpa_default_metrics();
	
	$metas = array('post_content' => 'Post Content');
	foreach($fields as $field){
		if( $field['type'] == 'heading' ){
			continue;
		} elseif( $field['type'] == 'subheading' ) {
			continue;
		} elseif( $field['type'] == 'separator' ) {
			continue;
		} else {
			$metas[$field['id']] = $field['name'];
		}
	}
	
	return $metas;
}
add_filter( '_wp_post_revision_fields', 'wpas_post_revision_fields' );

function wpas_post_revision_field( $value, $field ) {
	global $revision;
	
	if( $field == 'post_content' ){
		//continue;
	} else {
		$value = get_metadata( 'post', $revision->ID, $field, true );
	}
	
	return $value;
}
add_filter( '_wp_post_revision_field_my_meta', 'wpas_post_revision_field', 10, 2 );
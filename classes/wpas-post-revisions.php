<?php
/*
 * Site Custom Field revisions / History
 */

function wpas_save_post_revision( $post_id ) {
	$parent_id = wp_is_post_revision( $post_id );
	
	if ( $parent_id ) {
		$parent  = get_post($parent_id);
		$meta_data = get_post_meta($parent->ID);
		
		if ( $meta_data ){
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
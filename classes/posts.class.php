<?php

class Sites_CPT{
	
	function register_post_type(){
		$labels = array(
			'name' => 'WP Authorities',
			'singular_name' => 'Site',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Site',
			'edit_item' => 'Edit Site',
			'new_item' => 'New Site',
			'all_items' => 'All Sites',
			'view_item' => 'View Site',
			'search_items' => 'Search Sites',
			'not_found' =>  'No sites found',
			'not_found_in_trash' => 'No sites found in Trash', 
			'parent_item_colon' => '',
			'menu_name' => 'WP Authorities'
		);
		
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => false, 
			'query_var' => true,
			'rewrite' => array( 'slug' => 'site' ),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => PLUGINURL . 'images/favicon.ico',
			'supports' => array( 'title', 'thumbnail', 'excerpt', 'custom-fields' )
		);
		
		register_post_type('site', $args);
	}
	
	function register_taxonomies(){
	}
	
	// Add manage screen table
	function site_columns_head($defaults){
		unset($defaults['date']);
		$defaults['rank'] = __('Rank');
		$defaults['date'] = __('Date');
		return $defaults;
	}
	
	// Show custom column data
	function site_columns_content($column_name, $post_ID) {
		if ($column_name == 'rank') {
			$rank = get_post_meta($post_ID, 'rating', true);
			echo ($rank) ? __( $rank ) : __(0);
		}
	}
	
	// Orderby rank
	function site_orderby_rank(){
		global $wp_query;
		
		if( ! is_admin() )
			return;
		
		$orderby = $wp_query->get('orderby');
		
		if( 'Rank' == $orderby ) {
			$wp_query->set('meta_key', 'rating');
			$wp_query->set('orderby', 'meta_value_num');
		}
	}
	
	function add_meta_boxes(){
		add_meta_box(
            __('site_manage_meta'),
            __( 'Site Custom Settings', 'awp' ),
            array('Sites_CPT', 'metabox_fields'),
			'site'
        );
	}
	
	function metabox_fields( $post ){
		global $post;
		$post_id = $post->ID;
		
		if ( 'page' == $_REQUEST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return;
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
		}
		
		if(!$post)
			return;
		
		$exclude = get_post_meta($post_id, 'exclude_from_lists', true);
		$rank = get_post_meta($post_id, 'rating', true);
		
		?><table class="form-table">
        	<tr>
            	<th scope="row"><label for="exclude_from_lists"><strong>Exclude on Lists</strong></label></th>
                <td>
                	<input type="checkbox" name="exclude_from_lists" id="exclude_from_lists" value="true" <?php checked($exclude, 'true'); ?> />
                    <label for="exclude_from_lists">Exclude</label>
                </td>
            </tr>
        	<tr>
            	<th scope="row"><label for="rating"><strong>Rank:</strong></label></th>
                <td>
                	<input type="text" name="rating" id="rating" value="<?php echo ($rank) ? $rank : ''; ?>" />
                </td>
            </tr>
        </table><?php
	}
}

// Register Post Type
add_action( 'init', array('Sites_CPT', 'register_post_type') );

// Custom Sortable Columns
add_filter( 'manage_site_posts_columns', array('Sites_CPT', 'site_columns_head') );
add_filter( 'manage_edit-site_sortable_columns', array('Sites_CPT', 'site_columns_head') );
add_action( 'manage_site_posts_custom_column', array('Sites_CPT', 'site_columns_content'), 10, 2);

add_action( 'pre_get_posts', array('Sites_CPT', 'site_orderby_rank') );

// Add meta boxes
add_action( 'add_meta_boxes', array('Sites_CPT', 'add_meta_boxes') );
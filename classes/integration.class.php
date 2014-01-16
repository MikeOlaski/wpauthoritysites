<?php
/*
 * Integration Script for SuTheme BASE Module
 */

add_action( 'init', 'wpas_site_role_taxonomies', 0 );

function wpas_site_role_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Roles', 'taxonomy general name' ),
		'singular_name'     => _x( 'Role', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Role' ),
		'all_items'         => __( 'All Roles' ),
		'parent_item'       => __( 'Parent Role' ),
		'parent_item_colon' => __( 'Parent Role:' ),
		'edit_item'         => __( 'Edit Role' ),
		'update_item'       => __( 'Update Role' ),
		'add_new_item'      => __( 'Add New Role' ),
		'new_item_name'     => __( 'New Role Name' ),
		'menu_name'         => __( 'Role' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'roles' ),
	);

	register_taxonomy( 'people-role', array( 'people' ), $args );
}

add_action( 'add_meta_boxes', 'wpa_base_custom_boxes' );
add_action( 'save_post', 'wpa_base_custom_boxes_handle' );

function wpa_base_custom_boxes_handle( $post_id ){
	$fields = array('_base_people_fname', '_base_people_lname', '_base_people_email', '_base_people_website');
	
	foreach($fields as $field){
		if ( isset( $_POST[$field] ) ){
			update_post_meta( $post_id, $field, $_POST[$field] );
		}
	}
	
	return $post_id;
}

function wpa_base_custom_boxes(){
	add_meta_box( 'wpa_base_settings', 'People Custom Setting', 'wpa_base_people_metabox', 'people' );
}

function wpa_base_people_metabox( $post ){
	$fname = get_post_meta( $post->ID, '_base_people_fname', true );
	$lname = get_post_meta( $post->ID, '_base_people_lname', true );
	$email = get_post_meta( $post->ID, '_base_people_email', true );
	$website = get_post_meta( $post->ID, '_base_people_website', true );
	$urole = get_post_meta( $post->ID, '_base_people_role', true );
	
	?><table class="woo_metaboxes_table">
        <tr>
        	<th class="woo_metabox_names"><label class="selectit" for="_base_people_fname"><?php _e( "First Name", 'wpa' ); ?></label></th>
        	<td><input class="regular-text" type="text" id="_base_people_fname" name="_base_people_fname" value="<?php echo esc_attr( $fname ) ?>" /></td>
        </tr>
        
        <tr>
        	<th class="woo_metabox_names"><label class="selectit" for="_base_people_lname"><?php _e( "Last name", 'wpa' ); ?></label></th>
        	<td><input class="regular-text" type="text" id="_base_people_lname" name="_base_people_lname" value="<?php echo esc_attr( $lname ) ?>" /></td>
        </tr>
        
        <tr>
            <th class="woo_metabox_names"><label class="selectit" for="_base_people_email"><?php _e( "Email", 'wpa' ); ?></label></th>
            <td><input class="regular-text" type="text" id="_base_people_email" name="_base_people_email" value="<?php echo esc_attr( $email ) ?>" /></td>
        </tr>
        
        <tr>
            <th class="woo_metabox_names"><label class="selectit" for="_base_people_website"><?php _e( "Website", 'wpa' ); ?></label></th>
            <td><input class="regular-text" type="text" id="_base_people_website" name="_base_people_website" value="<?php echo esc_attr( $website ) ?>" /></td>
        </tr><?php
        
        /*<tr>
            <th class="woo_metabox_names"><label class="selectit" for="_base_people_role"><?php _e( "Role", 'wpa' ); ?></label></th>
            <td><select class="regular-text" type="text" id="_base_people_role" name="_base_people_role">
            	<option value="">Select a Role</option><?php
				get_dropdown_roles( $urole );
            ?></select></td>
        </tr>*/
	?></table><?php
}

function get_dropdown_roles( $selected = null ){
	global $wp_roles;
	
	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();
	
	foreach( $wp_roles->get_names() as $role=>$names ){
		?><option value="<?php echo $role; ?>" <?php selected($selected, $role); ?>><?php echo $names; ?></option><?php
	}
	
	// return $wp_roles->get_names();
}
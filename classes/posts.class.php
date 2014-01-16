<?php
!defined( 'ABSPATH' ) ? exit : '';

class Sites_CPT{
	
	var $fields;
	
	function __construct(){
		// Enqueue Scripts
		add_action( 'admin_head-post-new.php', array($this, 'site_manager_scripts') );
		add_action( 'admin_head-post.php', array($this, 'site_manager_scripts') );
		add_action( 'admin_head-edit.php', array($this, 'site_manager_scripts') );
		
		// Register Post Type
		add_action( 'init', array($this, 'register_post_type') );
		add_action( 'init', array($this, 'register_taxonomies') );
		
		// Register a Custom Post Status
		add_action( 'init', array($this, 'wpa_register_site_status') );
		
		// Remove Unnescessary filter objects
		add_action( 'wp', array($this, 'remove_alien_filters') );
		add_filter( 'parse_query', array($this, 'convert_term_id_to_taxonomy_term_in_query') );
		
		// Add Bulk action item
		add_filter( 'bulk_post_updated_messages', array($this, 'site_bulk_post_updated_messages_filter'), 10, 2 );
		add_action( 'admin_footer-edit.php', array($this, 'site_manager_bulk_action_item') );
		add_action( 'load-edit.php', array($this, 'site_manager_bulk_action_handle') );
		
		// Custom Sortable Columns
		add_filter( 'manage_site_posts_columns', array($this, 'site_columns') );
		add_filter( 'manage_edit-site_sortable_columns', array($this, 'site_columns_head') );
		add_action( 'manage_site_posts_custom_column', array($this, 'site_columns_content'), 10, 2);
		
		add_action( 'pre_get_posts', array($this, 'site_orderby_rank') );
		add_action( 'pre_get_posts', array($this, 'admin_quicklinks_callback') );
		
		// Add meta boxes
		add_action( 'add_meta_boxes', array($this, 'add_meta_boxes') );
		add_action( 'save_post', array($this, 'save_post') );
		
		// Add another row action
		add_filter('post_row_actions', array($this, 'add_action_row'), 10, 2);
		
		// Add filter
		add_action( 'restrict_manage_posts', array($this, 'filter_restrict_manage_posts_site'), 10 );
		
		// View Groups
		add_action( 'admin_footer-edit.php', array($this, 'wpas_view_groups') );
	}
	
	function wpas_view_groups(){
		$settings = get_option('awp_settings');
		global $post;
		
		$fields = wpa_default_metrics();
		$departmentColumns = array();
		$metricsColumns = array();
		foreach( $fields as $field ){
			if( $field['type'] == 'heading' ) {
				if($field['category'] == 'departments'){
					$departmentColumns[$field['id']] = $field['name'];
				} else {
					$metricsColumns[$field['id']] = $field['name'];
				}
			}
		}
		
		if( $post->post_type == 'site' ){
			?><div rel="wpas-view-groups" style="display:none;">
				<ul class="subsubsub clear">
                	<li><span><strong>Workflow:</strong></span></li>
					<li><a href="javascript:void(0);" data-column="action" class="wpa-views">Action</a></li>
				</ul>
				<ul class="subsubsub clear">
                	<li><span><strong>Departments:</strong></span></li><?php
					$i = 1;
					foreach( $departmentColumns as $id=>$name ){
						?><li>
							<a href="javascript:void(0);" data-column="<?php echo $id; ?>" class="wpa-views"><?php
                            echo $name;
							?></a><?php
							if( $i < count($departmentColumns) ){ echo '|'; }
							$i++;
						?></li><?php
					}
				?></ul>
				<ul class="subsubsub clear">
                	<li><span><strong>Metrics:</strong></span></li><?php
					$i = 1;
					foreach( $metricsColumns as $id=>$name ){
						?><li>
							<a href="javascript:void(0);" data-column="<?php echo $id; ?>" class="wpa-views"><?php
                            echo $name;
							?></a><?php
							if( $i < count($metricsColumns) ){ echo '|'; }
							$i++;
						?></li><?php
					}
				?></ul>
				<ul class="subsubsub clear">
                	<li><span><strong>Quicklinks:</strong></span></li>
					<li><a href="<?php echo admin_url('edit.php?post_type=site&site-type=wordpress'); ?>"><?php _e('WordPress Sites', 'wpas'); ?></a> |</li>
					<li><a href="<?php echo admin_url('edit.php?site-type=authority+NotWordpress&post_type=site'); ?>"><?php _e('Authority Sites', 'wpas'); ?></a> |</li>
					<li><a href="<?php echo admin_url('edit.php?post_type=site&site-type=authority+wordpress'); ?>"><?php _e('WordPress Authority Sites', 'wpas'); ?></a> |</li>
                    <li><a href="<?php echo admin_url('edit.php?post_type=site&site-type=featured'); ?>"><?php _e('Featured Sites', 'wpas'); ?></a> |</li>
					<li><a href="<?php echo admin_url('edit.php?post_type=site'); ?>"><?php _e('Sites', 'wpas'); ?></a> |</li>
					<li><a href="<?php echo admin_url('edit.php?post_status=uncheck&post_type=site'); ?>"><?php _e('UnChecked', 'wpas'); ?></a> |</li>
					<li><a href="<?php echo admin_url('edit.php?post_type=site&site-status=NotAudited'); ?>"><?php _e('UnAudited Sites', 'wpas'); ?></a> |</li>
                    <li><a href="<?php echo admin_url('edit.php?post_type=site&quicklinks=archive'); ?>"><?php _e('Front End Archives', 'wpas'); ?></a></li>
				</ul>
				<div class="clear"></div>
			</div>
			
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					var viewGroupsTemplate = $('div[rel=wpas-view-groups]').clone();
					viewGroupsTemplate.attr('class', 'wpas-view-groups clear').removeAttr('rel');
					viewGroupsTemplate.insertAfter('.wrap .subsubsub:first').show();
					
					$('div[rel=wpas-view-groups]').remove();
				});
			</script><?php
		}
	}
	
	function admin_quicklinks_callback( $query ){
		$settings = get_option('awp_settings');
		global $post;
		
		if ( is_admin() && $query->is_main_query() ) {
			if( isset($_REQUEST['quicklinks']) ){
				global $paged; $paged = 1; // Fix for the WordPress 3.0 "paged" bug.
				if ( get_query_var( 'paged' ) && ( get_query_var( 'paged' ) != '' ) ) { $paged = get_query_var( 'paged' ); }
				if ( get_query_var( 'page' ) && ( get_query_var( 'page' ) != '' ) ) { $paged = get_query_var( 'page' ); }
				$query->set("paged", $paged);
				
				if($wpa_settings['sites_default_orderby'] != 'title'){
					$orderby = 'meta_value_num';
					$query->set("meta_key", $wpa_settings['sites_default_orderby']);
				} else {
					$orderby = (isset($wpa_settings['sites_default_orderby']) ? $wpa_settings['sites_default_orderby'] : 'ID');
				}
				$query->set("orderby", $orderby);
				
				$order = (isset($wpa_settings['sites_default_order']) ? $wpa_settings['sites_default_order'] : 'asc');
				$query->set("order", $order);
				
				$query->set("tax_query", apply_filters('wpa_archive_wp_query', $query ) );
			}
		}
		
		return $query;
	}
	
	function filter_restrict_manage_posts_site(){
		$type = isset($_GET['post_type']) ? $_GET['post_type'] : 'post';
		$settings = get_option('awp_settings');
		
		if ('site' == $type){
			$statuses = get_terms('site-status', array(
				'orderby' 		=> 'count',
				'hide_empty'	=> 0
			));
			
			$types = get_terms('site-type', array(
				'orderby' 		=> 'count',
				'hide_empty'	=> 0
			));
			
			?><select name="site-status">
            	<option value=""><?php _e('Filter Status By ', 'wpa'); ?></option><?php
				$current_s = isset($_GET['site-status']) ? $_GET['site-status'] : '';
				foreach ($statuses as $status) {
					if( $settings['hide_timestamp'] == 'true' && preg_match('/[;|:]/', $status->name, $matches) ){
						// continue;
					} else {
						?><option value="<?php echo $status->slug ?>" <?php selected( $current_s, $status->slug ); ?>><?php echo $status->name; ?></option><?php
					}
                }
        	?></select>
            
            <select name="site-type">
            	<option value=""><?php _e('Filter Type By ', 'wpa'); ?></option><?php
				$current_t = isset($_GET['site-type']) ? $_GET['site-type'] : '';
				foreach ($types as $type) {
					?><option value="<?php echo $type->slug ?>" <?php selected( $current_t, $type->slug ); ?>><?php echo $type->name; ?></option><?php
                }
        	?></select><?php
		}
	}
	
	function add_action_row($actions, $post){
		$acts = array();
		if ($post->post_type == "site" && $post->post_status != 'trash'){
			$audit = add_query_arg(
				array(
					'post_type' => 'site',
					'action' => 'evaluate',
					'post' => array($post->ID)
				),
				'edit.php'
			);
			$wp_checker = add_query_arg(
				array(
					'post_type' => 'site',
					'action' => 'wp_checker',
					'post' => array($post->ID)
				),
				'edit.php'
			);
			$auth_checker = add_query_arg(
				array(
					'post_type' => 'site',
					'action' => 'auth_checker',
					'post' => array($post->ID)
				),
				'edit.php'
			);
			$acts['audit'] = sprintf('<a class="auditinline" data-id="%s" href="%s" title="Audit this item">Audit</a>', $post->ID, $audit );
			$acts['wp_checker'] = sprintf('<a class="wpchecker" data-id="%s" href="%s" title="Check if this item is a WordPress Site">Check for WordPress</a>', $post->ID, $wp_checker );
			$acts['auth_checker'] = sprintf('<a class="auth_checker" data-id="%s" href="%s" title="Check if this item is a Authority Site">Check for Authority</a>', $post->ID, $auth_checker );
		}
		$actions = wp_parse_args($actions, $acts);
		return $actions;
	}
	
	function set_fields($fields){
		$this->fields = $fields;
	}
	
	function register_post_type(){
		$labels = array(
			'name' => 'Sites',
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
			'menu_name' => 'Sites'
		);
		
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => array( 'slug' => 'sites' ),
			'taxonomies' => array('site-category', 'site-tags'),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => 2,
			'menu_icon' => PLUGINURL . 'images/favicon.ico',
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' )
		);
		
		register_post_type('site', $args);
	}
	
	function register_taxonomies(){
		$labels = array(
			'name'              => _x( 'Categories', 'taxonomy general name' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Category' ),
			'all_items'         => __( 'All Categories' ),
			'parent_item'       => __( 'Parent Category' ),
			'parent_item_colon' => __( 'Parent Category:' ),
			'edit_item'         => __( 'Edit Category' ),
			'update_item'       => __( 'Update Category' ),
			'add_new_item'      => __( 'Add New Category' ),
			'new_item_name'     => __( 'New Category Name' ),
			'menu_name'         => __( 'Category' ),
		);
	
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'site-category' ),
		);
	
		register_taxonomy( 'site-category', array( 'site' ), $args );
		
		$labels = array(
			'name'                       => _x( 'Tags', 'taxonomy general name' ),
			'singular_name'              => _x( 'Tag', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Tags' ),
			'popular_items'              => __( 'Popular Tags' ),
			'all_items'                  => __( 'All Tags' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Tag' ),
			'update_item'                => __( 'Update Tag' ),
			'add_new_item'               => __( 'Add New Tag' ),
			'new_item_name'              => __( 'New Tag Name' ),
			'separate_items_with_commas' => __( 'Separate tags with commas' ),
			'add_or_remove_items'        => __( 'Add or remove tags' ),
			'choose_from_most_used'      => __( 'Choose from the most used tags' ),
			'not_found'                  => __( 'No tags found.' ),
			'menu_name'                  => __( 'Tags' ),
		);
	
		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'site-tag' ),
		);
	
		register_taxonomy( 'site-tag', 'site', $args );
		
		$actiontaxes = array(
			'site-action' => 'Action',
			'site-status' => 'Status',
			'site-include' => 'Include',
			'site-topic' => 'Topic',
			'site-type' => 'Type',
			'site-location' => 'Location',
			'site-assignment' => 'Assignment'
		);
		
		foreach( $actiontaxes as $tax=>$label ){
			register_taxonomy(
				$tax,
				'site',
				array(
					'labels' => array(
						'name'                       => _x( $label, 'taxonomy general name' ),
						'singular_name'              => _x( $label, 'taxonomy singular name' ),
						'search_items'               => __( 'Search '.$label ),
						'popular_items'              => __( 'Popular '.$label ),
						'all_items'                  => __( 'All '.$label ),
						'parent_item'                => null,
						'parent_item_colon'          => null,
						'edit_item'                  => __( 'Edit '.$label ),
						'update_item'                => __( 'Update '.$label ),
						'add_new_item'               => __( 'Add New '.$label ),
						'new_item_name'              => __( 'New '.$label.' Name' ),
						'separate_items_with_commas' => __( 'Separate '.$label.' with commas' ),
						'add_or_remove_items'        => __( 'Add or remove '.$label ),
						'choose_from_most_used'      => __( 'Choose from the most used '.$label ),
						'not_found'                  => __( 'No '.$label.' found.' ),
						'menu_name'                  => __( $label ),
					),
					'rewrite' => array( 'slug' => $tax ),
					'hierarchical' => true,
				)
			);
		}
	}
	
	function wpa_register_site_status(){
		register_post_status( 'uncheck', array(
			'label'	=> _x( 'Unchecked', 'post' ),
			'public' => true,
			'exclude_from_search' => false,
			'show_in_admin_all_list' => true,
			'show_in_admin_status_list' => true,
			'label_count' => _n_noop( 'Unchecked <span class="count">(%s)</span>', 'Unchecked <span class="count">(%s)</span>' )
		));
	}
	
	// Add manage screen table
	function site_columns_head($defaults){
		$defaults['rank'] = __('Rank');
		$defaults['date'] = __('Date');
		
		return $defaults;
	}
	
	function site_columns( $defaults ){
		global $fields;
		$fields = $this->fields;
		
		// Remove Default Columns
		unset($defaults['date']);
		unset($defaults['status']);
		
		// Remove WP SEO Columns
		unset($defaults['wpseo-score']);
		unset($defaults['wpseo-title']);
		unset($defaults['wpseo-metadesc']);
		unset($defaults['wpseo-focuskw']);
		
		$defaults['site-action'] = __('Action');
		$defaults['site-status'] = __('Status');
		$defaults['site-include'] = __('Include');
		$defaults['site-topic'] = __('Topic');
		$defaults['site-type'] = __('Type');
		$defaults['site-location'] = __('Location');
		$defaults['site-assignment'] = __('Assignment');
		$defaults['rank'] = __('Rank');
		$defaults['date'] = __('Date');
		
		foreach($fields as $fl){
			if(('heading' == $fl['type']) || ('separator' == $fl['type'])){
				continue;
			} else {
				$defaults[$fl['id']] = __($fl['name']);
			}
		}
		
		return $defaults;
	}
	
	// Show custom column data
	function site_columns_content($column_name, $post_ID) {
		$settings = get_option('awp_settings');
		
		switch($column_name){
			case 'rank':
				$rank = get_post_meta($post_ID, 'rating', true);
				$rank = ($rank) ? $rank : get_post_meta($post_ID, 'awp-alexa-rank', true);
				echo ($rank) ? __( $rank ) : __(0);
				break;
			
			case 'site-status':
				$terms = wp_get_post_terms( $post_ID, $column_name );
				
				if( $terms ){
					$max = count($terms);
					$i = 1;
					$content = array();
					foreach( $terms as $tm ){
						if( $settings['hide_timestamp'] == 'true' ){
							if( !preg_match('/[;|:]/', $tm->name, $matches) ){
								$tlink = sprintf( 'edit.php?post_type=site&%s=%s', $column_name, $tm->slug );
								$content[] = '<a href="' . $tlink . '">' . $tm->name . '</a>';
							}
						} else {
							$tlink = sprintf( 'edit.php?post_type=site&%s=%s', $column_name, $tm->slug );
							$content[] = '<a href="' . $tlink . '">' . $tm->name . '</a>';
                            // if($i < $max){ echo ', '; }
						}
						$i++;
					}
					
					echo implode(', ', $content);
				} else {
					echo '—';
				}
				break;
			
			case 'taxonomy-site-category':
			case 'site-action':
			case 'site-status':
			case 'site-include':
			case 'site-topic':
			case 'site-type':
			case 'site-location':
			case 'site-assignment':
				$terms = wp_get_post_terms( $post_ID, $column_name );
				
				if( $terms ){
					$max = count($terms);
					$i = 1;
					foreach( $terms as $tm ){
						$tlink = sprintf( 'edit.php?post_type=site&%s=%s', $column_name, $tm->slug );
						?><a href="<?php echo $tlink; ?>"><?php echo $tm->name; ?></a><?php
						if($i < $max){ echo ', '; }
						$i++;
					}
				} else {
					echo '—';
				}
				break;
			
			default:
				$meta = get_post_meta($post_ID, $column_name, true);
				echo $meta;
				break;
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
            __( 'WordPress Authority Site Details', 'awp' ),
            array('Sites_CPT', 'metabox_fields'),
			'site'
        );
		
		add_meta_box(
            __('site_manage_evaluate'),
            __( 'WordPress Authority Tools', 'awp' ),
            array('Sites_CPT', 'metabox_evaluate'),
			'site',
			'side',
			'high'
        );
	}
	
	function metabox_evaluate(){
		global $post;
		
		$content = sprintf('<p>%s</p>', __('Click on "<tt>Audit</tt>" link to grab all the metrics of this site', 'wpas'));
		
		if( $audit = get_post_meta($post->ID, '_wpa_last_audit', true) ){
			$audit = sprintf('<small>(Last run %s)</small>', date('y.m.d;H:i', strtotime($audit)) );
		} else {
			$audit = '<small>(Never ran)</small>';
		}
		
		if( $check4wp = get_post_meta($post->ID, '_wpa_last_wpcheck', true) ){
			$check4wp = sprintf('<small>(Last run %s)</small>', date('y.m.d;H:i', strtotime($audit)) );;
		} else {
			$check4wp = '<small>(Never ran)</small>';
		}
		
		$content .= '<ul>';
			$content .= sprintf(
				'<li><a class="wpa-post-tools" id="awp-evaluate" href="javascript:void(0);">%s</a> %s</li>',
				'Run Auditor',
				$audit
			);
			$content .= sprintf(
				'<li><a class="wpa-post-tools" id="awp-wp-checker" id="" href="javascript:void(0);">%s</a> %s</li>',
				'Check for Wordpress',
				$check4wp
			);
			$content .= sprintf(
				'<li><a class="wpa-post-tools" id="awp-authority-checker" id="" href="javascript:void(0);">%s</a> %s</li>',
				'Check for Authority',
				$check4Au
			);
		$content .= '</ul>';
		
        $content .= sprintf('<img src="%s" class="preloader" align="preload" style="display:none;" />', PLUGINURL . '/images/preload.gif');
		
		echo $content;
	}
	
	function add_filter_boxes(){
		global $typenow;
		global $wp_query;
		
		$screen = get_current_screen();
		
		if ($typenow == 'site') {
			
			$actiontaxes = array(
				'site-category',
				'site-tag',
				'site-action',
				'site-status',
				'site-include',
				'site-topic',
				'site-type',
				'site-location',
				'site-assignment'
			);
			
			foreach( $actiontaxes as $taxonomy ){
				$taxonomies = get_taxonomy($taxonomy);
				$terms = get_terms( $taxonomy, array('hide_empty' => false) );
				?><select name="<?php echo $taxonomy ?>">
					<option value="0">Select All <?php echo $taxonomies->label; ?></option><?php
					foreach($terms as $tx){
						?><option value="<?php echo $tx->slug; ?>"><?php echo $tx->name; ?></option><?php
					}
				?></select><?php
			}
		}
	}
	
	function convert_term_id_to_taxonomy_term_in_query($query) {
		global $pagenow;
		$qv = &$query->query_vars;
		$actiontaxes = array(
			'site-category',
			'site-tag',
			'site-action',
			'site-status',
			'site-include',
			'site-topic',
			'site-type',
			'site-location',
			'site-assignment'
		);
		if ($pagenow=='edit.php' &&
				isset($qv['taxonomy']) && in_array($qv['taxonomy'], $actiontaxes) &&
				isset($qv['term']) && is_numeric($qv['term'])) {
			$term = get_term_by( 'id', $qv['term'], $qv['taxonomy'] );
			$qv['term'] = $term->slug;
		}
	}
	
	function metabox_fields( $post ){
		global $post, $fields;
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
		
		$disabled = array();
		$headings = wpa_get_metrics_groups();
		?><div id="awp_tabs" class="awp_meta_box">
			<ul class="awp-tabber">
            	<li class="awp-tab not-tab ui-state-disabled"><a href="javascript:void(0);">Departments</a></li><?php
                	$depts = wpa_get_metrics_group_by_category('departments');
					foreach($depts as $head){
						?><li class="awp-tab"><a href="#<?php echo $head['id']; ?>"><?php echo $head['name']; ?></a>
                            <div class="wp-menu-arrow"><div></div></div></li><?php
					}
				?><li class="wp-not-current-submenu wp-menu-separator not-tab"><div class="separator"></div></li>
                <li class="awp-tab not-tab ui-state-disabled"><a href="javascript:void(0);">Metrics</a></li><?php
                	$depts = wpa_get_metrics_group_by_category('metrics');
					foreach($depts as $head){
						?><li class="awp-tab"><a href="#<?php echo $head['id']; ?>"><?php echo $head['name']; ?></a>
                            <div class="wp-menu-arrow"><div></div></div></li><?php
					}
				/*?><li class="wp-not-current-submenu wp-menu-separator not-tab"><div class="separator"></div></li>
				<li class="awp-tab not-tab ui-state-disabled"><a href="javascript:void(0);">Valuation</a></li><?php
					$depts = wpa_get_metrics_group_by_category('valuation');
					foreach($depts as $head){
						?><li class="awp-tab"><a href="#<?php echo $head['id']; ?>"><?php echo $head['name']; ?></a>
                            <div class="wp-menu-arrow"><div></div></div></li><?php
					}*/
			?></ul>
            
            <div class="awp-panels"><?php
            	
				foreach( $fields as $panel ){
					if( $panel['type'] == 'heading' ){
						?><div id="<?php echo $panel['id']; ?>" class="panel">
							<h2 class="awp-settins-title"><?php echo $panel['name']; ?> Settings</h2><?php
							
							$controls = array();
							foreach( $fields as $control ){
								if( $control['group'] == $panel['id'] ){
									$controls[] = $control;
								}
							}
							
							Sites_CPT::site_manager_meta_fields( $controls );
							
						?></div><?php
					}
				}
				
            ?></div>
            <div class="clear"></div>
            
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				var index = $('.awp-tabber li:not(li.not-tab)').first().index();
                $('#awp_tabs').tabs({ disabled: [<?php echo implode(',', $disabled); ?>], active: index });
				
				$('.image_upload_button').click(function(e) {
					var send_attachment_bkp = wp.media.editor.send.attachment;
					var button = $(this);
					var id = button.attr('id').replace('_button', '_upload');
					var image = button.attr('id').replace('_button', '');
					
					_custom_media = true;
					wp.media.editor.send.attachment = function(props, attachment){
						if ( _custom_media ) {
							$("#"+id).val(attachment.url);
							$("#image_"+image).attr('src', attachment.url);
						} else {
							return _orig_send_attachment.apply( this, [props, attachment] );
						};
					}
					
					wp.media.editor.open(button);
					return false;
				});
            });
		</script>
        
        <div class="clear"></div><?php
	}
	
	function site_manager_meta_fields( $controls ){
		global $post;
		
		if(!$post)
			return;
		
		if( empty($controls) )
			return;
		
		$post_id = $post->ID;
		
		foreach($controls as $control){
			
			$metaname = $control['id'];
			$metaID = 'awp-'.$control['id'];
			$metavalue = get_post_meta( $post_id, $metaname, true );
			
			?><div class="awp-control-group"><?php
			if($control['type'] == 'subheading'){
				?><h2 class="awp-settins-subtitle" id="<?php echo $metaID; ?>"><?php echo $control['name'] ?></h2><?php
			} else {
				
				?><label for="<?php echo $metaID; ?>"><?php echo $control['name'] ?></label>
                <div class="awp-controls"><?php
					
					switch( $control['type'] ){
						case 'text':
							?><input type="text" class="regular-text" name="<?php echo $metaname; ?>" id="<?php echo $metaID; ?>" value="<?php echo $metavalue; ?>" />
							<br /><span class="description"><?php echo $control['desc']; ?></span><?php
							break;
						
						case 'checkbox':
							?><input type="checkbox" class="regular-checkbox" name="<?php echo $metaname; ?>" id="<?php echo $metaID; ?>" value="true" <?php checked($metavalue, 'true'); ?> />
                            <span class="description"><?php echo $control['desc']; ?></span><?php
							break;
						
						case 'checkbox2':
							$i = 1;
							foreach( $control['options'] as $value=>$option ){
								$checked = in_array($value, $metavalue) ? 'checked="checked"' : '';
								?><input type="checkbox" class="regular-checkbox" name="<?php echo $metaname; ?>[]" id="<?php echo $metaID; ?>-<?php echo $i; ?>" value="<?php echo $value; ?>" <?php echo $checked; ?> />
                                <label for="<?php echo $metaID; ?>-<?php echo $i; ?>"><?php echo $option; ?></label><br /><?php
								$i++;
							}
							?><br /><span class="description"><?php echo $control['desc']; ?></span><?php
							break;
						
						case 'radio':
							$i = 1;
							foreach( $control['options'] as $value=>$option ){
								?><input type="radio" class="regular-radio" name="<?php echo $metaname; ?>" id="<?php echo $metaID; ?>-<?php echo $i; ?>" value="<?php echo $value; ?>" <?php checked($value, $metavalue); ?> />
                                <label for="<?php echo $metaID; ?>-<?php echo $i; ?>"><?php echo $option; ?></label><br /><?php
								$i++;
							}
							?><br /><span class="description"><?php echo $control['desc']; ?></span><?php
							break;
						
						case 'select':
							?><select class="regular-select" name="<?php echo $metaname; ?>" id="<?php echo $metaID; ?>">
                                <option value="0" <?php selected($metavalue, 0); ?>>Select to return to default</option><?php
                                foreach( $control['options'] as $value=>$option ){
                                    ?><option value="<?php echo $value; ?>" <?php selected($metavalue, $value); ?>><?php echo $option; ?></option><?php
                                }
                            ?></select>
                            <br /><span class="description"><?php echo $control['desc']; ?></span><?php
							break;
						
						case 'textarea':
							?><textarea class="regular-textarea" name="<?php echo $metaname; ?>" id="<?php echo $metaID; ?>"><?php echo stripslashes($metavalue); ?></textarea>
                            <br /><span class="description"><?php echo $control['desc']; ?></span><?php
							break;
						
						case 'upload':
							?><input type="text" class="regular-text of-input" name="<?php echo $metaname; ?>" id="<?php echo $metaID; ?>_upload" value="<?php echo $metavalue; ?>" /><?php
							if( !empty($metavalue) ) {
								?><br /><a class="of-uploaded-image" href="<?php echo $metavalue; ?>"><img class="of-option-image" id="image_<?php echo $metaID; ?>" src="<?php echo $metavalue; ?>" alt="" /></a><br /><?php
							}
							?><span class="button image_upload_button" id="<?php echo $metaID; ?>_button">Upload Image</span><?php
					}
				?></div><?php
				
				if($control['followers']){
					?><label for="<?php echo $metaID.'-followers'; ?>"><?php echo $control['name'].' followers' ?></label>
					<div class="awp-controls">
                    	<input type="text" class="regular-text small" name="<?php echo $metaname.'-followers'; ?>" id="<?php echo $metaID.'-followers'; ?>" value="<?php echo get_post_meta($post_id, $metaname.'-followers', true); ?>" />
                        <span class="button manual_update_button">Update</span>
                        <span class="button run_audit_button">Audit</span>
                        
                        <img src="<?php echo PLUGINURL; ?>images/preload.gif" class="preloader" style="display:none;">
                        
                        <br /><span class="description">Last updated: <?php
						echo get_post_meta($post, $metaname.'-updated', true); ?> by <?php
						echo get_post_meta($post, $metaname.'-updater', true);
						?></span>
					</div><?php
				}
				
                ?><div class="clear"></div><?php
			}
            ?></div><?php
		}
	}
	
	function save_post( $post_id ){
		global $fields;
		
		if(!$post_id)
			return;
		
		foreach( $fields as $fl ){
			if('heading' == $fl['type']){
				continue;
			} else {
				if( isset($_POST[$fl['id']]) and (NULL != $_POST[$fl['id']]) ){
					update_post_meta( $post_id, $fl['id'], $_POST[$fl['id']] );
				} else {
					delete_post_meta( $post_id, $fl['id'] );
				}
			}
		}
		
		return;
	}
	
	function site_manager_scripts(){
		get_currentuserinfo();
		global $post, $user_ID;
		
		if( ('site' == $post->post_type) || ('site' == $_GET['post_type']) ){
			wp_enqueue_script('jquery');
			wp_enqueue_style( 'awpeditor', PLUGINURL . '/css/editor.css' );
			wp_enqueue_script( 'awpeditor', PLUGINURL . '/js/editor.js', array('jquery') );
			
			$view = get_user_meta($user_ID, 'user_defined_view', true);
			
			$fields = wpa_default_metrics();
			$columns = array();
			foreach( $fields as $field ){
				if( $field['type'] == 'heading' ) {
					// continue
				} elseif( $field['type'] == 'separator' ) {
					// continue;
				} else {
					$columns[$field['group']][] = $field['id'];
				}
			}
			
			wp_localize_script( 'awpeditor', 'WPAJAX_OBJ',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'post_url' => admin_url('post.php'),
					'manage_Screen' => admin_url('edit.php?post_type=site'),
					'defined_view' => $view,
					'fields' => $columns
				)
			);
		}
	}
	
	function site_manager_bulk_action_item(){
		global $post;
		
		if($post->post_type == 'site' && $post->post_status != 'trash') {
			?><script type="text/javascript">
				jQuery(document).ready(function($) {
					jQuery('<option>').val('evaluate').text('Audit').appendTo("select[name='action']");
					jQuery('<option>').val('evaluate').text('Audit').appendTo("select[name='action2']");
					
					jQuery('<option>').val('auth_checker').text('Check for Authority').appendTo("select[name='action']");
					jQuery('<option>').val('auth_checker').text('Check for Authority').appendTo("select[name='action2']");
					
					jQuery('<option>').val('wp_checker').text('Check for Wordpress').appendTo("select[name='action']");
					jQuery('<option>').val('wp_checker').text('Check for Wordpress').appendTo("select[name='action2']");
					
					<?php if( isset($_REQUEST['audited']) ){ ?>
						<?php if(!empty($_REQUEST['audited'])){ ?>
							var message = '<div id="message" class="updated"><p><?php echo sprintf( _n( '%s post audited.', '%s posts audited.', $_REQUEST['audited'] ), number_format_i18n( $_REQUEST['audited'] ) ); ?></p></div>';
						<?php } ?>
						$('div.wrap h2').after( message );
					<?php } ?>
				});
			</script><?
		}
	}
	
	function site_bulk_post_updated_messages_filter( $bulk_messages, $bulk_counts ) {
		$bulk_messages['site'] = array(
			'updated'   => _n( '%s site updated.', '%s sites updated.', $bulk_counts['updated'] ),
			'locked'    => _n( '%s site not updated, somebody is editing it.', '%s sites not updated, somebody is editing them.', $bulk_counts['locked'] ),
			'deleted'   => _n( '%s site permanently deleted.', '%s sites permanently deleted.', $bulk_counts['deleted'] ),
			'trashed'   => _n( '%s site moved to the Trash.', '%s sites moved to the Trash.', $bulk_counts['trashed'] ),
			'untrashed' => _n( '%s site restored from the Trash.', '%s sites restored from the Trash.', $bulk_counts['untrashed'] )
		);
	
		return $bulk_messages;
	}
	
	function site_manager_bulk_action_handle(){
		if ( (isset($_REQUEST['action']) && 'evaluate' == $_REQUEST['action']) || (isset($_REQUEST['action2']) && 'evaluate' == $_REQUEST['action2']) ) {
			if( $_REQUEST['post'] ){
				$ids = array();
				foreach($_REQUEST['post'] as $data){
					$url = get_post_meta($data, 'awp-url', true);
					if(!$url){
						$url = 'http://' . get_the_title($data);
					}
					$return = evaluate_js_callback( array('url' => $url, 'id' => $data) );
					$ids[] = $data;
				}
				
				if($return){
					$location = admin_url('edit.php?post_type=site&audited=' . count($ids) . '&ids=' . implode(',', $ids));
					wp_redirect( $location ); exit;
				}
			}
			
			return;
		}
	}
	
	// Remove SEO Yoast and tumblog filter
	function remove_alien_filters(){
		global $woo_tumblog_post_format;
		if( $woo_tumblog_post_format ){
			remove_action('restrict_manage_posts', array($woo_tumblog_post_format, 'woo_tumblog_restrict_manage_posts') );
		}
	}
}

global $fields;
$fields = wpa_default_metrics();

$custom_post_site = new Sites_CPT();
$custom_post_site->set_fields($fields);

// Remove unnescessary metaboxes that we know
function site_manager_remove_meta_box(){
	remove_meta_box( 'op_seo_meta_box', 'site', 'advanced' );
	remove_meta_box( 'su-main-setting', 'site', 'advanced' );
	// remove_meta_box( 'woothemes-settings' , 'site' , 'normal' );
}

add_action( 'add_meta_boxes', 'site_manager_remove_meta_box', 40 );
<?php
!defined( 'ABSPATH' ) ? exit : '';

class Sites_CPT{
	
	var $fields;
	
	function __construct(){
		// Enqueue Scripts
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
		add_action( 'admin_footer-edit.php', array($this, 'site_manager_bulk_action_item') );
		add_action( 'load-edit.php', array($this, 'site_manager_bulk_action_handle') );
		
		// Custom Sortable Columns
		add_filter( 'manage_site_posts_columns', array($this, 'site_columns') );
		add_filter( 'manage_edit-site_sortable_columns', array($this, 'site_columns_head') );
		add_action( 'manage_site_posts_custom_column', array($this, 'site_columns_content'), 10, 2);
		
		add_action( 'pre_get_posts', array($this, 'site_orderby_rank') );
		
		// Add meta boxes
		add_action( 'add_meta_boxes', array($this, 'add_meta_boxes') );
		add_action( 'save_post', array($this, 'save_post') );
		
		// Add another row action
		add_filter('post_row_actions', array($this, 'add_action_row'), 10, 2);
		
		// Add filter
		add_action( 'restrict_manage_posts', array($this, 'filter_restrict_manage_posts_site'), 10 );
	}
	
	function filter_restrict_manage_posts_site(){
		$type = isset($_GET['post_type']) ? $_GET['post_type'] : 'post';
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
					?><option value="<?php echo $status->slug ?>" <?php selected( $current_s, $status->slug ); ?>><?php echo $status->name; ?></option><?php
                }
        	?></select>
            
            <select name="site-status">
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
		if ($post->post_type =="site"){
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
			'label'	=> _x( 'Uncheck', 'post' ),
			'public' => true,
			'exclude_from_search' => false,
			'show_in_admin_all_list' => true,
			'show_in_admin_status_list' => true,
			'label_count' => _n_noop( 'Uncheck <span class="count">(%s)</span>', 'Uncheck <span class="count">(%s)</span>' )
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
		switch($column_name){
			case 'rank':
				$rank = get_post_meta($post_ID, 'rating', true);
				$rank = ($rank) ? $rank : get_post_meta($post_ID, 'awp-alexa-rank', true);
				echo ($rank) ? __( $rank ) : __(0);
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
            __( 'Site Evaluator', 'awp' ),
            array('Sites_CPT', 'metabox_evaluate'),
			'site',
			'side',
			'high'
        );
	}
	
	function metabox_evaluate(){
		?><p>Click "<tt>Audit This Site</tt>" to get all the data of this site</p>
        <input name="awp-evaluate" type="button" class="button button-primary button-large" id="awp-evaluate" accesskey="p" value="Audit this Site">
        <img src="<?php echo PLUGINURL; ?>/images/preload.gif" class="preloader" align="preload" style="display:none;" />
		<?php
	}
	
	function add_filter_boxes(){
		global $typenow;
		global $wp_query;
		
		$screen = get_current_screen();
		
		/*?><pre><?php print_r($screen); ?></pre><?php wp_die();*/
		
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
                <li class="awp-tab not-tab ui-state-disabled"><a href="javascript:void(0);">Signals</a></li><?php
                	$depts = wpa_get_metrics_group_by_category('signals');
					foreach($depts as $head){
						?><li class="awp-tab"><a href="#<?php echo $head['id']; ?>"><?php echo $head['name']; ?></a>
                            <div class="wp-menu-arrow"><div></div></div></li><?php
					}
				?><li class="wp-not-current-submenu wp-menu-separator not-tab"><div class="separator"></div></li>
				<li class="awp-tab not-tab ui-state-disabled"><a href="javascript:void(0);">Valuation</a></li><?php
					$depts = wpa_get_metrics_group_by_category('valuation');
					foreach($depts as $head){
						?><li class="awp-tab"><a href="#<?php echo $head['id']; ?>"><?php echo $head['name']; ?></a>
                            <div class="wp-menu-arrow"><div></div></div></li><?php
					}
				
				/*$i = 0;
				foreach( $fields as $head ){
					if( ($head['type'] == 'heading') || ($head['type'] == 'separator') ){
						if( $head['type'] == 'heading' ){
							?><li class="awp-tab"><a href="#<?php echo $head['id']; ?>"><?php echo $head['name']; ?></a>
                            <div class="wp-menu-arrow"><div></div></div></li><?php
						}
						if( $head['type'] == 'separator' ){
							if($i >= 1){
								?><li class="wp-not-current-submenu wp-menu-separator not-tab"><div class="separator"></div></li><?php
							}
							?><li class="awp-tab not-tab"><a href="javascript:void(0);"><?php echo $head['name']; ?></a></li><?php
							$disabled[] = $i;
						}
						$i++;
					}
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
        
        <div class="clear"></div>
		<?php
		
		/*$exclude = get_post_meta($post_id, 'exclude_from_lists', true);
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
        </table><?php*/
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
			
			?><div class="awp-control-group">
                <label for="<?php echo $metaID; ?>"><?php echo $control['name'] ?></label>
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
					
				?></div>
                <div class="clear"></div>
            </div><?php
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
			
			wp_localize_script( 'awpeditor', 'WPAJAX_OBJ',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'post_url' => admin_url('post.php'),
					'manage_Screen' => admin_url('edit.php?post_type=site'),
					'defined_view' => $view
				)
			);
		}
	}
	
	function site_manager_bulk_action_item(){
		global $post;
		
		if($post->post_type == 'site') {
			?><script type="text/javascript">
				jQuery(document).ready(function($) {
					jQuery('<option>').val('wp_checker').text('Check for Wordpress').prependTo("select[name='action']");
					jQuery('<option>').val('wp_checker').text('Check for Wordpress').prependTo("select[name='action2']");
					
					jQuery('<option>').val('auth_checker').text('Check for Authority').prependTo("select[name='action']");
					jQuery('<option>').val('auth_checker').text('Check for Authority').prependTo("select[name='action2']");
					
					jQuery('<option>').val('evaluate').text('Audit').prependTo("select[name='action']");
					jQuery('<option>').val('evaluate').text('Audit').prependTo("select[name='action2']");
					
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
			
			/*?><pre><?php print_r( $_REQUEST ); ?></pre><?php wp_die();*/
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

function awp_add_view_links($views){
	
	$views[] = '<a href="javascript:void(0)" data-column="site" class="wpa-views">Site</a>';
	$views[] = '<a href="javascript:void(0)" data-column="project" class="wpa-views">Team</a>';
	$views[] = '<a href="javascript:void(0)" data-column="links" class="wpa-views">Links</a>';
	$views[] = '<a href="javascript:void(0)" data-column="social" class="wpa-views">Social</a>';
	$views[] = '<a href="javascript:void(0)" data-column="buzz" class="wpa-views">Buzz</a>';
	$views[] = '<a href="javascript:void(0)" data-column="framework" class="wpa-views">Framework</a>';
	$views[] = '<a href="javascript:void(0)" data-column="community" class="wpa-views">Community</a>';
	$views[] = '<a href="javascript:void(0)" data-column="authors" class="wpa-views">Authors</a>';
	$views[] = '<a href="javascript:void(0)" data-column="content" class="wpa-views">Content</a>';
	$views[] = '<a href="javascript:void(0)" data-column="products" class="wpa-views">Products</a>';
	$views[] = '<a href="javascript:void(0)" data-column="systems" class="wpa-views">Systems</a>';
	$views[] = '<a href="javascript:void(0)" data-column="valuation" class="wpa-views">Valuation</a>';
	$views[] = '<a href="javascript:void(0)" data-column="scores" class="wpa-views">Scores</a>';
	$views[] = '<a href="javascript:void(0)" data-column="action" class="wpa-views">Action</a>';
	
	return $views;
}

global $fields;
$fields = wpa_default_metrics();

$custom_post_site = new Sites_CPT();
$custom_post_site->set_fields($fields);

// Remove unnescessary metaboxes that we know
function site_manager_remove_meta_box(){
	remove_meta_box( 'op_seo_meta_box', 'site', 'advanced' );
	remove_meta_box( 'su-main-setting', 'site', 'advanced' );
	remove_meta_box( 'woothemes-settings' , 'site' , 'normal' );
}

add_action( 'add_meta_boxes', 'site_manager_remove_meta_box', 40 );
add_filter( 'views_edit-site', 'awp_add_view_links' );
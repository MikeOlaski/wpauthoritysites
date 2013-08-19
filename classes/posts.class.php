<?php

global $fields;
$fields = array();

$shortname = 'awp';

// General
$fields[] = array(
	'name' => 'General',
	'id' => $shortname.'-general',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Name',
	'id' => $shortname.'-name',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Domain',
	'id' => $shortname.'-domain',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'TLD',
	'id' => $shortname.'-tld',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'URL – Link',
	'id' => $shortname.'-url',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Date Founded',
	'id' => $shortname.'-date',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Network IN?',
	'id' => $shortname.'-networked',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Location',
	'id' => $shortname.'-location',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Language',
	'id' => $shortname.'-language',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Owners',
	'id' => $shortname.'-owners',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Founder',
	'id' => $shortname.'-founder',
	'type' => 'text',
	'group' => $shortname.'-owners'
);

$fields[] = array(
	'name' => 'Owner',
	'id' => $shortname.'-owner',
	'type' => 'text',
	'group' => $shortname.'-owners'
);

$fields[] = array(
	'name' => 'Publisher',
	'id' => $shortname.'-publisher',
	'type' => 'text',
	'group' => $shortname.'-owners'
);

$fields[] = array(
	'name' => 'Producer',
	'id' => $shortname.'-producer',
	'type' => 'text',
	'group' => $shortname.'-owners'
);

$fields[] = array(
	'name' => 'Links',
	'id' => $shortname.'-links',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Google',
	'id' => $shortname.'-google',
	'type' => 'text',
	'group' => $shortname.'-links'
);

$fields[] = array(
	'name' => 'Yahoo',
	'id' => $shortname.'-yahoo',
	'type' => 'text',
	'group' => $shortname.'-links'
);

$fields[] = array(
	'name' => 'Majestic',
	'id' => $shortname.'-majestic',
	'type' => 'text',
	'group' => $shortname.'-links'
);

$fields[] = array(
	'name' => 'Social Network',
	'id' => $shortname.'-social',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Google Plus',
	'id' => $shortname.'-googleplus',
	'type' => 'text',
	'group' => $shortname.'-social'
);

$fields[] = array(
	'name' => 'Facebook',
	'id' => $shortname.'-facebook',
	'type' => 'text',
	'group' => $shortname.'-social'
);

$fields[] = array(
	'name' => 'Twitter',
	'id' => $shortname.'-twitter',
	'type' => 'text',
	'group' => $shortname.'-social'
);

$fields[] = array(
	'name' => 'Pinterest',
	'id' => $shortname.'-pinterest',
	'type' => 'text',
	'group' => $shortname.'-social'
);

$fields[] = array(
	'name' => 'LinkedIn',
	'id' => $shortname.'-linkedin',
	'type' => 'text',
	'group' => $shortname.'-social'
);

$fields[] = array(
	'name' => 'Ranks',
	'id' => $shortname.'-ranks',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Alexa Rank',
	'id' => $shortname.'-alexa-rank',
	'type' => 'text',
	'group' => $shortname.'-ranks'
);

$fields[] = array(
	'name' => 'Compete Rank',
	'id' => $shortname.'-compete-rank',
	'type' => 'text',
	'group' => $shortname.'-ranks'
);

$fields[] = array(
	'name' => 'SEM Rush Rank',
	'id' => $shortname.'-semrush-rank',
	'type' => 'text',
	'group' => $shortname.'-ranks'
);

$fields[] = array(
	'name' => 'One Rank',
	'id' => $shortname.'-one-rank',
	'type' => 'text',
	'group' => $shortname.'-ranks'
);

$fields[] = array(
	'name' => 'Traffic',
	'id' => $shortname.'-traffic',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Monthly Unique Visitors',
	'id' => $shortname.'-unique-visitors',
	'type' => 'text',
	'group' => $shortname.'-traffic'
);

$fields[] = array(
	'name' => 'Monthly Page Views',
	'id' => $shortname.'-page-views',
	'type' => 'text',
	'group' => $shortname.'-traffic'
);

$fields[] = array(
	'name' => 'Engagement',
	'id' => $shortname.'-engagement',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Pages Per Visit',
	'id' => $shortname.'-pages-per-visit',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Time Per Visit',
	'id' => $shortname.'-time-per-visit',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Comments Active',
	'id' => $shortname.'-comments-active',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Comment System',
	'id' => $shortname.'-comment-system',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Comments Per Post',
	'id' => $shortname.'-comments-per-post',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Percent Longer than 15 Seconds',
	'id' => $shortname.'-percent-longer-15',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => '0-10 Seconds under 55%',
	'id' => $shortname.'-10-seconds-under-55',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Financials',
	'id' => $shortname.'-financials',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Net Income',
	'id' => $shortname.'-net-income',
	'type' => 'text',
	'group' => $shortname.'-financials'
);

$fields[] = array(
	'name' => 'Gross Revenue',
	'id' => $shortname.'-gross-revenue',
	'type' => 'text',
	'group' => $shortname.'-financials'
);

$fields[] = array(
	'name' => 'Trailing 12 Months',
	'id' => $shortname.'-trailing-12-months',
	'type' => 'text',
	'group' => $shortname.'-financials'
);

$fields[] = array(
	'name' => 'Valuation',
	'id' => $shortname.'-valuation',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Last Sale Value',
	'id' => $shortname.'-sale-value',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Last Sale Price',
	'id' => $shortname.'-sale-price',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Revenue Value Multiplier',
	'id' => $shortname.'-revenue-multiplier',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Income value Multiplier',
	'id' => $shortname.'-income-multiplier',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Daily Worth (From Income Diary)',
	'id' => $shortname.'-daily-worth',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Sale URL',
	'id' => $shortname.'-sale-url',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Sale Date',
	'id' => $shortname.'-sale-date',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Sale Type',
	'id' => $shortname.'-sale-type',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Content',
	'id' => $shortname.'-content',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Number of Defined Silos',
	'id' => $shortname.'-silos-number',
	'type' => 'text',
	'group' => $shortname.'-content'
);

$fields[] = array(
	'name' => 'Silos',
	'id' => $shortname.'-silos-tag',
	'type' => 'text',
	'group' => $shortname.'-content'
);

$fields[] = array(
	'name' => 'Number of Rich Snippet Types',
	'id' => $shortname.'-rich-snippet-types',
	'type' => 'text',
	'group' => $shortname.'-content'
);

$fields[] = array(
	'name' => 'Number of Rich Snippets',
	'id' => $shortname.'-rich-snippets',
	'type' => 'text',
	'group' => $shortname.'-content'
);

$fields[] = array(
	'name' => 'Development',
	'id' => $shortname.'-development',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Percent Customized',
	'id' => $shortname.'-percent-customized',
	'type' => 'text',
	'group' => $shortname.'-development'
);

$fields[] = array(
	'name' => 'Cost to Build',
	'id' => $shortname.'-cost-to-build',
	'type' => 'text',
	'group' => $shortname.'-development'
);

$fields[] = array(
	'name' => 'Cost to Maintain',
	'id' => $shortname.'-cost-to-maintain',
	'type' => 'text',
	'group' => $shortname.'-development'
);

$fields[] = array(
	'name' => 'Authors',
	'id' => $shortname.'-authors',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Number of Authors',
	'id' => $shortname.'-authors-number',
	'type' => 'text',
	'group' => $shortname.'-authors'
);

$fields[] = array(
	'name' => 'Bio Type',
	'id' => $shortname.'-bio-type',
	'type' => 'text',
	'group' => $shortname.'-authors'
);

$fields[] = array(
	'name' => 'Byline Type',
	'id' => $shortname.'-byline-type',
	'type' => 'text',
	'group' => $shortname.'-authors'
);

$fields[] = array(
	'name' => 'Author Page Type',
	'id' => $shortname.'-author-page-type',
	'type' => 'text',
	'group' => $shortname.'-authors'
);

$fields[] = array(
	'name' => 'Number of Connected Profiles',
	'id' => $shortname.'-profiles-number',
	'type' => 'text',
	'group' => $shortname.'-authors'
);

$fields[] = array(
	'name' => 'Management',
	'id' => $shortname.'-management',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Staff',
	'id' => $shortname.'-staff',
	'type' => 'text',
	'group' => $shortname.'-management'
);

$fields[] = array(
	'name' => 'Automated Processes',
	'id' => $shortname.'-automated-processes',
	'type' => 'text',
	'group' => $shortname.'-management'
);

$fields[] = array(
	'name' => 'Brand',
	'id' => $shortname.'-brand',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Brand Keywords',
	'id' => $shortname.'-brand-keywords',
	'type' => 'text',
	'group' => $shortname.'-brand'
);

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
			'taxonomies' => array('site-category', 'site-tags'),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
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
					'label' => __( $label ),
					'rewrite' => array( 'slug' => $tax ),
					'hierarchical' => true,
				)
			);
		}
	}
	
	// Add manage screen table
	function site_columns_head($defaults){
		$defaults['rank'] = __('Rank');
		$defaults['date'] = __('Date');
		return $defaults;
	}
	
	function site_columns( $defaults ){
		unset($defaults['date']);
		$defaults['action'] = __('Action');
		$defaults['status'] = __('Status');
		$defaults['include'] = __('Include');
		$defaults['topic'] = __('Topic');
		$defaults['type'] = __('Type');
		$defaults['location'] = __('Location');
		$defaults['assignment'] = __('Assignment');
		$defaults['rank'] = __('Rank');
		$defaults['date'] = __('Date');
		return $defaults;
	}
	
	// Show custom column data
	function site_columns_content($column_name, $post_ID) {
		switch($column_name){
			case 'rank':
				$rank = get_post_meta($post_ID, 'rating', true);
				echo ($rank) ? __( $rank ) : __(0);
				break;
			
			case 'action':
			case 'status':
			case 'include':
			case 'topic':
			case 'type':
			case 'location':
			case 'assignment':
				$terms = wp_get_post_terms( $post_ID, 'site-'.$column_name );
				
				if( $terms ){
					$max = count($terms);
					$i = 1;
					foreach( $terms as $tm ){
						$tlink = sprintf( 'edit.php?post_type=site&site-%s=%s', $column_name, $tm->slug );
						?><a href="<?php echo $tlink; ?>"><?php echo $tm->name; ?></a><?php
						if($i < $max){ echo ', '; }
						$i++;
					}
				} else {
					echo '—';
				}
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
            __( 'Site Custom Settings', 'awp' ),
            array('Sites_CPT', 'metabox_fields'),
			'site'
        );
	}
	
	function add_filter_boxes(){
		global $typenow;
		global $wp_query;
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
		
		?><div id="awp_tabs" class="awp_meta_box">
			<ul class="awp-tabber"><?php
				foreach( $fields as $head ){
					if( $head['type'] == 'heading' ){
						?><li class="awp-tab"><a href="#<?php echo $head['id']; ?>"><?php echo $head['name']; ?></a></li><?php
					}
				}
				
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
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($){
                $('#awp_tabs').tabs();
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
					}
					
				?></div>
                <div class="clear"></div>
            </div><?php
		}
	}
	
	function site_manager_scripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'awpmain', PLUGINURL . '/css/main.css' );
	}
}

// Remove unnescessary metaboxes that we know
function site_manager_remove_meta_box(){
	remove_meta_box( 'op_seo_meta_box', 'site', 'advanced' );
	remove_meta_box( 'su-main-setting', 'site', 'advanced' );
	remove_meta_box( 'woothemes-settings' , 'site' , 'normal' );
}

// Enqueue Scripts
add_action( 'admin_head-post.php', array('Sites_CPT', 'site_manager_scripts') );

// Register Post Type
add_action( 'init', array('Sites_CPT', 'register_post_type') );
add_action( 'init', array('Sites_CPT', 'register_taxonomies') );
add_action( 'add_meta_boxes', 'site_manager_remove_meta_box', 40 );

// Add filter Boxes
add_action( 'restrict_manage_posts', array('Sites_CPT', 'add_filter_boxes') );
add_filter( 'parse_query', array('Sites_CPT', 'convert_term_id_to_taxonomy_term_in_query') );

// Custom Sortable Columns
add_filter( 'manage_site_posts_columns', array('Sites_CPT', 'site_columns') );
add_filter( 'manage_edit-site_sortable_columns', array('Sites_CPT', 'site_columns_head') );
add_action( 'manage_site_posts_custom_column', array('Sites_CPT', 'site_columns_content'), 10, 2);

add_action( 'pre_get_posts', array('Sites_CPT', 'site_orderby_rank') );

// Add meta boxes
add_action( 'add_meta_boxes', array('Sites_CPT', 'add_meta_boxes') );
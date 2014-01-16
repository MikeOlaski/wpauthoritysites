<?php
!defined( 'ABSPATH' ) ? exit : '';
/*
 * Plugin Name: WP Authority Sites
 * Plugin URI: http://onewebsite.ca/
 * Description: The definitive list of Wordpress base Authority Websites - Content Website Businesses that dominate their niche and mass audiences alike.
 * Version: 0.1
 * Author: OWS
 * Author URI: http://onewebsite.ca/
 */

define( 'PLUGINURL', plugin_dir_url( __FILE__ ) );
define( 'PLUGINPATH', plugin_dir_path( __FILE__ ) );

load_template( trailingslashit( PLUGINPATH ) . 'classes/TwitterAPIExchange.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/whois.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/majestic/APIService.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/grabzit/GrabzItClient.class.php' );

load_template( trailingslashit( PLUGINPATH ) . 'functions.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/simple_html_dom.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/admin-ajax.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/posts.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/cron.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/integration.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/bb_builder.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/scrapewp.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/topSites.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/template-functions.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/template-loader.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/template-hooks.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/shortcodes.class.php' );

register_activation_hook( __FILE__, 'wpas_activate' );
register_deactivation_hook( __FILE__, 'wpas_deactivate' );

add_action('admin_menu', 'wpas_register_pages');

function wpas_activate(){
	wpas_set_options();
}

function wpas_set_options() {
	$option = array();
	
	// Build our option
	$option['StartNum'] = 1;
	$option['cronLimit'] = 20;
	
	add_option('awp_options', $option);
	add_option('awp_websites', array());
	add_option('awp_requests', array());
	add_option('awp_settings', array());
	add_option('wpa_metrics', array());
	
	// Default Authority Business Builder departments
	add_option('bb_builder_depts', array(
		'management' => 'Management',
		'production' => 'Production',
		'project-business' => 'Project Business',
		'discovery' => 'Discovery',
		'operation' => 'Operation',
		'technology' => 'Technology',
		'content' => 'Content',
		'marketing' => 'Marketing',
		'sales' => 'Sales',
		'service' => 'Service',
		'system' => 'System',
		'information' => 'Information'
	));
}

function wpas_deactivate(){
	delete_option('awp_options');
	delete_option('awp_websites');
	delete_option('awp_requests');
	delete_option('awp_settings');
	delete_option('wpa_metrics');
	delete_option('bb_builder_depts');
	
	// On deactivation, remove all functions from the scheduled action hook.
	wp_clear_scheduled_hook( 'wp_authority_update' );
}

add_action( 'init', 'wpas_sidebars' );

function wpas_sidebars(){
	register_sidebar( array(
		'name' => __( 'WPAS Sidebar', 'wpas' ),
		'id' => 'sidebar-site',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

add_filter('nav_menu_css_class', 'wpas_clean_nav_menu');
function wpas_clean_nav_menu($classes){
	switch (get_post_type()){
		case 'site':
		case 'survey':
			$classes = array_filter($classes, "remove_parent_classes");
			break;
	}
	return $classes;
}

if(!function_exists('remove_parent_classes')){
	function remove_parent_classes($var){
		if( $var == 'current_page_parent' ){
			return false;
		}
		return true;
	}
}

add_filter('wpa_archive_wp_query', 'wpas_archive_tax_query');
function wpas_archive_tax_query( $tax_query ){
	global $post, $wp_query;
	$settings = get_option('awp_settings');
	$query = array('relation' => 'AND');
	
	if( !$settings['xtype'] )
		$settings['xtype'] = array();
	
	if( !$settings['xStatus'] )
		$settings['xStatus'] = array();
	
	$type_operator = $settings['action_taxonomy_type'];
	if( $type_operator ){
		$types = array();
		if( $typeObj = get_terms('site-type', array(
				'orderby'       => 'name', 
				'order'         => 'ASC',
				'hide_empty'    => false
			)) ){
			
			foreach($typeObj as $type){
				if( in_array($type->slug, $settings['xtype']) ){
					$types[] = $type->slug;
				}
			}
			
			if( !empty($types) ){
				$query[] = array(
					'taxonomy' => 'site-type',
					'field' => 'slug',
					'terms' => $types,
					'operator' => $type_operator
				);
			}
		}
	}
	
	$status_operator = $settings['action_taxonomy_status'];
	if( $status_operator ){
		$statuses = array();
		if( $statusObj = get_terms('site-status', array(
				'orderby'       => 'name', 
				'order'         => 'ASC',
				'hide_empty'    => false
			)) ){
			
			foreach($statusObj as $status){
				if( in_array($status->slug, $settings['xStatus']) ) {
					$statuses[] = $status->slug;
				}
			}
			
			if( !empty($statuses) ){
				$query[] = array(
					'taxonomy' => 'site-status',
					'field' => 'slug',
					'terms' => $statuses,
					'operator' => $status_operator
				);
			}
		}
	}
	
	if ( is_post_type_archive( array('site') ) ){
		$wp_query->tax_query = $query;
	}
	
	return $wp_query->tax_query;
}

add_action( 'wp_loaded', 'wpas_options_handle' );
function wpas_options_handle(){
	$requests = get_option('awp_requests');
	$settings = get_option('awp_settings');
	
	if( isset($_POST) && !empty($_REQUEST) ){
		
		foreach($_POST as $key=>$val){
			$$key = $val;
		}
		
		// Handle for bulk WP Checker action
		if( ( isset( $_REQUEST['action'] ) && 'wp_checker' == $_REQUEST['action'] ) || ( isset( $_REQUEST['action2'] ) && 'wp_checker' == $_REQUEST['action2'] ) ){
			$links = array();
			foreach($_REQUEST['post'] as $pID){
				$links[$pID] = strtolower(get_the_title($pID));
			}
			
			$scrape = new scrapeWordpress();
			$scrape->scrape( $links );
			
			if( $scrape->wp_sites ){
				foreach( $scrape->wp_sites as $wp ){
					wp_update_post(
						array(
							'ID' => $wp['ID'],
							'post_status' => 'publish'
						)
					);
					
					update_post_meta( $wp['ID'], 'awp-name', $wp['name'] );
					update_post_meta( $wp['ID'], 'awp-domain', wpa_get_host($wp['name']) );
					update_post_meta( $wp['ID'], 'awp-tld', wpa_get_tld($wp['name']) );
					update_post_meta( $wp['ID'], 'awp-url', wpa_add_url_scheme($wp['name']) );
					update_post_meta( $wp['ID'], '_wpa_last_wpcheck', date('c') );
					
					wp_set_object_terms( $wp['ID'], '$Wordpress', 'site-type', true );
					wp_remove_object_terms( $wp['ID'], '$NotWordpress', 'site-type' );
				}
			}
			
			if( $scrape->not_wp_sites ){
				foreach( $scrape->not_wp_sites as $not_wp ){
					wp_update_post(
						array(
							'ID' => $not_wp['ID'],
							'post_status' => 'publish'
						)
					);
					update_post_meta( $not_wp['ID'], '_wpa_last_wpcheck', date('c') );
					
					wp_set_object_terms( $not_wp['ID'], '$NotWordpress', 'site-type', true );
					wp_remove_object_terms( $not_wp['ID'], '$Wordpress', 'site-type' );
				}
			}
			
			header('Location:' . admin_url('edit.php?post_type=site&wp_checked=true')); exit;
		}
		
		// Make Manual API Request
		if(isset($_POST['awp_request']) && '' != $_POST['awp_request']){
			error_reporting(0);
			$return = true;
			
			// Check if Plugin settings are set
			if( !$settings['access_id'] || (isset($settings['access_id']) && '' == $settings['access_id']) )
				$return = false;
				$msg = 1;
			
			if( !$settings['access_secret'] || (isset($settings['access_secret']) && '' == $settings['access_secret']) )
				$return = false;
				$msg = 1;
			
			// Make sure that there is no errors
			if($return == true){
				// pre-save a new record of API request
				$requests[] = array(
					'subject' => $subject,
					'request' => 'API',
					'date' => date('c')
				);
				
				// Check if API class exist otherwise do nothing
				if( class_exists('TopSites')) {
					$topsites = new TopSites($settings['access_id'], $settings['access_secret'], $rank_start, $request_limit);
					$args = $topsites->getTopSites();
					
					// Check if API request is successful
					if($args){
						$i = $rank_start;
						$j = 0;
						
						// pre-saved each site into an array
						foreach($args as $i) {
							$websites[$i] = array(
								'name' => $i,
								'rank' => $i,
								'check' => false,
								'date' => date('c')
							);
							$j++;
							$i++;
						}
						
						// Create a new entry of site CPT
						foreach($websites as $site){
							$site['taxonomies']['site-type'][] = '$NotWordpress';
							$site['taxonomies']['site-status'][] = '!NotAudited';
							
							if( !get_page_by_title($site['name'], OBJECT, 'site') ){
								$pID = wp_insert_post(
									array(
										'post_type' => 'site',
										'post_date' => $site['date'],
										'post_title' => $site['name'],
										'post_status' => 'uncheck'
									)
								);
								
								if( isset($site['taxonomies']) ){
									foreach( $site['taxonomies'] as $tax=>$terms ){
										wp_set_object_terms( $pID, $terms, $tax, true );
									}
								}
								
								update_post_meta($pID, 'awp-alexa-rank', $site['rank']);
							}
						}
					} else {
						$return = false;
						$msg = 2;
					}
				}
				
				// Keep record of the manual request and website links
				$return = update_option('awp_requests', $requests);
			}
			
			// Redirect to manual request page
			$location = 'edit.php?post_type=site&page=wpa_import&settings-updated=';
			if( $return ){
				header('Location:'.admin_url($location.'true')); exit;
			} else {
				header('Location:'.admin_url($location.'false&message='.$msg)); exit;
			}
		} // End of Manual API Request
		
		// Manual upload
		if(isset($_POST['awp_upload']) && '' != $_POST['awp_upload']){
			error_reporting(0);
			
			if ( isset($_FILES["awp_file"]) ) {
				$return = true;
				
				if ($_FILES["awp_file"]["error"] > 0) {
					$return = false;
					$msg = 3;
				}
				
				if($return == true){
					$temp = explode(".", $_FILES["awp_file"]["name"]);
					$extension = end( $temp );
					if( $extension == "csv" ){
						$filename = $_FILES["awp_file"]["name"];
						if( file_exists( PLUGINPATH . "uploads/" . $filename ) ){
							$filename = rand(1111, 9999) . $filename;
						}
						move_uploaded_file( $_FILES["awp_file"]["tmp_name"], PLUGINPATH . "uploads/" . $filename );
						
						// pre-save a new record of manual upload
						$requests[] = array(
							'subject' => $subject,
							'request' => 'manual upload',
							'date' => date('c')
						);
						
						// Open the uploaded CSV file
						if (($handle = fopen( PLUGINPATH . "uploads/" . $filename, "r")) !== FALSE) {
							$row = ($csv_start_row) ? $csv_start_row : 1; // Set rank start
							$limit = ($csv_limit_row) ? $csv_limit_row : 50; // Set limit
							$i = 1;
							
							// pre-saved each site into an array
							while ( ($data = fgetcsv($handle, 1000, ",")) !== FALSE && $i <= $limit ) {
								if($row == $i){
									$websites[$data[1]] = array(
										'name' => $data[1],
										'rank' => $data[0],
										'check' => false,
										'date' => date('c'),
										'taxonomies' => array(
											'site-status' => array(
												'!Imported',
												'!Imported by CSV',
												'!Imported – ' . date('y.m.d;H:i')
											)
										)
									);
									$row++;
								}
								$i++;
							}
							
							// Close the file
							fclose($handle);
						}
						
						$return = true;
					} else {
						$return = false;
						$msg = 4;
					}
				}
				
				foreach($websites as $site){
					if( !get_page_by_title($site['name'], OBJECT, 'site') ){
						$site['taxonomies']['site-type'][] = '$NotWordpress';
						$site['taxonomies']['site-status'][] = '!NotAudited';
						
						$pID = wp_insert_post(
							array(
								'post_type' => 'site',
								'post_date' => $site['date'],
								'post_title' => $site['name'],
								'post_status' => 'uncheck'
							)
						);
						
						if( isset($site['taxonomies']) ){
							foreach( $site['taxonomies'] as $tax=>$terms ){
								wp_set_object_terms( $pID, $terms, $tax, true );
							}
						}
						
						update_post_meta($pID, 'awp-alexa-rank', $site['rank']);
					}
				}
				
				// Keep record of the manual upload and website links
				// update_option('awp_websites', $websites);
				$return = update_option('awp_requests', $requests);
			} else {
				$msg = 5;
			}
			
			// Redirect to manual request page
			$location = 'edit.php?post_type=site&page=wpa_import&settings-updated=';
			if( $return ){
				header('Location:'.admin_url($location.'true')); exit;
			} else {
				header('Location:'.admin_url($location.'false&message='.$msg)); exit;
			}
		} // End of Manual upload
		
		// Manual Domain Import
		if(isset($_POST['awp_import_domain']) && '' != $_POST['awp_import_domain']){
			if($awp_domain == '')
				return;
			
			// pre-save a new record of manual upload
			$requests[] = array(
				'subject' => ($subject != '') ? $subject : 'Manual Bulk Add',
				'request' => 'manual import',
				'date' => date('c')
			);
			
			$websites = explode(PHP_EOL, $awp_domain );
			
			$taxonomies = array(
				'site-status' => array(
					'!imported',
					'!NotAudited',
					'!imported by Bulk Add',
					'!Imported – ' . date('y.m.d;H:i')
				),
				'site-type' => array(
					'$NotWordpress'
				)
			);
			
			if($awp_domain_tags != ''){
				$str = $awp_domain_tags;
				
				$actionTags = array(
					'site-action' => '~',
					'site-status' => '!',
					'site-include' => '@',
					'site-topic' => '#',
					'site-type' => '$',
					'site-location' => '%',
					'site-assignment' => '^'
				);
				$terms = explode(',', $str);
				
				foreach( $terms as $i=>$e ){
					$taxObj = substr(trim($e), 0, 1);
					$term = substr(trim($e), 1, strlen(trim($e)));
					
					if( $key = array_search($taxObj, $actionTags) ){
						$taxonomies[$key][] = trim($e); // $term;
					} else {
						$taxonomies['site-tag'][] = trim($e);
					}
				}
			}
			
			// Keep record of the manual upload and website links
			foreach($websites as $site){
				if( !get_page_by_title($site, OBJECT, 'site') ){
					$pID = wp_insert_post(
						array(
							'post_type' => 'site',
							'post_date' => date('c'),
							'post_title' => $site,
							'post_status' => 'uncheck'
						)
					);
					
					foreach( $taxonomies as $tax=>$terms ){
						wp_set_object_terms( $pID, $terms, $tax, true );
					}
				}
			}
			
			$return = update_option('awp_requests', $requests);
			
			// Redirect to manual request page
			$location = 'edit.php?post_type=site&page=wpa_import&settings-updated=';
			if( $return ){
				header('Location:'.admin_url($location.'true')); exit;
			} else {
				header('Location:'.admin_url($location.'false&message='.$msg)); exit;
			}
		} // End of Manual Domain Import
		
		// Update Settings
		if(isset($_POST['awp_submit']) && '' != $_POST['awp_submit']){
			$fields = array(
				// Evaluation Settings
				'evaluation',
				
				// twitter API Settings
				'twitter_access_token',
				'twitter_access_secret',
				'twitter_cons_key',
				'twitter_cons_secret',
				
				// Compete API Settings
				'compete_api_key',
				
				// Google API Settings
				'goolge_api_key',
				
				// Yahoo API Settings
				'yahoo_api_key',
				
				// Majestic API Settings
				'majestic_api_key',
				
				// Alexa API Settings
				'access_id',
				'access_secret',
				'StartNum',
				'cronLimit',
				
				// GrabzIT API Settings
				'grabzit_api_key',
				'grabzit_api_secret',
				
				// Cron Settings
				'cronjob',
				'rank_page',
				'request_limit',
				'scrape_link',
				'scrape_limit',
				
				// Content and SEO Settings
				'archive_meta_title',
				'archive_meta_desc',
				'archive_meta_keywords',
				'archive_page_title',
				'archive_content_before',
				'archive_content_after',
				'single_sidebar',
				'bb_builder_page',
				
				// Action Tags
				'sites_default_order',
				'sites_default_orderby',
				'action_taxonomy_type',
				'action_taxonomy_status',
				'xtype',
				'xStatus',
				'hide_timestamp'
			);
			
			foreach( $fields as $fl ){
				if(isset($awp_settings[$fl]) && $awp_settings[$fl] != $settings[$fl]){
					$settings[$fl] = $awp_settings[$fl];
				} else {
					$settings[$fl] = $settings[$fl];
				}
			}
			
			if(isset($_POST['wpas_tab_identifier']) && $_POST['wpas_tab_identifier'] == 'action'){
				if( !isset($awp_settings['xtype']) || $awp_settings['xtype'] == '' ){
					$settings['xtype'] = 0;
				}
				
				if( !isset($awp_settings['xStatus']) || $awp_settings['xStatus'] == '' ){
					$settings['xStatus'] = 0;
				}
				
				if( isset($awp_settings['hide_timestamp']) && $awp_settings['hide_timestamp'] == 'true' ){
					$settings['hide_timestamp'] = 'true';
				} else {
					$settings['hide_timestamp'] = 0;
				}
			}
			
			$return = update_option('awp_settings', $settings);
			
			$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : admin_url('edit.php?post_type=site&page=wpauthority&settings-updated=');
			
			// Redirect to manual request page
			if( $return ){
				header('Location:'.$redirect.'true'); exit;
			} else {
				header('Location:'.$redirect.'false'); exit;
			}
		} // End of update
	}
	
	// Manage screen handle for top websites lists
	if( ( isset($_GET['action']) || isset($_GET['post'])) && 'wp_checker' == $_GET['action'] ){
		$links = array();
		foreach($_REQUEST['post'] as $pID){
			$links[$pID] = strtolower(get_the_title($pID));
		}
		
		$scrape = new scrapeWordpress();
		$scrape->scrape( $links );
		
		if( $scrape->wp_sites ){
			foreach( $scrape->wp_sites as $wp ){
				wp_update_post(
					array(
						'ID' => $wp['ID'],
						'post_status' => 'publish'
					)
				);
				
				update_post_meta( $wp['ID'], 'awp-name', $wp['name'] );
				update_post_meta( $wp['ID'], 'awp-domain', wpa_get_host($wp['name']) );
				update_post_meta( $wp['ID'], 'awp-tld', wpa_get_tld($wp['name']) );
				update_post_meta( $wp['ID'], 'awp-url', wpa_add_url_scheme($wp['name']) );
				update_post_meta( $wp['ID'], '_wpa_last_wpcheck', date('c') );
				
				wp_set_object_terms( $wp['ID'], '$Wordpress', 'site-type', true );
				wp_remove_object_terms( $wp['ID'], '$NotWordpress', 'site-type' );
			}
		}
		
		if( $scrape->not_wp_sites ){
			foreach( $scrape->not_wp_sites as $not_wp ){
				wp_update_post(
					array(
						'ID' => $not_wp['ID'],
						'post_status' => 'publish'
					)
				);
				update_post_meta( $not_wp['ID'], '_wpa_last_wpcheck', date('c') );
				
				wp_set_object_terms( $not_wp['ID'], '$NotWordpress', 'site-type', true );
				wp_remove_object_terms( $not_wp['ID'], '$Wordpress', 'site-type' );
			}
		}
		
		// Redirect to metrics group page
		header('Location:' . admin_url('edit.php?post_type=site&wp_checked=true')); exit;
	}
	
	// Add/Save Custom Metric
	if( isset($_POST['wpa_save_metric']) && '' != $_POST['wpa_save_metric'] ){
		foreach($_POST as $key=>$val){
			$$key = $val;
		}
		
		$fields = wpa_default_metrics();
		
		if($metric_id){
			unset($fields[$metric_id]);
		}
		
		$options = '';
		if($wpa_metrics['options']){
			$options = array();
			$opts = explode('|', stripslashes($wpa_metrics['options']) );
			foreach($opts as $opt){
				$options[$opt] = $opt;
			}
		}
		
		$fields[$wpa_metrics['id']] = array(
			'name' => $wpa_metrics['name'],
			'id' => $wpa_metrics['id'],
			'type' => $wpa_metrics['type'],
			'group' => $wpa_metrics['group'],
			'tip' => $wpa_metrics['tip'],
			'std' => $wpa_metrics['value'],
			'desc' => $wpa_metrics['desc'],
			'options' => $options,
			'readonly' => $readonly
		);
		
		// Record and save metrics
		$return = update_option('wpa_metrics', $fields);
		
		// Redirect to metrics page
		$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : admin_url('admin.php?page=wpauthority&tab=metrics&settings-updated=1');
		if( $return ){
			header('Location:'.$redirect); exit;
		} else {
			header('Location:'.$redirect); exit;
		}
	}
	
	// Add/Save Metric Group
	if( isset($_POST['wpa_save_group']) && '' != $_POST['wpa_save_group'] ){
		foreach($_POST as $key=>$val){
			$$key = $val;
		}
		
		$fields = wpa_default_metrics();
		
		if($group_id){
			unset($fields[$group_id]);
		}
		
		$fields[$wpa_metrics['id']] = array(
			'name' => $wpa_metrics['name'],
			'id' => $wpa_metrics['id'],
			'type' => $type,
			'desc' => $wpa_metrics['desc'],
			'category' => $wpa_metrics['category'],
			'readonly' => $wpa_metrics['readonly']
		);
		
		// Record and save metrics group
		$return = update_option('wpa_metrics', $fields);
		
		// Redirect to metrics group page
		$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : admin_url('admin.php?page=wpauthority&tab=metrics&settings-updated=1');
		if( $return ){
			header('Location:'.$redirect); exit;
		} else {
			header('Location:'.$redirect); exit;
		}
	}
	
	// Trash/Delete Custom Metric
	if( isset($_REQUEST['metric_action']) && '' != $_REQUEST['metric_action'] ){
		if($_REQUEST['id']){
			$fields = wpa_default_metrics();
			unset($fields[ $_REQUEST['id'] ]);
			
			// Record and save metrics
			$return = update_option('wpa_metrics', $fields);
		} else {
			$return = false;
		}
		
		// Redirect to metrics page
		$redirect = admin_url('admin.php?page=wpauthority&tab=metrics&settings-updated=true');
		if( $return ){
			header('Location:'.$redirect); exit;
		} else {
			header('Location:'.$redirect); exit;
		}
	}
	
	return;
}

function wpas_register_pages(){
	remove_submenu_page('edit.php?post_type=site', 'post-new.php?post_type=site');
	remove_submenu_page('edit.php?post_type=site', 'edit-tags.php?taxonomy=site-category&post_type=site');
	remove_submenu_page('edit.php?post_type=site', 'edit-tags.php?taxonomy=site-tag&post_type=site');
	remove_submenu_page('edit.php?post_type=site', 'edit-tags.php?taxonomy=site-action&post_type=site');
	remove_submenu_page('edit.php?post_type=site', 'edit-tags.php?taxonomy=site-status&post_type=site');
	remove_submenu_page('edit.php?post_type=site', 'edit-tags.php?taxonomy=site-include&post_type=site');
	remove_submenu_page('edit.php?post_type=site', 'edit-tags.php?taxonomy=site-topic&post_type=site');
	remove_submenu_page('edit.php?post_type=site', 'edit-tags.php?taxonomy=site-type&post_type=site');
	remove_submenu_page('edit.php?post_type=site', 'edit-tags.php?taxonomy=site-location&post_type=site');
	remove_submenu_page('edit.php?post_type=site', 'edit-tags.php?taxonomy=site-assigment&post_type=site');
	
	add_submenu_page( 'edit.php?post_type=site', 'Add New Site', 'Add New', 'manage_options', 'post-new.php?post_type=site' );
	add_submenu_page( 'edit.php?post_type=site', 'Action Tags', 'Action Tags', 'manage_options', 'javascript:void(0);' );
	add_submenu_page( 'edit.php?post_type=site', 'Import', 'Import', 'manage_options', 'wpa_import', 'wpas_import_callback' );
	add_submenu_page( 'edit.php?post_type=site', 'Settings', 'Settings', 'manage_options', 'wpauthority', 'wpas_admin_pages' );
	
	add_action( "admin_print_scripts", 'wpas_admin_scripts' );
}

function wpas_admin_scripts(){
	wp_enqueue_script('wpadminjs', PLUGINURL . 'js/admin.js', array('jquery'));
	wp_enqueue_style( 'awpstyles', PLUGINURL . 'css/admin.css' );
}

function wpas_import_callback(){
	
	?><div class="wrap">
        <div id="icon-ows" class="icon32"><img src="<?php echo PLUGINURL; ?>images/icon32.jpg" alt="WP Sites" /></div>
        <h2><?php _e('Import', 'wpa'); ?></h2><div>&nbsp;</div><?php
        
        if( isset( $_REQUEST['settings-updated'] ) ){
            if( $_REQUEST['settings-updated'] == 'true' ){
                ?><div id="setting-error" class="updated settings-error">
                    <p><strong>Request complete. links was recorded to the database.</strong></p>
                </div><?php
            } else {
                ?><div id="setting-error" class="error settings-error">
                    <p><strong><?php
                        switch($_REQUEST['message']){
                            case '1':
                                _e('Request unseccessful. Please setup the <a href="'. admin_url('admin.php?page=wpauthority') .'">API Settings</a>.');
                                break;
                            case '2':
                                _e('Request unseccessful. API Server error.');
                                break;
                            case '3':
                                _e('Upload error. file is broken.');
                                break;
                            case '4':
                                _e('Please upload a valid CSV file.');
                                break;
                            case '5':
                                _e('Error. No file choosen.');
                                break;
                            default:
                                _e('Request unsuccesful. 0 links recorded.');
                                break;
                        }
                    ?></strong></p>
                </div><?php
            }
        }
        
        ?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>" enctype="multipart/form-data">
        
            <h3>Alexa AWIS API Request</h3>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="subject"><strong>Subject Name</strong></label></th>
                    <td>
                        <input type="text" name="subject" id="subject" value="" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="rank_start"><strong>Start on Rank</strong></label></th>
                    <td>
                        <input type="text" name="rank_start" id="rank_start" value="" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="request_limit"><strong>Number of Request</strong></label></th>
                    <td>
                        <input type="text" name="request_limit" id="request_limit" value="" class="regular-text" /><br />
                        <span class="description">Response time depends on the number of request.</span>
                    </td>
                </tr>
            </table>
            
            <p><input type="submit" value="Make Request" class="button-primary" id="submit" name="awp_request" /></p>
            
            <h3>Import a CSV</h3>
            
            <table class="form-table">
            	<tr valign="top" style="display:none;">
                	<th scope="row" colspan="2"><label>
                    	<input type="checkbox" id="has_custom_row" value="1" /> <?php _e('Start on a custom row'); ?>
                    </label></th>
                </tr>
                
                <tr valign="top" class="csv_cutom_row" style="display:none;">
                	<th scope="row"><label for="row_start"><strong><?php _e('Starting row'); ?></strong></label></th>
                    <td><input type="text" name="csv_start_row" id="row_start" value="" /></td>
                </tr>
                
                <tr valign="top" class="csv_cutom_row" style="display:none;">
                	<th scope="row"><label for="row_end"><strong><?php _e('End row'); ?></strong></label></th>
                    <td><input type="text" name="csv_limit_row" id="row_end" value="" /></td>
                </tr>
                
                <tr valign="top">
                    <th scope="row">
                    	<label for="awp_file"><strong>Upload CSV</strong></label><br>
                        <small class="description"><a href="<?php echo PLUGINURL; ?>/uploads/cron.csv" target="_blank">Click here</a> to download a sample CSV file format.</small>
                    </th>
                    <td align="top">
                        <input type="file" name="awp_file" id="awp_file" value="" class="regular-text" />
                        <input type="submit" value="Upload" class="button-primary" id="submit" name="awp_upload" />
                        <br /><span class="description">Maximum of <?php echo (int)(ini_get('upload_max_filesize')); ?>mb filesize.</span>
                    </td>
                </tr>
            </table>
            
            <h3>Bulk Add Import</h3>
            
            <table class="form-table">
            	<tr>
                	<th scope="row">
                    	<label for="awp_domain"><strong><?php _e('Domains', 'wpa'); ?></strong></label><br>
                        <small class="description">One per line</small>
                    </th>
                    <td><textarea name="awp_domain" id="awp_domain" class="large-text" rows="7"></textarea></td>
                </tr>
                <tr>
                	<th scope="row">
                    	<label for="awp_domain_tags"><strong><?php _e('Tags', 'wpa'); ?></strong></label><br>
                        <small class="description">Separate each tag with comma</small>
                    </th>
                    <td>
                    	<input type="text" name="awp_domain_tags" id="awp_domain_tags" class="regular-text" value="" />
                    </td>
                </tr>
            </table>
            
            <p><input type="submit" value="Import Domains" class="button-primary" id="submit" name="awp_import_domain" /></p>
            
            <h3><?php _e('BuySellAds – Crawler', 'wpa'); ?></h3>
            
            <table class="form-table">
            
            </table>
            
            <h3><?php _e('Technorati Crawler', 'wpa'); ?></h3>
            
            <table class="form-table">
            
            </table>
            
        </form>
	</div><?php
}

function wpas_admin_pages(){
	global $options;
	$options = get_option('awp_options');
	$settings = get_option('awp_settings');
	$websites = get_option('awp_websites');
	
	$tab = $_REQUEST['tab'] ? $_REQUEST['tab'] : 'action';
	
	?><div class="wrap"><?php
		
		wpa_admin_nav_tabs();
		
		switch($tab){
			case 'action':
			default:
				load_template( trailingslashit( PLUGINPATH ) . 'admin/general.php' );
				break;
			
			case 'connect':
				load_template( trailingslashit( PLUGINPATH ) . 'admin/connect.php' );
				break;
			
			case 'bots':
				//load_template( trailingslashit( PLUGINPATH ) . 'admin/bots.php' );
				break;
			
			case 'cron':
				load_template( trailingslashit( PLUGINPATH ) . 'admin/cron.php' );
				break;
			
			case 'metrics':
			case 'groups':
				load_template( trailingslashit( PLUGINPATH ) . 'admin/metrics.php' );
				break;
			
			case 'addgroup':
			case 'editgroup':
				load_template( trailingslashit( PLUGINPATH ) . 'admin/editgroup.php' );
				break;
			
			case 'addmetric':
			case 'editmetric':
				load_template( trailingslashit( PLUGINPATH ) . 'admin/addgroup.php' );
				break;
			
			case 'content-seo':
				load_template( trailingslashit( PLUGINPATH ) . 'admin/content-seo.php' );
				break;
			
			case 'templates':
				load_template( trailingslashit( PLUGINPATH ) . 'admin/templates.php' );
				break;
			
			case 'checker':
				?><h3>Running WP Checker</h3>
				<p>Checking each sites manually to check if they are built by WordPress...</p><?php
				
				$cron = new Base_Cron();
				$cron->wp_authority_update_list();
				
				?><p>WP Check finished successfully!</p><?php
				break;
		}
	?></div><?php
}

function wpas_metrics_subnav(){
	$navs = array(
		'metrics' => 'Metrics',
		'groups' => 'Groups',
		'addmetric' => 'Add Metric',
		'addgroup' => 'Add Group'
	);
	
	$tab = $_REQUEST['tab'] ? $_REQUEST['tab'] : 'action';
	$i = 1;
	
	echo '<ul class="subsubsub">';
		foreach($navs as $link=>$label){
			$class = ($link == $tab) ? 'current' : '';
			$separator = ($i < count($navs)) ? '|' : '';
			echo sprintf(
				'<li><a href="%s" class="%s">%s</a> %s </li>',
				admin_url('edit.php?post_type=site&page=wpauthority&tab='.$link),
				$class,
				$label,
				$separator
			);
			$i++;
		}
	echo '</ul>';
}

function wpa_admin_nav_tabs(){
	$tabs = array(
		'action' => 'General',
		'connect' => 'Connect API',
		'bots' => 'Bots',
		'cron' => 'Cron',
		'metrics' => 'Metrics',
		'content-seo' => 'Content & SEO',
		'templates' => 'Templates'
	);
	
	?><div id="icon-ows" class="icon32"><img src="<?php echo PLUGINURL; ?>images/icon32.jpg" alt="WP Sites" /></div>
    
    <h2 class="nav-tab-wrapper supt-nav-tab-wrapper"><?php
		foreach($tabs as $tab=>$nav){
			$current_nav = isset($_GET['tab']) ? $_GET['tab'] : 'action';
			$classes = array('nav-tab');
			$classes[] = ($current_nav == $tab) ? 'nav-tab-active' : null;
			
			?><a href="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&tab=' . $tab); ?>" class="<?php echo implode(' ', $classes); ?>"><?php echo $nav; ?></a><?php
		}
    ?></h2>
	
	<div>&nbsp;</div><?php
}

function wp_authority_update(){
	do_action('wp_authority_update');
}

function get_post_by_title($post_title, $post_type = 'post', $output = OBJECT){
	global $wpdb;
	
	$post_id = $wpdb->get_var(
		$wpdb->prepare(
			sprintf("
				SELECT ID FROM $wpdb->posts WHERE post_title = '%s' AND post_type = '%s' AND post_status = 'publish'",
				$post_title,
				$post_type
			),
			$output
		)
	);
	
	return $post_id;
}

function wpa_paginate($pages = ''){
	global $paged;
	global $wp_query;
	
	if(empty($paged)){
		$paged =1;
	}
	
	if($pages == ''){
		$pages = $wp_query->max_num_pages;
		if(!$pages){
			$pages = 1;
		}
	}
	
	$range = $wp_query->posts_per_page;
	$showitems = ($range * 2) + 1;
	
	if($pages != 1){
		echo '<div class="wpa-paginate-posts"><ul>';
		if($paged > 1 AND $showitems < $pages){
			echo '<li><a href="'.get_pagenum_link($paged - 1).'"><< previous</a></li>';
		}
		
		for($counter = 1; $counter <= $pages; $counter++){
			if($pages != 1 AND (!($counter >= $paged + $range + 1 OR $counter <= $paged-$range-1) OR $pages <= $showitems)){
				$nextPageNum = $paged + 1;
				echo ($paged == $counter) ? '<li><a href="'.get_pagenum_link($nextPageNum).'">'.$nextPageNum.'</a></li>' : '<li><a href="'.get_pagenum_link($counter).'">'.$counter.'</a></li>';
			}
		}
		
		if($paged < $pages AND $showitems < $pages){
			echo '<li><a href="'.get_pagenum_link($paged + 1).'"> next >></a></li>';
		}
		echo '</ul></div>';
	}
}

remove_filter('sanitize_title', 'sanitize_title_with_dashes');

function sanitize_title_with_dots_and_dashes($title) {
	$title = strip_tags($title);
	// Preserve escaped octets.
	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
	// Remove percent signs that are not part of an octet.
	$title = str_replace('%', '', $title);
	// Restore octets.
	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

	$title = remove_accents($title);
	if (seems_utf8($title)) {
		if (function_exists('mb_strtolower')) {
			$title = mb_strtolower($title, 'UTF-8');
		}
		$title = utf8_uri_encode($title);
	}

	$title = strtolower($title);
	$title = preg_replace('/&.+?;/', '', $title); // kill entities
	$title = preg_replace('/[^%a-z0-9 ._-]/', '', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');
	$title = str_replace('-.-', '.', $title);
	$title = str_replace('-.', '.', $title);
	$title = str_replace('.-', '.', $title);
	$title = preg_replace('|([^.])\.$|', '$1', $title);
	$title = trim($title, '-'); // yes, again

	return $title;
}

add_filter('sanitize_title', 'sanitize_title_with_dots_and_dashes');

/*add_action( 'admin_bar_menu', 'wpa_admin_bar_menu', 40 );
function wpa_admin_bar_menu(){
	global $wp_admin_bar;
	
	if ( !is_super_admin() || !is_admin_bar_showing() )
		return;
	
	$wp_admin_bar->add_menu(
		array(
			'parent' => 'new-content',
			'title' => __('WP Site'),
			'href' => admin_url('post-new.php?post_type=site')
		)
	);
	
	if( is_single() ){
		global $post;
		
		if($post->post_type == 'site'){
			$wp_admin_bar->add_menu(
				array(
					'title' => __('Edit Site'),
					'href' => admin_url('post.php?post=' . $post->ID . '&action=edit')
				)
			);
		}
	}
}*/

function get_user_by_display_name( $display_name ) {
    global $wpdb;
	
	$user = $wpdb->get_row("SELECT `ID` FROM wp_users WHERE `display_name` = '" . $display_name . "'");
    if ( $user ) {
		return get_user_by( 'id', $user->ID );
	} else {
		return false;
	}
}
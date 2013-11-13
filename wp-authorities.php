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
load_template( trailingslashit( PLUGINPATH ) . 'classes/base.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/cron.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/integration.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/bb_builder.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/scrapewp.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/topSites.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/template-loader.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/template-hooks.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/shortcodes.class.php' );

register_activation_hook( __FILE__, 'awp_activate' );
register_deactivation_hook( __FILE__, 'awp_deactivate' );

add_action('admin_menu', 'awp_register_pages');

function awp_activate(){
	awp_set_options();
}

function awp_set_options() {
	$option = array();
	
	// Build our option
	$option['StartNum'] = 1;
	$option['cronLimit'] = 20;
	
	add_option('awp_options', $option);
	add_option('awp_websites', array());
	add_option('awp_requests', array());
	add_option('awp_settings', array());
	add_option('wpa_metrics', array());
}

function awp_deactivate(){
	delete_option('awp_options');
	delete_option('awp_websites');
	delete_option('awp_requests');
	delete_option('awp_settings');
	delete_option('wpa_metrics');
	delete_option('bb_builder_depts');
	
	// On deactivation, remove all functions from the scheduled action hook.
	wp_clear_scheduled_hook( 'wp_authority_update' );
}

add_action( 'init', 'awp_sidebars' );

function awp_sidebars(){
	register_sidebar( array(
		'name' => __( 'AWP Site Sidebar', 'awp' ),
		'id' => 'sidebar-site',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

add_action('template_redirect', 'awp_archive_tax_query');
function awp_archive_tax_query(){
	global $post, $wp_query;
	$settings = get_option('awp_settings');
	$query = array('relation' => 'OR');
	
	if( !$settings['xtype'] )
		$settings['xtype'] = array();
	
	if( !$settings['xStatus'] )
		$settings['xStatus'] = array();
	
	$operator = ($settings['action_taxonomy'] == 'include') ? 'IN' : 'NOT IN';
	
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
				'operator' => $operator
			);
		}
	}
	
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
				'operator' => $operator
			);
		}
	}
	
	if ( is_post_type_archive( array('site') ) ){
		$wp_query->set("tax_query", $query);
	}
	
	$wp_query->get_posts();
}

add_action( 'wp_loaded', 'awp_options_handle' );
function awp_options_handle(){
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
				$links[$pID] = get_the_title($pID);
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
					
					wp_set_object_terms( $wp['ID'], '$Wordpress', 'site-type', true );
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
							$row = ($rank_start) ? $rank_start : 1; // Set rank start
							$i = 1;
							
							$limit = ($request_limit) ? $request_limit : 5000;
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
				
				// wp_die( '<pre>' . print_r($websites, true) . '</pre>' );
				
				foreach($websites as $site){
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
			
			if($awp_domain_tags != ''){
				$terms = explode(',', $awp_domain_tags);
				$taxonomies = array(
					'site-tag' => $terms,
					'site-status' => array(
						'!imported',
						'!imported by Bulk Add',
						'!Imported – ' . date('y.m.d;H:i')
					)
				);
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
					
					update_post_meta($pID, 'awp-alexa-rank', $site['rank']);
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
				'action_taxonomy',
				'xtype',
				'xStatus',
				'hide_timestamp'
			);
			
			foreach( $fields as $fl ){
				( isset($awp_settings[$fl]) || $awp_settings[$fl] != $settings[$fl]) ? $settings[$fl] = $awp_settings[$fl] : null;
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
			$links[$pID] = get_the_title($pID);
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
				
				wp_set_object_terms( $wp['ID'], '$Wordpress', 'site-type', true );
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
		
		/*?><pre><?php print_r($_POST); ?></pre><?php wp_die();*/
		
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

function awp_register_pages(){
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
	
	add_submenu_page( 'edit.php?post_type=site', 'Action Tags', 'Action Tags', 'manage_options', 'javascript:void(0);' );
	add_submenu_page( 'edit.php?post_type=site', 'Import', 'Import', 'manage_options', 'wpa_import', 'wpa_import_callback' );
	add_submenu_page( 'edit.php?post_type=site', 'Settings', 'Settings', 'manage_options', 'wpauthority', 'awp_admin_pages' );
	
	add_action( "load-$ofpage", 'base_screen_options' ); // Custom table screen options
	add_action( "admin_print_scripts", 'awp_admin_scripts' );
}

function awp_admin_scripts(){
	wp_enqueue_script('wpadminjs', PLUGINURL . '/js/admin.js', array('jquery'));
	wp_enqueue_style( 'awpstyles', PLUGINURL . '/css/admin.css' );
}

function wpa_import_callback(){
	
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
                <tr>
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

/*function awp_overview_page(){
	global $websites;
	$websites = get_option('awp_websites');
	
	?><div class="wrap">
    	<div id="icon-ows" class="icon32"><img src="<?php echo PLUGINURL; ?>images/icon32.jpg" alt="WP Sites" /></div>
        <h2 class="nav-tab-wrapper supt-nav-tab-wrapper"><?php
            // _e('WP Sites');
            ?><a href="<?php echo admin_url('admin.php?page=wpauthority&tab=upload'); ?>" class="nav-tab">Import</a>
            <a href="<?php echo admin_url('admin.php?page=wpauthority'); ?>" class="nav-tab">Connect</a>
            <a href="<?php echo admin_url('admin.php?page=wpauthority&tab=cron'); ?>" class="nav-tab">Cron</a>
            <a href="<?php echo admin_url('admin.php?page=wpauthority&tab=metrics'); ?>" class="nav-tab">Metrics</a>
            <a href="<?php echo admin_url('admin.php?page=wpauthority&tab=content-seo'); ?>" class="nav-tab">Content & SEO</a>
            <a href="<?php echo admin_url('admin.php?page=wpauthority&tab=action'); ?>" class="nav-tab">Action Tags</a>
            <!-- <a href="<?php echo admin_url('admin.php?page=wpauthority&tab=checker'); ?>" class="nav-tab">WP Checker</a> --->
        </h2><div>&nbsp;</div><?php
        
        if( isset( $_REQUEST['settings-updated'] ) ){
            if( $_REQUEST['settings-updated'] == 'true' ){
                ?><div id="setting-error" class="updated settings-error">
                    <p><strong><?php
                    	switch($_REQUEST['message']){
							case '1':
								_e('Website link entry deleted suceesfully.');
								break;
							case '2':
							default:
								_e('Settings saved.');
								break;
						}
					?></strong></p>
                </div><?php
            } else {
                ?><div id="setting-error" class="error settings-error">
                    <p><strong><?php
						switch($_REQUEST['message']){
							case '1':
								_e('Website link cannot be deleted.');
								break;
							case '2':
								_e('Settings not saved');
								break;
						}
					?></strong></p>
                </div><?php
            }
        }
        
        ?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>"><?php
            
			if( isset($_REQUEST['action']) && ('edit' == $_REQUEST['action']) ){
				$item = $websites[$_REQUEST['link']];
				if($item){
					?><div class="editForm">
						<h3>Edit Item</h3>
						<label for="website_name">Name</label>
						<input type="text" name="website[name]" id="website_name" value="<?php echo $item['name']; ?>" />
						&nbsp;
						<input type="checkbox" name="website[check]" id="website_scanned" value="true" <?php checked($item['check'], 'true'); ?> />
						<label for="website_scanned">Scanned</label>
						&nbsp;
						<label for="website_rank">Rank</label>
						<input type="text" name="website[rank]" id="website_rank" value="<?php echo $item['rank']; ?>" />
                        
                        <input type="hidden" name="link" value="<?php echo $item['name']; ?>" />
                        <input class="button-primary" type="submit" name="awp_update_link" value="Update" />
					</div><?php
				}
			}
			
			$base = new Base_Table();
			
			$freshlinks = array();
			if( isset($_REQUEST['checked']) && ('' != $_REQUEST['checked']) ){
				
				if('true' == $_REQUEST['checked']){
					foreach($websites as $fl){
						if($fl['check'] == true){
							$freshlinks[] = $fl;
						}
					}
				} elseif( ($fl['check'] == false) && ('false' == $_REQUEST['checked']) ){
					foreach($websites as $fl){
						if($fl['check'] == false){
							$freshlinks[] = $fl;
						}
					}
				} else {
					$freshlinks = $websites;
				}
				
			} else {
				$freshlinks = $websites;
			}
			
			if(isset($_POST['s']) and '' != $_POST['s']){
				$items = array();
				if( isset( $freshlinks[$_POST['s']] ) ){
					$items[] = $freshlinks[$_POST['s']];
				}
				
				$base->set_data($items);
			} else {
				$base->set_data($freshlinks);
			}
			
            $base->prepare_items();
			
			?><div class="alignleft actions">
                <select name="checked" id="awp-checked">
                    <option value="0" <?php selected($_REQUEST['checked'], 0); ?>>Show All</option>
                    <option value="true" <?php selected($_REQUEST['checked'], 'true'); ?>>Show all scanned</option>
                    <option value="false" <?php selected($_REQUEST['checked'], 'false'); ?>>Show all not scanned</option>
                </select>
                <script type="text/javascript">
					jQuery(document).ready(function($) {
                        $('#awp-checked').change(function(e) {
                            e.preventDefault();
							window.location.href = "<?php echo admin_url('admin.php?page=wpauthorities&checked='); ?>" + $(this).val();
                        });
                    });
				</script>
			</div><?php
			
            $base->search_box('search', 'search_cpt');
            $base->display();
            
        	?><h3>Cron Statistics</h3><?php
			
            $count_posts = wp_count_posts( 'site' );
			
			// Count all scanned websites
			$checked = 0;
			foreach( $websites as $wb ){
				if($wb['check']){
					$checked++;
				}
			}
            
            ?><p><strong><?php _e('Number of websites recorded:'); ?></strong> <?php echo count($websites); ?></p>
            <p><strong><?php _e('Number of websites already scanned:'); ?></strong> <?php echo $checked; ?></p>
			<p><strong><?php _e('Number of websites detected as wordpress:'); ?></strong> <?php echo ($count_posts->publish) ? $count_posts->publish : 0; ?></p>
        
        </form>
	</div><?php
}*/

function awp_admin_pages(){
	global $options;
	$options = get_option('awp_options');
	$settings = get_option('awp_settings');
	$websites = get_option('awp_websites');
	
	$tab = $_REQUEST['tab'] ? $_REQUEST['tab'] : 'action';
	
	?><div class="wrap"><?php
		
		wpa_admin_nav_tabs();
		
		switch($tab){
			case 'cron':
				
				if( isset( $_REQUEST['settings-updated'] ) ){
					if( $_REQUEST['settings-updated'] == 'true' ){
						?><div id="setting-error" class="updated settings-error">
                        	<p><strong><?php _e('Settings saved.'); ?></strong></p>
                        </div><?php
					} else {
						?><div id="setting-error" class="error settings-error">
                        	<p><strong><?php _e('Settings not saved.'); ?></strong></p>
                        </div><?php
					}
				}
				
				?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>">
                	
                    <h3>Cron Settings</h3>
                    <table class="form-table">
                        <tr>
                        	<th scope="row"><label for="cronjob">Cronjob</label></th>
                            <td>
                            	<input type="checkbox" name="awp_settings[cronjob]" id="cronjob" value="true" <?php checked($settings['cronjob'], 'true'); ?> />
                                <label for="cronjob">Enable Cronjob</label>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="rank_page">Link to get page ranking</label></th>
                            <td>
                            	<input type="text" name="awp_settings[rank_page]" id="rank_page" value="<?php echo $settings['rank_page'] ?>" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="request_limit">Page ranking request limit</label></th>
                            <td>
                            	<input type="text" name="awp_settings[request_limit]" id="request_limit" value="<?php echo $settings['request_limit'] ?>" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="scrape_link">Link for wordpress scraping</label></th>
                            <td>
                            	<input type="text" name="awp_settings[scrape_link]" id="scrape_link" value="<?php echo $settings['scrape_link'] ?>" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="scrape_limit">Scraping limit per request</label></th>
                            <td>
                            	<input type="text" name="awp_settings[scrape_limit]" id="scrape_limit" value="<?php echo $settings['scrape_limit'] ?>" class="regular-text" />
                            </td>
                        </tr>
                    </table>
                    
                    <p>
                    	<input type="hidden" name="redirect" value="<?php echo admin_url('admin.php?page=wpauthority&tab=cron&settings-updated=true'); ?>" />
                    	<input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" />
                    </p>
                    
				</form><?php
				break;
			
			case 'addgroup':
			case 'editgroup':
			
				if( isset( $_REQUEST['settings-updated'] ) ){
					if( $_REQUEST['settings-updated'] == 'true' ){
						?><div id="setting-error" class="updated settings-error">
                        	<p><strong><?php _e('Settings saved.'); ?></strong></p>
                        </div><?php
					} else {
						?><div id="setting-error" class="error settings-error">
                        	<p><strong><?php _e('Settings not saved.'); ?></strong></p>
                        </div><?php
					}
				}
				
				$group = false;
				if( isset($_REQUEST['id']) && '' != $_REQUEST['id'] ){
					$group = wpa_get_metrics_group_by_id($_REQUEST['id']);
				}
				
				$editable = ($group['readonly']) ? true : false;
				
				?><form name="awp_settings" method="post" action="<?php echo admin_url('edit.php?post_type=site&page=wpauthority'); ?>">
                	<div class="new-metric-wrapper">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="wpa_metrics_label">Group Label</label></th>
                                <td><input type="text" name="wpa_metrics[name]" id="wpa_metrics_label" value="<?php echo ($group['name']) ? $group['name'] : ''; ?>" <?php echo ($editable) ? 'readonly="readonly"' : '' ?> class="regular-text" /><br>
                                <span class="description"></span></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wpa_metrics_name">Group Name</label></th>
                                <td><input type="text" name="wpa_metrics[id]" id="wpa_metrics_name" value="<?php echo ($group['id']) ? $group['id'] : ''; ?>" <?php echo ($editable) ? 'readonly="readonly"' : '' ?> class="regular-text" /><br>
                                <span class="description"></span></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wpa_metrics_cat">Group Category</label></th>
                                <td><select name="wpa_metrics[category]" id="wpa_metrics_cat">
                                    <option value="departments" <?php selected($group['category'], 'departments'); ?>>Departments</option>
                                    <option value="signals" <?php selected($group['category'], 'signals'); ?>>Signals</option>
                                    <option value="valuation" <?php selected($group['category'], 'valuation'); ?>>Valuation</option>
                                </select><br>
                                <span class="description"></span></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wpa_metrics_desc">Meta Description</label></th>
                                <td><textarea name="wpa_metrics[desc]" id="wpa_metrics_desc" class="regular-textarea"><?php echo ($group['desc']) ? $group['desc'] : ''; ?></textarea><br>
                                <span class="description"></span></td>
                            </tr>
                        </table>
                        <p><?php
                        	if($editable){
								?><input type="hidden" name="readonly" value="1" /><?php
							}
							
                        	?><input type="hidden" name="type" value="heading" />
                            <input type="hidden" name="redirect" value="<?php echo admin_url('admin.php?page=wpauthority&tab=groups&settings-updated=true'); ?>" /><?php
							
							if($group){
                            	?><input type="hidden" name="group_id" value="<?php echo $group['id'] ?>" />
                                <input type="submit" value="Save Group" class="button-primary" id="submit" name="wpa_save_group" /><?php
							} else {
								?><input type="submit" value="+ Add Group" class="button-primary" id="submit" name="wpa_save_group" /><?php
							}
							
                        ?></p>
                    </div><!-- /new-metric-wrapper -->
                </form><?php
				break;
			
			case 'addmetric':
			case 'editmetric':
			
				if( isset( $_REQUEST['settings-updated'] ) ){
					if( $_REQUEST['settings-updated'] == 'true' ){
						?><div id="setting-error" class="updated settings-error">
                        	<p><strong><?php _e('Settings saved.'); ?></strong></p>
                        </div><?php
					} else {
						?><div id="setting-error" class="error settings-error">
                        	<p><strong><?php _e('Settings not saved.'); ?></strong></p>
                        </div><?php
					}
				}
				
				$field = false;
				if( isset($_REQUEST['id']) && '' != $_REQUEST['id'] ){
					$field = wpa_get_metrics_by_id($_REQUEST['id']);
				}
				
				$editable = ($field['readonly']) ? false : true;
				
				?><form name="awp_settings" method="post" action="<?php echo admin_url('edit.php?post_type=site&page=wpauthority'); ?>">
                	<div class="new-metric-wrapper">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="wpa_metrics_label">Field Label</label></th>
                                <td><input type="text" name="wpa_metrics[name]" id="wpa_metrics_label" value="<?php echo ($field['name']) ? $field['name'] : ''; ?>" <?php echo (!$editable) ? 'readonly="readonly"' : '' ?> class="regular-text" /><br>
                                <span class="description"></span></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wpa_metrics_name">Field Name</label></th>
                                <td><input type="text" name="wpa_metrics[id]" id="wpa_metrics_name" value="<?php echo ($field['id']) ? $field['id'] : ''; ?>" <?php echo (!$editable) ? 'readonly="readonly"' : '' ?> class="regular-text" /><br>
                                <span class="description"></span></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wpa_metrics_type">Field Type</label></th>
                                <td><?php
                                	if(!$editable){
										?><input type="text" name="wpa_metrics[type]" id="wpa_metrics_type" class="regular-text" value="<?php echo ($field['type']) ? $field['type'] : ''; ?>" readonly /><?php
									} else {
										?><select name="wpa_metrics[type]" id="wpa_metrics_type" <?php echo (!$editable) ? 'disabled="disabled"' : '' ?>>
                                            <option value="text" <?php selected($field['type'], 'text'); ?>>Text</option>
                                            <option value="textarea" <?php selected($field['type'], 'textarea'); ?>>Texarea</option>
                                            <option value="checkbox2" <?php selected($field['type'], 'checkbox2'); ?>>Checkbox</option>
                                            <option value="radio" <?php selected($field['type'], 'radio'); ?>>Radio</option>
                                            <option value="select" <?php selected($field['type'], 'select'); ?>>Select</option>
                                        </select><?php
                                	}
                                    ?><br><span class="description"></span>
                                </td>
                            </tr>
							
                            <tr id="wpa-options-row" style="display:<?php echo ($field['options']) ? 'table-row' : 'none'; ?>;">
                            	<th scope="row"><label for="wpa_metrics_options">Field Options</label></th>
                                <td><textarea name="wpa_metrics[options]" id="wpa_metrics_options" class="regular-textarea" <?php echo (!$editable) ? 'readonly="readonly"' : '' ?>><?php
                                	echo ($field['options']) ? implode('|', $field['options']) : '';
                                ?></textarea><br>
                                <span class="description"><?php _e('Separate each option using a pipe "|" without spaces.', 'wpa'); ?></span></td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label for="wpa_metrics_group">Field Group</label></th>
                                <td><?php
									if(!$editable){
										?><input type="text" name="wpa_metrics[group]" id="wpa_metrics_group" class="regular-text" value="<?php echo ($field['group']) ? $field['group'] : ''; ?>" readonly /><?php
									} else {
										?><select name="wpa_metrics[group]" id="wpa_metrics_group" <?php echo (!$editable) ? 'disabled="disabled"' : '' ?>><?php
											$metricsGroup = wpa_get_metrics_groups();
											foreach($metricsGroup as $group){
												?><option value="<?php echo $group['id']; ?>" <?php selected($field['group'], $group['id']); ?>><?php echo $group['name']; ?></option><?php
											}
										?></select><?php
									}
									?><br><span class="description"></span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wpa_metrics_tip">Field Instructions</label></th>
                                <td><textarea name="wpa_metrics[tip]" id="wpa_metrics_tip" class="regular-textarea"><?php echo ($field['tip']) ? $field['tip'] : ''; ?></textarea><br>
                                <span class="description"></span></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wpa_metrics_desc">Meta Description</label></th>
                                <td><textarea name="wpa_metrics[desc]" id="wpa_metrics_desc" class="regular-textarea"><?php echo ($field['desc']) ? $field['desc'] : ''; ?></textarea><br>
                                <span class="description"></span></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wpa_metrics_required">Required</label></th>
                                <td>
                                <label><input type="radio" name="wpa_metrics[required]" id="wpa_metrics_required" value="true" <?php checked($field['required'], 'true'); ?> /> Yes</label>
                                <label><input type="radio" name="wpa_metrics[required]" id="wpa_metrics_required" value="false" <?php checked($field['required'], 'false'); ?> /> No</label>
                                <br>
                                <span class="description"></span></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wpa_metrics_std">Default Value</label></th>
                                <td><input type="text" name="wpa_metrics[value]" id="wpa_metrics_std" value="<?php echo ($field['std']) ? $field['std'] : ''; ?>" class="regular-text" /><br>
                                <span class="description"></span></td>
                            </tr>
                        </table>
                        <p><?php
							if(!$editable){
								?><input type="hidden" name="readonly" value="1" /><?php
							}
							?><input type="hidden" name="redirect" value="<?php echo admin_url('admin.php?page=wpauthority&tab=metrics&settings-updated=true'); ?>" /><?php
							
							if($field){
								?><input type="hidden" name="metric_id" value="<?php echo $field['id']; ?>" />
                                <input type="submit" value="Save Field" class="button-primary" id="submit" name="wpa_save_metric" /><?php
							} else {
								?><input type="submit" value="+ Add Field" class="button-primary" id="submit" name="wpa_save_metric" /><?php
							}
                        ?></p>
                    </div><!-- /new-metric-wrapper -->
                </form><?php
				break;
			
			case 'metrics':
			case 'groups':
			
				?><ul class="subsubsub">
                    <li><a href="<?php echo admin_url('admin.php?page=wpauthority&tab=metrics'); ?>" class="<?php echo ('metrics' == $tab) ? 'current' : ''; ?>">Metrics</a> |</li>
                    <li><a href="<?php echo admin_url('admin.php?page=wpauthority&tab=groups'); ?>" class="<?php echo ('groups' == $tab) ? 'current' : ''; ?>">Groups</a></li><?php
                    
					if('metrics' == $tab){
						?><li><a href="<?php echo admin_url('admin.php?page=wpauthority&tab=addmetric'); ?>" class="add-new-h2"><?php
                        	_e('Add Metric', 'wpa');
                        ?></a></li><?php
					} else {
						?><li><a href="<?php echo admin_url('admin.php?page=wpauthority&tab=addgroup'); ?>" class="add-new-h2"><?php
                        	_e('Add Group', 'wpa');
                        ?></a></li><?php
					}
					
                ?></ul><?php
				
				if( isset( $_REQUEST['settings-updated'] ) ){
					if( $_REQUEST['settings-updated'] == 'true' ){
						?><div id="setting-error" class="updated settings-error clear">
                        	<p><strong><?php _e('Settings saved.'); ?></strong></p>
                        </div><?php
					} else {
						?><div id="setting-error" class="error settings-error clear">
                        	<p><strong><?php _e('Settings not saved.'); ?></strong></p>
                        </div><?php
					}
				}
				
				?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>"><?php
                	
					if('metrics' == $tab){
						
						$metrics = wpa_default_metrics();
						
						?><table class="wp-list-table widefat fixed posts" cellpadding="0">
							<thead>
								<tr>
                                	<th scope="col" class="manage-column check-column">
										<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                                        <input id="cb-select-all-1" type="checkbox">
                                    </th>
									<th scope="col" class="manage-column name-column"><?php _e('Name', 'wpa'); ?></th>
									<th scope="col" class="manage-column description-column"><?php _e('Description', 'wpa'); ?></th>
									<th scope="col" class="manage-column id-column"><?php _e('ID', 'wpa'); ?></th>
									<th scope="col" class="manage-column type-column"><?php _e('Type', 'wpa'); ?></th>
									<th scope="col" class="manage-column group-column"><?php _e('Group', 'wpa'); ?></th>
								</tr>
							</thead>
							
							<tfoot>
								<tr>
                                	<th scope="col" class="manage-column check-column">
										<label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                                        <input id="cb-select-all-2" type="checkbox">
                                    </th>
									<th scope="col" class="manage-column name-column"><?php _e('Name', 'wpa'); ?></th>
									<th scope="col" class="manage-column description-column"><?php _e('Description', 'wpa'); ?></th>
									<th scope="col" class="manage-column id-column"><?php _e('ID', 'wpa'); ?></th>
									<th scope="col" class="manage-column type-column"><?php _e('Type', 'wpa'); ?></th>
									<th scope="col" class="manage-column group-column"><?php _e('Group', 'wpa'); ?></th>
								</tr>
							</tfoot>
							
							<tbody><?php
                            	foreach($metrics as $cfields){
									if('heading' == $cfields['type'] || 'separator' == $cfields['type']){
										continue;
									} else {
										?><tr>
											<th scope="col" class="manage-column check-column">
												<label class="screen-reader-text" for="cb-select-1">Select this Item</label>
												<input name="custom_metrics" id="cb-select-1" type="checkbox" value="<?php echo $cfields['id']; ?>" />
											</th>
											<td>
												<a href="<?php echo admin_url('admin.php?page=wpauthority&tab=editmetric&id=' . $cfields['id']); ?>"><strong><?php echo $cfields['name']; ?></strong></a>
												<div class="row-actions">
													<span class="edit"><a href="<?php echo admin_url('admin.php?page=wpauthority&tab=editmetric&id=' . $cfields['id']); ?>" title="Edit this item">Edit</a><?php
													
													if($cfields['readonly'] == false){
														?> | </span><span class="trash">
                                                        	<a class="submitdelete" title="Delete Item" href="<?php echo admin_url('admin.php?page=wpauthority&metric_action=delete&id='.$cfields['id']); ?>">Delete</a>
                                                        </span><?php
													} else {
														?></span><?php
													}
													
												?></div>
											</td>
											<td><?php echo $cfields['description']; ?></td>
											<td><?php echo $cfields['id']; ?></td>
											<td><?php echo $cfields['type']; ?></td>
											<td><?php echo $cfields['group']; ?></td>
										</tr><?php
									}
								}
							?></tbody>
						</table><?php
					} else {
						?><table class="wp-list-table widefat fixed posts" cellpadding="0">
							<thead>
								<tr>
									<th scope="col" class="manage-column name-column"><?php _e('Name', 'wpa'); ?></th>
									<th scope="col" class="manage-column description-column"><?php _e('Description', 'wpa'); ?></th>
								</tr>
							</thead>
							
							<tfoot>
								<tr>
									<th scope="col" class="manage-column name-column"><?php _e('Name', 'wpa'); ?></th>
									<th scope="col" class="manage-column description-column"><?php _e('Description', 'wpa'); ?></th>
								</tr>
							</tfoot>
							
							<tbody><?php
								$groups = wpa_get_metrics_groups();
								foreach($groups as $headings){
									?><tr>
                                        <td>
                                            <a href="<?php echo admin_url('admin.php?page=wpauthority&tab=editgroup&id=' . $headings['id']); ?>"><strong><?php echo $headings['name']; ?></strong></a>
                                            <div class="row-actions">
                                                <span class="edit"><a href="<?php echo admin_url('admin.php?page=wpauthority&tab=editgroup&id=' . $headings['id']); ?>" title="Edit this item">Edit</a><?php
												
												if($headings['readonly'] == false){
													?> | </span>
                                                	<span class="trash">
                                                		<a class="submitdelete" title="Delete Item" href="<?php echo admin_url('admin.php?page=wpauthority&metric_action=delete&id='.$headings['id']); ?>">Delete</a>
                                                    </span><?php
												} else {
													?></span><?php
												}
												
                                            ?></div>
                                        </td>
                                        <td><?php echo $headings['desc']; ?></td>
                                    </tr><?
								}
							?></tbody>
						</table>
						
						</table><?php
					}
                    
				?></form><?php
				break;
			
			case 'content-seo':
				
				if( isset( $_REQUEST['settings-updated'] ) ){
					if( $_REQUEST['settings-updated'] == 'true' ){
						?><div id="setting-error" class="updated settings-error">
                        	<p><strong><?php _e('Settings saved.'); ?></strong></p>
                        </div><?php
					} else {
						?><div id="setting-error" class="error settings-error">
                        	<p><strong><?php _e('Settings not saved.'); ?></strong></p>
                        </div><?php
					}
				}
				
				?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>">
                
                	<h3><?php _e('Archive', 'wpa'); ?></h3>
                    
                    <table class="form-table">
                    	<tr>
                        	<th scope="row"><label for="archive_meta_title">Meta Title</label></th>
                            <td><input type="text" class="regular-text" name="awp_settings[archive_meta_title]" id="archive_meta_title" value="<?php echo $settings['archive_meta_title']; ?>" /></td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="archive_meta_desc">Meta Description</label></th>
                            <td><input type="text" class="regular-text" name="awp_settings[archive_meta_desc]" id="archive_meta_desc" value="<?php echo $settings['archive_meta_desc']; ?>" /></td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="archive_meta_keywords">Meta Keywords</label></th>
                            <td><input type="text" class="regular-text" name="awp_settings[archive_meta_keywords]" id="archive_meta_keywords" value="<?php echo $settings['archive_meta_keywords']; ?>" /></td>
                        </tr>
                        
                        <tr>
                        	<th scope="row"><label for="archive_page_title">Archive Page Title</label></th>
                            <td><input type="text" class="regular-text" name="awp_settings[archive_page_title]" id="archive_page_title" value="<?php echo $settings['archive_page_title']; ?>" /></td>
                        </tr>
                        
                        <tr>
                        	<th scope="row"><label for="archive_content_before">Content After Title</label></th>
                            <td><?php
                            	wp_editor( $settings['archive_content_before'], 'archive_content_before', array(
									'textarea_name' => 'awp_settings[archive_content_before]'
								));
							?></td>
                        </tr>
                        
                        <tr>
                        	<th scope="row"><label for="archive_content_after">Content After Site Lists</label></th>
                            <td><?php
                            	wp_editor( $settings['archive_content_after'], 'archive_content_after', array(
									'textarea_name' => 'awp_settings[archive_content_after]'
								));
							?></td>
                        </tr>
                    </table>
                    
                    <h3><?php _e('Single Site', 'wpa'); ?></h3>
                    
                    <table class="form-table">
                    	<tr>
                        	<th scope="row"><label for="wpa_single_sidebar"><?php _e('Single Sidebar', ''); ?></label></th>
                            <td><select name="awp_settings[single_sidebar]" id="wpa_single_sidebar">
								<option value="0" <?php selected($settings['single_sidebar'], 0); ?>>None</option><?php
								
								global $wp_registered_sidebars;
								foreach($wp_registered_sidebars as $id=>$args){
									?><option value="<?php echo $id; ?>" <?php selected($settings['single_sidebar'], $id); ?>><?php echo $args['name'] ?></option><?php
								}
								
                            ?></select>
							</td>
                        </tr>
                    </table>
                    
                    <p>
                    	<input type="hidden" name="redirect" value="<?php echo admin_url('admin.php?page=wpauthority&tab=content-seo&settings-updated=true'); ?>" />
                    	<input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" />
                    </p>
                    
				</form><?php
				break;
			
			case 'action':
				
				if( isset( $_REQUEST['settings-updated'] ) ){
					if( $_REQUEST['settings-updated'] == 'true' ){
						?><div id="setting-error" class="updated settings-error">
                        	<p><strong><?php _e('Settings saved.'); ?></strong></p>
                        </div><?php
					} else {
						?><div id="setting-error" class="error settings-error">
                        	<p><strong><?php _e('Settings not saved.'); ?></strong></p>
                        </div><?php
					}
				}
				
				?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>">
                	<h3><?php _e('Sites Archive Display', 'wpa'); ?></h3>
                    
                    <table class="form-table">
                    	<tr>
                        	<th scope="row"><label for="action_taxonomy">Exclude or Include</label></th>
                            <td>
                            	<select name="awp_settings[action_taxonomy]" id="action_taxonomy">
                                	<option value="exclude" <?php selected($settings['action_taxonomy'], 'exclude'); ?>>Exclude</option>
                                	<option value="include" <?php selected($settings['action_taxonomy'], 'include'); ?>>Include</option>
                                </select>
                            </td>
                        </tr>
                    	<tr>
                        	<th scope="row"><label for="">$Types to Omit from Sites Archive:</label><br>
                            <small class="description">Check terms not to include.</small></th>
                            <td><?php
								$types = get_terms('site-type', array(
									'orderby'       => 'name', 
									'order'         => 'ASC',
									'hide_empty'    => false
								));
								
								if(!$settings['xtype'])
									$settings['xtype'] = array();
								
								foreach($types as $tm){
									$checked = in_array($tm->slug, $settings['xtype']) ? 'checked="checked"' : '';
									?><label><input type="checkbox" name="awp_settings[xtype][]" value="<?php echo $tm->slug ?>" <?php echo $checked; ?> /> <?php echo $tm->name; ?> </label><br><?php
								}
                            ?></td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="">!Statuses to Omit from Sites Archive:</label><br>
                            <small class="description">Check terms not to include.</small></th>
                            <td><?php
								$types = get_terms('site-status', array(
									'orderby'       => 'name', 
									'order'         => 'ASC',
									'hide_empty'    => false
								));
								
								if(!$settings['xStatus'])
									$settings['xStatus'] = array();
								
								foreach($types as $tm){
									$checked = in_array($tm->slug, $settings['xStatus']) ? 'checked="checked"' : '';
									?><label><input type="checkbox" name="awp_settings[xStatus][]" value="<?php echo $tm->slug ?>" <?php echo $checked; ?> /> <?php echo $tm->name; ?> </label><br><?php
								}
                            ?></td>
                        </tr>
                    </table>
                    
                    <h3><?php _e('Sites Managed Display', 'wpa'); ?></h3>
                    
                    <table class="form-table">
                    	<tr>
                        	<th scope="row">
                            	<label for="wpa_hide_timestamp"><?php _e('Display Settings', 'wpa'); ?></label>
                            </th>
                            <td>
                            	<label><input type="checkbox" name="awp_settings[hide_timestamp]" id="wpa_hide_timestamp" value="true" <?php checked($settings['hide_timestamp'], 'true'); ?> class="regular-check" />
                                <?php _e('Hide Timestamp !Status tags from the admin sites table.'); ?></label>
                            </td>
                        </tr>
                    </table>
                    
                    <h3><?php _e('WordPress Authority Qualification Settings', 'wpa'); ?></h3>
                    
                    <table class="form-table">
                    	<tr>
                        	<th scope="row">
                            </th>
                        </tr>
                    </table>
                    
                    <p>
                    	<input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" />
                    </p>
                </form><?php
				break;
			
			case 'checker':
			
				?><h3>Running WP Checker</h3>
				<p>Checking each sites manually to check if they are built by WordPress...</p><?php
				
				$cron = new Base_Cron();
				$cron->wp_authority_update_list();
				
				?><p>WP Check finished successfully!</p><?php
				
				break;
			
			case 'bots':
				
				?><?php
				break;
			
			default:
				
				if( isset( $_REQUEST['settings-updated'] ) ){
					if( $_REQUEST['settings-updated'] == 'true' ){
						?><div id="setting-error" class="updated settings-error">
                        	<p><strong><?php _e('Settings saved.'); ?></strong></p>
                        </div><?php
					} else {
						?><div id="setting-error" class="error settings-error">
                        	<p><strong><?php _e('Settings not saved.'); ?></strong></p>
                        </div><?php
					}
				}
				
				?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>">
					<h3>Compete</h3>
                    
                    <table class="form-table">
                    	<tr>
                        	<th scope="row"><label for="compete_api_key">API Key</label></th>
                            <td><input type="text" name="awp_settings[compete_api_key]" id="compete_api_key" value="<?php echo $settings['compete_api_key']; ?>" class="regular-text" /><br />
                            <span class="description">You can get your api service <a href="https://developer.compete.com/" target="_blank">here.</a></td>
                        </tr>
                    </table>
					
                    <h3>Majestic</h3>
                    
                    <table class="form-table">
                    	<tr>
                        	<th scope="row"><label for="majestic_api_key">API Key</label></th>
                            <td><input type="text" name="awp_settings[majestic_api_key]" id="majestic_api_key" value="<?php echo $settings['majestic_api_key']; ?>" class="regular-text" /><br />
                            <span class="description">You can get your api service <a href="https://www.majesticseo.com/account/api/" target="_blank">here</a></td>
                        </tr>
                    </table>
                    
                	<h3>Alexa</h3>
                    
					<table class="form-table">
                    	<tr>
                        	<th scope="row"><label for="access_id">Access ID Key:</label></th>
                            <td>
                            	<input type="text" name="awp_settings[access_id]" id="access_id" value="<?php echo $settings['access_id']; ?>" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="access_secret">Secret Access Key</label></th>
                            <td>
                            	<input type="text" name="awp_settings[access_secret]" id="access_secret" value="<?php echo $settings['access_secret'] ?>" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="StartNum">Default Starting Rank:</label></th>
                            <td>
                            	<input type="text" name="awp_settings[StartNum]" id="StartNum" value="<?php echo $settings['StartNum'] ?>" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="cronLimit">Default Number of Site Rank Request</label></th>
                            <td>
                            	<input type="text" name="awp_settings[cronLimit]" id="cronLimit" value="<?php echo $settings['cronLimit'] ?>" class="regular-text" />
                            </td>
                        </tr>
                    </table>
                    
                    <h3>GrabzIT</h3>
                    
                    <table class="form-table">
                    	<tr>
                        	<th scope="row"><label for="grabzit_api_key">API Key</label></th>
                            <td><input class="regular-text" type="text" name="awp_settings[grabzit_api_key]" id="grabzit_api_key" value="<?php echo $settings['grabzit_api_key'] ?>" /></td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="grabzit_api_secret">API Secret</label></th>
                            <td><input class="regular-text" type="text" name="awp_settings[grabzit_api_secret]" id="grabzit_api_secret" value="<?php echo $settings['grabzit_api_secret'] ?>" /></td>
                        </tr>
                    </table>
                    
                    <p><input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" /></p>
				</form><?php
				
				break;
		}
	?></div><?php
}

function wpa_admin_nav_tabs(){
	$tabs = array(
		'action' => 'General',
		'connect' => 'Connect API',
		'bots' => 'Bots',
		'cron' => 'Cron',
		'metrics' => 'Metrics',
		'content-seo' => 'Content & SEO'
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

function base_screen_options(){
	$option = 'per_page';
	$args = array(
		'label' => 'Websites per page',
		'default' => 10,
		'option' => 'sites_per_page'
	);
	add_screen_option( $option, $args );
	
	$base = new Base_Table();
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

add_action( 'admin_bar_menu', 'wpa_admin_bar_menu', 40 );
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
}

function get_user_by_display_name( $display_name ) {
    global $wpdb;
	
	$user = $wpdb->get_row("SELECT `ID` FROM wp_users WHERE `display_name` = '" . $display_name . "'");
    if ( $user ) {
		return get_user_by( 'id', $user->ID );
	} else {
		return false;
	}
}
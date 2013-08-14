<?php
/*
 * Plugin Name: WP Authorities
 * Plugin URI: http://onewebsite.ca/
 * Description: A Plugin that lists a thousands of authority websites built in wordpress.
 * Version: 0.1
 * Author: OWS
 * Author URI: http://onewebsite.ca/
 */

define( 'PLUGINURL', plugin_dir_url( __FILE__ ) );
define( 'PLUGINPATH', plugin_dir_path( __FILE__ ) );

load_template( trailingslashit( PLUGINPATH ) . 'classes/posts.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/base.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/cron.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/scrapewp.class.php' );
load_template( trailingslashit( PLUGINPATH ) . 'classes/topSites.class.php' );

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
}

function awp_deactivate(){
	delete_option('awp_options');
	delete_option('awp_websites');
	delete_option('awp_requests');
	delete_option('awp_settings');
	
	// On deactivation, remove all functions from the scheduled action hook.
	wp_clear_scheduled_hook( 'wp_authority_update' );
}

add_action( 'admin_init', 'awp_options_handle' );

function awp_options_handle(){
	$requests = get_option('awp_requests');
	$settings = get_option('awp_settings');
	$websites = get_option('awp_websites');
	
	if(isset($_POST)){
		
		foreach($_POST as $key=>$val){
			$$key = $val;
		}
		
		// Make Manual API Request
		if(isset($_POST['awp_request']) && '' != $_POST['awp_request']){
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
								'check' => false
							);
							$j++;
							$i++;
						}
						
						$return = true;
					} else {
						$return = false;
						$msg = 2;
					}
				}
				
				// Keep record of the manual request and website links
				update_option('awp_websites', $websites);
				update_option('awp_requests', $requests);
			}
			
			// Redirect to manual request page
			if( $return ){
				header('Location:'.admin_url('admin.php?page=wpauthority&tab=upload&settings-updated=true')); exit;
			} else {
				header('Location:'.admin_url('admin.php?page=wpauthority&tab=upload&settings-updated=false&message='.$msg)); exit;
			}
		} // End of Manual API Request
		
		// Manual upload
		if(isset($_POST['awp_upload']) && '' != $_POST['awp_upload']){
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
							
							$limit = ($request_limit) ? $request_limit : 1000000;
							// pre-saved each site into an array
							while ( ($data = fgetcsv($handle, 1000, ",")) !== FALSE && $i <= $limit ) {
								if($row == $i){
									$websites[$data[1]] = array(
										'name' => $data[1],
										'rank' => $data[0],
										'check' => false
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
				
				// Keep record of the manual upload and website links
				update_option('awp_websites', $websites);
				update_option('awp_requests', $requests);
			} else {
				$msg = 5;
			}
			
			// Redirect to manual request page
			if( $return ){
				header('Location:'.admin_url('admin.php?page=wpauthority&tab=upload&settings-updated=true')); exit;
			} else {
				header('Location:'.admin_url('admin.php?page=wpauthority&tab=upload&settings-updated=false&message='.$msg)); exit;
			}
		} // End of Manual upload
		
		// Update Settings
		if(isset($_POST['awp_submit']) && '' != $_POST['awp_submit']){
			
			// API Settings
			$settings['access_id'] = $awp_settings['access_id'];
			$settings['access_secret'] = $awp_settings['access_secret'];
			$settings['StartNum'] = $awp_settings['StartNum'];
			$settings['cronLimit'] = $awp_settings['cronLimit'];
			
			// Cron Settings
			$settings['cronjob'] = $awp_settings['cronjob'];
			$settings['rank_page'] = $awp_settings['rank_page'];
			$settings['request_limit'] = $awp_settings['request_limit'];
			$settings['scrape_link'] = $awp_settings['scrape_link'];
			$settings['scrape_limit'] = $awp_settings['scrape_limit'];
			
			$return = update_option('awp_settings', $settings);
			
			// Redirect to manual request page
			if( $return ){
				header('Location:'.admin_url('admin.php?page=wpauthority&settings-updated=true')); exit;
			} else {
				header('Location:'.admin_url('admin.php?page=wpauthority&settings-updated=false')); exit;
			}
		} // End of update
	}
	
	return;
}

function awp_register_pages(){
	$ofpage = add_menu_page(
		__('WP Authorities'),
		__('WP Authorities'),
		'manage_options',
		'wpauthority',
		'awp_admin_pages', PLUGINURL . 'images/favicon.ico'
	);
	
	add_submenu_page( 'wpauthority', __('WP Sites'), __('WP Sites'), 'manage_options', 'edit.php?post_type=site');
	
	// add_action( "load-$ofpage", 'base_screen_options' ); Custom table screen options
}

function awp_admin_pages(){
	global $options;
	$options = get_option('awp_options');
	$settings = get_option('awp_settings');
	$websites = get_option('awp_websites');
	
	$tab = $_REQUEST['tab'] ? $_REQUEST['tab'] : '';
	
	?><div class="wrap"><?php
		switch($tab){
			case 'upload':
				?><div id="icon-ows" class="icon32"><img src="<?php echo PLUGINURL; ?>images/icon32.jpg" alt="WP Authorities" /></div>
                <h2><?php _e('WP Authorities'); ?></h2><?php
				
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
				
				?><form name="awp_settings" method="post" action="<?php admin_url('admin.php?page=wpauthority'); ?>" enctype="multipart/form-data">
                	<h3>API Request</h3>
                    <table class="form-table">
                        <tr>
                        	<th scope="row"><label for="subject">Subject name:</label>
                            <td>
                            	<input type="text" name="subject" id="subject" value="" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="rank_start">Start on Rank</label></th>
                            <td>
                            	<input type="text" name="rank_start" id="rank_start" value="" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row"><label for="request_limit">Number of Request</label></th>
                            <td>
                            	<input type="text" name="request_limit" id="request_limit" value="" class="regular-text" />
                            </td>
                        </tr>
                    </table>
                    
                    <p><input type="submit" value="Make Request" class="button-primary" id="submit" name="awp_request" /></p>
                    
                    <h3>Import a CSV</h3>
					<table class="form-table">
                    	<tr>
                        	<th scope="row"><label for="awp_file">Upload CSV</label></th>
                            <td>
                            	<input type="file" name="awp_file" id="awp_file" value="" class="regular-text" />
                                <input type="submit" value="Upload" class="button-primary" id="submit" name="awp_upload" />
                            </td>
                        </tr>
                    </table>
				</form><?php
				break;
			
			default:
				?><div id="icon-ows" class="icon32"><img src="<?php echo PLUGINURL; ?>images/icon32.jpg" alt="WP Authorities" /></div>
				<h2><?php
					_e('WP Authorities');
					?><a href="<?php echo admin_url('admin.php?page=wpauthority&tab=upload'); ?>" class="add-new-h2">Manual Request</a>
				</h2><?php
                
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
				
				?><form name="awp_settings" method="post" action="<?php admin_url('options-general.php?page=wpauthority'); ?>">
                	<h3>API Settings</h3>
                    
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
                            	<input type="text" name="awp_settins[cronLimit]" id="cronLimit" value="<?php echo $settings['cronLimit'] ?>" class="regular-text" />
                            </td>
                        </tr>
                    </table>
                    
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
                            	<input type="text" name="awp_settins[request_limit]" id="request_limit" value="<?php echo $settings['request_limit'] ?>" class="regular-text" />
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
                    
                    <input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" />
				</form><?php
				
				/*$data = array();
				$base = new Base_Table();
				$base->set_data( {items} );
				$base->prepare_items();
				$base->search_box('search', 'search_cpt');
				$base->display();*/
				
				break;
		}
	?></div><?php
}

function base_screen_options(){
	$tab = $_REQUEST['tab'] ? $_REQUEST['tab'] : '';
	if(!'upload' == $tab){
		$tab = ($_REQUEST['tab']) ? $_REQUEST['tab'] : 'post-types';
		$option = 'per_page';
		$args = array(
			'label' => 'Websites per page',
			'default' => 10,
			'option' => 'sites_per_page'
		);
		add_screen_option( $option, $args );
		
		$base = new Base_Table();
	}
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
<?php
!defined( 'ABSPATH' ) ? exit : '';

class Base_Cron{
	
	var $file_path;
	var $cron_type;
	var $wp_sites;
	
	function __construct(){
		add_action( 'wp_authority_update', array($this, 'wp_authority_update_list') );
		
		if( !wp_next_scheduled( 'wp_authority_update' ) ) {
			wp_schedule_event( time(), 'daily', 'wp_authority_update' );
		}
		
		/*wp_schedule_event( time(), 'daily', 'wp_authority_update' );*/
	}
	
	function wp_authority_update_list(){
		global $wpdb;
		$option = get_option('awp_options');
		$settings = get_option('awp_settings');
		// $websites = get_option('awp_websites');
		
		// Make sure that starting line is lower than end line
		if($option['StartNum'] <= $option['cronLimit']) {
			
			/* We're on a beta and testing a cron job to check the site from a csv file
			if (($handle = fopen( PLUGINPATH . "uploads/cron.csv", "r")) !== FALSE) {
				
				$row = $option['StartNum'];
				$webs = array();
				$i = 1;
				
				while ( ($data = fgetcsv($handle, 1000, ",")) !== FALSE && $i <= $option['cronLimit'] ) {
					if($row == $i){
						$webs[$data[0]] = $data[1];
						$row++;
					}
					$i++;
				}
				
				$option['StartNum'] = $row;
				$option['cronLimit'] = $row+20;
				
				update_option('awp_options', $option);
				
				fclose($handle);
			}*/
			
			// Check all the sites from the websites links record
			$limit = ($settings['request_limit']) ? $settings['request_limit'] : 100;
			$webs = array();
			$i = 1;
			foreach($websites as $wb){
				if($i <= $limit){
					if($wb['check'] == false){
						$webs[$wb['rank']] = $wb['name'];
						$i++;
					}
				}
			}
			
			$this->wp_sites = $webs;
			if(!empty( $webs )){
				$this->scrapeSites();
			}
			
			foreach($websites as $site){
				if( !get_page_by_title($site['name'], OBJECT, 'site') ){
					$pID = wp_insert_post(
						array(
							'post_type' => 'site',
							'post_date' => $site['date'],
							'post_title' => $site['name'],
							'post_status' => 'publish'
						)
					);
					
					if( isset($site['taxonomies']) ){
						foreach( $site['taxonomies'] as $tax=>$terms ){
							wp_set_object_terms( $pID, $terms, $tax, true );
						}
					}
				}
			}
			
			/* Update all scanned websites
			foreach( $webs as $rank=>$name ){
				$websites[$name] = array(
					'name' => $name,
					'rank' => $rank,
					'check' => true,
					'date' => date('c')
				);
			} */
			
			// update_option('awp_websites', $websites);
		}
	}
	
	function scrapeSites(){
		$wp_sites = $this->wp_sites; // get_option('awp_wp_sites');
		
		if( !empty($wp_sites) and is_array($wp_sites) ){
			if( class_exists('scrapeWordpress') ) {
				$wp = new scrapeWordpress();
				$wp->scrape( $wp_sites );
			}
		}
	}
}

$cron = new Base_Cron();
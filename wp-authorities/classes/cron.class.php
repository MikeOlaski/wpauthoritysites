<?php

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
		
		// Make sure that starting line is lower than end line
		if($option['StartNum'] <= $option['cronLimit']) {
			
			// We're on a beta and testing a cron job to check the site from a csv file
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
			}
		}
		
		$this->wp_sites = $webs;
		$this->scrapeSites();
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
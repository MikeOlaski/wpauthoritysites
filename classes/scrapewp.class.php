<?php
!defined( 'ABSPATH' ) ? exit : '';

/**
 * Use to scrape multiple site to determine if the is using wordpress.
 * This class will check the html data of a site for wp-includes, wp-content, or wp-admin.
 */

class scrapeWordpress {
	/**
	 * Just a default regex
	 */	
	var $def_regex = '(wp-content|wp-includes|wp-admin)';
	
	/**
	 * Initialized scraping
	 *
	 * Authenticates $site if array or single string
	 * You can specify $regex and it replaces the default regex
	 * Empty $site returns empty
	 *
	 * @param array|string $site
	 * @uses do_matching()
	 * @since 1.1.0
	 * @return Arrays of results
	 */	
	function scrape( $site, $regex = '' ) {
		$args = array();
		
		if(empty( $regex ))
			$regex = $this->def_regex;
			
		if(empty( $site ))
			return;
		elseif( !is_array($site) )
			$args[] = $site;
		else
			$args = $site;
		
		$this->do_matching( $args , $regex );
	}
	
	/**
	 * Does a prematch and returns results
	 *
	 * @para string $regex
	 * @param array $sites
	 * @since 1.1.2
	 * @return bool
	 */
	
	function do_matching( $sites = array(), $regex ) {
		error_reporting(E_ERROR | E_PARSE); // Prevent warnings		
		// $wp_sites = get_option('awp_wp_sites'); Deprecated
		// sites are recorded using custom posts type
		
		$j = 0;
		$links = array();
		foreach($sites as $rating=>$site) {
			set_time_limit(500); //  Increased the timeout
			$data = file_get_contents('http://' . $site);
			
			preg_match($regex,$data,$match);
				if( !empty($match) ) {
					$links[] = array('name' => $site, 'rating' => $rating);
				} else {
					// Do something for those websites that
					// are not a WordPress
				}
			$j++;
		}
		
		if( $links && !empty($links) ){
			
			foreach($links as $po){
				// Create post object
				
				$slugs = explode('.', $po['name']); // Exclude TLD for post name eg. /mashable.com/ -> /mashable/
				// We have to check the slug to include subdomains eg. /play.google.com/ -> /play-google/
				$slugCount = count($slugs);
				$slug = '';
				$i = 1;
				foreach($slugs as $sg){
					if($i < $slugCount){
						if( $i == 1){
							$slug .= $sg;
						} else {
							$slug .= '-'.$sg;
						}
					}
					$i++;
				}
				
				$cpost = array(
					'post_title' => $po['name'],
					'post_name' => $slug,
					'post_type' => 'site',
					'post_status' => 'publish'
				);
				
				// Search for existing record
				$pID = get_post_by_title( $po['name'], 'site' );
				
				// Record the site into a custom post type
				if($pID and NULL != $pID){
					// Make sure to avoid redandunt record
					// Update existing record if there is
					$cpost['ID'] = $pID;
					$post_id = wp_update_post( $cpost );
				} else {
					// Record a the site doesn't exist
					$post_id = wp_insert_post( $cpost );
				}
				
				// Add or update all custom meta values
				if($post_id){
					update_post_meta( $post_id, 'rating', $po['rating'] );
					update_post_meta( $post_id, 'awp-alexa-rank', $po['rating'] );
					update_post_meta( $post_id, 'awp-name', $slug );
					update_post_meta( $post_id, 'awp-domain', $slugs[$slugCount - 1] );
					update_post_meta( $post_id, 'awp-url', 'http://'.$po['name'] );
				}
			}
		}
		
		// update_option('awp_wp_sites', $wp_sites);
		
		return $j;
	}
}
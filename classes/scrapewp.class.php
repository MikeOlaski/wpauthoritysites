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
	var $not_wp_sites;
	var $wp_sites;
	
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
		
		$j = 0;
		
		$wp_sites = array();
		$not_wp_sites = array();
		foreach($sites as $pID=>$site) {
			// Increased the timeout
			set_time_limit(500);
			
			$data = file_get_contents('http://' . $site);
			
			preg_match($regex, $data, $match);
				if( !empty($match) ) {
					$wp_sites[] = array(
						'ID' => $pID,
						'name' => $site
					);
				} else {
					// Let's make sure that those sites that are not wordpres
					// should also be updated so that we know that they are
					// already scanned
					$not_wp_sites[] = array(
						'ID' => $pID,
						'name' => $site
					);
				}
			$j++;
		}
		
		// Record site that are wp
		if( $wp_sites && !empty($wp_sites) ){
			$this->wp_sites = $wp_sites;
		} else {
			$this->wp_sites = null;
		}
		
		// Record site that are not wp
		if( $not_wp_sites && !empty($not_wp_sites) ){
			$this->not_wp_sites = $not_wp_sites;
		} else {
			$this->not_wp_sites = null;
		}
			
		/*foreach($links as $po){
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
				'post_name' => $po['name'], // $slug, Return the slug to -com format
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
				update_post_meta( $post_id, 'awp-name', $po['name'] );
				update_post_meta( $post_id, 'awp-domain', $slug );
				update_post_meta( $post_id, 'awp-tld', '.' . $slugs[$slugCount - 1] );
				update_post_meta( $post_id, 'awp-url', 'http://'.$po['name'] );
				
				if( isset($po['taxonomies']) && $po['taxonomies'] != '' ){
					foreach( $po['taxonomies'] as $taxonomy=>$terms){
						wp_set_object_terms( $post_id, $terms, $taxonomy, true );
					}
				}
				
				wp_set_object_terms( $post_id, '$Wordpress', 'site-type', true );
			}
		}*/
		
		return $j;
	}
}
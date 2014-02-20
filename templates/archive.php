<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

global $wpa_settings;
$wpa_settings = get_option('awp_settings');

global $wp_query;
wp_reset_query();

global $paged; $paged = 1; // Fix for the WordPress 3.0 "paged" bug.
if ( get_query_var( 'paged' ) && ( get_query_var( 'paged' ) != '' ) ) { $paged = get_query_var( 'paged' ); }
if ( get_query_var( 'page' ) && ( get_query_var( 'page' ) != '' ) ) { $paged = get_query_var( 'page' ); }

$wp_query->set("paged", $paged);

$archivePage = get_post_type_archive_link('site') . '?';

if(isset($wp_query->query['orderby'])){
	$orderby = $wp_query->query['orderby'];
} else {
	if($wpa_settings['sites_default_orderby'] != 'title'){
		$orderby = 'meta_value_num';
		$wp_query->set("meta_key", $wpa_settings['sites_default_orderby']);
	} else {
		$orderby = $wpa_settings['sites_default_orderby'];
	}
}
$wp_query->set("orderby", $orderby);

if( isset($_REQUEST['order']) ){
	$order = $_REQUEST['order'];
} elseif( isset($wp_query->query['order']) ){
	$order = $wp_query->query['order'];
} else {
	$order = $wpa_settings['sites_default_order'];
}
$wp_query->set("order", $order);

$number = 10;
if(isset($_REQUEST['posts_per_page'])){
	$number = $_REQUEST['posts_per_page'];
	$archivePage = $archivePage . 'posts_per_page=' . $number . '&';
	$wp_query->set("posts_per_page", $number);
}

if(isset($_REQUEST['meta_key'])){
	$meta = $_REQUEST['meta_key'];
	$wp_query->set("meta_key", $meta);
}

$wp_query->set("tax_query", apply_filters('wpa_archive_wp_query', $wp_query ) );
$wp_query->get_posts( $wp_query );

//wp_die( '<pre>' . print_r($wp_query, true) . '</pre>' );

$columns = array();
$columns['awp-action'] = array();
$taxonomies = get_object_taxonomies('site', 'objects');
foreach($taxonomies as $tax){
	$columns['awp-action'][] = array(
		'name' => $tax->label,
		'header' => 'wpa-th-'.$tax->name,
		'body' => 'wpa-td-'.$tax->name,
		'taxonomy' => $tax->name
	);
}

$fields = wpa_default_metrics();
$departmentColumns = array();
$metricsColumns = array();
foreach( $fields as $field ){
	if( $field['type'] == 'heading' ) {
		if($field['category'] == 'departments'){
			$departmentColumns[$field['id']] = array();
		} else {
			$metricsColumns[$field['id']] = array();
		}
	} elseif( $field['type'] == 'separator' ) {
		// continue;
	} else {
		if($fields[$field['group']]['category'] == 'departments'){
			$departmentColumns[$field['group']][] = array(
				'name' => $field['name'],
				'header' => 'wpa-th-' . $field['id'],
				'body' => 'wpa-td-' . $field['id'],
				'meta_key' => $field['id'],
				'sortable' => $field['sortable'],
				'format' => ($field['format']) ? $field['format'] : '',
				'link_text' => ($field['link_text']) ? $field['link_text'] : false,
				'meta_value' => ($field['meta_value']) ? $field['meta_value'] : false
			);
		} else {
			$metricsColumns[$field['group']][] = array(
				'name' => $field['name'],
				'header' => 'wpa-th-' . $field['id'],
				'body' => 'wpa-td-' . $field['id'],
				'meta_key' => $field['id'],
				'sortable' => $field['sortable'],
				'format' => ($field['format']) ? $field['format'] : '',
				'link_text' => ($field['link_text']) ? $field['link_text'] : false,
				'meta_value' => ($field['meta_value']) ? $field['meta_value'] : false
			);
		}
	}
}

get_header();

?><section id="primary"><?php

	/*<div id="secondary" class="widget-area" role="complementary">
    </div>*/
    
    ?><div id="content" role="main">
    	<div class="wpaSearchForm">
            <form name="s" action="<?php echo home_url(); ?>" method="get">
                <p>
                <select name="taxonomy" id="wpa-taxonomy">
                    <option value="0">Search Fields</option><?php
                    $taxes = get_taxonomies( array('object_type' => array('site')), 'objects' );
                    foreach($taxes as $tax){
                        ?><option value="<?php echo $tax->name; ?>"><?php echo $tax->label; ?></option><?php
                    }
                ?></select>
                
                <select name="term" id="wpa-term" disabled="disabled">
                    <option value="0">Select Type</option><?php
                    $terms = get_terms('site-type', array('hide_empty' => 0));
                    foreach($terms as $tm){
                        ?><option value="<?php echo $tm->slug; ?>"><?php echo $tm->name; ?></option><?php
                    }
                ?></select>
                
                <input type="text" name="s" id="search_field" value="<?php echo get_search_query(); ?>" />
                <input type="hidden" name="post_type" value="site" />
                <input type="submit" name="search" value="Search" /></p>
            </form>
            
            <ul class="filterButtons">
            	<li><a id="addFilterButton" href="javascript:void(0);" data-title="Add new conditional filter row">Add new Conditional Filter</a></li>
                <li>
                	<a id="filterGroups" class="wpa-filterg-btn" href="javascript:void(0);" data-title="Extra Buttons">Extra Buttons</a>
                    <div class="wpa-filter-groups hide">
                    	<span class="displayOptionshead"><?php _e('DISPLAY OPTIONS'); ?></span>
                        <p>
                        	Show 
                        	<label class="star-1 wpa-rating"><input type="checkbox" name="" id="" value="1" />1</label>
                            <label class="star-2 wpa-rating"><input type="checkbox" name="" id="" value="2" />2</label>
                            <label class="star-3 wpa-rating"><input type="checkbox" name="" id="" value="3" />3</label>
                            <label class="star-4 wpa-rating"><input type="checkbox" name="" id="" value="4" />4</label>
                            <label class="star-5 wpa-rating"><input type="checkbox" name="" id="" value="5" />5</label>
                        	rated sites
                        </p>
                        <ul class="filterGroup">
                        	<li><label> <input type="checkbox" name="" id="" value="" /> Categories</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Tags</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Actions</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Status</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Include</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Topic</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Type</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Location</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Assignment</label></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
		
		<ul class="wpa-display-controls">
            <li class="wpa-number-control"><span>Show <select name="posts_per_page" id="posts_per_page"><?php
                for($i=1; $i<=10; $i++){
                    $count = $i * 10;
                    $thisPage = $archivePage;
                    if(isset($_REQUEST['posts_per_page']))
                        $thisPage = get_post_type_archive_link('site') . '?';
                    
                    $URLquery = $thisPage . 'posts_per_page=' .$count . '&';
                    ?><option value="<?php echo $URLquery; ?>" <?php selected($number, $count); ?>><?php echo $count; ?></option><?
                }
            ?></select> Per page</span></li>
            <li><a href="#grid" class="wpa-control grid current" data-title="Show grid view">Grid</a></li>
            <li><a href="#detail" class="wpa-control detail" data-title="Show detail view">Detail</a></li>
            <li><a href="#list" class="wpa-control list" data-title="Show list view">List</a></li>
            <?php /*<li><a href="#line" class="wpa-control line" title="Line List View">Line List</a></li>*/ ?>
            <li>&nbsp;</li>
            <li class="openSearch">
            	<a href="javascript:void(0);" class="wpa-control search" title="Screen Options">Open Search</a><?php
				wpas_site_display_options();
            ?></li>
            <li class="openExport">
            	<a href="javscript:void(0);" class="wpa-control export" title="Export Options">Export</a>
                <div class="wpa-export-options hide">
                	<span class="displayOptionshead"><?php _e('DISPLAY OPTIONS'); ?></span>
                	<ul class="export">
                    	<li><a href="#">Save to CSV</a></li>
                        <li><a href="#">Save to PDF</a></li><?php
							$max_num_pages = $wp_query->max_num_pages;
							if($max_num_pages > 10){
								?><li>Pagination: <?php
									$pagination = 10;
									while($pagination < $max_num_pages){
										$pagination += 25;
										?><a href="<?php echo get_pagenum_link($pagination); ?>"><?php echo $pagination; ?></a><?php
									}
								?></li><?php
							}
                    ?></ul>
                </div>
            </li>
        </ul>
		
		<div class="clear"></div>
		
		<div class="wpa-group-column alignleft hide"><?php
            wpas_archive_view_groups();
        ?></div><?php
		
		$replaceOrder = ($order == 'asc') ? 'desc' : 'asc';
		$sorts = array(
			'Title' => array(
				'orderby' => 'title',
				'order' => $replaceOrder
			),
			'Alexa Rank' => array(
				'meta_key' => 'awp-alexa-rank',
				'orderby' => 'meta_value_num',
				'order' => $replaceOrder
			),
			'Authority Rank' => array(
				'meta_key' => 'awp-authority-rank',
				'orderby' => 'meta_value_num',
				'order' => $replaceOrder
			)
		);
		
		/* Sort Header */
		?><div class="wpa-sort-wrapper alignright">
			<p><?php _e('Sort by:', 'wpas');
				$i = 1;
				foreach($sorts as $label=>$sort){
					$current = (isset($_REQUEST['meta_key']) and $_REQUEST['meta_key'] == $sort['meta_key']) ? true : ((isset($_REQUEST['orderby']) and $_REQUEST['orderby'] == $sort['orderby']) ? true : false);
					
					echo sprintf(
						'<a href="%s" class="wpa-sortable %s" >%s</a>',
						add_query_arg($sort, $archivePage),
						($current) ? $order.' current' : $order,
						$label
					);
					if($i < count($sorts)){ echo '|'; }
					$i++;
				}
			?></p>
		</div>
		
		<div class="clear"></div>
		
		<form class="wpa-filter-form hide" name="filter" action="<?php echo site_url('sites'); ?>" method="post">
			<span class="displayOptionshead"><?php _e('New Filter'); ?></span>
            <fieldset>
            	<select name="filter[action][]" id="wpa-action">
                    <option value="include">Include</option>
                    <option value="exclude">Exclude</option>
				</select>
                
                <select name="filter[term][]" id="wpa-filter-term">
                    <option value="0">Keyword</option>
                </select>
                
                <input type="text" name="filter[s][]" id="wpa-filter-search" value="" />
            </fieldset>
            
            <input type="submit" class="wpa-submit-button" id="wpa-filter-button" name="search" value="Search" />
            
            <div class="clear"></div>
		</form><?php
		
		if ( $wp_query->have_posts() ) :
		
			?><header class="page-header">
                <h1 class="page-title"><?php
					$title = apply_filters('wpa_archive_page_title', 'WordPress Authority Site Directory');
					echo $title;
				?></h1>
            </header><?php
            
            $content_before = apply_filters('wpa_archive_content_before', '');
			echo $content_before;
			
            ?><div class="wpa-display-archives grid">
                <!-- Line List View -->
                <div class="wpa-line-header">
                    <div class="wpa-th wpa-th-thumbnail">Thumbnail</div>
                    <div class="wpa-th wpa-th-description">Description</div>
                    
                    <div class="clear"></div>
                </div>
                
                <!-- Start of list HR wrapper -->
                <div class="wpa-site-wrapper">
				
                <div class="wpa-list-header"><?php
					
					wpas_archive_list_header( $archivePage );
					
                	?><div class="clear"></div>
				</div><!-- /.wpa-site-wrapper -->
				
				<div class="wpas-site-loop"><?php /* Start the Loop */
				
				$i = 1;
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
				
					$post_id = get_the_ID();
					$metrics = get_post_meta( $post_id );
					
					$class = 'wpas';
					$class .= (is_sticky()) ? ' sticky-site' : '';
					$class .= (current_user_can('edit_post')) ? ' edit-enabled' : '';
					
					$default_img = PLUGINURL . 'timthumb.php?a=tl&w=290&h=250&src=' . $wpa_settings['default_site_image'];
					$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) );
					$attachmentURL = ($attachment) ? PLUGINURL.'/timthumb.php?src='.$attachment[0].'&w=290&h=250' : null;
					$thumbnail = sprintf(
						'<img src="%s" alt="%s" />',
						($attachmentURL) ? $attachmentURL : $default_img, get_the_title()
					);
					
					?><article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
						
                        <!-- List View -->
						<div class="wp-list-item"><?php
                        	wpas_archive_list_content(true, $post_id);
                            ?><div class="clear"></div>
						</div>
						
                        <!-- Grid View -->
						<div class="wpa-grid-item">
							<header class="entry-header">
								<div class="thumbnail alignleft">
									<a href="<?php the_permalink(); ?>"><?php
										echo $thumbnail;
									?></a>
                                </div>
                                
                                <h4 class="entry-title"><a href="javascript:void(0);" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'awp' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                                
                                <a class="external-link" href="<?php echo $metrics['awp-url'][0]; ?>" title="<?php the_title(); ?>" target="_blank"><img src="<?php echo PLUGINURL; ?>/images/link-icon.png" alt="<?php the_title(); ?>" /></a></h4>
                            </header><!-- .entry-header -->
							
							<div class="entry-summary"><?php
								wpas_get_authority_level(true, $post_id);
								wpas_get_authorit_ranks(true, $post_id);
								wpas_site_coveraged_feed(true, $post_id);
								echo wpas_site_network_feed(true, $post_id, 1);
								?><div class="clear"></div><?php
								wpas_site_metrics_grade(true, $post_id);
								
								wpas_get_watch_popup(true, $post_id);
								
								edit_post_link('Edit');
                            ?></div><!-- .entry-summary -->
                            
                            <div class="clear"></div>
						</div><!-- /Grid View -->
						
                        <!-- Detail View -->
						<div class="wpa-detail-item">
                        	<a href="javascript:void(0);" class="wpas-detail-more"><?php _e('See more', 'wpas'); ?></a>
                        	<div class="wpas-detail-view-col">
                            	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php
									echo $thumbnail;
								?></a><?php
                                wpas_get_authority_level(true, get_the_ID());
                                
								wpas_get_watch_popup(true, $post_id);
								
								edit_post_link('Edit'); ?>
                            </div>
                            
                            <div class="wpas-detail-view-col">
                            	<h4 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpas' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                                
                                <a class="external-link" href="<?php echo $metrics['awp-url'][0]; ?>" title="<?php the_title(); ?>" target="_blank"><img src="<?php echo PLUGINURL; ?>/images/link-icon.png" alt="<?php the_title(); ?>" /></a></h4>
                                
                                <div class="entry-summary"><?php
                                	the_excerpt();
                                ?></div>
                            </div>
                            
                            <div class="wpas-detail-view-col">
                            	<h4><?php _e('Ranks', 'wpas'); ?></h4><?php
								wpas_get_authorit_ranks(true, get_the_ID());
                            ?></div>
                            
                            <div class="wpas-detail-view-col">
                            	<h4><?php _e('Grades', 'wpas'); ?></h4><?php
								wpas_site_metrics_grade(true, get_the_ID());
                            ?></div>
                            
                            <div class="wpas-detail-view-col">
                            	<h4><?php the_title(); ?> <?php _e('Coveraged', 'wpas'); ?></h4><?php
								wpas_site_coveraged_feed(true, get_the_ID());
                            	?><h4><?php _e('Recent Popular Posts', 'wpas'); ?></h4><?php
								echo wpas_site_network_feed(true, get_the_ID(), 1);
                            ?></div>
                            
                            <div class="clear"></div>
						</div><!-- /Detail View --><?php
						
						$i++;
					?></article><?php
				endwhile;
				
				?><div class="clear"></div>
                
                </div><!-- /.wpas-site-loop -->
                </div><!-- /.wpa-site-wrapper -->
                
			</div><?php
			
			$content_after = apply_filters('wpa_archive_content_after', '');
			echo $content_after;
			
			if(function_exists('wp_pagenavi')) {
				wp_pagenavi();
			} else {
				echo wpa_paginate();
			}
			
		else :
			?><article id="post-0" class="post no-results not-found">
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'awp' ); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'awp' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-0 --><?php
        
		endif;
		
	?></div><!-- #content -->
    
    <div class="clear"></div>
</section><!-- #primary -->
    
<div class="clear"></div>

<?php get_footer(); ?>
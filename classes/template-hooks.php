<?php

function wpa_content_before(){
	do_action('wpa_content_before');
}

function wpa_main_before(){
	do_action('wpa_main_before');
}

function wpa_loop_before(){
	do_action('wpa_loop_before');
}

function wpa_post_before(){
	do_action('wpa_post_before');
}

function wpa_post_inside_before(){
	do_action('wpa_post_inside_before');
}

function wpa_before_title(){
	do_action('wpa_before_title');
}

function wpa_after_title(){
	do_action('wpa_after_title');
}

function wpa_post_meta(){
	do_action('wpa_post_meta');
}

function wpa_post_inside_after(){
	do_action('wpa_post_inside_after');
}

function wpa_post_after(){
	do_action('wpa_post_after');
}

function wpa_loop_after(){
	do_action('wpa_loop_after');
}

function wpa_main_after(){
	do_action('wpa_main_after');
}

function wpa_content_after(){
	do_action('wpa_content_after');
}

// Canvas theme Fix for version 5.2.7 and later
add_filter( 'body_class','wpa_layout_body_class', 50 );	
function wpa_layout_body_class( $classes ){
	$settings = get_option('awp_settings');
	global $post, $woo_options;
	
	if( is_single() && $post->post_type == 'site' ){
		if( '' == get_post_meta( $post->ID, 'layout', true ) ){
			$layout = 'one-col';
			
			unset( $classes[array_search('one-col',$classes)] );
			unset( $classes[array_search('two-col-left',$classes)] );
			unset( $classes[array_search('two-col-right',$classes)] );
			unset( $classes[array_search('three-col-left',$classes)] );
			unset( $classes[array_search('three-col-right',$classes)] );
			unset( $classes[array_search('three-col-middle',$classes)] );
			
			unset( $classes[array_search('one-col' . '-' . $width,$classes)] );
			unset( $classes[array_search('two-col-left' . '-' . $width,$classes)] );
			unset( $classes[array_search('two-col-right' . '-' . $width,$classes)] );
			unset( $classes[array_search('three-col-left' . '-' . $width,$classes)] );
			unset( $classes[array_search('three-col-right' . '-' . $width,$classes)] );
			unset( $classes[array_search('three-col-middle' . '-' . $width,$classes)] );
			
			// Specify site width
			$width = intval( str_replace( 'px', '', get_option( 'woo_layout_width', '960' ) ) );
			
			$classes[] = $layout;
			$classes[] = $layout . '-' . $width;
		}
	}
	
	if( is_page() && $post->ID == $settings['bb_builder_page'] ){
		$classes[] = 'bb_builder_page';
	}
	
	return $classes;
}

// Canvas theme Fix for version 5.2.7 and later
add_filter( 'post_class', 'wpa_survey_post_class', 50 );
function wpa_survey_post_class( $classes ){
	$settings = get_option('awp_settings');
	global $post;
	
	if( is_page() && $post->ID == $settings['bb_builder_page'] ){
		unset($classes[ array_search('post', $classes) ]);
	}
	
	return $classes;
}

// Get featured and custom site images
function wpa_get_image(){
	global $post;
	
	if( is_singular() ){
		?><div class="wpa-sgl-image image-300x240"><?php
			$post_image = get_post_meta($post->ID, 'awp-thumbnail', true);
			if(!$post_image == ''){
				?><img src="<?php echo $post_image; ?>" alt="<?php get_the_title($post->ID); ?>" /><?php
			} else {
				the_post_thumbnail('full');
			}
		?></div><?php
	}
}

// Get Site Post Meta
add_action('wpa_post_meta', 'wpa_post_meta_filter');
function wpa_post_meta_filter(){
	global $post;
	
	if( is_single() && 'site' == $post->post_type ){
		$tags_list = get_terms(
			array(
				'site-category',
				'site-topic'
			),
			array(
				'orderby' 		=> 'count',
				'hide_empty'	=> 0
			)
		);
		
		if(sizeof($tags_list)!=0){
			foreach($tags_list as $tag) if($tag->count > $max_count) $max_count = $tag->count;
			
			?><div id="myCanvasContainer">
				<canvas width="<?php echo $canvas_width;?>" height="<?php echo $canvas_height;?>" id="myCanvas" >
					<p>Anything in here will be replaced on browsers that support the canvas element</p>
				</canvas>
			</div>
			<div id="tags" style="display:none;">
				<ul><?php
					$i=1;
					foreach($tags_list as $tag){
						echo '<li><a href="'.site_url('?site-tag='.$tag->slug).'">'.$tag->name.'</a></li>';
						$i++;
					}
				?></ul>
			</div>
			<script type="text/javascript" src="<?php echo PLUGINURL; ?>js/jquery.tagcanvas.min.js"></script>
			<script type="text/javascript">
				$j = jQuery.noConflict();
				$j(document).ready(function() {
					if(!$j('#myCanvas').tagcanvas({
						textFont: 'Impact, "Arial", sans-serif',
						outlineColour: '#D04121',
						outlineMethod: 'block',
						textColour: '#0E1E38',
						weight: true,
						wheelZoom: false,
						depth: 0.99
					},'tags')) {
						$j('#myCanvasContainer').hide();
					}
				}); 
			</script><?php
		} else {
			_e('No Tags Found', 'wpa');
		}
		
		?><div class="fix"></div><?php
	}
}

// Rating
add_action('wpa_after_title', 'wpa_site_rank');
function wpa_site_rank(){
	global $post;
	
	if( is_single() && 'site' == $post->post_type ){
		$authority_level = get_post_meta($post->ID, 'awp-authority-level', true);
		if( $authority_level > 5 ){ $authority_level = 5; }
		
		?><div class="wpa-sgl-ranks"><?php
        	
			wpas_get_authority_level();
			
			?><div class="wpa-sgl-topranks"><?php
				wpas_get_authorit_ranks();
			?></div>
		</div>
		
		<div class="fix"></div><?php
	}
}

add_filter('excerpt_more', 'wpa_excerpt_more');
function wpa_excerpt_more( $more ) {
	global $post;
	
	if( is_single() && 'site' == $post->post_type ){
		return '<p><a class="wpa-read-more cboxElement" rel="inline" href="#inlineSummaryContent">Read more</a></p>';
	}
	
	return $more;
}

add_action('wpa_post_inside_after', 'wpa_site_footer');
function wpa_site_footer(){
	global $post;
	
	if( is_single() && 'site' == $post->post_type ){
		?><div class="wpa-sgl-site">
			<div class="wpa-sgl-teams">
				<h3><?php _e('Team', 'wpa'); ?></h3><?php
				
				$teams = array();
				if( $include_list = get_the_terms( $post->ID, 'site-include' ) ) {
					foreach($include_list as $inc){
						$tagName = str_replace('@', '', $inc->name);
						$people = get_page_by_title($tagName, 'OBJECT', 'people');
						if( $people ){
							if( $tag_list = get_the_terms( $people, 'people-include' ) ){
								foreach($tag_list as $tag):
									$peopleTagName = str_replace('@', '', $tag->name);
									if($peopleTagName == get_the_title($post->ID)){
										if( $user = get_user_by_display_name( $tagName ) ) {
											$teams[] = sprintf(
												'<a href="%1$s" title="%2$s">%2$s</a>',
												get_author_posts_url($user->ID),
												$clean_name,
												get_avatar( $user->ID, 32 )
											);
										} else {
											$email = get_post_meta($people->ID, '_base_people_email', true);
											$teams[] = sprintf(
												'<a href="%1$s" title="%2$s">%3$s</a>',
												get_permalink($people->ID),
												get_the_title($people->ID),
												get_avatar( $email, 32 )
											);
										}
									}
								endforeach;
							}
						}
					}
				}
				
				if( $teams ){
					echo implode(' ', $teams);
				} else {
					echo sprintf( '<p>%s</p>', __('No one is set as member of this team', 'wpas') );
				}
			?></div>
			
			<div class="wpa-sgl-socials">
				<h3><?php _e('Follow', 'wpa'); ?></h3>
				<ul><?php
					$socials = array(
						'awp-facebook' => 'Facebook',
						'awp-twitter' => 'Twitter',
						'awp-googleplus' => 'Google+',
						'awp-linkedin' => 'LinkedIn',
						'awp-youtube' => 'Youtube',
						'awp-pinterest' => 'Pinterest',
						'awp-rss' => 'RSS'
					);
					
					foreach($socials as $meta_key=>$media){
						$url = get_post_meta($post->ID, 'awp-url', true);
						$page = get_post_meta($post->ID, $meta_key, true);
						
						$count = get_post_meta($post->ID, $meta_key.'-followers', true);
						if( $count == '' ) { $count = wpas_get_social_counts($media, $url, $page); }
						
						if(!$count) {
							$title = $media;
						} else {
							$title = $media .' '. number_format((int)$count);
						}
						
						if($page){
							echo sprintf(
								'<li><a href="%s" data-type="%s" data-text="%s" target="_blank" class="%s">%2$s</a>',
								$page,
								$media,
								'Follow',
								'wpa-sgl-icon '. $meta_key . '-icon'
							);
							echo sprintf('<span class="count">%s</span>', wpas_numbers_to_readable_size($count) );
						}
					}
				?></ul>
            </div>
			<a href="<?php echo site_url('/'); ?>" class="wpa-watch-button"><?php _e('Watch This', 'wpa'); ?></a>
			
			<div class="fix"></div>
		</div>
        
		<div class="fix"></div>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				// Use the each() method to gain access to each of the elements attributes
				$('.wpa-sgl-icon').each(function(){
					$(this).qtip({
						content: '<a href="' + $(this).attr('href') +'" class="' + $(this).attr('data-type') + '" target="_blank"><span>&nbsp;</span>Follow on ' + $(this).attr('data-type') + '</a>',
						position: {
							corner: {
								target: 'bottomLeft',
							}
						},
						hide: {
							fixed: true
						},
						style: {
							width: 155,
							name: 'light',
							border: {
								width: 0
							}
						}
					});
				});
			});
		</script><?php
	}
}

add_action('wpa_post_inside_after', 'wpas_site_coveraged');
function wpas_site_coveraged(){
	global $post;
	
	if( is_single() && 'site' == $post->post_type ){
		wp_enqueue_script('flexslider');
		
		$directs = array();
		if( $coveraged = get_the_terms($post->ID, array('site-include')) ){
			foreach( $coveraged as $coverage ):
				$page_title = str_replace('@', '', $coverage->name);
				if( $post = get_page_by_title($page_title, OBJECT, 'show') )
					$directs[] = $post;
				if( $post = get_page_by_title($page_title, OBJECT, 'interviews') )
					$directs[] = $post;
				if( $post = get_page_by_title($page_title, OBJECT, 'reviews') )
					$directs[] = $post;
			endforeach;
		}
		
		$generals = wpas_get_sites_generally_related_posts($post->ID);
		$shows = array_merge($generals, $directs);
		
		?><div class="wpa-sgl-coverage">
			<ul class="wpa-coverage-filter alignright">
				<li class="first"><a href="#">Reviews</a></li>
				<li><a href="#">Interviews</a></li>
				<li><a href="#">Courses</a></li>
				<li><a href="#">Tutorials</a></li>
				<li class="last"><a href="#">Hangouts</a></li>
			</ul>
			
			<h3><?php _e('WPA Coveraged', 'wpa'); ?></h3><?php
			
            if( $shows ){
				?><div id="wpa-coverage-flexslider" class="wpa-flexslider flexslider">
                    <ul class="wpa-coverage-slides slides"><?php
						foreach( $shows as $show ):
							?><li><a href="<?php echo get_permalink($show->ID); ?>" title="<?php echo get_the_title($show->ID); ?>"><?php
                            	if( has_post_thumbnail($show->ID) ){
									echo get_the_post_thumbnail($show->ID, 'medium');
								} else {
									?><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /><?php
								}
                            ?></a></li><?php
						endforeach;
                    ?></ul>
                </div>
                
                <script type="text/javascript">
                    jQuery(window).load(function() {
                        jQuery('#wpa-coverage-flexslider').flexslider({
                            animation: "slide",
                            animationLoop: false,
                            itemWidth: 175,
                            maxItems: 5,
                            itemMargin: 42,
                            slideshow: false,
                            controlNav: false
                        });
                    });
                </script><?php
            } else {
                echo sprintf( '<p>%s</p>', __('No coveraged found', 'wpas') );
            }
            wp_reset_query();
            
		?></div><?php
	}
}

add_action('wpa_post_inside_after', 'wpa_site_most_shared');
function wpa_site_most_shared(){
	global $post;
	
	if( is_single() && 'site' == $post->post_type ){
		wp_enqueue_script('flexslider');
		
		?><div class="wpa-sgl-coverage">
			<ul class="wpa-popular-filter alignright">
				<li class="first"><a href="#">Today</a></li>
				<li><a href="#">Week</a></li>
				<li><a href="#">Month</a></li>
				<li><a href="#">Year</a></li>
				<li class="last"><a href="#">All Time</a></li>
			</ul>
			
			<h3><?php _e('Most Shared Content on', 'wpa'); ?> <?php echo get_the_title($post->ID); ?>'s Network</h3>
			
			<div id="wpa-popular-flexslider" class="wpa-flexslider flexslider">
				<ul class="wpa-populars-slides slides">
					<li><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></li>
					<li><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></li>
					<li><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></li>
					<li><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></li>
					<li><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></li>
					<li><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></li>
					<li><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></li>
					<li><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></li>
				</ul>
			</div>
			
			<script type="text/javascript">
				jQuery(window).load(function() {
					jQuery('#wpa-popular-flexslider').flexslider({
						animation: "slide",
						animationLoop: false,
						itemWidth: 175,
						maxItems: 5,
						itemMargin: 42,
						slideshow: false,
						controlNav: false
					});
				});
			</script>
		</div><?php
	}
}

add_action('wpa_post_inside_after', 'wpa_audit_site_score');
function wpa_audit_site_score(){
	global $post;
	
	$fields = wpa_default_metrics();
	
	if( is_single() && 'site' == $post->post_type ){
		?><div class="wpa-sgl-audits">
			<ul class="wpa-units-filter alignright">
				<li class="first"><a href="#">Points</a></li>
				<li><a href="#">Grades</a></li>
				<li><a href="#">Change</a></li>
				<li class="last"><a href="#">Rank</a></li>
			</ul>
			
			<ul class="wpa-type-filter alignright">
				<li class="first"><a href="#">Wordpress</a></li>
				<li><a href="#">Authority</a></li>
				<li class="last"><a href="#">Site</a></li>
			</ul>
			
			<h3><?php _e('Authority Audit Score'); ?></h3>
			
            <div id="wpa-scores" class="wpa-score-tabs">
            	<a class="wpas-score-tabs-prev" href="#">Prev</a>
				<a class="wpas-score-tabs-next" href="#">Next</a>
				
				<div style="overflow: hidden; margin: 0 25px;"><?php
            		wpas_site_metrics_grade(true, $post->ID);
				?></div>
                
                <a href="#" class="wpa-sgl-compare-button alignright">+ Compare Site</a>
                
                <ul class="wpa-display-controls">
                    <li class="openSearch">
                        <a href="#openSearch" class="wpa-control search" title="Screen Options">Open Search</a>
                        <div class="wpa-screen-options hide"></div>
                    </li>
                    <li class="openExport">
                        <a href="#export" class="wpa-control export" title="Export Options">Export</a>
                        <div class="wpa-export-options hide"></div>
                    </li>
                </ul><?php
                
                $site = array('domain', 'tld', 'url', 'date', 'networked', 'location', 'language');
                $links = array('google', 'alexa', 'yahoo', 'majestic');
                $socials = array(
                    'googleplus' => 'googleplus-followers',
                    'facebook' => 'facebook-followers',
                    'twitter' => 'twitter-followers',
                    'youtube' => 'youtube-followers',
                    'pinterest' => 'pinterest-followers',
                    'linkedin' => 'linkedin-followers',
                    'klout' => 'klout-followers'
                );
                
                ?><div class="wpa-sgl-metrics"><?php
					$heads = wpa_get_metrics_groups();
					unset($heads['awp-scores']);
					foreach( $heads as $head ){
						$metrics = wpa_get_metrics_by_group($head['id']);
						
						?><div id="<?php echo $head['id']; ?>">
							<h3><?php echo $head['name']; ?></h3>
							<table class="wpa-metrics-table">
								<thead><tr>
									<th class="metric"><?php _e('Metric Name', 'wpas'); ?></th>
									<th class="result"><?php _e('Audit Result', 'wpas'); ?></th>
									<th class="score"><?php _e('Score', 'wpas'); ?></th>
									<th class="solutions"><?php _e('Solutions', 'wpas'); ?></th>
								</tr></thead>
								
								<tbody><?php
									foreach( $metrics as $metric ){
										$value = get_post_meta($post->ID, $metric['id'], true);
										switch($metric['format']):
											case 'date':
												$result = date('F j, Y', strtotime($value)); break;
											case 'link':
												$text = ($metric['link_text']) ? $metric['link_text'] : $value;
												$result = sprintf('<a href="%s" target="_blank">%s</a>', $value, $text);
												break;
											case 'meta':
												$text = get_post_meta($post->ID, $metric['meta_value'], true);
												$result = sprintf('<a href="%s" target="_blank">%s</a>', $value, $text);
												break;
											case 'image':
												$result = sprintf('<img src="%s" alt="%s" />', $value, get_the_title($post->ID)); break;
											default:
												$result = $value;
										endswitch;
										
										?><tr valign="top">
											<th class="metric" scope="row"><?php
												echo sprintf('<i title="%1$s">%1$s</i>', stripslashes($metric['tip']));
												echo sprintf('<strong>%s</strong>', $metric['name']);
												echo sprintf('<span class="description">%s</span>', $metric['data_source']);
											?></th>
											<td class="result"><?php
												echo sprintf('<em>%s</em> <span class="description">%s</span>', $result, $metric['unit']);
											?></td>
											<td class="score"><?php
												$points = 53;
												echo sprintf('<em>%s</em> <span>Points</span>', $points);
											?></td>
											<td class="solutions"><?php
												echo sprintf('<h3>%s</h3> <p>%s</>', __('Get Radar Detector', 'wpas'), __('Your\'e going way to fast, your\'e going to get a ticket.', 'wpas'));
											?></td>
										</tr><?php
									}
								?></tbody>
							</table>
						</div><?php
					}
                ?></div><!-- /.wpa-sgl-metrics -->
            </div><!-- /#wpa-scores -->
		</div><!-- /wpa-sgl-audits -->
		
        <script type="text/javascript">
			jQuery(document).ready(function($) {
                $("#wpa-scores").tabs();
            });
		</script>
        
		<div class="clear"></div><?php
	}
}

add_filter('after_bb_builder_form', 'survey_popup', 10);
function survey_popup( $after ){
	$settings = get_option('awp_settings');
	global $post;
	
	if( is_page() && $post->ID == $settings['bb_builder_page'] ){
		$after = '<div style="display:none;"><div class="wpa_popup" id="wpa_help_popup">';
        	$after .= '<p><span class="wpa_popup_icon"></span>';
			$after .= __('Have you completed all the fields marked in orange?');
			$after .= '<br>';
			$after .= __('If you need help, please watch the video.');
			$after .= '</p>';
            
			$after .= '<div class="wpa_popup_actions">';
				$after .= '<input type="button" id="cancel_submit" class="wpa_button cancel" value="Cancel" />';
            	$after .= '<input type="submit" id="submit_survey" class="wpa_button submit" value="Continue" />';
			$after .= '</div>';
			
			$after .= '<div class="clear"></div>';
		$after .= '</div></div>';
	}
	
	return $after;
}
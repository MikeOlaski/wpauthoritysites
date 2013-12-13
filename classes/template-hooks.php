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
		$tags_list = get_terms('site-tag', array(
			'orderby' 		=> 'count',
			'hide_empty'	=> 0
		));
		
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
						textColour: '#333333',
						outlineColour: '#ffffff',
						outlineThickness: false,
						reverse: true,
						depth: 1,
						weight: true,
						maxSpeed: 0.05
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
		?><div class="wpa-sgl-ranks">
			<div class="wpa-sgl-rates">
				<span class="wpa-sgl-rate wpa-rate-4">4</span>
			</div>
			
			<div class="wpa-sgl-topranks">
				<ul>
					<li>
						<span class="alexa-sgl-icon">Alexa Rank</span>
						<?php echo number_format((int)get_post_meta($post->ID, 'awp-alexa-rank', true)); ?>
						<br class="clear" />
					</li>
					<li>
						<span class="seomoz-sgl-icon">SEOMoz Rank</span>
						<?php echo number_format((int)get_post_meta($post->ID, 'awp-moz-rank', true), 1); ?>
						<br class="clear" />
					</li>
					<li>
						<span class="onerank-sgl-icon">ONE Rank</span>
						<?php echo number_format((int)get_post_meta($post->ID, 'awp-one-rank', true)); ?>
						<br class="clear" />
					</li>
				</ul>
			</div>
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
				
				$include_list = get_the_terms( $post->ID, 'site-include' );
				if($include_list){
					foreach($include_list as $inc){
						$clean_name = str_replace('@', '', $inc->name);
						$people = get_post_by_title($clean_name, 'people');
						
						if($people){
							$tag_list = get_the_terms( $people, 'people-include' );
							foreach($tag_list as $tag){
								$clean_site = str_replace('@', '', $tag->name);
								if($clean_site == get_the_title($post->ID)){
									$user = get_user_by_display_name( $clean_name );
									?><a href="<?php echo get_author_posts_url($user->ID); ?>"><?php
										echo get_avatar( $user->ID, 32 );
									?></a><?php
								}
							}
						}
					}
				}
			?></div>
			
			<div class="wpa-sgl-socials">
				<h3><?php _e('Follow', 'wpa'); ?></h3><?php
				
				$socials = array(
					'awp-twitter' => 'Twitter',
					'awp-youtube' => 'Youtube',
					'awp-facebook' => 'Facebook',
					'awp-linkedin' => 'LinkedIn',
					'awp-pinterest' => 'Pinterest',
					'awp-flickr' => 'FlickR',
					'awp-googleplus' => 'Google+',
					'awp-rss' => 'RSS'
				);
				
				foreach($socials as $meta_key=>$media){
					$title = get_post_meta($post->ID, $meta_key.'-followers', true);
					$link = get_post_meta($post->ID, $meta_key, true);
					
					if(!$title) {
						$title = $media;
					} else {
						$title = $media .' '. number_format((int)$title);
					}
					
					if($link){
						?><a href="<?php echo $link; ?>" target="_blank" title="<?php echo $title; ?>" class="wpa-sgl-icon <?php echo $meta_key; ?>-icon"><?php
							echo $media;
						?></a><?php
					}
				}
				
			?></div>
			<a href="<?php echo site_url('/'); ?>" class="wpa-watch-button"><?php _e('Watch This', 'wpa'); ?></a>
			
			<div class="fix"></div>
		</div>
		
		<div class="fix"></div><?php
	}
}

add_action('wpa_post_inside_after', 'wpa_site_coveraged');
function wpa_site_coveraged(){
	global $post;
	
	if( is_single() && 'site' == $post->post_type ){
		wp_enqueue_script('flexslider');
		
		?><div class="wpa-sgl-coverage">
			<ul class="wpa-coverage-filter alignright">
				<li class="first"><a href="#">Reviews</a></li>
				<li><a href="#">Interviews</a></li>
				<li><a href="#">Courses</a></li>
				<li><a href="#">Tutorials</a></li>
				<li class="last"><a href="#">Hangouts</a></li>
			</ul>
			
			<h3><?php _e('WPA Coveraged', 'wpa'); ?></h3>
			
			<div id="wpa-coverage-flexslider" class="wpa-flexslider flexslider">
				<ul class="wpa-coverage-slides slides">
					<li><a href="#"><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></a></li>
					<li><a href="#"><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></a></li>
					<li><a href="#"><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></a></li>
					<li><a href="#"><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></a></li>
					<li><a href="#"><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></a></li>
					<li><a href="#"><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></a></li>
					<li><a href="#"><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></a></li>
					<li><a href="#"><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></a></li>
					<li><a href="#"><img src="<?php echo PLUGINURL; ?>images/placeholder.jpg" alt="Placeholder" /></a></li>
				</ul>
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
			</script>
		</div><?php
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
				<ul class="tabs">
					<li><a class="grade-2" href="#none">
						<span>LINKS</span>
						<em>0%</em>
						<small>163 VS 163</small>
					</a></li>
					<li><a class="grade-2" href="#none">
						<span>SOCIAL</span>
						<em>0%</em>
						<small>163 VS 163</small>
					</a></li>
					<li><a class="grade-1" href="#none">
						<span>COMMUNITY</span>
						<em>0%</em>
						<small>163 VS 163</small>
					</a></li>
					<li><a class="grade-1" href="#none">
						<span>BUZZ</span>
						<em>0%</em>
						<small>163 VS 163</small>
					</a></li>
					<li><a class="grade-0" href="#none">
						<span>TRAFFIC</span>
						<em>0%</em>
						<small>163 VS 163</small>
					</a></li>
					<li><a class="grade-2" href="#none">
						<span>ENGAGEMENT</span>
						<em>0%</em>
						<small>163 VS 163</small>
					</a></li>
					<li><a href="#none">
						<span>NETWORK</span>
						<em>0%</em>
						<small>163 VS 163</small>
					</a></li>
				</ul>
				<div id="none"></div>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<div class="wpa-group-column alignleft">
			<ul>
				<li class="first current"><a href="#">Summary</a></li>
				<li><a href="#">Scores</a></li>
				<li><a href="#">Site</a></li>
				<li><a href="#">Project</a></li>
				<li><a href="#">Links</a></li>
				<li><a href="#">Social</a></li>
				<li><a href="#">Community</a></li>
				<li><a href="#">Buzz</a></li>
				<li><a href="#">Traffic</a></li>
				<li><a href="#">Engagement</a></li>
				<li><a href="#">Content</a></li>
				<li><a href="#">Authors</a></li>
				<li><a href="#">Valuation</a></li>
			</ul>
		</div>
		
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
		</ul>
		
		<div class="clear"></div><?php
	}
}

add_action('wpa_post_inside_after', 'wpa_metrics_table');
function wpa_metrics_table(){
	global $post;
	
	if( is_single() && 'site' == $post->post_type ){
		?><div class="wpa-sgl-metrics">
			<h3><?php _e('Site', 'wpa'); ?></h3>
			
			<table class="wpa-metrics-table">
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Load Time'); ?></strong>
						<span class="description">by Site Auditor</span>
					</th>
					<td><em>1.14</em><span class="description">seconds</span></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Page Speed'); ?></strong>
						<span class="description">by Google</span>
					</th>
					<td><em>70</em><span class="description">overall score</span></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Preparedness'); ?></strong>
						<span class="description">by Site Auditor</span>
					</th>
					<td><ul>
						<li>www Direct Detected</li>
						<li>robots.txt Detected</li>
						<li>Google Analytics Integration Detected</li>
						<li>Crawlable</li>
						<li>No Malware Detected</li>
					</ul></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Domain Registration'); ?></strong>
						<span class="description">by Site Auditor</span>
					</th>
					<td><em>457</em><span class="description">days until expiration</span></td>
					<td></td>
				</tr>
			</table>
			
			<h3><?php _e('Links', 'wpa'); ?></h3>
			
			<table class="wpa-metrics-table">
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('External Backlinks'); ?></strong>
						<span class="description">by Majestic SEO</span>
					</th>
					<td><em>21,750</em><span class="description">backlinks</span></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('External Backlinks'); ?></strong>
						<span class="description">by MOZ</span>
					</th>
					<td><em>5,015</em><span class="description">backlinks</span></td>
					<td></td>
				</tr>
			</table>
			
			<h3><?php _e('Social', 'wpa'); ?></h3>
			
			<table class="wpa-metrics-table">
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Social Integration'); ?></strong>
						<span class="description">by Site Auditor</span>
					</th>
					<td><ul>
						<li>Facebook</li>
						<li>Twitter</li>
						<li>Google+</li>
						<li>LinkedIn</li>
					</ul></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Tweets'); ?></strong>
						<span class="description">on Twitter</span>
					</th>
					<td><em>1</em><span class="description">Tweet</span></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Likes'); ?></strong>
						<span class="description">on Facebbok</span>
					</th>
					<td><em>4,343</em><span class="description">likes</span></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Shares'); ?></strong>
						<span class="description">on Facebook</span>
					</th>
					<td><em>6,828</em><span class="description">shares</span></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Comments'); ?></strong>
						<span class="description">on Facebook</span>
					</th>
					<td><em>13,661</em><span class="description">comments</span></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Like Button'); ?></strong>
						<span class="description">on Facebook</span>
					</th>
					<td><em>24,832</em><span class="description">likes</span></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('+1\'s'); ?></strong>
						<span class="description">on Google+</span>
					</th>
					<td><em>220</em><span class="description">pluses</span></td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<i title="A detailed explanation about this field">A detailed explanation about this field</i>
						<strong><?php _e('Klout Score'); ?></strong>
						<span class="description">by Klout</span>
					</th>
					<td><em>53</em><span class="description">overall klout score</span></td>
					<td></td>
				</tr>
			</table>
		</div><?php
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
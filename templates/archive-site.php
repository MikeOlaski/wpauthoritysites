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

global $wp_query;
wp_reset_query();

$wp_query->set("tax_query", array(
	array(
		'taxonomy' => 'site-type',
		'field' => 'slug',
		'terms' => 'wpa'
	)
));

$archivePage = get_post_type_archive_link('site') . '?';
$orderby = isset($wp_query->query['orderby']) ? $wp_query->query['orderby'] : 'id';
$order = (isset($wp_query->query['order']) && 'asc' == $wp_query->query['order']) ? 'desc' : 'asc';

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

$wp_query->get_posts();

/*?><pre><?php print_r( $wp_query ); ?></pre><?php wp_die();*/

get_header();

?><section id="primary"><?php

	/*<div id="secondary" class="widget-area" role="complementary">
    </div>*/
    
    ?><div id="content" role="main"><?php
	
		if ( $wp_query->have_posts() ) :
		
			?><ul class="wpa-display-controls">
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
                <li><a href="#grid" class="wpa-control grid current">Grid</a></li>
                <li><a href="#detail" class="wpa-control detail">List</a></li>
                <li><a href="#list" class="wpa-control list">Detailed</a></li>
            </ul>
                
            <header class="page-header">
                <h1 class="page-title">
                    <?php _e( 'Sites Archives', 'awp' ); ?>
                </h1>
            </header>
			
            <div class="wpa-display-archives grid"><?php
				
				$sortbytitle = $archivePage . 'orderby=title&order='. $order;
				$sortbyPR = $archivePage . 'meta_key=awp-google-rank&orderby=meta_value&order=' . $order;
				$sortbyalexa = $archivePage . 'meta_key=awp-alexa-rank&orderby=meta_value&order=' . $order;
				
				/* Grid and Detail Header */
				?><div class="wpa-sort-wrapper">
					<p>Sort by:
                    <a href="<?php echo $sortbytitle; ?>" class="wpa-sortable <?php echo $order; echo ($orderby == 'title') ? ' current' : ''; ?>" >Title</a> |
                    <a href="<?php echo $sortbyPR; ?>" class="wpa-sortable <?php echo $order; echo ($meta == 'awp-google-rank') ? ' current' : ''; ?>">Google Rank</a> |
                    <a href="<?php echo $sortbyalexa; ?>" class="wpa-sortable <?php echo $order; echo ($meta == 'awp-alexa-rank') ? ' current' : ''; ?>">Alexa Rank</a>
                    </p>
				</div>
				
				<div class="wpa-screen-options">
                	<h4>Site</h4>
					<p>
                    	<input type="checkbox" id="wpa-thumbnail-option" value=".metrics-thumbnail" checked="checked" />
                        <label for="wpa-thumbnail-option">Thumbnail</label>
                        
                        <input type="checkbox" id="wpa-date-option" value=".metrics-founded" checked="checked" />
                        <label for="wpa-date-option">Date Founded</label>
                        
                        <input type="checkbox" id="wpa-location-option" value=".metrics-location" checked="checked" />
                        <label for="wpa-location-option">Location</label>
                        
                        <input type="checkbox" id="wpa-language-option" value=".metrics-language" checked="checked" />
                        <label for="wpa-language-option">Language</label>
                    </p>
                    
                    <h4>Owners</h4>
                    <p>
                        <input type="checkbox" id="wpa-founder-option" value=".metrics-founder" checked="checked" />
                        <label for="wpa-founder-option">Founder</label>
                        
                        <input type="checkbox" id="wpa-owner-option" value=".metrics-owner" checked="checked" />
                        <label for="wpa-owner-option">Owner</label>
                        
                        <input type="checkbox" id="wpa-publisher-option" value=".metrics-publisher" checked="checked" />
                        <label for="wpa-publisher-option">Publisher</label>
                        
                        <input type="checkbox" id="wpa-producer-option" value=".metrics-producer" checked="checked" />
                        <label for="wpa-producer-option">Producer</label>
                    </p>
                    
                    <h4>Backlinks</h4>
                    <p>
                        <input type="checkbox" id="wpa-google-option" value=".metrics-google" checked="checked" />
                        <label for="wpa-google-option">Google</label>
                        
                        <input type="checkbox" id="wpa-alexa-option" value=".metrics-alexa" checked="checked" />
                        <label for="wpa-alexa-option">Alexa</label>
                        
                        <input type="checkbox" id="wpa-yahoo-option" value=".metrics-yahoo" checked="checked" />
                        <label for="wpa-yahoo-option">Yahoo</label>
                        
                        <input type="checkbox" id="wpa-majestic-option" value=".metrics-majestic" checked="checked" />
                        <label for="wpa-majestic-option">Majestic</label>
                    </p>
                    
                    <h4>Shares and Likes</h4>
                    <p>
                        <input type="checkbox" id="wpa-googleplus-option" value=".metrics-googleplus" checked="checked" />
                        <label for="wpa-googleplus-option">Google+</label>
                        
                        <input type="checkbox" id="wpa-fbshares-option" value=".metrics-fbshares" checked="checked" />
                        <label for="wpa-fbshares-option">Facebook Shares</label>
                        
                        <input type="checkbox" id="wpa-fblikes-option" value=".metrics-fblikes" checked="checked" />
                        <label for="wpa-fblikes-option">Facebook Likes</label>
                        
                        <input type="checkbox" id="wpa-twitter-option" value=".metrics-twitter" checked="checked" />
                        <label for="wpa-twitter-option">Twitter</label>
                        
                        <input type="checkbox" id="wpa-pinterest-option" value=".metrics-pinterest" checked="checked" />
                        <label for="wpa-pinterest-option">Pinterest</label>
                        
                        <input type="checkbox" id="wpa-linkedin-option" value=".metrics-linkedin" checked="checked" />
                        <label for="wpa-linkedin-option">LinkedIn</label>
                    </p>
                    
                    <h4>Ranks</h4>
                    <p>
                        <input type="checkbox" id="wpa-alexarank-option" value=".metrics-alexarank" checked="checked" />
                        <label for="wpa-alexarank-option">Alexa Rank</label>
                        
                        <input type="checkbox" id="wpa-googlerank-option" value=".metrics-googlerank" checked="checked" />
                        <label for="wpa-googlerank-option">Gooogle Rank</label>
                        
                        <input type="checkbox" id="wpa-competerank-option" value=".metrics-competerank" checked="checked" />
                        <label for="wpa-competerank-option">Compete Rank</label>
                        
                        <input type="checkbox" id="wpa-semrushrank-option" value=".metrics-semrushrank" checked="checked" />
                        <label for="wpa-semrushrank-option">Sem Rush Rank</label>
                        
                        <input type="checkbox" id="wpa-onerank-option" value=".metrics-onerank" checked="checked" />
                        <label for="wpa-onerank-option">One Rank</label>
                    </p>
				</div><?php
            	
				/* List Header */
				?><div class="wpa-list-header">
					<div class="wpa-th-count">#</div>
                    <div class="wpa-th-title">
                    	<a href="<?php echo $sortbytitle; ?>" class="wpa-sortable <?php echo $order; echo ($orderby == 'title') ? ' current' : ''; ?>">Blog</a>
                    </div>
                    <div class="wpa-th-spacer"><a href="<?php echo $sortbyPR; ?>" class="wpa-sortable <?php echo $order; echo ($meta == 'awp-google-rank') ? ' current' : ''; ?>">PR</a></div>
                    <div class="wpa-th-traffic"><a href="<?php echo $sortbyalexa; ?>" class="wpa-sortable <?php echo $order; echo ($meta == 'awp-alexa-rank') ? ' current' : ''; ?>">Alexa</a></div>
                    <div class="wpa-th-authority">Links</div>
                    <div class="wpa-th-buzz">Backlinks</div>
                    
                    <div class="clear"></div>
				</div><?php
				
				/* Start the Loop */
				$i = 1;
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
				
					$metrics = get_post_meta( get_the_ID() );
					
					$post_id = get_the_ID();
					$class = (is_sticky()) ? 'sticky-site' : '';
					$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) );
					$attachmentURL = ($attachment) ? PLUGINURL . '/timthumb.php?src=' . $attachment[0] . '&w=150&h=150' : null;
					$thumbnailURL = ($attachment) ? PLUGINURL . '/timthumb.php?src=' . $attachment[0] . '&w=180&h=100' : null;
					
					$pageRank = get_post_meta($post_id, 'awp-google-rank', true);
					$alexaRank = get_post_meta($post_id, 'awp-alexa-rank', true);
					$date = get_post_meta($post_id, 'awp-date', true);
					$location = get_post_meta($post_id, 'awp-location', true);
					$language = get_post_meta($post_id, 'awp-language', true);
					
					$gplus = get_post_meta($post_id, 'awp-googleplus', true);
					$fb = get_post_meta($post_id, 'awp-facebook', true);
					$twitter = get_post_meta($post_id, 'awp-twitter', true);
					$pinteret = get_post_meta($post_id, 'awp-pinterest', true);
					$linkedin = get_post_meta($post_id, 'awp-linkedin', true);
					
					$gPlusCount = get_post_meta($post_id, 'awp-shares-goolgeplus', true);
					$fbShares = get_post_meta($post_id, 'awp-shares-facebook', true);
					$fbLikes = get_post_meta($post_id, 'awp-likes-facebook', true);
					$tweets = get_post_meta($post_id, 'awp-shares-twitter', true);
					$pinCount = get_post_meta($post_id, 'awp-shares-pinterest', true);
					$linkedCount = get_post_meta($post_id, 'awp-shares-linkedin', true);
					
					?><article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
						
                        <!-- List View -->
						<div class="wp-list-item">
							<div class="wpa-td-count"><?php echo $i; ?></div>
                            <div class="wpa-td-title">
                            	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								<p><?php
									if($gPlusCount){ ?><span class="meta">Google+:</span> <span class="metaval"><?php echo $gPlusCount; ?></span> <?php }
									if($fbShares){ ?><span class="meta">Facebook Share:</span> <span class="metaval"><?php echo $fbShares; ?></span> <?php }
									if($fbLikes){ ?><span class="meta">Facebook Likes:</span> <span class="metaval"><?php echo $fbLikes; ?></span> <?php }
									if($tweets){ ?><span class="meta">Twitter Shares:</span> <span class="metaval"><?php echo $tweets; ?></span> <?php }
									if($pinCount){ ?><span class="meta">Pinterest:</span> <span class="metaval"><?php echo $pinCount; ?></span><?php }
									if($linkedCount){ ?><span class="meta">LinkedIn:</span> <span class="metaval"><?php echo $linkedCount; ?></span> <?php }
                            	?></p>
                            </div>
                            <div class="wpa-td-spacer"><?php
                            	echo $pageRank;
							?></div>
                            <div class="wpa-td-traffic"><?php
                            	echo $metrics['awp-alexa-rank'][0];
                            ?></div>
                            <div class="wpa-td-authority"><?php
                            	if($gplus){ ?><a href="<?php echo $gplus; ?>" target="_blank" class="wpa-icons google">Google</a><?php }
								if($fb){ ?><a href="<?php echo $fb; ?>" target="_blank" class="wpa-icons facebook">Facebook</a><?php }
								if($twitter){ ?><a href="<?php echo $twitter; ?>" target="_blank" class="wpa-icons twitter">Teitter</a><?php }
								if($pinterest){ ?><a href="<?php echo $pinterest; ?>" target="_blank" class="wpa-icons pinterest">Pin</a><?php }
								if($linkedin){ ?><a href="<?php echo $linkedin; ?>" target="_blank" class="wpa-icons linkedin">LinkedIn</a><?php }
							?></div>
                            <div class="wpa-td-buzz">
                            	<p><span class="meta">Google: <span class="metaval"><?php echo $metrics['awp-google'][0]; ?></span></span><br />
                                <span class="meta">Alexa: <span class="metaval"><?php echo $metrics['awp-alexa'][0]; ?></span></span><br />
                                <span class="meta">Yahoo: <span class="metaval"><?php echo $metrics['awp-yahoo'][0]; ?></span></span><br />
                                <span class="meta">Majestic: <span class="metaval"><?php echo $metrics['awp-majestic'][0]; ?></span></span></p>
                            </div>
                            
                            <div class="clear"></div>
						</div>
						
                        <!-- Grid View -->
						<div class="wpa-grid-item"><?php
							
							?><header class="entry-header">
								<div class="thumbnail alignleft">
									<a href="<?php the_permalink(); ?>"><?php
										if($attachmentURL){
											?><img src="<?php echo $thumbnailURL ?>" align="<?php the_title(); ?>" /><?php
										} else {
											?><span><?php echo 'NO IMAGE'; ?></span><?php
										}
									?></a>
                                </div>
                                
                                <h4 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'awp' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                                <span class="meta"><?php
									echo date('F j Y', strtotime($date));
								?></span>
                            </header><!-- .entry-header -->
							
							<div class="entry-summary"><?php
								?><h2><?php echo number_format( (float)$alexaRank ); ?></h2>
                            </div><!-- .entry-summary -->
                            
                            <div class="clear"></div>
						</div>
						
                        <!-- Detail View -->
						<div class="wpa-detail-item">
                            <div class="thumbnail alignleft metrics-thumbnail">
								<a href="<?php the_permalink(); ?>"><?php
									if($attachmentURL){
										?><img src="<?php echo $attachmentURL ?>" align="<?php the_title(); ?>" /><?php
									} else {
										?><span><?php echo 'NO IMAGE'; ?></span><?php
									}
								?></a>
                            </div>
							
							<div class="entry-summary">
                                <header class="entry-header">
                                    <h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'awp' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                </header><!-- .entry-header --><?php
								
								the_excerpt();
								
								?><p><span class="meta metrics-founded">
                                	Established <span class="metaval"><?php echo date('F j Y', strtotime($date)); ?></span>
                                </span>
								<span class="meta metrics-googlerank">
                                	PageRank <span class="metaval"><?php echo number_format( (float)$alexaRank ); ?></span>
                                </span>
								<span class="meta metrics-location">
                                	Location <span class="metaval"><?php echo $location; ?></span>
                                </span>
								<span class="meta metrics-language">
                                	Language <span class="metaval"><? echo $language ?></span>
                                </span></p><?php
								
                                // Owner
                                ?><p><span class="meta metrics-founder">
                                	Founder <span class="metaval"><?php echo $metrics['awp-founder'][0]; ?></span>
                                </span>
                                <span class="meta metrics-owner">
                                	Owner <span class="metaval"><?php echo $metrics['awp-owner'][0]; ?></span>
                                </span>
                                <span class="meta metrics-publisher">
                                	Publisher <span class="metaval"><?php echo $metrics['awp-publisher'][0]; ?></span>
                                </span>
                                <span class="meta metrics-producer">
                                	Producer <span class="metaval"><?php echo $metrics['awp-producer'][0]; ?></span>
                                </span></p><?php
                                
								// Links
								?><p><span class="meta metrics-google">
                                	Google Backlinks <span class="metaval"><?php echo $metrics['awp-google'][0]; ?></span>
                                </span>
                                <span class="meta metrics-alexa">
                                	Alexa Backlinks <span class="metaval"><?php echo $metrics['awp-alexa'][0]; ?></span>
                                </span>
                                <span class="meta metrics-yahoo">
                                	Yahoo Backlinks <span class="metaval"><?php echo $metrics['awp-yahoo'][0]; ?></span>
                                </span>
                                <span class="meta metrics-majestic">
                                	Majestic Backlinks <span class="metaval"><?php echo $metrics['awp-majestic'][0]; ?></span>
                                </span></p><?php
                                
								// Shares and Likes
								?><p><span class="meta metrics-googleplus">
                                	Google+ <span class="metaval"><?php echo $metrics['awp-shares-goolgeplus'][0]; ?></span>
                                </span>
                                <span class="meta metrics-fbshares">
                                	Facebook Shares <span class="metaval"><?php echo $metrics['awp-shares-facebook'][0]; ?></span>
                                </span>
                                <span class="meta metrics-fblikes">
                                	Facebook Likes <span class="metaval"><?php echo $metrics['awp-likes-facebook'][0]; ?></span>
                                </span>
                                <span class="meta metrics-twitter">
                                	Twitter <span class="metaval"><?php echo $metrics['awp-shares-twitter'][0]; ?></span>
                                </span>
                                <span class="meta metrics-pinterest">
                                	Pinterest <span class="metaval"><?php echo $metrics['awp-shares-pinterest'][0]; ?></span>
                                </span>
                                <span class="meta metrics-linkedin">
                                	LinkedIn <span class="metaval"><?php echo $metrics['awp-shares-linkedin'][0]; ?></span>
                                </span></p><?php
								
								// Ranks
								?><p><span class="meta metrics-alexarank">
                                	Alexa Rank <span class="metaval"><?php echo $metrics['awp-alexa-rank'][0]; ?></span>
                                </span>
                                <span class="meta metrics-googlerank">
                                	Google Rank <span class="metaval"><?php echo $metrics['awp-google-rank'][0]; ?></span>
                                </span>
                                <span class="meta metrics-competerank">
                                	Compete Rank <span class="metaval"><?php echo $metrics['awp-compete-rank'][0]; ?></span>
                                </span>
                                <span class="meta metrics-semrushrank">
                                	SEM Rush Rank <span class="metaval"><?php echo $metrics['awp-semrush-rank'][0]; ?></span>
                                </span>
                                <span class="meta metrics-onerank">
                                	One Rank <span class="metaval"><?php echo $metrics['awp-one-rank'][0]; ?></span>
                                </span></p>
                            </div><!-- .entry-summary -->
                            
                            <div class="clear"></div>
						</div><?php
						$i++;
					?></article><?php
				endwhile;
				
				?><div class="clear"></div>
            </div><?php
			
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
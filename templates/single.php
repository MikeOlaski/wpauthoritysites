<?php
/*
 * The Template for displaying all single posts.
 */

$settings = get_option('awp_settings');
global $post;

get_header();
wpa_content_before();

?><!-- #content Starts -->
<div id="content" class="col-full">
    <div id="main-sidebar-container"><?php
	
        wpa_main_before();
        
        ?><!-- #main Starts -->
        <section id="main"><?php
		
            wpa_loop_before();
            
            if (have_posts()) { $count = 0;
				while (have_posts()) { the_post(); $count++;
					// Get the post content template file, contextually.
					load_template( trailingslashit( PLUGINPATH ) . '/templates/content-'. $post->post_type .'.php' );
				}
			}
            
            wpa_loop_after();
			
        ?></section><!-- /#main --><?php
        
        wpa_main_after();
		
		if( ($settings['single_sidebar'] != '0' || $settings['single_sidebar'] != '') || is_singular('survey') )
			load_template( trailingslashit( PLUGINPATH ) . '/templates/sidebar-'. $post->post_type .'.php' );
    
    	?><div class="clear"></div>
    </div><!-- /#main-sidebar-container --><?php
    
    get_sidebar('alt');
    
?></div><!-- /#content --><?php
    
wpa_content_after();
get_footer();
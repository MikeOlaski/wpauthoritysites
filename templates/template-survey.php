<?php
/*
 * Template Name: Business Builder Survey 
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
        
        ?><form name="bb_builder_form" action="<?php echo get_permalink(); ?>" method="post">
        <!-- #main Starts -->
        <section id="main"><?php
		
            wpa_loop_before();
            
            if (have_posts()) { $count = 0;
				while (have_posts()) { the_post(); $count++;
					$title_before = '<h1 class="wpa-sgl-title">';
					$title_after = '</h1>';
					
					wpa_post_before();
					
					?><article <?php post_class(); ?>><?php
						wpa_post_inside_before();
						
						wpa_before_title();
						
						?><header class="wpa-sgl-header"><?php
						
							the_title( $title_before, $title_after );
							wpa_post_meta();
						
						?></header><?php
						
						wpa_after_title();
						
						?><section class="wpa-sgl-entry entry"><?php
							
							the_content();
							bb_builder_form();
							
						?></section><!-- /.entry --><?php
						
						wpa_post_inside_after();
						
					?></article><!-- /.post --><?php
					
					wpa_post_after();
				}
			}
            
            wpa_loop_after();
			
        ?></section><!-- /#main --><?php
        
        wpa_main_after();
		
		if( ($settings['single_sidebar'] != '0' || $settings['single_sidebar'] != '') || is_singular('survey') )
			load_template( trailingslashit( PLUGINPATH ) . '/templates/sidebar-survey.php' );
    
    	?><div class="clear"></div>
        </form>
    </div><!-- /#main-sidebar-container --><?php
    
    get_sidebar('alt');
    
?></div><!-- /#content --><?php
    
wpa_content_after();
get_footer();
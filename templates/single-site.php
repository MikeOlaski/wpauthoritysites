<?php
!defined( 'ABSPATH' ) ? exit : '';
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

    <div id="primary">
        <div id="content" role="main">

            <?php while ( have_posts() ) : the_post(); ?>

                <?php load_template( trailingslashit( PLUGINPATH ) . '/templates/content-site.php' ); ?>

            <?php endwhile; // end of the loop. ?>

        </div><!-- #content -->
    </div><!-- #primary --><?php
    
    load_template( trailingslashit( PLUGINPATH ) . '/templates/sidebar-site.php' );
	
	?><div class="clear"></div><?php
		
get_footer(); ?>
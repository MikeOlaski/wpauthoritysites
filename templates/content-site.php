<?php
/*
 * WPAS Site single template
 */

$title_before = '<h1 class="title">';
$title_after = sprintf(
	'<span> %s<img src="%s" alt="" />%s</span></h1>',
	wpas_get_claim_popup(false, get_the_ID(), 'single'),
	PLUGINURL . 'images/wpas-icon.png',
	wpas_get_watch_popup(false, get_the_ID(), 'single')
);

?><article <?php post_class('wpas'); ?>>
	<header class="header"><?php the_title( $title_before, $title_after ); ?></header>
	
    <section class="wpas-entry entry">
		<div class="screenshot"><?php
		if ( has_post_thumbnail() )
			wpas_get_image();
		?></div>
        
		<div class="summary">
			<h3><?php _e('Summary', 'wpa'); ?></h3><?php
			the_excerpt();
			?><div style="display:none;"><div id="inlineSummaryContent" class="cBox"><?php the_content(); ?></div></div>
        </div>
        
		<div class="site-media">
			<div class="wpas-media">
				<h3><?php _e('Follow This Site', 'wpas'); ?></h3><?php
				wpas_site_subscribers(true, get_the_ID());
            ?></div>
            
            <div class="wpas-team">
            	<h3><?php _e('Follow This Site\'s Team'); ?></h3><?php
				wpas_site_team(true, get_the_ID());
            ?></div>
        </div>
        
		<div class="authority-ranks">
        	<h3><?php _e('Ranks', 'wpas'); ?></h3><?php
			
			wpas_get_authority_level();
			
			?><div class="wpas-topranks"><?php
				wpas_get_authorit_ranks();
			?></div>
		</div>
        
        <div class="clear"></div>
	</section><!-- /.entry --><?php
	
	wpa_post_inside_after();

?></article><!-- /.post -->
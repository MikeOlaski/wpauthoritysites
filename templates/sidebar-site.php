<?php
/**
 * The Sidebar containing the main widget area.
 */

?><aside id="sidebar"><?php
	$settings = get_option('awp_settings');
	dynamic_sidebar( $settings['single_sidebar'] );
?></aside><!-- /#sidebar -->
<?php
/*
 *
 */

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
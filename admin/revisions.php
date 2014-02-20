<h2><?php _e('Site Metric Revisions', 'wpa'); ?></h2><div>&nbsp;</div><?php

if( isset( $_REQUEST['settings-updated'] ) ){
	if( $_REQUEST['settings-updated'] == 'true' ){
		?><div id="setting-error" class="updated settings-error">
			<p><strong><?php _e('Settings saved', 'wpas'); ?></strong></p>
		</div><?php
	} else {
		?><div id="setting-error" class="error settings-error">
			<p><strong><?php _e('Settings not saved', 'wpas'); ?></strong></p>
		</div><?php
	}
}

$revisions = new WP_Query(
	array(
		'post_type' => 'revision',
		'post_status' => 'inherit',
		'posts_per_page' => -1
	)
);

?><form name="wpas_change" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpas_metric_revisions');?> ">
	<table class="wp-list-table widefat fixed posts">
	
	<thead><tr>
		<th scope="col" id="cb" class="manage-column column-cb check-column">
        	<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
            <input id="cb-select-all-1" type="checkbox">
        </th>
        <th scope="col" id="title" class="manage-column column-title sortable desc"><span>
			<a href="#"><?php _e('Title'); ?></a>
        </span></th>
        <th scope="col" id="date" class="manage-column column-date">
        	<span><?php _e('Date', 'wpas'); ?></span>
        </th>
	</tr></thead>
	
	<tfoot><tr>
		<th scope="col" id="cb" class="manage-column column-cb check-column">
        	<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
            <input id="cb-select-all-1" type="checkbox">
        </th>
        <th scope="col" id="title" class="manage-column column-title sortable desc"><span><?php _e('Title'); ?></span></th>
        <th scope="col" id="date" class="manage-column column-date">
        	<span><?php _e('Date', 'wpas'); ?></span>
        </th>
	</tr></tfoot>
	
	<tbody id="the-list"><?php
		if( $revisions->have_posts() ){
			while( $revisions->have_posts() ) : $revisions->the_post();
				$parent_id = wp_is_post_revision( get_the_ID() );
				
				if( get_post_type( $parent_id ) == 'site' ) {
					?><tr valign="top" id="post-<?php echo get_the_ID(); ?>" class="post-<?php echo get_the_ID(); ?> type-site status-inherit hentry alternate iedit author-self level-0 post">
						<th scope="row" class="check-column">
							<label class="screen-reader-text" for="cb-select-<?php echo get_the_ID(); ?>">Select <?php the_title(); ?></label>
							<input id="cb-select-<?php echo get_the_ID(); ?>" type="checkbox" name="post[]" value="<?php echo get_the_ID(); ?>">
							<div class="locked-indicator"></div>
						</th>
                        <td class="post-title page-title column-title"><?php
                        	echo sprintf(
								'<strong><a class="row-title" href="%s" title="%2$s">%2$s</a></strong>',
								admin_url('revision.php?revision=' . get_the_ID()),
								get_the_title($parent_id)
							);
                        ?></td>
                        <td class="post-date page-date column-date"><?php
							echo get_the_date('F j, Y');
						?></td>
					</tr><?php
				}
				
			endwhile;
		} else {
			?><tr>
				<td scope="row"><?php _e('No revision found', 'wpas'); ?></td>
			</tr><?php
		}
	?></tbody>
    
    </table>
</form>
<?php
/*
 * WPAuthorities Settings page
 * Content & SEO tab
 */

global $options;
$options = get_option('awp_options');
$settings = get_option('awp_settings');
$websites = get_option('awp_websites');

$tab = $_REQUEST['tab'] ? $_REQUEST['tab'] : 'action';

if( isset( $_REQUEST['settings-updated'] ) ){
	if( $_REQUEST['settings-updated'] == 'true' ){
		?><div id="setting-error" class="updated settings-error">
			<p><strong><?php _e('Settings saved.'); ?></strong></p>
		</div><?php
	} else {
		?><div id="setting-error" class="error settings-error">
			<p><strong><?php _e('Settings not saved.'); ?></strong></p>
		</div><?php
	}
}

?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>">

	<h3><?php _e('Archive', 'wpa'); ?></h3>
	
	<table class="form-table">
		<tr>
			<th scope="row"><label for="archive_meta_title">Meta Title</label></th>
			<td><input type="text" class="regular-text" name="awp_settings[archive_meta_title]" id="archive_meta_title" value="<?php echo $settings['archive_meta_title']; ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="archive_meta_desc">Meta Description</label></th>
			<td><input type="text" class="regular-text" name="awp_settings[archive_meta_desc]" id="archive_meta_desc" value="<?php echo $settings['archive_meta_desc']; ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="archive_meta_keywords">Meta Keywords</label></th>
			<td><input type="text" class="regular-text" name="awp_settings[archive_meta_keywords]" id="archive_meta_keywords" value="<?php echo $settings['archive_meta_keywords']; ?>" /></td>
		</tr>
		
		<tr>
			<th scope="row"><label for="archive_page_title">Archive Page Title</label></th>
			<td><input type="text" class="regular-text" name="awp_settings[archive_page_title]" id="archive_page_title" value="<?php echo $settings['archive_page_title']; ?>" /></td>
		</tr>
		
		<tr>
			<th scope="row"><label for="archive_content_before">Content After Title</label></th>
			<td><?php
				wp_editor( $settings['archive_content_before'], 'archive_content_before', array(
					'textarea_name' => 'awp_settings[archive_content_before]'
				));
			?></td>
		</tr>
		
		<tr>
			<th scope="row"><label for="archive_content_after">Content After Site Lists</label></th>
			<td><?php
				wp_editor( $settings['archive_content_after'], 'archive_content_after', array(
					'textarea_name' => 'awp_settings[archive_content_after]'
				));
			?></td>
		</tr>
	</table>
	
	<h3><?php _e('Single Site', 'wpa'); ?></h3>
	
	<table class="form-table">
		<tr>
			<th scope="row"><label for="wpa_single_sidebar"><?php _e('Single Sidebar', ''); ?></label></th>
			<td><select name="awp_settings[single_sidebar]" id="wpa_single_sidebar">
				<option value="0" <?php selected($settings['single_sidebar'], 0); ?>>None</option><?php
				
				global $wp_registered_sidebars;
				foreach($wp_registered_sidebars as $id=>$args){
					?><option value="<?php echo $id; ?>" <?php selected($settings['single_sidebar'], $id); ?>><?php echo $args['name'] ?></option><?php
				}
				
			?></select>
			</td>
		</tr>
	</table>
	
	<p>
		<input type="hidden" name="redirect" value="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&tab=content-seo&settings-updated='); ?>" />
		<input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" />
	</p>
	
</form>
<?php
/*
 * WPAuthorities Settings page
 * General Tab
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
	<h3><?php _e('Business Builder Template', 'wpa'); ?></h3>
	
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="bb_builder_page">Business Builder Page</label></th>
			<td><select name="awp_settings[bb_builder_page]" id="bb_builder_page">
				<option value="0" <?php selected($settings['bb_builder_page'], 0) ?>>None</option><?php
				$pages = get_pages();
				foreach ( $pages as $page ) {
					?><option value="<?php echo $page->ID; ?>" <?php selected($settings['bb_builder_page'], $page->ID); ?>><?php echo $page->post_title; ?></option><?php
				}
			?></select></td>
		</tr>
	</table>
	
	<h3><?php _e('Sites Managed Display', 'wpa'); ?></h3>
	
	<table class="form-table">
		<tr valign="top">
			<th scope="row">
				<label for="wpa_hide_timestamp"><?php _e('Display Settings', 'wpa'); ?></label>
			</th>
			<td>
				<label><input type="checkbox" name="awp_settings[hide_timestamp]" id="wpa_hide_timestamp" value="true" <?php checked($settings['hide_timestamp'], 'true'); ?> class="regular-check" />
				<?php _e('Hide Timestamp !Status tags from the admin sites table.'); ?></label>
			</td>
		</tr>
	</table>
	
	<h3><?php _e('WordPress Authority Qualification Settings', 'wpa'); ?></h3>
	
	<table class="form-table">
		<tr>
			<th scope="row">
			</th>
		</tr>
	</table>
	
	<p>
		<input type="hidden" name="wpas_tab_identifier" value="<?php echo $tab; ?>" />
		<input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" />
	</p>
</form>
<?php
/*
 * WPAuthorities Settings page
 * Templates Tab
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
	<h3><?php _e('Sites Archive Display', 'wpas'); ?></h3>
	
	<table class="form-table">
    	<tr valign="top">
        	<th scope="row"><label for="sites_default_order"><?php _e('Default Sort Order', 'wpas'); ?></label></th>
            <td>
            	<select name="awp_settings[sites_default_order]" id="sites_default_order">
                	<option value="asc" <?php selected($settings['sites_default_order'], 'asc'); ?>>Ascending</option>
                	<option value="desc" <?php selected($settings['sites_default_order'], 'desc'); ?>>Descending</option>
                </select>
            </td>
        </tr>
        <tr valign="top">
        	<th scope="row"><label for="sites_default_orderby"><?php _e('Default Sort Field', 'wpas'); ?></label></th>
            <td>
            	<select name="awp_settings[sites_default_orderby]" id="sites_default_orderby">
                	<option value="id" <?php selected($settings['sites_default_orderby'], 0); ?>>None</option>
                	<option value="awp-alexa-rank" <?php selected($settings['sites_default_orderby'], 'awp-alexa-rank'); ?>>Alexa Rank</option>
                    <option value="awp-authority-rank" <?php selected($settings['sites_default_orderby'], 'awp-authority-rank'); ?>>Authority Rank</option>
                    <option value="title" <?php selected($settings['sites_default_orderby'], 'title'); ?>>Title</option>
                </select>
            </td>
        </tr>
		<tr valign="top">
			<th scope="row"><label for="action_taxonomy_type"><?php _e('Exclude or Include Types', 'wpas'); ?></label></th>
			<td>
				<select name="awp_settings[action_taxonomy_type]" id="action_taxonomy_type">
					<option value="0" <?php selected($settings['action_taxonomy_type'], 0); ?>>None</option>
					<option value="NOT IN" <?php selected($settings['action_taxonomy_type'], 'NOT IN'); ?>>Exclude</option>
					<option value="IN" <?php selected($settings['action_taxonomy_type'], 'IN'); ?>>Include</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="">$Types to Omit from Sites Archive:</label><br>
			<small class="description">Chosse terms to include or exclude.</small></th>
			<td><?php
				$types = get_terms('site-type', array(
					'orderby'       => 'name', 
					'order'         => 'ASC',
					'hide_empty'    => false
				));
				
				if(!$settings['xtype'])
					$settings['xtype'] = array();
				
				foreach($types as $tm){
					$checked = in_array($tm->slug, $settings['xtype']) ? 'checked="checked"' : '';
					?><label><input type="checkbox" name="awp_settings[xtype][]" value="<?php echo $tm->slug ?>" <?php echo $checked; ?> /> <?php echo $tm->name; ?> </label><br><?php
				}
			?></td>
		</tr>
		<tr>
			<th scope="row"><label for="action_taxonomy_status">Exclude or Include Statuses</label></th>
			<td>
				<select name="awp_settings[action_taxonomy_status]" id="action_taxonomy_status">
					<option value="0" <?php selected($settings['action_taxonomy_status'], 0); ?>>None</option>
					<option value="NOT IN" <?php selected($settings['action_taxonomy_status'], 'NOT IN'); ?>>Exclude</option>
					<option value="IN" <?php selected($settings['action_taxonomy_status'], 'IN'); ?>>Include</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="">!Statuses to Omit from Sites Archive:</label><br>
			<small class="description">Choose terms to include or exclude.</small></th>
			<td><?php
				$types = get_terms('site-status', array(
					'orderby'       => 'name', 
					'order'         => 'ASC',
					'hide_empty'    => false
				));
				
				if(!$settings['xStatus'])
					$settings['xStatus'] = array();
				
				foreach($types as $tm){
					$checked = in_array($tm->slug, $settings['xStatus']) ? 'checked="checked"' : '';
					?><label><input type="checkbox" name="awp_settings[xStatus][]" value="<?php echo $tm->slug ?>" <?php echo $checked; ?> /> <?php echo $tm->name; ?> </label><br><?php
				}
			?></td>
		</tr>
	</table>
    
    <p>
    	<input type="hidden" name="redirect" value="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&tab=templates&settings-updated='); ?>" />
		<input type="hidden" name="wpas_tab_identifier" value="<?php echo $tab; ?>" />
		<input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" />
	</p>
    
</form>
<?php
/*
 * WPAuthorities Settings page
 * Add Metrics Group Tab
 */

global $options;
$options = get_option('awp_options');
$settings = get_option('awp_settings');
$websites = get_option('awp_websites');

$tab = $_REQUEST['tab'] ? $_REQUEST['tab'] : 'action';

// wpas_metrics_subnav();

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

$field = false;
if( isset($_REQUEST['id']) && '' != $_REQUEST['id'] ){
    $field = wpa_get_metrics_by_id($_REQUEST['id']);
}

$editable = ($field['readonly']) ? false : true;

?><form name="awp_settings" method="post" action="<?php echo admin_url('edit.php?post_type=site&page=wpauthority'); ?>">

	<h2><em><?php echo $field['name']; ?></em>: metric details</h2>
	
    <table class="form-table">
    	<tr valign="top">
        	<th scope="row"><label for="wpas_description"><?php _e('Description', 'wpas'); ?></label></th>
            <td><textarea rows="5" cols="40" name="wpa_metrics[description]" id="wpas_description"><?php echo ($field['desc']) ? $field['desc'] : ''; ?></textarea></td>
        </tr>
        
        <tr valign="top">
        	<th scope="row"><label for="wpas_data_source"><?php _e('Data Source', 'wpas'); ?></label></th>
            <td><input class="regular-text" type="text" name="wpa_metrics[data_source]" id="wpas_data_source" value="<?php echo ($field['data_source']) ? $field['data_source'] : ''; ?>" /></td>
        </tr>
        
        <tr valign="top">
        	<th scope="row"><label for="wpas_unit"><?php _e('Unit', 'wpas'); ?></label></th>
            <td><input class="regular-text" type="text" name="wpa_metrics[unit]" id="wpas_unit" value="<?php echo ($field['unit']) ? $field['unit'] : ''; ?>" /></td>
        </tr>
        
        <tr valign="top">
        	<th scope="row"><label for="wpas_tip"><?php _e('ToolTip Content', 'wpas'); ?></label></th>
            <td><textarea rows="5" cols="40" type="text" name="wpa_metrics[tip]" id="wpas_tip"><?php echo ($field['tip']) ? $field['tip'] : ''; ?></textarea></td>
        </tr>
        
        <tr valign="top">
        	<th scope="row"><label for="wpas_metric_type"><?php _e('Metric Type', 'wpas'); ?></label></th>
            <td><select name="wpa_metrics[metric_type]" id="wpas_metric_type">
                	<option value="authority" <?php selected($field['metric_type'], 'authority'); ?>>Authority</option>
                    <option value="site" <?php selected($field['metric_type'], 'site'); ?>>Site</option>
                	<option value="wordpress" <?php selected($field['metric_type'], 'wordpress'); ?>>Wordpress</option>
                </select>
            </td>
        </tr>
    </table>
    
    <input type="hidden" name="metric_id" value="<?php echo $field['id']; ?>" />
    <input type="hidden" name="wpa_metrics[name]" value="<?php echo $field['name']; ?>" />
    <input type="hidden" name="wpa_metrics[id]" value="<?php echo $field['id']; ?>" />
    <input type="hidden" name="wpa_metrics[type]" value="<?php echo $field['type']; ?>" />
    <input type="hidden" name="wpa_metrics[group]" value="<?php echo $field['group']; ?>" /><?php
    
    if($field['readonly']){
        ?><input type="hidden" name="wpa_metrics[readonly]" value="1" /><?php
    }
    
    if($field['programmatic']){
        ?><input type="hidden" name="wpa_metrics[programmatic]" value="1" /><?php
    }
	
	if($field['format']){
		?><input type="hidden" name="wpa_metrics[format]" value="<?php echo $field['format']; ?>" /><?php
	}
	
	if($field['meta_value']){
		?><input type="hidden" name="wpa_metrics[format]" value="<?php echo $field['meta_value']; ?>" /><?php
	}
	
	if($field['link_text']){
		?><input type="hidden" name="wpa_metrics[format]" value="<?php echo $field['link_text']; ?>" /><?php
	}
	
	if($field['score']){
		?><input type="hidden" name="wpa_metrics[score]" value="1" /><?php
	}
    
    ?><input type="submit" value="Save Field" class="button-primary" id="submit" name="wpa_save_metric" />
</form>
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

wpas_metrics_subnav();

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
    <div class="new-metric-wrapper">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="wpa_metrics_label">Field Label</label></th>
                <td><input type="text" name="wpa_metrics[name]" id="wpa_metrics_label" value="<?php echo ($field['name']) ? $field['name'] : ''; ?>" <?php echo (!$editable) ? 'readonly="readonly"' : '' ?> class="regular-text" /><br>
                <span class="description"></span></td>
            </tr>
            <tr>
                <th scope="row"><label for="wpa_metrics_name">Field Name</label></th>
                <td><input type="text" name="wpa_metrics[id]" id="wpa_metrics_name" value="<?php echo ($field['id']) ? $field['id'] : ''; ?>" <?php echo (!$editable) ? 'readonly="readonly"' : '' ?> class="regular-text" /><br>
                <span class="description"></span></td>
            </tr>
            <tr>
                <th scope="row"><label for="wpa_metrics_type">Field Type</label></th>
                <td><?php
                    if(!$editable){
                        ?><input type="text" name="wpa_metrics[type]" id="wpa_metrics_type" class="regular-text" value="<?php echo ($field['type']) ? $field['type'] : ''; ?>" readonly /><?php
                    } else {
                        ?><select name="wpa_metrics[type]" id="wpa_metrics_type" <?php echo (!$editable) ? 'disabled="disabled"' : '' ?>>
                            <option value="text" <?php selected($field['type'], 'text'); ?>>Text</option>
                            <option value="textarea" <?php selected($field['type'], 'textarea'); ?>>Texarea</option>
                            <option value="checkbox2" <?php selected($field['type'], 'checkbox2'); ?>>Checkbox</option>
                            <option value="radio" <?php selected($field['type'], 'radio'); ?>>Radio</option>
                            <option value="select" <?php selected($field['type'], 'select'); ?>>Select</option>
                        </select><?php
                    }
                    ?><br><span class="description"></span>
                </td>
            </tr>
            
            <tr id="wpa-options-row" style="display:<?php echo ($field['options']) ? 'table-row' : 'none'; ?>;">
                <th scope="row"><label for="wpa_metrics_options">Field Options</label></th>
                <td><textarea name="wpa_metrics[options]" id="wpa_metrics_options" class="regular-textarea" <?php echo (!$editable) ? 'readonly="readonly"' : '' ?>><?php
                    echo ($field['options']) ? implode('|', $field['options']) : '';
                ?></textarea><br>
                <span class="description"><?php _e('Separate each option using a pipe "|" without spaces.', 'wpa'); ?></span></td>
            </tr>
            
            <tr>
                <th scope="row"><label for="wpa_metrics_group">Field Group</label></th>
                <td><?php
                    if(!$editable){
                        ?><input type="text" name="wpa_metrics[group]" id="wpa_metrics_group" class="regular-text" value="<?php echo ($field['group']) ? $field['group'] : ''; ?>" readonly /><?php
                    } else {
                        ?><select name="wpa_metrics[group]" id="wpa_metrics_group" <?php echo (!$editable) ? 'disabled="disabled"' : '' ?>><?php
                            $metricsGroup = wpa_get_metrics_groups();
                            foreach($metricsGroup as $group){
                                ?><option value="<?php echo $group['id']; ?>" <?php selected($field['group'], $group['id']); ?>><?php echo $group['name']; ?></option><?php
                            }
                        ?></select><?php
                    }
                    ?><br><span class="description"></span>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="wpa_metrics_tip">Field Instructions</label></th>
                <td><textarea name="wpa_metrics[tip]" id="wpa_metrics_tip" class="regular-textarea"><?php echo ($field['tip']) ? $field['tip'] : ''; ?></textarea><br>
                <span class="description"></span></td>
            </tr>
            <tr>
                <th scope="row"><label for="wpa_metrics_desc">Meta Description</label></th>
                <td><textarea name="wpa_metrics[desc]" id="wpa_metrics_desc" class="regular-textarea"><?php echo ($field['desc']) ? $field['desc'] : ''; ?></textarea><br>
                <span class="description"></span></td>
            </tr>
            <tr>
                <th scope="row"><label for="wpa_metrics_required">Required</label></th>
                <td>
                <label><input type="radio" name="wpa_metrics[required]" id="wpa_metrics_required" value="true" <?php checked($field['required'], 'true'); ?> /> Yes</label>
                <label><input type="radio" name="wpa_metrics[required]" id="wpa_metrics_required" value="false" <?php checked($field['required'], 'false'); ?> /> No</label>
                <br>
                <span class="description"></span></td>
            </tr>
            <tr>
                <th scope="row"><label for="wpa_metrics_std">Default Value</label></th>
                <td><input type="text" name="wpa_metrics[value]" id="wpa_metrics_std" value="<?php echo ($field['std']) ? $field['std'] : ''; ?>" class="regular-text" /><br>
                <span class="description"></span></td>
            </tr>
        </table>
        <p><?php
            if(!$editable){
                ?><input type="hidden" name="readonly" value="1" /><?php
            }
            ?><input type="hidden" name="redirect" value="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&tab=metrics&settings-updated='); ?>" /><?php
            
            if($field){
                ?><input type="hidden" name="metric_id" value="<?php echo $field['id']; ?>" />
                <input type="submit" value="Save Field" class="button-primary" id="submit" name="wpa_save_metric" /><?php
            } else {
                ?><input type="submit" value="+ Add Field" class="button-primary" id="submit" name="wpa_save_metric" /><?php
            }
        ?></p>
    </div><!-- /new-metric-wrapper -->
</form>
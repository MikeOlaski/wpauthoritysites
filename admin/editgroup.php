<?php
/*
 * WPAuthorities Settings page
 * Edit Metrics Group Tab
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

$group = false;
if( isset($_REQUEST['id']) && '' != $_REQUEST['id'] ){
    $group = wpa_get_metrics_group_by_id($_REQUEST['id']);
}

$editable = ($group['readonly']) ? true : false;

?><form name="awp_settings" method="post" action="<?php echo admin_url('edit.php?post_type=site&page=wpauthority'); ?>">
    <div class="new-metric-wrapper">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="wpa_metrics_label">Group Label</label></th>
                <td><input type="text" name="wpa_metrics[name]" id="wpa_metrics_label" value="<?php echo ($group['name']) ? $group['name'] : ''; ?>" <?php echo ($editable) ? 'readonly="readonly"' : '' ?> class="regular-text" /><br>
                <span class="description"></span></td>
            </tr>
            <tr>
                <th scope="row"><label for="wpa_metrics_name">Group Name</label></th>
                <td><input type="text" name="wpa_metrics[id]" id="wpa_metrics_name" value="<?php echo ($group['id']) ? $group['id'] : ''; ?>" <?php echo ($editable) ? 'readonly="readonly"' : '' ?> class="regular-text" /><br>
                <span class="description"></span></td>
            </tr>
            <tr>
                <th scope="row"><label for="wpa_metrics_cat">Group Category</label></th>
                <td><select name="wpa_metrics[category]" id="wpa_metrics_cat">
                    <option value="departments" <?php selected($group['category'], 'departments'); ?>>Departments</option>
                    <option value="signals" <?php selected($group['category'], 'signals'); ?>>Signals</option>
                    <option value="valuation" <?php selected($group['category'], 'valuation'); ?>>Valuation</option>
                </select><br>
                <span class="description"></span></td>
            </tr>
            <tr>
                <th scope="row"><label for="wpa_metrics_desc">Meta Description</label></th>
                <td><textarea name="wpa_metrics[desc]" id="wpa_metrics_desc" class="regular-textarea"><?php echo ($group['desc']) ? $group['desc'] : ''; ?></textarea><br>
                <span class="description"></span></td>
            </tr>
        </table>
        <p><?php
            if($editable){
                ?><input type="hidden" name="readonly" value="1" /><?php
            }
            
            ?><input type="hidden" name="type" value="heading" />
            <input type="hidden" name="redirect" value="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&tab=groups&settings-updated=true'); ?>" /><?php
            
            if($group){
                ?><input type="hidden" name="group_id" value="<?php echo $group['id'] ?>" />
                <input type="submit" value="Save Group" class="button-primary" id="submit" name="wpa_save_group" /><?php
            } else {
                ?><input type="submit" value="+ Add Group" class="button-primary" id="submit" name="wpa_save_group" /><?php
            }
            
        ?></p>
    </div><!-- /new-metric-wrapper -->
</form>
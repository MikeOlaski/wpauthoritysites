<?php
/*
 * WPAuthorities Settings page
 * Cron Tab
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
    
    <h3>Cron Settings</h3>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="cronjob">Cronjob</label></th>
            <td>
                <input type="checkbox" name="awp_settings[cronjob]" id="cronjob" value="true" <?php checked($settings['cronjob'], 'true'); ?> />
                <label for="cronjob">Enable Cronjob</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="rank_page">Link to get page ranking</label></th>
            <td>
                <input type="text" name="awp_settings[rank_page]" id="rank_page" value="<?php echo $settings['rank_page'] ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="request_limit">Page ranking request limit</label></th>
            <td>
                <input type="text" name="awp_settings[request_limit]" id="request_limit" value="<?php echo $settings['request_limit'] ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="scrape_link">Link for wordpress scraping</label></th>
            <td>
                <input type="text" name="awp_settings[scrape_link]" id="scrape_link" value="<?php echo $settings['scrape_link'] ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="scrape_limit">Scraping limit per request</label></th>
            <td>
                <input type="text" name="awp_settings[scrape_limit]" id="scrape_limit" value="<?php echo $settings['scrape_limit'] ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    
    <p>
        <input type="hidden" name="redirect" value="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&tab=cron&settings-updated='); ?>" />
        <input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" />
    </p>
    
</form>
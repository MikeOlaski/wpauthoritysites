<?php
/*
 * WPAuthorities Settings page
 * Connect API Tab
 */

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
    <h3>Compete</h3>
    
    <table class="form-table">
        <tr>
            <th scope="row"><label for="compete_api_key">API Key</label></th>
            <td><input type="text" name="awp_settings[compete_api_key]" id="compete_api_key" value="<?php echo $settings['compete_api_key']; ?>" class="regular-text" /><br />
            <span class="description">You can get your api service <a href="https://developer.compete.com/" target="_blank">here.</a></td>
        </tr>
    </table>
    
    <h3>Majestic</h3>
    
    <table class="form-table">
        <tr>
            <th scope="row"><label for="majestic_api_key">API Key</label></th>
            <td><input type="text" name="awp_settings[majestic_api_key]" id="majestic_api_key" value="<?php echo $settings['majestic_api_key']; ?>" class="regular-text" /><br />
            <span class="description">You can get your api service <a href="https://www.majesticseo.com/account/api/" target="_blank">here</a></td>
        </tr>
    </table>
    
    <h3>Alexa</h3>
    
    <table class="form-table">
        <tr>
            <th scope="row"><label for="access_id">Access ID Key:</label></th>
            <td>
                <input type="text" name="awp_settings[access_id]" id="access_id" value="<?php echo $settings['access_id']; ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="access_secret">Secret Access Key</label></th>
            <td>
                <input type="text" name="awp_settings[access_secret]" id="access_secret" value="<?php echo $settings['access_secret'] ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="StartNum">Default Starting Rank:</label></th>
            <td>
                <input type="text" name="awp_settings[StartNum]" id="StartNum" value="<?php echo $settings['StartNum'] ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cronLimit">Default Number of Site Rank Request</label></th>
            <td>
                <input type="text" name="awp_settings[cronLimit]" id="cronLimit" value="<?php echo $settings['cronLimit'] ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    
    <h3>GrabzIT</h3>
    <p>You can get you app API credentials from <a href="http://grabz.it/" target="_blank">grabz.it</a></p>
    
    <table class="form-table">
        <tr>
            <th scope="row"><label for="grabzit_api_key">API Key</label></th>
            <td><input class="regular-text" type="text" name="awp_settings[grabzit_api_key]" id="grabzit_api_key" value="<?php echo $settings['grabzit_api_key'] ?>" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="grabzit_api_secret">API Secret</label></th>
            <td><input class="regular-text" type="text" name="awp_settings[grabzit_api_secret]" id="grabzit_api_secret" value="<?php echo $settings['grabzit_api_secret'] ?>" /></td>
        </tr>
    </table>
    
    <p><input type="hidden" name="redirect" value="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&tab=connect&settings-updated='); ?>" />
    <input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" /></p>
</form>
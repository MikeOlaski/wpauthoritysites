<?php
$tabs = array(
	'general' => 'General',
	'manage' => 'Manage Subscription',
	'form' => 'Subscribe Form',
	'page' => 'Manage Page',
	'notification' => 'Notifications'
);

$current_nav = isset($_GET['tab']) ? $_GET['tab'] : 'general';
$wpas_subscribe = get_option('wpas_subscribe');
$wpas_notification = $wpas_subscribe['notification'];

?><h2 class="nav-tab-wrapper supt-nav-tab-wrapper"><?php
    foreach($tabs as $tab=>$nav){
        $classes = array('nav-tab');
        $classes[] = ($current_nav == $tab) ? 'nav-tab-active' : null;
        
        ?><a href="<?php echo admin_url('edit.php?post_type=site&page=wpas_site_subscribers&tab=' . $tab); ?>" class="<?php echo implode(' ', $classes); ?>"><?php echo $nav; ?></a><?php
    }
?></h2>

<div>&nbsp;</div><?php

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

switch($current_nav){
	case 'general':
		_e('Custom options', 'wpas');
	break;
	
	case 'manage':
		wpas_subscribers_manager(); break;
	
	case 'form':
		_e('Subscription Form', 'wpas');
	break;
	
	case 'page':
		_e('Subscription page options');
	break;
	
	case 'notification':
		?><h3><?php _e('Options', 'wpas'); ?></h3>
        
        <form name="wpas_subscription_notification" method="post" action="<?php echo get_permalink(); ?>">
            <table class="form-table">
                <tr valign="top">
                    <th><label for="wpas_subscribe_sender_name"><?php _e('Sender Name', 'wpas'); ?></label></th>
                    <td><input type="text" name="wpas_subscribe[sender_name]" id="wpas_subscribe_sender_name" value="<?php echo ($wpas_notification['sender_name']) ? $wpas_notification['sender_name'] : ''; ?>" class="regular-text" /><br />
                    <span class="description"><?php _e('Name to use for the "from" field when sending a new notification to the user.', 'wpas'); ?></span></td>
                </tr>
                
                <tr valign="top">
                    <th><label for="wpas_subscribe_sender_email"><?php _e('Sender email address', 'wpas'); ?></label></th>
                    <td><input type="text" name="wpas_subscribe[sender_email]" id="wpas_subscribe_sender_email" value="<?php echo ($wpas_notification['sender_email']) ? $wpas_notification['sender_email'] : ''; ?>" class="regular-text" /><br />
                    <span class="description"><?php _e('Email address to use for the "from" field when sending a new notification to the user.', 'wpas'); ?></span></td>
                </tr>
            </table>
            
            <h3><?php _e('Messages', 'wpas'); ?></h3>
            
            <table class="form-table">
                <tr valign="top">
                    <th><label for="wpas_subscribe_email_subject"><?php _e('Notification subject', 'wpas'); ?></label></th>
                    <td><input type="text" name="wpas_subscribe[email_subject]" id="wpas_subscribe_email_subject" value="<?php echo ($wpas_notification['email_subject']) ? $wpas_notification['email_subject'] : ''; ?>" class="regular-text" /><br />
                    <span class="description"><?php _e('Subject of the notification email. Allowed tag: [post_title]', 'wpas'); ?></span></td>
                </tr>
                
                <tr valign="top">
                    <th><label for="wpas_subscribe_email_content"><?php _e('Notification message', 'wpas'); ?></label></th>
                    <td><textarea cols="40" rows="5" name="wpas_subscribe[email_content]" id="wpas_subscribe_email_content"><?php echo ($wpas_notification['email_content']) ? $wpas_notification['email_content'] : ''; ?></textarea><br />
                    <span class="description"><?php _e('Content of the notification email. Allowed tags: [post_title], [post_permalink], [post_author], [post_content], [manager_link], [change]', 'wpas'); ?></span></td>
                </tr><?php
                
                /*<tr valign="top">
                    <th><label for="wpas_subscribe"><?php _e('', 'wpas'); ?></label></th>
                    <td><input type="text" name="wpas_subscribe[]" id="wpas_subscribe" value="<?php echo ($wpas_subscribe['']) ? $wpas_subscribe[''] : ''; ?>" class="regular-text" />
                    <span class="description"><?php _e('', 'wpas'); ?></span></td>
                </tr>*/ ?>
            </table>
            
            <h3>Welcome Message</h3>
            
            <table class="form-table">
            	<tr valign="top">
                    <th><label for="wpas_subscribe_welcome_subject"><?php _e('Welcome subject', 'wpas'); ?></label></th>
                    <td><input type="text" name="wpas_subscribe[welcome_subject]" id="wpas_subscribe_welcome_subject" value="<?php echo ($wpas_notification['welcome_subject']) ? $wpas_notification['welcome_subject'] : ''; ?>" class="regular-text" /><br />
                    <span class="description"><?php _e('Subject of the welcome email for new subscribers. Allowed tag: [post_title]', 'wpas'); ?></span></td>
                </tr>
                
                <tr valign="top">
                    <th><label for="wpas_subscribe_welcome_content"><?php _e('Welcome message', 'wpas'); ?></label></th>
                    <td><textarea cols="40" rows="5" name="wpas_subscribe[welcome_content]" id="wpas_subscribe_welcome_content"><?php echo ($wpas_notification['welcome_content']) ? $wpas_notification['welcome_content'] : ''; ?></textarea><br />
                    <span class="description"><?php _e('Content of the welcome email for new subscribers. Allowed tags: [post_title], [post_permalink], [post_author], [post_content], [manager_link], [change]', 'wpas'); ?></span></td>
                </tr>
            </table>
            
            <p><input type="hidden" name="wpas_tab_identifier" value="notification">
            <input type="submit" value="Update option" class="button-primary" id="submit" name="wpas_subscribe_submit"></p>
		
		</form><?php
		
	break;
}
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

$post_types = array('site', 'interviews', 'reviews', 'shows', 'feed');

?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>">
	<h3><?php _e('WPAS Display Settings', 'wpas'); ?></h3>
	
	<table class="form-table"><?php 
		
		foreach($post_types as $type){
			?><tr valign="top">
				<th scope="row"><label for="default_<?php echo $type; ?>_image"><?php _e('Default ' . ucwords($type) . ' thumbnail', 'wpas'); ?></label></th>
				<td>
					<input class="regular-text" type="text" name="awp_settings[default_<?php echo $type; ?>_image]" id="default_<?php echo $type; ?>_image" value="<?php echo ($settings['default_' . $type . '_image']) ? $settings['default_' . $type . '_image'] : ''; ?>" />
					<span class="button upload_media_btn" id="default_<?php echo $type; ?>_image_button">Upload</span><?php
					
					if($settings['default_' . $type . '_image']){
						echo sprintf(
							'<br /><span class="description"><img src="%s" alt="%s" width="300" id="default_' . $type . '_image_preview" /></span>',
							$settings['default_' . $type . '_image'], __('Default thumbnail','wpas')
						);
					}
				?></td>
			</tr><?php
		}
		
    ?></table>
    
    <p>
    	<input type="hidden" name="redirect" value="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&tab=display&settings-updated='); ?>" />
		<input type="hidden" name="wpas_tab_identifier" value="<?php echo $tab; ?>" />
		<input type="submit" value="Update option" class="button-primary" id="submit" name="awp_submit" />
	</p>
    
</form>

<script type="text/javascript">
	jQuery(document).ready(function($){
		var _custom_media = true,
		_orig_send_attachment = wp.media.editor.send.attachment;
	
	$('.upload_media_btn').click(function(e) {
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = $(this);
		var id = button.attr('id').replace('_button', '');
		var preview = button.attr('id').replace('_button', '_preview');
		_custom_media = true;
	
		wp.media.editor.send.attachment = function(props, attachment){
			if ( _custom_media ) {
				$("#"+id).val(attachment.url);
				$("#"+preview).attr('src', attachment.url);
			} else {
				return _orig_send_attachment.apply( this, [props, attachment] );
			};
		}
		
		wp.media.editor.open(button);
		return false;
	});
	
	$('.add_media').on('click', function(){
		_custom_media = false;
	});
});
</script>
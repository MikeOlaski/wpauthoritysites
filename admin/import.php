<h2><?php _e('Import', 'wpa'); ?></h2><div>&nbsp;</div><?php
        
if( isset( $_REQUEST['settings-updated'] ) ){
	if( $_REQUEST['settings-updated'] == 'true' ){
		?><div id="setting-error" class="updated settings-error">
			<p><strong>Request complete. links was recorded to the database.</strong></p>
		</div><?php
	} else {
		?><div id="setting-error" class="error settings-error">
			<p><strong><?php
				switch($_REQUEST['message']){
					case '1':
						_e('Request unseccessful. Please setup the <a href="'. admin_url('admin.php?page=wpauthority') .'">API Settings</a>.');
						break;
					case '2':
						_e('Request unseccessful. API Server error.');
						break;
					case '3':
						_e('Upload error. file is broken.');
						break;
					case '4':
						_e('Please upload a valid CSV file.');
						break;
					case '5':
						_e('Error. No file choosen.');
						break;
					default:
						_e('Request unsuccesful. 0 links recorded.');
						break;
				}
			?></strong></p>
		</div><?php
	}
}

?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>" enctype="multipart/form-data">

	<h3>Alexa AWIS API Request</h3>
	
	<table class="form-table">
		<tr>
			<th scope="row"><label for="subject"><strong>Subject Name</strong></label></th>
			<td>
				<input type="text" name="subject" id="subject" value="" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="rank_start"><strong>Start on Rank</strong></label></th>
			<td>
				<input type="text" name="rank_start" id="rank_start" value="" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="request_limit"><strong>Number of Request</strong></label></th>
			<td>
				<input type="text" name="request_limit" id="request_limit" value="" class="regular-text" /><br />
				<span class="description">Response time depends on the number of request.</span>
			</td>
		</tr>
	</table>
	
	<p><input type="submit" value="Make Request" class="button-primary" id="submit" name="awp_request" /></p>
	
	<h3>Import a CSV</h3>
	
	<table class="form-table">
		<tr valign="top" style="display:none;">
			<th scope="row" colspan="2"><label>
				<input type="checkbox" id="has_custom_row" value="1" /> <?php _e('Start on a custom row'); ?>
			</label></th>
		</tr>
		
		<tr valign="top" class="csv_cutom_row" style="display:none;">
			<th scope="row"><label for="row_start"><strong><?php _e('Starting row'); ?></strong></label></th>
			<td><input type="text" name="csv_start_row" id="row_start" value="" /></td>
		</tr>
		
		<tr valign="top" class="csv_cutom_row" style="display:none;">
			<th scope="row"><label for="row_end"><strong><?php _e('End row'); ?></strong></label></th>
			<td><input type="text" name="csv_limit_row" id="row_end" value="" /></td>
		</tr>
		
		<tr valign="top">
			<th scope="row">
				<label for="awp_file"><strong>Upload CSV</strong></label><br>
				<small class="description"><a href="<?php echo PLUGINURL; ?>/uploads/cron.csv" target="_blank">Click here</a> to download a sample CSV file format.</small>
			</th>
			<td align="top">
				<input type="file" name="awp_file" id="awp_file" value="" class="regular-text" />
				<input type="submit" value="Upload" class="button-primary" id="submit" name="awp_upload" />
				<br /><span class="description">Maximum of <?php echo (int)(ini_get('upload_max_filesize')); ?>mb filesize.</span>
			</td>
		</tr>
	</table>
	
	<h3>Bulk Add Import</h3>
	
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="awp_domain"><strong><?php _e('Domains', 'wpa'); ?></strong></label><br>
				<small class="description">One per line</small>
			</th>
			<td><textarea name="awp_domain" id="awp_domain" class="large-text" rows="7"></textarea></td>
		</tr>
		<tr>
			<th scope="row">
				<label for="awp_domain_tags"><strong><?php _e('Tags', 'wpa'); ?></strong></label><br>
				<small class="description">Separate each tag with comma</small>
			</th>
			<td>
				<input type="text" name="awp_domain_tags" id="awp_domain_tags" class="regular-text" value="" />
			</td>
		</tr>
	</table>
	
	<p><input type="submit" value="Import Domains" class="button-primary" id="submit" name="awp_import_domain" /></p>
	
	<h3><?php _e('BuySellAds – Crawler', 'wpa'); ?></h3>
	
	<table class="form-table">
	
	</table>
	
	<h3><?php _e('Technorati Crawler', 'wpa'); ?></h3>
	
	<table class="form-table">
	
	</table>
	
</form>
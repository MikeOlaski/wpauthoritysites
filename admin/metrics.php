<?php
/*
 * Site Metrics admin page
 */

global $options;
$options = get_option('awp_options');
$settings = get_option('awp_settings');
$websites = get_option('awp_websites');

$tab = $_REQUEST['tab'] ? $_REQUEST['tab'] : 'action';

// wpas_metrics_subnav();

if( isset( $_REQUEST['settings-updated'] ) ){
    if( $_REQUEST['settings-updated'] == 'true' ){
        ?><div id="setting-error" class="updated settings-error clear">
            <p><strong><?php _e('Settings saved.'); ?></strong></p>
        </div><?php
    } else {
        ?><div id="setting-error" class="error settings-error clear">
            <p><strong><?php _e('Settings not saved.'); ?></strong></p>
        </div><?php
    }
}

?><form name="awp_settings" method="post" action="<?php admin_url('edit.php?post_type=site&page=wpauthority'); ?>"><?php
    
    $metrics = wpa_default_metrics();
        
	?><table class="wp-list-table widefat fixed posts" cellpadding="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
					<input id="cb-select-all-1" type="checkbox">
				</th>
				<th scope="col" class="manage-column name-column"><?php _e('Name', 'wpa'); ?></th>
				<th scope="col" class="manage-column description-column"><?php _e('Description', 'wpa'); ?></th>
				<th scope="col" class="manage-column id-column"><?php _e('ID', 'wpa'); ?></th>
				<th scope="col" class="manage-column type-column"><?php _e('Type', 'wpa'); ?></th>
				<th scope="col" class="manage-column group-column"><?php _e('Group', 'wpa'); ?></th>
			</tr>
		</thead>
		
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column">
					<label class="screen-reader-text" for="cb-select-all-2">Select All</label>
					<input id="cb-select-all-2" type="checkbox">
				</th>
				<th scope="col" class="manage-column name-column"><?php _e('Name', 'wpa'); ?></th>
				<th scope="col" class="manage-column description-column"><?php _e('Description', 'wpa'); ?></th>
				<th scope="col" class="manage-column id-column"><?php _e('ID', 'wpa'); ?></th>
				<th scope="col" class="manage-column type-column"><?php _e('Type', 'wpa'); ?></th>
				<th scope="col" class="manage-column group-column"><?php _e('Group', 'wpa'); ?></th>
			</tr>
		</tfoot>
		
		<tbody><?php
			foreach($metrics as $cfields){
				if('heading' == $cfields['type'] || 'separator' == $cfields['type']){
					continue;
				} else {
					?><tr>
						<th scope="col" class="manage-column check-column">
							<label class="screen-reader-text" for="cb-select-1">Select this Item</label>
							<input name="custom_metrics" id="cb-select-1" type="checkbox" value="<?php echo $cfields['id']; ?>" />
						</th>
						<td>
							<a href="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&tab=editmetric&id=' . $cfields['id']); ?>"><strong><?php echo $cfields['name']; ?></strong></a>
							<div class="row-actions">
								<span class="edit"><a href="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&tab=editmetric&id=' . $cfields['id']); ?>" title="Edit this item">Edit</a><?php
								
								if($cfields['readonly'] == false){
									?> | </span><span class="trash">
										<a class="submitdelete" title="Delete Item" href="<?php echo admin_url('edit.php?post_type=site&page=wpauthority&metric_action=delete&id='.$cfields['id']); ?>">Delete</a>
									</span><?php
								} else {
									?></span><?php
								}
								
							?></div>
						</td>
						<td><?php echo $cfields['description']; ?></td>
						<td><?php echo $cfields['id']; ?></td>
						<td><?php echo $cfields['type']; ?></td>
						<td><?php echo $cfields['group']; ?></td>
					</tr><?php
				}
			}
		?></tbody>
	</table>

</form>
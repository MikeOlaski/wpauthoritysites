<?php
/*
 * WPAS Subscriber/Watch plugin
 */

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Subscribers_List extends WP_List_Table {
	
	var $example_data;
	
	function get_columns(){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'name' => 'Name',
			'email' => 'Email',
			'post' => 'Post',
			'status' => 'Status',
			'date' => 'Date'
		);
		return $columns;
	}
	
	function get_sortable_columns() {
		$sortable_columns = array(
			'email' => array('email', false),
			'date' => array('date', false),
			'post' => array('post', false),
			'name' => array('name', false)
		);
		return $sortable_columns;
	}
	
	function column_cb( $item ){
		echo sprintf(
			'<label class="screen-reader-text" for="cb-select-%s">Select %s</label>',
			$item['subscriber_id'],
			$item['fname'] . ' ' . $item['lname']
		);
		echo sprintf('<input id="cb-select-%1$s" type="checkbox" name="cpt[]" value="%1$s">', $item['subscriber_id']);
		echo '<div class="locked-indicator"></div>';
	}
	
	function usort_reorder( $a, $b ) {
		// If no sort, default to title
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'booktitle';
		// If no order, default to asc
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
		// Determine sort order
		$result = strcmp( $a[$orderby], $b[$orderby] );
		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : -$result;
	}
	
	function column_default( $item, $column_name ) {
		switch( $column_name ) { 
			case 'name':
				return $item['fname'] . ' ' . $item['lname'];
			case 'email':
				return $item[$column_name];
			case 'status':
				return $item[$column_name];
			case 'date':
				return date('F j, Y', strtotime($item[$column_name]));
			case 'post':
				if(is_array($item['post_id'])){
					$posts = array();
					foreach($item['post_id'] as $post_id){
						$posts[] = sprintf(
							'<a href="%s">%s</a>',
							add_query_arg(array('post' => $post_id, 'action' => 'edit'), admin_url('post.php')),
							get_the_title($post_id)
						);
					}
					return implode(', ', $posts);
				} else {
					return sprintf(
						'<a href="%s">%s</a>',
						add_query_arg(array('post' => $item['post_id'], 'action' => 'edit'), admin_url('post.php')),
						get_the_title($item['post_id'])
					);
				}
			default:
				return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
		}
	}
	
	function column_name( $item ) {
		$edit_link = add_query_arg(array(
				'post_type' => 'site',
				'page' => 'wpas_site_subscribers',
				'tab' => 'manage',
				'action' => 'edit',
				'subscriber' => $item['subscriber_id']
			),
			admin_url('edit.php')
		);
		
		$delete_link = add_query_arg(array(
				'post_type' => 'site',
				'page' => 'wpas_site_subscribers',
				'tab' => 'manage',
				'action' => 'delete',
				'subscriber' => $item['subscriber_id']
			),
			admin_url('edit.php')
		);
		
		$name = sprintf(
			'<a href="%s">%s</a>',
			$edit_link,
			$item['fname'] . ' ' . $item['lname']
		);
		
		$actions = array(
			'edit' => sprintf('<a href="%s">%s</a>', $edit_link, __('Edit', 'wpas')),
			'delete'	=> sprintf('<a href="%s">%s</a>', $delete_link, __('Delete', 'wpas'))
		);
		return sprintf('<strong>%s</strong> %s', $name, $this->row_actions($actions) );
	}
	
	function get_bulk_actions(){
		$actions = array(
			'edit' => __('Edit', 'wpas'),
			'delete' => __('Delete', 'wpas')
		);
		return $actions;
	}
	
	function prepare_items() {
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
		
		if(!empty($this->subscribers)){
			usort( $this->subscribers, array( &$this, 'usort_reorder' ) );
		}
		
		$this->items = $this->subscribers;
	}
	
	function __construct() {
		$subscription = get_option('wpas_subsriber');
		$data = array();
		
		foreach($subscription as $post_id=>$subscribers){
			foreach( $subscribers as $key=>$val ){
				if( isset($data[$key]) ){
					if(is_array($data[$key]['post_id'])):
						$data[$key]['post_id'][] = $val['post_id'];
					else:
						$data[$key]['post_id'] = array($val['post_id'],$data[$key]['post_id']);
					endif;
				} else {
					$data[$key] = $val;
					$data[$key]['subscriber_id'] = $key;
				}
				$i++;
			}
		}
		
		$this->subscribers = $data;
		
		parent::__construct(
			array(
				'singular'=> 'wp_list_text_link',
				'plural' => 'wp_list_test_links',
				'ajax'	=> false
			)
		);
	}
}

add_action('save_post', 'wpas_notice_subscribers', 1);
function wpas_notice_subscribers( $post_id ){
	$wpas_subscribe = get_option('wpas_subscribe');
	$wpas_notification = $wpas_subscribe['notification'];
	
	// If $_POST is empty, don't send the email
	if( empty($_POST) )
		return;
	
	// If this is just a revision, don't send the email.
	if ( wp_is_post_revision( $post_id ) )
		return;
	
	// If no one is subsribe, don't send the email
	$post_subscribers = wpas_get_post_subscribers($post_id);
	if( !$post_subscribers )
		return;
	
	// If no changes are made, don't send the email
	$changes = wpas_track_post_changes($post_id, $_POST);
	if( !$changes )
		return;
	
	// DEBUG: wp_die( '<pre>' . print_r($changes, true) . '</pre>' );
	
	foreach($changes as $changed){
		$change_data = sprintf(
			'<tr><th scope="row">%s</th><td>%s</td><td>%s</td></tr>',
			$changed['name'],
			$changed['old'],
			$changed['new']
		);
	}
	
	$change_table = sprintf(
		'<table><tr><th scope="col">%s</th><th scope="col">%s</th><th scope="col">%s</th></tr> %s</table>',
		__('Metric', 'wpas'),
		__('Old value', 'wpas'),
		__('New value', 'wpas'),
		$change_data
	);
	
	$post_title = get_the_title( $post_id );
	$post_url = get_permalink( $post_id );
	$post_author = get_the_author_meta('display_name', $_POST['post_author']);
	$manager_link = add_query_arg(array('table' => 'subscription', 'action' => 'edit'), site_url('/'));
	
	$shortcodes = array(
		'[post_title]' => $post_title,
		'[post_permalink]' => $post_url,
		'[post_author]' => $post_author,
		'[post_content]' => stripslashes(nl2br($_POST['post_content'])),
		'[manager_link]' => $manager_link,
		'[change]' => $change_table
	);
	
	$subject = $wpas_notification['email_subject'];
	$message = stripslashes(nl2br($wpas_notification['email_content']));
	foreach($shortcodes as $find=>$replace){
		$message = str_replace($find, $replace, $message);
		$subject = str_replace($find, $replace, $subject);
	}
	
	$from = $wpas_notification['sender_name'] . '<' . $wpas_notification['sender_email'] . '>';
	$from = (!$from) ? get_bloginfo('admin_email') : $from;
	$headers = 'From: ' . $from . "\r\n";
	$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Send email to subscribers
	foreach($post_subscribers as $recipient){
		$to = $recipient['fname'] . '<' . $recipient['email'] . '>';
		wp_mail( $to, $subject, $message, $headers );
	}
}

function wpas_subscribers_manager(){
	$subscribers = new Subscribers_List();
	$subscribers->prepare_items();
	$subscribers->display();
}

add_action('loop_start', 'wpas_subscribe_callback_notice');
function wpas_subscribe_callback_notice($array){
	global $wp_query;
    if($array != $wp_query){
		return;
    }
	
	$html = '';
	
	if( isset($_REQUEST['subcription']) && is_single() ){
		$html .= '<div class="wpas-subscription-notice ';
		if( $_REQUEST['subcription'] == 'false' ){
			$html .= 'wpas-error"><p>';
			switch( $_REQUEST['message'] ){
				case 1:
					$html .= __('Error: You have already subscribed to this post.', 'wpas'); break;
				case 2:
					$html .= __('Error: Please use a valid email address.', 'wpas'); break;
				case 3:
					$html .= __('Error: Please fill up all the required fields.', 'wpas'); break;
			}
		} else {
			$html .= 'wpas-success"><p>';
			$html .= __('You have subscribe successfully.', 'wpas');
		}
		$html .= '</p></div>';
	}
	
	$html .= '<script type="text/javascript">';
		$html .= 'jQuery(document).ready(function($){';
			$html .= 'setTimeout(function(){';
				$html .= '$(".wpas-subscription-notice").fadeOut();';
			$html .= '}, 8000);';
		$html .= '});';
	$html .= '</script>';
	
	echo $html;
}

add_action('init', 'wpas_subscribe_form_callback');
function wpas_subscribe_form_callback(){
	if(isset($_POST['wpas_subscriber']) && $_POST['wpas_subscriber'] != ''){
		$subsribers = get_option('wpas_subsriber');
		if(!$subsribers){ $subsribers = array(); }
		
		foreach($_POST as $key=>$val){
			$$key = $val;
		}
		
		if(!$redirect_to){
			$redirect_to = get_permalink($wpas_subsriber['post_id']);
		}
		
		if($wpas_subsriber['fname'] == ''){
			wp_redirect(add_query_arg(array('subcription' => 'false', 'message' => 3), $redirect_to)); exit;
		} elseif($wpas_subsriber['lname'] == '') {
			wp_redirect(add_query_arg(array('subcription' => 'false', 'message' => 3), $redirect_to)); exit;
		}
		
		if( isset($subsribers[$wpas_subsriber['post_id']][$wpas_subsriber['email']]) ){
			wp_redirect(add_query_arg(array('subcription' => 'false', 'message' => 1), $redirect_to)); exit;
		}
		
		if(!is_email($wpas_subsriber['email'])){
			wp_redirect(add_query_arg(array('subcription' => 'false', 'message' => 2), $redirect_to)); exit;
		}
		
		$subsribers[$wpas_subsriber['post_id']][$wpas_subsriber['email']] = array(
			'fname' => $wpas_subsriber['fname'],
			'lname' => $wpas_subsriber['lname'],
			'email' => $wpas_subsriber['email'],
			'post_id' => $wpas_subsriber['post_id'],
			'status' => $wpas_subsriber['status'],
			'date' => date('c')
		);
		
		$return = update_option('wpas_subsriber', $subsribers);
		
		if($return){
			wp_redirect(add_query_arg(array('subcription' => 'true'), $redirect_to)); exit;
		}
	}
	
	return;
}

function wpas_subscribe_form($echo = true, $post_id = ''){
	global $post;
	$post_id = (!$post_id) ? $post->ID : $post_id;
	
	$html = '<form action="'. get_permalink($post_id) .'" method="post">';
	
	$html .= sprintf('<h3>%s : %s</h3>', __('Watch', 'wpas'), get_the_title($post_id));
	
	$html .= '<table class="form-table" width="100%">';
	
	$html .= '<tr valign="top">';
	$html .= sprintf(
		'<th scope="row" align="left"><label for="wpas_subsriber_fname">%s:</label></th>',
		__('First name', 'wpas')
	);
	$html .= '<td><input type="text" name="wpas_subsriber[fname]" id="wpas_subsriber_fname" value="" /></td>';
	$html .= '</tr>';
	
	$html .= '<tr valign="top">';
	$html .= sprintf(
		'<th scope="row" align="left"><label for="wpas_subsriber_lname">%s:</label></th>',
		__('Last name', 'wpas')
	);
	$html .= '<td><input type="text" name="wpas_subsriber[lname]" id="wpas_subsriber_lname" value="" /></td>';
	$html .= '</tr>';
	
	$html .= '<tr valign="top">';
	$html .= sprintf(
		'<th scope="row" align="left"><label for="wpas_subsriber_email">%s:</label></th>',
		__('Email', 'wpas')
	);
	$html .= '<td><input type="text" name="wpas_subsriber[email]" id="wpas_subsriber_email" value="" /></td>';
	$html .= '</tr>';
	
	$html .= '</table>';
	
	$html .= sprintf('<input type="hidden" name="wpas_subsriber[post_id]" value="%s" />', $post_id);
	$html .= '<input type="hidden" name="wpas_subsriber[status]" value="Y" />';
	$html .= '<input type="hidden" name="redirect_to" value="'. get_permalink($post_id) .'" />';
	
	$html .= '<input class="alignright" type="submit" name="wpas_subscriber" value="Submit" />';
	
	$html .= '<div class="clear"></div>';
	$html .= '</form>';
	
	if($echo){ echo $html; } else { return $html; }
}

function wpas_get_post_subscribers($post_id){
	$subscription = get_option('wpas_subsriber');
	
	if( !isset($subscription[$post_id]) )
		return false;
	
	$subscribers = array();
	foreach($subscription[$post_id] as $email=>$subscriber){
		if($subscriber['status'] == 'Y')
			$subscribers[] = $subscriber;
	}
	
	if( empty($subscribers) )
		return false;
	
	return $subscribers;
}

function wpas_track_post_changes($post_id, $data){
	$metadata = wpa_default_metrics();
	$changes = array();
	
	foreach( $metadata as $meta ){
		if( isset($data[$meta['id']]) ){
			$old = get_post_meta($post_id, $meta['id'], true);
			if( $data[$meta['id']] != trim($old) ){
				$changes[] = array(
					'name' => $meta['name'],
					'old' => $old,
					'new' => $data[$meta['id']]
				);
			}
		}
	}
	
	if( empty($changes) )
		return false;
	
	return $changes;
}

add_action('admin_init', 'wpas_subscribe_save_options');
function wpas_subscribe_save_options(){
	$wpas_subscribe = get_option('wpas_subscribe');
	
	if( isset($_POST['wpas_subscribe_submit']) and $_POST['wpas_subscribe_submit'] ){
		$fields = array('sender_name', 'sender_email', 'email_subject', 'email_content');
		
		foreach( $fields as $field ){
			if( isset($_POST['wpas_subscribe'][$field]) ){
				$wpas_subscribe['notification'][$field] = $_POST['wpas_subscribe'][$field];
			}
		}
		
		$return = update_option('wpas_subscribe', $wpas_subscribe);
		
		if($return){
			wp_redirect(
				add_query_arg(array(
						'post_type' => 'site',
						'page' => 'wpas_site_subscribers',
						'tab' => $_POST['wpas_tab_identifier'],
						'settings-updated' => 'true'
					),
					admin_url('edit.php')
				)
			); exit;
		} else {
			wp_redirect(
				add_query_arg(array(
						'post_type' => 'site',
						'page' => 'wpas_site_subscribers',
						'tab' => $_POST['wpas_tab_identifier'],
						'settings-updated' => 'false'
					),
					admin_url('edit.php')
				)
			); exit;
		}
	}
	
	return;
}
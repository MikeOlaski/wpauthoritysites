<?php
/*
 * WPAS - Claim feature manager
 */

add_action('loop_start', 'wpas_claim_callback_notice');
function wpas_claim_callback_notice($array){
	global $wp_query;
    if($array != $wp_query){
		return;
    }
	
	$html = '';
	
	if( isset($_REQUEST['claim']) && is_single() ){
		$html .= '<div class="wpas-claim-notice ';
		if( $_REQUEST['claim'] == 'false' ){
			$html .= 'wpas-error"><p>';
			switch( $_REQUEST['message'] ){
				case 1:
					$html .= __('Error: You have already claim this site.', 'wpas'); break;
				case 2:
					$html .= __('Error: Please use a valid email address.', 'wpas'); break;
				case 3:
					$html .= __('Error: Please fill up all the required fields.', 'wpas'); break;
			}
		} else {
			$html .= 'wpas-success"><p>';
			$html .= __('You have successfully sent a request to claim this site.', 'wpas');
		}
		$html .= '</p></div>';
	}
	
	$html .= '<script type="text/javascript">';
		$html .= 'jQuery(document).ready(function($){';
			$html .= 'setTimeout(function(){';
				$html .= '$(".wpas-claim-notice").fadeOut();';
			$html .= '}, 8000);';
		$html .= '});';
	$html .= '</script>';
	
	echo $html;
}

add_action('init', 'wpas_claim_form_callback');
function wpas_claim_form_callback(){
	if(isset($_POST['wpas_claim']) && $_POST['wpas_claim'] != ''){
		$claimed = get_option('wpas_claimed');
		if(!$claimed){ $claimed = array(); }
		$registered = false;
		
		foreach($_POST as $key=>$val){
			$$key = $val;
		}
		
		if(!$redirect_to){
			$redirect_to = get_permalink($wpas_claimed['post_id']);
		}
		
		if($wpas_claimed['fname'] == ''){
			wp_redirect(add_query_arg(array('claim' => 'false', 'message' => 3), $redirect_to)); exit;
		} elseif($wpas_claimed['lname'] == '') {
			wp_redirect(add_query_arg(array('claim' => 'false', 'message' => 3), $redirect_to)); exit;
		}
		
		if( isset($claimed[$wpas_claimed['post_id']][$wpas_claimed['email']]) ){
			wp_redirect(add_query_arg(array('claim' => 'false', 'message' => 1), $redirect_to)); exit;
		}
		
		if(!is_email($wpas_claimed['email'])){
			wp_redirect(add_query_arg(array('claim' => 'false', 'message' => 2), $redirect_to)); exit;
		}
		
		// Create a user name
		$user_name = explode('@', $wpas_claimed['email']);
		$user_id = username_exists( $user_name[0] );
		
		if ( !$user_id and email_exists($wpas_claimed['email']) == false ) {
			// Make sure username and email does not exists, Otherwise Register the user
			$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
			$user_id = wp_create_user( $user_name[0], $random_password, $wpas_claimed['email'] );
			
			wp_update_user( array (
				'ID' => $user_id,
				'first_name' => $wpas_claimed['fname'],
				'last_name' => $wpas_claimed['lname']
			) ) ;
			
			$registered = true;
		}
		
		// User is registered let's record that this user is wanting to claim the site
		$claimed[$wpas_claimed['post_id']][$wpas_claimed['email']] = array(
			'fname' => $wpas_claimed['fname'],
			'lname' => $wpas_claimed['lname'],
			'email' => $wpas_claimed['email'],
			'post_id' => $wpas_claimed['post_id'],
			'status' => $wpas_claimed['status'],
			'date' => date('c')
		);
		
		$return = update_option('wpas_claimed', $claimed);
		
		if($return){
			// Let's be courteous and aknowledge the user by sending a welcome email
			// wpas_akcnowledge_claimer(); // Commented out: Feature to be confirmed with Mike
			
			// Notify admin that this use wants to claim the site
			wpas_notify_admin_of_claim($user_id, $wpas_claimed['post_id'], true);
			
			wp_redirect(add_query_arg(array('claim' => 'true'), $redirect_to)); exit;
		}
	}
	
	return;
}

function wpas_akcnowledge_claimer(){
	// Content coming soon
}

function wpas_notify_admin_of_claim($user_id, $post_id, $is_new_user = false){
	$admin = get_bloginfo('admin_email');
	$sitename = get_the_title($post_id);
	$blogname = get_bloginfo('name');
	$user_link = add_query_arg(
		array('user_id' => $user_id),
		admin_url('user-edit.php')
	);
	$userdata = get_userdata( $user_id );
	
	// Hi There,
	//
	// A new user has been registered and request to claim {$sitename}.
	// To view the user details click the link below;
	//
	// {$user_link}
	//
	// Regards
	// {$blogname}
	
	$subject = sprintf('[%s] Claim Site Request', $blogname);
	$message = 'Hi There' . "\n\n";
	
	if( $is_new_user ){
		$message .= sprintf('%s %s has been registered and ', $userdata->user_firstname, $userdata->user_lastname);
	} else {
		$message .= sprintf('%s ', $userdata->display_name);
	}
	
	$message .= sprintf('request to claim %s.', $sitename) . "\n";
	$message .= 'To view the user details click the link below;' . "\n\n";
	$message .= $user_link . "\n\n";
	
	$message .= 'Regards,' . "\n";
	$message .= $blogname . "\n";
	
	$from = $blogname . '<' . $admin . '>';
	$headers = 'From: ' . $from . "\r\n";
	$to = $blogname . '<' . $admin . '>';
	
	wp_mail( $to, $subject, $message, $headers );
}
<?php
class MVSF_Hooks extends MVSF_Utils {
	function __construct(){
		parent::__construct();
		
		if($this->settings['stop_from_publish'])
			add_action('save_post', array( &$this, 'check_seo'), 99, 2);
		
		add_action('save_post', array( &$this, 'save_mvsf'));
		add_action('transition_post_status', array( &$this, 'send_notifications'), 10, 3);
	}
	
	function send_notifications($new_status, $old_status, $post){
		// First Create
		if( ('new' == $old_status || 'auto-draft' == $old_status)
			&& ( 'draft' == $new_status || 'publish' == $new_status || 'pending' == $new_status ) ){	// Dont care about autosaves, revisions and trashes
					
			$post_edit_link = get_edit_post_link($post->ID, 'mvsf_email');
			$post_url = get_permalink($post->ID);
			$post_title = get_the_title($post->ID);
		
			$emails = explode("\n",$this->settings['emails']);
			// Get the site domain and get rid of www.
			$sitename = strtolower( $_SERVER['SERVER_NAME'] );
			if ( substr( $sitename, 0, 4 ) == 'www.' ) {
				$sitename = substr( $sitename, 4 );
			}

			$headers = 'From: SEO Force <seoforce@'.$sitename.'>' . "\r\n";

			foreach($emails as $email){
				$message = str_replace('%post_edit_link%', $post_edit_link, str_replace('%post_url%', $post_url, str_replace('%post_title%', $post_title, $this->settings['template'])));
			   	wp_mail($email, 'SEO Force Notification: ' . $post_title, $message, $headers);
			}
		}
	}
	
	function save_mvsf($post_id){
		update_post_meta($post_id, '_mvsf', $_POST['mvsf']);
	}
	
	function check_seo($post_id, $post){
		if($post->post_status == 'publish'){
			if(isset($_POST['aiosp_title']) && isset($_POST['aiosp_description']) && isset($_POST['aiosp_keywords'])){
				if(empty($_POST['aiosp_title']) || empty($_POST['aiosp_description']) || empty($_POST['aiosp_keywords'])){
					global $wpdb;
					$wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $post_id ) );
				}
			}
		}
	}
}
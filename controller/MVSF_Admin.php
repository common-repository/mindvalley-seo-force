<?php

class MVSF_Admin extends MVSF_Utils {
	
	function __construct(){
		// Add the admin menu
		add_action( 'admin_menu', array (&$this, 'admin_menu') ); 
		add_action('admin_enqueue_scripts', array (&$this, 'enqueue_scripts') ); 
	}
	
	function admin_menu(){
		global $mvsf_settings;
		add_menu_page( __('MV SEO Force', 'mindvalley'), __('MV SEO Force', 'mindvalley'), 'publish_posts', plugin_basename(MVSF_BASE), array (&$mvsf_settings, 'show_settings'), $icon_url );
		add_submenu_page( plugin_basename(MVSF_BASE) , __('Settings', 'mindvalley'), __('Settings', 'mindvalley'), 'publish_posts', plugin_basename(MVSF_BASE), array (&$mvsf_settings, 'show_settings'));
	}
	
	function enqueue_scripts($hook){

		if( 'toplevel_page_mindvalley-seo-force' == $hook ){
			wp_enqueue_script( 'jquery_autogrow', MVSF_LIB_URL . 'js/jquery.autogrowtextarea.js', 'jquery' );
		}
		
		if( 'post-new.php' == $hook || 'post.php' == $hook){
			wp_register_script('jquery-bgiframe', MVSF_LIB_URL .'js/jquery.bgiframe.min.js', 'jquery');
			wp_enqueue_script( 'jquery-bgiframe' );

			wp_register_script('jquery-ui-autocomplete', MVSF_LIB_URL .'js/jquery.autocomplete.min.js', array('jquery-ui-core', 'jquery-ui-widget'), '1.8.16');
			wp_enqueue_script( 'jquery-ui-autocomplete' );
		}
		
	}
}
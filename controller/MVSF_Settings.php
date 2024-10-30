<?php

class MVSF_Settings extends MVSF_Utils {
	function __construct(){
		parent::__construct();
		register_activation_hook( MVSF, array( &$this , 'initialize_settings' ) );
	}
	
	function initialize_settings(){
		if(!isset($this->settings['template'])){
			$this->settings['template'] = "New post %post_title% created. Please fill in required SEO fields.\n\nPost link: %post_url%\nPost edit link: %post_edit_link%";
			$this->_saveSettings($this->settings);
		}
		if(!isset($this->settings['stop_from_publish'])){
			$this->settings['stop_from_publish'] = 1;
			$this->_saveSettings($this->settings);
		}
		
	}
	
	function show_settings(){
		if( isset($_POST['mvsf_settings']) ){
			$this->_saveSettings($_POST['settings']);
		}
		$data['mvsf_settings'] = $this->_getSettings('refresh');
		
		echo $this->_getView( 'settings.php', $data );
	}
}
<?php

class MVSF_Utils {
	var $settings;
	
	function __construct(){
		$this->_getSettings();
	}
	
	protected function _getView($fileName, $passVariables = array(), $useClassPath = true) {

        if ($useClassPath){
            $partialDir = get_class($this) . '/';
        }else{
            $partialDir = '';
        }
		
		$htmlFile = MVSF_VIEW . $partialDir . $fileName;

        if (!file_exists($htmlFile)){
			return '';
        }

        if (count($passVariables) > 0) {
            foreach ($passVariables as $key => $data){
                    $$key = $data;
            }
        }
        
        ob_start();
        include($htmlFile);
        $data = ob_get_contents();
        ob_end_clean();
        return $data;
	}	
	
	protected function _getSettings($refresh=false){

		if(empty($this->settings) || 'refresh' == $refresh){
			$this->settings = get_option('mvsf_settings',array());
		}
		return $this->settings;
	}
	
	protected function _saveSettings($data){
		update_option('mvsf_settings', stripslashes_deep($data));
	}
}
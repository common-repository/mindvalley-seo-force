<?php
/*
Plugin Name: Mindvalley SEO Force
Plugin URI: http://mindvalley.com/opensource
Description: Force authors to fullfill SEO requirements before publishing posts.
Author: Mindvalley
Version: 1.0
*/
define('MVSF', __FILE__);
define('MVSF_BASE', dirname(__FILE__));
define('MVSF_CONTROLLER', dirname(__FILE__) . '/controller/');
define('MVSF_MODEL', dirname(__FILE__) . '/model/');
define('MVSF_VIEW', dirname(__FILE__) . '/view/');
define('MVSF_LIB', dirname(__FILE__) . '/lib/');
define('MVSF_LIB_URL', WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/lib/');

function mvsf_autoload($class){
  $locations = array(MVSF_BASE,MVSF_CONTROLLER,MVSF_MODEL);
  foreach ($locations as $location){
    if (file_exists($location . $class.'.php')){
      require_once $location . $class.'.php';
      break;
    }
  }
}

spl_autoload_register('mvsf_autoload');

global $mvsf_admin,$mvsf_settings,$mvsf_hooks,$mvsf_editor;
$mvsf_hooks = new MVSF_Hooks();
$mvsf_editor = new MVSF_Editor();
$mvsf_settings = new MVSF_Settings();
$mvsf_admin = new MVSF_Admin();
<?php
/*
Plugin Name: Insert or Embed iSpring Content into Wordpress
Plugin URI: http://www.elearningplugins.com
Description: Quickly embed or insert iSpring content into a post or page
Version: 1.0
Author: elearningplugins.com
Author URI: http://www.elearningplugins.com
*/

define ( 'WP_ISPRING_EMBEDER_PLUGIN_DIR', dirname(__FILE__)); // Plugin Directory
define ( 'WP_ISPRING_EMBEDER_PLUGIN_URL', plugin_dir_url(__FILE__)); // Plugin URL (for http requests)

global $wpdb;
require_once("settings_file.php");
require_once("functions.php");
include_once(WP_ISPRING_EMBEDER_PLUGIN_DIR."/include/shortcode.php");





register_activation_hook(__FILE__,'ispring_embeder_install'); 


register_deactivation_hook( __FILE__, 'ispring_embeder_remove' );

function ispring_embeder_install() {

@mkdir(ispring_getUploadsPath());
@file_put_contents(ispring_getUploadsPath()."index.html","");

}
function ispring_embeder_remove() {

$ispring_upload_path=ispring_getUploadsPath();
if(file_exists($ispring_upload_path."/.htaccess")){unlink($ispring_upload_path."/.htaccess");}

}


add_action( 'wp_ajax_ispring_upload', 'wp_ajax_ispring_upload' );
add_action( 'wp_ajax_ispring_del_dir', 'wp_ajax_ispring_del_dir' );
add_action( 'wp_ajax_ispring_rename_dir', 'wp_ajax_ispring_rename_dir');


function wp_ispring_media_button() {
	$wp_ispring_media_button_image = ispring_getPluginUrl().'ispring.png';
	echo '<a href="media-upload.php?type=ispring_upload&TB_iframe=true&tab=upload" class="thickbox">
  <img src="'.$wp_ispring_media_button_image.'"  width=15 height=15 /></a>';
}

function media_upload_ispring_form()
{
	ispring_print_tabs();
	echo '<div class="wrap" style="margin-left:20px;  margin-bottom:50px;">';
		echo '<div id="icon-upload" class="icon32"><br></div><h2>Upload File</h2>';
		ispring_print_upload();
	echo "</div>";

}
function media_upload_ispring_content()
{
	ispring_print_tabs();
	echo '<div class="wrap" style="margin-left:20px;  margin-bottom:50px;">';
		echo '<div id="icon-upload" class="icon32"><br></div><h2>iSpring Content Library</h2>';
		ispring_printInsertForm();
	echo "</div>";
}



function media_upload_ispring()
{
	wp_iframe( "media_upload_ispring_content" );
}

function media_upload_ispring_upload()
{
	if($_GET['tab']=='ispring') #I added this technique because: on wordpress 3.4  'media_upload_ispring' action hook does not work.
	{
	wp_iframe( "media_upload_ispring_content" );
	}
	else
	{
	wp_iframe( "media_upload_ispring_form" );
	}
}

function ispring_print_tabs()
{

	
	function ispring_tabs($tabs) 
	{
	$newtab1 = array('upload' => 'Upload File');
	$newtab2 = array('ispring' => 'Content Library');
	return array_merge($newtab1,$newtab2);
	}
add_filter('media_upload_tabs', 'ispring_tabs');
media_upload_header();

}


add_action('media_upload_ispring_upload','media_upload_ispring_upload');
add_action('media_upload_ispring','media_upload_ispring');
add_action( 'media_buttons', 'wp_ispring_media_button',100);


/* added by oneTarek --*/
//add_action('wp_head','ispring_embeder_wp_head');
add_action('wp_footer','ispring_embeder_wp_head');

function ispring_embeder_enqueue_script() {
	wp_enqueue_script('jquery');
}    
 
add_action('wp_enqueue_scripts', 'ispring_embeder_enqueue_script');

include_once(WP_ISPRING_EMBEDER_PLUGIN_DIR."/admin_page.php");



?>
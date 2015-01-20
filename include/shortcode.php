<?php
#shortcode handler

function ispring_iframe_handler($attr,$content)
{
$opt=get_ispring_embeder_options();
$cbox_themes=ispring_embeder_get_colorbox_themes();
//echo "<pre>"; print_r( $opt); echo "</pre>";
$link_text='<img src="'.WP_ISPRING_EMBEDER_PLUGIN_URL.'launch_presentation.gif" alt="Launch Presentation" />'; #a button image, will be reset if short have link_text option
extract($attr); #http://php.net/manual/en/function.extract.php
if(isset($button) && ""!=trim($button))
{
$link_text='<img src="'.$button.'" alt="Launch Presentation" />';
}

		#creating content to send
		if($type==""){$type="iframe";}
			switch($type)
			{
			  case 'iframe':
			  {
			  $return_content= "<iframe src='$src' width='$width' height='$height' frameborder='$border'></iframe>";
			  $href=$src;
			  break;
			  }
			  case 'lightbox':
			  {
				  if($opt["lightbox_script"]=="nivo_lightbox")
				  {
				  $return_content= '<a class="nivo_lightbox_iframe" data-lightbox-type="iframe" title="'.$title.'" href="'.$href.'">'.$link_text.'</a>';
				  }
				  else
				  {
				  //echo "<pre>"; print_r( $cbox_themes); echo "</pre>";
				  if($colorbox_theme!=""){ if(array_key_exists($colorbox_theme, $cbox_themes)){ global $ispring_embeder_colorbox_theme;$ispring_embeder_colorbox_theme=$colorbox_theme;}}
				  $return_content= '<a class="colorbox_iframe" title="'.$title.'" href="'.$href.'">'.$link_text.'</a>';
				  }
				  if(isset($size_opt)){global $ispring_embeder_size_opt; $ispring_embeder_size_opt=$size_opt;}
				  if(isset($width) && isset($height)){global $ispring_embeder_width;$ispring_embeder_width=$width;global $ispring_embeder_height;$ispring_embeder_height=$height; }
				  if(isset($scrollbar) && $scrollbar=="no"){global $ispring_embeder_scrollbar; $ispring_embeder_scrollbar="no";}
			  		
			  
			  break;
			  }
			  case 'open_link_in_new_window':
			  {
			  $return_content= '<a target="_blank" href="'.$href.'">'.$link_text.'</a>';
			  break;
			  }
			  case 'open_link_in_same_window':
			  {
			  $return_content= '<a href="'.$href.'">'.$link_text.'</a>';
			  break;
			  }
			
			}// end switch($type)
	
	
	#return
	return $return_content;

}

add_shortcode( 'ispring_iframe_loader', 'ispring_iframe_handler' );
?>
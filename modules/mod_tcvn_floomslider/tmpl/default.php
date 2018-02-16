<?php 
/*
# ------------------------------------------------------------------------
# TCVN Floom Slider Module for Joomla 3.1
# ------------------------------------------------------------------------
# Copyright(C) 2008-2013 www.thecoders.vn. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-2.0.html GNU/GPL
# Author: TheCoders.vn
# Websites: http://TheCoders.com
# ------------------------------------------------------------------------
*/
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);
$uri = JFactory::getURI();
$url = $uri->root();

$doc   =  JFactory::getDocument();
$langa = JRequest::getVar('lang','en','request','string');

$doc->addStylesheet(JURI::base()."modules/mod_tcvn_floomslider/assets/css/floom.css");

if($params->get('jquery', 1)) {
	$doc->addScript(JURI::base()."modules/mod_tcvn_floomslider/assets/js/jquery.js");
}

$doc->addScript(JURI::base()."modules/mod_tcvn_floomslider/assets/js/jqFancyTransitions.1.8.js");

$wimage = $params->get('mwidth', 999);
$himage = $params->get('mheight', 430);
$thumb  = JURI::base() ."/modules/mod_tcvn_floomslider/timthumb.php?w=" . $wimage . "&h=" . $himage . "&a=c&q=99&z=0";
?>
<style type="text/css">
.ft-title {
	width:<?php echo ($wimage - 20); ?>px;
}
</style>
<div id="slideshowHolder">
	<?php	
		foreach($lists as $list) {
			$url 	= $thumb . '&src=' . JURI::base() . $list->url;
			$title 	= str_replace(array('"', "'"), "", $list->title);
			$link 	= $list->link;
			$desc 	= str_replace(array('"', "'"), "", $list->desc);
			
			$alt	= '';
			if($params->get('show_title', 1)) {
				$alt .= '<h2>';
					if($params->get('link_title', 1)) {
						$alt .= '<a href=\''.$link.'\' target=\''.$params->get('item_target', '_blank').'\'>';
						$alt .= $title;
						$alt .= '</a>';
					}
					else {
						$alt .= $title;
					}
				$alt .= '</h2>';
			}
			
			if($params->get('show_desc', 1)) {
				$alt .= '<p>'.$desc.'</p>';
			}
			
			echo '<img src="'.$url.'" alt="'.$alt.'" />';
			echo '<a href ="'.$link.'"/></a>';
		}		
	?>
</div>
<a target="_blank" style="font-size:0; height:0; width:0; opacity:0; position:absolute" title="Free Joomla Modules" href="http://thecoders.vn/joomla-modules.html">Joomla Modules</a>
<script>
jQuery(document).ready( function($){
	$('#slideshowHolder').jqFancyTransitions({ 
		effect: 		'<?php echo ($params->get('effect', 'wave')); ?>',
		width: 			<?php echo $wimage; ?>, 
		height: 		<?php echo $himage; ?>,
		links: 			false,
		strips: 		<?php echo ($params->get('strips', '20')); ?>, 
		delay: 			<?php echo ($params->get('delay', '5000')); ?>,
		stripDelay: 	<?php echo ($params->get('stripDelay', '50')); ?>,
		titleOpacity: 	<?php echo ($params->get('titleOpacity', '0.7')); ?>,
		titleSpeed: 	<?php echo ($params->get('titleSpeed', 1000)); ?>,
		navigation: 	<?php echo ($params->get('navigation', 1)) ? 'true' : 'false'; ?>		
	});
});
</script>
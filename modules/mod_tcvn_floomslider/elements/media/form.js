/*
# ------------------------------------------------------------------------
# TCVN Floom Slider Module for Joomla 2.5
# ------------------------------------------------------------------------
# Copyright(C) 2008-2012 www.thecoders.vn. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-2.0.html GNU/GPL
# Author: Thecoders.vn
# Websites: http://Thecoders.com
# ------------------------------------------------------------------------
*/

// JavaScript Document
window.addEvent('domready', function() {
	$('addnew').addEvent('click', function(event) {
		event.stop();
		
		var url 	= $('jform_params_image_url').value;
		var title  	= $('image-title').value;
		var _link 	= $('image-link').value;
		var desc 	= $('image-desc').value;
		
		var carea	= $('jform_params_data').value;
		var text	= '';
		
		if(url == '' || title == '' || _link == '' || desc == '') {
			alert('Please entry URL, TITLE, LINK and DESCRIPTION of Image !');
			return false;
		}
		
		text 		= carea + url + '|' + title + '|' + _link + '|' + desc + '\n';
		$('jform_params_data').value = text;
		
		$('jform_params_image_url').value = '';
		$('image-title').value = '';
		$('image-link').value  = '';
		$('image-desc').value  = '';				
		
		return true;
	});
});

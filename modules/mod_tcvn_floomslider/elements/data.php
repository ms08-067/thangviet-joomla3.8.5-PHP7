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

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a category element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JFormFieldData extends JFormField
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'data';
	
	protected function getInput()
	{		
		
	}
	
	protected function getLabel()
	{
		$html = array();
						
		$html[] = '<label class="hasTip" title="' . JTEXT::_('MOD_TCVN_FLOOMSLIDER_IMAGE_TITLE') . '::' . JTEXT::_('MOD_TCVN_FLOOMSLIDER_IMAGE_TITLE_DESC') . '">' . JTEXT::_('MOD_TCVN_FLOOMSLIDER_IMAGE_TITLE') . '</label>';
		$html[] = '<input type="text" name="title" id="image-title" value="" size="53" />';
		
		$html[] = '<label class="hasTip" title="' . JTEXT::_('MOD_TCVN_FLOOMSLIDER_IMAGE_LINK') . '::' . JTEXT::_('MOD_TCVN_FLOOMSLIDER_IMAGE_LINK_DESC') . '">' . JTEXT::_('MOD_TCVN_FLOOMSLIDER_IMAGE_LINK') . '</label>';
		$html[] = '<input type="text" name="image-link" id="image-link" value="" size="53" />';
		
		$html[] = '<label class="hasTip" title="' . JTEXT::_('MOD_TCVN_FLOOMSLIDER_IMAGE_DESC') . '::' . JTEXT::_('MOD_TCVN_FLOOMSLIDER_IMAGE_DESC_DESC') . '">' . JTEXT::_('MOD_TCVN_FLOOMSLIDER_IMAGE_DESC') . '</label>';
		$html[] = '<textarea name="desc" id="image-desc" rows="3" cols="30"></textarea>';
		$html[] = '<div class="addnew"><button id="addnew">' . JTEXT::_('MOD_TCVN_FLOOMSLIDER_ADD_NEW') . '</button></div>';
		
		return implode('', $html);
	}
	
	protected function getTitle()
	{
		return $this->getLabel();
	}
}
?>
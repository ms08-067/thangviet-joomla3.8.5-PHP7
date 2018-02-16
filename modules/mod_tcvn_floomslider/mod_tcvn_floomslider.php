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

// no direct access
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS.'helper.php');

$lists = modTCVNFloomSliderHelper::getdata($params);

if(!count($lists)) return;

require(JModuleHelper::getLayoutPath('mod_tcvn_floomslider'));
?>
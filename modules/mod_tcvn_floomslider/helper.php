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
class modTCVNFloomSliderHelper
{
	public static function getdata(&$params)
	{				 
		$data = $params->get('data', '');
		$rows = explode("\n", $data);
		$list = array();
		
		//echo "<pre>"; print_r($rows); exit;

		for($i = 0; $i < count($rows); $i++)
		{
			$row = $rows[$i];
			if($row != '')
			{
				


				@list($url, $title, $link, $desc) = explode("|", $row);
				$object = new stdClass();
				
				$object->url 	= $url;
				$object->title 	= $title;
				$object->link 	= $link;
				$object->desc 	= $desc;
				
				$list[] = $object;
			}
		}
		if($params->get('random', 0))
		{
			$randomlist = array();
			$arr = array_rand($list, ($params->get('numberRandom', 2) == 1) ? 2 : $params->get('numberRandom', 2));
			for($i = 0; $i < $params->get('numberRandom', 2); $i++)
			{
				$randomlist[] = $list[$arr[$i]];
			}
			return $randomlist;
		}
		else
			return $list;		
	 }
}
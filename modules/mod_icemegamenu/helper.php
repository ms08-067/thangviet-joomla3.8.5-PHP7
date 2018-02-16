<?php 
/**
 * IceMegaMenu Extension for Joomla 3.0 By IceTheme
 * 
 * 
 * @copyright	Copyright (C) 2008 - 2012 IceTheme.com. All rights reserved.
 * @license		GNU General Public License version 2
 * 
 * @Website 	http://www.icetheme.com/Joomla-Extensions/icemegamenu.html
 * @Support 	http://www.icetheme.com/Forums/IceMegaMenu/
 *
 */
 
 
/* no direct access*/
defined('_JEXEC') or die('Restricted access');


require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';

jimport('joomla.base.tree');
jimport('joomla.utilities.simplexml');
require_once("libs/menucore.php");

class modIceMegamenuHelper
{
	
	var $_params 	= null;
	var $moduleid	= 0;
	var $_module 	= null;
	
	public function __construct($module = null, $params = array())
	{
		
		if(!empty($module))
		{
			$this->_module = $module;
			$this->moduleid = $module->id;
			$this->loadMediaFiles($params, $module);
		}
		$this->_params = $params;
	}
	
	function buildXML($params)
	{
		$menu 	= new IceMenuTree($params);
		$items 	= &JSite::getMenu();
        $start  = $params->get('startLevel');
        $end    = $params->get('endLevel');
        $sChild = $params->get('showAllChildren');         
        
        if($end<$start && $end!=0){ return ""; }
            
        if(!$sChild){ $end = $start;}  
          
		// Get Menu Items
		$rows = $items->getItems('menutype', $params->get('menutype'));
        foreach($rows as $key=>$val)
        {             
            if(!(($end!=0 && $rows[$key]->level>=$start && $rows[$key]->level<=$end) ||($end==0 && $rows[$key]->level>=$start)))
            {
                unset($rows[$key]);
            }
        }         
		$maxdepth = $params->get('maxdepth',10);
		
		// Build Menu Tree root down(orphan proof - child might have lower id than parent)
		$user 	= &JFactory::getUser();
		$ids 	= array();
		$ids[1] = true;
		$last 	= null;
		$unresolved = array();
		
		// pop the first item until the array is empty if there is any item		
		if(is_array($rows))
		{
			while(count($rows) && !is_null($row = array_shift($rows)))
			{
				if(array_key_exists($row->parent_id, $ids))
				{
					$row->ionly = $params->get('menu_images_link');
					$menu->addNode($params, $row);
					// record loaded parents
					$ids[$row->id] = true;
				}
				else
				{
					// no parent yet so push item to back of list
					// SAM: But if the key isn't in the list and we dont _add_ this is infinite, so check the unresolved queue
					if(!array_key_exists($row->id, $unresolved) || $unresolved[$row->id] < $maxdepth)
					{
						array_push($rows, $row);
						// so let us do max $maxdepth passes
						// TODO: Put a time check in this loop in case we get too close to the PHP timeout
						if(!isset($unresolved[$row->id])) $unresolved[$row->id] = 1;
						else $unresolved[$row->id]++;
					}
				}
			}
		}
		return $menu->toXML();
	}

	function &getXML($type, &$params, $decorator)
	{
		static $xmls;

		if(!isset($xmls[$type]))
		{
			$cache 			= &JFactory::getCache('mod_icemegamenu');
			//$string 		= $cache->call(array('modIceMegamenuHelper', 'buildXML'), $params);
			/*$string = '<div><div class="ice-megamenu-toggle">
				<a data-toggle="collapse" data-target=".nav-collapse">Menu</a>
				</div>
				<div class="nav-collapse icemegamenu collapse">
				<ul id="icemegamenu" class="meganizr mzr-slide mzr-responsive">
					<li id="iceMenu_101" class="iceMenuLiLevel_1 active">
						<a href="http://thangvietsecurity.com/" class="icemega_active iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[TRANG CHỦ]]></span></a>
					</li>
					<li id="iceMenu_102" class="iceMenuLiLevel_1 mzr-drop parent">
						<a href="./index.php?option=com_content&amp;view=article&amp;id=2&amp;Itemid=102" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[GIỚI THIỆU]]></span></a>
					<ul class="icesubMenu icemodules sub_level_1" style="width:250px"><li><div style="float:left;width:250px" class="iceCols"><ul><li id="iceMenu_145" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=2&amp;Itemid=145" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Sơ Đồ Tổ Chức]]></span></a></li><li id="iceMenu_146" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=3&amp;Itemid=146" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Phương Châm Hoạt Động]]></span></a></li></ul></div></li></ul></li><li id="iceMenu_103" class="iceMenuLiLevel_1 mzr-drop parent"><a href="./index.php?option=com_content&amp;view=article&amp;id=4&amp;Itemid=103" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[DỊCH VỤ BẢO VỆ]]></span></a><ul class="icesubMenu icemodules sub_level_1" style="width:660px"><li><div style="float:left;width:220px" class="iceCols"><ul><li id="iceMenu_147" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=4&amp;Itemid=147" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Toà Nhà]]></span></a></li><li id="iceMenu_148" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=5&amp;Itemid=148" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Nhà Máy]]></span></a></li><li id="iceMenu_149" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=6&amp;Itemid=149" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Ngân Hàng]]></span></a></li><li id="iceMenu_150" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=9&amp;Itemid=150" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Siêu Thị]]></span></a></li><li id="iceMenu_151" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=8&amp;Itemid=151" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Trường Học]]></span></a></li></ul></div><div  style="float:left;width:220px" class="iceCols"><ul><li id="iceMenu_152" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=13&amp;Itemid=152" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Dự Án]]></span></a></li><li id="iceMenu_153" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=15&amp;Itemid=153" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Khách Sạn]]></span></a></li><li id="iceMenu_154" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=15&amp;Itemid=154" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Cửa Hàng]]></span></a></li><li id="iceMenu_155" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=12&amp;Itemid=155" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Công Trường]]></span></a></li><li id="iceMenu_166" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=14&amp;Itemid=166" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Chung Cư]]></span></a></li></ul></div><div  style="float:left;width:220px" class="iceCols"><ul><li id="iceMenu_156" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=11&amp;Itemid=156" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Khu Công Nghiệp]]></span></a></li><li id="iceMenu_157" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=10&amp;Itemid=157" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Sân Bay, Bến Cảng]]></span></a></li><li id="iceMenu_158" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=16&amp;Itemid=158" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Sự Kiện]]></span></a></li><li id="iceMenu_159" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=17&amp;Itemid=159" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Yếu Nhân(Vệ Sĩ)]]></span></a></li><li id="iceMenu_160" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=18&amp;Itemid=160" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Hình Thức Bảo Vệ Khác]]></span></a></li></ul></div></li></ul></li><li id="iceMenu_104" class="iceMenuLiLevel_1 mzr-drop parent"><a href="./index.php?option=com_content&amp;view=article&amp;id=19&amp;Itemid=104" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[KHÁCH HÀNG]]></span></a><ul class="icesubMenu icemodules sub_level_1" style="width:220px"><li><div style="float:left;width:220px" class="iceCols"><ul><li id="iceMenu_167" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=19&amp;Itemid=167" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Khách Hàng Công Ty]]></span></a></li></ul></div></li></ul></li><li id="iceMenu_105" class="iceMenuLiLevel_1 mzr-drop parent"><a href="./index.php?option=com_content&amp;view=article&amp;id=20&amp;Itemid=105" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[TUYỂN DỤNG]]></span></a><ul class="icesubMenu icemodules sub_level_1" style="width:200px"><li><div style="float:left;width:200px" class="iceCols"><ul><li id="iceMenu_168" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=20&amp;Itemid=168" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[QUY TRÌNH TUYỂN DỤNG]]></span></a></li></ul></div></li></ul></li><li id="iceMenu_170" class="iceMenuLiLevel_1 mzr-drop parent"><a href="./index.php?option=com_content&amp;view=category&amp;layout=blog&amp;id=9&amp;Itemid=170" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Tin Tức]]></span></a><ul class="icesubMenu icemodules sub_level_1" style="width:200px"><li><div style="float:left;width:200px" class="iceCols"><ul><li id="iceMenu_169" class="iceMenuLiLevel_2"><a href="./index.php?option=com_content&amp;view=article&amp;id=21&amp;Itemid=169" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Đào Tạo]]></span></a></li></ul></div></li></ul></li><li id="iceMenu_106" class="iceMenuLiLevel_1"><a href="./index.php?option=com_content&amp;view=article&amp;id=22&amp;Itemid=106" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[THIẾT BỊ BẢO VỆ]]></span></a></li><li id="iceMenu_107" class="iceMenuLiLevel_1"><a href="./index.php?option=com_content&amp;view=article&amp;id=23&amp;Itemid=107" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[LIÊN HỆ]]></span></a></li></ul></div></div>';
			*/	
			$string = '<div><div class="ice-megamenu-toggle"><a data-toggle="collapse" data-target=".nav-collapse">Menu</a></div><div class="nav-collapse icemegamenu collapse  "><ul id="icemegamenu" class="meganizr mzr-slide mzr-responsive"><li id="iceMenu_101" class="iceMenuLiLevel_1 active"><a href="http://thangvietsecurity.com/" class="icemega_active iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[TRANG CHỦ]]></span></a></li><li id="iceMenu_102" class="iceMenuLiLevel_1 mzr-drop parent"><a href="./gioi-thieu.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[GIỚI THIỆU]]></span></a><ul class="icesubMenu icemodules sub_level_1" style="width:250px"><li><div style="float:left;width:250px" class="iceCols"><ul><li id="iceMenu_145" class="iceMenuLiLevel_2"><a href="./gioi-thieu/gioi-thieu-7.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Sơ Đồ Tổ Chức]]></span></a></li><li id="iceMenu_146" class="iceMenuLiLevel_2"><a href="./gioi-thieu/gioi-thieu-8.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Phương Châm Hoạt Động]]></span></a></li></ul></div></li></ul></li><li id="iceMenu_103" class="iceMenuLiLevel_1 mzr-drop parent"><a href="./dich-vu-bao-ve.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[DỊCH VỤ BẢO VỆ]]></span></a><ul class="icesubMenu icemodules sub_level_1" style="width:660px"><li><div style="float:left;width:220px" class="iceCols"><ul><li id="iceMenu_147" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-toa-nha.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Toà Nhà]]></span></a></li><li id="iceMenu_148" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-nha-may.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Nhà Máy]]></span></a></li><li id="iceMenu_149" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-ngan-hang.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Ngân Hàng]]></span></a></li><li id="iceMenu_150" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-sieu-thi.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Siêu Thị]]></span></a></li><li id="iceMenu_151" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-truong-hoc.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Trường Học]]></span></a></li></ul></div><div  style="float:left;width:220px" class="iceCols"><ul><li id="iceMenu_152" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-du-an.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Dự Án]]></span></a></li><li id="iceMenu_153" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-nha-hang-khach-san.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Khách Sạn]]></span></a></li><li id="iceMenu_154" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-cua-hang.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Cửa Hàng]]></span></a></li><li id="iceMenu_155" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-cong-truong.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Công Trường]]></span></a></li><li id="iceMenu_166" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-chung-cu.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Chung Cư]]></span></a></li></ul></div><div  style="float:left;width:220px" class="iceCols"><ul><li id="iceMenu_156" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-khu-cong-nghiep.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Khu Công Nghiệp]]></span></a></li><li id="iceMenu_157" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-san-bay-ben-cang.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Sân Bay, Bến Cảng]]></span></a></li><li id="iceMenu_158" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/bao-ve-su-kien.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Sự Kiện]]></span></a></li><li id="iceMenu_159" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/2014-06-25-09-22-68.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Bảo Vệ Yếu Nhân(Vệ Sĩ)]]></span></a></li><li id="iceMenu_160" class="iceMenuLiLevel_2"><a href="./dich-vu-bao-ve/hinh-thuc-bao-ve-khac.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Hình Thức Bảo Vệ Khác]]></span></a></li></ul></div></li></ul></li><li id="iceMenu_104" class="iceMenuLiLevel_1 mzr-drop parent"><a href="./gioi-thieu-3.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[KHÁCH HÀNG]]></span></a><ul class="icesubMenu icemodules sub_level_1" style="width:220px"><li><div style="float:left;width:220px" class="iceCols"><ul><li id="iceMenu_167" class="iceMenuLiLevel_2"><a href="./gioi-thieu-3/khach-hang-cong-ty.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Khách Hàng Công Ty]]></span></a></li></ul></div></li></ul></li><li id="iceMenu_105" class="iceMenuLiLevel_1 mzr-drop parent"><a href="./tuyen-dung.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[TUYỂN DỤNG]]></span></a><ul class="icesubMenu icemodules sub_level_1" style="width:200px"><li><div style="float:left;width:200px" class="iceCols"><ul><li id="iceMenu_168" class="iceMenuLiLevel_2"><a href="./tuyen-dung/quy-trinh-tuyen-dung.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[QUY TRÌNH TUYỂN DỤNG]]></span></a></li></ul></div></li></ul></li><li id="iceMenu_170" class="iceMenuLiLevel_1 mzr-drop parent"><a href="./tin-tuc.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Tin Tức]]></span></a><ul class="icesubMenu icemodules sub_level_1" style="width:200px"><li><div style="float:left;width:200px" class="iceCols"><ul><li id="iceMenu_169" class="iceMenuLiLevel_2"><a href="./tin-tuc/dao-tao.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[Đào Tạo]]></span></a></li></ul></div></li></ul></li><li id="iceMenu_106" class="iceMenuLiLevel_1"><a href="./gioi-thieu-5.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[THIẾT BỊ BẢO VỆ]]></span></a></li><li id="iceMenu_107" class="iceMenuLiLevel_1"><a href="./lien-he.html" class=" iceMenuTitle"><span class="icemega_title icemega_nosubtitle"><![CDATA[LIÊN HỆ]]></span></a></li></ul></div></div>';		
			$xmls[$type] 	= $string;
		}
		// Get document
		require_once(JPATH_BASE.DS."modules".DS."mod_icemegamenu".DS."libs".DS."simplexml.php");
		$xml = new JSimpleXML;
		$xml->loadString($xmls[$type]);
		$doc = &$xml->document;
		//$menu	= &JSite::getMenu();
		//$active	= $menu->getActive();
		$active	= JFactory::getApplication()->getMenu();
		$start	= $params->get('startLevel');
		$end	= $params->get('endLevel');
		$sChild	= $params->get('showAllChildren');
		$path	= array();
		
		// Get subtree
		if($doc && is_callable($decorator))
		{
			$doc->map($decorator, array('end'=>$end, 'children'=>$sChild));
		}
		return $doc;
	}

	function render(&$params, $callback)
	{				
		switch($params->get('menu_style', 'list'))
		{
			case 'list_flat' :
				break;
				
			case 'horiz_flat' :
				break;

			case 'vert_indent' :
				break;

			default :
				// Include the new menu class
				//echo "<pre>";print_r($callback);exit;
				$xml = modIceMegamenuHelper::getXML($params->get('menutype'), $params, $callback);
				if($xml)
				{
					$class = $params->get('class_sfx');
					$xml->addAttribute('class', 'icemegamenu'.$class);
					
					if($tagId = $params->get('tag_id'))
					{
						$xml->addAttribute('id', $tagId);
					}
					$result = JFilterOutput::ampReplace($xml->toString((bool)$params->get('show_whitespace')));
					$result = str_replace(array('&gt;','&lt;','&quot;'), array('>','<','"'), $result);
					$result = str_replace(array('<ul/>', '<ul />'), '', $result);
					echo $result;
				}
				break;
		}
	}
	
	/**
	 * check K2 Existed ?
	 */
	public static function isK2Existed()
	{
		return is_file(JPATH_SITE.DS.  "components" . DS . "com_k2" . DS . "k2.php");	
	}
	/**
	 *  check the folder is existed, if not make a directory and set permission is 755
	 *
	 *
	 * @param array $path
	 * @access public,
	 * @return boolean.
	 */
	public static function makeDir($path)
	{
		$folders = explode('/', ($path));
		$tmppath =  JPATH_SITE.DS.'images'.DS.'icethumbs'.DS;
		
		if(!file_exists($tmppath))
		{
			JFolder::create($tmppath, 0755);
		} 
		for($i = 0; $i < count($folders) - 1; $i ++)
		{
			if(! file_exists($tmppath . $folders [$i]) && ! JFolder::create($tmppath . $folders [$i], 0755))
			{
				return false;
			}	
			$tmppath = $tmppath . $folders [$i] . DS;
		}		
		return true;
	}	
	/**
	 *  check the folder is existed, if not make a directory and set permission is 755
	 *
	 *
	 * @param array $path
	 * @access public,
	 * @return boolean.
	 */
	public static function renderThumb($path, $width=100, $height=100, $title='', $isThumb=true)
	{
		
		if($isThumb&& $path)
		{
			$path 		= str_replace(JURI::base(), '', $path);
			$imagSource = JPATH_SITE.DS. str_replace('/', DS,  $path);
			
			if(file_exists($imagSource))
			{
				$path =  $width."x".$height.'/'.$path;
				$thumbPath = JPATH_SITE.DS.'images'.DS.'icethumbs'.DS. str_replace('/', DS,  $path);
				
				if(!file_exists($thumbPath))
				{
					$thumb = PhpThumbFactory::create($imagSource);  
					if(!self::makeDir($path))
					{
							return '';
					}		
					$thumb->adaptiveResize($width, $height);
					$thumb->save($thumbPath); 
				}
				$path = JURI::base().'images/icethumbs/'.$path;
			} 
		}
		return $path;
	}
	/**
	 * Load Modules Joomla By position's name
	 */
	public function loadModulesByPosition($position='')
	{
		$modules = JModuleHelper::getModules($position);
		if($modules)
		{
			$document = &JFactory::getDocument();
			$renderer = $document->loadRenderer('module');
			$output='';
			foreach($modules  as $module)
			{
				$output .= '<div class="lof-module">'.$renderer->render($module, array('style' => 'raw')).'</div>';
			}
			return $output;
		}
		return ;
	}
	/**
	 * load css - javascript file.
	 * 
	 * @param JParameter $params;
	 * @param JModule $module
	 * @return void.
	 */
	public function loadMediaFiles($params, $module)
	{
		global $app;
		$app 			= JFactory::getApplication();
		$theme_style 	= $params->get("theme_style","default");
		
		$enable_bootrap = $params->get("enable_bootrap", 0);
		$resizable_menu = $params->get("resizable_menu", 0);
		
		$document = JFactory::getDocument();
		if($enable_bootrap == 1){
			$document->addStyleSheet(JURI::base()."media/jui/css/bootstrap.css");
				$document->addStyleSheet(JURI::base()."media/jui/css/bootstrap-responsive.css");
			$document->addScript(JURI::base()."media/jui/js/bootstrap.min.js");
		}
		
		
		if (
			(!file_exists(JPATH_ROOT.'/templates/'.$app->getTemplate().'/less/iceslideshow.less'))
			|| ( $app->getTemplate() == "it_therestaurant2")
			|| ( $app->getTemplate() == "it_planeterath")
			|| ( $app->getTemplate() == "it_blackwhite2")
			|| ( $app->getTemplate() == "it_trendyshop")
			|| ( $app->getTemplate() == "it_cinema3")
			)
		 {
			
			if(!defined("MOD_ICEMEGAMENU"))
			{
	
				$css = "templates/".$app->getTemplate()."/html/".$module->module."/css/".$theme_style."_icemegamenu.css";
				$css2 = "templates/".$app->getTemplate()."/html/".$module->module."/css/".$theme_style."_icemegamenu-ie.css";
				if($resizable_menu == 1){
					$css3 = "templates/".$app->getTemplate()."/html/".$module->module."/css/".$theme_style."_icemegamenu-reponsive.css";
				}	
				if(is_file($css)) {
					$document->addStyleSheet($css);
				} else {
					$css = JURI::base().'modules/'.$module->module.'/themes/'.$params->get('theme_style','default').'/css/'.$theme_style.'_icemegamenu.css';
					$document->addStyleSheet($css);
				}
				if(is_file($css3)) {
					$document->addStyleSheet($css3);
				} else {
					if($resizable_menu == 1){
						$css3 = JURI::base().'modules/'.$module->module.'/themes/'.$params->get('theme_style','default').'/css/'.$theme_style.'_icemegamenu-reponsive.css';
					}	
					$document->addStyleSheet($css3);
				}
				define("MOD_ICEMEGAMENU", 1);
			}
		}
	}

	/**
	 * get a subtring with the max length setting.
	 * 
	 * @param string $text;
	 * @param int $length limit characters showing;
	 * @param string $replacer;
	 * @return tring;
	 */
	public static function substring($text, $length = 100, $isStripedTags=true,  $replacer='...')
	{
		$string = $isStripedTags? strip_tags($text):$text;
		return JString::strlen($string) > $length ? JString::substr($string, 0, $length).$replacer: $string;
	}
}

if(!defined('modIceMegaMenuXMLCallbackDefined'))
{
	function modIceMegaMenuXMLCallbackDefinedXMLCallback(&$node, $args)
	{
		$user	= &JFactory::getUser();
		$menu	= &JSite::getMenu();
		$active	= $menu->getActive();
		$path	= isset($active) ? array_reverse($active->tree) : null;
	
		if(($args['end']) &&($node->attributes('level') >= $args['end']))
		{
			$children = $node->children();
			foreach($node->children() as $child)
			{
				if($child->name() == 'ul')
				{
					$node->removeChild($child);
				}
			}
		}

		if($node->name() == 'ul')
		{
			foreach($node->children() as $child)
			{
				if($child->attributes('access') > $user->get('aid', 0))
				{
					$node->removeChild($child);
				}
			}
		}
	
		if(($node->name() == 'li') && isset($node->ul))
		{
			$node->addAttribute('class', 'parent');
		}
	
		if(isset($path) &&(in_array($node->attributes('id'), $path) || in_array($node->attributes('rel'), $path)))
		{
			if($node->attributes('class'))
			{
				$node->addAttribute('class', $node->attributes('class').' active');
			}
			else
			{
				$node->addAttribute('class', 'active');
			}
		}
		else
		{
			if(isset($args['children']) && !$args['children'])
			{
				$children = $node->children();
				foreach($node->children() as $child)
				{
					if($child->name() == 'ul')
					{
						$node->removeChild($child);
					}
				}
			}
		}
	
		if(($node->name() == 'li') &&($id = $node->attributes('id')))
		{
			if($node->attributes('class'))
			{
				$node->addAttribute('class', $node->attributes('class').' item'.$id);
			}
			else
			{
				$node->addAttribute('class', 'item'.$id);
			}
		}
	
		if(isset($path) && $node->attributes('id') == $path[0])
		{
			$node->addAttribute('id', 'current');
		}
		else
		{
			$node->removeAttribute('id');
		}
		$node->removeAttribute('rel');
		$node->removeAttribute('level');
		$node->removeAttribute('access');
	}
	define('modIceMegaMenuXMLCallbackDefined', true);
}
?>
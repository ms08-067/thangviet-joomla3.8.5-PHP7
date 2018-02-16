<?php

/**
 * @package bootstrapmegamenu Bootstrap Mega Menu for Joomla
 * @subpackage mod_bootstrapmegamenu
 * @copyright Copyright (C) 2013 T.V.T Marine Automation (aka TVTMA). All rights reserved.
 * @license http://www.gnu.org/licenses GNU General Public License version 2 or later; see LICENSE.txt
 * @author url: http://ma.tvtmarine.com
 * @author TVTMA support@ma.tvtmarine.com
 */
// Deny direct access

defined('_JEXEC') or die();

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once __DIR__ . '/helper.php';
// initial declaration
$module_path = 'modules/mod_bootstrapmegamenu';
$assets_path = $module_path . '/assets';

$doc = JFactory::getDocument();
$list = ModBootstrapMegaMenuHelper::getList($params);
$base = ModBootstrapMegaMenuHelper::getBase($params);
$active = ModBootstrapMegaMenuHelper::getActive($params);
$active_id = $active->id;
$path = $base->tree;

$showAll = $params->get('showAllChildren');
$class_sfx = htmlspecialchars($params->get('class_sfx'));

$mnu_type_class = "";
switch ($params->get('mnu_type')) {
        case 1:
                $mnu_type_class = " nav-pills";
                break;
        case 2:
                $mnu_type_class = " nav-tabs";
                break;
        case 3:
                $mnu_type_class = " nav-list";
                break;
}

$plugin = JPluginHelper::getPlugin('system', 'bootstrapmegamenu');
$plg_params = new JRegistry();
$plg_params->loadString($plugin->params);

if (count($list))
{
        require JModuleHelper::getLayoutPath('mod_bootstrapmegamenu', $params->get('layout', 'default'));
}
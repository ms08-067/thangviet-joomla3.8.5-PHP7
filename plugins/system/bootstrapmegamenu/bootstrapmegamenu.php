<?php

/**
 * @package bootstrapmegamenu Bootstrap Mega Menu for Joomla
 * @subpackage plg_bootstrapmegamenu
 * @copyright Copyright (C) 2013 T.V.T Marine Automation (aka TVTMA). All rights reserved.
 * @license http://www.gnu.org/licenses GNU General Public License version 2 or later; see LICENSE.txt
 * @author url: http://ma.tvtmarine.com
 * @author TVTMA support@ma.tvtmarine.com
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');

class plgSystemBootstrapmegamenu extends JPlugin
{

        var $plugin = null;
        var $plgParams = null;
        var $time = 0;

        function __construct(&$subject, $config)
        {
                parent::__construct($subject, $config);
                $lang = JFactory::getLanguage();
                $lang->load('plg_system_bootstrapmegamenu', JPATH_ADMINISTRATOR);
        }

        function onContentPrepareForm($form, $data)
        {
                if ($form->getName() == 'com_menus.item')
                {
                        $xmlFile = dirname(__FILE__) . '/params';
                        JForm::addFormPath($xmlFile);
                        $form->loadFile('params', false);
                }
        }

}

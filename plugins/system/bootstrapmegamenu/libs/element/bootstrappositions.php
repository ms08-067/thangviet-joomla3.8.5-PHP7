<?php

/**
 * @package bootstrapmegamenu Bootstrap Mega Menu for Joomla
 * @subpackage plg_bootstrapmegamenu
 * @copyright Copyright (C) 2013 T.V.T Marine Automation (aka TVTMA). All rights reserved.
 * @license http://www.gnu.org/licenses GNU General Public License version 2 or later; see LICENSE.txt
 * @author url: http://ma.tvtmarine.com
 * @author TVTMA support@ma.tvtmarine.com
 */
// Ensure this file is being included by a parent file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldBootstrappositions extends JFormField
{

        /**
         * Element name
         *
         * @access	protected
         * @var		string
         */
        protected $_name = 'Bootstrappositions';

        protected function getInput()
        {
                $attr = '';
                // Initialize some field attributes.
                $attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
                // To avoid user's confusion, readonly="true" should imply disabled="true".
                if ((string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true')
                {
                        $attr .= ' disabled="disabled"';
                }
                $attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
                $attr .= $this->multiple ? ' multiple="multiple"' : '';
                // Initialize JavaScript field attributes.
                $attr .= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

                $db = JFactory::getDBO();
                $query = "SELECT DISTINCT position FROM #__modules ORDER BY position ASC";
                $db->setQuery($query);
                $groups = $db->loadObjectList();
                $groupHTML = array();
                if ($groups && count($groups))
                {
                        foreach ($groups as $tvalue => $item) {
                                $groupHTML[] = JHTML::_('select.option', $item->position, $item->position);
                        }
                }
                if (!empty($value) && !is_array($value))
                        $value = explode("|", $value);

                $lists = JHTML::_('select.genericlist', $groupHTML, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
                return $lists;
        }

}

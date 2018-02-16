<?php 
/**
 * @package X Spacer for Joomla! 2.5
 * @author http://Thecoders.vn
 * @copyright (C) 2011- Thecoders.vn
 * @license http://www.gnu.org/licenseses/gpl-2.0.html GNU/GPL
**/
 
// no direct access
defined('_JEXEC') or die;
/**
 * Get a collection of categories
 */
class JFormFieldXSpacer extends JFormField
{
	
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 'xspacer'; 	
	
	/**
	 * fetch Element 
	 */
	protected function getInput()
	{		
		if(!defined('X_LOADMEDIACONTROL'))
		{
			define('X_LOADMEDIACONTROL', 1);
			$uri = str_replace(DS,"/", str_replace(JPATH_SITE, JURI::base(), dirname(__FILE__)));
			$uri = str_replace("/administrator/", "", $uri);			
			JHTML::stylesheet($uri."/media/".'form.css');
			JHTML::script($uri."/media/".'form.js');
		}
	}	
	/**
	 * Method to get the field label markup.
	 *
	 * @return	string	The field label markup.
	 * @since	1.6
	 */
	protected function getLabel()
	{
		$html  = array();
		$class = $this->element['class'] ? (string) $this->element['class'] : '';

		$html[] = '<span class="spacer">';
		$html[] = '<span class="before"></span>';
		$html[] = '<span class="'.$class.'">';
		
		if((string) $this->element['hr'] == 'true')
		{
			$html[] = '<hr class="'.$class.'" />';
		}
		else
		{
			$label = '';
			// Get the label text from the XML element, defaulting to the element name.
			$text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
			$text = $this->translateLabel ? JText::_($text) : $text;

			// Build the class for the label.
			$class = !empty($this->description) ? 'hasTip' : '';
			$class = $this->required == true ? $class.' required' : $class;

			// Add the opening label tag and main attributes attributes.
			$label .= '<label id="'.$this->id.'-lbl" class="'.$class.'"';

			// If a description is specified, use it to build a tooltip.
			if(!empty($this->description)) {
				$label .= ' title="'.htmlspecialchars(trim($text, ':').'::' .
							($this->translateDescription ? JText::_($this->description) : $this->description), ENT_COMPAT, 'UTF-8').'"';
			}

			// Add the label text and closing tag.
			$label .= '>'.$text.'</label>';
			$html[] = $label;
		}
		
		$html[] = '</span>';
		$html[] = '<span class="after"></span>';
		$html[] = '</span>';
		return implode('',$html);
	}
	/**
	 * Method to get the field title.
	 *
	 * @return	string	The field title.
	 * @since	1.6
	 */
	protected function getTitle()
	{
		return $this->getLabel();
	}
}
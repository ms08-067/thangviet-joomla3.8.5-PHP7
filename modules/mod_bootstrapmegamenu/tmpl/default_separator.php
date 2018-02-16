<?php
/**
 * @package bootstrapmegamenu Bootstrap Mega Menu for Joomla
 * @subpackage mod_bootstrapmegamenu
 * @copyright Copyright (C) 2013 T.V.T Marine Automation (aka TVTMA). All rights reserved.
 * @license http://www.gnu.org/licenses GNU General Public License version 2 or later; see LICENSE.txt
 * @author url: http://ma.tvtmarine.com
 * @author TVTMA support@ma.tvtmarine.com
 */
defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$title = $item->anchor_title ? ' title="' . $item->anchor_title . '" ' : '';
if ($item->menu_image)
{
        $item->params->get('menu_text', 1) ?
                        $linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /> <span class="image-title">' . $item->title . '</span> ' :
                        $linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />';
} else
{
        $linktype = $item->title;
}

/* BEGIN Glyphicons */
$glyphicon_classes = trim($item->params->get('glyphicon'));
if ($glyphicon_classes)
{
        $linktype = '<span class="' . $glyphicon_classes . '"></span> ' . $linktype;
}
/* END Glyphicons */
?><span class="separator"<?php echo $title; ?>><?php echo $linktype; ?></span>
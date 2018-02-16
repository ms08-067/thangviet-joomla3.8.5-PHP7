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
/* BEGIN icons */
$glyphicon_classes = trim($item->params->get('glyphicon'));
$icon = $glyphicon_classes ? '<span class="' . $glyphicon_classes . '"></span> ' : '';
/* END icons */
?>
<span class="nav-header"><?php echo $icon . $item->title; ?></span>
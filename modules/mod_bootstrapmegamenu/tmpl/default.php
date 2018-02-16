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
$app = JFactory::getApplication();
$menu = $app->getMenu();
$lang = JFactory::getLanguage();
$default_mnu = $menu->getDefault($lang->getTag());

$bootstrap_ver = $plg_params->get('t-boostrapmegamenu_bootstrapversion', '2.x');
$mnu_right_align = $params->get('mnu_right_align', 0);
$min_css = '.min';
//$min_css = '';
switch ($bootstrap_ver) {
        case '3.x':
                $row = 'row';
                $list_unstyled = 'list-unstyled';
                $navbar_collapse = 'navbar-collapse collapse';
                $navbar_btn_class = 'navbar-toggle collapsed';
                $load_css = 'multi-col-bootstrap3' . $min_css . '.css';
                $mnu_right_align = $mnu_right_align ? ' navbar-right' : '';
                break;

        default:
                $row = 'row-fluid';
                $list_unstyled = 'unstyled';
                $navbar_collapse = 'nav-collapse collapse';
                $navbar_btn_class = 'btn btn-navbar';
                $load_css = 'multi-col' . $min_css . '.css';
                $mnu_right_align = $mnu_right_align ? ' pull-right' : '';
                break;
}
$use_module_css = $params->get('use_module_css', 1);
?>
<div class="tvtma-megamnu navbar <?php echo $params->get('navbar_class', 'navbar-default'); ?>" role="navigation">
        <div class="container">
                <div class="navbar-header">
                        <button type="button" class="<?php echo $navbar_btn_class; ?>" data-toggle="collapse" data-target="#tvtma-megamnu">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                        </button>
                        <?php if ($logo = $params->get('logo', '')): ?>
                                <?php if ($logo_img_class = $params->get('logo_img_class', '')): ?>
                                        <?php $logo_img_class = 'class="' . $logo_img_class . '" '; ?>
                                <?php endif; ?>
                                <?php if ($params->get('enable_logo_link', '')): ?>
                                        <?php if ($logo_link_class = $params->get('logo_link_class', '')): ?>
                                                <?php $logo_link_class = 'class="' . $logo_link_class . '" '; ?>
                                        <?php endif; ?>
                                        <a <?php echo $logo_link_class; ?>href="<?php echo $default_mnu->flink; ?>">
                                        <?php endif; ?>
                                        <img <?php echo $logo_img_class; ?>src="<?php echo $logo; ?>" title="<?php echo ''; ?>" />

                                        <?php if ($params->get('enable_logo_link', '')): ?>
                                        </a>
                                <?php endif; ?>

                        <?php endif; ?>
                </div>

                <<?php echo $params->get('wrappertag', 'div'); ?> class="<?php echo $navbar_collapse; ?>" id="tvtma-megamnu">
                <ul class="nav navbar-nav<?php echo $mnu_right_align . $mnu_type_class . $class_sfx; ?>"<?php
                    $tag = '';
                    if ($params->get('tag_id') != null)
                    {
                            $tag = $params->get('tag_id') . '';
                            echo ' id="' . $tag . '"';
                    }
                    ?>>
                            <?php
                            $load_multicol_css = false;
                            $nav_child = ($params->get('enable_hoverdropdown', 0) == 1) ? 'nav-child ' : '';

                            $multicol_start = false;
                            $col_no = 0;
                            $lastitem = 0;
                            foreach ($list as $i => &$item) :

                                    $multi_col = $item->params->get('multicol_start');
                                    if ($multi_col)
                                    {
                                            $load_multicol_css = true;
                                    }
                                    $menu_subtitle = $item->params->get('bootstrapmega_subtitle');
                                    $bootstrapmega_width = trim($item->params->get('bootstrapmega_width'));
                                    $bootstrapmega_subtype = $item->params->get('bootstrapmega_subtype');
                                    $bootstrapmega_modules = $item->params->get('bootstrapmega_modules');
                                    $bootstrapmega_positions = $item->params->get('bootstrapmega_positions');

                                    $class = 'item-' . $item->id;
                                    if ($item->id == $active_id)
                                    {
                                            $class .= ' current';
                                    }

                                    if (in_array($item->id, $path))
                                    {
                                            $class .= ' active';
                                    } elseif ($item->type == 'alias')
                                    {
                                            $aliasToId = $item->params->get('aliasoptions');
                                            if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
                                            {
                                                    $class .= ' active';
                                            } elseif (in_array($aliasToId, $path))
                                            {
                                                    $class .= ' alias-parent-active';
                                            }
                                    }

                                    if ($item->type == 'separator')
                                    {
                                            $class .= ' divider';
                                    }

                                    if ($item->deeper)
                                    {
                                            $class .= ' deeper';
                                    }

                                    if ($item->parent)
                                    {
                                            $class .= ' parent dropdown';
                                            if ($bootstrapmega_width == 'full')
                                            {
                                                    $class .=' tvtma-megamnu-fullwidth';
                                            }
                                    }
                                    if ($list[$lastitem]->col_header)
                                    {
                                            $class .= 'megacol-header';
                                    }
                                    if ($item->deeper && $item->level > 1)
                                    {
                                            $class = str_replace('dropdown', '', $class);
                                            if (!$item->multicol_element)
                                            {
                                                    $class .= ' dropdown-submenu';
                                            }
                                    }

                                    if (!empty($class))
                                    {
                                            $class = ' class="' . trim($class) . '"';
                                    }

                                    echo '<li' . $class . '>';

                                    // Render the menu item.
                                    switch ($item->type) :
                                            case 'separator':
                                            case 'url':
                                            case 'component':
                                            case 'heading':
                                                    require JModuleHelper::getLayoutPath('mod_bootstrapmegamenu', 'default_' . $item->type);
                                                    break;

                                            default:
                                                    require JModuleHelper::getLayoutPath('mod_bootstrapmegamenu', 'default_url');
                                                    break;
                                    endswitch;

                                    // The next is a column header
                                    if ($item->col_header)
                                    {
                                            // The next item is the first item of the first column
                                            if ($item->multicol_start)
                                            {
                                                    $multicol_start = true;
                                                    $col_no = 0;
                                                    $width_style = ($bootstrapmega_width == 'full' || $bootstrapmega_width == '') ? '' : 'width: ' . $bootstrapmega_width . ';"';
                                                    $left_offset = trim($item->params->get('left_offset'));
                                                    $left_offset = $left_offset ? 'left: ' . $left_offset . ';' : '';

                                                    $right_offset = trim($item->params->get('right_offset'));
                                                    $right_offset = $right_offset ? 'right: ' . $right_offset . ';' : '';

                                                    $offset_style = ($left_offset || $right_offset || $width_style) ? ' style="' . $left_offset . $right_offset . $width_style . '"' : '';
                                                    echo '<ul class="' . $nav_child . $list_unstyled . ' dropdown-menu"' . $offset_style . '>
                                                                <li>
                                                                <div class="' . $row . '">
                                                                <div class="tvtma-megamnu-content">';
                                            }
                                            // The next item is a column header but not the first column under the multi-column menu item
                                            else
                                            {
                                                    echo '</ul>';
                                            }

                                            if ($multicol_start)
                                            {
                                                    switch ($bootstrap_ver) {
                                                            case '3.x':
                                                                    $span_width = $item->col_width ? 'col-md-' . $item->col_width . ' ' : 'col-md-12 ';

                                                                    break;

                                                            default:
                                                                    $span_width = $item->col_width ? 'span' . $item->col_width . ' ' : 'span12 ';
                                                                    break;
                                                    }

                                                    echo '<ul class="' . $span_width . $list_unstyled . '">';
                                            }
                                    }
                                    // Normal item in a multicol
                                    elseif ($item->multicol_element)
                                    {
                                            // No further action is needed
                                    }
                                    // The next item is deeper.
                                    elseif ($item->deeper)
                                    {
                                            echo '<ul class="' . $nav_child . $list_unstyled . ' dropdown-menu">';
                                    } elseif ($item->multicol_end)
                                    {
                                            $multicol_start = false;
                                            echo '</div></div></li></ul>';
                                    }
                                    // The next item is shallower.
                                    elseif ($item->shallower)
                                    {
                                            echo '</li>';

                                            echo str_repeat('</ul></li>', $item->level_diff);
                                    }

                                    // The next item is on the same level.
                                    else
                                    {
                                            echo '</li>';
                                    }
                                    $lastitem = $i;
                            endforeach;

                            if ($load_multicol_css && $use_module_css)
                            {
                                    $doc->addStyleSheet($assets_path . '/css/' . $load_css);
                            }
                            ?>
                </ul>
                </<?php echo $params->get('wrappertag', 'div'); ?>>
        </div>
</div>
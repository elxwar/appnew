<?php
defined('_JEXEC') or die;

if (!defined('_ARTX_FUNCTIONS'))
  require_once dirname(__FILE__) . str_replace('/', DIRECTORY_SEPARATOR, '/../functions.php');

function modChrome_artstyle($module, &$params, &$attribs)
{
  $style = isset($attribs['artstyle']) ? $attribs['artstyle'] : 'art-nostyle';
  $styles = array(
    'art-nostyle' => 'modChrome_artnostyle',
    'art-block' => 'modChrome_artblock',
    'art-article' => 'modChrome_artarticle',
    'art-vmenu' => 'modChrome_artvmenu'
  );
  // moduleclass_sfx support:
  //  '' or 'suffix'   - use default style, suffix will not be added to the module tag
  //                     but will be added to the module elements.
  //  ' suffix'        - adds suffix to the module root tag as well as to the module elements.
  //  'art-...'        - overwrites module style.
  //  'suffix art-...' - overwrites style and adds suffix to the module root tag and
  //                     to the module elements, does not add art-... to the module elements.
  $classes = explode(' ', rtrim($params->get('moduleclass_sfx')));
  $keys = array_keys($styles);
  $art = array();
  foreach ($classes as &$class) {
    if (in_array($class, $keys)) {
      $art[] = $class;
      $class = ' ';
    }
  }
  $classes = str_replace('  ', ' ', implode(' ', $classes));
  $style = count($art) ? array_pop($art) : $style;
  $params->set('moduleclass_sfx', $classes);
  call_user_func($styles[$style], $module, $params, $attribs);
}

function modChrome_artnostyle($module, &$params, &$attribs)
{
if (!empty ($module->content)) : ?>
<div class="art-nostyle<?php echo $params->get('moduleclass_sfx'); ?>">
<?php if ($module->showtitle != 0) : ?>
<h3><?php echo $module->title; ?></h3>
<?php endif; ?>
<?php echo $module->content; ?>
</div>
<?php endif;
}

function modChrome_artblock($module, &$params, &$attribs)
{
  if (!empty ($module->content))
    echo artxBlock(($module->showtitle != 0) ? $module->title : '', $module->content,
      $params->get('moduleclass_sfx'));
}

function modChrome_artvmenu($module, &$params, &$attribs)
{
  if (!empty ($module->content)) {
    if (function_exists('artxVMenuBlock'))
      echo artxVMenuBlock(($module->showtitle != 0) ? $module->title : '', $module->content,
        $params->get('moduleclass_sfx'));
    else
      echo artxBlock(($module->showtitle != 0) ? $module->title : '', $module->content,
        $params->get('moduleclass_sfx'));
  }
}

function modChrome_artarticle($module, &$params, &$attribs)
{
  if (!empty ($module->content)) {
    $data = array('classes' => $params->get('moduleclass_sfx'), 'content' => $module->content);
    if ($module->showtitle != 0)
      $data['header-text'] = $module->title;
    echo artxPost($data);
  }
}

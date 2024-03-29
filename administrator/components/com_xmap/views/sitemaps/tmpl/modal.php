<?php
/**
 * @version             $Id$
 * @copyright			Copyright (C) 2007 - 2009 Joomla! Vargas. All rights reserved.
 * @license             GNU General Public License version 2 or later; see LICENSE.txt
 * @author              Guillermo Vargas (guille@vargas.co.cr)
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');

$function = JRequest::getVar('function', 'jSelectSitemap');
$n = count($this->items);
?>
<form action="<?php echo JRoute::_('index.php?option=com_xmap&view=sitemaps');?>" method="post" name="adminForm">
	<fieldset class="filter clearfix">
		<div class="left">
			<label for="search">
				<?php echo JText::_('JSearch_Filter_Label'); ?>
			</label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" size="60" title="<?php echo JText::_('Xmap_Filter_Search_Desc'); ?>" />

			<button type="submit">
				<?php echo JText::_('JSearch_Filter_Submit'); ?></button>
			<button type="button" onclick="$('filter_search').value='';this.form.submit();">
				<?php echo JText::_('JSearch_Filter_Clear'); ?></button>
		</div>

		<div class="right">
			<select name="filter_access" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOption_Select_Access');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'));?>
			</select>

			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOption_Select_Published');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>

		</div>
	</fieldset>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(this)" />
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'Xmap_Heading_Sitemap', 'a.title', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'Xmap_Heading_Published', 'a.state', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'JGrid_Heading_Access', 'access_level', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
				</th>
				<th width="10%" nowrap="nowrap">
					<?php echo JText::_('Xmap_Heading_Html_Stats'); ?><br />
					(<?php echo JText::_('Xmap_Heading_Num_Links') . ' / '. JText::_('Xmap_Heading_Num_Hits') . ' / ' . JText::_('Xmap_Heading_Last_Visit'); ?>)
				</th>
				<th width="10%" nowrap="nowrap">
					<?php echo JText::_('Xmap_Heading_Xml_Stats'); ?><br />
					<?php echo JText::_('Xmap_Heading_Num_Links') . '/'. JText::_('Xmap_Heading_Num_Hits') . '/' . JText::_('Xmap_Heading_Last_Visit'); ?>
				</th>
				<th width="1%" nowrap="nowrap">
					<?php echo JHtml::_('grid.sort', 'JGrid_Heading_ID', 'a.id', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :

                        $now = JFactory::getDate()->toUnix();
			if ( !$item->lastvisit_html ) {
				$htmlDate = JText::_('Date_Never');
			}elseif ( $item->lastvisit_html > ($now-3600)) { // Less than one hour
				$htmlDate = JText::sprintf('Date_Minutes_Ago',intval(($now-$item->lastvisit_html)/60));
			} elseif ( $item->lastvisit_html > ($now-86400)) { // Less than one day
				$hours = intval (($now-$item->lastvisit_html)/3600 );
				$htmlDate = JText::sprintf('Date_Hours_Minutes_Ago',$hours,($now-($hours*3600)-$item->lastvisit_html)/60);
			} elseif ( $item->lastvisit_html > ($now-259200)) { // Less than three days
				$days = intval(($now-$item->lastvisit_html)/86400);
				$htmlDate = JText::sprintf('Date_Days_Hours_Ago',$days,intval(($now-($days*86400)-$item->lastvisit_html)/3600));
			} else {
				$date = new JDate($item->lastvisit_html);
				$htmlDate = $date->toFormat('%Y-%m-%d %H:%M');
			}

			if ( !$item->lastvisit_xml ) {
				$xmlDate = JText::_('Date_Never');
			} elseif ( $item->lastvisit_xml > ($now-3600)) { // Less than one hour
				$xmlDate = JText::sprintf('Date_Minutes_Ago',intval(($now-$item->lastvisit_xml)/60));
			} elseif ( $item->lastvisit_xml > ($now-86400)) { // Less than one day
				$hours = intval (($now-$item->lastvisit_xml)/3600 );
				$xmlDate = JText::sprintf('Date_Hours_Minutes_Ago',$hours,($now-($hours*3600)-$item->lastvisit_xml)/60);
			} elseif ( $item->lastvisit_xml > ($now-259200)) { // Less than three days
				$days = intval(($now-$item->lastvisit_xml)/86400);
				$xmlDate = JText::sprintf('Date_Days_Hours_Ago',$days,intval(($now-($days*86400)-$item->lastvisit_xml)/3600));
			} else {
				$date = new JDate($item->lastvisit_xml);
				$xmlDate = $date->toFormat('%Y-%m-%d %H:%M');
			}

			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td style="text-align:center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<td>
					<a style="cursor: pointer;" onclick="if (window.parent) window.parent.<?php echo $function;?>('<?php echo $item->id; ?>', '<?php echo $this->escape($item->title); ?>');">
						<?php echo $this->escape($item->title); ?></a>
				</td>
				<td align="center">
					<?php echo JHtml::_('jgrid.published', $item->state, $i, 'sitemaps.'); ?>
				</td>
				<td align="center">
					<?php echo $this->escape($item->access_level); ?>
				</td>
				<td class="center">
					<?php echo $item->count_html .' / '.$item->views_html. ' / ' . $htmlDate; ?>
				</td>
				<td class="center">
					<?php echo $item->count_xml .' / '.$item->views_xml. ' / ' . $xmlDate; ?>
				</td>
				<td align="center">
					<?php echo (int) $item->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<input type="hidden" name="tmpl" value="component" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->state->get('list.ordering'); ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->state->get('list.direction'); ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>

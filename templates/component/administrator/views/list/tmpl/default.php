<?php
/**
 * @package     {{ sentenceCase componentName }}
 * @subpackage  {{ lowerCase componentName }}
 *
 * @copyright   {{ copyright }}
 * @license     {{ licence }}
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');
HTMLHelper::_('bootstrap.tooltip');

$userId    = $this->user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $this->user->authorise('core.edit.state', 'com_{{ lowerCase componentName }}');
$saveOrder = $listOrder == 'a.ordering';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_{{ lowerCase componentName }}&task={{ lowerCase entityName }}s.saveOrderAjax&tmpl=component';
	HTMLHelper::_('sortablelist.sortable', '{{ lowerCase entityName }}List', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();
?>

<form action="<?php echo Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}s'); ?>" method="post"
	name="adminForm" id="adminForm">
	<?php
	if (!empty($this->sidebar))
	{
		?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>

		<div id="j-main-container" class="span10">
		<?php
	}
	else
	{
		?>
		<div id="j-main-container">
		<?php
	}
	?>

			<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

			<div class="clearfix"></div>

			<table class="table table-striped" id="{{ lowerCase entityName }}List">
				<thead>
					<tr>
						<?php
						if (isset($this->items[0]->ordering))
						{
							?>
							<th width="1%" class="nowrap center hidden-phone">
								<?php echo HTMLHelper::_(
									'searchtools.sort', '',
									'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING',
									'icon-menu-2'); ?>
							</th>
							<?php
						}
						?>

						<th width="1%" class="center hidden-phone">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>

						<?php
						if (isset($this->items[0]->state))
						{
							?>
							<th width="1%" class="nowrap center">
								<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
							</th>
							<?php
						}
						?>

						<th class="left">
							<?php echo JHtml::_('searchtools.sort',  'COM_{{ constantCase componentName }}_{{ constantCase viewName }}_TITLE', 'a.title', $listDirn, $listOrder); ?>
						</th>

						<th class="">
							<?php echo JHtml::_('searchtools.sort',  'COM_{{ constantCase componentName }}_{{ constantCase viewName }}_ID', 'a.id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>

				<tbody>
					<?php
					foreach ($this->items as $i => $item)
					{
						$ordering   = ($listOrder == 'a.ordering');
						$canCreate  = $this->user->authorise('core.create', 'com_{{ lowerCase componentName }}');
						$canEdit    = $this->user->authorise('core.edit', 'com_{{ lowerCase componentName }}');
						$canCheckin = $this->user->authorise('core.manage', 'com_{{ lowerCase componentName }}');
						$canChange  = $this->user->authorise('core.edit.state', 'com_{{ lowerCase componentName }}');
						?>

						<tr class="row<?php echo $i % 2; ?>">

							<?php
							if (isset($this->items[0]->ordering))
							{
								?>
								<td class="order nowrap center hidden-phone">
									<?php
									if ($canChange)
									{
										$disableClassName = '';
										$disabledLabel = '';

										if (!$saveOrder)
										{
											$disabledLabel    = Text::_('JORDERINGDISABLED');
											$disableClassName = 'inactive tip-top';
										}
										?>

										<span class="sortable-handler hasTooltip <?php echo $disableClassName ?>"
											title="<?php echo $disabledLabel ?>">
												<i class="icon-menu"></i>
										</span>

										<input type="text" style="display:none" name="order[]" size="5"
											value="<?php echo $item->ordering; ?>" class="width-20 text-area-order "/>

										<?php
									}
									else
									{
										?>
										<span class="sortable-handler inactive">
											<i class="icon-menu"></i>
										</span>
										<?php
									}
									?>
								</td>
								<?php
							}
							?>

							<td class="center hidden-phone">
								<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
							</td>

							<?php
							if (isset($this->items[0]->state))
							{
								?>
								<td class="center">
									<?php echo JHtml::_('jgrid.published', $item->state, $i, '{{ lowerCase entityName }}s.', $canChange, 'cb'); ?>
								</td>
								<?php
							}
							?>

							<td>
								<?php
								if (isset($item->checked_out) && $item->checked_out && ($canEdit || $canChange))
								{
									echo JHtml::_('jgrid.checkedout', $i, $item->uEditor, $item->checked_out_time, '{{ lowerCase entityName }}s.', $canCheckin);
								}

								if ($canEdit)
								{
									?>
									<a href="<?php echo Route::_('index.php?option=com_{{ lowerCase componentName }}&task={{ lowerCase entityName }}.edit&id=' . (int) $item->id); ?>">
										<?php echo $this->escape($item->title); ?></a>
									<?php
								}
								else
								{
									echo $this->escape($item->title);
								}
								?>
							</td>

							<td><?php echo $item->id; ?></td>
						</tr>
						<?php
					}
					?>
				</tbody>

				<tfoot>
					<tr>
						<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
			</table>

			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="boxchecked" value="0"/>

			<?php echo HTMLHelper::_('form.token'); ?>
		</div>
</form>

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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');
HTMLHelper::_('bootstrap.tooltip');

$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
?>

<div class="{{ lowerCase entityName }}-list row-fluid">
	<div class="row-fluid">
		<h1><?php echo $this->document->getTitle(); ?></h1>
	</div>

	<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post"
		  name="adminForm" id="adminForm">

		<?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>

		<div class="table-responsive">
			<table class="table table-striped" id="{{ lowerCase entityName }}List">
				<thead>
					<tr>
						<?php
						if (isset($this->items[0]->state))
						{
							?>
							<th width="5%">
								<?php echo JHtml::_('searchtools.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
							</th>
							<?php
						}
						?>

						<th class=''>
							<?php echo JHtml::_('searchtools.sort',  'COM_{{ constantCase componentName }}_{{ constantCase viewName }}_NAME', 'a.name', $listDirn, $listOrder); ?>
						</th>

						<th class=''>
							<?php echo JHtml::_('searchtools.sort',  'COM_{{ constantCase componentName }}_{{ constantCase viewName }}_ID', 'a.id', $listDirn, $listOrder); ?>
						</th>

						<?php
						if ($this->canEdit || $this->canDelete)
						{
							?>
							<th class="center">
								<?php echo Text::_('COM_{{ constantCase componentName }}_ACTIONS'); ?>
							</th>
							<?php
						}
						?>
					</tr>
				</thead>

				<tbody>
					<?php
					foreach ($this->items as $i => $item)
					{
						$this->canEdit = $this->user->authorise('core.edit', 'com_{{ lowerCase componentName }}');

						if (!$this->canEdit && $this->user->authorise('core.edit.own', 'com_{{ lowerCase componentName }}'))
						{
							$this->canEdit = Factory::getUser()->id == $item->created_by;
						}
						?>

						<tr class="row<?php echo $i % 2; ?>">
							<?php
							if (isset($this->items[0]->state))
							{
								$class = ($this->canChange) ? 'active' : 'disabled';
								?>

								<td class="center">
									<a class="btn btn-micro <?php echo $class; ?>"
										href="<?php echo ($this->canChange) ? JRoute::_('index.php?option=com_{{ lowerCase componentName }}&task={{ lowerCase entityName }}.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
										<?php
										if ($item->state == 1)
										{
											?>
											<i class="icon-publish"></i>
											<?php
										}
										else
										{
											?>
											<i class="icon-unpublish"></i>
											<?php
										}
										?>
									</a>
								</td>

								<?php
							}
							?>

							<td>
								<?php
								if (isset($item->checked_out) && $item->checked_out)
								{
									echo JHtml::_('jgrid.checkedout', $i, $item->uEditor, $item->checked_out_time, '{{ lowerCase entityName }}s.', $this->canCheckin);
								}
								?>
								<a href="<?php echo JRoute::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}&id=' . (int) $item->id); ?>">
									<?php echo $this->escape($item->name); ?>
								</a>
							</td>

							<td><?php echo $item->id; ?></td>


							<?php
							if ($this->canEdit || $this->canDelete)
							{
								?>
								<td class="center">
									<?php
									if ($this->canEdit)
									{
										?>
										<a href="<?php echo JRoute::_('index.php?option=com_{{ lowerCase componentName }}&task={{ lowerCase entityName }}form.edit&id=' . $item->id, false, 2); ?>"
											class="btn btn-mini" type="button">
											<i class="icon-edit" ></i>
										</a>
										<?php
									}
									?>

									<?php
									if ($this->canDelete)
									{
										?>
										<a href="<?php echo JRoute::_('index.php?option=com_{{ lowerCase componentName }}&task={{ lowerCase entityName }}form.remove&id=' . $item->id, false, 2); ?>"
											class="btn btn-mini delete-button" type="button">
											<i class="icon-trash" ></i>
										</a>
										<?php
									}
									?>
								</td>
								<?php
							}
							?>
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
		</div>

		<?php
		if ($this->canCreate)
		{
			?>
			<a href="<?php echo Route::_('index.php?option=com_{{ lowerCase componentName }}&task={{ lowerCase entityName }}form.edit&id=0', false, 0); ?>"
				class="btn btn-success btn-small">
				<i class="icon-plus"></i>
				<?php echo Text::_('COM_{{ constantCase componentName }}_ADD_ITEM'); ?>
			</a>
			<?php
		}
		?>

		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="boxchecked" value="0"/>

		<?php echo HTMLHelper::_('form.token'); ?>
	</form>
</div>

<?php
if ($this->canDelete)
{
	?>
	<script type="text/javascript">
		jQuery(document).ready(function () {
			jQuery('.delete-button').click(deleteItem);
		});

		function deleteItem() {
			if (!confirm("<?php echo Text::_('COM_{{ constantCase componentName }}_DELETE_MESSAGE'); ?>")) {
				return false;
			}
		}
	</script>
	<?php
}

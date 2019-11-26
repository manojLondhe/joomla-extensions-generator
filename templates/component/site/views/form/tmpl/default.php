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

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidation');
HTMLHelper::_('formbehavior.chosen', 'select');
HTMLHelper::_('bootstrap.tooltip');
?>

<div class="{{ lowerCase entityName }}-edit front-end-edit row-fluid">
	<div class="row-fluid">
		<?php
		if (!empty($this->item->id))
		{
			?>
			<h1><?php echo Text::sprintf('COM_{{ constantCase componentName }}_EDIT_{{ constantCase entityName }}_TITLE', $this->item->id); ?></h1>
			<?php
		}
		else
		{
			?>
			<h1><?php echo Text::_('COM_{{ constantCase componentName }}_ADD_{{ constantCase entityName }}_TITLE'); ?></h1>
			<?php
		}?>
	</div>

	<form id="form-{{ lowerCase entityName }}"
		action="<?php echo Route::_('index.php?option=com_{{ lowerCase componentName }}&task={{ lowerCase viewName }}.save'); ?>"
		method="post" class="form-validate form-horizontal" enctype="multipart/form-data">

		<div class="row-fluid">
			<?php echo $this->form->renderField('name'); ?>
		</div>

		<?php
		// Add other fields
		?>

		<div class="row-fluid">
			<div class="control-group">
				<div class="controls">
					<?php
					if ($this->canSave)
					{
						?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo Text::_('JSUBMIT'); ?>
						</button>
						<?php
					}
					?>

					<a class="btn"
					   href="<?php echo Route::_('index.php?option=com_{{ lowerCase componentName }}&task={{ lowerCase viewName }}.cancel'); ?>"
					   title="<?php echo Text::_('JCANCEL'); ?>">
						<?php echo Text::_('JCANCEL'); ?>
					</a>
				</div>
			</div>
		</div>

		<input type="hidden" name="jform[id]"               value="<?php echo $this->item->id; ?>" />
		<input type="hidden" name="jform[ordering]"         value="<?php echo $this->item->ordering; ?>" />
		<input type="hidden" name="jform[state]"            value="<?php echo $this->item->state; ?>" />
		<input type="hidden" name="jform[checked_out]"      value="<?php echo $this->item->checked_out; ?>" />
		<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

		<input type="hidden" name="option" value="com_{{ lowerCase componentName }}"/>
		<input type="hidden" name="task" value="{{ lowerCase viewName }} .save"/>
		<?php echo HTMLHelper::_('form.token'); ?>
	</form>
</div>

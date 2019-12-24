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
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidation');
HTMLHelper::_('formbehavior.chosen', 'select');
HTMLHelper::_('bootstrap.tooltip');

$doc = Factory::getDocument();

$script = "
	Joomla.submitbutton = function (task) {
		if (task == '{{ lowerCase viewName }}.cancel') {
			Joomla.submitform(task, document.getElementById('{{ lowerCase entityName }}-form'));
		}
		else {
			if (task != '{{ lowerCase viewName }}.cancel' && document.formvalidator.isValid(document.id('{{ lowerCase entityName }}-form'))) {
				Joomla.submitform(task, document.getElementById('{{ lowerCase entityName }}-form'));
			}
			else {
				alert(Joomla.JText._('JGLOBAL_VALIDATION_FORM_FAILED'));
			}
		}
	}
";

$doc->addScriptDeclaration($script);

Text::script('JGLOBAL_VALIDATION_FORM_FAILED');
?>

<div class="{{ lowerCase entityName }}-edit row-fluid">
	<form
		action="<?php echo Route::_('index.php?option=com_{{ lowerCase componentName }}&layout=edit&id=' . (int) $this->item->id); ?>"
		method="post" enctype="multipart/form-data" name="adminForm" id="{{ lowerCase entityName }}-form" class="form-validate form-horizontal">

		<?php // @echo $this->form->renderField('created_by'); ?>
		<?php // @echo $this->form->renderField('modified_by'); ?>

		<div class="row-fluid">
			<?php echo $this->form->renderField('name'); ?>
		</div>

		<input type="hidden" name="jform[id]"               value="<?php echo $this->item->id; ?>" />
		<input type="hidden" name="jform[ordering]"         value="<?php echo $this->item->ordering; ?>" />
		<input type="hidden" name="jform[state]"            value="<?php echo $this->item->state; ?>" />
		<input type="hidden" name="jform[checked_out]"      value="<?php echo $this->item->checked_out; ?>" />
		<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />
		<input type="hidden" name="task"                    value=""/>

		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>

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
use Joomla\CMS\Language\Text;

jimport('joomla.application.component.view');

/**
 * View to edit {{ camelCase componentName }}
 *
 * @package  {{ sentenceCase componentName }}
 *
 * @since    {{ version }}
 */
class {{ sentenceCase componentName }}View{{ sentenceCase viewName }} extends \Joomla\CMS\MVC\View\HtmlView
{
	protected $state;

	protected $item;

	protected $form;

	protected $user;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->user  = Factory::getUser();
		$this->state = $this->get('State');
		$this->item  = $this->get('Item');
		$this->form  = $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * checks if user has access to create or edit record
	 *
	 * @return boolean
	 *
	 * @throws Exception
	 */
	protected function isAuthorised()
	{
		$authorised = false;

		// New record
		if (empty($this->item->id))
		{
			if ($this->user->authorise('core.create', 'com_{{ lowerCase componentName }}'))
			{
				$authorised = true;
			}
		}
		// Edit record
		else
		{
			// User has access to edit any record
			if ($this->user->authorise('core.edit', 'com_{{ lowerCase componentName }}'))
			{
				$authorised = true;
			}
			else
			{
				// If item has created_by field
				if (isset($this->item->created_by))
				{
					// User has access to edit own record && user is owner of this record
					if ($this->user->authorise('core.edit.own', 'com_{{ lowerCase componentName }}') && $this->item->created_by == $this->user->id)
					{
						$authorised = true;
					}
				}
			}
		}

		return $authorised;
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function addToolbar()
	{
		Factory::getApplication()->input->set('hidemainmenu', true);

		$isNew = ($this->item->id == 0);

		if (isset($this->item->checked_out))
		{
			$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $this->user->get('id'));
		}
		else
		{
			$checkedOut = false;
		}

		$canDo = {{ sentenceCase componentName }}Helper::getActions();

		JToolBarHelper::title(Text::_('COM_{{ constantCase componentName }}_{{ constantCase viewName }}_PAGE_TITLE'), 'edit.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create'))))
		{
			JToolBarHelper::apply('{{ lowerCase viewName }}.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('{{ lowerCase viewName }}.save', 'JTOOLBAR_SAVE');
		}

		if (!$checkedOut && ($canDo->get('core.create')))
		{
			JToolBarHelper::custom('{{ lowerCase viewName }}.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create'))
		{
			JToolBarHelper::custom('{{ lowerCase viewName }}.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}

		if (empty($this->item->id))
		{
			JToolBarHelper::cancel('{{ lowerCase viewName }}.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			JToolBarHelper::cancel('{{ lowerCase viewName }}.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}

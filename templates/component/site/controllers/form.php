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
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

/**
 * Controller for form for {{ camelCase entityName }}
 *
 * @package  {{ sentenceCase componentName }}
 *
 * @since    {{ version }}
 */
class {{ sentenceCase componentName }}Controller{{ sentenceCase viewName }} extends \Joomla\CMS\MVC\Controller\FormController
{
	/**
	 * Method to edit an existing record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key
	 *                           (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if access level check and checkout passes, false otherwise.
	 *
	 * @since   {{ version }}
	 */
	public function edit($key = null, $urlVar = null)
	{
		$app = Factory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id');
		$editId     = $app->input->getInt('id', 0);

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id', $editId);

		// Get the model.
		$model = $this->getModel('{{ sentenceCase entityName }}Form', '{{ sentenceCase componentName }}Model');

		// Check out the item
		if ($editId)
		{
			$model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId)
		{
			$model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase viewName }}&id=' . $editId, false));
	}

	/**
	 * Method to save a record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if successful, false otherwise.
	 *
	 * @since   {{ version }}
	 */
	public function save($key = null, $urlVar = null)
	{
		// Check for request forgeries.
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app   = Factory::getApplication();
		$model = $this->getModel('{{ sentenceCase entityName }}Form', '{{ sentenceCase componentName }}Model');

		// Get the user data.
		$data = Factory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();

		if (!$form)
		{
			throw new Exception($model->getError(), 500);
		}

		// Validate the posted data.
		$data = $model->validate($form, $data);

		// Check for errors.
		if ($data === false)
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			$input = $app->input;
			$jform = $input->get('jform', array(), 'ARRAY');

			// Save the data in the session.
			$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', $jform);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id');
			$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}form&id=' . $id, false));

			$this->redirect();
		}

		// Attempt to save the data.
		$return = $model->save($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id');
			$this->setMessage(Text::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}form&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id', null);

		// Redirect to the list screen.
		$this->setMessage(Text::_('COM_{{ constantCase componentName }}_ITEM_SAVED_SUCCESSFULLY'));
		$menu = Factory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}s' : $item->link);
		$this->setRedirect(Route::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', null);
	}

	/**
	 * Method to cancel an edit.
	 *
	 * @param   string  $key  The name of the primary key of the URL variable.
	 *
	 * @return  boolean  True if access level checks pass, false otherwise.
	 *
	 * @since   {{ version }}
	 */
	public function cancel($key = null)
	{
		$app = Factory::getApplication();

		// Get the current edit id.
		$editId = (int) $app->getUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id');

		// Get the model.
		$model = $this->getModel('{{ sentenceCase entityName }}Form', '{{ sentenceCase componentName }}Model');

		// Check in the item
		if ($editId)
		{
			$model->checkin($editId);
		}

		$menu = Factory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}s' : $item->link);
		$this->setRedirect(Route::_($url, false));
	}

	/**
	 * Method to remove data
	 *
	 * @return void
	 *
	 * @throws Exception
	 *
	 * @since {{ version }}
	 */
	public function remove()
	{
		$app   = Factory::getApplication();
		$model = $this->getModel('{{ sentenceCase entityName }}Form', '{{ sentenceCase componentName }}Model');
		$pk    = $app->input->getInt('id');

		// Attempt to save the data
		try
		{
			$return = $model->delete($pk);

			// Check in the profile
			$model->checkin($return);

			// Clear the profile id from the session.
			$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id', null);

			$menu = $app->getMenu();
			$item = $menu->getActive();
			$url = (empty($item->link) ? 'index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}s' : $item->link);

			// Redirect to the list screen
			$this->setMessage(Text::_('COM_{{ constantCase componentName }}_ITEM_DELETED_SUCCESSFULLY'));
			$this->setRedirect(Route::_($url, false));

			// Flush the data from the session.
			$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', null);
		}
		catch (Exception $e)
		{
			$errorType = ($e->getCode() == '404') ? 'error' : 'warning';
			$this->setMessage($e->getMessage(), $errorType);
			$this->setRedirect('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}s');
		}
	}
}

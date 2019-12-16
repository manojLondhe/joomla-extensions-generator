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
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

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
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = '{{ lowerCase entityName }}s';
		parent::__construct();
	}

	/**
	 * Save campaign data
	 *
	 * @param   integer  $key     key.
	 *
	 * @param   integer  $urlVar  url
	 *
	 * @return  boolean|string  The arguments to append to the redirect URL.
	 *
	 * @since   2.3.0
	 */
	public function save($key = null, $urlVar = null)
	{
		// Check for request forgeries.
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app   = Factory::getApplication();
		$input = Factory::getApplication()->input;
		$data  = $input->get('jform', array(), 'array');

		$task  = $this->getTask();
		$model = $this->getModel('{{ sentenceCase entityName }}', '{{ sentenceCase componentName }}Model');

		$table   = $model->getTable();
		$checkin = property_exists($table, $table->getColumnAlias('checked_out'));

		// Populate the row id from the session.
		$id        = $this->input->getInt('id');
		$data['id'] = $id;

		// The save2copy task needs to be handled slightly differently.
		if ($task === 'save2copy')
		{
			// Check-in the original row.
			if ($checkin && $model->checkin($data['id']) === false)
			{
				// Check-in failed. Go back to the item and display a notice.
				$this->setError(Text::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
				$this->setMessage($this->getError(), 'error');
				$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}&id=' . $id, false));

				return false;
			}

			// Reset the ID, the multilingual associations and then treat the request as for Apply.
			$data['id']           = 0;
			$data['associations'] = array();

			$task = 'apply';
		}

		// Get form
		// Sometimes the form needs some posted data, such as for plugins and modules.
		$form = $model->getForm($data, false);

		if (!$form)
		{
			$app->enqueueMessage($model->getError(), 'error');

			return false;
		}

		// Validate the posted data.
		$validData = $model->validate($form, $data);

		// Check for errors.
		if ($validData === false)
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
			}

			// Save the data in the session.
			$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', $data);

			// Tweak *important
			// $app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id', $data['id']);

			// Redirect back to the edit screen.
			// $id = (int) $app->getUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id');

			$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}&layout=edit&id=' . $id, false));

			$this->redirect();
		}

		// Attempt to save the data.
		if (!$model->save($validData))
		{
			// Save the data in the session.
			$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', $data);

			// Redirect back to the edit screen.
			$this->setError(Text::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}&id=' . $id), false);

			return false;
		}

		// Save succeeded, so check-in the record.
		if ($checkin && $model->checkin($validData['id']) === false)
		{
			// Save the data in the session.
			$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', $validData);

			// Check-in failed, so go back to the record and display a notice.
			$this->setError(Text::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}&id=' . $id, false));

			return false;
		}

		$this->setMessage(Text::_('COM_{{ constantCase componentName }}_MSG_SUCCESS_SAVE_{{ constantCase viewName }}'), 'Success');

		// Redirect the user and adjust session state based on the chosen task.
		switch ($task)
		{
			case 'apply':
				// Set the record data in the session.
				$id = $model->getState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id');
				$this->holdEditId('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}', $id);
				$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', null);
				$model->checkout($id);

				// Redirect back to the edit screen.
				$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}&layout=edit&id=' . $id, false));
			break;

			case 'save2new':
				// Clear the record id and data from the session.
				$this->releaseEditId('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}', $id);
				$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', null);

				// Redirect back to the edit screen.
				$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}&layout=edit', false));
			break;

			default:
				// Clear the record id and data from the session.
				$this->releaseEditId('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}', $id);
				$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', null);

				// Redirect to the list screen.
				$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}s', false));
			break;
		}
	}
}

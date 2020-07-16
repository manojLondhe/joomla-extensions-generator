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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Uri\Uri;

/**
 * Controller for form for {{ camelCase entityName }}
 *
 * @package  {{ sentenceCase componentName }}
 *
 * @since    {{ version }}
 */
class {{ sentenceCase componentName }}Controller{{ sentenceCase viewName }} extends FormController
{
	protected $view_list;

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
	 * Save {{ lowerCase entityName }} data
	 *
	 * @param   integer  $key     key.
	 *
	 * @param   integer  $urlVar  url
	 *
	 * @return  boolean|string  The arguments to append to the redirect URL.
	 *
	 * @since   2.3.0
	 */
	public function save($key = null, $urlVar = '')
	{
		// Check for request forgeries.
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app   = Factory::getApplication();
		$input = $app->input;
		$model = $this->getModel('{{ sentenceCase entityName }}', '{{ sentenceCase componentName }}Model');
		$table = $model->getTable();

		$data = $input->post->get('jform', array(), 'array');
		$task = $this->getTask();

		$checkin = property_exists($table, $table->getColumnAlias('checked_out'));

		// Determine the name of the primary key for the data.
		if (empty($key))
		{
			$key = $table->getKeyName();
		}

		// To avoid data collisions the urlVar may be different from the primary key.
		if (empty($urlVar))
		{
			$urlVar = $key;
		}

		$recordId = $this->input->getInt($urlVar);

		// Populate the row id from the session.
		$data[$key] = $recordId;

		// The save2copy task needs to be handled slightly differently.
		if ($task === 'save2copy')
		{
			// Check-in the original row.
			if ($checkin && $model->checkin($data[$key]) === false)
			{
				// Check-in failed. Go back to the item and display a notice.
				$this->setMessage(Text::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()), 'error');
				$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}' . $this->getRedirectToItemAppend($recordId, $urlVar), false));

				return false;
			}

			// Reset the ID, the multilingual associations and then treat the request as for Apply.
			$data[$key] = 0;

			$task = 'apply';
		}

		// Access check.
		if (!$this->allowSave($data, $key))
		{
			$this->setError(Text::_('JLIB_APPLICATION_ERROR_SAVE_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				Route::_(
					'index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}' . $this->getRedirectToListAppend(),
					false
				)
			);

			return false;
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
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', $data);

			// Redirect back to the edit screen
			$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}' . $this->getRedirectToItemAppend($recordId, $urlVar), false));

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

			$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}' . $this->getRedirectToItemAppend($recordId, $urlVar), false));


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

			$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}' . $this->getRedirectToItemAppend($recordId, $urlVar), false));

			return false;
		}

		$this->setMessage(Text::_('COM_{{ constantCase componentName }}_MSG_SUCCESS_SAVE_{{ constantCase viewName }}'));

		// Redirect the user and adjust session state based on the chosen task.
		switch ($task)
		{
			case 'apply':
				// Set the record data in the session.
				$recordId = $model->getState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id');
				$this->holdEditId('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}', $recordId);
				$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', null);
				$model->checkout($recordId);

				// Redirect back to the edit screen.
				$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}' . $this->getRedirectToItemAppend($recordId, $urlVar), false));
			break;

			case 'save2new':
				// Clear the record id and data from the session.
				$this->releaseEditId('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}', $recordId);
				$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', null);

				// Redirect back to the edit screen.
				$this->setRedirect(Route::_('index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}' . $this->getRedirectToItemAppend(null, $urlVar), false));
			break;

			default:
				// Clear the record id and data from the session.
				$this->releaseEditId('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}', $recordId);
				$app->setUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', null);

				$url = 'index.php?option=com_{{ lowerCase componentName }}&view={{ lowerCase entityName }}s' . $this->getRedirectToListAppend();

				// Check if there is a return value
				$return = $this->input->get('return', null, 'base64');

				if (!is_null($return) && Uri::isInternal(base64_decode($return)))
				{
					$url = base64_decode($return);
				}

				// Redirect to the list screen.
				$this->setRedirect(Route::_($url, false));

			break;
		}
	}
}

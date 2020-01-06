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
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;
use Joomla\String\StringHelper;
use Joomla\CMS\MVC\Model\AdminModel;

/**
 * Model for form for {{ camelCase entityName }}
 *
 * @package  {{ sentenceCase componentName }}
 *
 * @since    {{ version }}
 */
class {{ sentenceCase componentName }}Model{{ sentenceCase viewName }} extends AdminModel
{
	/**
	 * @var      string    The prefix to use with controller messages.
	 * @since    1.6
	 */
	protected $text_prefix = 'COM_{{ constantCase componentName }}';

	/**
	 * @var null  Item data
	 * @since  1.6
	 */
	protected $item = null;

	/**
	 * Method to get the table
	 *
	 * @param   string  $type    Name of the JTable class
	 * @param   string  $prefix  Optional prefix for the table class name
	 * @param   array   $config  Optional configuration array for JTable object
	 *
	 * @return  JTable|boolean JTable if found, boolean false on failure
	 */
	public function getTable($type = '{{ sentenceCase entityName }}', $prefix = '{{ sentenceCase componentName }}Table', $config = array())
	{
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_{{ lowerCase componentName }}/tables');

		return Table::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the {{ lowerCase entityName }}form.
	 *
	 * The base form is loaded from XML
	 *
	 * @param   array    $data      An optional array of data for the form to interogate.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return    JForm    A JForm object on success, false on failure
	 *
	 * @since    {{ version }}
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_{{ lowerCase componentName }}.{{ lowerCase entityName }}',
			'{{ lowerCase viewName }}',
			array(
				'control'   => 'jform',
				'load_data' => $loadData,
			)
		);

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return    mixed    The data for the form.
	 *
	 * @since    {{ version }}
	 */
	protected function loadFormData()
	{
		$data = Factory::getApplication()->getUserState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		// Support for multiple value field: columnName

		/*$array = array();

		foreach ((array) $data->columnName as $value)
		{
			if (!is_array($value))
			{
				$array[] = $value;
			}
		}

		if (!empty($array))
		{
			$data->columnName = $array;
		}*/

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed    Object on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{
			// Do any procesing on fields here if needed
		}

		return $item;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @param   JTable  $table  Table Object
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function prepareTable($table)
	{
		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			if (@$table->ordering === '')
			{
				$db = Factory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__{{ tableName }}');
				$max             = $db->loadResult();
				$table->ordering = $max + 1;
			}
		}
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success, False on error.
	 *
	 * @since   1.6
	 */
	public function save($data)
	{
		$table = $this->getTable();
		$id    = (!empty($data['id'])) ? $data['id'] : (int) $this->getState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id');
		$state = (!empty($data['state'])) ? 1 : 0;
		$isNew = true;

		// Uncomment this if needed

		/*
		$date = Factory::getDate();

		if ($data['id'])
		{
			$data['modified_by']   = $user->id;
			$data['modified_date'] = $date->toSql(true);
		}
		else
		{
			$data['created_by']   = $user->id;
			$data['created_date'] = $date->toSql(true);
		}
		*/

		// Allow an exception to be thrown.
		try
		{
			// Load the row if saving an existing record.
			if ($id > 0)
			{
				$table->load($id);
				$isNew = false;
			}

			// Bind the data.
			if (!$table->bind($data))
			{
				$this->setError($table->getError());

				return false;
			}

			// Prepare the row for saving
			$this->prepareTable($table);

			// Check the data.
			if (!$table->check())
			{
				$this->setError($table->getError());

				return false;
			}

			// Store the data.
			if (!$table->store())
			{
				$this->setError($table->getError());

				return false;
			}
		}
		catch (\Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		// IMPORTANT to set new id in state, it is fetched in controller later
		if (isset($table->id))
		{
			$this->setState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.id', $table->id);
		}

		$this->setState('com_{{ lowerCase componentName }}.edit.{{ lowerCase entityName }}.new', $isNew);

		return true;
	}
}

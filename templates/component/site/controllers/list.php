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

/**
 * Controller for list of {{ camelCase entityName }}
 *
 * @package  {{ sentenceCase componentName }}
 *
 * @since    {{ version }}
 */
class {{ sentenceCase componentName }}Controller{{ sentenceCase viewName }} extends {{ sentenceCase componentName }}Controller
{
	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  \JModelLegacy|boolean  Model object on success; otherwise false on failure.
	 *
	 * @since   {{ version }}
	 */
	public function &getModel($name = '{{ sentenceCase entityName }}', $prefix = '{{ sentenceCase componentName }}Model', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
}

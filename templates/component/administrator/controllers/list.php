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

use Joomla\CMS\MVC\Controller\AdminController;

/**
 * List controller for {{ camelCase entityName }}
 *
 * @package  {{ sentenceCase componentName }}
 *
 * @since    {{ version }}
 */
class {{ sentenceCase componentName }}Controller{{ sentenceCase viewName }} extends AdminController
{
	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelBase|JModelLegacy|boolean  Model object on success; otherwise false on failure.
	 *
	 * @since   {{ version }}
	 */
	public function getModel($name = '{{ sentenceCase entityName }}', $prefix = '{{ sentenceCase componentName }}Model', $config = array())
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}
}

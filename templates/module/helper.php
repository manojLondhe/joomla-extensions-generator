<?php
/**
 * @package     Joomla.Site
 * @subpackage  {{ lowerCase moduleName }}
 *
 * @copyright   {{ copyright }}
 * @license     {{ licence }}
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Helper for {{ lowerCase moduleName }}
 *
 * @since  1.5
 */
class Mod{{ sentenceCase moduleName }}Helper
{
	/**
	 * Get list of stats
	 *
	 * @param   \Joomla\Registry\Registry  &$params  module parameters
	 *
	 * @return  array
	 */
	public static function &getList(&$params)
	{
		$rows = array();

		/*$app  = JFactory::getApplication();
		$db   = JFactory::getDbo();



		$query      = $db->getQuery(true);

		// Your DB query goes here
		//*/

		return $rows;
	}
}

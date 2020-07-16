<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  {{ sentenceCase pluginType }}.{{ lowerCase pluginName }}
 *
 * @copyright   {{ copyright }}
 * @license     {{ licence }}
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Plugin\CMSPlugin;

/**
 * Class for {{ sentenceCase pluginName }} {{ sentenceCase pluginType }} Plugin
 *
 * @since  {{ version }}
 */
class Plg{{ sentenceCase pluginType }}{{ sentenceCase pluginName }} extends CMSPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 *
	 * @since  3.2.11
	 */
	protected $autoloadLanguage = true;

	/**
	 * Constructor
	 *
	 * @param   string  $subject  subject
	 * @param   array   $config   config
	 *
	 * @since   1.0.0
	 */
	public function __construct($subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/**
	 * Example trigger
	 *
	 * @param   string   $param1  Example
	 * @param   string   $param2  Example
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	public function onEntityAfterSave($param1, $param2)
	{
		return true;
	}
}

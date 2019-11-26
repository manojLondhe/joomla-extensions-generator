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

/**
 * Class for {{ sentenceCase pluginName }} {{ sentenceCase pluginType }} Plugin
 *
 * @since  {{ version }}
 */
class Plg{{ sentenceCase pluginType }}{{ sentenceCase pluginName }} extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 *
	 * @since  3.2.11
	 */
	protected $autoloadLanguage = true;
}

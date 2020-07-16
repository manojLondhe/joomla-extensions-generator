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

use Joomla\CMS\Table\Table;

/**
 * Table class for {{ camelCase entityName }}
 *
 * @package  {{ sentenceCase componentName }}
 *
 * @since    {{ version }}
 */
class {{ sentenceCase componentName }}Table{{ sentenceCase entityName }} extends Table
{
	/**
	 * Constructor
	 *
	 * @param   \JDatabaseDriver  &$db  \JDatabaseDriver object.
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__{{ tableName }}', 'id', $db);
		$this->setColumnAlias('published', 'state');
	}
}

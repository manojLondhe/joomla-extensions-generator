<?php
/**
 * @version    SVN:{{ version }}
 * @package    Joomla.Cli
 * @author     {{ author }} <{{ authorEmail }}>
 * @copyright  {{ copyright }}
 * @license    {{ licence }}
 */

// Make sure this is being called from the command line
if (PHP_SAPI !== 'cli')
{
	die('This is a command line only application.');
}

const _JEXEC = 1;

if (file_exists(dirname(__DIR__) . '/defines.php'))
{
	require_once dirname(__DIR__) . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', dirname(__DIR__));
	require_once JPATH_BASE . '/includes/defines.php';
	require_once JPATH_BASE . '/includes/framework.php';
}

require_once JPATH_LIBRARIES . '/import.legacy.php';
require_once JPATH_LIBRARIES . '/cms.php';

jimport('joomla.application.cli');
ini_set('display_errors', 'On');

/**
 * A command line cron job to {{ lowerCase cliTitleComment }}.
 *
 * @since  {{ version }}
 */
class {{ pascalCase cliFileName }}Cli extends JApplicationCli
{
	/**
	 * Entry point for CLI script
	 *
	 * @return  void
	 *
	 * @since   {{ version }}
	 */
	public function doExecute()
	{
		$this->out("Hello World!");
	}
}

JApplicationCli::getInstance('{{ pascalCase cliFileName }}Cli')->execute();

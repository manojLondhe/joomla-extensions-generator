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

// Include the statistics functions only once
JLoader::register('Mod{{ sentenceCase moduleName }}Helper', __DIR__ . '/helper.php');

$list           = Mod{{ sentenceCase moduleName }}Helper::getList($params);
$moduleClassSfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_{{ lowerCase moduleName }}', $params->get('layout', 'default'));

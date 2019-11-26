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
use Joomla\CMS\Language\Text;

jimport('joomla.application.component.view');

/**
 * View to edit {{ camelCase componentName }}
 *
 * @package  {{ sentenceCase componentName }}
 *
 * @since    {{ version }}
 */
class {{ sentenceCase componentName }}View{{ sentenceCase viewName }} extends \Joomla\CMS\MVC\View\HtmlView
{
	protected $state;

	protected $item;

	protected $form;

	protected $params;

	protected $canSave;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->app   = Factory::getApplication();
		$this->user  = Factory::getUser();
		$this->input = $this->app->getInput();

		if (!$this->user->id)
		{
			$uri         = $this->input->server->get('REQUEST_URI');
			$redirectUrl = base64_encode($uri);
			$msg         = JText::_('COM_{{ constantCase componentName }}_ERROR_MESSAGE_NOT_AUTHORISED');

			$this->app->redirect(Route::_('index.php?option=com_users&view=login&return=' . $redirectUrl, false), $msg);
		}

		$this->state   = $this->get('State');
		$this->item    = $this->get('Item');
		$this->params  = $this->app->getParams('com_{{ lowerCase componentName }}');
		$this->canSave = $this->get('CanSave');
		$this->form    = $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		if (!$this->isAuthorised())
		{
			throw new Exception(Text::_('COM_{{ constantCase componentName }}_ERROR_MESSAGE_NOT_AUTHORISED'), 403);
		}

		$this->prepareDocument();

		parent::display($tpl);
	}

	/**
	 * checks if user has access to create or edit record
	 *
	 * @return boolean
	 *
	 * @throws Exception
	 */
	protected function isAuthorised()
	{
		$authorised = false;

		// New record
		if (empty($this->item->id))
		{
			if ($this->user->authorise('core.create', 'com_{{ lowerCase componentName }}'))
			{
				$authorised = true;
			}
		}
		// Edit record
		else
		{
			// User has access to edit any record
			if ($this->user->authorise('core.edit', 'com_{{ lowerCase componentName }}'))
			{
				$authorised = true;
			}
			else
			{
				// If item has created_by field
				if (isset($this->item->created_by))
				{
					// User has access to edit own record && user is owner of this record
					if ($this->user->authorise('core.edit.own', 'com_{{ lowerCase componentName }}') && $this->item->created_by == $this->user->id)
					{
						$authorised = true;
					}
				}
			}
		}

		return $authorised;
	}

	/**
	 * Prepares the document
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function prepareDocument()
	{
		$menus = $this->app->getMenu();
		$title = null;

		// Because the application sets a default page title,
		// We need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', Text::_('COM_{{ constantCase componentName }}_{{ constantCase viewName }}_PAGE_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		if (empty($title))
		{
			$title = $this->app->get('sitename');
		}
		elseif ($this->app->get('sitename_pagetitles', 0) == 1)
		{
			$title = Text::sprintf('JPAGETITLE', $this->app->get('sitename'), $title);
		}
		elseif ($this->app->get('sitename_pagetitles', 0) == 2)
		{
			$title = Text::sprintf('JPAGETITLE', $title, $this->app->get('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}

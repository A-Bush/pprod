<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

/**
 * ArticlePopas View
 */
class ArticlePopaViewArticlePopas extends JViewLegacy
{
	/**
	 * ArticlePopas view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
 
		// Set the toolbar and number of found items
		$this->addToolBar($this->pagination->total);
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar($total=null) 
	{
		JToolBarHelper::title(JText::_('COM_ARTICLEPOPA_MANAGER_ARTICLEPOPAS').
			//Reflect number of items in title!
			($total?' <span style="font-size: 0.5em; vertical-align: middle;">('.$total.')</span>':'')
			, 'articlepopa');
		JToolBarHelper::deleteList('', 'articlepopas.delete');
		JToolBarHelper::editList('articlepopa.edit');
		JToolBarHelper::addNew('articlepopa.add');
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_ARTICLEPOPA_ADMINISTRATION'));
	}
}
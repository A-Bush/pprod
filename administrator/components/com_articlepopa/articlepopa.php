<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// Set some global property
$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-articlepopa {background-image: url(../media/com_articlepopa/images/tux-16x16.png);}');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by ArticePopa
$controller = JControllerLegacy::getInstance('ArticlePopa');
 
// Perform the Request task and Execute request task
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
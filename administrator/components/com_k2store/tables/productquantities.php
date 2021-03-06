<?php
/*------------------------------------------------------------------------
# com_k2store - K2 Store
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://k2store.org
# Technical Support:  Forum - http://k2store.org/forum/index.html
-------------------------------------------------------------------------*/


/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );
JLoader::register( 'K2StoreTable', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2store'.DS.'tables'.DS.'_base.php' );
class TableProductQuantities extends K2StoreTable
{

	function TableProductQuantities(&$db )
	{
		$tbl_key    = 'productquantity_id';
        $tbl_suffix = 'productquantities';
        $this->set( '_suffix', $tbl_suffix );
       	$name 		= 'k2store';

		parent::__construct( "#__{$name}_{$tbl_suffix}", $tbl_key, $db );
	}

	function check()
	{
		if (empty($this->product_id))
		{
			$this->setError( JText::_('K2STORE_PRODUCT_REQUIRED') );
			return false;
		}

		return true;
	}

}
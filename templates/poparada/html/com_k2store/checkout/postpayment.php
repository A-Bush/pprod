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


// no direct access
	defined('_JEXEC') or die('Restricted access'); 
	$order_link = @$this->order_link;
	$plugin_html = @$this->plugin_html;
?>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
	
		<h3 class="text-center bordered-bottom"><?php echo JText::_( "K2STORE_CHECKOUT_RESULTS" ); ?></h3>
	
		<?php echo $plugin_html; ?>
	
		<?php if(!empty($order_link)):?>
		<div class="note pad-top-bottom-50">
			<a href="<?php echo JRoute::_($order_link); ?>">
		        <?php echo JText::_( "K2STORE_VIEW_PRINT_INVOICE" ); ?>
			</a>
		</div>
		<?php endif; ?>
		</div>
	</div>
</div>

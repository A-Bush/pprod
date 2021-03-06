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

?>
<div class="k2store">

<form action="index.php?option=com_k2store&view=orders" method="post" name="adminForm" id="adminForm">
<table class="adminlist table table-striped">
<tr>
	<td align="left" width="100%">
		<?php echo JText::_( 'K2STORE_FILTER_SEARCH' ); ?>:
		<input type="text" name="search" id="search" value="<?php echo htmlspecialchars($this->lists['search']);?>" class="text_area" onchange="document.adminForm.submit();" />
		<button class="btn btn-success" onclick="this.form.submit();"><?php echo JText::_( 'K2STORE_FILTER_GO' ); ?></button>
		<button class="btn btn-inverse" onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'K2STORE_FILTER_RESET' ); ?></button>
	</td>
	<td nowrap="nowrap">
		<?php
		echo $this->lists['orderstate'];
		?>
	</td>
</tr>
</table>
	<table class="adminlist table table-striped table-bordered">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'K2STORE_NUM' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
			</th>
			<th class="title">
				<?php echo JHTML::_('grid.sort',  'K2STORE_ORDER_DATE', 'a.created_date', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th class="title">
				<?php echo JHTML::_('grid.sort',  'K2STORE_ORDER_INVOICE_ORDER_ID', 'a.order_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<!--
			<th class="title">
				<?php echo JHTML::_('grid.sort',  'K2STORE_ORDER_ORDER_ID', 'a.order_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			 -->
			<th width="15%"  class="title">
				<?php echo JHTML::_('grid.sort',  'K2STORE_ORDER_BUYER_NAME', 'a.user_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>

			<th width="15%"  class="title">
				<?php echo JText::_('K2STORE_ORDER_EMAIL'); ?>
			</th>

			<th width="15%">
				<?php echo JHTML::_('grid.sort',  'K2STORE_ORDER_AMOUNT', 'a.orderpayment_amount', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="15%">
				<?php echo JHTML::_('grid.sort',  'K2STORE_ORDER_PAYMENT_TYPE', 'a.orderpayment_type', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<!--
			<th width="15%">
				<?php echo JHTML::_('grid.sort',  'K2STORE_ORDER_TRANSACTION_STATUS', 'a.transaction_status', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			 -->
			<th width="15%">
				<?php echo JHTML::_('grid.sort',  'K2STORE_ORDER_ORDER_STATUS', 'a.order_state_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="11">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = $this->items[$i];
		if(isset($row->invoice_number) && $row->invoice_number > 0) {
			$invoice_number = $row->invoice_prefix.$row->invoice_number;
		}else {
			$invoice_number = $row->id;
		}
		$link 	= JRoute::_( 'index.php?option=com_k2store&view=orders&task=view&id='. $row->id );

		//$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$checked = JHTML::_('grid.id', $i, $row->id );

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td><?php echo JHTML::_('date', $row->created_date, $this->params->get('date_format', JText::_('DATE_FORMAT_LC1'))); ?></td>
			<td>
			<span class="editlinktip hasTip" title="<?php echo JText::_( 'K2STORE_ORDER_VIEW' );?>::<?php echo $this->escape($row->order_id); ?>">
				<a href="<?php echo $link ?>" >
				<?php echo $invoice_number; ?>
				</a>
			</td>
			<!--
			<td>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'K2STORE_ORDER_VIEW' );?>::<?php echo $this->escape($row->order_id); ?>">
				<a href="<?php echo $link ?>" >
				<?php echo $this->escape($row->order_id); ?>
				</a>
				</span>
			</td>
			 -->

			<td align="center">
				<?php if($row->buyer) {
					echo $row->buyer;
				}else {
					echo $row->billing_first_name.' '.$row->billing_last_name;
				}
				?>
			</td>

			<td align="center">
			<?php if($row->bemail) {
					echo $row->bemail;
				}else {
					echo $row->user_email;
				}
				?>
			</td>

			<td align="center">
				<?php echo K2StoreUtilities::number( $row->orderpayment_amount, $row->currency_code, $row->currency_value ); ?>
			</td>
			<td align="center">
				<?php echo JText::_($row->orderpayment_type); ?>
			</td>
			<!--
			<td align="center">
				<?php echo JText::_($row->transaction_status); ?>
			</td>
			 -->
			<td align="center">
				<span class="label <?php echo $row->orderstatus_cssclass;?> order-state-label">
					<?php
					if(JString::strlen($row->order_state) > 0) {
						echo JText::_($row->order_state);
					} else {
						echo JText::_('K2STORE_PAYSTATUS_INCOMPLETE');
					}
					?>
				</span>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</tbody>
	</table>
	<input type="hidden" name="option" value="com_k2store" />
	<input type="hidden" name="view" value="orders" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
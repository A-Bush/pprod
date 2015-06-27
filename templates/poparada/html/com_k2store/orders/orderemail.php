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


//no direct access
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_ADMINISTRATOR . '/components/com_k2store/library/prices.php');
require_once(JPATH_ADMINISTRATOR . '/components/com_k2store/library/selectable/base.php');
require_once(JPATH_SITE . '/components/com_k2store/helpers/orders.php');
$selectableBase = new K2StoreSelectableBase();
$row = @$this->row;
$order = @$this->order;
$items = @$order->getItems();
if (JFactory::getUser()->id && empty($row->billing_first_name)) {
    $recipient_name = JFactory::getUser()->name;
} else {
    $recipient_name = $row->billing_first_name . '&nbsp;' . $row->billing_last_name;
}

$showShipping = true;
if (isset($row->is_shippable) && !empty($row->is_shippable)) {
    if ($row->is_shippable == '0') {
        $showShipping = false;
    }
} else {
    if (!$this->params->get('show_shipping_address')) {
        $showShipping = false;
    }
}

?>
    <div id="k2store_order_info">
        <div class="k2store_ordermail_header">
            <?php echo JText::sprintf('K2STORE_ORDER_PLACED_HEADER', $recipient_name, $this->sitename, $row->id); ?>
        </div>

        <table>
            <tr>
                <h3>
                    <strong><?php echo JText::_("K2STORE_ORDER_DETAIL"); ?>:</strong>
                </h3>
            </tr>
            <tr>
                <td><strong><?php echo JText::_("K2STORE_ORDER_ID"); ?> </strong>
                </td>
                <td><?php echo @$row->id; ?>
                </td>
            </tr>
            <tr>
                <td><strong><?php echo JText::_("K2STORE_ORDER_DATE"); ?> </strong>
                </td>
                <td><?php echo JHTML::_('date', $row->created_date, $this->params->get('date_format', JText::_('DATE_FORMAT_LC1'))); ?>
                </td>
            </tr>
            <tr>
                <td><strong><?php echo JText::_("K2STORE_ORDER_STATUS"); ?> </strong>
                </td>
                <td><?php echo JText::_((@$row->order_state == '') ? '' : @$row->order_state); ?>
                </td>
            </tr>
            <tr>
                <td><strong><?php echo JText::_("K2STORE_BILLING_ADDRESS"); ?> </strong></td>
                <td>
                    <?php
                    echo $row->billing_first_name . " " . $row->billing_last_name . "<br/>";
                    echo $row->billing_phone_1 . " , ";
                    echo '<br/> ';
                    echo $row->user_email;
                    echo '<br/> ';
                    ?>
                </td>
            </tr>
            <tr>
                <td><strong><?php echo JText::_('K2STORE_ORDER_PAYMENT_TYPE'); ?> </strong></td>
                <td><?php echo JText::_($row->orderpayment_type); ?></td>
            </tr>
            <tr>
                <?php
                $field = 'all_payment';
                $fields = array();
                if (!empty($row->$field) && JString::strlen($row->$field) > 0) {
                    $custom_fields = json_decode(stripslashes($row->$field));
                    if (isset($custom_fields) && count($custom_fields)) {
                        foreach ($custom_fields as $namekey => $field) {
                            if (!property_exists($row, $type . '_' . $namekey) && !property_exists($row, 'user_' . $namekey) && $namekey != 'country_id' && $namekey != 'zone_id' && $namekey != 'option' && $namekey != 'task' && $namekey != 'view') {
                                $fields[$namekey] = $field;
                            }
                        }

                    }
                }
                ?>
                <?php if (isset($fields) && count($fields)) : ?>
                <?php foreach ($fields as $namekey => $field) : ?>
                <?php if (is_object($field)): ?>
            <tr>
                <td><strong><?php echo JText::_($field->label); ?>:</strong></td>
                <td>&nbsp;&nbsp;&nbsp;<?php echo JText::_($field->value); ?></td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>

            <?php if (isset($this->shipping_info->ordershipping_type)): ?>
                <tr>
                    <td><strong><?php echo JText::_('K2STORE_ORDER_SHIPPING_NAME') ?></strong></td>
                    <td><?php echo $this->shipping_info->ordershipping_name; ?></td>
                </tr>
            <?php endif; ?>
            <tr><br/></tr>
            <tr>
                <td><strong><?php echo JText::_("K2STORE_ORDER_CUSTOMER_NOTE"); ?> </strong><br/></td>
                <td>
                    <?php echo $row->customer_note; ?>
                </td>
            </tr>

        </table>
    </div>


    <div id="items_info">
        <h3>
            <?php echo JText::_("K2STORE_ITEMS_IN_ORDER"); ?>
        </h3>

        <table class="cart_order" style="clear: both;">
            <thead>
            <tr>
                <th style="text-align: left;"><?php echo JText::_("K2STORE_CART_ITEM"); ?></th>
                <th style="width: 150px; text-align: center;"><?php echo JText::_("K2STORE_CART_ITEM_QUANTITY"); ?>
                </th>
                <th style="width: 150px; text-align: right;"><?php echo JText::_("K2STORE_ITEM_PRICE"); ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0;
            $k = 0; ?>
            <?php foreach (@$items as $item) : ?>

                <tr class='row<?php echo $k; ?>'>
                    <td> <?php echo JText::_($item->orderitem_name); ?> <br/>

                        <!-- start of orderitem attributes -->

                        <!-- backward compatibility -->
                        <?php if (!K2StoreOrdersHelper::isJSON(stripslashes($item->orderitem_attribute_names))): ?>

                            <?php if (!empty($item->orderitem_attribute_names)) : ?>
                                <span><?php echo $item->orderitem_attribute_names; ?></span>
                            <?php endif; ?>
                            <br/>
                        <?php else: ?>
                            <!-- since 3.1.0. Parse attributes that are saved in JSON format -->
                            <?php if (!empty($item->orderitem_attribute_names)) : ?>
                                <?php
                                //first convert from JSON to array
                                $registry = new JRegistry;
                                $registry->loadString(stripslashes($item->orderitem_attribute_names), 'JSON');
                                $product_options = $registry->toObject();
                                ?>
                                <?php foreach ($product_options as $option) : ?>
                                    -
                                    <small><?php echo $option->name; ?>: <?php echo $option->value; ?>
                                        <?php if (strpos($option->name, 'ткан') != false && isset($option->additional)) : ?>
                                            (цвет <?php echo $option->additional; ?>)
                                        <?php endif; ?>
                                    </small><br/>
                                <?php endforeach; ?>
                                <br/>
                            <?php endif; ?>
                        <?php endif; ?>
                        <!-- end of orderitem attributes -->

                        <?php if (!empty($item->orderitem_sku)) : ?> <b><?php echo JText::_("K2STORE_SKU"); ?>:</b>
                            <?php echo $item->orderitem_sku; ?> <br/> <?php endif; ?>
                        <b><?php echo JText::_("K2STORE_CART_ITEM_UNIT_PRICE"); ?>:</b>
                        <?php echo K2StorePrices::number($item->orderitem_price, $row->currency_code, $row->currency_value); ?>
                    </td>
                    <td style="text-align: center;"><?php echo $item->orderitem_quantity; ?>
                    </td>
                    <td style="text-align: right;"><?php echo K2StorePrices::number($item->orderitem_final_price, $row->currency_code, $row->currency_value); ?>
                    </td>
                </tr>
                <?php $i = $i + 1;
                $k = (1 - $k); ?>
            <?php endforeach; ?>

            <?php if (empty($items)) : ?>
                <tr>
                    <td colspan="10" align="center"><?php echo JText::_('K2STORE_NO_ITEMS'); ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
            <tfoot>
            <tr>
                <th colspan="2" style="text-align: right;"><?php echo JText::_("K2STORE_CART_SUBTOTAL"); ?>
                </th>
                <th style="text-align: right;"><?php echo K2StorePrices::number($order->order_subtotal, $row->currency_code, $row->currency_value); ?>
                </th>
            </tr>

            <?php if ($row->order_shipping > 0): ?>
                <tr>
                    <th colspan="2" style="text-align: right;">
                        <?php echo "(+)"; ?>
                        <?php echo JText::_("K2STORE_SHIPPING"); ?>
                    </th>
                    <th style="text-align: right;"><?php echo K2StorePrices::number($row->order_shipping, $row->currency_code, $row->currency_value); ?>
                    </th>
                </tr>
            <?php endif; ?>


            <?php if ($row->order_shipping_tax > 0): ?>
                <tr>
                    <th colspan="2" style="text-align: right;">
                        <?php echo "(+)"; ?>
                        <?php echo JText::_("K2STORE_CART_SHIPPING_TAX"); ?>
                    </th>
                    <th style="text-align: right;"><?php echo K2StorePrices::number($row->order_shipping_tax, $row->currency_code, $row->currency_value); ?>
                    </th>
                </tr>
            <?php endif; ?>


            <?php if ($order->order_discount > 0): ?>

                <tr>
                    <th colspan="2" style="text-align: right;">
                        <?php
                        if (!empty($order->order_discount)) {
                            echo "(-)";
                            echo JText::_("K2STORE_CART_DISCOUNT");
                        }
                        ?>
                    </th>

                    <th style="text-align: right;">
                        <?php
                        if (!empty($order->order_discount)) {
                            echo K2StorePrices::number($order->order_discount, $row->currency_code, $row->currency_value);
                        }
                        ?>
                    </th>
                </tr>

            <?php endif; ?>

            <?php if ($row->order_tax > 0): ?>

                <tr>
                    <th colspan="2" style="text-align: right;"><?php
                        if (!empty($this->show_tax)) {
                            echo JText::_("K2STORE_CART_PRODUCT_TAX_INCLUDED");
                        } else {
                            echo JText::_("K2STORE_CART_PRODUCT_TAX");
                        }
                        ?>
                        <br/>
                        <?php
                        if (isset($this->ordertaxes) && is_array($this->ordertaxes) && isset($this->ordertaxes[0]->order_id) && $this->ordertaxes[0]->order_id == $row->order_id) {
                            $last = count($this->ordertaxes);
                            $i = 1;
                            foreach ($this->ordertaxes as $ordertax) {
                                echo JText::_($ordertax->ordertax_title);
                                echo ' ( ' . floatval($ordertax->ordertax_percent) . ' % )';
                                if ($i != $last) echo '<br />';
                                $i++;
                            }
                        }
                        ?>
                    </th>
                    <th style="text-align: right;">
                        <?php
                        if (isset($this->ordertaxes) && is_array($this->ordertaxes) && isset($this->ordertaxes[0]->order_id) && $this->ordertaxes[0]->order_id == $row->order_id) {
                            echo '<br />';
                            $i = 1;
                            foreach ($this->ordertaxes as $ordertax) {
                                echo K2StorePrices::number($ordertax->ordertax_amount);
                                if ($i != $last) echo '<br />';
                                $i++;
                            }
                        } else {
                            echo K2StorePrices::number($row->order_tax, $row->currency_code, $row->currency_value);
                        }
                        ?>
                    </th>
                </tr>

            <?php endif; ?>

            <?php if ($row->order_surcharge > 0): ?>
                <tr>
                    <th colspan="<?php echo $colspan; ?>" style="text-align: right;">
                        <?php echo JText::_("K2STORE_CART_SURCHARGE"); ?>
                    </th>
                    <th style="text-align: right;"><?php echo K2StorePrices::number($row->order_surcharge, $row->currency_code, $row->currency_value); ?>
                    </th>

                </tr>
            <?php endif; ?>

            <tr>
                <th colspan="2"
                    style="font-size: 120%; text-align: right;"><?php echo JText::_("K2STORE_CART_GRANDTOTAL"); ?>
                </th>
                <th style="font-size: 120%; text-align: right;"><?php echo K2StorePrices::number($row->order_total, $row->currency_code, $row->currency_value); ?>
                </th>

            </tr>
            </tfoot>
        </table>
    </div>

<?php if (!$this->isGuest): //show only if the buyer is not a guest. Because a guest cannot access the stored order information ?>
    <div class="k2store_ordermail_footer">
        <?php echo JText::sprintf('K2STORE_ORDER_PLACED_FOOTER', $this->siteurl . 'index.php?option=com_k2store&view=orders&task=view&id=' . $row->id); ?>
    </div>
<?php else: ?>
    <div class="k2store_ordermail_footer">
        <?php echo JText::sprintf('K2STORE_ORDER_GUEST_TOKEN', $this->siteurl . 'index.php?option=com_k2store&view=orders&task=view', $order->token); ?>
    </div>

<?php endif; ?>
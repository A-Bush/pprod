<?php
/*------------------------------------------------------------------------
# com_k2store - K2Store
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://k2store.org
# Technical Support:  Forum - http://k2store.org/forum/index.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');

$shipping_rates_text = JText::_('K2STORE_GETTING_SHIPPING_RATES');
?>
<?php if (count($this->rates)): ?>
    <h3 xmlns="http://www.w3.org/1999/html"><?php echo JText::_('K2STORE_CHECKOUT_SELECT_A_SHIPPING_METHOD'); ?></h3>
    <p><?php echo JText::_('K2STORE_PLEASE_SELECT_YOUR_PREFERRED_SHIPPING_METHOD_BELOW'); ?>:</p>
    <input type="hidden" id="shippingrequired" name="shippingrequired" value="1"/>
    <script>
        function addressHide(){
            jQuery('div#address-del').hide();
        }
        function addressRequired(){
            jQuery('div#address-del').show();
        }
    </script>


    <?php

    foreach ($this->rates as $rate) {
        $checked = "";

        if (!empty($this->default_rate)) {
            if ($this->default_rate['name'] == $rate['name']) {
                $checked = "checked";
            }
        }
        ?>
        <?php if ($rate['name'] == "Доставка по Украине") { ?>
            <div class="radio">
                <label for="shipping_<?php echo $rate['element']; ?>"
                       onClick="k2storeSetShippingRate('<?php echo $rate['name']; ?>','<?php echo $rate['price']; ?>',<?php echo $rate['tax']; ?>,<?php echo $rate['extra']; ?>, '<?php echo $rate['code']; ?>', true );"><input
                        id="shipping_<?php echo $rate['element']; ?>" name="shipping_plugin"
                        rel="<?php echo $rate['name']; ?>" type="radio" value="<?php echo $rate['element'] ?>"
                        onClick="addressRequired();k2storeSetShippingRate('<?php echo $rate['name']; ?>','<?php echo $rate['price']; ?>',<?php echo $rate['tax']; ?>,<?php echo $rate['extra']; ?>, '<?php echo $rate['code']; ?>', true );" <?php echo $checked; ?> />
                    <strong><?php echo $rate['name'];?></strong> <?php echo '( Тарифы уточняйте у менеджера )'; ?>
                </label>
            </div>
        <?php } elseif ($rate['name'] == "Самовывоз"){ ?>
            <div class="radio">
                <label for="shipping_<?php echo $rate['element']; ?>"
                       onClick="k2storeSetShippingRate('<?php echo $rate['name']; ?>','<?php echo $rate['price']; ?>',<?php echo $rate['tax']; ?>,<?php echo $rate['extra']; ?>, '<?php echo $rate['code']; ?>', true );"><input
                        id="shipping_<?php echo $rate['element']; ?>" name="shipping_plugin"
                        rel="<?php echo $rate['name']; ?>" type="radio" value="<?php echo $rate['element'] ?>"
                        onClick="addressHide();k2storeSetShippingRate('<?php echo $rate['name']; ?>','<?php echo $rate['price']; ?>',<?php echo $rate['tax']; ?>,<?php echo $rate['extra']; ?>, '<?php echo $rate['code']; ?>', true );" <?php echo $checked; ?> />
                    <strong><?php echo $rate['name'];?></strong> <?php echo '(<a href="/contact.html#map" target="blank"> Водогонная 9 </a>)'; ?>
                </label>
            </div>
        <?php } else { ?>
            <div class="radio">
                <label for="shipping_<?php echo $rate['element']; ?>"
                       onClick="k2storeSetShippingRate('<?php echo $rate['name']; ?>','<?php echo $rate['price']; ?>',<?php echo $rate['tax']; ?>,<?php echo $rate['extra']; ?>, '<?php echo $rate['code']; ?>', true );"><input
                        id="shipping_<?php echo $rate['element']; ?>" name="shipping_plugin"
                        rel="<?php echo $rate['name']; ?>" type="radio" value="<?php echo $rate['element'] ?>"
                        onClick="addressRequired();k2storeSetShippingRate('<?php echo $rate['name']; ?>','<?php echo $rate['price']; ?>',<?php echo $rate['tax']; ?>,<?php echo $rate['extra']; ?>, '<?php echo $rate['code']; ?>', true );" <?php echo $checked; ?> />
                    <strong><?php echo $rate['name']; ?></strong>
                    <?php if (K2StorePrices::number($rate['total']) > 0) { ?> ( <?php echo K2StorePrices::number($rate['total']); ?> ) <?php } ?>
                </label>
            </div>
        <?php } ?>
    <?php } ?>

<?php endif; ?>

<?php $setval = false; ?>
<?php if (count($this->rates) == 1 && ($this->rates['0']['name'] == $this->default_rate['name'])) $setval = true; ?>
    <input type="hidden" name="shipping_price" id="shipping_price"
           value="<?php echo $setval ? $this->rates['0']['price'] : ""; ?>"/>
    <input type="hidden" name="shipping_tax" id="shipping_tax"
           value="<?php echo $setval ? $this->rates['0']['tax'] : ""; ?>"/>
    <input type="hidden" name="shipping_name" id="shipping_name"
           value="<?php echo $setval ? $this->rates['0']['name'] : ""; ?>"/>
    <input type="hidden" name="shipping_code" id="shipping_code"
           value="<?php echo $setval ? $this->rates['0']['code'] : ""; ?>"/>
    <input type="hidden" name="shipping_extra" id="shipping_extra"
           value="<?php echo $setval ? $this->rates['0']['extra'] : ""; ?>"/>

    <div id='shipping_form_div' style="padding-top: 10px;"></div>
    <div id='shipping_error_div' style="padding-top: 10px;"></div>
<?php
if (!empty($this->default_rate)) :
    $default_rate = $this->default_rate; ?>
    <script type="text/javascript">
        (function ($) {
            $(document).ready(function () {
                k2storeSetShippingRate('<?php echo $default_rate['name']; ?>', '<?php echo $default_rate['price']; ?>', <?php echo $default_rate['tax']; ?>, <?php echo $default_rate['extra']; ?>, '<?php echo $default_rate['code']; ?>', '<?php echo JText::_('K2STORE_UPDATING_SHIPPING_RATES')?>', '<?php echo JText::_('K2STORE_UPDATING_CART')?>', true);
            });
        })(k2store.jQuery);

//        function addressHide(){
//            console.log('hide');
////        $(div#address-del).hide();
//        }
    </script>
<?php endif; ?>
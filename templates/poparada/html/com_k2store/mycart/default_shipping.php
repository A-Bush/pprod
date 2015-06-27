<?php
/*------------------------------------------------------------------------
# com_k2store - K2Store
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://k2store.org
# Technical Support:  Forum - http://k2store.org/forum/index.html
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<?php if(isset($this->shipping_methods) && count($this->shipping_methods)): ?>
<div id="k2store-cart-shipping" class="k2store-cart-shipping">
	<h3><?php echo JText::_('K2STORE_CHECKOUT_SELECT_A_SHIPPING_METHOD');?></h3>
	
	<?php foreach($this->shipping_methods as $method): ?>
	<?php
		$checked = '';
		if(isset($this->shipping_values['shipping_name']) && $this->shipping_values['shipping_name']==$method['name']) {
			$checked = 'checked';
		}
	?>
	<?php if ($method['name'] == 'Служба доставки') : ?>
	<div class="radio">
		<label for="shipping_<?php echo $method['element']; ?>" onClick="k2storeUpdateShipping('<?php echo addslashes($method['name']); ?>','<?php echo $method['price']; ?>',<?php echo $method['tax']; ?>,<?php echo $method['extra']; ?>, '<?php echo $method['code']; ?>', true );">
		<input type="radio" id="shipping_<?php echo $method['element']; ?>" rel="<?php echo addslashes($method['name'])?>" name="shipping_method" <?php echo $checked; ?> onClick="k2storeUpdateShipping('<?php echo addslashes($method['name']); ?>','<?php echo $method['price']; ?>',<?php echo $method['tax']; ?>,<?php echo $method['extra']; ?>, '<?php echo $method['code']; ?>', true );" />
			<?php echo $method['name']; ?> 
			(Тарифы: <a href="http://www.autolux.ua/" rel="nofollow" target="_blank">Автолюкс</a>,<a href="http://www.intime.ua/calc/" rel="nofollow" target="_blank"> Интайм</a>, 
			<a href="http://nexpress.com.ua/calculator" target="_blank">Ночной Экспресс</a>, <a href="http://www.delivery-auto.com/ru/" rel="nofollow" target="_blank">Деливери</a>, Новой Почтой (оплата товара и доставки – при получении, доставка в течение суток). Обращаем ваше внимание на то, что тарифы на доставку «Новой Почтой» примерно в четыре раза выше, чем у других компаний.)
		</label>
	</div>
	<?php else : ?>
	<div class="radio">
		<label for="shipping_<?php echo $method['element']; ?>" onClick="k2storeUpdateShipping('<?php echo addslashes($method['name']); ?>','<?php echo $method['price']; ?>',<?php echo $method['tax']; ?>,<?php echo $method['extra']; ?>, '<?php echo $method['code']; ?>', true );">
		<input type="radio" id="shipping_<?php echo $method['element']; ?>" rel="<?php echo addslashes($method['name'])?>" name="shipping_method" <?php echo $checked; ?> onClick="k2storeUpdateShipping('<?php echo addslashes($method['name']); ?>','<?php echo $method['price']; ?>',<?php echo $method['tax']; ?>,<?php echo $method['extra']; ?>, '<?php echo $method['code']; ?>', true );" />
			<?php echo $method['name']; ?> ( <?php echo K2StorePrices::number( $method['total']); ?> )
		</label>
	</div>
	<?php endif; ?>

	<?php endforeach; ?>

</div>
<?php endif;?>
<?php $setval = false;?>
<input type="hidden" name="shipping_price" id="shipping_price" value="<?php echo $setval ? $this->shipping_methods['0']['price'] : "";?>" />
<input type="hidden" name="shipping_tax" id="shipping_tax" value="<?php echo $setval ? $this->shipping_methods['0']['tax'] : "";?>" />
<input type="hidden" name="shipping_name" id="shipping_name" value="<?php echo $setval ? $this->shipping_methods['0']['name'] : "";?>" />
<input type="hidden" name="shipping_code" id="shipping_code" value="<?php echo $setval ? $this->shipping_methods['0']['code'] : "";?>" />
<input type="hidden" name="shipping_extra" id="shipping_extra" value="<?php echo $setval ? $this->shipping_methods['0']['extra'] : "";?>" />

<script type="text/javascript">

	function k2storeUpdateShipping(name, price, tax, extra, code, combined) {
		(function($) {
			var form = $('#k2store-cart-form');
			form.find("input[type='hidden'][name='shipping_name']").val(name);
			form.find("input[type='hidden'][name='shipping_code']").val(code);
			form.find("input[type='hidden'][name='shipping_price']").val(price);
			form.find("input[type='hidden'][name='shipping_tax']").val(tax);
			form.find("input[type='hidden'][name='shipping_extra']").val(extra);
			//override the task
			form.find("input[type='hidden'][name='task']").val('shippingUpdate');

			$.ajax({
				url: 'index.php',
				type: 'post',
				data: $('#k2store-cart-form input[type=\'hidden\'], #k2store-cart-form input[type=\'radio\']:checked'),
				dataType: 'json',
				beforeSend: function() {
					$('#k2store-cart-shipping').after('<span class="wait">&nbsp;<img src="<?php echo JUri::root(true); ?>/media/k2store/images/loader.gif" alt="" /></span>');
				},
				complete: function() {
					$('.wait').remove();
				},
				success: function(json) {
					if (json['redirect']) {
						location = json['redirect'];
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		})(k2store.jQuery);
	}

	</script>
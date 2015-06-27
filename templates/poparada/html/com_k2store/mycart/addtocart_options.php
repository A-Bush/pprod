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
defined( '_JEXEC' ) or die( 'Restricted access' );
$options = $this->attributes;
$db = JFactory::getDbo();
?>

<?php if ($options) { ?>
<?php
  $product_id = $this->item->product_id;
  $product_info = K2StoreHelperCart::getItemInfo($product_id);
  $height = $product_info->item_height;
  $width = $product_info->item_width;


?>

      <div class="options">
        <?php foreach ($options as $key=>$option) { ?>
          <?php if ($option['type'] == 'select'){
            if ($option["option_id"] == 1) { ?>
            <!-- select option id = 1 -->
            <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
              <span class="required">*</span>
              <?php } ?>
              <b><?php echo $option['option_name']; ?>:</b><br />
              <script>
                var sizesOptions = {};
                var sizesValues = [];
              </script>

              <div class="select-wrapper">
                <select id="selectSize" class="form-control" name="product_option[<?php echo $option['product_option_id']; ?>]">
                  <?php foreach ($option['optionvalue'] as $option_value) : ?>
                    <script>
                      sizesOptions["<?php echo $option_value['optionvalue_name']; ?>"] = {
                        id:<?php echo $option_value['product_optionvalue_id']; ?>,
                        price:<?php echo $option_value['product_optionvalue_price']; ?>
                      };
                    </script>
                    <?php if (strpos($option_value['optionvalue_name'],'1S') !== false): ?>
                      <option value="S">маленький (S)</option>
                      <?php elseif (strpos($option_value['optionvalue_name'],'1M') !== false): ?>
                      <option value="M">средний (M)</option>
                      <?php elseif (strpos($option_value['optionvalue_name'],'1L') !== false): ?>
                      <option value="L">большой (L)</option>
                    <?php endif; ?>
                    <!-- sizesOptions["<?php echo stripslashes($db->escape(JText::_($option_value['optionvalue_name']))); ?>"] = <?php echo $option_value['product_optionvalue_id']; ?>; -->
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
		  
		 <!-- <br/> -->
            <?php } else { ?>
            <!-- option id = 2 -->
		  <script>
			  function pc(){
				  var prc = jQuery('option:selected').attr('data-to-price');
				  prc = prc.substr(0, prc.length-1) + 'грн.';
				  document.getElementById('price_eq').innerHTML = prc;

			  }
		  </script>


            <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
              <span class="required">*</span>
              <?php } ?>
              <b><?php echo $option['option_name']; ?>:</b><br />
              <div class="select-wrapper">
                <select class="form-control" name="product_option[<?php echo $option['product_option_id']; ?>]" onclick="pc();">
                  <?php foreach ($option['optionvalue'] as $option_value) { ?>
                  <?php $checked = ''; if($option_value['product_optionvalue_default']) $checked = 'selected="selected"'; ?>
                  <option <?php echo $checked; ?>
                    data-to-price="<?php echo $option_value['product_optionvalue_price'] ?>"
                    value="<?php echo $option_value['product_optionvalue_id']; ?>"><?php echo stripslashes($db->escape(JText::_($option_value['optionvalue_name']))); ?>

                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <br />
            <?php } }?>




      <!-- radio -->

      <?php if ($option['type'] == 'radio') {
      //<!-- option id = 2 -->
        if ($option["option_id"] == 2) {  ?>

        <!-- fabric-choise -->
        <div class="pick" id="img-zoom" style="display: none;">
          <h4 class="text-center"><span>&nbsp;Выбрать&nbsp;</span></h4>
        </div>
        <?php
          $this->set('option_index_modal', $key);
          echo $this->loadTemplate('modal');
          // echo $this->loadTemplate('modalTest');
        }
        else if ($option["option_id"] == 3) {
          $this->set('option_index_modal', $key);
          echo $this->loadTemplate('modal');
        }
        else if ($option["option_id"] == 4 || $option["option_id"] == 6) {?>
          <!-- radio -->
          <div id="option-<?php echo $option['product_option_id']; ?>" style="display:none;" class="option size2options">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['option_name']; ?>:</b><br />
          <?php foreach ($option['optionvalue'] as $option_value) { ?>
          <?php $checked = ''; if($option_value['product_optionvalue_default']) $checked = 'checked="checked"'; ?>
          <input <?php echo $checked; ?> data-to-price="<?php echo $option_value['product_optionvalue_price']; ?>" data-name="<?php echo $option_value['optionvalue_name']; ?>" type="radio" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_optionvalue_id']; ?>" id="option-value-<?php echo $option_value['product_optionvalue_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_optionvalue_id']; ?>"><?php echo stripslashes($db->escape(JText::_($option_value['optionvalue_name']))); ?>
            <?php if ($option_value['product_optionvalue_price'] > 0) { ?>
              <?php
              //get the tax
          $tax = $this->tax_class->getProductTax($option_value['product_optionvalue_price'], $this->item->product_id);
                ?>
                (<?php echo $option_value['product_optionvalue_prefix']; ?>
                <?php  echo K2StoreHelperCart::dispayPriceWithTax($option_value['product_optionvalue_price'], $tax, $this->params->get('price_display_options', 1)); ?>
                )

              <?php } ?>
            </label>
            <br />
            <?php } ?>
          </div>
          <br />
        <?php }
        else { ?>
          <!-- radio -->
          <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['option_name']; ?>:</b><br />
          <?php foreach ($option['optionvalue'] as $option_value) { ?>
          <?php $checked = ''; if($option_value['product_optionvalue_default']) $checked = 'checked="checked"'; ?>
          <input <?php echo $checked; ?> type="radio" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_optionvalue_id']; ?>" id="option-value-<?php echo $option_value['product_optionvalue_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_optionvalue_id']; ?>"><?php echo stripslashes($db->escape(JText::_($option_value['optionvalue_name']))); ?>
            <?php if ($option_value['product_optionvalue_price'] > 0) { ?>
	            <?php
	            //get the tax
  				$tax = $this->tax_class->getProductTax($option_value['product_optionvalue_price'], $this->item->product_id);
  	            ?>
              	(<?php echo $option_value['product_optionvalue_prefix']; ?>
              	<?php  echo K2StoreHelperCart::dispayPriceWithTax($option_value['product_optionvalue_price'], $tax, $this->params->get('price_display_options', 1)); ?>
              	)

              <?php } ?>
            </label>
            <br />
            <?php } ?>
          </div>
          <br />
        <?php } ?>
      <?php } ?>




        <?php if ($option['type'] == 'checkbox') { ?>
          <!-- checkbox-->

        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['option_name']; ?>:</b><br />
          <?php foreach ($option['optionvalue'] as $option_value) { ?>
          <?php $checked = ''; if($option_value['product_optionvalue_default']) $checked = 'checked="checked"'; ?>
          <input <?php echo $checked; ?> type="checkbox" name="product_option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_optionvalue_id']; ?>" id="option-value-<?php echo $option_value['product_optionvalue_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_optionvalue_id']; ?>"><?php echo stripslashes($db->escape(JText::_($option_value['optionvalue_name']))); ?>
            <?php if ($option_value['product_optionvalue_price'] > 0) { ?>
                <?php
	            //get the tax
				$tax = $this->tax_class->getProductTax($option_value['product_optionvalue_price'], $this->item->product_id);
	            ?>
            	(<?php echo $option_value['product_optionvalue_prefix']; ?>
            	<?php  echo K2StoreHelperCart::dispayPriceWithTax($option_value['product_optionvalue_price'], $tax, $this->params->get('price_display_options', 1)); ?>
            	)
            	<?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>


        <?php if ($option['type'] == 'text') { ?>
         <!-- text -->
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['option_name']; ?>:</b><br />
          <input type="text" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['optionvalue']; ?>" />
        </div>
        <br />
        <?php } ?>


        <?php if ($option['type'] == 'textarea') { ?>
         <!-- textarea -->
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['option_name']; ?>:</b><br />
          <textarea name="product_option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['optionvalue']; ?></textarea>
        </div>
        <br />
        <?php } ?>


        <?php if ($option['type'] == 'date') { ?>
          <!-- date -->
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['option_name']; ?>:</b><br />
          <input type="text" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['optionvalue']; ?>" class="k2store_date" />
        </div>
        <br />
        <?php } ?>


        <?php if ($option['type'] == 'datetime') { ?>
         <!-- datetime -->
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['option_name']; ?>:</b><br />
          <input type="text" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['optionvalue']; ?>" class="k2store_datetime" />
        </div>
        <br />
        <?php } ?>

        <?php if ($option['type'] == 'time') { ?>
        <!-- time -->
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['option_name']; ?>:</b><br />
          <input type="text" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['optionvalue']; ?>" class="k2store_time" />
        </div>
        <br />
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>

<script type="text/javascript">

</script>
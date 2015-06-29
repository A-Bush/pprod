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
$options = $this->attributes;
$db = JFactory::getDbo();
//$product_id = $this->item->product_id;
//$product_info = K2StoreHelperCart::getItemInfo($product_id);
$index = $this->option_index_modal;
//echo var_dump($options);
$option = $options[$index];
$fabricsCatId = '13';
/*Get K2 Fabrics Category from db*/
/*

  $query = $db->getQuery(true);
$query->select($db->quoteName(array('a.name', 'b.id', 'b.title', 'b.alias', 'b.hits', 'b.extra_fields')))
    ->from($db->quoteName('#__k2_categories', 'a'))
    ->join('INNER', $db->quoteName('#__k2_items', 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.catid') . ')')
	->where(array(($db->quoteName('a.parent') . ' = 13'), ($db->quoteName('b.published') . ' = 1'), ($db->quoteName('b.trash').' = 0')));
  $db->setQuery($query);
  $itemList = $db->loadObjectList('title');
//echo var_dump($itemList);


  usort($itemList, function ($a, $b)
    {
        return strcmp($b->hits, $a->hits);
    });

*/

?>

<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
  <!-- required -->
    <?php if ($option['required']) { ?>
    <span class="required">*</span>
    <?php } ?>
  <!-- opt name -->
  <b><?php echo $option['option_name']; ?>:</b><br />

  <!-- Launch modal -->
    <button id="btn-fabric-<?php echo($index) ?>" type="button" class="btn-fabric" data-toggle="modal" data-target="#fabricsModal<?php echo($index) ?>">
    </button>

  <!-- Modal -->
    <div class="modal fade fabricsModal" id="fabricsModal<?php echo($index) ?>" data-index="<?php echo($index) ?>" tabindex="-1" role="dialog" aria-labelledby="fabricsModal<?php echo($index) ?>Label" aria-hidden="true">
    <!-- modal-dialog -->
      <div class="modal-dialog">
      <!-- modal-content -->
        <div class="modal-content">
        <!-- modal-header -->
          <div class="modal-header row">

            <div class="col-xs-10 col-sm-3">
              <div class="clearfix">
                <h4 class="modal-title pull-left" id="fabricsModal<?php echo($index) ?>Label">Выбор ткани</h4>
              </div>
            </div>
            <div class="col-xs-2 col-sm-push-7">
              <div class="clearfix">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&nbsp;&times;&nbsp;</span></button>
              </div>
            </div>

            <div class="col-xs-12 col-sm-7 col-sm-pull-2">

              <ul class="list-inline">
                <li class="dropdown">
                  <span id="fabric-fabric<?php echo($index) ?>" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                    Вид ткани
                    <span class="caret"></span>
                  </span>

                  <ul id="fabric-filter<?php echo($index) ?>" class="dropdown-menu" role="menu" aria-labelledby="fabric-fabric">

                    <!-- <li role="presentation">
                      <a role="menuitem" tabindex="-1" href="#">Флок</a>
                    </li> -->
					<li class="type" data-field="1"><a href="">Оксфорд</a></li>
					<li class="type" data-field="2"><a href="">Велюр</a></li>
					<li class="type" data-field="3"><a href="">Рогожка</a></li>
                    <li class="type" data-field="4"><a href="">Кожзам</a></li>
                    <li class="type" data-field="5"><a href="">Микрофибра</a></li>
                    <li class="type" data-field="6"><a href="">Флок</a></li>
					<li class="type" data-field="7"><a href="">Шенилл</a></li>
                    <li class="type" data-field="8"><a href="">Жаккард</a></li>
                    <li class="type" data-field="9"><a href="">Габардин</a></li>

                    <li class="type" data-field="all"><a href="">Все виды</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <span id="fabric-category<?php echo($index) ?>" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">Ценовая категория
                    <span class="caret"></span>
                  </span>

                  <ul id="category-filter<?php echo($index) ?>" class="dropdown-menu" role="menu" aria-labelledby="fabric-category">
                   <li class="category" data-field="1"><a href="">Первая категория</a></li>
				   <li class="category" data-field="2"><a href="">Вторая категория</a></li>
				   <li class="category" data-field="3"><a href="">Третья категория</a></li>
				   <li class="category" data-field="4"><a href="">Четвёртая категория</a></li>
                    <li class="type" data-field="all"><a href="">Все категории</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <span id="fabric-color<?php echo($index) ?>" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                    Цвет
                    <span class="caret"></span>
                  </span>

                  <ul id="color-filter<?php echo($index) ?>" class="dropdown-menu" role="menu" aria-labelledby="fabric-color">
                    <li class="color" data-field="1"><a href="">Белый</a></li>
                    <li class="color" data-field="2"><a href="">Серый</a></li>
                    <li class="color" data-field="3"><a href="">Чёрный</a></li>
                    <li class="color" data-field="4"><a href="">Красный</a></li>
                    <li class="color" data-field="5"><a href="">Розовый</a></li>
                    <li class="color" data-field="6"><a href="">Оранжевый</a></li>
                    <li class="color" data-field="7"><a href="">Жёлтый</a></li>
                    <li class="color" data-field="8"><a href="">Зелёный</a></li>
                    <li class="color" data-field="9"><a href="">Голубой</a></li>
                    <li class="color" data-field="10"><a href="">Синий</a></li>
                    <li class="color" data-field="11"><a href="">Фиолетовый</a></li>
                    <li class="color" data-field="12"><a href="">Коричневый</a></li>
                    <li class="color" data-field="13"><a href="">Бежевый</a></li>
                    <li class="color" data-field="14"><a href="">Серебристый</a></li>
					           <li class="color" data-field="16"><a href="">Золотой</a></li>
                    <li class="color" data-field="15"><a href="">Разноцветный</a></li>
					<li class="color" data-field="all"><a href="">Все цвета</a></li>

                  </ul>
                </li>
              </ul>

              <div>
                <ul id="applied-filters<?php echo($index) ?>" class="list-inline">

                </ul>
              </div>
            </div>



          </div><!-- /.modal-header -->
<!-- modal-body -->
  <div class="modal-body">
    <!-- fabrics-accordion<?php echo($index) ?> -->
    <div class="panel-group fabrics-accordion" id="fabrics-accordion<?php echo($index) ?>" role="tablist" aria-multiselectable="true">
    <?php foreach ($option['optionvalue'] as $option_value) : ?>
      <div class="panel panel-default fabrics-body">
        <div class="panel-heading" role="tab" id="heading<?php echo $option_value['product_optionvalue_id']; ?>">
          <div class="radio">
            <h4 class="fabric-title" data-toggle="collapse" data-parent="#fabrics-accordion<?php echo($index) ?>" href="#collapse<?php echo $option_value['product_optionvalue_id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $option_value['product_optionvalue_id']; ?>">
                      <!-- <h4 class="panel-title"> -->
              <label for="<?php echo $option_value['product_optionvalue_id']; ?>">
                <?php $checked = ''; if($option_value['product_optionvalue_default']) $checked = 'checked="checked"'; ?>
                <input <?php echo $checked; ?>
                  data-category="<?php echo $option_value['product_optionvalue_weight'] ?>"
                  type="radio"
                  name="product_option[<?php echo $option['product_option_id']; ?>]"
                  data-product-option="fabricsModal<?php echo($index) ?>"
                  value="<?php echo $option_value['product_optionvalue_id']; ?>"
                  data-fabricid="<?php echo $option_value['product_optionvalue_data']->product_option_id; ?>"
                  id="option-value-<?php echo $option_value['product_optionvalue_id']; ?>" />
                <?php echo stripslashes($db->escape(JText::_($option_value['optionvalue_name']))); ?>

              </label>
                      <!-- </h4> -->
            </h4>

          </div><!-- /.radio -->
        </div><!-- /.panel-heading -->
        <div id="collapse<?php echo $option_value['product_optionvalue_id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $option_value['product_optionvalue_id']; ?>">
          <div class="panel-body">
			  <div class="fabric-descr"></div>
            <ul class="list-inline fill-fabrics" >



              </ul>
            </div><!-- /.panel-body -->
          </div>
      </div><!-- /.panel panel-default -->

    <?php endforeach; ?>

    </div><!-- /#fabrics-accordion<?php echo($index) ?> -->


  </div>
<!-- /.modal-body -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /#fabricsModal<?php echo($index) ?> -->
</div>
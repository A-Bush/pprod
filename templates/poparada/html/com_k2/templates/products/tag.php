<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Tag Layout -->

<div id="k2Container" class="tagView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title')): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
	<?php endif; ?>

	<?php if($this->params->get('tagFeedIcon',1)): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

	<?php if(count($this->items)): ?>
	<h2 id="featured" class="text-center pad-all-50 no-margin item-title">
  Популярное
  </h2>
	<div class="tagItemList single-item">
		<?php foreach($this->items as $item): ?>

		<!-- Start K2 Item Layout -->
		<div class="tagItemView">
			  <?php if($item->params->get('tagItemImage',1) && !empty($item->imageLarge)): ?>
			  <!-- Item Image -->
			    <a href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
			    	<img class="block-center" style="height: 70%; width: auto;" src="<?php echo $item->imageLarge; ?>" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>" />
			    </a>
			  <?php endif; ?>

			  <?php if($item->params->get('tagItemIntroText',1)): ?>
			  <!-- Item introtext -->
			  <!-- <div class="tagItemIntroText">
			  	<?php echo $item->introtext; ?>
			  </div> -->
			  <?php endif; ?>

			  <div class="tagItemCaption">



				  <!-- Item title -->
					<div class="tagItemHeader">

					  <?php if($item->params->get('tagItemTitle',1)): ?>
					  <h3 class="tagItemTitle text-center">
					  	<?php if ($item->params->get('tagItemTitleLinked',1)): ?>
							<a href="<?php echo $item->link; ?>">
					  		<?php echo $item->title; ?>
					  	</a>
					  	<?php else: ?>
					  	<?php echo $item->title; ?>
					  	<?php endif; ?>
					  </h3>
					  <?php endif; ?>

			  	</div>

				</div><!-- /.tagItemCaption -->

		</div>
		<!-- End K2 Item Layout -->

		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php echo $this->pagination->getPagesCounter(); ?>
	</div>
	<?php endif; ?>

	<?php endif; ?>

</div>
<!-- End K2 Tag Layout -->
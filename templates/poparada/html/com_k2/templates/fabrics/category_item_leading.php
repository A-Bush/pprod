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

// Define default image size (do not change)
K2HelperUtilities::setDefaultImage($this->item, 'itemlist', $this->params);

?>

<div class="cell-60 pad-right pad-bottom-20 bordered-after">
	<!-- Item Image -->
	<?php if($this->item->params->get('catItemImage') && !empty($this->item->image)): ?>
		    <a href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
		    	<img class="img-responsive" src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px; height:auto;" />
		    </a>
	<?php endif; ?>
</div>
<div class="cell-40 pad-left-20 bordered-after" style="vertical-align: middle;">
	<!-- Date created -->
		<?php if($this->item->params->get('catItemDateCreated')): ?>
		<span class="catItemDateCreated text-muted">
			<?php echo JHTML::_('date', $this->item->created , JText::_('K2_DATE_FORMAT_LC2')); ?>
		</span>
		<?php endif; ?>

	<!-- Item title -->
	  <?php if($this->item->params->get('catItemTitle')): ?>
	  <h3 class="catItemTitle">
			<?php if(isset($this->item->editLink)): ?>
			<!-- Item edit link -->
			<span class="catItemEditLink">
				<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>">
					<?php echo JText::_('K2_EDIT_ITEM'); ?>
				</a>
			</span>
			<?php endif; ?>

	  	<?php if ($this->item->params->get('catItemTitleLinked')): ?>
			<a href="<?php echo $this->item->link; ?>">
	  		<?php echo $this->item->title; ?>
	  	</a>
	  	<?php else: ?>
	  	<?php echo $this->item->title; ?>
	  	<?php endif; ?>

	  	<?php if($this->item->params->get('catItemFeaturedNotice') && $this->item->featured): ?>
	  	<!-- Featured flag -->
	  	<span>
		  	<sup>
		  		<?php echo JText::_('K2_FEATURED'); ?>
		  	</sup>
	  	</span>
	  	<?php endif; ?>
	  </h3>
	  <?php endif; ?>

	<!-- Item introtext -->
	  <?php if($this->item->params->get('catItemIntroText')): ?>
	  <div class="catItemIntroText">
	  	<p><?php echo $this->item->introtext; ?></p>
	  </div>
	  <?php endif; ?>
	<!-- Item "read more..." link -->
		<?php if ($this->item->params->get('catItemReadMore')): ?>
		
		<p>
			<a class="k2ReadMore" href="<?php echo $this->item->link; ?>">
				<?php echo JText::_('K2_READ_MORE'); ?> <small class="glyphicon glyphicon-arrow-right"></small>
			</a>
		</p>
		
		<?php endif; ?>	

</div>
<!-- End K2 Item Layout -->

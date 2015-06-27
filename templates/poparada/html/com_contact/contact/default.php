<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');

jimport('joomla.html.html.bootstrap');
?>

<div class="container-fluid contact<?php echo $this->pageclass_sfx?>" itemscope itemtype="http://schema.org/Person">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	<?php endif; ?>
	<?php if ($this->contact->name && $this->params->get('show_name')) : ?>
		<div class="bordered-bottom ">
			<h2 class="text-center">
				<?php if ($this->item->published == 0) : ?>
					<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
				<?php endif; ?>
				<span class="contact-name" itemprop="name"><?php echo $this->contact->name; ?></span>
			</h2>
		</div>
	<?php endif;  ?>

	<!-- category, slider ... -->
		<?php if ($this->params->get('show_contact_category') == 'show_no_link') : ?>
			<h3>
				<span class="contact-category"><?php echo $this->contact->category_title; ?></span>
			</h3>
		<?php endif; ?>
		<?php if ($this->params->get('show_contact_category') == 'show_with_link') : ?>
			<?php $contactLink = ContactHelperRoute::getCategoryRoute($this->contact->catid); ?>
			<h3>
				<span class="contact-category"><a href="<?php echo $contactLink; ?>">
					<?php echo $this->escape($this->contact->category_title); ?></a>
				</span>
			</h3>
		<?php endif; ?>
		<?php if ($this->params->get('show_contact_list') && count($this->contacts) > 1) : ?>
			<form action="#" method="get" name="selectForm" id="selectForm">
				<?php echo JText::_('COM_CONTACT_SELECT_CONTACT'); ?>
				<?php echo JHtml::_('select.genericlist', $this->contacts, 'id', 'class="inputbox" onchange="document.location.href = this.value"', 'link', 'name', $this->contact->link);?>
			</form>
		<?php endif; ?>

		<?php if ($this->params->get('show_tags', 1) && !empty($this->item->tags)) : ?>
			<?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
			<?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
		<?php endif; ?>

	 	<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
			<?php echo JHtml::_('bootstrap.startAccordion', 'slide-contact', array('active' => 'basic-details')); ?>
		<?php endif; ?>
		<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
			<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'basic-details')); ?>
		<?php endif; ?>

		<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
			<?php echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_DETAILS'), 'basic-details'); ?>
		<?php endif; ?>
		<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'basic-details', JText::_('COM_CONTACT_DETAILS', true)); ?>
		<?php endif; ?>



	<div class="table"><!-- show_image -->
		<div class="cell-40 pad-right pad-top-bottom-20 bordered-after">
			<?php if ($this->contact->image && $this->params->get('show_image')) : ?>
					<?php echo JHtml::_('image', $this->contact->image, JText::_('COM_CONTACT_IMAGE_DETAILS'), array('class' => 'img-responsive', 'align' => 'middle', 'itemprop' => 'image')); ?>
			<?php endif; ?>
		</div>
		<div class="cell-60 pad-left-20 bordered-after" style="vertical-align: middle;">
			<?php if ($this->contact->misc && $this->params->get('show_misc')) : ?>
			<!-- presentation_style -->
				<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
					<?php echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_OTHER_INFORMATION'), 'display-misc'); ?>
				<?php endif; ?>
				<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'display-misc', JText::_('COM_CONTACT_OTHER_INFORMATION', true)); ?>
				<?php endif; ?>
				<?php if ($this->params->get('presentation_style') == 'plain'):?>

				<?php endif; ?>
			<!-- html -->
			<?php
				$parts = preg_split('/<[^>]*[\/]>/i', $this->contact->misc, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
			 	if(count($parts > 1)) :
			?>
				<div class="contact-miscinfo">
					<div class="text-center pad-all-30">
						<?php echo $parts[0]; ?>
					</div>
				</div>
				<?php else : ?>
				<div class="contact-miscinfo">
					<div class="text-center pad-all-30">
						<?php echo $this->contact->misc; ?>
					</div>
				</div>
			<?php endif; ?>

				<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
					<?php echo JHtml::_('bootstrap.endSlide'); ?>
				<?php endif; ?>
				<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
					<?php echo JHtml::_('bootstrap.endTab'); ?>
				<?php endif; ?>

			<?php endif; ?>
		</div><!-- /.cell-60 pad-left-20 bordered-after -->
	</div><!-- /.table -->
	<?php if(count($parts > 1)) : ?>
		<div class="container-fluid">
			<?php foreach ($parts as $key => $part) : ?>
				<?php if ($key>0) :?>
					<p><?php echo $part ?></p>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

<!-- /.container -->
	<!-- contact -->
		<?php if ($this->contact->con_position && $this->params->get('show_position')) : ?>
			<dl class="contact-position dl-horizontal">
				<dd itemprop="jobTitle">
					<?php echo $this->contact->con_position; ?>
				</dd>
			</dl>
		<?php endif; ?>

		<div class="row pad-all-20">
			<div class="col-sm-6">
				<!-- plain  -->
					<?php if ($this->params->get('presentation_style') == 'plain'):?>

						<?php  echo '<h3 class="item-title" id="contact-info">'. JText::_('COM_CONTACT_DETAILS').'</h3>';  ?>

					<?php endif; ?>
				<?php echo $this->loadTemplate('address'); ?>


				<!-- Callback module -->
				<div>
					<h3 class="contact-category item-title" id="callback">Заказать обратный звонок</h3>
					<div>

						<?php
							jimport( 'joomla.application.module.helper' ); // подключаем нужный класс, один раз на странице
							$module = JModuleHelper::getModules('callback'); // получаем в массив все модули из заданной позиции
							echo JModuleHelper::renderModule($module[0], $attribs); // выводим первый модуль из заданной позиции
						?>
					</div>
				</div>

				<!--/.Callback module -->



			</div><!-- /.col-sm-6 -->

		<?php if ($this->params->get('allow_vcard')) :	?>
			<?php echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS');?>
			<a href="<?php echo JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id='.$this->contact->id . '&amp;format=vcf'); ?>">
			<?php echo JText::_('COM_CONTACT_VCARD');?></a>
		<?php endif; ?>

		<!-- slider, tabs -->
			<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
				<?php echo JHtml::_('bootstrap.endSlide'); ?>
			<?php endif; ?>
			<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
				<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php endif; ?>

		<!-- form -->
		<?php if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>
			<!-- slider, tabs -->
				<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
					<?php echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_EMAIL_FORM'), 'display-form'); ?>
				<?php endif; ?>
				<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'display-form', JText::_('COM_CONTACT_EMAIL_FORM', true)); ?>
				<?php endif; ?>

			<div class="col-sm-6">
				<?php if ($this->params->get('presentation_style') == 'plain'):?>
					<?php echo '<h3 class="item-title" id="message-form">'. JText::_('COM_CONTACT_EMAIL_FORM').'</h3>';  ?>
				<?php endif; ?>

				<?php  echo $this->loadTemplate('form');  ?>
			</div><!-- /.col-sm-6 -->
		</div><!-- /.row -->

			<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
				<?php echo JHtml::_('bootstrap.endSlide'); ?>
			<?php endif; ?>
				<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
				<?php endif; ?>

		<?php endif; ?>

		<?php if ($this->params->get('show_links')) : ?>
			<?php echo $this->loadTemplate('links'); ?>
		<?php endif; ?>

		<?php if ($this->params->get('show_articles') && $this->contact->user_id && $this->contact->articles) : ?>

			<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
				<?php echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('JGLOBAL_ARTICLES'), 'display-articles'); ?>
			<?php endif; ?>
			<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
				<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'display-articles', JText::_('JGLOBAL_ARTICLES', true)); ?>
			<?php endif; ?>
			<?php if ($this->params->get('presentation_style') == 'plain'):?>
				<?php echo '<h3>'. JText::_('JGLOBAL_ARTICLES').'</h3>';  ?>
			<?php endif; ?>

			<?php echo $this->loadTemplate('articles'); ?>

			<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
				<?php echo JHtml::_('bootstrap.endSlide'); ?>
			<?php endif; ?>
			<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
				<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ($this->params->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) : ?>

			<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
				<?php echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_PROFILE'), 'display-profile'); ?>
			<?php endif; ?>
			<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
				<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'display-profile', JText::_('COM_CONTACT_PROFILE', true)); ?>
			<?php endif; ?>
			<?php if ($this->params->get('presentation_style') == 'plain'):?>
				<?php echo '<h3>'. JText::_('COM_CONTACT_PROFILE').'</h3>';  ?>
			<?php endif; ?>

			<?php echo $this->loadTemplate('profile'); ?>

			<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
				<?php echo JHtml::_('bootstrap.endSlide'); ?>
			<?php endif; ?>
			<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
				<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php endif; ?>

		<?php endif; ?>



		<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
			<?php echo JHtml::_('bootstrap.endAccordion'); ?>
		<?php endif; ?>
		<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
			<?php echo JHtml::_('bootstrap.endTabSet'); ?>
		<?php endif; ?>
</div>
<!-- map -->
	<div class="container-fluid">
		<h3 id="map" class="text-center bordered-bottom item-title">Карта</h3>
		<div id="map-canvas"></div>
	</div>
	<hr>
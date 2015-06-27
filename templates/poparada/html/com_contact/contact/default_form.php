<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

?>

<div class="contact-form">
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate">
		<fieldset>
			<legend>Отправить сообщение.<br>
				<small class="text-danger"><sup>*</sup> Все поля, отмеченные звёздочкой, являются обязательными.</small></legend>
			<div class="form-group">

					<?php echo $this->form->getLabel('contact_name'); ?>


					<?php echo $this->form->getInput('contact_name', null, null, "form-control"); ?>

			</div>
			<div class="form-group">
				<?php echo $this->form->getLabel('contact_email'); ?>
				<?php echo $this->form->getInput('contact_email', null, null, "form-control"); ?>
			</div>
			<div class="form-group">
				<?php echo $this->form->getLabel('contact_subject'); ?>
				<?php echo $this->form->getInput('contact_subject', null, null, "form-control"); ?>
			</div>
			<div class="form-group">
				<?php echo $this->form->getLabel('contact_message'); ?>
				<?php echo $this->form->getInput('contact_message', null, null, "form-control"); ?>
			</div>
			<?php if ($this->params->get('show_email_copy')) : ?>
				<div class="checkbox">
					<label for="">

					<?php echo $this->form->getInput('contact_email_copy'); ?>
					Отправить копию этого сообщения на ваш адрес
					</label>
				</div>
			<?php endif; ?>
			<?php //Dynamically load any additional fields from plugins. ?>
			<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
				<?php if ($fieldset->name != 'contact') : ?>
					<?php $fields = $this->form->getFieldset($fieldset->name); ?>
					<?php foreach ($fields as $field) : ?>
						<div class="control-group">
							<?php if ($field->hidden) : ?>
								<div class="controls">
									<?php echo $field->input; ?>
								</div>
							<?php else: ?>
								<div class="control-label">
									<?php echo $field->label; ?>
									<?php if (!$field->required && $field->type != "Spacer") : ?>
										<span class="optional"><?php echo JText::_('COM_CONTACT_OPTIONAL'); ?></span>
									<?php endif; ?>
								</div>
								<div class="controls"><?php echo $field->input; ?></div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<div class="form-actions" style="padding-top: 10px">

				<button class="btn btn-common validate"  type="submit"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>
				<?php if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>
				<input type="hidden" name="option" value="com_contact" />
				<input type="hidden" name="task" value="contact.submit" />
				<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
				<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</fieldset>
	</form>
</div>
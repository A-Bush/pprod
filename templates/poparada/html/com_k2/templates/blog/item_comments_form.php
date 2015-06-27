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

<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'custom',
	 custom_theme_widget: 'responsive_recaptcha'
 };
</script>

<h4 class="text-center bordered-bottom"><?php echo JText::_('K2_LEAVE_A_COMMENT') ?></h4>

<?php if($this->params->get('commentsFormNotes')): ?>
<p class="itemCommentsFormNotes">
	<?php if($this->params->get('commentsFormNotesText')): ?>
	<?php echo nl2br($this->params->get('commentsFormNotesText')); ?>
	<?php else: ?>
	<?php echo JText::_('K2_COMMENT_FORM_NOTES') ?>
	<?php endif; ?>
</p>
<?php endif; ?>

<form action="<?php echo JURI::root(true); ?>/index.php" method="post" id="comment-form" class="form-validate">
	<div class="col-sm-8">
		<div class="form-group hidden-xs">
			<label class="formComment" for="commentText"><?php echo JText::_('K2_MESSAGE'); ?> *</label>
			<textarea rows="20" class="form-control inputbox" onblur="if(this.value=='') this.value='<?php echo JText::_('K2_ENTER_YOUR_MESSAGE_HERE'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_ENTER_YOUR_MESSAGE_HERE'); ?>') this.value='';" name="commentText" id="commentText"><?php echo JText::_('K2_ENTER_YOUR_MESSAGE_HERE'); ?></textarea>
		</div>
		<div class="form-group visible-xs">
			<label class="formComment" for="commentText"><?php echo JText::_('K2_MESSAGE'); ?> *</label>
			<textarea rows="5" class="form-control inputbox" onblur="if(this.value=='') this.value='<?php echo JText::_('K2_ENTER_YOUR_MESSAGE_HERE'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_ENTER_YOUR_MESSAGE_HERE'); ?>') this.value='';" name="commentText" id="commentText"><?php echo JText::_('K2_ENTER_YOUR_MESSAGE_HERE'); ?></textarea>
		</div>
	</div>


	<div class="col-sm-4">
		<div class="form-group">
			<label class="formName" for="userName"><?php echo JText::_('K2_NAME'); ?> *</label>
			<input class="inputbox form-control" type="text" name="userName" id="userName" value="<?php echo JText::_('K2_ENTER_YOUR_NAME'); ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('K2_ENTER_YOUR_NAME'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_ENTER_YOUR_NAME'); ?>') this.value='';" />
		</div>
		<div class="form-group">
			<label class="formEmail" for="commentEmail"><?php echo JText::_('K2_EMAIL'); ?> *</label>
			<input class="inputbox form-control" type="text" name="commentEmail" id="commentEmail" value="<?php echo JText::_('K2_ENTER_YOUR_EMAIL_ADDRESS'); ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('K2_ENTER_YOUR_EMAIL_ADDRESS'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_ENTER_YOUR_EMAIL_ADDRESS'); ?>') this.value='';" />
		</div>



		<?php if($this->params->get('recaptcha') && ($this->user->guest || $this->params->get('recaptchaForRegistered', 1))): ?>
		<label class="formRecaptcha"><?php echo JText::_('K2_ENTER_THE_TWO_WORDS_YOU_SEE_BELOW'); ?></label>
		<!--	<div id="recaptcha"> -->



     <div id="responsive_recaptcha">
			<ul class="list-group">
				<li class="list-group-item">
					<div id="recaptcha_image"></div>
				</li>
				<!--	<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div> -->
				<li class="list-group-item">
					<div class="form-group">
						<label for="recaptcha_response_field" class="solution">
							<span class="recaptcha_only_if_image">Введите текст с картинки:</span>
							<span class="recaptcha_only_if_audio">Введите услышанные числа:</span>
						</label>
						<div class="input-group">
							<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="form-control" />
							<span class="input-group-btn">
								<a type="button" class="btn btn-default" href="javascript:Recaptcha.reload()" id="icon-reload" alt="Обновить"><span class="glyphicon glyphicon-refresh"></span></a>
								<a type="button" class="recaptcha_only_if_image btn btn-default" href="javascript:Recaptcha.switch_type('audio')" id="icon-audio" alt="Прослушать аудио"><span class="glyphicon glyphicon-headphones"></span></a>
								<a type="button" class="recaptcha_only_if_audio btn btn-default" href="javascript:Recaptcha.switch_type('image')" id="icon-image" alt="Распознать картинку"><span class="glyphicon glyphicon-picture"></span></a>
								<a type="button" class="btn btn-default" href="javascript:Recaptcha.showhelp()" id="icon-help" alt="Помощь"><span class="glyphicon glyphicon-question-sign"></span></a>
							</span>
						</div>
					</div>
				</li>
			</ul>
		</div>

	<!--	</div>  -->

		<?php endif; ?>

		<!--  -->
		
			
		
		<span id="formLog" style="color:red"></span>
		
		<input type="submit" class="btn btn-smaller" id="submitCommentButton" value="<?php echo JText::_('K2_SUBMIT_COMMENT'); ?>" />


		<input type="hidden" name="option" value="com_k2" />
		<input type="hidden" name="view" value="item" />
		<input type="hidden" name="task" value="comment" />
		<input type="hidden" name="itemID" value="<?php echo JRequest::getInt('id'); ?>" />
		<?php echo JHTML::_('form.token'); ?>
	</div>
</form>
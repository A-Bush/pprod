<?php
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2011-2014 Ext-Joom.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2.
# Author: Ext-Joom.com
# Websites:  http://www.ext-joom.com
# Date modified: 01/09/2014 - 13:00
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die;
?>


<div class="mod_ext_callback <?php echo $moduleclass_sfx ?>">

<?php
// check
if(isset($_POST['extsendcallback'])) {
	$name 		= trim(strip_tags($_POST["name"]));
	$phone 		= trim(strip_tags($_POST["phone"]));

	if ($ext_show_message > 0) {
		$message 	= trim(htmlspecialchars($_POST["message"],ENT_QUOTES));
	}

	if ( $name=="" OR $phone=="") {
		if($ext_error_field == '' OR $ext_error_field == ' ') {
			$errMsg .= JText::_(ERRORFIELD)."<br />";
		} else {
			$errMsg .= $ext_error_field."<br />";
			}
	}


	if($errMsg == '') {

		$msg  = "$ext_name_label  $name <br/>";
		$msg .=	"$ext_phone_label  $phone <br/>";
		if ($ext_show_message > 0) {
			if(get_magic_quotes_gpc()) {
				$message = stripslashes($message);
			}
			$msg .=	"$ext_message_label \r\n$message";
		}

		$headers= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: $ext_my_email\r\n";
		$headers .= "Reply-To: $ext_my_email\r\n";
		//$headers .= "Return-Path: $email\r\n";

		mail($ext_my_email, $ext_subject, $msg, $headers);


?>
		<div style="text-align:center;">
			<p>
			<?php
			echo $ext_send_message=='' ? JText::_(SENDMESSAGE) : $ext_send_message;
			?>
			</p>
		<div style="clear:both;"></div>
		</div>
<?php
	}
}

if(!isset($_POST['extsendcallback']) || $errMsg != '') {
?>
	<div class="ext_callback_form">
		<?php
		if ($errMsg != ''){
			echo '<p>'.$errMsg.'</p>';
		}
		?>

		<form id="ext_callback_id_<?php echo $ext_id;?>" class="blocks" action="" method="post">
			<div class="form-group">
				<label for="name"><?php echo $ext_name_label;?></label>
				<input required type="text" class="form-control" name="name" pattern="^[a-zA-Zа-яА-ЯєїіЄЇІ'\s]+$" placeholder="<?php echo $ext_attribute_name; ?>" />
			</div>

			<div class="form-group">
				<label for="phone"><?php echo $ext_phone_label;?></label>
				<input required type="text" class="form-control" name="phone" pattern="[\+0-9]{7,14}" placeholder="<?php echo $ext_attribute_phone; ?>" />
			</div>

			<?php if ($ext_show_message > 0) { ?>
			<div class="form-group">
				<label for="message"><?php echo $ext_message_label;?></label>
				<textarea class="form-control" name="message" rows="3" placeholder="<?php echo $ext_attribute_message; ?>"></textarea>

			<?php } ?>
			</div>

			<p>
				<input type="submit" class="btn btn-common validate" pattern="{,250}" value="<?php echo $ext_send_label;?>"  name="extsendcallback" />
			</p>
		</form>
	</div>

<?php
}
?>
	<div style="clear:both;"></div>
</div>
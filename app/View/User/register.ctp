<?php if(!empty($continue_link)) { ?>

	<a href="<?=$continue_link?>" class="btn btn-default"><?=$continue_link_text?></a>

<?php } else { ?>

	<p></p>
	<label for="UserEmail"><?=__("Email address")?></label>
	<div class="input">
	<?php if(!empty($ajax) && $ajax) { ?>
		<input name="was" type="hidden" id="was" value="/<?=$wannabe->event->reference?>/Login#register" />
	<?php } else { ?>
			<input name="was" type="hidden" id="was" value="/<?=$wannabe->event->reference?>/User/Register" />
	<?php } ?>

	</div>
	<input class="email_field" name="email" type="textfield" id="UserEmail" autofocus placeholder="<?=__("email@address.com")?>" <? if(isset($previous)) { echo "value='".$previous."'"; } ?>/>
	<span class="help-block">
		<?=__("Enter your email address to register for a new account. <br />Use a valid email address as you will reviece an email from us asking you to validate your email account before registration continues.")?>
	</span>

<?php } ?>

<p></p>
<input type="hidden" name="id" value="<?=$user['User']['id']?>" />
<div class="clearfix<? if(isset($passwordMismatch)) echo "error"; ?>">
<label for="UserPassword1"><?=__("Password")?></label>
	<div class="input">
		<input class="password_field1" name="password1" type="password" id="UserPassword1" autofocus placeholder="<?=__("password")?>" />
	</div>
</div>
<label for="UserPassword2"><?=__("Confirm")?></label>
<div class="clearfix<? if(isset($passwordMismatch)) echo "error"; ?>">
	<div class="input">
		<input class="password_field2" name="password2" type="password" id="UserPassword2" placeholder="<?=__("confirm")?>" />
		<span class="help-block">
<?php
if(isset($passwordMismatch)) {
	echo __("Passwords did not match, try again.");
} else {
	echo __("Enter your new password two times.");
}
?>
		</span>
	</div>
</div>

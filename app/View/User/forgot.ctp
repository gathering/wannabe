<p></p>
<label for="UserEmail"><?=__("Email address")?></label>
<div class="input">
<?php
if($ajax):
?>
        <input name="was" type="hidden" id="was" value="/<?=$wannabe->event->reference?>/Login#forgot" />
<?php
else:
?>
        <input name="was" type="hidden" id="was" value="/<?=$wannabe->event->reference?>/User/Forgot" />
<?php
endif;
?>
<input class="email_field" name="email" type="textfield" id="UserEmail" autofocus placeholder="<?=__("email@address.com")?>"  <? if(isset($previous)) { echo "value='".$previous."'"; } ?>/>
<span class="help-block">
<?=__("Enter your email address to reset your password.")?>
</span>
</div>

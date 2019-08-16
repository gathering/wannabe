<form method="POST">
	<fieldset>
        <label for="data[Otherinfo][message]"><?=__("Message")?></label>
        <div class="input"><textarea name="data[Otherinfo][message]"></textarea></div>
        <div class="actions">
            <?=$this->Form->submit(__('Deny'), array('name'=>'verify-yes', 'class' => 'btn danger small', 'div' => false))?>
            <a href="<?=$was?>" class='btn small' ><?=__("Back")?></a>
        </div>
	</fieldset>
</form>

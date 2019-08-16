<form method="POST">
	<fieldset>
	<legend><?=$header?></legend>
	<div class="input"><?=$text?></div>
	<? if (isset($rejectall) && $rejectall) : ?>
	<label for="data[denialmessage]"><?=__("Denial message")?></label>
	<div class="input"><textarea name="data[denialmessage]"></textarea></div>
	<? endif; ?>
	<div class="actions">
	<?=$this->Form->submit(__('Yes'), array('name'=>'verify-yes', 'class' => 'btn danger small', 'div' => false))?>
	<a href="<?=$was?>" class='btn small' ><?=__("No")?></a>
	</div>
	<? if(isset($hidden) && count($hidden)) foreach($hidden as $name => $value) { ?>
	    <?=$this->Form->hidden($name, array('value' => $value))?>
	<? } ?>
	</fieldset>
</form>

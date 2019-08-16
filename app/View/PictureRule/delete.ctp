<form method="post">
	<fieldset>
		<legend><?=__("Delete %s", $rule['PictureRule']['rule_text'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this rule? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('PictureRule.id', array('value' => $rule['PictureRule']['id']))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/PictureRule')?>" class="btn"><?=__("No")?></a>
	</div>
</form>

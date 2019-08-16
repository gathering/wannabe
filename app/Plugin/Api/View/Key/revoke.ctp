<form method="post">
	<fieldset>
		<legend><?=__("Revoking API key %s", $key['ApiKey']['apikey'])?></legend>
		<div class="input"><?=__("Are you sure you want to revoke this key? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('ApiKey.id', array('value' => $key['ApiKey']['id']))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/api/Key')?>" class="btn"><?=__("No")?></a>
	</div>
</form>

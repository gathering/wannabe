<form method="post">
	<fieldset>
		<legend><?=__("Delete %s", $application['ApiApplication']['name'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this application? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('ApiApplication.id', array('value' => $application['ApiApplication']['id']))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/api/Application')?>" class="btn"><?=__("No")?></a>
	</div>
</form>

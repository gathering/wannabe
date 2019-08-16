<form method="post">
	<fieldset>
		<legend><?=__("Delete %s", $task['Task']['name'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this task? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('Task.id', array('value' => $task['Task']['id']))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/TaskAdmin')?>" class="btn"><?=__("No")?></a>
	</div>
</form>

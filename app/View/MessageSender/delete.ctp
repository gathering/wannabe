<form method="post">
	<fieldset>
		<legend><?=__("Delete %s", $sender['MessageSender']['name'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this sender? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('MessageSender.id', array('value' => $sender['MessageSender']['id']))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/MessageSender')?>" class="btn"><?=__("No")?></a>
	</div>
</form>

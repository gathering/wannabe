<form method="post" action="/<?=WB::$event->reference?>/logistic/Storage/delete/<?=$unit['LogisticStorage']['id']?>">
	<fieldset>
		<legend><?=__("Delete %s", $unit['LogisticStorage']['name'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this storage unit? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('LogisticStorage.id', array('value' => $unit['LogisticStorage']['id']))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn btn-danger'))?> <a href="<?=$this->Wb->eventUrl('/logistic')?>" class="btn btn-primary"><?=__("No")?></a>
	</div>
</form>

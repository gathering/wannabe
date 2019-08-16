<form method="post" action="/<?=WB::$event->reference?>/logistic/Supplier/delete/<?=$supplier['LogisticSupplier']['id']?>">
	<fieldset>
		<legend><?=__("Delete %s", $supplier['LogisticSupplier']['company'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this supplier? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('LogisticSupplier.id', array('value' => $supplier['LogisticSupplier']['id']))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn btn-danger'))?> <a href="<?=$this->Wb->eventUrl('/logistic/')?>" class="btn"><?=__("No")?></a>
	</div>
</form>

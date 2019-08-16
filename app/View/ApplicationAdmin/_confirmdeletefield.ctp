<form method="post" enctype="multipart/form-data" action="<?=$this->Wb->eventUrl('/ApplicationAdmin/deletefield')?>">
	<fieldset>
		<legend><?=__("Delete field “%s”", $field['ApplicationAvailableField']['name'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this field? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('ApplicationAvailableField.id', array('value' => $field['ApplicationAvailableField']['id']))?>
		<?=$this->Form->hidden('ApplicationPage.id', array('value' => $page['ApplicationPage']['id']))?>
		<?=$this->Form->hidden('Otherinfo.confirmed', array('value' => 1))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/ApplicationAdmin/field/'.$page['ApplicationPage']['id'])?>" class="btn"><?=__("No")?></a>
	</div>
</form>

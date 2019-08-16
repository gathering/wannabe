<form method="POST"  enctype="multipart/form-data" action="<?=$this->Wb->eventUrl('/ApplicationAdmin/save')?>">
	<fieldset>
		<legend><?=__("Edit field: %s", $field['ApplicationAvailableField']['name'])?></legend>
		<?=$this->Form->hidden('ApplicationAvailableField.id', array('value' => $field['ApplicationAvailableField']['id']))?>
		<?=$this->Form->hidden('Otherinfo.type', array('value' => 'field'))?>
		<?=$this->Form->hidden('ApplicationAvailableField.application_page_id', array('value' => $page['ApplicationPage']['id']))?>
		<div class="clearfix">
			<label for="data[ApplicationAvailableField][name]"><?=__("Name")?></label>
			<div class="input">
				<?=$this->Form->text('ApplicationAvailableField.name', array('value' => $field['ApplicationAvailableField']['name'], 'div' => false, 'label' => false))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationAvailableField][description]"><?=__("Description")?></label>
			<div class="input">
				<?=$this->Form->textarea('ApplicationAvailableField.description', array('value' => $field['ApplicationAvailableField']['description'], 'div' => false, 'label' => false, 'class' => 'xxlarge', 'rows' => 4))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationAvailableField][pplication_fieldtype_id]"><?=__("Field type")?></label>
			<div class="input">
				<?=$this->Form->select('ApplicationAvailableField.application_fieldtype_id', $fieldtypes, array('value' => $field['ApplicationAvailableField']['application_fieldtype_id'], 'div' => false, 'label' => false))?>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Save field"), array('name'=>'save', 'div' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/ApplicationAdmin/field/'.$page['ApplicationPage']['id'])?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

<form method="POST"  enctype="multipart/form-data" action="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/save')?>">
	<fieldset>
		<legend><?=__("Edit field: %s", $field['CfadApplicationAvailableField']['name'])?></legend>
		<?=$this->Form->hidden('CfadApplicationAvailableField.id', array('value' => $field['CfadApplicationAvailableField']['id']))?>
		<?=$this->Form->hidden('Otherinfo.type', array('value' => 'field'))?>
		<?=$this->Form->hidden('CfadApplicationAvailableField.application_page_id', array('value' => $page['CfadApplicationPage']['id']))?>
		<div class="clearfix">
			<label for="data[CfadApplicationAvailableField][name]"><?=__("Name")?></label>
			<div class="input">
				<?=$this->Form->text('CfadApplicationAvailableField.name', array('value' => $field['CfadApplicationAvailableField']['name'], 'div' => false, 'label' => false))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[CfadApplicationAvailableField][description]"><?=__("Description")?></label>
			<div class="input">
				<?=$this->Form->textarea('CfadApplicationAvailableField.description', array('value' => $field['CfadApplicationAvailableField']['description'], 'div' => false, 'label' => false, 'class' => 'xxlarge', 'rows' => 4))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[CfadApplicationAvailableField][pplication_fieldtype_id]"><?=__("Field type")?></label>
			<div class="input">
				<?=$this->Form->select('CfadApplicationAvailableField.application_fieldtype_id', $fieldtypes, array('value' => $field['CfadApplicationAvailableField']['application_fieldtype_id'], 'div' => false, 'label' => false))?>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Save field"), array('name'=>'save', 'div' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/field/'.$page['CfadApplicationPage']['id'])?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

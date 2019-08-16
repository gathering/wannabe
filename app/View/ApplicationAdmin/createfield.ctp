<form method="POST"  enctype="multipart/form-data" action="<?=$this->Wb->eventUrl('/ApplicationAdmin/save')?>">
	<fieldset>
		<legend><?=__("Create new field")?></legend>
		<?=$this->Form->hidden('Otherinfo.type', array('value' => 'field'))?>
		<?=$this->Form->hidden('ApplicationAvailableField.application_page_id', array('value' => $page['ApplicationPage']['id']))?>
		<div class="clearfix">
			<label for="data[ApplicationAvailableField][name]"><?=__("Name")?></label>
			<div class="input">
				<?=$this->Form->text('ApplicationAvailableField.name', array('div' => false, 'label' => false))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationAvailableField][description]"><?=__("Description")?></label>
			<div class="input">
				<?=$this->Form->textarea('ApplicationAvailableField.description', array('div' => false, 'label' => false, 'class' => 'xxlarge', 'rows' => 4))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationAvailableField][pplication_fieldtype_id]"><?=__("Field type")?></label>
			<div class="input">
				<?=$this->Form->select('ApplicationAvailableField.application_fieldtype_id', $fieldtypes, array('div' => false, 'label' => false, 'empty' => __("Choose")))?>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Create field"), array('name'=>'save', 'div' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/ApplicationAdmin/field/'.$page['ApplicationPage']['id'])?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

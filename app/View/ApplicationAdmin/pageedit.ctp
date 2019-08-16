<form method="POST"  enctype="multipart/form-data" action="<?=$this->Wb->eventUrl('/ApplicationAdmin/save')?>">
	<fieldset>
		<legend><?=__("Edit “%s”", $page['ApplicationPage']['name'])?></legend>
		<?=$this->Form->hidden('ApplicationPage.id', array('value' => $page['ApplicationPage']['id']))?>
		<?=$this->Form->hidden('Otherinfo.type', array('value' => 'page'))?>
		<div class="clearfix">
			<label for="data[ApplicationPage][name]"><?=__("Name")?></label>
			<div class="input">
				<?=$this->Form->text('ApplicationPage.name', array('div' => false, 'label' => false, 'value' => $page['ApplicationPage']['name']))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationPage][description]"><?=__("Description")?></label>
			<div class="input">
				<?=$this->Form->textarea('ApplicationPage.description', array('div' => false, 'label' => false, 'value' => $page['ApplicationPage']['description'], 'class' => 'xxlarge', 'rows' => 4))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationPage][position]"><?=__("Position")?></label>
			<div class="input">
				<?=$this->Form->text('ApplicationPage.position', array('div' => false, 'label' => false, 'value' => $page['ApplicationPage']['position']))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationPage][type]"><?=__("Type")?></label>
			<div class="input">
				<?=$this->Form->select('ApplicationPage.type', $types, array('empty' => __("Choose"), 'div' => false, 'label' => false, 'value' => $page['ApplicationPage']['type']))?>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit('Save', array('name'=>'save', 'div' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/ApplicationAdmin/page')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

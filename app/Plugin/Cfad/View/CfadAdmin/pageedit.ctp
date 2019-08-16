<form method="POST"  enctype="multipart/form-data" action="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/save')?>">
	<fieldset>
		<legend><?=__("Edit “%s”", $page['CfadApplicationPage']['name'])?></legend>
		<?=$this->Form->hidden('CfadApplicationPage.id', array('value' => $page['CfadApplicationPage']['id']))?>
		<?=$this->Form->hidden('Otherinfo.type', array('value' => 'page'))?>
		<div class="clearfix">
			<label for="data[CfadApplicationPage][name]"><?=__("Name")?></label>
			<div class="input">
				<?=$this->Form->text('CfadApplicationPage.name', array('div' => false, 'label' => false, 'value' => $page['CfadApplicationPage']['name']))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[CfadApplicationPage][description]"><?=__("Description")?></label>
			<div class="input">
				<?=$this->Form->textarea('CfadApplicationPage.description', array('div' => false, 'label' => false, 'value' => $page['CfadApplicationPage']['description'], 'class' => 'xxlarge', 'rows' => 4))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[CfadApplicationPage][position]"><?=__("Position")?></label>
			<div class="input">
				<?=$this->Form->text('CfadApplicationPage.position', array('div' => false, 'label' => false, 'value' => $page['CfadApplicationPage']['position']))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[CfadApplicationPage][type]"><?=__("Type")?></label>
			<div class="input">
				<?=$this->Form->select('CfadApplicationPage.type', $types, array('empty' => __("Choose"), 'div' => false, 'label' => false, 'value' => $page['CfadApplicationPage']['type']))?>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit('Save', array('name'=>'save', 'div' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/page')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

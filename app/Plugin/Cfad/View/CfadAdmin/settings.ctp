<form method="POST"  enctype="multipart/form-data" action="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/settings')?>">
	<fieldset>
		<legend><?=__("Setting for applications")?></legend>
		<?=$this->Form->hidden('CfadApplicationSetting.event_id', array('value' => $settings['CfadApplicationSetting']['event_id']))?>
		<?=$this->Form->hidden('CfadApplicationSetting.id', array('value' => $settings['CfadApplicationSetting']['id']))?>
		<div class="clearfix">
			<label for="data[CfadApplicationSetting][choices]"><?=__("Number of choices")?></label>
			<div class="input">
				<?=$this->Form->text('CfadApplicationSetting.choices', array('value' => $settings['CfadApplicationSetting']['choices'], 'div' => false, 'label' => false))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="checkOptions"><?=__("Options")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
							<?=$this->Form->checkbox('CfadApplicationSetting.can_apply', array('div' => false, 'label' => false))?>
							<span><?=__("Open for applications")?></span>
						</label>
					</li>
				</ul>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit('Save', array('name'=>'save', 'div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/cfad/')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

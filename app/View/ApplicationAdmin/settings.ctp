<form method="POST"  enctype="multipart/form-data" action="<?=$this->Wb->eventUrl('/ApplicationAdmin/settings')?>">
	<fieldset>
		<legend><?=__("Setting for applications")?></legend>
		<?=$this->Form->hidden('ApplicationSetting.event_id', array('value' => $settings['ApplicationSetting']['event_id']))?>
		<?=$this->Form->hidden('ApplicationSetting.id', array('value' => $settings['ApplicationSetting']['id']))?>
		<div class="clearfix">
			<label for="data[ApplicationSetting][choices]"><?=__("Number of choices")?></label>
			<div class="input">
				<?=$this->Form->text('ApplicationSetting.choices', array('value' => $settings['ApplicationSetting']['choices'], 'div' => false, 'label' => false))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="checkOptions"><?=__("Options")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
							<?=$this->Form->checkbox('ApplicationSetting.privacy', array('div' => false, 'label' => false))?>
							<span><?=__("Enable privacy")?></span>
						</label>
					</li>
					<li>
						<label>
							<?=$this->Form->checkbox('ApplicationSetting.priority', array('div' => false, 'label' => false))?>
							<span><?=__("Enable priority")?></span>
						</label>
					</li>
					<li>
						<label>
							<?=$this->Form->checkbox('ApplicationSetting.crewquestion', array('div' => false, 'label' => false))?>
							<span><?=__("Enable crewquestion")?></span>
						</label>
					</li>
				</ul>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationSetting][open]"><?=__("Open applications")?></label>
			<div class="input">
                <?=$this->Form->select('ApplicationSetting.open', $crews, array('div' => false, 'label' => false))?>
                <span class="help-block"><?=__("Enable sending open applications for this crew")?></span>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationSetting][deniedtext]"><?=__("Denied notification")?></label>
			<div class="input">
				<?=$this->Form->textarea('ApplicationSetting.deniedtext', array('value' => $settings['ApplicationSetting']['deniedtext'], 'div' => false, 'label' => false, 'class' => 'xxlarge', 'rows' => 4))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationSetting][donestring]"><?=__("Confirmation text")?></label>
			<div class="input">
				<?=$this->Form->textarea('ApplicationSetting.donestring', array('value' => $settings['ApplicationSetting']['donestring'], 'div' => false, 'label' => false, 'class' => 'xxlarge', 'rows' => 4))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationSetting][mailsubject]"><?=__("Confimation Subject")?></label>
			<div class="input">
				<?=$this->Form->text('ApplicationSetting.mailsubject', array('value' => $settings['ApplicationSetting']['mailsubject'], 'div' => false, 'label' => false))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[ApplicationSetting][mailstring]"><?=__("Confirmation body")?></label>
			<div class="input">
				<?=$this->Form->textarea('ApplicationSetting.mailstring', array('value' => $settings['ApplicationSetting']['mailstring'], 'div' => false, 'label' => false, 'class' => 'xxlarge', 'rows' => 4))?>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit('Save', array('name'=>'save', 'div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/ApplicationAdmin/page')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

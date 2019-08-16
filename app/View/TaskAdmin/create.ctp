<form method="post">
	<fieldset>
		<legend><?=__("Create new task")?></legend>
        <?php foreach($langs as $lang => $locale) { ?>
            <div class="clearfix <? if($this->Form->error('Task.'.$lang.'.name')) echo "error"; ?>">
                <label for="data[Task][<?=$lang?>][name]"><?=__("Name")?> (<?=$lang?>)</label>
                <div class="input">
                    <?=$this->Form->input('Task.'.$lang.'.name', array('div' => false, 'error' => false, 'label' => false))?>
                    <span class="help-block"><?=$this->Form->error('Task.'.$lang.'.name')?></span>
                </div>
            </div>
            <div class="clearfix <? if($this->Form->error('Task.'.$lang.'.message')) echo "error"; ?>">
                <label for="data[Task][<?=$lang?>][message]"><?=__("Message")?> (<?=$lang?>)</label>
                <div class="input">
                    <?=$this->Form->input('Task.'.$lang.'.message', array('empty' => __("None"), 'div' => false, 'error' => false, 'label' => false, 'rows' => 3))?>
                    <span class="help-block"><?=$this->Form->error('Task.'.$lang.'.message')?></span>
                </div>
            </div>
        <?php } ?>
		<div class="clearfix <? if($this->Form->error('Task.redirect')) echo "error"; ?>">
			<label for="data[Task][redirect]"><?=__("Redirect to")?></label>
			<div class="input">
				<?=$this->Form->input('Task.redirect', array('empty' => __("None"), 'div' => false, 'error' => false, 'label' => false))?>
				<span class="help-block"><?=$this->Form->error('Task.redirect')?></span>
			</div>
		</div>
		<div class="clearfix <? if($this->Form->error('Task.model')) echo "error"; ?>">
			<label for="data[Task][model]"><?=__("Linked model")?></label>
			<div class="input">
				<?=$this->Form->input('Task.model', array('empty' => __("None"), 'div' => false, 'error' => false, 'label' => false))?>
				<span class="help-block"><?=$this->Form->error('Task.model')?></span>
			</div>
		</div>
		<div class="clearfix <? if($this->Form->error('Task.condition')) echo "error"; ?>">
			<label for="data[Task][condition]"><?=__("Activation condition")?></label>
			<div class="input">
				<?=$this->Form->input('Task.condition', array('empty' => __("None"), 'div' => false, 'error' => false, 'label' => false, 'class' => 'code span8', 'rows' => 10))?>
				<span class="help-block"><?=$this->Form->error('Task.condition')?></span>
			</div>
		</div>
		<div class="clearfix">
			<label for="objectList"><?=__("Options")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
							<?=$this->Form->checkbox('Task.enabled', array('div' => false, 'error' => false, 'label' => false))?>
							<span><?=__("Enable task")?></span>
						</label>
					</li>
					<li>
						<label>
							<?=$this->Form->checkbox('Task.allow_sub', array('div' => false, 'error' => false, 'label' => false))?>
							<span><?=__("Allow sub-queries")?></span>
						</label>
					</li>
					<li>
						<label>
							<?=$this->Form->checkbox('Task.complete_with_model', array('div' => false, 'error' => false, 'label' => false, 'checked' => 'checked'))?>
							<span><?=__("Set completed with model")?></span>
						</label>
					</li>
					<li>
						<label>
							<?=$this->Form->checkbox('Task.skip_button', array('div' => false, 'error' => false, 'label' => false))?>
							<span><?=__("Enable skip button")?></span>
						</label>
					</li>
				</ul>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Create task"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/TaskAdmin')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

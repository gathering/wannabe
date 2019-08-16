<form method="post">
	<fieldset>
		<legend><?=__("Create new application")?></legend>
        <div class="clearfix <? if($this->Form->error('ApiApplication.name')) echo "error"; ?>">
            <label for="data[ApiApplication][name]"><?=__("Name")?></label>
            <div class="input">
                <?=$this->Form->input('ApiApplication.name', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('ApiApplication.name')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('ApiApplication.description')) echo "error"; ?>">
            <label for="data[ApiApplication][description]"><?=__("Description")?></label>
            <div class="input">
                <?=$this->Form->textarea('ApiApplication.description', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('ApiApplication.description')?></span>
            </div>
        </div>
        <div class="clearfix">
            <label for="data[ApiApplication][enabled]"><?=__('Enabled')?></label>
            <div class="input">
                <ul class="inputs-list">
                    <li>
                        <label>
                            <?=$this->Form->checkbox('ApiApplication.enabled', array('div' => 'false'))?> 
                            <span><?=__("Applications must be enabled to be used")?></span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Create application"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/api/Application')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

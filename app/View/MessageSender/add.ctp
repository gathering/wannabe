<form method="post">
	<fieldset>
		<legend><?=__("Create new sender")?></legend>
        <div class="clearfix <? if($this->Form->error('MessageSender.name')) echo "error"; ?>">
            <label for="data[MessageSender][name]"><?=__("Name")?></label>
            <div class="input">
                <?=$this->Form->input('MessageSender.name', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('MessageSender.name')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('MessageSender.email')) echo "error"; ?>">
            <label for="data[MessageSender][email]"><?=__("Email")?></label>
            <div class="input">
                <?=$this->Form->email('MessageSender.email', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('MessageSender.email')?></span>
            </div>
        </div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Create sender"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/MessageSender')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

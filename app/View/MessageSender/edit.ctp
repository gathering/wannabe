<form method="post">
	<fieldset>
		<legend><?=__("Edit %s", $sender['MessageSender']['name'])?></legend>
		<?=$this->Form->hidden('MessageSender.id', array('value' => $sender['MessageSender']['id']))?>
        <div class="clearfix <? if($this->Form->error('MessageSender.name')) echo "error"; ?>">
            <label for="data[MessageSender][name]"><?=__("Name")?></label>
            <div class="input">
                <?=$this->Form->input('MessageSender.name', array('div' => false, 'error' => false, 'label' => false, 'value' => $sender['MessageSender']['name']))?>
                <span class="help-block"><?=$this->Form->error('MessageSender.name')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('MessageSender.email')) echo "error"; ?>">
            <label for="data[MessageSender][email]"><?=__("Email")?></label>
            <div class="input">
                <?=$this->Form->email('MessageSender.email', array('div' => false, 'error' => false, 'label' => false, 'value' => $sender['MessageSender']['email']))?>
                <span class="help-block"><?=$this->Form->error('MessageSender.email')?></span>
            </div>
        </div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Save sender"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/MessageSender')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

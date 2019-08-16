<form method="post">
    <fieldset>
        <legend><?=__("Create new channel")?></legend>
        
        <div class="clearfix <? if($this->Form->error('IrcChannelKey.channelname')) echo "error"; ?>">
            <label for="data[IrcChannelKey][channelname]"><?=__("Channel name")?> </label>
            
            <div class="input">
                <?=$this->Form->input('IrcChannelKey.channelname', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('IrcChannelKey.channelname')?> </span>
            </div>

        </div>
        <div class="clearfix <? if($this->Form->error('IrcChannelKey.channelkey')) echo "error"; ?>">
            <label for="data[IrcChannelKey][channelkey]"><?=__("Channel key")?> </label>

            <div class="input">
                <?=$this->Form->input('IrcChannelKey.channelkey', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('IrcChannelKey.channelkey')?> </span>
            </div>
        </div>
        
        <hr />
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit(__("Create channel"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/IrcChannelKeyAdmin')?>" class="btn"><?=__("Back")?></a>
    </div>
</form>

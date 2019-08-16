<form method="post">
    <h3><?=__("Do you really want to delete the channel %s", "\"" . $channel['IrcChannelKey']['channelname'] . "\"")?></h3>
    <div class="actions">
        <?=$this->Form->submit(__("Delete channel"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/IrcChannelKeyAdmin')?>" class="btn"><?=__("Back")?></a>
    </div>
</form>

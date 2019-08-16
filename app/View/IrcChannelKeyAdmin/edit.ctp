<form method="post">
    <fieldset>
       <?=$this->Form->hidden('IrcChannelKey.id', array('value' => $channel['IrcChannelKey']['id']))?> 
       <?=$this->Form->hidden('IrcChannelKeyCrew.irc_channel_key_id', array('value'=> $channel['IrcChannelKey']['id']))?>
        <legend><?=__("Edit channel %s", "\"" . $channel['IrcChannelKey']['channelname'] . "\"")?></legend>
        
        <div class="row">
            <div class="span8">
                <div class="clearfix <? if($this->Form->error('IrcChannelKey.channelkey')) echo "error"; ?>">
                    <label for="data[IrcChannelKey][channelkey]"><?=__("Channel key")?> </label>

                    <div class="input">
                        <?=$this->Form->input('IrcChannelKey.channelkey', array('value' => $channel['IrcChannelKey']['channelkey'], 'div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$this->Form->error('IrcChannelKey.channelkey')?> </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span8">
                <div class="clearfix <? if($this->Form->error('IrcChannelKeyCrew.crew_id')) echo "error"; ?>">
                    <label for="data[IrcChannelKeyCrew][crew_id]"><?=__("Add crew")?></label>
                
                    <div class="input">
                        <?=$this->Form->select('IrcChannelKeyCrew.crew_id', $crews, array('empty' => __("Choose"), 'div' => false, 'error' => false))?>
                        <span class="help-block"><?=$this->Form->error('IrcChannelKeyCrew.crew_id')?></span>
                    </div>
                </div>
            </div>
            <div class="span8">
                <?=$this->Form->submit(__("Save and add crew"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> 
            </div>
        </div>
    </fieldset>
</form>

<div class="row">
    <div class="span16">
        <hr />
        <h3><?=__("Enabled crews (No listed crews means the channel is open to everyone.)")?></h3>
        <table>
            <tr>
                <th><?=__("Crew id")?></th>
                <th><?=__("Crew name")?></th>
                <th><?=__("Delete")?></th>
            </tr>

        <? foreach($enabled_crews as $enabled_crew) { ?>
            <tr>
                <td><?=$enabled_crew['IrcChannelKeyCrew']['crew_id']?></td>
                <td><?=$crews[$enabled_crew['IrcChannelKeyCrew']['crew_id']]?></td>
                <td><a href="<?=$this->Wb->eventUrl("/IrcChannelKeyAdmin/Deletecrew/{$channel['IrcChannelKey']['id']}/{$enabled_crew['IrcChannelKeyCrew']['crew_id']}") ?>" class="btn danger"><?=__("Delete")?></a></td>
            </tr>
        <? } ?>
        </table>
    </div>
</div>

<hr />
<div class="row">
    <div class="span16">
        <a href="<?=$this->Wb->eventUrl('/IrcChannelKeyAdmin')?>" class="btn"><?=__("Back")?></a>
    </div>
</div>

<div class="row">
    <div class="span16">
        <h3><?=__("Create new channel")?></h3>
        <a href="<?=$this->Wb->eventUrl("/IrcChannelKeyAdmin/Create/")?>" class="btn primary"><?=__("Create new channel")?></a>
    </div>
</div>

<div class="row">
    <div class="span16">
        <hr />
        <h3><?=__("Channels")?></h3>
        <table>
            <tr>
                <th><?=__("Channel name")?></th>
                <th><?=__("Channel password")?></th>
                <th><?=__("Updated")?></th>
                <th><?=__("Edit")?></th>
                <th><?=__("Delete")?></th>
            </tr>

        <?php foreach($channelList as $channelEntry => $channelObject) { ?>
            <tr>
                <td><?=$channelObject['IrcChannelKey']['channelname']?></td>
                <td><?=$channelObject['IrcChannelKey']['channelkey']?></td>
                <td><?=$channelObject['IrcChannelKey']['updated']?></td>
                <td><a href="<?=$this->Wb->eventUrl("/IrcChannelKeyAdmin/Edit/{$channelObject['IrcChannelKey']['id']}")?>" class="btn"><?=__("Edit")?></a></td>
                <td><a href="<?=$this->Wb->eventUrl("/IrcChannelKeyAdmin/Delete/{$channelObject['IrcChannelKey']['id']}")?>" class="btn danger"><?=__("Delete")?></a></td>
            </tr>
        <?php } ?>
        </table>
    </div>
</div>

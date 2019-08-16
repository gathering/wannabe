<div class="row">
    <div class="span8">
        <h3><?=__("Add new badge")?></h3>
        <a href="<?=$this->Wb->eventUrl("/Badge/add")?>" class="btn primary"><?=__("Add new badge")?></a>
        <a href="<?=$this->Wb->eventUrl("/Badge/disable")?>" class="btn danger"><?=__("Disable badge by scanning")?></a>
    </div>
</div>
<br />
<div class="row">
    <div class="span16">
        <h3><?=__("Active badges for this event")?></h3>
        <?php if($badges) { ?>
            <table>
                <tr>
                    <th><?=__("Type")?></th>
                    <th><?=__("NFC id")?></th>
                    <th><?=__("User")?></th>
                    <th><?=__("Specification")?></th>
                    <th><?=__("Last updated")?></th>
                    <th><?=__("Active")?></th>
                </tr>
            <?php foreach($badges as $badge ) { ?>
                <tr>
                    <td><?=$badge['Badge']['type']?></td>
                    <td><?=$badge['Badge']['nfc_id']?></td>
                    <td><?=($badge['Badge']['user_id'] ? $this->Wb->userLink($badge) : __('No user related.'))?></td>
                    <td><?=$badge['Badge']['specification']?></td>
                    <td><?=$badge['Badge']['updated']?></td>
                    <td>
                        <?php if ($badge['Badge']['active']) { ?>
                            <a href="<?=$this->Wb->eventUrl("/Badge/disable/".$badge['Badge']['id'])?>" class="btn danger" onclick="confirm('Are you sure?')"><?=__('Disable')?></a>
                        <?php } else { echo _("Disabled"); } ?>
                    </td>
                </tr>
            <?php } ?>

           </table>
        <?php } else { ?>
            <p>No badges to display.</p>
        <?php } ?>
    </div>
</div>

<h3><?=__("Actions")?></h3>
<a href="<?=$this->Wb->eventUrl("/KeycardHandout/out")?>" class="btn success"><?=__("Hand out card")?></a>
<a href="<?=$this->Wb->eventUrl("/KeycardCard")?>" class="btn"><?=__("Manage cards")?></a>
<hr />
<h3><?=__("Key cards currently out")?></h3>
<?php if($handouts) { ?>
<table>
    <thead>
    <th><?=__("Card number")?></th>
    <th><?=__("Name")?></th>
    <th><?=__("Seat/Row")?></th>
    <th><?=__("Phone")?></th>
    <th><?=__("Deposit")?></th>
    <th><?=__("Description")?></th>
    <th><?=__("Handout time")?></th>
    <th></th>
    </thead>
    <tbody>
    <?php foreach($handouts as $handout) { ?>
    <tr>
        <td><?=$handout['KeycardHandout']['card_id']?></td>
        <td><?=$handout['KeycardHandout']['name']?></td>
        <td><?=$handout['KeycardHandout']['seat']?></td>
        <td><?=$handout['KeycardHandout']['phone']?></td>
        <td><?=$handout['KeycardHandout']['deposit']?></td>
        <td><?=$handout['KeycardHandout']['deposit_desc']?></td>
        <td><?=strftime(__("%b %e %G, %H:%M"), strtotime($handout['KeycardHandout']['created']))?></td>
        <td><a href="<?=$this->Wb->eventUrl("/KeycardHandout/in/".$handout['KeycardHandout']['id'])?>" class="btn primary"><?=__("Hand in")?></a></td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<?php }else{ echo __("There are no cards out right now"); } ?>

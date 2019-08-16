<h3><?=__("Actions")?></h3>
<a href="<?=$this->Wb->eventUrl("/KeycardCard/add")?>" class="btn primary"><?=__("Register new card")?></a>
<hr />
<h3><?=__("Key cards")?></h3>
<table>
    <thead>
        <th><?=__("Id")?></th>
        <th><?=__("Card number")?></th>
        <th><?=__("Delete")?></th>
    </thead>
    <tbody>
        <?php foreach($cards as $card) { ?>
        <tr>
            <td><?=$card['KeycardCard']['id']?></td>
            <td><?=$card['KeycardCard']['card_number']?></td>
            <td><a class="btn danger" href="<?=$this->Wb->eventUrl('/KeycardCard/delete/'.$card['KeycardCard']['id'])?>"><?=__("Delete")?></a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<div class="actions">
    <a class="btn" href="<?=$this->Wb->eventUrl('/KeycardHandout')?>"><?=__("Back")?></a>
</div>

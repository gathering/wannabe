<h3><?=__("Register new item")?></h3>
<a href="<?=$this->Wb->eventUrl("/WardrobeCardAdmin/Create")?>" class="btn primary"><?=__("Register new item")?></a>

<hr />

<div class="row">
    <div class="span16">
        <h4><?=__("Items")?></h4>
        <table class="zebra-striped bordered-table">
            <tr>
                <th><?=__("Description of item")?></th>
                <th><?=__("Serialnumber")?></th>
                <th><?=__("Edit")?></th>
                <th><?=__("Delete")?></th>
            <tr>

            <? foreach($cards as $card) { ?>        
            <tr>
                <td> <?= $card['WardrobeCard']['wardrobe'] ?> </td>
                <td> <?= $card['WardrobeCard']['card'] ?> </td>
                <td> <a href="<?=$this->Wb->eventUrl("/WardrobeCardAdmin/Edit/{$card['WardrobeCard']['id']}")?>" class="btn"><?=__("Edit")?></a></td>
                <td> <a href="<?=$this->Wb->eventUrl("/WardrobeCardAdmin/Delete/{$card['WardrobeCard']['id']}")?>" class="btn danger"><?=__("Delete")?></a></td>
            </tr>
            <? } ?>
        </table>
    </div>
</div>

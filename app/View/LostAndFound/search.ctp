<div class="row">
    <div class="span16">
        
        <br />
        <h3><?=__("Items")?></h3>

        <table class="zebra-striped bordered-table">
            <tr>
                <th><?=__("Name")?></th>
                <th><?=__("Description")?></th>
                <th><?=__("Found where")?></th>
                <th><?=__("Found when")?></th>
                <th><?=__("Reported by")?></th>
                <th><?=__("Contact")?></th>
                <th><?=__("Edit")?></th>
                <th><?=__("Resolve")?></th>
                <th><?=__("Delete")?></th>
            </tr>
        
        <? foreach($items as $item) { ?>
            <tr>
                <td> <?= $item['LostAndFound']['name'] ?> </td>
                <td> <?= $item['LostAndFound']['description'] ?> </td>
                <td> <?= $item['LostAndFound']['found_where'] ?> </td>
                <td> <?= $item['LostAndFound']['found_when'] ?> </td>
                <td> <?= $item['LostAndFound']['reported_by'] ?> </td>
                <td> <?= $item['LostAndFound']['reported_by_contact'] ?> </td>
                <td><a href="<?=$this->Wb->eventUrl("/LostAndFound/Edit/{$item['LostAndFound']['id']}")?>" class="btn primary"><?=__("Edit")?></a> </td>
                <td>
                    <? if($item['LostAndFound']['resolved'] != '0000-00-00 00:00:00') { ?>
                        <font color="Green">Resolved</font>
                    <? } else { ?>
                        <a href="<?=$this->Wb->eventUrl("/LostAndFound/Resolve/{$item['LostAndFound']['id']}")?>" class="btn success"><?=__("Resolve")?></a>
                    <? } ?>
                </td>
                <td><a href="<?=$this->Wb->eventUrl("/LostAndFound/Delete/{$item['LostAndFound']['id']}")?>" class="btn danger"><?=__("Delete")?></a> </td>
            </tr>
        <? } ?>

        </table>
    </div>
</div>

<div class="actions">
        <a href="<?=$this->Wb->eventUrl('/LostAndFound')?>" class="btn"><?=__("Back")?></a>
</div>

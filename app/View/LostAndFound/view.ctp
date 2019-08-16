<fieldset>
    <legend><?=__("View item")?></legend>
    
    <table class="zebra-striped bordered-table">
        <tr>
            <th></th>
            <th><?=__("Value")?></th>
        </tr>
        <tr>
            <td><?=__("Id")?></td>
            <td><?=$item['LostAndFound']['id']?></td>
        </tr>
        <tr>
            <td><?=__("Name")?>/td>
            <td><?=$item['LostAndFound']['name']?></td>
        </tr>
        <tr>
            <td><?=__("Lost/Found")?></td>
            <td><? echo $item['LostAndFound']['type'] == 0 ? 'Lost' : 'Found' ?></td>
        </tr>
        <tr>
            <td><?=__("Description")?></td>
            <td><?=$item['LostAndFound']['description']?></td>
        </tr>
        <tr>
            <td><?=__("Lost/Found where")?></td>
            <td><?=$item['LostAndFound']['found_where']?></td>
        </tr>
        <tr>
            <td><?=__("Lost/Found when")?></td>
            <td><?=$item['LostAndFound']['found_when']?></td>
        </tr>
        <tr>
            <td><?=__("Reported by")?></td>
            <td><?=$item['LostAndFound']['reported_by']?></td>
        </tr>
        <tr>
            <td><?=__("Reported by contact")?></td>
            <td><?=$item['LostAndFound']['reported_by_contact']?></td>
        </tr>
        <tr>
            <td><?=__("Delivered to")?></td>
            <td><?=$item['LostAndFound']['delivered_to']?></td>
        </tr>
        <tr>
            <td><?=__("Delivered to contact")?></td>
            <td><?=$item['LostAndFound']['delivered_to_contact']?></td>
        </tr>
        <tr>
            <td><?=__("Resolved")?></td>
            <td><?=$item['LostAndFound']['resolved']?></td>
        </tr>
        <tr>
            <td><?=__("Resolved by")?></td>
            <td><a href="<?=$this->Wb->eventUrl("/Profile/View/{$item['LostAndFound']['resolved_by']}")?>"><?=$realname['User']['realname']?></a></lab</td>
        </tr>
        <tr>
            <td><?=__("Created")?></td>
            <td><?=$item['LostAndFound']['created']?></td>
        </tr>
        <tr>
            <td><?=__("Updated")?></td>
            <td><?=$item['LostAndFound']['updated']?></td>
        </tr>
    </table>
</fieldset>

<div class="actions">
    <a href="<?=$this->Wb->eventUrl('/LostAndFound')?>" class="btn"><?=__("Back")?></a>
</div>

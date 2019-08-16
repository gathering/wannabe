<?= $this->Html->css("//cdn.datatables.net/1.10.5/css/jquery.dataTables.min.css") ?>
<?= $this->Html->script("//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js") ?>
<?= $this->Html->css('lostandfound/lostandfound')?>

<div class="row">
    <div class="span-one-third">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/add")?>" class="btn success large"><?=__("Add new item")?></a>
    </div>
    <div class="span-one-third">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/lost")?>" class="btn large"><?=__("Go to Lost section")?></a>
    </div>
    <div class="span-one-third">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/resolved")?>" class="btn large"><?=__("Go to Resolved section")?></a>
    </div>
</div>
<hr />

<table id="foundItemsTable" class="display cell-border hover stripe">
    <thead>
    <tr>
        <td><?=__("Category");?></td>
        <td><?=__("Storage place");?></td>
        <td><?=__("Description");?></td>
        <td><?=__("Info");?></td>
        <td><?=__("Edit");?></td>
        <td><?=__("Delete");?></td>
        <td><?=__("Resolve");?></td>
        <td>Found by</td>
        <td>Found date</td>
        <td>Found logged in user</td>
        <td>Found registered by</td>
        <td>Found resolved description</td>
        <td>Found resolved date</td>
        <td>Found resolved delivered to</td>
        <td>Found resolved delivered by</td>
        <td>Found resolved logged in user</td>
        <td>Found resolved registered by</td>
    </tr>
    </thead>
    <tbody>
    <? foreach($foundItems as $foundItem) { ?>
        <? $id = $foundItem["FoundItem"]["id"] ?>
        <tr>
            <td><?= $foundItem["LostAndFoundCategory"]["name"] ?></td>
            <td><?= $foundItem["LostAndFoundStoragePlace"]["name"] ?></td>
            <td><?= $foundItem["FoundItem"]["description"] ?></td>
            <td><a href="found_info/<?= $id ?>"><?= __("Info") ?></a></td>
            <td><a href="found_edit/<?= $id ?>"><?= __("Edit") ?></a></td>
            <td><a href="found_delete/<?= $id ?>"><?= __("Delete") ?></a></td>
            <td><a href="found_resolve/<?= $id ?>"><?=__("Set as resolved") ?></a></td>
            <td><?= $foundItem["FoundItem"]["found_by"] ?></td>
            <td><?= $foundItem["FoundItem"]["found_date"] ?></td>
            <td><?= $foundItem["FoundItem"]["found_logged_in_user"] ?></td>
            <td><?= $foundItem["FoundItem"]["found_registered_by"] ?></td>
            <td><?= $foundItem["FoundItem"]["resolved_description"] ?></td>
            <td><?= $foundItem["FoundItem"]["resolved_date"] ?></td>
            <td><?= $foundItem["FoundItem"]["resolved_delivered_to"] ?></td>
            <td><?= $foundItem["FoundItem"]["resolved_delivered_by"] ?></td>
            <td><?= $foundItem["FoundItem"]["resolved_logged_in_user"] ?></td>
            <td><?= $foundItem["FoundItem"]["resolved_registered_by"] ?></td>
        </tr>
    <? } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $("#foundItemsTable").dataTable({
            "saveState": true,
            "order": [[1, "asc"]],
            "columnDefs": [
                {
                    "targets" : [7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                    "visible" : false,
                    "searchable": true
                }
            ]
        });
    });
</script>
<?= $this->Html->css("//cdn.datatables.net/1.10.5/css/jquery.dataTables.min.css") ?>
<?= $this->Html->script("//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js") ?>
<?= $this->Html->css('lostandfound/lostandfound')?>

<div class="row">
    <div class="span-one-third">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/add")?>" class="btn success large"><?=__("Add new item")?></a>
    </div>
    <div class="span-one-third">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/found")?>" class="btn large"><?=__("Go to Found section")?></a>
    </div>
    <div class="span-one-third">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/resolved")?>" class="btn large"><?=__("Go to Resolved section")?></a>
    </div>
</div>
<hr />

<div class="content">
    <ul class="tabs" data-tabs="tabs">
        <li id="lostTab" class="active"><a href="#lostItems" data-toggle="tab"><?=__("Lost items")?></a></li>
        <li id="lostFoundTab"><a href="#lostItemsFound" data-toggle="tab"><?=__("Lost items that are found")?></a></li>
    </ul>
    <div class="tab-content">
        <div id="lostItems" class="tab-pane active">
            <table id="lostItemsTable" class="display cell-border hover stripe">
                <thead>
                <tr>
                    <td><?=__("Category")?></td>
                    <td><?=__("Description")?></td>
                    <td><?=__("Info")?></td>
                    <td><?=__("Edit")?></td>
                    <td><?=__("Delete")?></td>
                    <td><?=__("Found")?></td>
                    <td>Storage place</td>
                    <td>Last seen date</td>
                    <td>Last seen where</td>
                    <td>Lost by</td>
                    <td>Lost registered date</td>
                    <td>Lost registered logged in user</td>
                    <td>Lost registered by</td>
                    <td>Found by</td>
                    <td>Found date</td>
                    <td>Found logged in user</td>
                    <td>Found registered by</td>
                    <td>Resolved date</td>
                    <td>Resolved logged in user</td>
                    <td>Resolved registered by</td>
                    <td>Resolved delivered by</td>
                    <td>Resolved description</td>
                </tr>
                </thead>
                <tbody>
                <? foreach($lostItems as $lostItem) { ?>
                    <? if($lostItem["LostItem"]["found_date"] != "0000-00-00 00:00:00") { continue; } ?>

                    <? $id = $lostItem["LostItem"]["id"] ?>
                    <tr>
                        <td><?= $lostItem["LostAndFoundCategory"]["name"] ?></td>
                        <td><?= $lostItem["LostItem"]["description"] ?></td>
                        <td><a href="lost_info/<?= $id ?>"><?= __("Info") ?></a></td>
                        <td><a href="lost_edit/<?= $id ?>"><?= __("Edit") ?></a></td>
                        <td><a href="lost_delete/<?= $id ?>"><?= __("Delete") ?></a></td>
                        <td><a href="lost_found/<?= $id ?>"><?=__("Set as found")?></a></td>
                        <td><?= $lostItem["LostAndFoundStoragePlace"]["name"] ?></td>
                        <td><?= $lostItem["LostItem"]["last_seen_date"] ?></td>
                        <td><?= $lostItem["LostItem"]["last_seen_where"] ?></td>
                        <td><?= $lostItem["LostItem"]["lost_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["lost_registered_date"] ?></td>
                        <td><?= $lostItem["LostItem"]["lost_registered_logged_in_user"] ?></td>
                        <td><?= $lostItem["LostItem"]["lost_registered_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["found_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["found_date"] ?></td>
                        <td><?= $lostItem["LostItem"]["found_logged_in_user"] ?></td>
                        <td><?= $lostItem["LostItem"]["found_registered_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["resolved_date"] ?></td>
                        <td><?= $lostItem["LostItem"]["resolved_logged_in_user"] ?></td>
                        <td><?= $lostItem["LostItem"]["resolved_registered_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["resolved_delivered_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["resolved_description"] ?></td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        </div>
        <div id="lostItemsFound" class="tab-pane">
            <table id="foundItemsTable" class="display cell-border hover stripe">
                <thead>
                <tr>
                    <td><?=__("Category")?></td>
                    <td><?=__("Storage place")?></td>
                    <td><?=__("Description")?></td>
                    <td><?=__("Info")?></td>
                    <td><?=__("Edit")?></td>
                    <td><?=__("Delete")?></td>
                    <td><?=__("Resolve")?></td>
                    <td>Last seen date</td>
                    <td>Last seen where</td>
                    <td>Lost by</td>
                    <td>Lost registered date</td>
                    <td>Lost registered logged in user</td>
                    <td>Lost registered by</td>
                    <td>Found by</td>
                    <td>Found date</td>
                    <td>Found logged in user</td>
                    <td>Found registered by</td>
                    <td>Resolved date</td>
                    <td>Resolved logged in user</td>
                    <td>Resolved registered by</td>
                    <td>Resolved delivered by</td>
                    <td>Resolved description</td>
                </tr>
                </thead>
                <tbody>
                <? foreach($lostItems as $lostItem) { ?>
                    <? if($lostItem["LostItem"]["found_date"] == "0000-00-00 00:00:00" || $lostItem["LostItem"]["resolved"]) { continue; } ?>
                    <? $id = $lostItem["LostItem"]["id"] ?>
                    <tr>
                        <td><?= $lostItem["LostAndFoundCategory"]["name"] ?></td>
                        <td><?= $lostItem["LostAndFoundStoragePlace"]["name"]?></td>
                        <td><?= $lostItem["LostItem"]["description"] ?></td>
                        <td><a href="lost_info/<?= $id ?>"><?= __("Info") ?></a></td>
                        <td><a href="lost_edit/<?= $id ?>"><?= __("Edit") ?></a></td>
                        <td><a href="lost_delete/<?= $id ?>"><?= __("Delete") ?></a></td>
                        <td><a href="lost_resolve/<?= $id ?>"><?=__("Set as resolved")?></a></td>
                        <td><?= $lostItem["LostItem"]["last_seen_date"] ?></td>
                        <td><?= $lostItem["LostItem"]["last_seen_where"] ?></td>
                        <td><?= $lostItem["LostItem"]["lost_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["lost_registered_date"] ?></td>
                        <td><?= $lostItem["LostItem"]["lost_registered_logged_in_user"] ?></td>
                        <td><?= $lostItem["LostItem"]["lost_registered_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["found_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["found_date"] ?></td>
                        <td><?= $lostItem["LostItem"]["found_logged_in_user"] ?></td>
                        <td><?= $lostItem["LostItem"]["found_registered_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["resolved_date"] ?></td>
                        <td><?= $lostItem["LostItem"]["resolved_logged_in_user"] ?></td>
                        <td><?= $lostItem["LostItem"]["resolved_registered_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["resolved_delivered_by"] ?></td>
                        <td><?= $lostItem["LostItem"]["resolved_description"] ?></td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $("#lostItemsTable").dataTable({
            "saveState": true,
            "order": [[1, "asc"]],
            "columnDefs": [
                {
                    "targets" : [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
                    "visible" : false,
                    "searchable": true
                }
            ]
        });

        $("#foundItemsTable").dataTable({
            "saveState": true,
            "order": [[1, "asc"]],
            "columnDefs": [
                {
                    "targets" : [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
                    "visible" : false,
                    "searchable": true
                }
            ]
        });
    });
</script>
<?=$this->Html->script('lostandfound/lost.js')?>
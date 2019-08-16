<? foreach($places as $place) { ?>
    <tr>
        <td> <?= $place['LostAndFoundStoragePlace']['name'] ?> </td>
        <? if($place['LostAndFoundStoragePlace']['active']) { ?>
            <td>
                <a class="setStoragePlaceActive" data-storage-place-id="<?= $place['LostAndFoundStoragePlace']['id'] ?>"><?=__("Set inactive")?></a>
            </td>
        <? } else { ?>
            <td>
                <a class="setStoragePlaceInactive" class="btn success" data-storage-place-id="<?= $place['LostAndFoundStoragePlace']['id'] ?>"><?=__("Set active") ?></a>
            </td>
        <? } ?>
    </tr>
<? } ?>
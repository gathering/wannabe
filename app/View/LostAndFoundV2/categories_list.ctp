<? foreach($categories as $category) { ?>
    <tr>
        <td> <?= $category['LostAndFoundCategory']['name'] ?> </td>
        <? if($category['LostAndFoundCategory']['active']) { ?>
            <td>
                <a class="setCategoryActive" data-category-id="<?= $category['LostAndFoundCategory']['id'] ?>"><?=__("Set inactive")?></a>
            </td>
        <? } else { ?>
            <td>
                <a class="setCategoryInactive" class="btn success" data-category-id="<?= $category['LostAndFoundCategory']['id'] ?>"><?=__("Set active") ?></a>
            </td>
        <? } ?>
    </tr>
<? } ?>
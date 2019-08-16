<script>
    $(function () {
        $('.tabs').tabs();
        $("table").tablesorter({ sortList: [[0,1]] });
    })
</script>
<div class="row">
    <div class="span16">
        <table class="bordered-table">
            <thead>
                <tr>
                    <th><?=__("Description of item")?></th>
                    <th><?=__("Current number of users")?></th>
                </tr>
            </thead>
        <? foreach($cards_overview as $wardrobe => $count) { ?>
            <tr>
                <td><?=$wardrobe?></td>
                <td><?=$count?></td>
            </tr>
        <? } ?>
        </table>
    </div>
</div>

<hr />

<div class="content">
    <ul class="tabs" data-tabs="tabs">
        <li id="availableTab" class="active"><a href="#availableTabContent" data-toggle="tab"><?=__("Available items") ?></a></li>
        <li id="unavailableTab"><a href="#unavailableTabContent" data-toggle="tab"><?=__("Items in use") ?></a></li>
    </ul>
    <div class="tab-content">
        <div id="availableTabContent" class="tab-pane active">
            <? if(sizeof($cards_not_in_use) == 0) { ?>
                <p><?=__("There are currently no available items")?></p>
            <? } else { ?>
                <table class="zebra-striped bordered-table">
                    <thead>
                    <tr>
                        <th><?=__("Description of item")?></th>
                        <th><?=__("Serialnumber")?></th>
                        <th><?=__("Action")?></th>
                    <tr>
                    </thead>

                    <? foreach($cards_not_in_use as $card) { ?>
                        <tr>
                            <td> <?= $card['WardrobeCard']['wardrobe'] ?> </td>
                            <td> <?= $card['WardrobeCard']['card'] ?> </td>
                            <td> <a href="<?=$this->Wb->eventUrl("/WardrobeCard/handout/{$card['WardrobeCard']['id']}")?>" class="btn success"><?=__("Hand out")?></a></td>
                        </tr>
                    <? } ?>
                </table>
            <? } ?>
        </div>
        <div id="unavailableTabContent" class="tab-pane">
            <? if(sizeof($cards_in_use) == 0) { ?>
                <p><?=__("There are currently no items being used")?></p>
            <? } else { ?>
                <table class="zebra-striped bordered-table">
                    <thead>
                    <tr>
                        <th><?=__("Description of item")?></th>
                        <th><?=__("Serialnumber")?></th>
                        <th><?=__("Action")?></th>
                    <tr>
                    </thead>

                    <? foreach($cards_in_use as $card) { ?>
                        <tr>
                            <td> <?= $card['WardrobeCard']['wardrobe'] ?> </td>
                            <td> <?= $card['WardrobeCard']['card'] ?> </td>
                            <td> <a href="<?=$this->Wb->eventUrl("/WardrobeCard/handin/{$card['WardrobeCard']['id']}")?>" class="btn success"><?=__("Hand in")?></a></td>
                        </tr>
                    <? } ?>
                </table>
            <? } ?>
        </div>
    </div>
</div>
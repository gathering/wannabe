<?=$this->Html->css('lostandfound/lostandfound')?>

<?
$lost_category_id_error             = $this->Form->error('LostItem.category_id');
$lost_description_error             = $this->Form->error('LostItem.description');
$lost_last_seen_when_error          = $this->Form->error('LostItem.last_seen_date');
$lost_last_seen_where_error         = $this->Form->error('LostItem.last_seen_where');
$lost_lost_by_error                 = $this->Form->error('LostItem.lost_by');
$lost_registered_by_error           = $this->Form->error("LostItem.lost_registered_by");
$lost_found_by_error                = $this->Form->error("LostItem.found_by");
$lost_storage_place_error           = $this->Form->error("LostItem.storage_place_id");
$lost_resolved_description          = $this->Form->error("LostItem.resolved_description");
?>

<div class="lost">
    <form method="post">
        <fieldset>
            <legend><?= __("Edit lost item") ?></legend>

            <input type="hidden" name="data[LostItem][id]" value="<?=$lostItem["LostItem"]["id"]?>" />

            <h4 class="rowspace"><?=__("Information about item that was lost")?></h4>
            <div class="help-inline"><?=__("General information about the item that was reported lost.")?></div>
            <div class="help-inline"><?=__("Be as descriptive as possible.")?></div>

            <!-- CATEGORY -->
            <div class="clearfix <? if($lost_category_id_error) echo "error" ?>">
                <label for="lostCategory"><?__("Item category")?></label>
                <div class="input">
                    <select name="data[LostItem][category_id]" id="lostCategory">
                        <? foreach($categories as $category) { ?>
                            <option
                                value="<?= $category["LostAndFoundCategory"]["id"] ?>"
                                <? if($category["LostAndFoundCategory"]["id"] == $lostItem["LostItem"]["category_id"]) echo "selected='selected'" ?>>
                                <?= $category["LostAndFoundCategory"]["name"] ?>
                            </option>
                        <? } ?>
                    </select>
                    <span class="help-block"><?=$lost_category_id_error?></span>
                </div>
            </div>

            <!-- DESCRIPTION -->
            <div class="clearfix <? if($lost_description_error) echo "error" ?>">
                <label for="data[LostItem][description]"><?=__("Description of item that was lost")?>*</label>
                <div class="input">
                    <?=$this->Form->input('LostItem.description', array('value' => $lostItem["LostItem"]["description"] ,'div' => false, 'error' => false, 'label' => false))?>
                    <span class="help-block"><?=$lost_description_error?></span>
                </div>
            </div>

            <!-- LAST SEEN WHERE -->
            <div class="clearfix <? if($lost_last_seen_where_error) echo "error" ?>">
                <label for="data[LostItem][last_seen_where]"><?=__("Where was the item last seen?")?></label>
                <div class="input">
                    <?=$this->Form->input('LostItem.last_seen_where', array('value' => $lostItem["LostItem"]["last_seen_where"],'div' => false, 'error' => false, 'label' => false))?>
                    <span class="help-block"><?=$lost_last_seen_where_error?></span>
                </div>
            </div>

            <!-- LAST SEEN WHEN -->
            <div class="row">
                <div class="span8">
                    <div class="clearfix <? if($lost_last_seen_when_error) echo "error" ?>">
                        <label for="data[LostItem][last_seen_date]"><?=__("When was the item last seen?")?></label>
                        <div class="input">
                            <?=$this->Form->input('LostItem.last_seen_date', array('selected' => $lostItem["LostItem"]["last_seen_date"],'div' => false, 'error' => false, 'label' => false, 'class' => 'span2'))?>
                            <span class="help-block"><?=$lost_last_seen_when_error?></span>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>

            <h4 class="rowspace"><?=__("Information about person who reported item missing")?></h4>
            <div class="help-inline"><?=__("Information about the person who came to Info:Desk and reported an item missing.")?></div>
            <div class="help-inline"><?=__("Here you should scan the user's bracelet")?></div>

            <!-- WHO LOST THE ITEM? -->
            <div class="apiUserIdContainer">
                <div class="clearfix <? if($lost_lost_by_error) echo "error" ?>">
                    <label for="data[LostItem][lost_by]"><?=__("Who lost this item?")?></label>
                    <div class="input">
                        <?=$this->Form->input('LostItem.lost_by', array('value' => $lostItem["LostItem"]["lost_by"],'div' => false, 'error' => false, 'label' => false, 'class' => 'apiUserId tryLoadLink'))?>
                        <span class="help-block"><?=$lost_lost_by_error?></span>
                    </div>
                </div>
            </div>

            <hr />
            <h4 class="rowspace"><?=__("Information about person who registered item in Wannabe")?></h4>
            <div class="help-inline"><?=__("Information about the person in Info:Desk who registered the item as lost.")?></div>

            <!-- WHO IS LOGGED IN TO WANNABE? -->
            <div class="clearfix">
                <label for="lostLoggedInAs"><?=__("User who was logged in when item was registered")?></label>
                <div class="input">
                    <input id="lostLoggedInAs" readonly="readonly" value="<?=$lostItem["LostItem"]["lost_registered_logged_in_user"]?>">
                </div>
            </div>

            <!-- MANUAL WANNABE USER ID -->
            <div class="clearfix">
                <label for="lostRegisteredBy"><?=__("Item was registered in Wannabe by")?></label>
                <div class="input">
                    <input value="<?=$lostItem["LostItem"]["lost_registered_by"]?>" id="lostRegisteredBy" disabled/>
                </div>
            </div>

            <div class="clearfix ">
                <label for="lostRegisteredWhen"><?=__("When the item was registered")?></label>
                <div class="input">
                    <input id="lostRegisteredWhen" readonly="readonly" value="<?=$lostItem["LostItem"]["lost_registered_date"]?>">
                </div>
            </div>

        <? if($lostItem["LostItem"]["found_registered_by"] != null) { ?>

            <hr />
            <h4 class="rowspace"><?=__("Information about person who found this item")?></h4>

            <div class="apiUserIdContainer">
                <div class="clearfix <? if($lost_found_by_error) echo "error" ?>">
                    <div class="help-inline"><?=__("The person who found the item and delivered it to a crew member or Info:Desk")?></div>
                    <label for="data[LostItem][found_by]"><?=__("Who found this item?")?></label>
                    <div class="input">
                        <?=$this->Form->input('LostItem.found_by', array('value' => $lostItem["LostItem"]["found_by"],'div' => false, 'error' => false, 'label' => false, 'class' => 'apiUserId tryLoadLink'))?>
                        <span class="help-block"><?=$lost_found_by_error?></span>
                    </div>
                </div>
            </div>

            <hr />
            <h4 class="rowspace"><?=__("Information about where the item is being stored")?></h4>

            <div class="clearfix <? if($lost_storage_place_error) echo "error" ?>">
                <label for="lostStoragePlace"><?=__("Storage place")?></label>
                <div class="input">
                    <select name="data[LostItem][storage_place_id]" id="lostStoragePlace">
                        <? foreach($storagePlaces as $storagePlace) { ?>
                            <option
                                value="<?= $storagePlace["LostAndFoundStoragePlace"]["id"] ?>"
                                <? if($storagePlace["LostAndFoundStoragePlace"]["id"] == $lostItem["LostItem"]["storage_place_id"]) echo "selected='selected'" ?>>
                                <?= $storagePlace["LostAndFoundStoragePlace"]["name"] ?>
                            </option>
                        <? } ?>
                    </select>
                    <span class="help-block"><?=$lost_storage_place_error?></span>
                </div>
            </div>

            <hr />
            <h4 class="rowspace"><?=__("Information about person who registered this item as found in Wannabe")?></h4>

            <div class="clearfix">
                <label for="foundLoggedInUser"><?=__("User who was logged in when item was registered as found")?></label>
                <div class="input">
                    <input id="foundLoggedInUser" readonly="readonly" value="<?=$lostItem["LostItem"]["found_logged_in_user"]?>">
                </div>
            </div>

            <!-- MANUAL WANNABE USER ID -->
            <div class="clearfix">
                <label for="foundRegisteredBy"><?=__("Item was registered as found in Wannabe by")?></label>
                <div class="input">
                    <input value="<?=$lostItem["LostItem"]["found_registered_by"]?>" id="foundRegisteredBy" disabled/>
                </div>
            </div>

            <div class="clearfix">
                <label for="foundRegisteredWhen"><?=__("When the item was registered as found")?></label>
                <div class="input">
                    <input id="foundRegisteredWhen" readonly="readonly" value="<?=$lostItem["LostItem"]["found_date"]?>">
                </div>
            </div>

        <? } ?>

        <? if($lostItem["LostItem"]["resolved"]) { ?>

            <hr />
            <h4 class="rowspace"><?=__("Information about person who registered this item as resolved in Wannabe")?></h4>

            <div class="clearfix">
                <label for="resolvedLoggedInUser"><?=__("User who was logged in when item was registered as resolved")?></label>
                <div class="input">
                    <input id="resolvedLoggedInUser" readonly="readonly" value="<?=$lostItem["LostItem"]["resolved_logged_in_user"]?>">
                </div>
            </div>

            <!-- MANUAL WANNABE USER ID -->
            <div class="clearfix">
                <label for="resolvedRegisteredBy"><?=__("Item was registered as resolved in Wannabe by")?></label>
                <div class="input">
                    <input value="<?=$lostItem["LostItem"]["resolved_registered_by"]?>" id="resolvedRegisteredBy" disabled/>
                </div>
            </div>

            <div class="clearfix">
                <label for="resolvedWhen"><?=__("When the item was registered as resolved")?></label>
                <div class="input">
                    <input id="resolvedWhen" readonly="readonly" value="<?=$lostItem["LostItem"]["resolved_date"]?>">
                </div>
            </div>

            <div class="clearfix">
                <label for="resolvedDeliveredBy"><?=__("Who delivered the item back to the user?")?></label>
                <div class="input">
                    <input id="resolvedDeliveredBy" readonly="readonly" value="<?=$lostItem["LostItem"]["resolved_delivered_by"]?>">
                </div>
            </div>

            <div class="clearfix <? if($lost_resolved_description) echo "error" ?>">
                <label for="data[LostItem][resolved_description]"><?=__("Description of delivery process?")?></label>
                <div class="input">
                    <?=$this->Form->input('LostItem.resolved_description', array('value' => $lostItem["LostItem"]["resolved_description"],'div' => false, 'error' => false, 'label' => false))?>
                    <span class="help-block"><?=$lost_resolved_description?></span>
                </div>
            </div>
        <? } ?>

        </fieldset>
        <div class="actions">
            <?=$this->Form->submit(__("Save"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
            <a href="<?=$this->Wb->eventUrl('/LostAndFoundV2/lost')?>" class="btn"><?=__("Back to Lost section")?></a>
        </div>
    </form>
</div>
<?=$this->Html->script('geekevents/userapi.js')?>
<?=$this->Html->script('geekevents/tryloadlink.js')?>
<?=$this->Html->css('lostandfound/lostandfound')?>

<?

$found_category_id_error            = $this->Form->error("FoundItem.category_id");
$found_description_error            = $this->Form->error("FoundItem.description");
$found_storage_place_error          = $this->Form->error("FoundItem.storage_place_id");
$found_by_error                     = $this->Form->error("FoundItem.found_by");
$found_date_error                   = $this->Form->error("FoundItem.found_date");
$found_resolved_date_error          = $this->Form->error("FoundItem.resolved_date");
$found_resolved_description_error   = $this->Form->error("FoundItem.resolved_description");
$found_resolved_delivered_by_error  = $this->Form->error("FoundItem.resolved_delivered_by");
$found_resolved_delivered_to_error  = $this->Form->error("FoundItem.resolved_delivered_to");

?>

<form method="post">
    <fieldset>
        <legend><?= __("Edit found item") ?></legend>
        <input type="hidden" name="data[FoundItem][id]" value="<?=$foundItem["FoundItem"]["id"]?>" />

        <h4 class="rowspace"><?=__("Information about object")?></h4>
        <div class="help-inline"><?=__("General information about the item that was reported found.")?></div>
        <div class="help-inline"><?=__("Be as descriptive as possible.")?></div>

        <!-- CATEGORY -->
        <div class="clearfix <? if($found_category_id_error) echo "error" ?>">
            <label for="foundCategory"><?=__("Category") ?></label>
            <div class="input">
                <select name="data[FoundItem][category_id]" id="foundCategory">
                    <option value=""></option>
                    <? foreach($categories as $category) { ?>
                        <option
                            value="<?= $category["LostAndFoundCategory"]["id"] ?>"
                            <? if($foundItem["FoundItem"]["category_id"] == $category["LostAndFoundCategory"]["id"]) echo "selected='selected'" ?>>
                            <?= $category["LostAndFoundCategory"]["name"] ?>
                        </option>
                    <? } ?>
                </select>
                <span class="help-block"><?=$found_category_id_error?></span>
            </div>
        </div>
        <!-- DESCRIPTION -->
        <div class="clearfix <? if($found_description_error) echo "error" ?>">
            <label for="data[FoundItem][description]"><?=__("Description of item")?></label>
            <div class="input">
                <?=$this->Form->input('FoundItem.description', array('value' => $foundItem["FoundItem"]["description"], 'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$found_description_error?></span>
            </div>
        </div>

        <div class="row">
            <div class="span8">
                <div class="clearfix <? if($found_date_error) echo "error" ?>">
                    <label for="data[FoundItem][found_date]"><?=__("When was the item found?")?></label>
                    <div class="input">
                        <?=$this->Form->input('FoundItem.found_date', array('selected' => $foundItem["FoundItem"]["found_date"],'div' => false, 'error' => false, 'label' => false, 'class' => 'span2'))?>
                        <span class="help-block"><?=$found_date_error?></span>
                    </div>
                </div>
            </div>
        </div>

        <hr />
        <h4 class="rowspace"><?=__("Information about where the item is being stored")?></h4>
        <!-- STORAGE -->
        <div class="clearfix <? if($found_storage_place_error) echo "error" ?>">
            <label for="data[FoundItem][storage_place_id]"><?=__("Storage place")?></label>
            <div class="input">
                <select name="data[FoundItem][storage_place_id]" id="storagePlace">
                    <option value=""></option>
                    <? foreach($storagePlaces as $storagePlace) { ?>
                        <option
                            value="<?= $storagePlace["LostAndFoundStoragePlace"]["id"] ?>"
                            <? if($foundItem["FoundItem"]["storage_place_id"] == $storagePlace["LostAndFoundStoragePlace"]["id"]) echo "selected='selected'" ?>>
                            <?= $storagePlace["LostAndFoundStoragePlace"]["name"] ?>
                        </option>
                    <? } ?>
                </select>
                <span class="help-block"><?=$found_storage_place_error?></span>
            </div>
        </div>

        <hr/>
        <h4 class="rowspace"><?=__("Information about person who reported item missing")?></h4>
        <div class="help-inline"><?=__("Information about the person who came to Info:Desk and reported an item found.")?></div>
        <div class="help-inline"><?=__("Here you should scan the user's bracelet")?></div>

        <!-- WHO LOST THE ITEM? -->
        <div class="apiUserIdContainer">
            <div class="clearfix <? if($found_by_error) echo "error" ?>">
                <label for="data[FoundItem][found_by]"><?=__("Who found this item?")?></label>
                <div class="input">
                    <?=$this->Form->input('FoundItem.found_by', array('value' => $foundItem["FoundItem"]["found_by"], 'div' => false, 'error' => false, 'label' => false, 'class' => 'apiUserId tryLoadLink'))?>
                    <span class="help-block"><?=$found_by_error?></span>
                </div>
            </div>
        </div>

        <hr />
        <h4 class="rowspace"><?=__("Information about person who registered item in Wannabe")?></h4>
        <div class="help-inline"><?=__("Information about the person in crew who registered the item as found.")?></div>

        <!-- WHO IS LOGGED IN TO WANNABE? -->
        <div class="clearfix">
            <label for="foundLoggedInAs"><?=__("User who was logged in when item was registered")?></label>
            <div class="input">
                <input id="foundLoggedInAs" readonly="readonly" value="<?=$foundItem["FoundItem"]["found_logged_in_user"]?>">
            </div>
        </div>

        <!-- MANUAL WANNABE USER ID -->
        <div class="clearfix differentUserWrapper">
            <label for="foundRegisteredBy"><?=__("Item was registered in Wannabe by")?></label>
            <div class="input">
                <input id="foundRegisteredBy" value="<?= $foundItem["FoundItem"]["found_registered_by"]?>" disabled>
            </div>
        </div>

    <? if($foundItem["FoundItem"]["resolved"])  { ?>

        <hr />
        <h4 class="rowspace"><?=__("Information about the delivery process")?></h4>

        <div class="clearfix <? if($found_resolved_description_error) echo "error" ?>">
            <label for="data[FoundItem][resolved_description]"><?=__("Description of delivery process?")?></label>
            <div class="input">
                <?=$this->Form->input('FoundItem.resolved_description', array('value' => $foundItem["FoundItem"]["resolved_description"],'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$found_resolved_description_error?></span>
            </div>
        </div>

        <div class="clearfix <? if($found_resolved_delivered_by_error) echo "error" ?>">
            <label for="resolvedDeliveredBy"><?=__("Who delivered the item back to the user?")?></label>
            <div class="input">
                <?=$this->Form->input('FoundItem.resolved_delivered_by', array('value' => $foundItem["FoundItem"]["resolved_delivered_by"],'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$found_resolved_delivered_by_error?></span>
            </div>
        </div>

        <div class="apiUserIdContainer">
            <div class="clearfix <? if($found_resolved_delivered_to_error) echo "error" ?>">
                <label for="data[FoundItem][resolved_delivered_to]"><?=__("Who was the item delivered to?")?></label>
                <div class="input">
                    <?=$this->Form->input('FoundItem.resolved_delivered_to', array('value' => $foundItem["FoundItem"]["resolved_delivered_to"],'div' => false, 'error' => false, 'label' => false, 'class' => 'apiUserId tryLoadLink'))?>
                    <span class="help-block"><?=$found_resolved_delivered_to_error?></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="span8">
                <div class="clearfix <? if($found_resolved_date_error) echo "error" ?>">
                    <label for="data[FoundItem][resolved_date]"><?=__("When was the item resolved?")?></label>
                    <div class="input">
                        <?=$this->Form->input('FoundItem.resolved_date', array('selected' => $foundItem["FoundItem"]["resolved_date"],'div' => false, 'error' => false, 'label' => false, 'class' => 'span2'))?>
                        <span class="help-block"><?=$found_resolved_date_error?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix <? if($found_resolved_description_error) echo "error" ?>">
            <label for="data[FoundItem][resolved_description]"><?=__("Description of delivery process?")?></label>
            <div class="input">
                <?=$this->Form->input('FoundItem.resolved_description', array('value' => $foundItem["FoundItem"]["resolved_description"],'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$found_resolved_description_error?></span>
            </div>
        </div>

        <div class="clearfix">
            <label for="resolvedLoggedInUser"><?=__("User who was logged in when item was registered")?></label>
            <div class="input">
                <input id="resolvedLoggedInUser" value="<?= $foundItem["FoundItem"]["resolved_logged_in_user"]?>" disabled>
            </div>
        </div>

        <div class="clearfix">
            <label for="foundRegisteredBy"><?=__("Item was registered in Wannabe by")?></label>
            <div class="input">
                <input id="foundRegisteredBy" value="<?= $foundItem["FoundItem"]["found_registered_by"]?>" disabled>
            </div>
        </div>

    <? } ?>

    </fieldset>
    <div class="actions">
        <?=$this->Form->submit(__("Save"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
        <a href="<?=$this->Wb->eventUrl('/LostAndFoundV2/found')?>" class="btn"><?=__("Back to Found section")?></a>
    </div>
</form>
<?=$this->Html->script('geekevents/userapi.js')?>
<?=$this->Html->script('geekevents/tryloadlink.js')?>
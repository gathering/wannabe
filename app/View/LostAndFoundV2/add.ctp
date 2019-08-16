<?=$this->Html->css('lostandfound/lostandfound')?>

<?
    $selectedType = isset($selectedType) ? $selectedType : "";
?>

<div class="row">
    <div class="span16">
        <form class="form-stacked">
            <div class="clearfix">
                <label for="selectType"><?=__("Select type")?></label>
                <select id="selectType">
                    <option <? if($selectedType == "") echo "selected='selected'" ?>></option>
                    <option <? if($selectedType == "lost") echo "selected='selected'" ?> value="lost"><?=__("Lost")?></option>
                    <option <? if($selectedType == "found") echo "selected='selected'" ?> value="found"><?=__("Found")?></option>
                </select>
            </div>
        </form>
    </div>
</div>

<hr/>

<div class="add-content-wrapper">
    <?
    $lost_category_id_error     = $this->Form->error('LostItem.category_id');
    $lost_description_error     = $this->Form->error('LostItem.description');
    $lost_last_seen_when_error  = $this->Form->error('LostItem.last_seen_date');
    $lost_last_seen_where_error = $this->Form->error('LostItem.last_seen_where');
    $lost_lost_by_error         = $this->Form->error('LostItem.lost_by');
    $lost_registered_by_error   = $this->Form->error("LostItem.lost_registered_by");
    $found_category_id_error    = $this->Form->error("FoundItem.category_id");
    $found_description_error    = $this->Form->error("FoundItem.description");
    $found_storage_place_error  = $this->Form->error("FoundItem.storage_place_id");
    $found_by_error             = $this->Form->error("FoundItem.found_by");
    $found_date_error           = $this->Form->error("FoundItem.found_date");
    $found_logged_in_user_error = $this->Form->error("FoundItem.found_logged_in_user");
    $found_registered_by_error  = $this->Form->error("FoundItem.found_registered_by");
    $selectedCategory           = isset($selectedCategory) ? $selectedCategory : null;
    $selectedStoragePlace       = isset($selectedStoragePlace) ? $selectedStoragePlace : null;
    $differentUser              = isset($differentUser) ? $differentUser : false;
    ?>

    <div class="lost hidden">
        <form method="post" action="add">
            <fieldset>
                <legend><?= __("Register new lost item") ?></legend>

                <input type="hidden" name="data[SelectedType]" value="lost" />
                <h4 class="rowspace"><?=__("Information about item that was lost")?></h4>
                <div class="help-inline"><?=__("General information about the item that was reported lost.")?></div>
                <div class="help-inline"><?=__("Be as descriptive as possible.")?></div>

                <!-- CATEGORY -->
                <div class="clearfix <? if($lost_category_id_error) echo "error" ?>">
                    <label for="lostCategory"><?=__("Item category")?></label>
                    <div class="input">
                        <select name="data[LostItem][category_id]" id="lostCategory">
                            <option value=""></option>
                            <? foreach($categories as $category) { ?>
                                <option
                                    value="<?= $category["LostAndFoundCategory"]["id"] ?>"
                                    <? if($selectedCategory && $selectedCategory == $category["LostAndFoundCategory"]["id"]) echo "selected='selected'" ?>>
                                    <?= $category["LostAndFoundCategory"]["name"] ?>
                                </option>
                            <? } ?>
                        </select>
                        <span class="help-block"><?=$lost_category_id_error?></span>
                    </div>
                </div>

                <!-- DESCRIPTION -->
                <div class="clearfix <? if($lost_description_error) echo "error" ?>">
                    <label for="data[LostItem][description]"><?=__("Description of lost item")?></label>
                    <div class="input">
                        <?=$this->Form->input('LostItem.description', array('div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$lost_description_error?></span>
                    </div>
                </div>

                <!-- LAST SEEN WHERE -->
                <div class="clearfix <? if($lost_last_seen_where_error) echo "error" ?>">
                    <label for="data[LostItem][last_seen_where]"><?=__("Where was the item last seen?")?></label>
                    <div class="input">
                        <?=$this->Form->input('LostItem.last_seen_where', array('div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$lost_last_seen_where_error?></span>
                    </div>
                </div>

                <!-- LAST SEEN WHEN -->
                <div class="row">
                    <div class="span8">
                        <div class="clearfix <? if($lost_last_seen_when_error) echo "error" ?>">
                            <label for="data[LostItem][last_seen_date]"><?=__("When was the item last seen?")?></label>
                            <div class="input">
                                <?=$this->Form->input('LostItem.last_seen_date', array('div' => false, 'error' => false, 'label' => false, 'class' => 'span2'))?>
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
                            <?=$this->Form->input('LostItem.lost_by', array('div' => false, 'error' => false, 'label' => false, 'class' => 'apiUserId tryLoadLink'))?>
                            <span class="help-block"><?=$lost_lost_by_error?></span>
                        </div>
                    </div>
                </div>

                <hr />
                <h4 class="rowspace"><?=__("Information about person who registered item in Wannabe")?></h4>
                <div class="help-inline"><?=__("Information about the person in crew who registered the item as lost.")?></div>

                <!-- WHO IS LOGGED IN TO WANNABE? -->
                <div class="clearfix">
                    <label for="lostLoggedInAs"><?=__("Currently logged in user")?></label>
                    <div class="input">
                        <input id="lostLoggedInAs" readonly="readonly" value="<?=$wannabe->user["User"]["id"]?>">
                        <span><input value="<?=$wannabe->user["User"]["realname"]?>" readonly="readonly"/></span>
                    </div>
                </div>

                <!-- IS IT A DIFFERENT USER THAN THE ONE LOGGED IN? -->
                <div class="clearfix">
                    <label for="lostDifferentUser"><?=__("I am not this user")?></label>
                    <div class="input">
                        <input id="lostDifferentUser" name="data[DifferentUser]" type="checkbox" <? if($differentUser) echo "checked" ?>/>
                    </div>
                </div>

                <!-- MANUAL WANNABE USER ID -->
                <div class="clearfix differentUserWrapper hidden <? if($lost_registered_by_error) echo "error" ?>">
                    <label for="data[LostItem][lost_registered_by]"><?=__("Your Wannabe user ID?")?></label>
                    <div class="input">
                        <?=$this->Form->input('LostItem.lost_registered_by', array('div' => false, 'error' => false, 'label' => false, 'disabled' => 'disabled', 'placeholder' => "Wannabe user Id"))?>
                        <span class="help-block"><?=$lost_registered_by_error?></span>
                    </div>
                </div>

            </fieldset>
            <div class="actions">
                <?=$this->Form->submit(__("Register item as lost"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
                <a href="<?=$this->Wb->eventUrl('/LostAndFoundV2/lost')?>" class="btn"><?=__("Back to lost")?></a>
            </div>
        </form>
    </div>
    <div class="found hidden">
        <form method="post" action="add">
            <fieldset>
                <legend><?= __("Register new found item") ?></legend>

                <input type="hidden" name="data[SelectedType]" value="found" />
                <h4 class="rowspace"><?=__("Information about item that was found")?></h4>
                <div class="help-inline"><?=__("General information about the item that was reported found.")?></div>
                <div class="help-inline"><?=__("Be as descriptive as possible.")?></div>

                <!-- CATEGORY -->
                <div class="clearfix <? if($found_category_id_error) echo "error" ?>">
                    <label for="foundCategory"><?=__("Item category") ?></label>
                    <div class="input">
                        <select name="data[FoundItem][category_id]" id="foundCategory">
                            <option value=""></option>
                            <? foreach($categories as $category) { ?>
                                <option
                                    value="<?= $category["LostAndFoundCategory"]["id"] ?>"
                                    <? if($selectedCategory && $selectedCategory == $category["LostAndFoundCategory"]["id"]) echo "selected='selected'" ?>>
                                    <?= $category["LostAndFoundCategory"]["name"] ?>
                                </option>
                            <? } ?>
                        </select>
                        <span class="help-block"><?=$found_category_id_error?></span>
                    </div>
                </div>
                <!-- DESCRIPTION -->
                <div class="clearfix <? if($found_description_error) echo "error" ?>">
                    <label for="data[FoundItem][description]"><?=__("Description of found item")?></label>
                    <div class="input">
                        <?=$this->Form->input('FoundItem.description', array('div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$found_description_error?></span>
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
                                    <? if($selectedStoragePlace && $selectedStoragePlace == $storagePlace["LostAndFoundStoragePlace"]["id"]) echo "selected='selected'" ?>>
                                    <?= $storagePlace["LostAndFoundStoragePlace"]["name"] ?>
                                </option>
                            <? } ?>
                        </select>
                        <span class="help-block"><?=$found_storage_place_error?></span>
                    </div>
                </div>

                <hr/>
                <h4 class="rowspace"><?=__("Information about person who reported item found")?></h4>
                <div class="help-inline"><?=__("Information about the person who came to Info:Desk and reported an item found.")?></div>
                <div class="help-inline"><?=__("Here you should scan the user's bracelet")?></div>

                <!-- WHO LOST THE ITEM? -->
                <div class="apiUserIdContainer">
                    <div class="clearfix <? if($found_by_error) echo "error" ?>">
                        <label for="data[FoundItem][found_by]"><?=__("Who found this item?")?></label>
                        <div class="input">
                            <?=$this->Form->input('FoundItem.found_by', array('div' => false, 'error' => false, 'label' => false, 'class' => 'apiUserId tryLoadLink'))?>
                            <span class="help-block"><?=$found_by_error?></span>
                        </div>
                    </div>
                </div>

                <hr />
                <h4 class="rowspace"><?=__("Information about person who registered item in Wannabe")?></h4>
                <div class="help-inline"><?=__("Information about the person in crew who registered the item as found.")?></div>

                <!-- WHO IS LOGGED IN TO WANNABE? -->
                <div class="clearfix">
                    <label for="foundLoggedInAs"><?=__("Currently logged in user")?></label>
                    <div class="input">
                        <input id="foundLoggedInAs" readonly="readonly" value="<?=$wannabe->user["User"]["id"]?>">
                        <span><input value="<?=$wannabe->user["User"]["realname"]?>" readonly="readonly"/></span>
                    </div>
                </div>

                <!-- IS IT A DIFFERENT USER THAN THE ONE LOGGED IN? -->
                <div class="clearfix">
                    <label for="foundDifferentUser"><?=__("I am not this user")?></label>
                    <div class="input">
                        <input id="foundDifferentUser" name="data[DifferentUser]" type="checkbox" <? if($differentUser) echo "checked" ?>/>
                    </div>
                </div>

                <!-- MANUAL WANNABE USER ID -->
                <div class="clearfix differentUserWrapper hidden <? if($found_registered_by_error) echo "error" ?>">
                    <label for="data[FoundItem][found_registered_by]"><?=__("Your Wannabe user ID?")?></label>
                    <div class="input">
                        <?=$this->Form->input('FoundItem.found_registered_by', array('div' => false, 'error' => false, 'label' => false, 'disabled' => 'disabled', 'placeholder' => 'Wannabe user Id'))?>
                        <span class="help-block"><?=$found_registered_by_error?></span>
                    </div>
                </div>

            </fieldset>
            <div class="actions">
                <?=$this->Form->submit(__("Register item as found"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
                <a href="<?=$this->Wb->eventUrl('/LostAndFoundV2/found')?>" class="btn"><?=__("Back to found")?></a>
            </div>
        </form>
    </div>
</div>

<?=$this->Html->script('lostandfound/add.js')?>
<?=$this->Html->script('geekevents/userapi.js')?>
<?=$this->Html->script('geekevents/tryloadlink.js')?>
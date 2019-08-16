<?=$this->Html->css('lostandfound/lostandfound')?>

<div class="add-content-wrapper">
    <?
    $lost_storage_place_error           = $this->Form->error("LostItem.storage_place_id");
    $lost_found_by_error                = $this->Form->error("LostItem.found_by");
    $lost_found_logged_in_user_error    = $this->Form->error("LostItem.found_logged_in_user");
    $lost_found_registered_by_error     = $this->Form->error("LostItem.found_registered_by");
    $lost_found_date_error              = $this->Form->error("LostItem.found_date");
    $selectedStoragePlace               = isset($selectedStoragePlace) ? $selectedStoragePlace : null;
    $differentUser                      = isset($differentUser) ? $differentUser : false;
    ?>

    <div class="lost">
        <form method="post">
            <fieldset>
                <legend><?= __("Set item as found") ?></legend>
                <input type="hidden" name="data[LostItem][id]" value="<?=$lostItem["LostItem"]["id"]?>" />

                <h4 class="rowspace"><?=__("Information about person who found this item")?></h4>
                <div class="help-inline"><?=__("Information about the person who came to Info:Desk and reported an item found.")?></div>

                <div class="apiUserIdContainer">
                    <div class="clearfix <? if($lost_found_by_error) echo "error" ?>">
                        <label for="data[LostItem][found_by]"><?=__("Who found this item?")?></label>
                        <div class="input">
                            <?=$this->Form->input('LostItem.found_by', array('value' => $lostItem["LostItem"]["found_by"],'div' => false, 'error' => false, 'label' => false, 'class' => 'apiUserId tryLoadLink'))?>
                            <span class="help-block"><?=$lost_found_by_error?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="span8">
                        <div class="clearfix <? if($lost_found_date_error) echo "error" ?>">
                            <label for="data[LostItem][found_date]"><?=__("When was item found?")?></label>
                            <div class="input">
                                <?=$this->Form->input('LostItem.found_date', array('div' => false, 'error' => false, 'label' => false, 'class' => 'span2'))?>
                                <span class="help-block"><?=$lost_found_date_error?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />
                <h4 class="rowspace"><?=__("Information about where the item is being stored")?></h4>

                <div class="clearfix <? if($lost_storage_place_error) echo "error" ?>">
                    <label for="storagePlace"><?=__("Storage place")?></label>
                    <div class="input">
                        <select name="data[LostItem][storage_place_id]" id="storagePlace">
                            <option value=""></option>
                            <? foreach($storagePlaces as $storagePlace) { ?>
                                <option
                                    value="<?= $storagePlace["LostAndFoundStoragePlace"]["id"] ?>"
                                    <? if($selectedStoragePlace && $selectedStoragePlace == $storagePlace["LostAndFoundStoragePlace"]["id"]) echo "selected='selected'" ?>>
                                    <?= $storagePlace["LostAndFoundStoragePlace"]["name"] ?>
                                </option>
                            <? } ?>
                        </select>
                        <span class="help-block"><?=$lost_storage_place_error?></span>
                    </div>
                </div>

                <hr />
                <h4 class="rowspace"><?=__("Information about person who registered this item as found in Wannabe")?></h4>

                <!-- WHO IS LOGGED IN TO WANNABE? -->
                <div class="clearfix">
                    <label for="lostLoggedInAs"><?=__("Logged in user")?></label>
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
                <div class="clearfix differentUserWrapper hidden <? if($lost_found_registered_by_error) echo "error" ?>">
                    <label for="data[LostItem][found_registered_by]"><?=__("Your Wannabe user ID?")?></label>
                    <div class="input">
                        <?=$this->Form->input('LostItem.found_registered_by', array('div' => false, 'error' => false, 'label' => false, 'disabled' => 'disabled'))?>
                        <span class="help-block"><?=$lost_found_registered_by_error?></span>
                    </div>
                </div>
            </fieldset>
            <div class="actions">
                <?=$this->Form->submit(__("Save"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
                <a href="<?=$this->Wb->eventUrl('/LostAndFoundV2/lost')?>" class="btn"><?=__("Back to Lost section")?></a>
            </div>
        </form>
    </div>
</div>

<?=$this->Html->script('lostandfound/add.js')?>
<?=$this->Html->script('geekevents/userapi.js')?>
<?=$this->Html->script('geekevents/tryloadlink.js')?>
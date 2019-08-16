<?=$this->Html->css('lostandfound/lostandfound')?>

<div class="add-content-wrapper">
    <form method="post">
        <fieldset>
            <input type="hidden" name="data[FoundItem][id]" value="<?=$foundItem["FoundItem"]["id"]?>" />
            <h4 class="rowspace"><?=__("Information about item that was found")?></h4>

            <!-- CATEGORY -->
            <div class="clearfix">
                <label for="category"><?=__("Item category")?></label>
                <div class="input">
                    <select disabled>
                        <option id="category"><?= $foundItem["LostAndFoundCategory"]["name"] ?></option>
                    </select>
                </div>
            </div>

            <!-- DESCRIPTION -->
            <div class="clearfix">
                <label for="description"><?=__("Description of item that was found")?></label>
                <div class="input">
                    <textarea id="description" cols="30" rows="6" readonly="readonly"><?=$foundItem["FoundItem"]["description"]?></textarea>
                </div>
            </div>

            <hr />
            <h4 class="rowspace"><?=__("Information about where the item is being stored")?></h4>

            <div class="clearfix">
                <label for="storagePlace"><?=__("Storage place")?></label>
                <div class="input">
                    <select disabled>
                        <option id="storagePlace"><?= $foundItem["LostAndFoundStoragePlace"]["name"] ?></option>
                    </select>
                </div>
            </div>

            <hr/>

            <h4 class="rowspace"><?=__("Information about person who found the item")?></h4>
            <div class="help-inline"><?=__("The person who found the item and delivered it to a crew member or Info:Desk")?></div>
            <!-- WHO FOUND THE ITEM? -->
            <div class="clearfix ">
                <label for="foundBy"><?=__("Person who found the item")?></label>
                <div class="input">
                    <textarea id="foundBy" class="tryLoadLink" cols="30" rows="6" readonly="readonly"><?=$foundItem["FoundItem"]["found_by"]?></textarea>
                </div>
            </div>

            <hr />
            <h4 class="rowspace"><?=__("Information about person who registered item in Wannabe")?></h4>

            <!-- WHO IS LOGGED IN TO WANNABE? -->
            <div class="clearfix ">
                <label for="foundLoggedInAs"><?=__("User who was logged in when the item was registered")?></label>
                <div class="input">
                    <input id="foundLoggedInAs" readonly="readonly" value="<?=$foundItem["FoundItem"]["found_logged_in_user"]?>">
                </div>
            </div>

            <!-- MANUAL WANNABE USER ID -->
            <div class="clearfix ">
                <label for="foundRegisteredBy"><?=__("User who actually registered the item")?></label>
                <div class="input">
                    <input id="foundRegisteredBy" readonly="readonly" value="<?=$foundItem["FoundItem"]["found_registered_by"]?>">
                </div>
            </div>

            <div class="clearfix ">
                <label for="foundRegisteredWhen"><?=__("When the item was registered")?></label>
                <div class="input">
                    <input id="foundRegisteredWhen" readonly="readonly" value="<?=$foundItem["FoundItem"]["found_date"]?>">
                </div>
            </div>

            <hr />

            <? if($foundItem["FoundItem"]["resolved"]) { ?>

                <h4 class="rowspace"><?=__("Information about delivery process")?></h4>
                <div class="help-inline"><?=__("This is a description about how the delivery process took place")?></div>


                <div class="clearfix ">
                    <label for="resolvedDescription"><?=__("Description of the delivery process")?></label>
                    <div class="input">
                        <textarea id="resolvedDescription" readonly="readonly"><?=$foundItem["FoundItem"]["resolved_description"]?></textarea>
                    </div>
                </div>

                <div class="help-inline"><?=__("This should be the user who had lost the item, and got it back.")?></div>
                <div class="clearfix ">
                    <label for="resolvedDeliveredTo"><?=__("Who the item was handed back to")?></label>
                    <div class="input">
                        <textarea id="resolvedDeliveredTo" class="tryLoadLink" readonly="readonly"><?=$foundItem["FoundItem"]["resolved_delivered_to"]?></textarea>
                    </div>
                </div>

                <div class="help-inline"><?=__("The crew member who was responsible for handing the item back to the user.")?></div>
                <div class="clearfix ">
                    <label for="resolvedDeliveredBy"><?=__("Who handed the item back")?></label>
                    <div class="input">
                        <input id="resolvedDeliveredBy" readonly="readonly" value="<?=$foundItem["FoundItem"]["resolved_delivered_by"]?>">
                    </div>
                </div>

                <div class="clearfix ">
                    <label for="resolvedLoggedInAs"><?=__("User who was logged in when the item was registered as resolved")?></label>
                    <div class="input">
                        <input id="resolvedLoggedInAs" readonly="readonly" value="<?=$foundItem["FoundItem"]["resolved_logged_in_user"]?>">
                    </div>
                </div>

                <div class="clearfix ">
                    <label for="resolvedRegisteredBy"><?=__("User who actually registered the item as resolved")?></label>
                    <div class="input">
                        <input id="resolvedRegisteredBy" readonly="readonly" value="<?=$foundItem["FoundItem"]["resolved_registered_by"]?>">
                    </div>
                </div>

                <div class="clearfix ">
                    <label for="resolvedRegisteredWhen"><?=__("When the item was registered resolved")?></label>
                    <div class="input">
                        <input id="resolvedRegisteredWhen" readonly="readonly" value="<?=$foundItem["FoundItem"]["resolved_date"]?>">
                    </div>
                </div>
            <? } ?>

            <div class="actions">
                <?=$this->Form->submit(__("Delete"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?>
                <a href="<?=$this->Wb->eventUrl('/LostAndFoundV2/found')?>" class="btn"><?=__("Back to Found section")?></a>
            </div>
        </fieldset>
    </form>
</div>

<?=$this->Html->script('geekevents/tryloadlink.js')?>
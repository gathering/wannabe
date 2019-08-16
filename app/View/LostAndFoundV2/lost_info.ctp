<?=$this->Html->css('lostandfound/lostandfound')?>

<div class="add-content-wrapper">
    <form>
    <fieldset>
        <h4 class="rowspace"><?=__("Information about object")?></h4>

        <!-- CATEGORY -->
        <div class="clearfix">
            <label for="category"><?=__("Category")?></label>
            <div class="input">
                <select readonly="readonly">
                    <option id="category"><?= $lostItem["LostAndFoundCategory"]["name"] ?></option>
                </select>
            </div>
        </div>

        <!-- DESCRIPTION -->
        <div class="clearfix">
            <label for="description"><?=__("Description of item")?></label>
            <div class="input">
                <textarea id="description" cols="30" rows="6" readonly="readonly"><?=$lostItem["LostItem"]["description"]?></textarea>
            </div>
        </div>

        <!-- LAST SEEN WHERE -->
        <div class="clearfix ">
            <label for="lastSeenWhere"><?=__("Last seen where?")?></label>
            <div class="input">
                <textarea id="lastSeenWhere" cols="30" rows="6" readonly="readonly"><?=$lostItem["LostItem"]["last_seen_where"]?></textarea>
            </div>
        </div>

        <!-- LAST SEEN WHEN -->
        <div class="row">
            <div class="span8">
                <div class="clearfix ">
                    <label for="lastSeenDate"><?=__("Last seen when?")?></label>
                    <div class="input">
                        <input id="lastSeenDate" readonly="readonly" value="<?=$lostItem["LostItem"]["last_seen_date"]?>">
                    </div>
                </div>
            </div>
        </div>

        <hr/>

        <h4 class="rowspace"><?=__("Information about person who reported item missing")?></h4>

        <!-- WHO LOST THE ITEM? -->
        <div class="clearfix ">
            <label for="lostBy"><?=__("Who lost this item?")?></label>
            <div class="input">
                <textarea id="lostBy" class="tryLoadLink" cols="30" rows="6" readonly="readonly"><?=$lostItem["LostItem"]["lost_by"]?></textarea>
            </div>
        </div>

        <hr />
        <h4 class="rowspace"><?=__("Information about person who registered item in Wannabe")?></h4>

        <!-- WHO IS LOGGED IN TO WANNABE? -->
        <div class="clearfix ">
            <label for="lostLoggedInAs"><?=__("User who was logged in when item was registered")?></label>
            <div class="input">
                <input id="lostLoggedInAs" readonly="readonly" value="<?=$lostItem["LostItem"]["lost_registered_logged_in_user"]?>">
            </div>
        </div>

        <!-- MANUAL WANNABE USER ID -->
        <div class="clearfix ">
            <label for="lostRegisteredBy"><?=__("User who actually registered the item")?></label>
            <div class="input">
                <input id="lostRegisteredBy" readonly="readonly" value="<?=$lostItem["LostItem"]["lost_registered_by"]?>">
            </div>
        </div>

        <div class="clearfix ">
            <label for="lostRegisteredWhen"><?=__("When the item was registered")?></label>
            <div class="input">
                <input id="lostRegisteredWhen" readonly="readonly" value="<?=$lostItem["LostItem"]["lost_registered_date"]?>">
            </div>
        </div>

        <hr />

    <? if($lostItem["LostItem"]["found_registered_by"] != null) { ?>

        <h4 class="rowspace"><?=__("Information about person who found this item")?></h4>

        <div class="clearfix ">
            <label for="foundBy"><?=__("The person who found the item")?></label>
            <div class="input">
                <textarea id="foundBy" class="tryLoadLink" readonly="readonly"><?=$lostItem["LostItem"]["found_by"]?></textarea>
            </div>
        </div>

        <hr />
        <h4 class="rowspace"><?=__("Information about where the item is being stored")?></h4>

        <div class="clearfix">
            <label for="storagePlace"><?=__("Storage place")?></label>
            <div class="input">
                <select readonly="readonly">
                    <option id="storagePlace"><?= $lostItem["LostAndFoundStoragePlace"]["name"] ?></option>
                </select>
            </div>
        </div>

        <hr />
        <h4 class="rowspace"><?=__("Information about person who registered the item as found in Wannabe")?></h4>

        <!-- WHO IS LOGGED IN TO WANNABE? -->
        <div class="clearfix ">
            <label for="foundLoggedInAs"><?=__("User who was logged in when item was registered as found")?></label>
            <div class="input">
                <input id="foundLoggedInAs" readonly="readonly" value="<?=$lostItem["LostItem"]["found_logged_in_user"]?>">
            </div>
        </div>

        <!-- MANUAL WANNABE USER ID -->
        <div class="clearfix ">
            <label for="foundRegisteredBy"><?=__("User who actually registered the item as found")?></label>
            <div class="input">
                <input id="foundRegisteredBy" readonly="readonly" value="<?=$lostItem["LostItem"]["found_registered_by"]?>">
            </div>
        </div>

        <div class="clearfix ">
            <label for="foundRegisteredWhen"><?=__("When the item was registered found")?></label>
            <div class="input">
                <input id="foundRegisteredWhen" readonly="readonly" value="<?=$lostItem["LostItem"]["found_date"]?>">
            </div>
        </div>

    <? } ?>

    <? if($lostItem["LostItem"]["resolved"]) { ?>

        <h4 class="rowspace"><?=__("Information about person who registered the item as resolved in Wannabe")?></h4>

        <!-- WHO IS LOGGED IN TO WANNABE? -->
        <div class="clearfix ">
            <label for="resolvedLoggedInAs"><?=__("User who was logged in when item was registered as resolved")?></label>
            <div class="input">
                <input id="resolvedLoggedInAs" readonly="readonly" value="<?=$lostItem["LostItem"]["resolved_logged_in_user"]?>">
            </div>
        </div>

        <!-- MANUAL WANNABE USER ID -->
        <div class="clearfix ">
            <label for="resolvedRegisteredBy"><?=__("User who actually registered the item as resolved")?></label>
            <div class="input">
                <input id="resolvedRegisteredBy" readonly="readonly" value="<?=$lostItem["LostItem"]["resolved_registered_by"]?>">
            </div>
        </div>

        <div class="clearfix ">
            <label for="resolvedRegisteredWhen"><?=__("When the item was registered resolved")?></label>
            <div class="input">
                <input id="resolvedRegisteredWhen" readonly="readonly" value="<?=$lostItem["LostItem"]["resolved_date"]?>">
            </div>
        </div>

        <div class="clearfix ">
            <label for="resolvedDeliveredBy"><?=__("Who handed the item back")?></label>
            <div class="input">
                <input id="resolvedDeliveredBy" readonly="readonly" value="<?=$lostItem["LostItem"]["resolved_delivered_by"]?>">
            </div>
        </div>

        <div class="clearfix ">
            <label for="resolvedDescription"><?=__("Description of delivery process")?></label>
            <div class="input">
                <input id="resolvedDescription" readonly="readonly" value="<?=$lostItem["LostItem"]["resolved_description"]?>">
            </div>
        </div>

    <? } ?>

        <div class="actions">
            <a href="<?=$this->Wb->eventUrl('/LostAndFoundV2/lost')?>" class="btn"><?=__("Back to Lost section")?></a>
        </div>
    </fieldset>
    </form>
</div>

<?=$this->Html->script('geekevents/tryloadlink.js')?>
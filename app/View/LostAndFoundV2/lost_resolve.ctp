<?=$this->Html->css('lostandfound/lostandfound')?>

    <div class="add-content-wrapper">
        <?
        $lost_resolved_logged_in_user_error    = $this->Form->error("LostItem.resolved_logged_in_user");
        $lost_resolved_registered_by_error     = $this->Form->error("LostItem.resolved_registered_by");
        $lost_resolved_registered_by_error     = $this->Form->error("LostItem.resolved_registered_by");
        $lost_resolved_delivered_by_error      = $this->Form->error("LostItem.resolved_delivered_by");
        $lost_resolved_date_error              = $this->Form->error("LostItem.resolved_date");
        $lost_resolved_description_error       = $this->Form->error("LostItem.resolved_description");
        $differentUser                         = isset($differentUser) ? $differentUser : false;
        ?>

        <div class="lost">
            <form method="post">
                <fieldset>
                    <legend><?= __("Set item as resolved and delivered") ?></legend>
                    <input type="hidden" name="data[LostItem][id]" value="<?=$lostItem["LostItem"]["id"]?>" />

                    <h4 class="rowspace"><?=__("Information about person who registered this item as resolved in Wannabe")?></h4>

                    <!-- WHO IS LOGGED IN TO WANNABE? -->
                    <div class="clearfix">
                        <label for="resolvedLoggedInAs"><?=__("Logged in user")?></label>
                        <div class="input">
                            <input id="resolvedLoggedInAs" readonly="readonly" value="<?=$wannabe->user["User"]["id"]?>">
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
                    <div class="clearfix differentUserWrapper hidden <? if($lost_resolved_registered_by_error) echo "error" ?>">
                        <label for="data[LostItem][resolved_registered_by]"><?=__("Your Wannabe user ID?")?></label>
                        <div class="input">
                            <?=$this->Form->input('LostItem.found_registered_by', array('div' => false, 'error' => false, 'label' => false, 'disabled' => 'disabled'))?>
                            <span class="help-block"><?=$lost_resolved_registered_by_error?></span>
                        </div>
                    </div>

                    <!-- MANUAL WANNABE USER ID -->
                    <div class="clearfix <? if($lost_resolved_delivered_by_error) echo "error" ?>">
                        <label for="resolvedDeliveredBy"><?=__("Delivered by")?></label>
                        <div class="input">
                            <?=$this->Form->input('LostItem.resolved_delivered_by', array('div' => false, 'error' => false, 'label' => false, 'placeholder' => __("Wannabe user id")))?>
                            <span class="help-block"><?=$lost_resolved_delivered_by_error?></span>
                        </div>
                    </div>

                    <div class="clearfix <? if($lost_resolved_delivered_by_error) echo "error" ?>">
                        <label for="resolvedDescription"><?=__("Description of delivery process")?></label>
                        <div class="input">
                            <?=$this->Form->input('LostItem.resolved_description', array('div' => false, 'error' => false, 'label' => false, 'placeholder' => __("Description of how the item was delivered")))?>
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
<?=$this->Html->script('geekevents/tryloadlink.js')?>
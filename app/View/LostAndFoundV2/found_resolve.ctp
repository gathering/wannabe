<?=$this->Html->css('lostandfound/lostandfound')?>

    <div class="add-content-wrapper">
        <?
        $found_resolved_logged_in_user_error    = $this->Form->error("FoundItem.resolved_logged_in_user");
        $found_resolved_registered_by_error     = $this->Form->error("FoundItem.resolved_registered_by");
        $found_resolved_delivered_by_error      = $this->Form->error("FoundItem.resolved_delivered_by");
        $found_resolved_delivered_to_error      = $this->Form->error("FoundItem.resolved_delivered_to");
        $found_resolved_date_error              = $this->Form->error("FoundItem.resolved_date");
        $found_resolved_description             = $this->Form->error("FoundItem.resolved_description");
        $differentUser                          = isset($differentUser) ? $differentUser : false;
        ?>

        <form method="post">
            <fieldset>
                <legend><?= __("Set item as resolved and delivered") ?></legend>
                <input type="hidden" name="data[FoundItem][id]" value="<?=$foundItem["FoundItem"]["id"]?>" />

                <h4 class="rowspace"><?=__("Information about the delivery process")?></h4>

                <!-- DESCRIPTION OF PROCESS -->
                <div class="clearfix <? if($found_resolved_description) echo "error" ?>">
                    <label for="data[FoundItem][resolved_description]"><?=__("Description of delivery process?")?></label>
                    <div class="input">
                        <?=$this->Form->input('FoundItem.resolved_description', array('value' => $foundItem["FoundItem"]["resolved_description"],'div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$found_resolved_description?></span>
                    </div>
                </div>


                <!-- DELIVERED TO -->
                <div class="apiUserIdContainer">
                    <div class="help-inline"><?=__("This should be the user who had lost the item, and got it back.")?></div>
                    <div class="clearfix <? if($found_resolved_delivered_to_error) echo "error" ?>">
                        <label for="data[FoundItem][resolved_delivered_to]"><?=__("Who was the item delivered to?")?></label>
                        <div class="input">
                            <?=$this->Form->input('FoundItem.resolved_delivered_to', array('value' => $foundItem["FoundItem"]["resolved_delivered_to"],'div' => false, 'error' => false, 'label' => false, 'class' => 'apiUserId tryLoadLink'))?>
                            <span class="help-block"><?=$found_resolved_delivered_to_error?></span>
                        </div>
                    </div>
                </div>

                <div class="help-inline"><?=__("The crew member who was responsible for handing the item back to the user.")?></div>
                <!-- DELIVERED TO -->
                <div class="clearfix <? if($found_resolved_delivered_by_error) echo "error" ?>">
                    <label for="data[FoundItem][resolved_delivered_by]"><?=__("Who was the item delivered by?")?></label>
                    <div class="input">
                        <?=$this->Form->input('FoundItem.resolved_delivered_by', array('value' => $foundItem["FoundItem"]["resolved_delivered_by"],'div' => false, 'error' => false, 'label' => false, 'placeholder' => "Wannabe-ID"))?>
                        <span class="help-block"><?=$found_resolved_delivered_by_error?></span>
                    </div>
                </div>

                <!-- WHO IS LOGGED IN TO WANNABE? -->
                <div class="clearfix">
                    <label for="resolvedLoggedInAs"><?=__("Currently logged in user")?></label>
                    <div class="input">
                        <input id="resolvedLoggedInAs" readonly="readonly" value="<?=$wannabe->user["User"]["id"]?>">
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
                <div class="clearfix differentUserWrapper hidden <? if($found_resolved_registered_by_error) echo "error" ?>">
                    <label for="data[FoundItem][resolved_registered_by]"><?=__("Your Wannabe user ID?")?></label>
                    <div class="input">
                        <?=$this->Form->input('FoundItem.resolved_registered_by', array('div' => false, 'error' => false, 'label' => false, 'disabled' => 'disabled', 'placeholder' => "Wannabe-ID"))?>
                        <span class="help-block"><?=$found_resolved_registered_by_error?></span>
                    </div>
                </div>
            </fieldset>
            <div class="actions">
                <?=$this->Form->submit(__("Save"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
                <a href="<?=$this->Wb->eventUrl('/LostAndFoundV2/found')?>" class="btn"><?=__("Back to Found section")?></a>
            </div>
        </form>
    </div>

<?=$this->Html->script('lostandfound/add.js')?>
<?=$this->Html->script('geekevents/userapi.js')?>
<?=$this->Html->script('geekevents/tryloadlink.js')?>
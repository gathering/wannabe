<?  $has_arrived = $accreditation['Accreditation']['actual_arrival'] != '0000-00-00 00:00:00';
    $has_departed = $accreditation['Accreditation']['actual_departure'] != '0000-00-00 00:00:00'; ?>

<? if(!$accreditation['Accreditation']['accepted']) { ?>
    <div class="actions">
        <a href="<?=$this->Wb->eventUrl("/Accreditation/accept/{$accreditation['Accreditation']['id']}")?>" class="btn success"><?=__("Accept and send e-mail")?></a>
        <a href="<?=$this->Wb->eventUrl("/Accreditation/decline/{$accreditation['Accreditation']['id']}")?>" class="btn danger"><?=__("Decline and send e-mail")?></a>
    </div>
<hr />

<? } ?>

<? //Checkin ?>
<div class="row">
    <div class="span4">
        <h3>Actual arrival</h3>
    <? if($has_arrived) { ?>
        <div><strong><?=date("l, M j H:i", strtotime($accreditation['Accreditation']['actual_arrival']))?></strong></div>
    <? } else { ?>
        <div><a href="<?=$this->Wb->eventUrl("/Accreditation/Checkin/{$accreditation['Accreditation']['id']}")?>" class="btn primary"><?=__("Checkin")?></a></div>
    <? } ?>
    </div>

<? //Checkout ?>
    <div class="span6">
        <h3>Actual departure</h3>
    <?php if($has_arrived && !$has_departed) { ?>
        <div><a href="<?=$this->Wb->eventUrl("/Accreditation/Checkout/{$accreditation['Accreditation']['id']}")?>" class="btn primary"><?=__("Checkout")?></a> </div>
    <? } elseif(!$has_arrived) { ?>
        <div><strong> <?=__("Has not yet arrived")?> </strong></div>
    <? } else { ?>
        <div><strong><?=date("l, M j H:i", strtotime($accreditation['Accreditation']['actual_departure']))?></strong></div>
    <? } ?>
    </div>
    
<? //Reset checkin/out data ?>
    <div class="span6">
        <h3>Reset checkin and checkout time</h3>
        <div><a href="<?=$this->Wb->eventUrl("/Accreditation/ResetCheckinOut/{$accreditation['Accreditation']['id']}")?>" class="btn danger"><?=__("Reset")?></a> </div>
    </div>
</div>

<hr />

<div class="row">
    <div class="span16">
        <form method="post" action="<?=$this->Wb->eventUrl("/Accreditation/Edit/{$accreditation['Accreditation']['id']}/saveaccreditation")?>">
            <fieldset>
                <?=$this->Form->hidden('Accreditation.id', array('value' => $accreditation['Accreditation']['id']))?>
                <legend><?=__("Edit accreditation")?></legend>

                <div class="clearfix <? if($this->Form->error('Accreditation.company_name')) echo "error"; ?>">
                    <label for="data[Accreditation][company_name]"><?=__("Company name")?> </label>

                    <div class="input">
                        <?=$this->Form->input('Accreditation.company_name', array('value' => $accreditation['Accreditation']['company_name'], 'div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$this->Form->error('Accreditation.company_name')?></span>
                    </div>
                </div>
                <div class="clearfix <? if($this->Form->error('Accreditation.realname')) echo "error"; ?>">
                    <label for="data[Accreditation][realname]"><?=__("Real name")?></label>
                    <div class="input">
                        <?=$this->Form->input('Accreditation.realname', array('value' => $accreditation['Accreditation']['realname'], 'div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$this->Form->error('Accreditation.realname')?></span>
                    </div>
                </div>
                <div class="clearfix <? if($this->Form->error('Accreditation.phonenumber')) echo "error"; ?>">
                    <label for="data[Accreditation][phonenumber]"><?=__("Phone number")?></label>
                    <div class="input">
                        <?=$this->Form->input('Accreditation.phonenumber', array('value' => $accreditation['Accreditation']['phonenumber'], 'div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$this->Form->error('Accreditation.phonenumber')?></span>
                    </div>
                </div>
                <div class="clearfix <? if($this->Form->error('Accreditation.email')) echo "error"; ?>">
                    <label for="data[Accreditation][email]"><?=__("E-mail")?></label>
                    <div class="input">
                        <?=$this->Form->input('Accreditation.email', array('value' => $accreditation['Accreditation']['email'], 'div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$this->Form->error('Accreditation.email')?></span>
                    </div>
                </div>
                <div class="clearfix <? if($this->Form->error('Accreditation.numpersons')) echo "error"; ?>">
                    <label for="data[Accreditation][numpersons]"><?=__("Number of persons")?></label>
                    <div class="input">
                        <?=$this->Form->input('Accreditation.numpersons', array('value' => $accreditation['Accreditation']['numpersons'], 'div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$this->Form->error('Accreditation.numpersons')?></span>
                    </div>
                </div>
                <div class="clearfix <? if($this->Form->error('Accreditation.badge_id')) echo "error"; ?>">
                    <label for="data[Accreditation][badge_id]"><?=__("Badge ID")?></label>
                    <div class="input">
                        <?=$this->Form->input('Accreditation.badge_id', array('type' => 'text', 'value' => $accreditation['Accreditation']['badge_id'], 'div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$this->Form->error('Accreditation.badge_id')?></span>
                    </div>
                </div>
                <div class="clearfix <? if($this->Form->error('Accreditation.arrivaldate')) echo "error"; ?>">
                    <label for="data[Accreditation][arrivaldate]"><?=__("Arrival date")?></label>
                    <div class="input">
                        <?=$this->Form->input('Accreditation.arrivaldate', array('selected' => $accreditation['Accreditation']['arrivaldate'], 'div' => false, 'error' => false, 'label' => false, 'class' => 'span2'))?>
                        <span class="help-block"><?=$this->Form->error('Accreditation.arrivaldate')?></span>
                    </div>
                </div>
                <div class="clearfix <? if($this->Form->error('Accreditation.departuredate')) echo "error"; ?>">
                    <label for="data[Accreditation][departuredate]"><?=__("Departure date")?></label>
                    <div class="input">
                        <?=$this->Form->input('Accreditation.departuredate', array('selected' => $accreditation['Accreditation']['departuredate'], 'div' => false, 'error' => false, 'label' => false, 'class' => 'span2'))?>
                        <span class="help-block"><?=$this->Form->error('Accreditation.departuredate')?></span>
                    </div>
                </div>
                <div class="clearfix">
                    <label for="objectList"><?=__("Check all that apply")?></label>
                    <div class="input">
                        <ul class="inputs-list">
                            <li>
                                <label>
                                    <?=$this->Form->input('Accreditation.pictures', array('type' => 'checkbox', 'value' => $accreditation['Accreditation']['pictures'], 'checked' => $accreditation['Accreditation']['pictures'] == 1, 'div' => false, 'error' => false, 'label' => false))?>
                                    <span><?=__("Pictures")?></span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <?=$this->Form->input('Accreditation.film', array('type' => 'checkbox', 'value' => $accreditation['Accreditation']['film'], 'checked' => $accreditation['Accreditation']['film'] == 1, 'div' => false, 'error' => false, 'label' => false))?>
                                    <span><?=__("Film")?></span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <?=$this->Form->input('Accreditation.tour', array('type' => 'checkbox', 'value' => $accreditation['Accreditation']['tour'], 'checked' => $accreditation['Accreditation']['tour'] == 1, 'div' => false, 'error' => false, 'label' => false))?>
                                    <span><?=__("Tour")?></span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <?=$this->Form->input('Accreditation.smsalert', array('value' => $accreditation['Accreditation']['smsalert'], 'checked' => $accreditation['Accreditation']['smsalert'] == 1, 'div' => false, 'error' => false, 'label' => false))?>
                                    <span><?=__("SMS Alert")?></span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix <? if($this->Form->error('Accreditation.extended_info')) echo "error"; ?>">
                    <label for="data[Accreditation][extended_info]"><?=__("Extended info")?></label>
                    <div class="input">
                        <?=$this->Form->input('Accreditation.extended_info', array('value' => $accreditation['Accreditation']['extended_info'], 'div' => false, 'error' => false, 'label' => false, 'class' => 'span8'))?>
                        <span class="help-block"><?=$this->Form->error('Accreditation.extended_info')?></span>
                    </div>
                </div>
                <div class="clearfix <? if($this->Form->error('Accreditation.internal_comment')) echo "error"; ?>">
                    <label for="data[Accreditation][internal_comment]"><?=__("Internal comment")?></label>
                    <div class="input">
                        <?=$this->Form->input('Accreditation.internal_comment', array('value' => $accreditation['Accreditation']['internal_comment'], 'div' => false, 'error' => false, 'label' => false, 'class' => 'span8'))?>
                        <span class="help-block"><?=$this->Form->error('Accreditation.internal_comment')?></span>
                    </div>
                </div>
            </fieldset>
            <div class="actions">
                <?=$this->Form->submit(__("Save changes"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
            </div>
        </form>

        <form method="post" action="<?=$this->Wb->eventUrl("/Accreditation/Edit/{$accreditation['Accreditation']['id']}/addusergroup")?>">
            <fieldset>
                <legend>Add usergroup</legend>
                <?=$this->Form->hidden('AccreditationAccess.accreditation_id', array('value' => $accreditation['Accreditation']['id']))?>
                <div class="clearfix <? if($this->Form->error('AccreditationAccess.accreditation_group_id')) echo "error"; ?>">
                    <label for="data[AccreditationAccess][accreditation_group_id]"><?=__("Add group")?></label>
                
                    <div class="input">
                        <?=$this->Form->select('AccreditationAccess.accreditation_group_id', $usergroups, array('empty' => __("Choose"), 'div' => false, 'error' => false))?>
                        <span class="help-block"><?=$this->Form->error('AccreditationAccess.accreditation_group_id')?></span>
                    </div>
                </div>
            </fieldset>
            <div class="actions">
                <?=$this->Form->submit(__("Add usergroup"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> 
            </div>
        </form>

        <table class="zebra-striped bordered-table">
            <h3><?=__("Assigned groups")?></h3>
            <tr>
                <th><?=__("Name")?></th>
                <th><?=__("Edit")?></th>
                <th><?=__("Delete")?></th>
            </tr>
            
            <? foreach($usergroups_assigned as $usergroup) { ?>
                <tr>
                    <td><?=$usergroup['Groups']['name']?></td>
                    <td><a href="<?=$this->Wb->eventUrl("/Accreditation/EditUserGroup/{$usergroup['Access']['accreditation_group_id']}") ?>" class="btn"><?=__("Edit")?></a></td>
                    <td><a href="<?=$this->Wb->eventUrl("/Accreditation/Edit/{$accreditation['Accreditation']['id']}/delusergroup/{$usergroup['Access']['accreditation_group_id']}") ?>" class="btn danger"><?=__("Delete")?></a></td>
                </tr>
            <? } ?>
            
        </table>
    </div>
</div>

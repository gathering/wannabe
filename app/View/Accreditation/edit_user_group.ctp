<? if($usergroup) { ?>
<h3><?=__("Edit user group %s", "\"" . $usergroup['AccreditationGroup']['name'] . "\"")?></h3>

<form method="post" action="<?=$this->Wb->eventUrl("/Accreditation/EditUserGroup/{$usergroup['AccreditationGroup']['id']}/name")?>">
    <?=$this->Form->hidden('AccreditationGroup.id', array('value' => $usergroup['AccreditationGroup']['id']))?>
    <div class="row"><br />
        <div class="span8">
            <div class="clearfix <? if($this->Form->error('AccreditationGroup.name')) echo "error"; ?>">
                <label for="data[AccreditationGroup][name]"><?=__("Name")?> </label>

                <div class="input">
                    <?=$this->Form->input('AccreditationGroup.name', array('value' => $usergroup['AccreditationGroup']['name'], 'div' => false, 'error' => false, 'label' => false))?>
                    <span class="help-block"><?=$this->Form->error('AccreditationGroup.name')?> </span>
                </div>
            </div>
        </div>
         <div class="span4">
            <?=$this->Form->submit(__("Save group name"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> 
        </div>
    </div>
</form>
<form method="post" action="<?=$this->Wb->eventUrl("/Accreditation/EditUserGroup/{$usergroup['AccreditationGroup']['id']}/addmember")?>">
    <?=$this->Form->hidden('AccreditationGroupMember.accreditation_group_id', array('value' => $usergroup['AccreditationGroup']['id']))?>
    <div class="row">
        <div class="span8">
            <div class="clearfix <? if($this->Form->error('AccreditationGroupMember.user_id')) echo "error"; ?>">
                <label for="data[AccreditationGroupMember][user_id]"><?=__("Add crew member")?></label>
            
                <div class="input">
        			<div class="input-prepend">
        				<span class="add-on"><?=__("User ID")?></span>
        				<input class="span3"name="data[AccreditationGroupMember][user_id]" type="text>
                    	<span class="help-block"><?=$this->Form->error('AccreditationGroupMember.user_id')?></span>
        			</div>
                </div>
            </div>
        </div>
        <div class="span4">
            <?=$this->Form->submit(__("Add user"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> 
        </div>
    </div>
</form>

<? } else { ?>
    <h3><?=__("Please select a valid user group")?></h3>
<? } ?>

</form>
<div class="row">
    <div class="span16">
        <hr />
        <h3><?=__("Members")?></h3>
        <table class="zebra-striped bordered-table">
            <tr>
                <th><?=__("Id")?></th>
                <th><?=__('Username')?></th>
                <th><?=__('Real name')?></th>
                <th><?=__('E-mail')?></th>
                <th><?=__("Delete")?></th>
            </tr>

        <? foreach($members as $member) { ?>
            <tr>
                <td><?=$member['User']['id']?></td>
                <td><?=$member['User']['username']?></td>
                <td><a href="<?=$this->Wb->eventUrl("/Profile/View/{$member['User']['id']}")?>"><?=$member['User']['realname']?></a></td>
                <td><?=$member['User']['email']?></td>
                <td><a href="<?=$this->Wb->eventUrl("/Accreditation/DeleteMemberFromUserGroup/{$usergroup['AccreditationGroup']['id']}/{$member['User']['id']}")?>" class="btn danger"><?=__("Delete")?></a></td>
            </tr>
        <? } ?>
        </table>
    </div>
</div>
<hr />
<div class="row">
    <div class="span16">
        <a href="<?=$this->Wb->eventUrl('/Accreditation/UserGroups')?>" class="btn"><?=__("Back")?></a>
    </div>
</div>

<div class="row">
    <div class="span3 offset12 into-header">
        <h4><?=__("Back")?></h4>
        <div class="well">
            <a href="<?=$this->Wb->eventUrl("/Accreditation/All")?>" class="btn primary"><?=__("Back")?></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="span16">
        <h4><?=__("Actions")?></h4>
        <a href="<?=$this->Wb->eventUrl("/Accreditation/CreateUserGroup/")?>" class="btn primary"><?=__("Create new user group")?></a>
    </div>
    
</div>

<div class="row">
    <div class="span16">
        <hr />
        <h3><?=__("User groups")?></h3>

        <table class="zebra-striped bordered-table">
            <tr>
                <th><?=__("Id")?></th>
                <th><?=__("Name")?></th>
                <th><?=__("Edit")?></th>
                <th><?=__("Delete")?></th>
            </tr>

        <? foreach($usergroups as $accreditationGroup) { ?>
            <tr>
                <td><?=$accreditationGroup['AccreditationGroup']['id']?></td>
                <td><?=$accreditationGroup['AccreditationGroup']['name']?></td>
                <td><a href="<?=$this->Wb->eventUrl("/Accreditation/EditUserGroup/{$accreditationGroup['AccreditationGroup']['id']}")?>" class="btn"><?=__("Edit")?></a></td>
                <td><a href="<?=$this->Wb->eventUrl("/Accreditation/DeleteUserGroup/{$accreditationGroup['AccreditationGroup']['id']}")?>" class="btn danger"><?=__("Delete")?></a></td>
            </tr>
        <? } ?>

        </table>
    </div>
</div>

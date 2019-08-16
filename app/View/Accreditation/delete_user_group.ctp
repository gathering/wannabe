<form method="post">
    <h3><?=__("Do you really want to delete the usergroup %s", "\"" . $usergroup['AccreditationGroup']['name'] . "\"")?></h3>
    <div class="actions">
        <?=$this->Form->submit(__("Delete group"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/Accreditation/UserGroups')?>" class="btn"><?=__("Back")?></a>
    </div>
</form>

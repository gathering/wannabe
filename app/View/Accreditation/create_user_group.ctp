<form method="post">
    <fieldset>
        <legend><?=__("Create new user group")?></legend>
        
        <div class="clearfix <? if($this->Form->error('AccreditationGroup.name')) echo "error"; ?>">
            <label for="data[AccreditationGroup][name]"><?=__("User group name")?> </label>
            
            <div class="input">
                <?=$this->Form->input('AccreditationGroup.name', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('AccreditationGroup.name')?> </span>
            </div>

        </div>
        <hr />
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit(__("Create user group"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/Accreditation/UserGroups')?>" class="btn"><?=__("Back")?></a>
    </div>
</form>

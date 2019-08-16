<div class="row">
    <div class="span16">
        <?php if(!$canManage && empty($available_press_accreditation_groups)) { ?>
            <p><?=__("You do not have any access to any accreditations")?></p>
        <?php } else { ?>
            <?php if($canManage) { ?>
                <h4><?=__("Manage all accreditations")?></h4>
                <ul>
                    <li><a href="<?=$this->Wb->eventUrl("/Accreditation/All")?>"><?=__("Manage")?></a></li>
                </ul>
            <?php } ?>
            <?php if(!empty($available_press_accreditation_groups)) { ?>
                <h4><?=__("Press accreditation groups")?></h4>
                <ul>
                <?foreach($available_press_accreditation_groups as $accreditationGroup) { ?>
                    <li><a href="<?=$this->Wb->eventUrl("/Accreditation/Group/{$accreditationGroup['Groups']['id']}")?>"><?=$accreditationGroup['Groups']['name']?></a></li>
                <? } ?>
                </ul>
            <? } ?>
            <p><a href="<?=$this->Wb->eventUrl("/Accreditation/register")?>" class="btn primary"><?=__("Register new")?></a></p>
        <?php } ?>
    </div>
</div>

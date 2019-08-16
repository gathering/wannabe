<form method="post">
    <h3><?=__("Do you really want to delete this accreditation?")?></h3>
    <div class="actions">
        <?=$this->Form->submit(__("Delete accreditation"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/Accreditation/All')?>" class="btn"><?=__("Back")?></a>
    </div>
</form>

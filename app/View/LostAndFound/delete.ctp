<form method="post">
    <h3><?=__("Do you really want to delete this item?")?></h3>
    <div class="actions">
        <?=$this->Form->submit(__("Delete item"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/LostAndFound')?>" class="btn"><?=__("Back")?></a>
    </div>
</form>

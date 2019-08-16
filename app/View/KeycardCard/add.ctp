<form method="post">
    <fieldset>
    <legend><?=__("Add keycard")?></legend>
    <div class="clearfix <? if($this->Form->error('KeycardCard.card_number')) echo "error"; ?>">
        <label for="data[KeycardCard][card_number]"><?=__('Card number')?></label>
        <div class="input">
            <?=$this->Form->textfield('KeycardCard.card_number', array('div' => false, 'error' => false, 'label' => false))?>
        </div>
        <span class="help-block"><?=$this->Form->error('KeycardCard.card_number')?></span>
    </div>
    <div class="actions">
        <?=$this->Form->submit(__("Save"), array('class' => 'btn success','name'=>'save', 'div' => false))?>
        <a class="btn" href="<?=$this->Wb->eventUrl('/KeycardCard')?>"><?=__("Back")?></a>
    </div>
    </fieldset>
</form>

<form id="disableBadge" method="post">
<fieldset>
    <legend><?=__('Disable badge')?></legend>

    <div class="clearfix <? if($this->Form->error('Badge.nfc_id')) echo "error"; ?>">
        <label for="data[Badge][nfc_id]"><?=__('NFC identfication')?></label>
        <div class="input">
            <?=$this->Form->text('Badge.nfc_id', array('label' => false, 'div' => false)) ?>
            <span class="help-block"><?=$this->Form->error('nfc_id')?></span>
        </div>
    </div>
</fieldset>

<div class="actions">
    <?=$this->Form->submit($savebutton, array('class' => 'btn warning','name'=>'save'))?>
    <a href="<?=$this->Wb->eventUrl('/Badge')?>" class="btn"><?=__("Back")?></a>
</div>
</form>

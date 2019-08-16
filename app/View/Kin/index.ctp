<form method="post">
    <fieldset>
        <legend><?=__("Fill in or change name and phone number")?></legend>
        <div class="clearfix <? if($this->Form->error('Kin.name')) echo "error"; ?>">
            <label for="data[Kin][name]"><?=__("Name")?></label>
            <div class="input">
                <?=$this->Form->input('Kin.name', array('div' => false, 'error' => false, 'label' => false, 'value' => (isset($kin['Kin']['name']))?$kin['Kin']['name']:''))?>
                <span class="help-block"><?=$this->Form->error('Kin.name')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Kin.number')) echo "error"; ?>">
            <label for="data[Kin][number]"><?=__("Phone number")?></label>
            <div class="input">
                <?=$this->Form->input('Kin.number', array('div' => false, 'error' => false, 'label' => false, 'value' => (isset($kin['Kin']['number']))?$kin['Kin']['number']:''))?>
                <span class="help-block"><?=$this->Form->error('Kin.number')?></span>
            </div>
        </div>
        <div class="actions">
            <?=$this->Form->submit(__("Send"), array('class' => 'btn success','name'=>'save'))?>
        </div>
    </fieldset>
</form>


<form method="post">
<fieldset>
    <legend><?=__("Hand out card")?></legend>
    <div class="clearfix">
    <label for="[KeycardHandout][card_id]"><?=__("Choose card")?></label>
        <div class="input">
            <?=$this->Form->select('KeycardHandout.card_id', $cards, array('div' => false, 'error' => false, 'label' => false))?>
        </div>    
    </div>
    <div class="clearfix">
    <label for="[KeycardHandout][name]"><?=__("Name")?></label>
        <div class="input">
            <?=$this->Form->input('KeycardHandout.name', array('div' => false, 'error' => false, 'label' => false))?>
        </div>    
    </div>
    <div class="clearfix">
    <label for="[KeycardHandout][seat]"><?=__("Seat/row")?></label>
        <div class="input">
            <?=$this->Form->input('KeycardHandout.seat', array('div' => false, 'error' => false, 'label' => false))?>
        </div>    
    </div>
    <div class="clearfix">
    <label for="[iKeycardHandout][phone]"><?=__("Phone")?></label>
        <div class="input">
            <?=$this->Form->input('KeycardHandout.phone', array('div' => false, 'error' => false, 'label' => false))?>
        </div>    
    </div>
    <div class="clearfix">
    <label for="[KeycardHandout][deposit]"><?=__("Deposit")?></label>
        <div class="input">
            <?=$this->Form->input('KeycardHandout.deposit', array('div' => false, 'error' => false, 'label' => false))?>
        </div>    
    </div>
    <div class="clearfix">
    <label for="[KeycardHandout][deposit_desc]"><?=__("Description")?></label>
        <div class="input">
            <?=$this->Form->input('KeycardHandout.deposit_desc', array('div' => false, 'error' => false, 'label' => false))?>
        </div>    
    </div>
    <div class="actions">
        <?=$this->Form->submit(__("Hand out"), array('class' => 'btn success','name'=>'save', 'div' => false))?>        
        <a class="btn" href="<?=$this->Wb->eventUrl('/KeycardHandout')?>"><?=__("Back")?></a>
    </div>
</fieldset>
</form>

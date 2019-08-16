<form method="post">
    <fieldset>
        <legend><?=__("Resolve item")?></legend>
        <?=$this->Form->hidden('LostAndFound.id', array('value' => $id))?>
        <div class="clearfix <? if($this->Form->error('LostAndFound.delivered_to')) echo "error"; ?>">
            <label for="data[LostAndFound][delivered_to]"><?=__("Delivered to")?></label>
            <div class="input">
                <?=$this->Form->input('LostAndFound.delivered_to', array('value' => $item['LostAndFound']['delivered_to'], 'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LostAndFound.delivered_to')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LostAndFound.delivered_to_contact')) echo "error"; ?>">
            <label for="data[LostAndFound][delivered_to_contact]"><?=__("Delivered to contact information")?></label>
            <div class="input">
                <?=$this->Form->input('LostAndFound.delivered_to_contact', array('value' => $item['LostAndFound']['delivered_to_contact'],'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LostAndFound.delivered_to_contact')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LostAndFound.resolved_by')) echo "error"; ?>">
            <label for="data[LostAndFound][resolved_by]"><?=__("Resolved by")?></label>
            <div class="input">
                <div class="input-prepend">
                        <span class="add-on"><?=__("User ID")?></span>
                        <input class="span3"name="data[LostAndFound][resolved_by]" type="text>
                        <span class="help-block"><?=$this->Form->error('LostAndFound.resolved_by')?></span>
                    </div>
            </div>
        </div>
    </fieldset>
    
    <div class="actions">
        <?=$this->Form->submit(__("Resolve item"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
        <a href="<?=$this->Wb->eventUrl('/LostAndFound')?>" class="btn"><?=__("Back")?></a>
    </div>
</form>

<form method="post">
    <fieldset>
        <legend><?=__("Edit item")?></legend>
        <?=$this->Form->hidden('LostAndFound.id', array('value' => $id))?>
        <div class="clearfix <? if($this->Form->error('LostAndFound.name')) echo "error"; ?>">
            <label for="data[LostAndFound][name]"><?=__("Name")?> </label>
            <div class="input">
                <?=$this->Form->input('LostAndFound.name', array('value' => $item['LostAndFound']['name'],'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LostAndFound.name')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LostAndFound.type')) echo "error"; ?>">
            <label for="data[LostAndFound][type]"><?=__("Type")?></label>
            <div class="input">
                <?=$this->Form->select('LostAndFound.type', array("0" => "Lost", "1" => "Found"), array('empty' => false, 'value' => $item['LostAndFound']['type']))?>
                <span class="help-block"><?=$this->Form->error('LostAndFound.type')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LostAndFound.description')) echo "error"; ?>">
            <label for="data[LostAndFound][description]"><?=__("Description")?></label>
            <div class="input">
                <?=$this->Form->input('LostAndFound.description', array('value' => $item['LostAndFound']['description'], 'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LostAndFound.description')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LostAndFound.found_where')) echo "error"; ?>">
            <label for="data[LostAndFound][found_where]"><?=__("Found/Lost where")?></label>
            <div class="input">
                <?=$this->Form->input('LostAndFound.found_where', array('value' => $item['LostAndFound']['found_where'],'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LostAndFound.found_where')?></span>
            </div>
        </div>
        <div class="row">
            <div class="span8">
                <div class="clearfix <? if($this->Form->error('LostAndFound.found_when')) echo "error"; ?>">
                    <label for="data[LostAndFound][found_when]"><?=__("Found/Lost when")?></label>
                    <div class="input">
                        <?=$this->Form->input('LostAndFound.found_when', array('selected' => $item['LostAndFound']['found_when'],'div' => false, 'error' => false, 'label' => false, 'class' => 'span2'))?>
                        <span class="help-block"><?=$this->Form->error('LostAndFound.found_when')?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LostAndFound.reported_by')) echo "error"; ?>">
            <label for="data[LostAndFound][reported_by]"><?=__("Reported by")?></label>
            <div class="input">
                <?=$this->Form->input('LostAndFound.reported_by', array('value' => $item['LostAndFound']['reported_by'],'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LostAndFound.reported_by')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LostAndFound.reported_by_contact')) echo "error"; ?>">
            <label for="data[LostAndFound][reported_by_contact]"><?=__("Reported by contact information")?></label>
            <div class="input">
                <?=$this->Form->input('LostAndFound.reported_by_contact', array('value' => $item['LostAndFound']['reported_by_contact'],'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LostAndFound.reported_by_contact')?></span>
            </div>
        </div>
    </fieldset>
    
    <div class="actions">
        <?=$this->Form->submit(__("Save"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
        <a href="<?=$this->Wb->eventUrl('/LostAndFound')?>" class="btn"><?=__("Back")?></a>
    </div>
</form>

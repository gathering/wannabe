<form method="POST" action="">
	<fieldset id="infofield">
        <legend><?=__("Item info")?></legend>
        <div class="clearfix <? if($this->Form->error('Item.name')) echo "error"; ?>">
            <label for="data[Item][name]"><?=__("Name")?></label>
            <div class="input">
                <?=$this->Form->input('Item.name', array('div' => false, 'error' => false, 'class' => 'form-control', 'label' => false, 'value' => ($item['LogisticItem']['name'])))?>
                <span class="help-block"><?=$this->Form->error('Item.name')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Item.description')) echo "error"; ?>">
            <label for="data[Item][description]"><?=__("Description")?></label>
            <div class="input">
                <?=$this->Form->input('Item.description', array('div' => false, 'error' => false, 'class' => 'form-control', 'label' => false, 'value' => ($item['LogisticItem']['description'])))?>
                <span class="help-block"><?=$this->Form->error('Item.description')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Tag.id')) echo "error"; ?>">
            <label for="data[Tags]"><?=__("Tags")?></label>
            <div class="input">
                <?=$this->Form->input('Tag', array('div' => false, 'error' => false, 'label' => false, 'class' => 'form-control', 'multiple' => 'multiple', 'value' => $selected_tags))?>
                <span class="help-block"><?=$this->Form->error('Tag.id')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Item.supplier_id')) echo "error"; ?>">
            <label for="data[Item][supplier_id]"><?=__("Supplier")?></label>
            <div class="input">
                <?=$this->Form->select('Item.supplier_id', $suppliers, array('div' => false, 'error' => false, 'class' => 'form-control', 'label' => false, 'empty' => __("Choose"), 'value' => $item['LogisticSupplier']['id']))?>
                <span class="help-block"><?=$this->Form->error('Item.supplier_id')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Item.parent')) echo "error"; ?>">
            <label for="data[Item][parent]"><?=__("Parent")?></label>
            <div class="input">
                <?=$this->Form->i('Item.parent', $suppliers, array('div' => false, 'error' => false, 'label' => false, 'value' => $item['LogisticItem']['parent']))?>
                <span class="help-block"><?=$this->Form->error('Item.supplier_id')?></span>
            </div>
        </div>
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit('Save', array('class' => 'btn btn-success', 'div' => false))?> <a href="<?=$this->Wb->eventUrl('/logistic/Item/view/'.$item['LogisticItem']['id'])?>" class="btn btn-info"><?=__("Back to item")?></a>
    </div>
</form>

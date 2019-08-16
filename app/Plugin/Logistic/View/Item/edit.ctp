<form method="POST" action="<?=$this->Wb->eventUrl( '/logistic/Item/update' )?>">
    <?=$this->Form->hidden('Item.id', array('value' => $item['LogisticItem']['id']))?>
    <?php if($bulk) { ?>
        <?=$this->Form->hidden('Item.bulk_id', array('value' => $bulk['LogisticBulk']['id']))?>
    <?php } ?>
    <fieldset id="infofield">
        <legend><?=__("Item info")?></legend>
        <div class="clearfix <? if($this->Form->error('Item.name')) echo "error"; ?>">
            <label for="data[Item][name]"><?=__("Name")?></label>
            <div class="input">
                <?=$this->Form->input('Item.name', array('div' => false, 'error' => false, 'label' => false, 'class' => 'form-control', 'value' => ($bulk?$bulk['LogisticBulk']['name']:$item['LogisticItem']['name'])))?>
                <span class="help-block"><?=$this->Form->error('Item.name')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Item.description')) echo "error"; ?>">
            <label for="data[Item][description]"><?=__("Description")?></label>
            <div class="input">
                <?=$this->Form->input('Item.description', array('div' => false, 'error' => false, 'class' => 'form-control', 'label' => false, 'value' => ($bulk?$bulk['LogisticBulk']['description']:$item['LogisticItem']['description'])))?>
                <span class="help-block"><?=$this->Form->error('Item.description')?></span>
            </div>
        </div>
        <?php if ($bulk['LogisticBulk']['type'] != 'bulk') { ?>
        <div class="clearfix <? if($this->Form->error('Item.comment')) echo "error"; ?>">
            <label for="data[Item][comment]"><?=__("Comment")?></label>
            <div class="input">
                <?=$this->Form->input('Item.comment', array('div' => false, 'error' => false, 'class' => 'form-control', 'label' => false, 'value' => $item['LogisticItem']['comment']))?>
                <span class="help-block"><?=$this->Form->error('Item.comment')?></span>
            </div>
        </div>
        <?php } ?>
        <div class="clearfix <? if($this->Form->error('Tag.id')) echo "error"; ?>">
            <label for="data[Tags]"><?=__("Tags")?></label>
            <div class="input">
                <?=$this->Form->input('Tag', array('div' => false, 'error' => false, 'class' => 'form-control', 'label' => false, 'multiple' => 'multiple', 'value' => $selected_tags))?>
                <span class="help-block"><?=$this->Form->error('Tag.id')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Item.supplier_id')) echo "error"; ?>">
            <label for="data[Item][supplier_id]"><?=__("Supplier")?></label>
            <div class="input">
                <?=$this->Form->select('Item.supplier_id', $suppliers, array('div' => false, 'class' => 'form-control', 'error' => false, 'label' => false, 'empty' => __("Choose"), 'value' => $item['LogisticSupplier']['id']))?>
                <span class="help-block"><?=$this->Form->error('Item.supplier_id')?></span>
            </div>
        </div>
        <?php if ($bulk['LogisticBulk']['type'] == 'bulk') { ?>
        <div class="clearfix <? if($this->Form->error('Item.amount')) echo "error"; ?>">
            <label for="data[Item][amount]"><?=__("Number of items")?></label>
            <div class="input">
                <?=$this->Form->input('Item.amount', array('div' => false, 'error' => false, 'class' => 'form-control', 'label' => false, 'value' => $bulk['LogisticBulk']['amount']))?>
                <span class="help-block"><?=$this->Form->error('Item.amount')?></span>
            </div>
        </div>
        <?php } ?>
        <div class="clearfix <? if($this->Form->error('Item.AssetTag')) echo "error"; ?>">
            <label for="data[Item][AssetTag]"><?=__("AssetTag")?></label>
            <div class="input">
                <?=$this->Form->input('Item.AssetTag', array('div' => false, 'error' => false, 'class' => 'form-control', 'label' => false, 'value' => $item['LogisticItem']['AssetTag']))?>
                <span class="help-block"><?=$this->Form->error('Item.AssetTag')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Item.parent')) echo "error"; ?>">
            <label for="data[Item][parent]"><?=__("Parent")?></label>
            <div class="input">
                <?=$this->Form->i('Item.parent', array('div' => false, 'error' => true, 'label' => false, 'maxlength' => 4,'value' => $item['LogisticItem']['parent']))?>
                <span class="help-block"><?=$this->Form->error('Item.parent')?></span>
            </div>
        </div>
        <?php if (!$bulk) { ?>
        <div class="clearfix <? if($this->Form->error('Item.serialnumber')) echo "error"; ?>">
            <label for="data[Item][serialnumber]"><?=__("Serial number")?></label>
            <div class="input">
                <?=$this->Form->input('Item.serialnumber', array('div' => false, 'error' => false, 'class' => 'form-control', 'label' => false, 'value' => $item['LogisticItem']['serialnumber']))?>
                <span class="help-block"><?=$this->Form->error('Item.serialnumber')?></span>
            </div>
        </div>
        <?php } ?>
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit('Save', array('class' => 'btn btn-primary', 'div' => false))?> <a href="<?=$this->Wb->eventUrl('/logistic/Item/view/'.$item['LogisticItem']['id'])?>" class="btn btn-info"><?=__("Back to item")?></a>
    </div>
</form>

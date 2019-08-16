<form method="post" action="<?=$this->Wb->eventUrl("/WardrobeCardAdmin/Create")?>">
    <fieldset>
        <legend><?=__("Register new item")?></legend>

        <div class="clearfix <? if($this->Form->error('WardrobeCard.card')) echo "error"; ?>">
            <label for="data[WardrobeCard][card]"><?=__("Serialnumber")?> </label>

            <div class="input">
                <?=$this->Form->input('WardrobeCard.card', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=__("Must be unique across all items")?></span>
                <span class="help-block"><?=$this->Form->error('WardrobeCard.card')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('WardrobeCard.wardrobe')) echo "error"; ?>">
            <label for="data[WardrobeCard][wardrobe]"><?=__("Description of item")?> </label>

            <div class="input">
                <?=$this->Form->input('WardrobeCard.wardrobe', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=__("Garderobe 1 / Garderobe 3 / Skrutrekker")?></span>
                <span class="help-block"><?=$this->Form->error('WardrobeCard.wardrobe')?></span>
            </div>
        </div>
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit(__("Save changes"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
        <a href="<?=$this->Wb->eventUrl("/WardrobeCardAdmin")?>" class="btn">Back</a>
    </div>
</form>

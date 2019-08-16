<form method="post" action="<?=$this->Wb->eventUrl("/WardrobeCardAdmin/Edit/{$card['WardrobeCard']['id']}")?>">
    <fieldset>
        <?=$this->Form->hidden('WardrobeCard.id', array('value' => $card['WardrobeCard']['id']))?>
        <legend><?=__("Edit item " . $card['WardrobeCard']['card'] )?></legend>

        <div class="clearfix <? if($this->Form->error('WardrobeCard.wardrobe')) echo "error"; ?>">
            <label for="data[WardrobeCard][wardrobe]"><?=__("Description of item")?> </label>

            <div class="input">
                <?=$this->Form->input('WardrobeCard.wardrobe', array('value' => $card['WardrobeCard']['wardrobe'], 'div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('WardrobeCard.wardrobe')?></span>
            </div>
        </div>
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit(__("Save changes"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
        <a href="<?=$this->Wb->eventUrl("/WardrobeCardAdmin")?>" class="btn">Back</a>
    </div>
</form>

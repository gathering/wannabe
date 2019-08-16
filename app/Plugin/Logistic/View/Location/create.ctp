<h2><?=__("Logistics")?></h2>

<p><?=__("Create storage location")?></p>
<form method="POST" action="<?=$this->Wb->eventUrl( '/logistic/Location/create' )?>">
        <div class="clearfix <? if($this->Form->error('Item.name')) echo "error"; ?>">
            <label for="data[Item][name]"><?=__("Location name")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticLocation.name', array('div' => false, 'error' => false, 'label' => false, 'value' => ''))?>
            </div>
        </div>
	<input class="btn primary" type="submit" value="<?=__("Create new location")?>" />
</form>

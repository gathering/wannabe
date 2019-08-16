<?=$this->Html->css('lostandfound/lostandfound')?>

<div class="lostandfound row show-grid">
    <div class="span-one-third">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/lost")?>" class="btn large"><?=__("Go to Lost section")?></a>
    </div>
    <div class="span-one-third">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/found")?>" class="btn large"><?=__("Go to Found section")?></a>
    </div>
    <div class="span-one-third">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/resolved")?>" class="btn large"><?=__("Go to Resolved section")?></a>
    </div>
</div>

<hr />

<div class="row lostandfoundindex">
    <div class="span8">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/storagePlaces")?>" class="btn"><?=__("Storage places")?></a>
    </div>
    <div class="span8">
        <a href="<?=$this->Wb->eventUrl("/LostAndFoundV2/categories")?>" class="btn default"><?=__("Item categories")?></a>
    </div>
</div>
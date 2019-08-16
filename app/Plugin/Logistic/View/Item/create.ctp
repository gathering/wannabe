<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>

<div class="row">
<div class="col-md-3">

<form method="POST" action="<?=$this->Wb->eventUrl( '/logistic/Item/createNew' )?>">
        <legend><?=__("Item info")?></legend>
        <div class="clearfix <? if($this->Form->error('Item.AssetTag')) echo "error"; ?>">
            <label for="data[Item][AssetTag]"><?=__("AssetTag")?></label>
            <div class="input">
                <?=$this->Form->input('Item.AssetTag', array('div' => false, 'error' => false, 'label' => false, 'class'=> 'form-control'))?>
                <span class="help-block"><?=$this->Form->error('Item.AssetTag')?></span>
            </div>
        </div>
    <div class="actions">
        <?=$this->Form->submit('Create', array('class' => 'btn btn-primary', 'div' => false))?>
    </div>
</form>
</div>

</div>
<?php if(isset($noItems)) {
    echo $noItems;
} else { ?>

<form method="post">
<?php foreach($items as $key => $item) { ?>
    <div class="page-header">
        <h3><?=$item['CrewEffectsItem']['title']?></h3>
    </div>
      <div class="row">
        <?php if ( $item['CrewEffectsItem']['image'] != '' ) { ?>
        <div class="col-md-5">
            <ul class="media-grid">
                <li>
                    <a target="_blank" href="<?=$item['CrewEffectsItem']['image']?>"><img src="<?=$item['CrewEffectsItem']['image']?>" alt="<?=$item['CrewEffectsItem']['title']?>" border="0" width="100%" /></a>
                </li>
            </ul>
        </div>
        <?php } ?>
        <?php if ( $item['CrewEffectsItem']['description'] != '' ) { ?>
        <div class="col-md-7">
            <h4><?=__("Description")?></h4>
            <p><?=nl2br($item['CrewEffectsItem']['description'])?></p>
            <?php if($item['CrewEffectsItem']['allow_order']): ?>
            <fieldset>
                <?=(isset($item['Order']['CrewEffectsOrder']['id']) ? $this->Form->hidden('CrewEffectsOrder.'.$key.'.id', array('value' => $item['Order']['CrewEffectsOrder']['id'])) : null)?>
                <?= $this->Form->hidden('CrewEffectsOrder.'.$key.'.item_id', array('value' => $item['CrewEffectsItem']['id']))?>
                <div class="clearfix">
                </div>
                <div class="clearfix <? if($this->Form->error('CrewEffectsOrder.item_size')) echo "error"; ?>">
                    <label for="data[CrewEffectsOrder][<?=$key?>][item_size]" style="font-weight: bold;"><?=__('Size')?></label>
                    <div class="input">
                        <?= $this->Form->select('CrewEffectsOrder.'.$key.'.item_size', $item['CrewEffectsItem']['sizes'],  array('label' => false, 'div' => false, 'value' => (isset($item['Order']['CrewEffectsOrder']['item_size']) ? $item['Order']['CrewEffectsOrder']['item_size'] : ''))) ?>
                        <span class="help-block"><?=$this->Form->error('CrewEffectsOrder.item_size')?></span>
                    </div>
                </div>
                <?php /*<div class="clearfix <? if($this->Form->error('CrewEffectsItem.item_amount')) echo "error"; ?>">
                    <label for="data[CrewEffectsItem][item_amount]"><?=__('Extra items')?></label>
                    <div class="input">
                    <p><?=__("You will get %s pcs. %s free.", $item['CrewEffectsItem']['amount_free'], strtolower($item['CrewEffectsItem']['title']))?>
                        <br /><?=__("Additional %s will cost NOK %s,– per psc. Amount entered here is extra items, not including free item. If you just want free items leave extra items at zero.", strtolower($item['CrewEffectsItem']['title']), $item['CrewEffectsItem']['price'])?></p>
                        <?= $this->Form->input('CrewEffectsOrder.'.$key.'.item_amount', array('class' => 'small', 'label' => false, 'div' => false, 'value' => (isset($item['Order']['CrewEffectsOrder']['item_amount']) ? $item['Order']['CrewEffectsOrder']['item_amount'] : '0'))) ?>
                        <span class="help-block"><?=$this->Form->error('CrewEffectsOrder.item_amount')?></span>
                    </div>
                    </div> */ ?>
                    <p><?=__("You will get %s pcs. %s free.", $item['CrewEffectsItem']['amount_free'], strtolower($item['CrewEffectsItem']['title']))?></p>
            </fieldset>
            <?php else: ?>
                <p><?=__("You cannot change your order at this point.")?>
                <?php /* Your order is as follows:")?></p>
                <p><?=__("You will get a total of %s pcs. %s in size %s.",
                    ($item['Order']['CrewEffectsOrder']['item_amount']+$item['CrewEffectsItem']['amount_free']),
                    $item['CrewEffectsItem']['title'],
                    $item['Order']['CrewEffectsOrder']['item_size']
                )?></a>
                <?php if($item['Order']['CrewEffectsOrder']['item_amount']): ?>
                    <p><?=__("%s of which you will get for free, and %s you will have to pay %sNOK each for.",
                        $item['CrewEffectsItem']['amount_free'],
                        $item['Order']['CrewEffectsOrder']['item_amount'],
                        $item['CrewEffectsItem']['price']
                    )?></p>
                <?php else: ?>
                    <p><?=__("You will get this for free.")?></p>
                <?php endif; */?>
            <?php endif; ?>
        </div>
        <?php } ?>
    </div>
<?php } ?>
<div class="actions">
    <?=$this->Form->submit(__("Save order"), array('class' => 'btn btn-lg btn-success','name'=>'save'))?>
</div>
</form>
<?php } ?>

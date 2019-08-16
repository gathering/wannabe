<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<form method="POST">
    <fieldset>
        <div class="clearfix <? if($this->Form->error('LogisticSupplier.company')) echo "error"; ?>">
            <label for="data[LogisticSupplier][company]"><?=__("Company name")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticSupplier.company', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LogisticSupplier.company')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LogisticSupplier.contact')) echo "error"; ?>">
            <label for="data[LogisticSupplier][contact]"><?=__("Contact")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticSupplier.contact', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LogisticSupplier.contact')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LogisticSupplier.email')) echo "error"; ?>">
            <label for="data[LogisticSupplier][email]"><?=__("Email")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticSupplier.email', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LogisticSupplier.email')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LogisticSupplier.address')) echo "error"; ?>">
            <label for="data[LogisticSupplier][address]"><?=__("Address")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticSupplier.address', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LogisticSupplier.address')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LogisticSupplier.postcode')) echo "error"; ?>">
            <label for="data[LogisticSupplier][postcode]"><?=__("Postal code")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticSupplier.postcode', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('LogisticSupplier.postcode')?></span>
            </div>
        </div>
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit(__("Add"), array('class' => 'btn btn-success', 'div' => false))?>
    </div>
</form>

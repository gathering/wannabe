<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<form method="POST">
    <?=$this->Form->hidden('LogisticSupplier.id', array('value' => $supplier['LogisticSupplier']['id']))?>
    <fieldset>
        <div class="clearfix <? if($this->Form->error('LogisticSupplier.company')) echo "error"; ?>">
            <label for="data[LogisticSupplier][company]"><?=__("Company name")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticSupplier.company', array('div' => false, 'error' => false, 'label' => false, 'value' => $supplier['LogisticSupplier']['company']))?>
                <span class="help-block"><?=$this->Form->error('LogisticSupplier.company')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LogisticSupplier.contact')) echo "error"; ?>">
            <label for="data[LogisticSupplier][contact]"><?=__("Contact")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticSupplier.contact', array('div' => false, 'error' => false, 'label' => false, 'value' => $supplier['LogisticSupplier']['contact']))?>
                <span class="help-block"><?=$this->Form->error('LogisticSupplier.contact')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LogisticSupplier.email')) echo "error"; ?>">
            <label for="data[LogisticSupplier][email]"><?=__("Email")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticSupplier.email', array('div' => false, 'error' => false, 'label' => false, 'value' => $supplier['LogisticSupplier']['email']))?>
                <span class="help-block"><?=$this->Form->error('LogisticSupplier.email')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LogisticSupplier.address')) echo "error"; ?>">
            <label for="data[LogisticSupplier][address]"><?=__("Address")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticSupplier.address', array('div' => false, 'error' => false, 'label' => false, 'value' => $supplier['LogisticSupplier']['address']))?>
                <span class="help-block"><?=$this->Form->error('LogisticSupplier.address')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('LogisticSupplier.postcode')) echo "error"; ?>">
            <label for="data[LogisticSupplier][postcode]"><?=__("Postal code")?></label>
            <div class="input">
                <?=$this->Form->input('LogisticSupplier.postcode', array('div' => false, 'error' => false, 'label' => false, 'value' => $supplier['LogisticSupplier']['postcode']))?>
                <span class="help-block"><?=$this->Form->error('LogisticSupplier.postcode')?></span>
            </div>
        </div>
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit(__("Update"), array('class' => 'btn btn-success', 'div' => false))?>
        <a href="<?=$this->Wb->eventUrl('/logistic/Supplier/delete/'.$supplier['LogisticSupplier']['id'])?>" class="btn btn-danger"><?=__("Delete")?></a>
    </div>
</form>

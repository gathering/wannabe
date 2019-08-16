<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<form method="POST" action="<?=$this->Wb->eventUrl( '/logistic/Item/save' )?>">
<script type="text/javascript">
function switchmode(mode) {
    var single = $('.show-for-single');
    var series = $('.show-for-series');
    var bulk = $('.show-for-bulk');
    if (mode == 'single') {
        series.hide();
        bulk.hide();
        single.show();
    } else if (mode == 'series') {
        single.hide();
        bulk.hide();
        series.show();
    } else if (mode == 'bulk') {
        single.hide();
        series.hide();
        bulk.show();
    }
}
function registration(modus) {
    var stock = document.getElementById('stock');
    var handout = document.getElementById('handout');
    var registrationbox = document.getElementById('registrationbox');
    registrationbox.value = modus;
    if (modus == 'stock') {
        stock.style.display = 'block';
        handout.style.display = 'none';
    }
    else if (modus == 'handout') {
        stock.style.display = 'none';
        handout.style.display = 'block';
    }
    else if (modus == 'register') {
        stock.style.display = 'none';
        handout.style.display = 'none';
    }
}
registration('register');
</script>

    <div class="row">
<div class="col-md-12">

    <fieldset>
        <legend><?=__("Registration mode")?></legend>
        <div id="mode" class="col-md-4">
            <label for="data[Item][regmode]"><?=__("Mode")?>:</label>
            <div class="input">
                <select name="data[Item][regmode]" onchange="switchmode(this[selectedIndex].value)" class="form-control">
                    <option value="single"><?=__('Single item')?></option>
                    <option value="series"><?=__('Series of items')?></option>
                    <option value="bulk"><?=__('Bulk')?></option>
                </select>
            </div>
        </div>
    </fieldset>
    <hr />
    <fieldset>

</div>

        <div class="col-md-6">

        <legend><?=__("Mandatory item info")?></legend>

        <div class="clearfix <? if($this->Form->error('Item.AssetTag')) echo "error"; ?>">
            <label for="data[Item][AssetTag]"><?=__("AssetTag")?></label>
            <div class="input">
                <?=$this->Form->input('Item.AssetTag', array('div' => false, 'error' => false, 'label' => false, 'value' => $AssetTag, 'readonly' => 'readonly', 'class' => 'form-control'))?>
                <span class="show-for-series help-block" style="display: none"><?=__("Only one AssetTag can be added now, the rest should be added after the series has been created.")?></span>
            </div>
        </div>
        <div style="display: none" class="show-for-bulk clearfix <? if($this->Form->error('Item.count')) echo "error"; ?>">
            <label for="data[Item][count]"><?=__("Number of items")?></label>
            <div class="input">
                <?=$this->Form->input('Item.count', array('div' => false, 'error' => false, 'label' => false, 'class' => 'form-control'))?>
                <span class="help-block"><?=$this->Form->error('Item.count')?></span>
            </div>
        </div>
        <br />
        <br />
        <div class="clearfix <? if($this->Form->error('Item.name')) echo "error"; ?>">
            <label for="data[Item][name]"><?=__("Name")?></label>
            <div class="input">
                <?=$this->Form->input('Item.name', array('div' => false, 'error' => false, 'label' => false, 'class' => 'form-control'))?>
                <span class="help-block"><?=$this->Form->error('Item.name')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Item.supplier_id')) echo "error"; ?>">
            <label for="data[Item][supplier_id]"><?=__("Supplier")?></label>
            <div class="input">
                <?=$this->Form->select('Item.supplier_id', $suppliers, array('div' => false, 'error' => false, 'label' => false, 'empty' => __("Choose"), 'class' => 'form-control'))?>
                <span class="help-block"><?=$this->Form->error('Item.supplier_id')?></span>
            </div>
        </div>

    </fieldset>

        </div>
        <div class="col-md-6">

    <fieldset>

        <legend><?=__("Optional item info")?></legend>

        <div class="show-for-single show-for-series clearfix <? if($this->Form->error('Item.serialnumber')) echo "error"; ?>">
            <label for="data[Item][serialnumber]"><?=__("Serial number")?></label>
            <div class="input">
                <?=$this->Form->input('Item.serialnumber', array('div' => false, 'error' => false, 'label' => false, 'class' => 'form-control'))?>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Item.description')) echo "error"; ?>">
            <label for="data[Item][description]"><?=__("Description")?></label>
            <div class="input">
                <?=$this->Form->input('Item.description', array('div' => false, 'error' => false, 'label' => false, 'class' => 'form-control'))?>
                <span class="help-block"><?=$this->Form->error('Item.description')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Tag.id')) echo "error"; ?>">
            <label for="data[Tags]"><?=__("Tags")?></label>
            <div class="input">
                <?=$this->Form->input('Tag', array('div' => false, 'error' => false, 'label' => false, 'multiple' => 'multiple', 'class' => 'form-control'))?>
                <span class="help-block"><?=$this->Form->error('Tag.id')?></span>
            </div>
        </div>
        <div class="clearfix <?  if($this->Form->error('Item.unrig_storage_id')) echo "error"; ?>">
            <label for="data[Item][unrig_storage_id]"><?=__("Unrig destination")?></label>
            <div class="input">
                <?=$this->Form->select('Item.unrig_storage_id', $unrig_storages, array('div' => false, 'error' => false, 'label' => false, 'empty' => __("Choose"), 'class' => 'form-control'))?>
                <span class="help-block"><?=$this->Form->error('Item.unrig_storage_id')?></span>
            </div>
        </div>
        <div class="clearfix <?  if($this->Form->error('Item.parent')) echo "error"; ?>">
            <label for="data[Item][parent]"><?=__("Parent")?></label>
            <div class="input">
                <?=$this->Form->i('Item.parent', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('Item.parent')?></span>
            </div>
        </div>
    </fieldset>
        </div>

        <div class="col-md-12">
    <fieldset id="regaction">
        <legend><?=__("Registration action")?></legend>
        <div class="col-md-4">
            <label for="data[Item][regimode]"><?=__("Action")?></label>
            <div class="input">
                <select name="data[Item][regimode]" onchange="registration(this[selectedIndex].value)" class="form-control">
                        <option value="register"><?=__('Just register')?></option>
                        <option value="stock"><?=__('Place in stock')?></option>
                        <option value="handout"><?=__('Hand out')?></option>
                </select>
            </div>
        </div>
    </fieldset>
        </div>

        <div class="col-md-3">
    <fieldset id="stock" style="display:none; margin-top: 20px;">
        <legend><?=__("Storage unit")?></legend>
        <div class="clearfix">
            <label for="data[Item][storage_id]"><?=__("Storage unit")?></label>
            <div class="input">
                <?=$this->Form->select('Item.storage_id', $storages, array('div' => false, 'error' => false, 'label' => false, 'empty' => __("Choose"), 'class' => 'form-control'))?>
            </div>
        </div>
    </fieldset>


    <fieldset id="handout" style="display:none; margin-top: 20px;">
        <legend><?=__("Hand out to user")?></legend>
        <div class="clearfix">
            <label for="data[Item][user_id]"><?=__("User ID")?></label>
            <div class="input">
                <?=$this->Form->input('Item.user_id', array('div' => false, 'error' => false, 'label' => false, 'id' => 'realname', 'type' => 'text', 'class' => 'form-control'))?><div id="results"></div>
            </div>
        </div>
    </fieldset>
        </div>
        <div class="col-md-12">
            <br/>
    <input type="hidden" name="data[Item][regvalue]" id="registrationbox" style="width: 200px;" disabled="disabled" />
    <div class="actions">
        <?=$this->Form->submit('Create', array('class' => 'btn btn-primary', 'div' => false))?>
    </div>
        </div>

</div>
</form>

<?php $this->Html->scriptStart( array('block' => 'bottom')); ?>
var element = document.getElementById("realname");
element.onkeypress = function(e){
if(e.keyCode == 13){
var value = element.value;
if(value.match("E") != "E"){
value = value.replace('%','');
value = value.replace('_','');
foundzero = true;
id = "";
for(var i = 0; i < value.length;i++){
if(value.charAt(i) == '0' && foundzero == true){

}else{
foundzero = false;
id += value.charAt(i);
}
}
element.value = id;
return false;
}
else{
element.value = "ERROR";
return false;
}
return false;
}
}
// Don't submit the entire form when scanning a serial number
$('#ItemSerialnumber').keypress(function(e) { if (e.keyCode == 13) { e.preventDefault(); } });
<?php $this->Html->scriptEnd(); ?>


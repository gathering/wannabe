<form id="addBadge" method="post">
<fieldset>
    <legend><?=__('Add new badge')?></legend>

    <div class="clearfix <? if($this->Form->error('Badge.type')) echo "error"; ?>">
        <label for="data[Badge][type]"><?=__('Type')?></label>
        <div class="input">
            <?=$this->Form->input('Badge.type', array('label' => false, 'div' => false, 'default' => 'crew'))?>
            <span class="help-block"><?=$this->Form->error('type')?></span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('Badge.user_id')) echo "error"; ?>">
        <label for="data[Badge][user_id]"><?=__('User id')?></label>
        <div class="input">
            <?=$this->Form->text('Badge.user_id', array('label' => false, 'div' => false)) ?>
            <span class="help-block"><?=$this->Form->error('user_id')?></span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('Badge.specification')) echo "error"; ?>">
        <label for="data[Badge][specification]"><?=__('Specification')?></label>
        <div class="input">
            <?=$this->Form->text('Badge.specification', array('label' => false, 'div' => false)) ?>
            <span class="help-block"><?=$this->Form->error('specification')?></span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('Badge.nfc_id')) echo "error"; ?>">
        <label for="data[Badge][nfc_id]"><?=__('NFC identfication')?></label>
        <div class="input">
            <?=$this->Form->text('Badge.nfc_id', array('label' => false, 'div' => false)) ?>
            <span class="help-block"><?=$this->Form->error('nfc_id')?></span>
        </div>
    </div>
</fieldset>

<div class="actions">
    <?=$this->Form->submit($savebutton, array('class' => 'btn success','name'=>'save'))?>
    <a href="<?=$this->Wb->eventUrl('/Badge')?>" class="btn"><?=__("Back")?></a>
</div>
</form>

<script type="text/javascript">
	$(function () {
        $('#BadgeSpecification').prop('disabled', true);

		$('#BadgeType').change(function () {
            console.log($(this).val());
			if($(this).val() != '0') {
				$('#BadgeUserId').prop('disabled',true);
			}else {
				$('#BadgeUserId').prop('disabled',false);
			}
            if($(this).val() == '5') {
                $('#BadgeSpecification').prop('disabled', false);
            }else{
                $('#BadgeSpecification').prop('disabled', true);
            }

		});

		$('#BadgeNfcId').keypress(function (e) {
			if(e.which === 13) {
				$('form#addBadge').submit();
			}
		});
	});
</script>
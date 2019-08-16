<?
$act = '';
switch ($action) {
	case 'deny':
		$act = __("deny");
		break;
	case 'accept':
		$act = __("accept");
		break;
}
$first = true;
?>

<form method="post" action="<?=$this->here?>?document_id=<?=$document['CfadApplicationDocument']['id']?>&amp;choice_id=<?=$choice['CfadApplicationChoice']['id']?>&amp;confirmed=1">
	<fieldset>
		<legend><?=__("Are you sure you want to %s the application to %s?", $act, $crews[$choice['CfadApplicationChoice']['crew_id']])?></legend>
        <div class="clearfix <? if(isset($invaliddate)) echo "error"; ?>">
			<? if($action == 'deny') { ?>
				<label for="data[denialmessage]"><?=__('Denial message')?></label>
				<div class="input">
					<textarea name="data[denialmessage]" class="xxlarge" rows="4"></textarea>
				</div>
			<? } ?>
			<? if($action == 'accept') { ?>
				<label for="data[day]"><?=__('Select day')?></label>
                <div class="input <? if(isset($invaliddate)) echo "error"; ?>">
                    <?=$this->Form->select('day', $dates, array('empty' => __("Date"), 'class' => 'span3', 'div' => false, 'error' => false, 'label' => false))?>
                    <span class="help-block"><? if(isset($invaliddate)) echo __("Date must be set"); ?></span>
				</div>
			<? } ?>
		</div>
		<div class="clearfix">
			<label><?=__('Go back to:')?></label>
			<div class="input">
				<select name="data[return_to]">
					<option value="/cfad" selected><?=__('List of crew applications')?></option>
					<option value="/cfad/Handle/view/<?=$document['User']['id']?>"><?=__('Current application')?></option>
				</select>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<input type="submit" value="<?=__("Yes")?>" class="btn" /> <a href="<?=$this->Wb->eventurl('/cfad/Handle/view/'.$document['User']['id'])?>" class="btn danger"><?=__('No')?></a>
	</div>
</form>

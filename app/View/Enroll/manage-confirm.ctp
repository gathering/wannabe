<?
$act = '';
switch ($action) {
	case 'deny':
		$act = __("deny");
		break;
	case 'accept':
		$act = __("accept");
		break;
	case 'waiting':
		$act = __("postpone, i.e. place on waiting list,");
	case 'disable':
		$act = __("disable");
}
$first = true;
?>

<form method="post" action="<?=$this->here?>?document_id=<?=$document['ApplicationDocument']['id']?>&amp;choice_id=<?=$choice['ApplicationChoice']['id']?>&amp;confirmed=1">
	<fieldset>
		<legend><?=__("Are you sure you want to %s the application to %s?", $act, $crews[$choice['ApplicationChoice']['crew_id']])?></legend>
		<div class="clearfix">
			<? if($action == 'accept') { ?>
				<label for="membertype"><?=__('Member type')?></label>
				<div class="input">
					<ul class="inputs-list">
						<?php foreach($userroles as $index => $role) { ?>
							<li>
								<label>
									<input type="radio" name="data[leader]" value="<?=$index?>" <?=$first?'checked':''?> />
									<span><?=$role?></span>
								</label>
							</li>
						<?php if($first) $first = false; } ?>
					</ul>
				</div>
			<? } ?>
			<? if($action == 'deny') { ?>
				<label for="data[denialmessage]"><?=__('Denial message')?></label>
				<div class="input">
					<textarea name="data[denialmessage]" class="xxlarge" rows="4"></textarea>
				</div>
			<? } ?>
			<? if($action == 'waiting') { ?>
				<label for="data[waitmessage]"><?=__('Waiting message')?></label>
				<div class="input">
					<textarea name="data[waitmessage]" class="xxlarge" rows="4"></textarea>
				</div>
			<? } ?>
		</div>
		<div class="clearfix">
			<label><?=__('Go back to:')?></label>
			<div class="input">
				<select name="data[return_to]">
					<option value="/enroll" selected><?=__('List of crew applications')?></option>
					<option value="/enroll/view/<?=$document['User']['id']?>"><?=__('Current application')?></option>
				</select>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<input type="submit" value="<?=__("Yes")?>" class="btn" /> <a href="<?=$this->Wb->eventurl('/Enroll/view/'.$document['User']['id'])?>" class="btn danger"><?=__('No')?></a>
	</div>
</form>

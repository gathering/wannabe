<form method="post">
	<fieldset>
		<legend><?=__("Edit %s-mail %s", $types[$mail['EnrollMail']['type']], $mail['EnrollMail']['subject'])?></legend>
		<?=$this->Form->hidden('EnrollMail.id', array('value' => $mail['EnrollMail']['id']))?>
		<div class="clearfix <? if($this->Form->error('EnrollMail.subject')) echo "error"; ?>">
			<label for="data[EnrollMail][subject]"><?=__("Subject")?></label>
			<div class="input">
				<?=$this->Form->input('EnrollMail.subject', array('div' => false, 'error' => false, 'label' => false, 'value' => $mail['EnrollMail']['subject']))?>
				<span class="help-block"><?=$this->Form->error('EnrollMail.subject')?></span>
			</div>
		</div>
		<div class="clearfix <? if($this->Form->error('EnrollMail.type')) echo "error"; ?>">
			<label for="data[EnrollMail][type]"><?=__("Type")?></label>
			<div class="input">
				<?=$this->Form->select('EnrollMail.type', $types, array('empty' => __("Choose"), 'div' => false, 'error' => false, 'value' => $mail['EnrollMail']['type']))?>
				<span class="help-block"><?=$this->Form->error('EnrollMail.type')?></span>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Save mail"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/EnrollAdmin')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>

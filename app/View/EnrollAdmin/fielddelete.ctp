<form method="post">
	<fieldset>
		<legend><?=__("Delete field %s", $field['EnrollMailfield']['name'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this field? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('EnrollMailfield.id', array('value' => $field['EnrollMailfield']['id']))?>
		<?=$this->Form->hidden('EnrollMailfield.enroll_mail_id', array('value' => $field['EnrollMailfield']['enroll_mail_id']))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/EnrollAdmin/mail/'.$field['EnrollMailfield']['enroll_mail_id'])?>" class="btn"><?=__("No")?></a>
	</div>
</form>

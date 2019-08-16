<form method="post">
	<fieldset>
		<legend><?=__("Delete %s-mail %s", $types[$mail['EnrollMail']['type']], $mail['EnrollMail']['subject'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this mail? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('EnrollMail.id', array('value' => $mail['EnrollMail']['id']))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/EnrollAdmin')?>" class="btn"><?=__("No")?></a>
	</div>
</form>

<form method="post">
	<fieldset>
		<legend><?=__("Delete term version %s", $term['Term']['version'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this term? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('Term.id', array('value' => $term['Term']['id']))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/TermAdmin')?>" class="btn"><?=__("No")?></a>
	</div>
</form>

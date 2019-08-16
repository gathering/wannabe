<form method="post">
	<fieldset>
		<legend><?=__("Delete %s", $crew['Crew']['name'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this crew? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('Crew.id', array('value' => $crew['Crew']['id']))?>
		<?=$this->Form->hidden('Crew.crew_id', array('value' => $crew['Crew']['crew_id']))?>
        <br/>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn btn-danger'))?> <a href="<?=$this->Wb->eventUrl('/CrewAdmin')?>" class="btn btn-default"><?=__("No")?></a>
	</div>
</form>

<h3>Legg til sak</h3>
<br />
<?=$this->Form->create( 'DispatchCase', array( 'url' => $this->Wb->eventUrl('/dispatch/createCase/') ) )?>

<fieldset>
<legend>Type problem</legend>
<?=$this->Form->select('problem_id', $problemnames, array())?>
</fieldset>

<fieldset>
<legend>Rad</legend>
<?=$this->Form->text('row', array('value' => $case['DispatchCase']['row']))?>
</fieldset>

<fieldset>
<legend>Sete</legend>
<?=$this->Form->text('seat', array('value' => $case['DispatchCase']['seat']))?>
</fieldset>

<fieldset>
<legend>Switch</legend>
<?=$this->Form->text('switch', array('value' => $case['DispatchCase']['switch']))?>
</fieldset>

<fieldset>
<legend>Beskrivelse</legend>
<?=$this->Form->textarea('description', array('class'=>'small', 'value' => $case['DispatchCase']['description']))?>
</fieldset>

<fieldset>
<legend>Prioritet</legend>
<?=$this->Form->select('priority', $priorities, array())?>
</fieldset>

<fieldset>
<legend>Deliger</legend>
<?=$this->Form->select('delegated_user_id', $delegatednames, array())?>
</fieldset>

<?=$this->Form->submit('Lagre', array('name'=>'save'))?>

<?=$this->Form->end()?>

<? var_dump($this->data); ?>
<? foreach ($page['CrewapplicationAvailablefield'] as $index => $field) { ?>
  <? foreach ($this->data['CrewapplicationChoice'] as $choice_id) { ?>
    <? if($choice_id['crew_id'] == 0) { return; } $index++; ?>
	<fieldset>
		<legend><?=$field['name']?> <?=$crews[$choice_id['crew_id']]?>?</legend>
		<span><?=$field['description']?></span>
		<?
		
		print $wb->hidden('CrewapplicationField/'.$index.'/id');
		print $wb->hidden('CrewapplicationField/'.$index.'/crew_id', array('value'=>$choice_id['crew_id']));
		print $wb->hidden('CrewapplicationField/'.$index.'/crewapplication_availablefield_id', array('value'=>$field['id']));

		switch ($field['CrewapplicationFieldtype']['name'])
		{
			case 'textarea':
				print $wb->textarea('CrewapplicationField/'.$index.'/value', array('style'=>'height:120px; width:300px', 'disabled' => $readonly));
				break;
		}
		
		?>
	</fieldset>

  <? } ?>
<? } ?>
<? debug($page); ?>
<? debug($this->data); ?>

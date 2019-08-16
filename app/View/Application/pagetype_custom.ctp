<? foreach ($page['CrewapplicationAvailablefield'] as $index => $field) { ?>

	<fieldset>
		<legend><?=$field['name']?></legend>
		<span><?=$field['description']?></span>
		<?

		print $wb->hidden('CrewapplicationField/'.$index.'/id');
		print $wb->hidden('CrewapplicationField/'.$index.'/crewapplication_availablefield_id', array('value'=>$field['id']));

		switch ($field['CrewapplicationFieldtype']['name'])
		{
			case 'textarea':
				print $wb->textarea('CrewapplicationField/'.$index.'/value', array('style'=>'height:120px; width:300px', 'class'=>'form-control','disabled' => $readonly));
				break;
		}

		?>
	</fieldset>

<? } ?>

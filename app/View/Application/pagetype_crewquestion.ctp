<?
$atleastonequestion = false;
?>
<?
$choicefields = array();
foreach($this->data['ApplicationChoice'] as $choice):
	foreach ($page['ApplicationAvailableField'] as $field):
		if($field['crew_id'] == $choice['crew_id']):
			if($choice['denied']) break;
			$atleastonequestion = true;
			$choicefields[] = $field;
		endif;
	endforeach;
endforeach;
if($atleastonequestion):
foreach ($choicefields as $field):
	switch ($field['ApplicationFieldType']['name']):
		case 'crewwhy':
			$index = -1;
			foreach($this->data['ApplicationField'] as $savedindex => $savedfield):
				if($savedfield['application_availablefield_id'] == $field['id']):
					$index = $savedindex;
				endif;
			endforeach;
			if($index == -1):
				$index = rand(10000,99999);
			endif;
			?><div class="clearfix">
				<label for="field_name"><?=__("From")?> <?=$crews[$field['crew_id']]?></label>
				<div class="input">
					<p><strong><?=$field['name']?></strong></p>
					<?
						print $this->Wb->hidden('ApplicationField.'.$index.'.id');
						print $this->Wb->hidden('ApplicationField.'.$index.'.application_availablefield_id', array('value'=>$field['id']));
						print $this->Wb->hidden('ApplicationField.'.$index.'.crew_id', null, false, $field['crew_id']);
						print $this->Wb->textarea('ApplicationField.'.$index.'.value', array('div' => false, 'class' => 'form-control', 'rows' => '3', 'disabled' => $readonly));
					?>
					<span class="help-block"><?=WbSanitize::clean($field['description'])?></span>
				</div>
			</div><?
		break;
	endswitch;
endforeach;
endif;
if(!$atleastonequestion): ?>
	<p><?=__("It looks like there is no custom questions from your selected crews. Press next to continue.")?></p>
<?
endif;
?>

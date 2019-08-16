<?php
/*<form>
	<fieldset>
		<label for="data[Carplate][carplate]"><?=__('Search')?></label>
		<div class="input">
			<input type="text" name="">
			<span class="help-block"><?=__("Search carplates")?></span>
		</div>
		<div class="input">
			<?=$this->Form->submit($searchbutton, array('class' => 'btn success', 'name' => 'search'))?>
		</div>
	</fieldset>

</form>
*/
?>

<h4><?=__('Registered carplates')?></h4>
<table class="zebra-striped condensed-table">
	<thead>
		<th><?=__('User ID')?></th>
		<th><?=__('Name')?></th>
		<th><?=__('Crew')?></th>
		<th><?=__('Carplate')?></th>
	</thead>
	<tbody>
		<?php
		foreach ($carplates as $carplate)
		{
			echo '<tr>
					<td>'.$carplate['Carplate']['user_id'].'</td>
					<td>'.$this->Wb->userLink($carplate).'</td>
					<td>'.$this->Wb->crewLink($carplate).'</td>
					<td>'.$carplate['Carplate']['carplate'].'</td>
				</tr>';
		}
		?>
	</tbody>
</table>
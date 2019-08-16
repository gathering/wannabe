<?php
?>
<table class="table table-striped">
<thead>
    <tr>
        <th width="15%"><b><?=__("User")?></b></th>
        <th width="30%"><b><?=__("Allergies")?></b></th>
        <th width="27%"><b><?=__("Other needs")?></b></th>
        <th width="10%"><b><?=__("Last Updated")?></b></th>
        <th width="18%"><b><?=__("Actions")?></b></th>
    </tr>
</thead>
<tbody>
<?php
foreach ($needs as $need) {
	
	//iterate through allergies for translation
	$allergies = explode(",", $need['Needs']['allergies']);
	$allergiesString = "";
	foreach ($allergies as $allergy){
		$allergiesString .= __($allergy, TRUE) . ", ";
	}
	
	$allergiesString = rtrim($allergiesString, ", ");
	
	echo '
	<tr>
		<td>'.$this->Wb->userLink($need).'</td>
        <td>'.h($allergiesString).'</td>
		<td>'.h($need['Needs']['nutritionalneeds']).'</td>
		<td style="width: 80px;">'.h($need['Needs']['updated_on']).'</td>
        <td style="width: 185px;">
            <a class="btn btn-danger" href="'.$this->Wb->eventUrl("/NeedsAdmin/deny/need:nutritional/user:".$need['User']['id']).'">'.__("Deny").'</a>
            <form action="'.$this->Wb->eventUrl('/Message/compose/from:2').'" method="POST" style="display: inline;">
                <input type="hidden" name="user_id" value="'.$need['User']['id'].'">
                <input type="hidden" name="subject" value="'.__("Message about your nutritional need").'">
                <input type="submit" class="btn" href="'.$this->Wb->eventUrl("/NeedsAdmin/message/".$need['User']['id']).'" value="'.__("Send message").'">
            </form>
        </td>
	</tr>';
}
?>
</tbody>
</table>

<table class="table table-striped">
<tr>
    <th width="30%"> <b><?=__("User")?> </b> </th>
    <th width="55%"> <b><?=__("Need")?> </b> </th>
    <th width="15%"> <b><?=__("Last Updated")?> </b></th>
</tr>
<?php
foreach ($needs as $need) {
	echo '
	<tr>
		<td>'.$this->Wb->userLink($need).'</td>
		<td>'.h($need['Needs']['medicalneeds']).'</td>
		<td style="width: 80px;">'.h($need['Needs']['updated_on']).'</td>
	</tr>';
}
?>
</table>

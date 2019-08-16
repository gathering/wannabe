<p>
<h2><?=__("Page “%s”", $page['CfadApplicationPage']['name'])?></h2>
</p>
<table>
	<thead>
		<tr>
			<th><?=__("Name")?></th>
			<th><?=__("Description")?></th>
			<th><?=__("Field Type")?></th>
			<th><?=__("Edit")?></th>
			<th><?=__("Delete")?></th>
		</tr>
	</thead>
<tbody>
<?
foreach($page['CfadApplicationAvailableField'] as $field):
	print "<tr><td>".$field['name']."</td>";
	print "<td>".$field['description']."</td>";
	print "<td>".$fieldtypes[$field['application_fieldtype_id']]."</td>";
	print "<td><a href='".$this->Wb->eventUrl('/cfad/CfadAdmin/field/'.$page['CfadApplicationPage']['id']."/".$field['id'])."' class='btn'>".__("Edit")."</a></td>";
	print "<td><a href='".$this->Wb->eventUrl('/cfad/CfadAdmin/deletefield/'.$field['id'])."' class='btn danger'>".__("Delete")."</a></td>";
endforeach;
?>
</tbody>
</table>
<p><a href="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/createfield/'.$page['CfadApplicationPage']['id'])?>" class="btn primary"><?=__("Create new field")?></a> <a href="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/page')?>" class="btn"><?=__("Back")?></a></p>

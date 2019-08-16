<p>
<h2><?=__("Page “%s”", $page['ApplicationPage']['name'])?></h2>
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
foreach($page['ApplicationAvailableField'] as $field):
	print "<tr><td>".$field['name']."</td>";
	print "<td>".$field['description']."</td>";
	print "<td>".$fieldtypes[$field['application_fieldtype_id']]."</td>";
	print "<td><a href='".$this->Wb->eventUrl('/ApplicationAdmin/field/'.$page['ApplicationPage']['id']."/".$field['id'])."' class='btn'>".__("Edit")."</a></td>";
	print "<td><a href='".$this->Wb->eventUrl('/ApplicationAdmin/deletefield/'.$field['id'])."' class='btn danger'>".__("Delete")."</a></td>";
endforeach;
?>
</tbody>
</table>
<p><a href="<?=$this->Wb->eventUrl('/ApplicationAdmin/createfield/'.$page['ApplicationPage']['id'])?>" class="btn primary"><?=__("Create new field")?></a> <a href="<?=$this->Wb->eventUrl('/ApplicationAdmin/page')?>" class="btn"><?=__("Back")?></a></p>

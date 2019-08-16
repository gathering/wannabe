<table>
	<thead>
		<tr>
			<th><?=__("Name")?></th>
			<th><?=__("Description")?></th>
			<th><?=__("Position")?></th>
			<th><?=__("Type")?></th>
			<th><?=__("Edit")?></th>
			<th><?=__("Settings")?></th>
			<th><?=__("Delete")?></th>
		</tr>
	</thead>
<tbody>
<?
foreach($pages as $page):
	print "<tr><td>".$page['ApplicationPage']['name']."</td>";
	print "<td>".$page['ApplicationPage']['description']."</td>";
	print "<td><center>".$page['ApplicationPage']['position']."</center></td>";
	print "<td><center>".$page['ApplicationPage']['type']."</center></td>";
	print "<td><a href='".$this->Wb->eventUrl('/ApplicationAdmin/page/'.$page['ApplicationPage']['id'])."' class='btn'>".__("Edit")."</a></td>";
	print "<td><a href='".$this->Wb->eventUrl('/ApplicationAdmin/field/'.$page['ApplicationPage']['id'])."' class='btn'>".__("Settings")."</a></td>";
	print "<td><a href='".$this->Wb->eventUrl('/ApplicationAdmin/deletepage/'.$page['ApplicationPage']['id'])."' class='btn danger'>".__("Delete")."</a></td></tr>";
endforeach;
?>
</tbody>
</table>
<p><a href="<?=$this->Wb->eventUrl('/ApplicationAdmin/createpage')?>" class="btn primary"><?=__("Create new page")?></a> <a href="<?=$this->Wb->eventUrl('/ApplicationAdmin/settings')?>" class="btn"><?=__("Settings for application")?></a></p>

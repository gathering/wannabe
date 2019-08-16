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
	print "<tr><td>".$page['CfadApplicationPage']['name']."</td>";
	print "<td>".$page['CfadApplicationPage']['description']."</td>";
	print "<td><center>".$page['CfadApplicationPage']['position']."</center></td>";
	print "<td><center>".$page['CfadApplicationPage']['type']."</center></td>";
	print "<td><a href='".$this->Wb->eventUrl('/cfad/CfadAdmin/page/'.$page['CfadApplicationPage']['id'])."' class='btn'>".__("Edit")."</a></td>";
	print "<td><a href='".$this->Wb->eventUrl('/cfad/CfadAdmin/field/'.$page['CfadApplicationPage']['id'])."' class='btn'>".__("Settings")."</a></td>";
	print "<td><a href='".$this->Wb->eventUrl('/cfad/CfadAdmin/deletepage/'.$page['CfadApplicationPage']['id'])."' class='btn danger'>".__("Delete")."</a></td></tr>";
endforeach;
?>
</tbody>
</table>
<p><a href="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/createpage')?>" class="btn primary"><?=__("Create new page")?></a> <a href="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/settings')?>" class="btn"><?=__("Settings for application")?></a></p>

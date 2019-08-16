<table>
	<tr>
		<th>#</th>
		<th><?=__("Name")?></th>
		<th><?=__("Title")?></th>
		<th><?=__("Left")?></th>
		<th><?=__("Active")?></th>
	</tr>

	<?php foreach($frontNews as $news): ?>
	<tr>
		<td><?=$this->Wb->eventLink($news['FrontNews']['id'], "/FrontNewsManager/edit/{$news['FrontNews']['id']}")?></td>
		<td><?=$news['FrontNews']['name']?></td>
		<td><?=$news['FrontNews']['title']?></td>
		<td><?=$news['FrontNews']['left_box']?></td>
		<td><?=$news['FrontNews']['active']?></td>
	</tr>
	<?php endforeach; ?>

</table>
	<a href="<?=$this->Wb->eventUrl('/FrontNewsManager/add')?>" class="btn success"><?=__("Create new")?></a>

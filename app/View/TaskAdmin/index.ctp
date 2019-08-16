<div class="row">
	<div class="span16">
		<h3><?=__("Create new task")?></h3>
		<a href="<?=$this->Wb->eventUrl("/TaskAdmin/Create")?>" class="btn primary"><?=__("Create new task")?></a>
	</div>
</div>
<div class="row">
	<div class="span16">
		<hr />
		<h3><?=__("Tasks")?></h3>
		<table class="zebra-striped bordered-table">
			<thead>
				<tr>
					<th><?=__("#")?></th>
                    <th><?=__("Name")?></th>
					<th><?=__("Enabled")?></th>
					<th><?=__("Allow sub")?></th>
					<th><?=__("Edit")?></th>
					<th><?=__("Delete")?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($tasks as $task) { ?>
					<tr>
						<td><?=$task['Task']['id']?></td>
						<td><?=$task['Task']['name']?></td>
						<td><?=$task['Task']['enabled']?__("Yes"):__("No")?></td>
						<td><?=$task['Task']['allow_sub']?__("Yes"):__("No")?></td>
						<td><a href="<?=$this->Wb->eventUrl("/TaskAdmin/Edit/{$task['Task']['id']}")?>" class="btn"><?=__("Edit")?></a></td>
						<td><a href="<?=$this->Wb->eventUrl("/TaskAdmin/Delete/{$task['Task']['id']}")?>" class="btn danger"><?=__("Delete")?></a></td>
					</tr>	
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

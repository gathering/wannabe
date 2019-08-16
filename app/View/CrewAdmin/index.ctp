<div class="row">
    <div class="col-md-12">
		<table class="table table-hover">
			<thead>
				<tr>
					<th><b><?=__("#")?></b></th>
					<th><b><?=__("Name")?></b></th>
					<th><b><?=__("Parent")?></b></th>
					<th><b><?=__("Application")?></b></th>
					<th><b><?=__("Hidden")?></b></th>
					<th><b><?=__("Edit")?></b></th>
					<th><b><?=__("Delete")?></b></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($crews as $crew) { ?>
					<tr>
						<td><?=$crew['Crew']['id']?></td>
						<td><a href="<?=$this->Wb->eventUrl("/Crew/Edit/{$crew['Crew']['name']}")?>"><?=$crew['Crew']['name']?></a></td>
						<td><?=$crew['Parentcrew']['id']?$crew['Parentcrew']['name']:__("None")?></td>
						<td><?=$crew['Crew']['canapply']?__("Open"):__("Closed")?></td>
						<td><?=$crew['Crew']['hidden']?__("Yes"):__("No")?></td>
						<td><a href="<?=$this->Wb->eventUrl("/Crew/Edit/{$crew['Crew']['name']}")?>" role="button" class="btn btn-default"><?=__("Edit")?></a></td>
						<td><a href="<?=$this->Wb->eventUrl("/CrewAdmin/Delete/{$crew['Crew']['id']}")?>" role="button" class="btn btn-danger"><?=__("Delete")?></a></td>
					</tr>	
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
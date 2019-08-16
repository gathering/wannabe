<div class="row">
	<div class="span16">
		<h3><?=__("Create new term")?></h3>
		<a href="<?=$this->Wb->eventUrl("/TermAdmin/Create")?>" class="btn primary"><?=__("Create new term")?></a>
	</div>
</div>
<div class="row">
	<div class="span16">
		<hr />
		<h3><?=__("Terms")?></h3>
		<table class="zebra-striped bordered-table">
			<thead>
				<tr>
					<th><?=__("#")?></th>
                    <th><?=__("Title")?></th>
					<th><?=__("Version")?></th>
					<th><?=__("Active")?></th>
					<th><?=__("Edit")?></th>
					<th><?=__("Delete")?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($terms as $term) { ?>
					<tr>
						<td><?=$term['Term']['id']?></td>
						<td><?=$term['Term']['title']?></td>
						<td><?=$term['Term']['version']?></td>
						<td><?=$term['Term']['active']?__("Yes"):__("No")?></td>
						<td><a href="<?=$this->Wb->eventUrl("/TermAdmin/Edit/{$term['Term']['id']}")?>" class="btn"><?=__("Edit")?></a></td>
						<td><a href="<?=$this->Wb->eventUrl("/TermAdmin/Delete/{$term['Term']['id']}")?>" class="btn danger"><?=__("Delete")?></a></td>
					</tr>	
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

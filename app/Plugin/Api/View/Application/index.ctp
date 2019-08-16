<div class="row">
	<div class="span16">
		<h3><?=__("Create new application")?></h3>
		<a href="<?=$this->Wb->eventUrl("/api/Application/add")?>" class="btn primary"><?=__("Create new application")?></a>
	</div>
</div>
<div class="row">
	<div class="span16">
		<h3><?=__("Applications")?></h3>
		<table>
			<tr>
				<th><?=__("Key")?></th>
				<th><?=__("Name")?></th>
				<th><?=__("Enabled")?></th>
				<th><?=__("Issued keys")?></th>
				<th><?=__("Edit")?></th>
				<th><?=__("Delete")?></th>
			</tr>
		<?php foreach($applications as $application) { ?>
			<tr>
				<td><?=$application['ApiApplication']['id']?></td>
				<td><?=$application['ApiApplication']['name']?></td>
                <? if($application['ApiApplication']['enabled']): ?>
                    <td class="green">✔</td>
                <? else: ?>
                    <td class="red">✘</td>
                <? endif; ?>
				<td><a href="<?=$this->Wb->eventUrl("/api/Application/keys/{$application['ApiApplication']['id']}")?>" class="btn info"><?=__("View keys")?></a></td>
				<td><a href="<?=$this->Wb->eventUrl("/api/Application/edit/{$application['ApiApplication']['id']}")?>" class="btn"><?=__("Edit")?></a></td>
				<td><a href="<?=$this->Wb->eventUrl("/api/Application/delete/{$application['ApiApplication']['id']}")?>" class="btn danger"><?=__("Delete")?></a></td>
			</tr>	
		<?php } ?>
		</table>
	</div>
</div>

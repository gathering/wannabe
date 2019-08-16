<div class="row">
	<div class="span16">
		<h3><?=__("Create new rule")?></h3>
		<a href="<?=$this->Wb->eventUrl("/PictureRule/add")?>" class="btn primary"><?=__("Create new rule")?></a>
	</div>
</div>
<div class="row">
	<div class="span16">
		<h3><?=__("Rules")?></h3>
		<table>
			<tr>
				<th><?=__("Rule")?></th>
				<th><?=__("Edit")?></th>
				<th><?=__("Delete")?></th>
			</tr>
		<?php foreach($rules as $rule) { ?>
			<tr>
				<td><?=$rule['PictureRule']['rule_text']?></td>
				<td><a href="<?=$this->Wb->eventUrl("/PictureRule/edit/{$rule['PictureRule']['id']}")?>" class="btn"><?=__("Edit")?></a></td>
				<td><a href="<?=$this->Wb->eventUrl("/PictureRule/delete/{$rule['PictureRule']['id']}")?>" class="btn danger"><?=__("Delete")?></a></td>
			</tr>	
		<?php } ?>
		</table>
	</div>
</div>

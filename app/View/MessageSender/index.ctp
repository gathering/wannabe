<div class="row">
	<div class="span16">
		<h3><?=__("Create new sender")?></h3>
		<a href="<?=$this->Wb->eventUrl("/MessageSender/add")?>" class="btn primary"><?=__("Create new sender")?></a>
	</div>
</div>
<div class="row">
	<div class="span16">
		<h3><?=__("Senders")?></h3>
		<table>
			<tr>
				<th><?=__("ID")?></th>
				<th><?=__("Name")?></th>
				<th><?=__("Email")?></th>
				<th><?=__("Edit")?></th>
				<th><?=__("Delete")?></th>
			</tr>
		<?php foreach($senders as $sender) { ?>
			<tr>
				<td><?=$sender['MessageSender']['id']?></td>
				<td><?=$sender['MessageSender']['name']?></td>
				<td><?=$sender['MessageSender']['email']?></td>
				<td><a href="<?=$this->Wb->eventUrl("/MessageSender/edit/{$sender['MessageSender']['id']}")?>" class="btn"><?=__("Edit")?></a></td>
				<td><a href="<?=$this->Wb->eventUrl("/MessageSender/delete/{$sender['MessageSender']['id']}")?>" class="btn danger"><?=__("Delete")?></a></td>
			</tr>	
		<?php } ?>
		</table>
	</div>
</div>

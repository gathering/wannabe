<div class="row">
	<div class="span16">
        <?php if(!empty($keys)): ?>
		<table class="zebra-striped bordered-table">
			<thead>
				<tr>
					<th><?=__("Key")?></th>
					<th><?=__("Issued")?></th>
					<th><?=__("Issuer")?></th>
					<th><?=__("Revoke access")?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($keys as $key) { ?>
					<tr>
						<td><?=$key['ApiKey']['apikey']?></td>
						<td><?=date("M j, Y G:i", strtotime($key['ApiKey']['created']))?></td>
                        <td><?=$key['ApiApplication']['name']?> – <?=$key['ApiApplication']['description']?></td>
						<td><a href="<?=$this->Wb->eventUrl("/api/Key/revoke/{$key['ApiKey']['id']}")?>" class="btn danger"><?=__("Revoke")?></a></td>
					</tr>	
				<?php } ?>
			</tbody>
        </table>
        <?php else: ?>
            <p><?=__("You have no API-keys.")?></p>
        <?php endif; ?>
	</div>
</div>

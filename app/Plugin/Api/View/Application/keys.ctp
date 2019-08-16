<div class="row">
	<div class="span16">
        <?php if(!empty($application['ApiKey'])): ?>
		<table class="zebra-striped bordered-table">
			<thead>
				<tr>
					<th><?=__("Key")?></th>
					<th><?=__("User")?></th>
					<th><?=__("Issued")?></th>
					<th><?=__("Active")?></th>
					<th><?=__("Revoke access")?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($application['ApiKey'] as $key) { ?>
					<tr>
						<td><?=$key['apikey']?></td>
                        <td><?=$this->Wb->userLink($key)?></td>
						<td><?=date("M j, Y G:i", strtotime($key['created']))?></td>
                        <? if(!$key['revoked']): ?>
                            <td class="green">✔</td>
                        <? else: ?>
                            <td class="red">✘</td>
                        <? endif; ?>
						<td><a href="<?=$this->Wb->eventUrl("/api/Application/keys/{$application['ApiApplication']['id']}/revoke/{$key['id']}")?>" class="btn danger"><?=__("Revoke")?></a></td>
					</tr>	
				<?php } ?>
			</tbody>
        </table>
        <?php else: ?>
            <p><?=__("This application has no issued API-keys.")?></p>
        <?php endif; ?>
	</div>
</div>

<?php App::uses('WbSanitize', 'Lib'); ?>
<form method="POST">
		<?php if(!empty($members)): ?>
			<table class="zebra-striped bordered-table">
                <thead>
                    <tr>
                        <th><?=__("Name")?></th>
                        <th><?=__("Crew")?></th>
                        <th><?=__("Day")?></th>
                        <th><?=__("Remove")?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($members as $index => $member): ?>
                        <tr>
                            <?=$this->Form->hidden('CfadUser.'.$index.'.id', array('value' => $member['CfadUser']['id']))?>
                            <td><?=$this->Wb->userLink($member)?></td>
                            <td><?=$this->Form->select('CfadUser.'.$index.'.crew_id', $crewnames, array('class' => 'span3', 'div' => false, 'error' => false, 'label' => false, 'value' => $member['Crew']['id']))?></td>
                            <td><?=$this->Form->select('CfadUser.'.$index.'.date', $dates, array('class' => 'span3', 'div' => false, 'error' => false, 'label' => false, 'value' => $member['CfadUser']['date']))?></td>
                            <td><?=$this->Wb->eventLink(__('Remove'), '/cfad/Member/remove/'.$member['CfadUser']['id'], array('class' => 'btn danger'))?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
			</table>
		<?php else: ?>
            <p><?=__("No members")?>.</p>
		<?php endif; ?>

		<a class="btn pull-right" href="#top"><?=__("&#x2191; To top")?></a>
		<?=$this->Form->submit(__('Save'), array('name' => 'save-members', 'class' => 'btn primary'))?>
</form>

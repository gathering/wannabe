<div class="row">
    <div class="span16">
		<? if ( is_array($members) && count($members) > 0 ) { ?>
			<table class="zebra-striped bordered-table">
				<tr>
                    <th>&nbsp;</th>
                    <th><?=__("Name")?></th>
                    <th><?=__("Terms & conditions")?></th>
                    <th><?=__("Picture")?></th>
                    <? foreach($tasks as $task): ?>
                        <th><?=$task['Task']['name']?></th>
                    <? endforeach; ?>
				</tr>
				<? $prevteam = -1; $canManageSomeMembers = false; ?>
				<? foreach ( $members as $member ) { $membertitle = $this->Wb->getUsertitleForCrew($member, $crew['Crew']['id']);?>
					<? if($prevteam != $member['Team']['id']) { $prevteam = $member['Team']['id']; ?>
						<tr><td colspan="8"><strong><? if($member['Team']['name'] == 'NO') { echo __("No teams"); } else { echo h($member['Team']['name'], null, "UTF-8"); } ?></strong></td></tr>
					<? } ?>
					<tr>
						<td>&nbsp;</td>
						<td><?=$this->Wb->userLink($member)?> (<?=strlen($member['CrewsUser']['title']) ? '<strong>'.$member['CrewsUser']['title'].'</strong>' : $membertitle?>)</td>
                        <? if(strtotime($member['UserTerm']['accepted']) > strtotime($term['Term']['updated'])): ?>
                            <td class="green">✔</td>
                        <? else: ?>
                            <td class="red">✘</td>
                        <? endif; ?>

                        <? if(isset($member['PictureApproval']['approved']) && $member['PictureApproval']['approved']): ?>
                            <td class="green">✔</td>
                        <? else: ?>
                            <td class="red">✘</td>
                        <? endif; ?>
                        <? foreach($tasks as $task): ?>
                            <? foreach($member['UserTask'] as $current): ?>
                                <? if($current['task_id'] == $task['Task']['id']): ?>
                                    <? if($current['completed']): ?>
                                        <td class="green">✔</td>
                                    <? else: ?>
                                        <td class="red">✘</td>
                                    <? endif; ?>
                                <? endif; ?>
                            <? endforeach; ?>
                        <? endforeach; ?>
					</tr>
				<? } ?>
			</table>
		<? } else { ?>
		<p><?=__("No members")?>.</p>
		<? } ?>

		<a class="btn pull-right" href="#top"><?=__("&#x2191; To top")?></a>
		<?=$canManageSomeMembers ? $this->Form->submit(__('Save'), array('name' => 'save-members', 'class' => 'btn primary')) : ''?>
</form>
</div>
</div>

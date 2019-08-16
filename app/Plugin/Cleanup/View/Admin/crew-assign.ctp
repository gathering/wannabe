<div class="row">
    <div class="span16">
        <?php if (empty($cleanups)): ?>
            <p><?=__('There are no active cleanups')?></p>  
        <?php else: ?>
            <table class="zebra-striped bordered-table">
                <thead>
                    <tr>
                        <th><?=__("Time")?></th>
                        <th><?=__("Assigned")?></th>
                        <th></th>
                    </tr>
                </thead>
            <?php foreach ($cleanups as $cleanup): ?>
                <tr>
                    <td class="moment format"><?= $cleanup['Cleanup']['unixtime'] ?></td>
                    <td>
                        <?=$cleanup['Cleanup']['cleanup_positions_upcoming'] + $cleanup['Cleanup']['cleanup_positions_completed']?>/<?=$cleanup['Cleanup']['maximum']?>
                        <?
                            $free = $cleanup['Cleanup']['maximum'] - $cleanup['Cleanup']['cleanup_positions_upcoming'] - $cleanup['Cleanup']['cleanup_positions_completed'];
                            echo "(" . ($free <= 0 ? __("Cleanup is full") : $free . " " . __("Available")) . ")";
                        ?>
                    </td>
                    <td class="buttongroup">
                        <a href="<?=$this->Wb->eventUrl("/Cleanup/Admin/assign/cleanup:" . $cleanup['Cleanup']['id'] . "/crew:" . $crew['Crew']['id'])?>" class="btn primary assign"><?=__('Assign members')?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>
        <?php endif; ?> 
        <?php if(!empty($members)): ?>
            <table class="zebra-striped bordered-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?=__("User")?></th>
                        <th><?=__("Time")?></th>
                        <th></th>
                    </tr>
                </thead>
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?=$member['User']['id']?></td>
                    <td><?=$this->Wb->userLink($member)?></td>
                    <?php if(isset($member['CleanupPosition']['completed']) && $member['CleanupPosition']['completed']): ?>
                        <td class="green">✔ <?=__("Completed")?></td>
                    <?php elseif(isset($member['Cleanup'])): ?>
                        <td class="moment format"><?=$member['Cleanup']['unixtime']?></td>
                    <?php else: ?>
                        <td class="red">✘ <?=__("Not set")?></td>
                    <?php endif; ?>
                    <td class="buttongroup">
                        <?php if(!isset($member['CleanupPosition']['completed']) || !$member['CleanupPosition']['completed']): ?>
                            <?php if(isset($member['Cleanup']['time'])): ?>
                                <a href="<?=$this->Wb->eventUrl('/Cleanup/Admin/remove/user:' . $member['User']['id'])?>" class="btn small error delete"><?=__('Delete')?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>

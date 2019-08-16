<div class="row">
    <div class="span16">
    <?php if (empty($cleanups)) { ?>
        <p><?=__('There are no active cleanups')?></p>  
    <?php } else { ?>
        <table class="zebra-striped bordered-table">
            <thead>
                <tr>
                    <th><?=__("Description")?></th>
                    <th><?=__("Time")?></th>
                    <th><?=__("Count")?></th>
                    <th><?=__("Assigned")?></th>
                    <th></th>
                </tr>
            </thead>
        <?php foreach ($cleanups as $cleanup) { ?>
            <tr>
                <td><?= $cleanup['Cleanup']['description'] ?></td>
                <td class="moment format"><?= $cleanup['Cleanup']['unixtime'] ?></td>
                <td>
                    <?=__("Total: %s, upcoming: %s, completed: %s", 
                        $cleanup['Cleanup']['cleanup_positions_upcoming'] + $cleanup['Cleanup']['cleanup_positions_completed'], 
                        $cleanup['Cleanup']['cleanup_positions_upcoming'], 
                        $cleanup['Cleanup']['cleanup_positions_completed']
                    )?>
                </td>
                <td>
                    <?=$cleanup['Cleanup']['cleanup_positions_upcoming'] + $cleanup['Cleanup']['cleanup_positions_completed']?>/<?=$cleanup['Cleanup']['maximum']?>
                </td>
                <td class="buttongroup">
                    <a href="<?=$this->Wb->eventUrl("/Cleanup/Register/view/cleanup:" . $cleanup['Cleanup']['id'])?>" class="btn primary assign"><?=__('Register')?></a>
                </td>
            </tr>
        <?php } ?>
        </table>
    <?php } ?> 
    </div>
</div>
<div class="row">
    <div class="span16">
        <?=__("%d completed cleanups of %d assigned of %s total in crew(not including exempt crews)", $cleanup_completed_count, $cleanup_count, $member_count)?>
    </div>
</div>

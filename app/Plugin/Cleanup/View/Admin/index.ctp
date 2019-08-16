<div class="row">
    <div class="span16">
        <a href="<?=$this->Wb->eventUrl("/Cleanup/Admin/add")?>" class="btn primary"><?=__("Add cleanup time")?></a>
        <a href="<?=$this->Wb->eventUrl("/Cleanup/Admin/exempt")?>" class="btn primary"><?=__("Exempt crews from cleanup")?></a>
        <a href="<?=$this->Wb->eventUrl("/Cleanup/Admin/Statistics")?>" class="btn error primary"><?=__('Statistics')?></a>
        <a href="<?=$this->Wb->eventUrl("/Cleanup/Admin/Search")?>" class="btn error primary"><?=__('Search')?></a>
    </div>
</div>
<div class="row">
    <div class="span16">
    <hr />
    <?php if (empty($cleanups)) { ?>
        <p><?=__('There are no active cleanups')?></p>  
    <?php } else { ?>
        <table class="zebra-striped bordered-table">
            <thead>
                <tr>
                    <th><?=__("Description")?></th>
                    <th><?=__("Time")?></th>
                    <th><?=__("Amounts")?></th>
                    <th></th>
                </tr>
            </thead>
        <?php foreach ($cleanups as $cleanup) { ?>
            <tr>
                <td><?= $cleanup['Cleanup']['description'] ?></td>
                <td class="moment format"><?= $cleanup['Cleanup']['unixtime'] ?></td>
                <td>
                    <?=__("Maximum: %s, total: %s, upcoming: %s, completed: %s", 
                        $cleanup['Cleanup']['maximum'],
                        $cleanup['Cleanup']['cleanup_positions_total'], 
                        $cleanup['Cleanup']['cleanup_positions_upcoming'], 
                        $cleanup['Cleanup']['cleanup_positions_completed']
                    )?>
                </td>
                <td class="buttongroup">
                    <a href="<?=$this->Wb->eventUrl("/Cleanup/Admin/assign/cleanup:" . $cleanup['Cleanup']['id'])?>" class="btn primary assign"><?=__('Assign')?></a>
                    <a href="<?=$this->Wb->eventUrl("/Cleanup/Admin/edit/" . $cleanup['Cleanup']['id'])?>" class="btn primary assign"><?=__('Edit')?></a>
                    <a href="<?=$this->Wb->eventUrl("/Cleanup/Admin/remove/cleanup:" . $cleanup['Cleanup']['id'])?>" class="btn error delete"><?=__('Delete')?></a>
                </td>
            </tr>
        <?php } ?>
        </table>
    <?php } ?> 
    </div>
</div>
<div class="row">
    <div class="span16">
        <hr />
        <?=__("%d completed cleanups of %d assigned of %s total in crew(not including exempt crews)", $cleanup_completed_count, $cleanup_count, $member_count)?>
    </div>
</div>

<div class="row">
    <div class="span16">
        <?php if (empty($cleanups)) { ?>
            <p><?=__('There are no active cleanups')?></p>  
        <?php } else { ?>
            <table class="zebra-striped bordered-table">
                <thead>
                    <tr>
                        <th><?=__("Crew")?></th>
                        <th><?=__("Total")?></th>
                        <th><?=__("Assigned")?></th>
                        <th><?=__("Missing")?></th>
                        <th><?=__("Completed")?></th<
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($crew_stats as $crew_name=>$stats) { ?>
                <?php if ($stats['total'] != 0) { ?>
                    <tr>
                        <td><?= $crew_name ?></td>
                        <td><?= $stats['total'] ?></td>
                        <td><?= $stats['assigned'] ?></td>
                        <td><?= $stats['total']-$stats['assigned'] ?></td>
                        <td><?= $stats['completed'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>
<hr />
<div class="row">
    <div class="span16">
        <a href="<?=$this->Wb->eventUrl('/Cleanup/Admin')?>" class="btn default"><?=__('Back')?></a>
    </div>
</div>

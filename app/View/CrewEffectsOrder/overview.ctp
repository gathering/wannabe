<?php
if(in_array(true, $acl)) {
?>
<div class="row">
    <div class="col-md-12">
        <h3><?=__("Actions")?></h3>
        <?php if($acl['economy']) {?><a href="<?=$this->Wb->eventUrl('/CrewEffectsOrder/economy')?>" class="btn btn-primary"><?=__("Register payments")?></a><?php } ?>
        <?php if($acl['logistic']) {?><a href="<?=$this->Wb->eventUrl('/CrewEffectsOrder/logistics/free')?>" class="btn btn-primary"><?=__("Deliver free effects")?></a>
        <a href="<?=$this->Wb->eventUrl('/CrewEffectsOrder/logistics/extra')?>" class="btn btn-primary"><?=__("Deliver extra effects")?></a><?php } ?>
        <?php if($acl['items']) {?><a href="<?=$this->Wb->eventUrl('/CrewEffectsItems/')?>" class="btn btn-primary"><?=__("View items")?></a><?php } ?>
    </div>
</div>
<br />
<hr />
<?php } ?>
<h3>Overview</h3>
<div class="row">
    <div class="col-md-12">
    <?php foreach($data as $datakey => $entry) { ?>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <?php foreach($entry as $entrykey => $item) { ?>
                    <th><?=$entrykey?></th>
                <?php } ?>
           </tr>
            </thead>
            <tbody>
            <tr>
                <?php foreach($entry as $entrykey => $item) { ?>
                    <?php if($entrykey == 'Title') { ?>
                        <td><strong><?=$item?></strong></td>
                    <?php } else { ?>
                    <td><?=$item['free']?> <?=__("(free)")?>, <?=$item['extra']?> <?=__("(extra)")?></td>
                    <?php } ?>
                <?php } ?>
            </tr>
            </tbody>
        </table>
    <?php } ?>
    </div>
</div>

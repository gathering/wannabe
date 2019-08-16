<div class="row">
    <div class="span16">
    <?php if (empty($cleaners)) { ?>
        <p><?=__('There are no cleaners assigned.')?></p>  
    <?php } else { ?>
        <table class="zebra-striped bordered-table">
            <thead>
                <tr>
                    <th><?=__("User")?></th>
                    <th><?=__("Comment")?></th>
                    <th></th>
                </tr>
            </thead>
        <?php foreach ($cleaners as $cleaner) { ?>
            <tr>
                <form method="post">
                    <?= $this->Form->input('CleanupPosition.id', array('div' => false, 'error' => false, 'label' => false, 'hidden' => true, 'value' => $cleaner['CleanupPosition']['id'])) ?>
                    <td><?= $cleaner['User']['realname'] . " (#" . $cleaner['User']['id'] . ")" ?></td>
                    <td><?= $this->Form->input('CleanupPosition.comment', array('div' => false, 'error' => false, 'label' => false, 'value' => $cleaner['CleanupPosition']['comment'])) ?></td>
                    <td class="buttongroup">
                        <?php if ($cleaner['CleanupPosition']['completed']) { ?>
                            <?= $this->Form->submit(__('Undo'), array('class' => 'btn success', 'name'=>'undo')) ?>
                        <?php } else { ?>
                            <?= $this->Form->submit(__('Completed'), array('class' => 'btn error', 'name'=>'completed')) ?>
                        <?php } ?>
                    </td>
                </form>
            </tr>
        <?php } ?>
        </table>
    <?php } ?> 
        <div class="actions">
            <a href="<?=$this->Wb->eventUrl('/Cleanup')?>" class="btn default"><?=__('Back')?></a>
        </div>
    </div>
</div>

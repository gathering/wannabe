<div class="row">
    <div class="col-md-12">
        <form method="post">
            <fieldset>
                <legend><?= __("Delete %s", $list['Mailinglist']['address']) ?></legend>
                <div class="input"><?= __("Are you sure you want to delete this list? This action cannot be undone") ?></div>
            </fieldset>
            <div class="actions">
                <?= $this->Form->hidden('Mailinglist.id', array('value' => $list['Mailinglist']['id'])) ?>
                <?= $this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn btn-danger')) ?>
                <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin') ?>" class="btn btn-default"><?= __("No") ?></a>
            </div>
        </form>
    </div>
</div>
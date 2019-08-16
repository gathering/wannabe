<div class="row">
    <div class="col-md-12">
        <form method="post">
            <fieldset>
                <legend><?= __("Delete rule") ?></legend>
                <div class="input"><?= __("Are you sure you want to delete this rule? This action cannot be undone") ?></div>
            </fieldset>
            <br/>
            <div class="actions">
                <?= $this->Form->hidden('Mailinglistrule.id', array('value' => $rule['Mailinglistrule']['id'])) ?>
                <?= $this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn btn-danger')) ?>
                <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/Rule/' . $list) ?>" class="btn btn-default"><?= __("No") ?></a>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form method="post">
            <fieldset>
                <legend><?= __("Create new rule for %s", $list['Mailinglist']['address']) ?></legend>
                <?= $this->Form->hidden('MailinglistruleUser.mailinglist_id', array('value' => $list['Mailinglist']['id'])) ?>
                <div class="form-group">
                    <label for="data[MailinglistruleUser][user_id]"><?= __("User ID") ?></label>
                    <div class="input">
                        <?= $this->Form->text('MailinglistruleUser.user_id', array('div' => false, 'error' => false, 'class' => 'form-control')) ?>
                        <span class="help-block"><?= $this->Form->error('MailinglistruleUser.user_id') ?></span>
                    </div>
                </div>
            </fieldset>
            <div class="actions">
                <?= $this->Form->submit(__("Create rule"), array('div' => false, 'label' => false, 'class' => 'btn btn-success')) ?>
                <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/Rule/' . $list['Mailinglist']['address']) ?>" class="btn btn-default"><?= __("Back") ?></a>
            </div>
        </form>
    </div>
</div>

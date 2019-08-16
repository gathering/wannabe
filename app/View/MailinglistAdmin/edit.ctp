<div class="row">
    <div class="col-md-12">
        <form method="post">
            <fieldset>
                <legend><?= __("Edit %s", $list['Mailinglist']['address']) ?></legend>
                <?= $this->Form->hidden('Mailinglist.id', array('value' => $list['Mailinglist']['id'])) ?>
                <div class="form-group">
                    <label for="data[Mailinglist][address]"><?= __("Address") ?></label>
                    <div class="input">
                        <?= $this->Form->input('Mailinglist.address', array('div' => false, 'error' => false, 'label' => false, 'value' => $list['Mailinglist']['address'], 'class' => 'form-control')) ?>
                        <span class="help-block"><?= $this->Form->error('Mailinglist.address') ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="data[Mailinglist][moderatorpassword]"><?= __("Moderator password") ?></label>
                    <div class="input">
                        <?= $this->Form->input('Mailinglist.moderatorpassword', array('div' => false, 'error' => false, 'label' => false, 'value' => $list['Mailinglist']['moderatorpassword'], 'class' => 'form-control')) ?>
                        <span class="help-block"><?= $this->Form->error('Mailinglist.moderatorpassword') ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="data[Mailinglist][crew_id]"><?= __("Administrative crew") ?></label>
                    <div class="input">
                        <?= $this->Form->select('Mailinglist.crew_id', $crews, array('empty' => __("Choose"), 'div' => false, 'error' => false, 'value' => $list['Mailinglist']['crew_id'], 'class' => 'form-control')) ?>
                        <span class="help-block"><?= $this->Form->error('Mailinglist.crew_id') ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="data[Mailinglist][optional]"><?= __("Options") ?></label>
                    <div class="checkbox">
                        <ul class="inputs-list">
                            <li>
                                <label>
                                    <?= $this->Form->checkbox('Mailinglist.optional', array('div' => false, 'error' => false, 'checked' => $list['Mailinglist']['optional'])) ?>
                                    <span><?= $this->Form->error('Mailinglist.optional') ? $this->Form->error('Mailinglist.optional') : __("Make optional") ?></span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </fieldset>
            <div class="actions">
                <?= $this->Form->submit(__("Save list"), array('div' => false, 'label' => false, 'class' => 'btn btn-success')) ?>
                <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin') ?>" class="btn"><?= __("Back") ?></a>
            </div>
        </form>
    </div>
</div>
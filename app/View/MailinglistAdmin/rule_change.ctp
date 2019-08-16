<div class="row">
    <div class="col-md-12">
        <form method="post">
            <fieldset>
                <legend><?= __("Edit rule for %s for %s", $crews[$rule['Mailinglistrule']['crew_id']], $list['Mailinglist']['address']) ?></legend>
                <?= $this->Form->hidden('Mailinglistrule.mailinglist_id', array('value' => $list['Mailinglist']['id'])) ?>
                <?= $this->Form->hidden('Mailinglistrule.id', array('value' => $rule['Mailinglistrule']['id'])) ?>
                <div class="form-group">
                    <label for="data[Mailinglistrule][crew_id]"><?= __("Crew") ?></label>
                    <div class="input">
                        <?= $this->Form->select('Mailinglistrule.crew_id', $crews, array('empty' => __("Choose"), 'div' => false, 'error' => false, 'value' => $rule['Mailinglistrule']['crew_id'], 'class' => 'form-control')) ?>
                        <span class="help-block"><?= $this->Form->error('Mailinglistrule.crew_id') ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="data[Mailinglistrule][leader]"><?= __("Level") ?></label>
                    <div class="input">
                        <?= $this->Form->select('Mailinglistrule.leader', $roles, array('empty' => __("Choose"), 'div' => false, 'error' => false, 'value' => $rule['Mailinglistrule']['leader'], 'class' => 'form-control')) ?>
                        <span class="help-block"><?= $this->Form->error('Mailinglistrule.leader') ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="data[Mailinglistrule][enable_moderator]"><?= __("Options") ?></label>
                    <div class="checkbox">
                        <ul class="inputs-list">
                            <li>
                                <label>
                                    <?= $this->Form->checkbox('Mailinglistrule.enable_moderator', array('div' => false, 'error' => false, 'checked' => $rule['Mailinglistrule']['enable_moderator'])) ?>
                                    <span><?= $this->Form->error('Mailinglistrule.enable_moderator') ? $this->Form->error('Mailinglistrule.enable_moderator') : __("Enable moderator for this rule") ?></span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </fieldset>
            <div class="actions">
                <?= $this->Form->submit(__("Edit rule"), array('div' => false, 'label' => false, 'class' => 'btn btn-success')) ?>
                <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/Rule/' . $list['Mailinglist']['address']) ?>" class="btn btn-default"><?= __("Back") ?></a>
            </div>
        </form>
    </div>
</div>
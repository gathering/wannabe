<div class="row">
    <div class="col-md-6">
        <h3><?= __("Create new list") ?></h3>
        <a href="<?= $this->Wb->eventUrl("/MailinglistAdmin/Create") ?>" class="btn btn-primary"><?= __("Create new list") ?></a>
    </div>
    <div class="col-md-6">
        <h3><?= __("Lookup user membership") ?></h3>
        <form class="form-horizontal" method="GET" action="<?= $this->Wb->eventUrl("/MailinglistAdmin/Membership/") ?>">
            <div class="form-group">
                <div class="col-sm-4">
                    <input name="user_id" class="form-control" type="text" id="user_id" placeholder="<?= __("User ID") ?>">
                </div>
                <div class="col-sm-3">
                    <?= $this->Form->submit(__("Lookup"), array('class' => 'btn btn-success', 'div' => false, 'label' => false)) ?>
                </div>
            </div>

        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><b><?= __("List") ?></b></th>
                    <th><b><?= __("Show rules/members") ?></b></th>
                    <th><b><?= __("Edit") ?></b></th>
                    <th><b><?= __("Delete") ?></b></th>
                </tr>
            </thead>
            <?php foreach ($mailinglists as $id => $mailinglist) { ?>
                <tr>
                    <td><?= $mailinglist ?></td>
                    <td><a href="<?= $this->Wb->eventUrl("/MailinglistAdmin/Rule/{$mailinglist}") ?>" class="btn btn-default"><?= __("Show rules/members") ?></a></td>
                    <td><a href="<?= $this->Wb->eventUrl("/MailinglistAdmin/Edit/{$id}") ?>" class="btn btn-default"><?= __("Edit") ?></a></td>
                    <td><a href="<?= $this->Wb->eventUrl("/MailinglistAdmin/Delete/{$id}") ?>" class="btn btn-danger"><?= __("Delete") ?></a></td>
                </tr>
            <?php } ?>
        </table>
        </div>
    </div>
</div>

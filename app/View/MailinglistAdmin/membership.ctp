<div class="row">
    <div class="col-md-12">
        <?php if (empty($lists)) { ?>
            <p><?= __("User not signed up for any lists") ?></p>
        <?php } else { ?>
            <ul>
                <?php foreach ($lists as $list) { ?>
                    <li>
                        <?= $list['Mailinglistaddress']['mailinglist'] ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <br>
        <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin') ?>" class="btn btn-default"><?= __("Back") ?></a>
    </div>
</div>
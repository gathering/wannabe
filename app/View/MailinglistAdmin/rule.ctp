<div class="row">
    <div class="col-md-12">
        <p>
            <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/RuleCreate/crew/' . $list['Mailinglist']['address']) ?>" class="btn btn-primary"><?= __("Create new crew rule") ?></a>
            <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/RuleCreate/team/' . $list['Mailinglist']['address']) ?>" class="btn btn-primary"><?= __("Create new team rule") ?></a>
            <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/RuleCreate/user/' . $list['Mailinglist']['address']) ?>" class="btn btn-primary"><?= __("Create new user rule") ?></a>
            <?php if (empty($crewnewRules)) { ?>
                <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/RuleCreate/crewnew/' . $list['Mailinglist']['address']) ?>" class="btn btn-primary"><?= __("Add all new crew members") ?></a>
            <?php } ?>
            <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/') ?>" class="btn btn-default"><?= __("Back") ?></a>
        </p>
        <hr/>
        <h3><?= __("Existing rules for this mailinglist") ?> </h3>
        <?php
        $count = count($rules);
        switch ($count) {
            case 0:
                $count_text = "";
                break;
            case 1:
                $count_text = $count . " " . strtolower(__("Rule"));
                break;
            default:
                $count_text = $count . " " . strtolower(__("Rules"));
                break;
        }
        ?>
        <h4><?= __("Crews") ?>
            <small> <?= $count_text ?> </small>
        </h4>
        <?php if (!empty($rules)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><b><?= __("Crew") ?></b></th>
                        <th><b><?= __("Level") ?></b></th>
                        <th><b><?= __("Change level") ?></b></th>
                        <th><b><?= __("Delete") ?></b></th>
                    </tr>
                    </thead>
                    <?php foreach ($rules as $rule) { ?>
                        <tr>
                            <td><?= $crews[$rule['Mailinglistrule']['crew_id']] ?></td>
                            <td><?= $roles[$rule['Mailinglistrule']['leader']] ?></td>
                            <td>
                                <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/RuleChange/' . $list['Mailinglist']['address'] . '/' . $rule['Mailinglistrule']['id']) ?>" class="btn btn-default"><?= __("Change") ?></a></td>
                            <td>
                                <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/RuleDelete/crew/' . $list['Mailinglist']['address'] . '/' . $rule['Mailinglistrule']['id']) ?>" class="btn btn-danger"><?= __("Delete") ?></a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } else { ?>
            <p><?= __("No crew rules") ?></p>
        <?php }
        $count = count($teamRules);
        switch ($count) {
            case 0:
                $count_text = "";
                break;
            case 1:
                $count_text = $count . " " . strtolower(__("Rule"));
                break;
            default:
                $count_text = $count . " " . strtolower(__("Rules"));
                break;
        }
        ?>
        <hr/>
        <h4><?= __("Teams") ?>
            <small> <?= $count_text ?> </small>
        </h4>
        <?php if (!empty($teamRules)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><b><?= __("Team") ?></b></th>
                        <th><b><?= __("Delete") ?></b></th>
                    </tr>
                    </thead>
                    <?php foreach ($teamRules as $rule) { ?>
                        <tr>
                            <td><?= $teams[$rule['MailinglistruleTeam']['team_id']] ?></td>
                            <td>
                                <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/RuleDelete/team/' . $list['Mailinglist']['address'] . '/' . $rule['MailinglistruleTeam']['id']) ?>" class="btn btn-danger"><?= __("Delete") ?></a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } else { ?>
            <p><?= __("No team rules") ?></p>
        <?php }
        $count = count($userRules);
        switch ($count) {
            case 0:
                $count_text = "";
                break;
            case 1:
                $count_text = $count . " " . strtolower(__("Rule"));
                break;
            default:
                $count_text = $count . " " . strtolower(__("Rules"));
                break;
        }
        ?>
        <hr/>
        <h4><?= __("Users") ?>
            <small> <?= $count_text ?> </small>
        </h4>
        <?php if (!empty($userRules)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><b><?= __("User") ?></b></th>
                        <th><b><?= __("Username") ?></b></th>
                        <th><b><?= __("Delete") ?></b></th>
                    </tr>
                    </thead>
                    <?php foreach ($userRules as $rule) { ?>
                        <tr>
                            <td><?= $rule['User']['realname'] ?></td>
                            <td><?= $rule['User']['username'] ?></td>
                            <td>
                                <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/RuleDelete/user/' . $list['Mailinglist']['address'] . '/' . $rule['MailinglistruleUser']['id']) ?>" class="btn btn-danger"><?= __("Delete") ?></a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } else { ?>
            <p><?= __("No user rules") ?></p>
        <?php } ?>
        <hr/>
        <h4><?= __("New crew members") ?></h4>
        <?php if (!empty($crewnewRules)) { ?>
            <?php foreach ($crewnewRules as $rule) { ?>
                <p><?= __("New crew members are added to this list") ?></p>
                <p>
                    <a href="<?= $this->Wb->eventUrl('/MailinglistAdmin/RuleDelete/crewnew/' . $list['Mailinglist']['address'] . '/' . $rule['MailinglistruleCrewnew']['id']) ?>" class="btn btn-danger"><?= __("Remove") ?></a></p>
            <?php } ?>
        <?php } else { ?>
            <p><?= __("New crew members are not added to this list") ?></p>
        <?php } ?>
        <hr/>
        <h3><?= __("Members") ?>
            <small><?= __("%s members total", count($members) + count($membersCrewnew)) ?></small>
        </h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><b><?= __("Name") ?></b></th>
                    <th><b><?= __("Username") ?></b></th>
                    <th><b><?= __("Email") ?></b></th>
                </tr>
                </thead>
                <?php foreach ($members as $member) { ?>
                    <tr>
                        <td><?= $member['u']['realname'] ?></td>
                        <td><?= $member['u']['username'] ?></td>
                        <td><?= $member['u']['address'] ?></td>
                    </tr>
                <?php } ?>
                <?php foreach ($membersCrewnew as $member) { ?>
                    <tr>
                        <td><?= $member['MailinglistaddressCrewnew']['realname'] ?></td>
                        <td><?= $member['MailinglistaddressCrewnew']['username'] ?></td>
                        <td><?= $member['MailinglistaddressCrewnew']['address'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <h3><?=__("Optional lists")?></h3>
        <?php if(!empty($optional)) { ?>
        <form method="post">
        <fieldset>
            <div class="clearfix">
                <label id="optionscheckboxes" for="data[UserMailpref][subscribe]"><?=__('Signed up for…')?></label>
                <div class="input">
                    <ul class="inputs-list">
                        <?php foreach($optional as $list) { ?>
                            <li>
                                <label>
                                    <?=$this->Form->hidden('UserMailpref.'.$list['UserMailpref']['id'].'.id', array('value' => $list['UserMailpref']['id']))?>
                                    <?=$this->Form->hidden('UserMailpref.'.$list['UserMailpref']['id'].'.mailinglist_id', array('value' => $list['MailinglistaddressesNotopt']['mailinglist_id']))?>
                                    <?=$this->Form->checkbox('UserMailpref.'.$list['UserMailpref']['id'].'.subscribe', array('div' => 'false', 'checked' => $list['UserMailpref']['subscribe']))?>
                                    <span><?=$list['MailinglistaddressesNotopt']['mailinglist']?></span>
                                </label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </fieldset>
        <div class="actions">
            <?=$this->Form->submit(__("Save settings"), array('class' => 'btn success','name'=>'save'))?>
        </div>
        </form>
        <?php foreach($optional as $list) { ?>
            <?php if(!$list['UserMailpref']['subscribe'] && isset($list['MailmanPassword'])) { ?>
                <form method="post" name="f" action="https://lists.gathering.org/private/<? $mailman = preg_split('/\@/', $list['MailinglistaddressesNotopt']['mailinglist']); echo $mailman[0]; ?>/">
                    <input type="hidden" name="username" value="<?=$list['MailmanPassword']['email']?>" id="username">
                    <input type="hidden" name="password" value="<?=$list['MailmanPassword']['password']?>" id="password">
                    <?=$this->Form->submit(__("Enter archive for %s", $list['MailinglistaddressesNotopt']['mailinglist']), array('class' => 'btn','name'=>'submit'))?>
                </form>
            <?php } ?>
        <?php } ?>
        <?php } else { ?>
        <p><?=__("No optional lists")?></p>
        <?php } ?>
    </div>
    <div class="col-md-8">
        <h3>Information about the mailing lists</h3>
        <p>As a crew member you have access to and are subscribed to several mailing lists. These lists are used to spread informasjon to all crew members, and as a discussion forum for the different crews and teams. In the form to the left you can unsubscribe from optional lists. Please note that it can take up to one hour for changes to apply.</p>
        <h4>Email conduct</h4>
        <p>Common sense and normal conduct is expected when using the mailing lists. There are a high number of subscribed crew members on the lists, and you should therefore keep in mind that it is important that your email should be understood by any and all who reads it. Take some time to familiarize yourself with rules on quoting and general mailing behaviour.</p>
        <h4>Pjatt</h4>
        <p><a href="mailto:tgpjatt@gathering.org">tgpjatt@gathering.org</a> is a list for discussion about anything, also things not related to TG. It's opt-in and available for all, even those not in crew. Be warned, it is a highly active mailing list with over a thousand emails per year. You can subscribe by sending an empty email to <a href="mailto:tgpjatt-subscribe@gathering.org">tgpjatt-subscribe@gathering.org</a>, and unsubscribe by sending an empty email to <a href="mailto:tgpjatt-unsubscribe@gathering.org">tgpjatt-unsubscribe@gathering.org</a>. Keep in mind that you will be required to reply when recieving email for (un)subscribing. Otherwise nothing will happen. Normal email conduct also applies to this list.</p>
    </div>
</div>
<hr />
<div class="row">
    <div class="span16">
        <h3><?=__("Subscribed lists")?></h3>
        <?php if(!empty($lists)) { ?>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th><b><?=__("Name")?> </b></th>
                    <?php if($isModerator) { ?><th><b><?=__("Moderation password")?></b></th><? } ?>
                    <th><b><?=__("Archive")?></b></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($lists as $list) { ?>
                    <tr>
                        <td><?=$list['Mailinglistaddresses']['mailinglist']?></td>
                        <?php if($isModerator) { ?><td><?php if(isset($list['Mailinglistmoderator'])) { echo $list['Mailinglistmoderator']['moderatorpassword']; } ?>&nbsp;</td><? } ?>
                        <td>
                            <?php if(isset($list['MailmanPassword'])) { ?>
                                <form method="post" name="f" action="https://lists.gathering.org/private/<? $mailman = preg_split('/\@/', $list['MailmanPassword']['mailinglist']); echo $mailman[0]; ?>/">
                                    <input type="hidden" name="username" value="<?=$list['MailmanPassword']['email']?>" id="username">
                                    <input type="hidden" name="password" value="<?=$list['MailmanPassword']['password']?>" id="password">
                                    <?=$this->Form->submit(__("Archive"), array('class' => 'btn','name'=>'submit'))?>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
        <p><?=__("No subscribed lists")?></p>
        <?php } ?>
    </div>
</div>

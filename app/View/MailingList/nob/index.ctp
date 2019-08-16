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
        <h3>Informasjon om e-postlistene</h3>
        <p>Som frivillig medlem har du tilgang og er påmeldt en rekke e-postlister. Disse brukes til å spre informasjon til medlemmene og som diskusjonsfora for de forskjellige gruppene. Til venste finner du et skjema hvor du kan melde deg av valgfrie lister. Det kan ta opptil én time før endringen skjer.</p>
        <h4>Skikk og bruk</h4>
        <p>Sunn fornuft og normal oppførsel er forventet ved bruk av listene. Det er svært mange medlemmer på listene, og du bør derfor tenke på at din e-post skal bli forstått. Ta deg derfor tid til å lese gjennom <a href="http://trivini.no/epost/" target="_blank">denne siden</a>, som omhandler dette. Du bør også ta deg tid til å sette deg inn i hvordan man <a href="http://antobiomatika.net/usenet/quoting.html" target="_blank">siterer korrekt</a>.</p>
        <h4>Pjattlista</h4>
        <p>Pjattlista er en liste der man prater om alt mulig rart, også ting ikke relatert til TG. Den er åpen for alle, også de som ikke er crewmedlemmer. Vær advart, det kommer <em>mye</em> e-post der (mange tusen i året). For å melde deg på listen kan du sende en tom e-post til <a href="mailto:tgpjatt-subscribe@gathering.org">tgpjatt-subscribe@gathering.org</a>. Du kan melde deg av igjen ved å sende en tom e-post til <a href="mailto:tgpjatt-unsubscribe@gathering.org">tgpjatt-unsubscribe@gathering.org</a>. Merk deg at du må svare på e-posten du får ved av- og påmelding, ellers skjer ingenting. Regler for skikk og bruk gjelder også denne listen.</p>
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
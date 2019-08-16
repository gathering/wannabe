<div class="row">
    <div class="span8">
        <h4><?=__("Crew")?></h3>
        <a href="<?=$this->Wb->eventUrl("/SmsMessage/all")?>" class="btn "><?=__("All crew members")?></a>
        <a href="<?=$this->Wb->eventUrl("/SmsMessage/teams")?>" class="btn "><?=__("Specific crew")?></a>
        <a href="<?=$this->Wb->eventUrl("/SmsMessage/real_teams")?>" class="btn "><?=__("Specific team")?></a>
    </div>
    <div class="span8">
        <h4><?=__("Cleanup")?></h3>
        <a href="<?=$this->Wb->eventUrl("/SmsMessage/cleanups")?>" class="btn "><?=__("Users with cleanup times")?></a>
    </div>
</div>
<br />
<div class="row">
    <div class="span8">
        <h4><?=__("Users")?></h3>
        <a href="<?=$this->Wb->eventUrl("/SmsMessage/user")?>" class="btn "><?=__("User")?></a>
        <a href="<?=$this->Wb->eventUrl("/SmsMessage/users")?>" class="btn "><?=__("Specific users")?></a>
        <a href="<?=$this->Wb->eventUrl("/SmsMessage/mailinglist")?>" class="btn "><?=__("Mailinglist members")?></a>
    </div>
    <div class="span8">
        <h4><?=__("Users")?></h3>
        <a href="<?=$this->Wb->eventUrl("/SmsMessage/accreditationalerts")?>" class="btn "><?=__("All accreditations signed up for SMS")?></a>
        <a href="<?=$this->Wb->eventUrl("/SmsMessage/accreditation")?>" class="btn "><?=__("All accreditations")?></a>
    </div>
</div>
<br />
<div class="row">
    <div class="span8">
        <h4><?=__("Specific numbers")?></h3>
        <a href="<?=$this->Wb->eventUrl("/SmsMessage/numbers")?>" class="btn "><?=__("Phone numbers")?></a>
    </div>
</div>



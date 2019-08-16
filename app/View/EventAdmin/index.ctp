<form method="post">
<?=$this->Form->hidden('Event.id', array('value' => WB::$event->id))?>
<fieldset>
    <legend><?=__('Event')?></legend>

    <div class="clearfix <? if($this->Form->error('Event.name')) echo "error"; ?>">
        <label for="data[Event][name]"><?=__('Name')?></label>
        <div class="input">
            <?=$this->Form->input('Event.name', array('div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['name']))?>
            <span class="help-block"><?=$this->Form->error('Event.name')?></span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('Event.reference')) echo "error"; ?>">
        <label for="data[Event][reference]"><?=__('URL reference')?></label>
        <div class="input">
            <?=$this->Form->input('Event.reference', array('div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['reference']))?>
            <span class="help-block"><?=$this->Form->error('Event.reference')?></span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('Event.urlmode')) echo "error"; ?>">
        <label for="data[Event][urlmode]"><?=__('URL type')?></label>
        <div class="input">
            <?=$this->Form->select('Event.urltype', $urlmodes, array('div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['urlmode']))?>
            <span class="help-block"><?=$this->Form->error('Event.urlmode')?></span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('Event.email')) echo "error"; ?>">
        <label for="data[Event][email]"><?=__('Email')?></label>
        <div class="input">
            <?=$this->Form->input('Event.email', array('div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['email']))?>
            <span class="help-block"><?=$this->Form->error('Event.email')?></span>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend><?=__('Location')?></legend>

    <div class="clearfix <? if($this->Form->error('Event.locationname')) echo "error"; ?>">
        <label for="data[Event][locationname]"><?=__('Location')?></label>
        <div class="input">
            <?=$this->Form->input('Event.locationname', array('div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['locationname']))?>
            <span class="help-block"><?=$this->Form->error('Event.locationname')?></span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('Event.longitude')) echo "error"; ?>">
        <label for="data[Event][longitude]"><?=__('Longitude')?></label>
        <div class="input">
            <?=$this->Form->input('Event.longitude', array('div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['longitude']))?>
            <span class="help-block"><?=$this->Form->error('Event.longitude')?></span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('Event.latitude')) echo "error"; ?>">
        <label for="data[Event][latitude]"><?=__('Latitude')?></label>
        <div class="input">
            <?=$this->Form->input('Event.latitude', array('div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['latitude']))?>
            <span class="help-block"><?=$this->Form->error('Event.latitude')?></span>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend><?=__('When')?></legend>
    <div class="clearfix <? if($this->Form->error('Event.start')) echo "error"; ?>">
        <label for="data[Event][start]"><?=__("Start")?></label>
        <div class="input">
            <div class="inline-inputs">
                <?=$this->Form->day('Event.start', array('empty' => __("Day"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['start']))?>
                <?=$this->Form->month('Event.start', array('empty' => __("Month"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['start']))?>
                <?=$this->Form->year('Event.start', date('Y')-20, date('Y')+5, array('empty' => 'Year', 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['start']))?>
                <?=$this->Form->hour('Event.start', true, array('empty' => 'Hour', 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['start']))?>
                <?=$this->Form->minute('Event.start', array('empty' => __("Minute"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['start']))?>
            </div>
            <span class="help-block"><?=$this->Form->error('Event.start')?></span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('Event.end')) echo "error"; ?>">
        <label for="data[Event][end]"><?=__("End")?></label>
        <div class="input">
            <div class="inline-inputs">
                <?=$this->Form->day('Event.end', array('empty' => __("Day"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['end']))?>
                <?=$this->Form->month('Event.end', array('empty' => __("Month"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['end']))?>
                <?=$this->Form->year('Event.end', date('Y')-20, date('Y')+5, array('empty' => 'Year', 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['end']))?>
                <?=$this->Form->hour('Event.end', true, array('empty' => 'Hour', 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['end']))?>
                <?=$this->Form->minute('Event.end', array('empty' => __("Minute"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['end']))?>
            </div>
            <span class="help-block"><?=$this->Form->error('Event.end')?></span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('Event.show_time')) echo "error"; ?>">
        <label for="data[Event][show_time]"><?=__("Ordinary show time")?></label>
        <div class="input">
            <div class="inline-inputs">
                <?=$this->Form->day('Event.show_time', array('empty' => __("Day"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['show_time']))?>
                <?=$this->Form->month('Event.show_time', array('empty' => __("Month"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['show_time']))?>
                <?=$this->Form->year('Event.show_time', date('Y')-20, date('Y')+5, array('empty' => 'Year', 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['show_time']))?>
                <?=$this->Form->hour('Event.show_time', true, array('empty' => 'Hour', 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['show_time']))?>
                <?=$this->Form->minute('Event.show_time', array('empty' => __("Minute"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['Event']['show_time']))?>
            </div>
            <span class="help-block"><?=$this->Form->error('Event.show_time')?></span>
        </div>
    </div>
</fieldset>
<fieldset>
    <legend><?=__('Kandu membership')?></legend>
    <div class="clearfix <? if($this->Form->error('KanduMembershipSetting.expires')) echo "error"; ?>">
        <label for="data[KanduMembershipSetting][expires]"><?=__("Expires")?></label>
        <div class="input">
            <div class="inline-inputs">
                <?=$this->Form->day('KanduMembershipSetting.expires', array('empty' => __("Day"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $kandu['expires']))?>
                <?=$this->Form->month('KanduMembershipSetting.expires', array('empty' => __("Month"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $kandu['expires']))?>
                <?=$this->Form->year('KanduMembershipSetting.expires', date('Y')-20, date('Y')+5, array('empty' => 'Year', 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $kandu['expires']))?>
                <?=$this->Form->hour('KanduMembershipSetting.expires', true, array('empty' => 'Hour', 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $kandu['expires']))?>
                <?=$this->Form->minute('KanduMembershipSetting.expires', array('empty' => __("Minute"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $kandu['expires']))?>
            </div>
            <span class="help-block"><?=$this->Form->error('KanduMembershipSetting.expires')?></span>
        </div>
    </div>

    <div class="clearfix <? if($this->Form->error('KanduMembershipSetting.year')) echo "error"; ?>">
        <label for="data[Event][locationname]"><?=__('Membership year')?></label>
        <div class="input">
            <?=$this->Form->input('KanduMembershipSetting.year', array('div' => false, 'error' => false, 'label' => false, 'value' => $kandu['year']))?>
            <span class="help-block"><?=$this->Form->error('KanduMembershipSetting.year')?></span>
        </div>
    </div>
</fieldset>


<fieldset>
    <div class="input">
        <?=$this->Form->checkbox('KanduMembershipSetting.enabled', array('class' => 'span2', 'checked' => $kandu['enabled']))?> <?=__('Enable KANDU membership site')?><br />
        <?=$this->Form->checkbox('Event.hide', array('class' => 'span2', 'checked' => $data['Event']['hide']))?> <?=__('Hide event from listing')?><br />
        <?=$this->Form->checkbox('Event.disable', array('class' => 'span2', 'checked' => $data['Event']['disable']))?> <?=__('Disable event (only people with superuser can access the event)')?><br />
        <?=$this->Form->checkbox('Event.can_apply_for_crew', array('class' => 'span2', 'checked' => $data['Event']['can_apply_for_crew']))?> <?=__('Open for crew applications')?>
    </div>
</fieldset>
<div class="actions">
    <?=$this->Form->submit($savebutton, array('class' => 'btn success','name'=>'save'))?>
</div>
</form>


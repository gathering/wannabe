<form method="post">
<fieldset>
    <div class="clearfix">
        <label for="data[ShowupTime][approved]"><?=__("Status")?></label>
        <div class="input">
            <?php
            if($data['ShowupTime']['approved'] == 2)
                echo '<p class="green">'.__("Approved").'</p>';
            else if($data['ShowupTime']['approved'] == 1)
                echo '<p class="red">'.__("Declined").'</p>';
            else
                echo '<p class="yellow">'.__("Not set, or awaiting confirmation").'</p>';
            ?>
        </div>
        <div class="input">
            <p>In order to have control over who arrives when in the ship, all members must set a personal showup time.</p>
            <p>Ordinary arrival time is <?php echo $ordinary_show_time; ?>.</p>
            <p>Anyone who chooses a time outside of 16:00 and 19:00 will have to justify this and await approval from their Chief or Organizer. Only those who have special scheduled activities or long travel distances will get approved such showup time.</p>
            <p>Note that those who arrive early cannot expect to spend time in front of their own PCs. It is expected that you volunteer for work at all times except when your Chief doesn't have specific tasks for you.</p>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('ShowupTime.date') || $this->Form->error('ShowupTime.hour')) echo "error"; ?>">
        <label for="data[ShowupTime][time]"><?=__("Showup time")?></label>
        <div class="input">
            <div class="inline-inputs">
                <?=$this->Form->select('ShowupTime.date', $dates, array('empty' => __("Date"), 'class' => 'span3', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['ShowupTime']['date']))?>
                <?=$this->Form->hour('ShowupTime', true,  array('empty' => __("Hour"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['ShowupTime']['hour']))?>
            </div>
            <span class="help-block">
                <?php
                    if($this->Form->error('ShowupTime.date'))
                        echo $this->Form->error('ShowupTime.date');
                    else if($this->Form->error('ShowupTime.hour'))
                        echo $this->Form->error('ShowupTime.hour');
                ?>
            </span>
        </div>
    </div>
    <div class="clearfix <? if($this->Form->error('ShowupTime.comment')) echo "error"; ?>">
        <label for="data[ShowupTime][comment]"><?=__('Comment')?></label>
        <div class="input">
            <?=$this->Form->input('ShowupTime.comment', array('div' => false, 'error' => false, 'label' => false, 'value' => $data['ShowupTime']['comment']))?>
            <span class="help-block"><?=$this->Form->error('ShowupTime.Comment')?></span>
        </div>
    </div>
</fieldset>

<div class="actions">
    <?=$this->Form->submit(__("Save showup time"), array('class' => 'btn success','name'=>'save'))?>
</div>
</form>

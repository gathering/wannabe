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
            <p>For å ha kontroll på hvem som ankommer skipet når, må alle sette en personlig oppmøtetid!</p>
            <p>Ordinær oppmøtetid er: <?php echo $ordinary_show_time; ?>.</p>
            <p>Alle som velger tid utenom 16.00 til 19.00 vil måtte begrunne dette og avvente godkjenning fra sin Chief eller Organizer. Det er kun de som har spesielle avtalte gjøremål eller lang reisevei som får godkjent dette.</p>
            <p>Merk at de som kommer tidlig ikke kan regne med å bruke tid foran egen PC. Det forventes at du siller opp som frivillig all den tid din Chief ikke har konkrete oppgaver til deg.</p>
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

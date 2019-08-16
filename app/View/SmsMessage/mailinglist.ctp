<?php
$mailinglists = array_combine($mailinglists, $mailinglists);

?>

<form method="post">
<fieldset>
    <legend><?=__("Send SMS to mailinglist members")?></legend>
    <div class="clearfix">
        <label for="[SmsMessage][eid]"><?=__("Choose list")?></label>
        <div class="input">
            <?=$this->Form->select('SmsMessage.eid', $mailinglists, array())?>
        </div>
    </div>
    <div class="clearfix">
        <label for="[SmsMessage][content]"><?=__("Content")?></label>
        <div class="input">
            <?=$this->Form->textarea('SmsMessage.content', array())?>
        </div>
    </div>
    <div class="clearfix">
        <div class="input">
            <input type="text" id="charcounter">
        </div>
    </div>
    <div class="actions">
    <?=$this->Form->submit(__("Send"), array('class' => 'btn success','name'=>'save'))?><?if(isset($indexAccess)) { ?><a href="<?=$this->Wb->eventUrl('/SmsMessage')?>" class="btn"><?=__("Back")?></a><?php } ?>
    </div>
</fieldset>
</form>

<script type="text/javascript" language="JavaScript">
    var counter = document.getElementById("charcounter");
    var message = document.getElementById("SmsMessageContent");
    message.onkeydown = function(){
        var msgs = Math.floor((1+message.value.length)/160)+1;
        counter.value = (1+message.value.length)+" chars ("+msgs+" messages)";
    }
</script>



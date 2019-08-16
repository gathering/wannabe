<form method="POST" action="<?=$this->Wb->eventUrl('/Message/send/'.$hash)?>"> 
	<fieldset>
        <legend><?=$header?></legend>
        <div class="clearfix">
            <label for="data[from]"><?=__("From")?></label>
            <div class="input">
                <input type="text"  class="span6" id="data[from]" name="data[from]" rows="8" disabled="disabled" value="<?=$from['name']?> <<?=$from['email']?>>" />
            </div>
        </div>
        <div class="clearfix">
            <label for="data[Message][subject]"><?=__("Subject")?></label>
            <div class="input">
                <?php if(isset($subject)) { ?>
                <input type="text"  class="span6" id="data[Message][subject]" name="data[Message][subject]" rows="8" disabled="disabled" value="<?=$subject?>" />
                <?=$this->Form->hidden('Message.subject', array('value' => $subject))?>
                <?php } else { ?>
                    <input type="text"  class="span6" id="data[Message][subject]" name="data[Message][subject]" rows="8" />
                <?php } ?>
            </div>
        </div>
        <div class="clearfix">
            <label for="data[Message][message]"><?=__("Message")?></label>
            <div class="input">
                <textarea class="xxlarge" id="data[Message][message]" name="data[Message][message]" rows="8" autofocus></textarea>
                <span class="help-block">
                    <?=__("The message will be delivered by e-mail to the user.")?>
                </span>
            </div>
        </div>
        <div class="actions">
            <?=$this->Form->submit(__('Send'), array('name'=>'verify-send', 'class' => 'btn success', 'div' => false))?>
            <a href="<?=$was?>" class='btn danger' ><?=__("Cancel")?></a>
        </div>
        <?=$this->Form->hidden('Message.confirm_send', array('value' => $hash))?>
        <?=$this->Form->hidden('Message.to', array('value' => $to))?>
        <?=$this->Form->hidden('Message.from', array('value' => $from['id']))?>
        <?=$this->Form->hidden('Message.redirect', array('value' => $was))?>
	</fieldset>
</form>

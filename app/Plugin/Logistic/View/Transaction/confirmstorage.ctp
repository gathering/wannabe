<h4><?=__("This will result in the whole storage being checked out to the same person or crew, are you sure of this?")?></h4>
<dl class="dl-horizontal">
    <dt><?=__("ID")?></dt><dd><?=$transaction['LogisticTransaction']['logistic_storage_id']?></dd>
    <dt><?=__("Item")?></dt><dd><?=$storage['LogisticStorage']['name']?></dd>
    <dt><?=__("Status")?></dt><dd><?=$statuslist[4]?></dd>
    <?php if(isset($transaction['LogisticTransaction']['logistic_user_id']) and isset($user['User'])) { ?>
        <dt><?=__("User")?></dt><dd><?=$user['User']['realname']." (".$transaction['LogisticTransaction']['logistic_user_id'].")"?></dd>
    <?php } ?>

    <?php if(isset($transaction['LogisticTransaction']['logistic_crew_id']) and isset($crew['Crew'])) { ?>
        <dt><?=__("Crew")?></dt><dd><?=$crew['Crew']['name']." (".$transaction['LogisticTransaction']['logistic_crew_id'].")"?></dd>
    <?php } ?>

    <?php if(isset($transaction['LogisticTransaction']['logistic_received_user_id'])) { ?>
        <dt><?=__("Recipient")?></dt><dd><?=(isset($received_user['User']) ? $received_user['User']['realname'] : "")." (".$transaction['LogisticTransaction']['logistic_received_user_id'].")"?></dd>
    <?php } ?>
</dl>
<? echo $this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/applystorage')));?>

    <?php if(isset($transaction['LogisticTransaction']['logistic_user_id']) and isset($user['User'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_user_id', array('value' => $transaction['LogisticTransaction']['logistic_user_id']))?>
    <?php } ?>

    <?php if(isset($transaction['LogisticTransaction']['logistic_crew_id']) and isset($crew['Crew'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_crew_id', array('value' => $transaction['LogisticTransaction']['logistic_crew_id']))?>
    <?php } ?>

    <?php if(isset($transaction['LogisticTransaction']['logistic_received_user_id'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_received_user_id', array('value' => $transaction['LogisticTransaction']['logistic_received_user_id']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_storage_id'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_storage_id', array('value' => $transaction['LogisticTransaction']['logistic_storage_id']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['donedate'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.donedate', array('value' => $transaction['LogisticTransaction']['donedate']))?>
    <?php } ?>
    <?=$this->Form->hidden('Redirect.path', array('value' => $transaction['Redirect']['path']))?>
    <div class="actions"><?=$this->Form->submit(__("Confirm"), array('div' => false, 'class' => 'btn btn-success', 'name' => 'confirm'))?> <?=$this->Form->submit(__("Abort"), array('div' => false, 'class' => 'btn btn-danger', 'name' => 'abort'))?></div>
</form>

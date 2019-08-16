<h2><?=__("Confirm transaction")?></h2>
<h3><?=__("This will result in all copies being checked in, are you sure?")?></h3>
<ul class="unstyled">
    <li><?=__("ID").": ".$transaction['LogisticTransaction']['logistic_item_id']?></li>
    <li><?=__("Status").": ".$statuslist[$transaction['LogisticTransaction']['logistic_status_id']]?></li>
    <?php if(isset($transaction['LogisticTransaction']['logistic_user_id'])) { ?>
        <li><?=__("User").": ".$transaction['LogisticTransaction']['logistic_user_id']?></li>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_received_user_id'])) { ?>
        <li><?=__("Recipient").": ".$transaction['LogisticTransaction']['logistic_received_user_id']?></li>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['amount'])) { ?>
        <li><?=__("Amount").": ".$transaction['LogisticTransaction']['amount']?></li>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_storage_id'])) { ?>
        <li><?=__("Place").": ".$storagelist[$transaction['LogisticTransaction']['logistic_storage_id']]?></li>
    <?php } ?>
</ul>
<? echo $this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/applyall')));?>
    <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => $transaction['LogisticTransaction']['logistic_status_id']))?>
    <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $transaction['LogisticTransaction']['logistic_item_id']))?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_bulk_id'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_bulk_id', array('value' => $transaction['LogisticTransaction']['logistic_bulk_id']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_user_id'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_user_id', array('value' => $transaction['LogisticTransaction']['logistic_user_id']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_received_user_id'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_received_user_id', array('value' => $transaction['LogisticTransaction']['logistic_received_user_id']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['amount'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.amount', array('value' => $transaction['LogisticTransaction']['amount']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_storage_id'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_storage_id', array('value' => $transaction['LogisticTransaction']['logistic_storage_id']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['storage_comment'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.storage_comment', array('value' => $transaction['LogisticTransaction']['storage_comment']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['donedate'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.donedate', array('value' => $transaction['LogisticTransaction']['donedate']))?>
    <?php } ?>
    <?=$this->Form->hidden('Redirect.path', array('value' => $transaction['Redirect']['path']))?>
    <div class="actions"><?=$this->Form->submit(__("Confirm"), array('div' => false, 'class' => 'btn success', 'name' => 'confirm'))?> <?=$this->Form->submit(__("Abort"), array('div' => false, 'class' => 'btn danger', 'name' => 'abort'))?></div>
</form>

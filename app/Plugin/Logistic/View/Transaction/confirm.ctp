<h2><?=__("Confirm transaction")?></h2>
<dl>
    <dt><?=__("ID")?></dt><dd><?=$transaction['LogisticTransaction']['logistic_item_id']?></dd>
    <dt><?=__("Item")?></dt><dd><?=$item['LogisticItem']['name']?></dd>
    <dt><?=__("Status")?></dt><dd><?=$statuslist[$transaction['LogisticTransaction']['logistic_status_id']]?></dd>
    <?php if(isset($transaction['LogisticTransaction']['logistic_user_id'])) { ?>
        <dt><?=__("User")?></dt><dd><?=$user['User']['realname']." (".$transaction['LogisticTransaction']['logistic_user_id'].")"?></dd>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_hand_out_comment']) && !empty($transaction['LogisticTransaction']['logistic_hand_out_comment'])) { ?>
        <dt><?=__("Comment")?></dt><dd><?=$transaction['LogisticTransaction']['logistic_hand_out_comment']?></dd>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['storage_comment']) && !empty($transaction['LogisticTransaction']['storage_comment'])) { ?>
        <dt><?=__("Comment")?></dt><dd><?=$transaction['LogisticTransaction']['storage_comment']?></dd>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['amount'])) { ?>
        <dt><?=__("Amount")?></dt><dd><?=$transaction['LogisticTransaction']['amount']?></dd>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_storage_id'])) { ?>
        <dt><?=__("Place")?></dt>
        <dd>
            <?php if(isset($transaction['LogisticTransaction']['prev_logistic_storage_id'])) { ?>
                <?=__('From')?> <?=$storagelist[$transaction['LogisticTransaction']['prev_logistic_storage_id']]?> <?=__('to')?>
            <?php } ?>
            <?=$storagelist[$transaction['LogisticTransaction']['logistic_storage_id']]?>
        </dd>
    <?php } ?>

</dl>
<? echo $this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/apply')));?>
    <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => $transaction['LogisticTransaction']['logistic_status_id']))?>
    <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $transaction['LogisticTransaction']['logistic_item_id']))?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_bulk_id'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_bulk_id', array('value' => $transaction['LogisticTransaction']['logistic_bulk_id']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_user_id'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_user_id', array('value' => $transaction['LogisticTransaction']['logistic_user_id']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_hand_out_comment'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_hand_out_comment', array('value' => $transaction['LogisticTransaction']['logistic_hand_out_comment']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['amount'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.amount', array('value' => $transaction['LogisticTransaction']['amount']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['logistic_storage_id'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.logistic_storage_id', array('value' => $transaction['LogisticTransaction']['logistic_storage_id']))?>
    <?php } ?>
    <?php if(isset($transaction['LogisticTransaction']['prev_logistic_storage_id'])) { ?>
        <?=$this->Form->hidden('LogisticTransaction.prev_logistic_storage_id', array('value' => $transaction['LogisticTransaction']['prev_logistic_storage_id']))?>
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

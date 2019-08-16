<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<?php if($bulk['LogisticBulk']['deleted']): ?>
<?php 
    if($bulk['LogisticBulk']['type'] == 'bulk') $type = __("bulk");
    else $type = __("series");
?>
<div class="alert-message block-message error">
    <p><strong><?=__("Attention")?>: </strong><?=__("This %s has been deleted and cannot be used before it is reactivated.", $type)?></p>
    <div class="alert-actions">
        <?=$this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/confirmall')))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_bulk_id', array('value' => $bulk['LogisticBulk']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $items[0]['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => '9'))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Bulk/view/".$bulk['LogisticBulk']['id']))?>
            <?php if($bulk['LogisticBulk']['type'] == 'bulk'): ?>
                <?=$this->Form->input('LogisticTransaction.amount', array('label' => false, 'div' => false, 'class' => 'mini', 'placeholder' => __("Amount"))); ?>
            <?php endif; ?>
            <?=$this->Form->submit(__("Reactivate"), array('div' => false, 'class' => 'btn btn-primary'));?>
        </form>
    </div>
</div>
<?php endif; ?>
<?php if ($bulk['LogisticBulk']['type'] == 'bulk' && $bulk['LogisticBulk']['amountleft'] != $storage_amounts_sum) : ?>
    <div class="alert-message block-message error">
        <p>
            <strong><?=__("Attention")?>:</strong>
            <?=__("The amount left of this bulk does not equal the sum available for each storage location.")?>
            <strong><?=__("Contact Core:Systems (wannabe@gathering.org)!")?></strong>
        </p>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-3">
        <h4><?=__("Item details")?></h4>
        <?php if ($bulk['LogisticBulk']['description']): ?>
            <strong><?=__("Description")?></strong>
            <p><?=$bulk['LogisticBulk']['description']?></p>
        <?php endif; ?>
        <? if ($bulk['LogisticBulk']['type'] == 'bulk') { ?>
            <strong><?=__("AssetTag")?></strong>
            <p><?=$items[0]['LogisticItem']['AssetTag']?></p>
        <? } ?>
        <? if($bulk['LogisticSupplier']['company']) { ?>
            <strong><?=__("Owner")?></strong>
            <p>
                <?=$bulk['LogisticSupplier']['company']?>
                <?php if ($bulk['LogisticSupplier']['email']) { echo '('.$bulk['LogisticSupplier']['email'].')'; } ?>
            </p>
        <? } ?>
        <? if(isset($item['LogisticItem']['parent'])) { ?>
            <strong><?=__("Parent")?></strong>
            <p>
                <a href="<?=$this->Wb->eventUrl('/logistic/Item/view/'.$parent['LogisticItem']['id']);?>"><?=$parent['LogisticItem']['name']?>  </a>
            </p>
        <? }?>
        <? if(count($children) > 0) { ?>
            <strong><?=__("Children")?></strong>
            <?  foreach($children as $child){?> 
            <?      echo '<li># '.$child['LogisticItem']['id'].' <a href="'.$this->Wb->eventUrl('/logistic/Item/view/'.$child['LogisticItem']['id']).'">'.$child['LogisticItem']['name'].'</a></li>';?>
            <?  } ?>
        <?  } ?>
        <?php if(isset($items[0]) && isset($items[0]['LogisticTag']) && count($items[0]['LogisticTag']) > 0): ?>
            <strong><?=__("Tags")?></strong>
            <ul>
            <? foreach ($items[0]['LogisticTag'] as $tag)
            echo '<li>'.$this->Wb->eventLink($tag['name'], '/logistic/Search/filter/tag:'.$tag['id']).'</li>';?>
            </ul>
        <?php endif; ?>
        <?php if (isset($unrig_storage)): ?>
            <strong><?=__("Unrig destination")?></strong>
            <p>
                <?=$unrig_storage['LogisticStorage']['name']?>
            </p>
        <?php endif; ?>
        <? if ($bulk['LogisticBulk']['type'] == 'series') { ?>
            <strong><?=__("Amount")?></strong>
            <p><?=count($items)?></p>
        <? } ?>
    </div>
    <div class="col-md-9">
        <? if ($bulk['LogisticBulk']['type'] == 'bulk') { ?>
            <h4><?=__("Amounts available in storage")?></h4>
            <table class="table table-bordered">
                <tbody>
                    <?php foreach ($storagelist as $storage_id => $storage_name) { ?>
                        <?php if (isset($storage_amounts[$storage_id])) { ?>
                            <tr>
                                <td><?=$this->Wb->eventLink($storage_name, '/logistic/Search/filter/storage:'.$storage_id)?></td>
                                <td class="number-column"><?=$storage_amounts[$storage_id]?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <tr>
                        <td><strong><?=__('Total amount in storage')?></strong></td>
                        <td class="number-column"><strong><?=$bulk['LogisticBulk']['amountleft']?></strong></td>
                    </tr>
                    <tr>
                        <td class="divider-row"><?=__('Total amount not in storage')?></td>
                        <td class="divider-row number-column"><?=($bulk['LogisticBulk']['amount'] - $bulk['LogisticBulk']['amountleft'])?></td>
                    </tr>
                    <tr>
                        <td><strong><?=__('Total amount registered in system')?></strong></td>
                        <td class="number-column"><strong><?=$bulk['LogisticBulk']['amount']?></strong></td>
                    </tr>
                </tbody>
            </table>
        <? } else { ?>
            <h4><?=__("Overview")?></h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?=__("AssetTag")?></th>
                        <th><?=__("Status")?></th>
                        <th><?=__("Condition")?></th>
                        <th><?=__("Place")?></th>
                        <th><?=__("User/Crew")?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) {  ?>
                        <tr>
                            <td><?=$this->Wb->eventLink($item['LogisticItem']['AssetTag'], '/logistic/Item/view/'.$item['LogisticItem']['id'])?></td>
                            <td><?=$status[$item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] - 1]['LogisticStatus']['canonicalname']?></td>
                            <td><?=$condition_captions[$item['LogisticItem']['condition']]?></td>
                            <td><?=$this->Wb->eventLink($item['LogisticTransaction'][0]['LogisticStorage']['name'].($item['LogisticTransaction'][0]['LogisticTransaction']['storage_comment']?" (".$item['LogisticTransaction'][0]['LogisticTransaction']['storage_comment'].")":''), '/logistic/Search/filter/storage:'.$item['LogisticTransaction'][0]['LogisticStorage']['id'])?></td>

                            <?php
                            $transaction = $item['LogisticTransaction'][0];
                            if($transaction['User']['id'] != NULL) { ?>
                                <td><?=$this->Wb->eventLink($this->Wb->userDisplayName($transaction), '/logistic/Search/filter/user:'.$transaction['User']['id'])?></td>
                            <?php } elseif($transaction['Crew']['id']) { ?>
                                <td><?=$this->Wb->eventLink($transaction['Crew']['name'], '/logistic/Search/filter/crew:'.$transaction['Crew']['id'])?> </td>
                            <?php } else {
                                echo "<td> </td>";
                            } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <? } ?>
    </div>
</div>
<?php if(isset($items[0])): ?>
<hr />
<? if ($bulk['LogisticBulk']['type'] == 'bulk') { ?>
    <div class="row">
        <div class="col-md-12 log-history">
            <h4><?=__("Bulk history")?> <small><a href="#" id="log-toggle-history"><?=__("Toggle last/all")?></a></small></h4>
            <table class="table table-bordered"">
                <thead>
                    <tr>
                        <th><?=__("Amount")?></th>
                        <th><?=__("Timestamp")?></th>
                        <th><?=__("Status")?></th>
                        <th><?=__("Done by")?></th>
                        <th><?=__("Place")?></th>
                        <th><?=__("User/Crew")?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) {
                          foreach ($item['LogisticTransaction'] as $transaction) { ?>
                        <tr <?=isset($transaction['LogisticTransaction']['deleted'])?'style="text-decoration: line-through;"':''?>>
                            <td><?=$transaction['LogisticTransaction']['amount']?></td>
                            <td><?=$transaction['LogisticTransaction']['created']?></td>
                            <td><?=$status[$transaction['LogisticTransaction']['logistic_status_id'] - 1]['LogisticStatus']['canonicalname']?></td>
                            <td><?=$this->Wb->userLink(array('User' => $transaction['DoneBy']))?></td>
                            <td>
                                <?php $prev_logistic_storage_id = $transaction['LogisticTransaction']['prev_logistic_storage_id']; ?>
                                <?php if ($prev_logistic_storage_id) : ?>
                                    <?=__('From')?> <?=$this->Wb->eventLink($storagelist[$prev_logistic_storage_id], '/logistic/Search/filter/storage:'.$prev_logistic_storage_id)?>
                                    <br /> <?=__('to')?>
                                <?php endif; ?>
                                <?=$this->Wb->eventLink($transaction['LogisticStorage']['name'].($transaction['LogisticTransaction']['storage_comment']?" (".$transaction['LogisticTransaction']['storage_comment'].")":''), '/logistic/Search/filter/storage:'.$transaction['LogisticStorage']['id'])?>
                            </td>
                            <td><?=$this->Wb->eventLink($this->Wb->userDisplayName($transaction), '/logistic/Search/filter/user:'.$transaction['User']['id'])?></td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
<hr />
<? } ?>
<? if($bulk['LogisticBulk']['type'] == 'series' && ($item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 1 || $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 3 ||
$item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 5 || $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 9)) { ?>
<div class="row">
    <div class="col-md-3">
    <h4><?=_("Hand out the whole series")?></h4>
    <?=$this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/confirmall')))?>
        <fieldset>
            <?=$this->Form->hidden('LogisticTransaction.logistic_bulk_id', array('value' => $item['LogisticItem']['logistic_bulk_id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => '4'))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Bulk/view/".$bulk['LogisticBulk']['id']))?>

            <div class="col-md-12">
                <label for="data[LogisticTransaction][logistic_hand_out_comment]"><?=__("Comment (optional)")?></label>
                <div class="input">
                    <?=$this->Form->text('LogisticTransaction.logistic_hand_out_comment', array('label' => false, 'div' => false, 'class' => 'form-control')); ?>
                </div>
            </div>

            <div class="col-md-12">
                <label for="data[LogisticTransaction][logistic_user_id]"><?=__("User")?></label>
                <div class="input">
                    <?=$this->Form->text('LogisticTransaction.logistic_user_id', array('label' => false, 'div' => false, 'class' => 'form-control'))?> <br> <?=$this->Form->submit(__("Perform"), array('div' => false, 'class' => 'btn btn-primary'));?>
                </div>
            </div>

        </fieldset>
    </form>
    </div>
</div>
<? } ?>
<? if($bulk['LogisticBulk']['type'] == 'series' && ($item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 4)) { ?>
    <h4><?=_("Check in the whole series")?></h4>
    <?=$this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/confirmall')))?>
        <fieldset>
            <?=$this->Form->hidden('LogisticTransaction.logistic_bulk_id', array('value' => $item['LogisticItem']['logistic_bulk_id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => '5'))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Bulk/view/".$bulk['LogisticBulk']['id']))?>
            <div class="clearfix">
                <label for="data[LogisticTransaction][logistic_storage_id]"><?=__("Storage")?></label>
                <div class="input">
                    <?=$this->Form->select('LogisticTransaction.logistic_storage_id', $storagelist, array('label' => false, 'div' => false, 'empty' => __("Choose")))?>
                </div>
            </div>
            <div class="clearfix">
                <label for="data[LogisticTransaction][storage_comment]"><?=__("Comment")?></label>
                <div class="input">
                    <?=$this->Form->input('LogisticTransaction.storage_comment', array('label' => false, 'div' => false))?> <?=$this->Form->submit(__("Perform"), array('div' => false, 'class' => 'btn btn-primary'));?>
                </div>
            </div>
        </fieldset>
    </form>
<? } ?>
<? if ($bulk['LogisticBulk']['type'] == 'bulk') { ?>
<? foreach ($items as $item) { ?>
<? if($bulk['LogisticBulk']['amountleft'] != 0) { ?>
    <h4><?=_("Hand out")?></h4>
    <p>
        <?=__('Use express checkout to hand out items:')?>
        <a class="btn btn-primary" href="<?=$this->Wb->eventUrl('/Logistic/Express/checkout')?>#<?=$item['LogisticItem']['AssetTag']?>"><?=__('Express Checkout')?></a>
    </p>
<? } ?>
<? if(
        $bulk['LogisticBulk']['amount'] && 
        (
            $bulk['LogisticBulk']['amount'] != $bulk['LogisticBulk']['amountleft']
        ) && (
            $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] != 6 && 
            $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] != 8 || 
            $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 9
        )
    ) { ?>
    <h4><?=_("Checkin")?></h4>
    <p>
        <?=__('Use express checkin to check in items:')?>
        <a class="btn btn-primary" href="<?=$this->Wb->eventUrl('/Logistic/Express/checkin')?>#<?=$item['LogisticItem']['AssetTag']?>"><?=__('Express Checkin')?></a>
    </p>
<? } ?>

    <h4><?=__("Move")?></h4>
    <?=$this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/confirm')));?>
        <fieldset>
            <?=$this->Form->hidden('LogisticTransaction.logistic_bulk_id', array('value' => $item['LogisticItem']['logistic_bulk_id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => '7'))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Bulk/view/".$bulk['LogisticBulk']['id']))?>
            <div class="clearfix">
                <label for="data[LogisticTransaction][amount]"><?=__("Amount")?></label>
                <div class="input">
                    <?=$this->Form->input('LogisticTransaction.amount', array('label' => false, 'div' => false)); ?>
                </div>
            </div>
            <div class="clearfix">
                <label for="data[LogisticTransaction][prev_logistic_storage_id]"><?=__("From storage")?></label>
                <div class="input">
                    <?=$this->Form->select('LogisticTransaction.prev_logistic_storage_id', $storagelist, array('label' => false, 'div' => false, 'empty' => __("Choose")))?>
                </div>
            </div>
            <div class="clearfix">
                <label for="data[LogisticTransaction][logistic_storage_id]"><?=__("To storage")?></label>
                <div class="input">
                    <?=$this->Form->select('LogisticTransaction.logistic_storage_id', $storagelist, array('label' => false, 'div' => false, 'empty' => __("Choose")))?>
                </div>
            </div>
            <div class="clearfix">
                <label for="data[LogisticTransaction][storage_comment]"><?=__("Comment")?></label>
                <div class="input">
                    <?=$this->Form->input('LogisticTransaction.storage_comment', array('label' => false, 'div' => false))?> <?=$this->Form->submit(__("Perform"), array('div' => false, 'class' => 'btn btn-primary'));?>
                </div>
            </div>
        </fieldset>
    </form>
<? } ?>
<? if(
        (
            $bulk['LogisticBulk']['amount']
        ) && (
            $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 1 ||
            $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 2 ||
            $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 9
        )
    ) { ?>
    <h4><?=__("Place in stock")?></h4>
    <?=$this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/confirm')));?>
        <fieldset>
            <?=$this->Form->hidden('LogisticTransaction.logistic_bulk_id', array('value' => $item['LogisticItem']['logistic_bulk_id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => false))?>
            <?=$this->Form->hidden('LogisticTransaction.amount', array('value' => $bulk['LogisticBulk']['amount']))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Bulk/view/".$bulk['LogisticBulk']['id']))?>
            <div class="clearfix">
                <label for="data[LogisticTransaction][logistic_storage_id]"><?=__("Storage")?></label>
                <div class="input">
                    <?=$this->Form->select('LogisticTransaction.logistic_storage_id', $storagelist, array('label' => false, 'div' => false, 'empty' => __("Choose")))?>
                </div>
            </div>
            <div class="clearfix">
                <label for="data[LogisticTransaction][storage_comment]"><?=__("Comment")?></label>
                <div class="input">
                    <?=$this->Form->input('LogisticTransaction.storage_comment', array('label' => false, 'div' => false))?> <?=$this->Form->submit(__("Perform"), array('div' => false, 'class' => 'btn btn-primary'));?>
                </div>
            </div>
        </fieldset>
    </form>
<? } ?>
<? if($item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 1) { ?>
    <h4><?=__("Set in transit")?></h4>
    <?=$this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/confirm')));?>
        <fieldset>
            <?=$this->Form->hidden('LogisticTransaction.logistic_bulk_id', array('value' => $item['LogisticItem']['logistic_bulk_id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => '2'))?>
            <?=$this->Form->hidden('LogisticTransaction.amount', array('value' => $bulk['LogisticBulk']['amount']))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Bulk/view/".$bulk['LogisticBulk']['id']))?>
            <div class="clearfix">
                <label for="data[LogisticTransaction][donedate]"><?=__("Expected delivered")?></label>
                <div class="input">
                    <?=$this->Form->dateTime('LogisticTransaction.donedate', 'DMY', '24',array('interval' => '10', 'label' => false, 'div' => false, 'class' => 'col-md-1'))?> <?=$this->Form->submit(__("Perform"), array('class' => 'btn btn-primary', 'div' => false));?>
                </div>
            </div>
        </fieldset>
    </form>
<? } ?>
<? } ?>

<? if($item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] != 8) { ?>
<div class="row">
    <h4><?=_("Remove")?></h4>
    <div class="col-md-12">
    <?=$this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/confirmall')))?>
        <fieldset>
            <?=$this->Form->hidden('LogisticTransaction.logistic_bulk_id', array('value' => $item['LogisticItem']['logistic_bulk_id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => '8'))?>
            <?php if ($bulk['LogisticBulk']['type'] == 'bulk'): ?>
                <?=$this->Form->hidden('LogisticTransaction.amount', array('value' => $bulk['LogisticBulk']['amount']))?>
            <?php endif; ?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Bulk/view/".$bulk['LogisticBulk']['id']))?>
            <div class="clearfix">
                <div class="input">
                    <?=$this->Form->submit(__("Remove"), array('div' => false, 'class' => 'btn btn-danger'));?>
                </div>
            </div>
        </fieldset>
    </form>
    </div>
</div>
<? } ?>

<?php endif; ?>

<?php $this->Html->scriptStart( array('block' => 'bottom')); ?>
    $(document).ready(function() {
        $('#log-toggle-history').html("Show all");
        $('.log-history table tr').toggle();
        $('.log-history table tr:first-child').show();  
        $('#log-toggle-history').click(function() {
            $('.log-history table tr').toggle();
            $('.log-history table tr:first-child').show();  
            if($('#log-toggle-history').html() == 'Show all') {
                $('#log-toggle-history').html("Hide all");
            } else {
                $('#log-toggle-history').html("Show all");
            }
        });
    });
<?php $this->Html->scriptEnd(); ?>